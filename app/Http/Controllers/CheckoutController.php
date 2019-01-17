<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckOutRequest;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PagSeguro\Parsers\Session\Response;

class CheckoutController extends Controller
{

    /**
     * Pag Seguro Account Email
     *
     * @var string
     */
    private $accountEmail = '';

    public function __construct()
    {
        $this->accountEmail = env('PAG_SEGURO_ACCOUNT_EMAIL');
    }

    /**
     * Displays checkout view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        try {

            if (Auth::user()->registration_completed == 0) {
//
                session()->flash('warning', 'Precisamos que você finalize o seu cadastro para fazer a doação.');
                return redirect()->route('user.edit', ['id' => Auth::id()]);
            }

            $error = '';
            $session = $this->initializePagSeguro();
            $campaign = Campaign::find($id);

        } catch (\Exception $e) {

            $error = $e->getMessage();
        }

        return view('checkout', compact('campaign', 'error', 'session'));
    }

    /**
     * Executes the checkout - Integration with PagSeguro
     *
     * @param CheckOutRequest $request
     */
    public function process(CheckOutRequest $request)
    {
        try {
            $ccToken = $request->post('creditCardToken');
            $campaignId = $request->post('campaign_id');
            $campaignName = $request->post('campaign_name');

            /** @var User $user */
            $user = Auth::user();

            $this->initializePagSeguro();
            $donationAmount = str_replace('.', '', $request->post('donationAmount'));
            $donationAmount = str_replace(',', '.', $donationAmount);
            $donationAmount = number_format($donationAmount, 2, '.',  '');

            //Configurando Cartao de Credito
            $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();

            //Especifica o e-mail que vai receber o pagamento
            $creditCard->setReceiverEmail($this->accountEmail);

            //Nosso ID
            $creditCard->setReference($campaignId);

            //Moeda
            $creditCard->setCurrency("BRL");

            //Adicionando Itens
            $creditCard->addItems()->withParameters(
                '1', // texto livre, com limite de 100 caracteres.
                $campaignName, //Descricao: texto livre, com limite de 100 caracteres.
                1, //Quantidade: Um número inteiro maior ou igual a 1 e menor ou igual a 999
                $donationAmount // Valor: Decimal, com duas casas decimais separadas por ponto
            );

            $senderEmail = $user->email;
            if (env('PAG_SEGURO_ENVIRONMENT', 'sandbox') == 'sandbox') {
                $senderEmail = 'c05883669321348108367@sandbox.pagseguro.com.br';
            }

            $plainPhone = preg_replace('/\D/', '', $user->phone_number);

            //Comprador
            $creditCard->setSender()->setName($user->name);
            $creditCard->setSender()->setEmail($senderEmail);
            $creditCard->setSender()->setPhone()->withParameters($user->area_code, $plainPhone);
            $creditCard->setSender()->setDocument()->withParameters('CPF', $user->cpf);
            $creditCard->setSender()->setIp($request->ip());


            //Entrega
            $creditCard->setShipping()->setAddress()->withParameters(
                $user->street_name,
                $user->street_number,
                $user->district,
                str_replace('-', '', $user->postal_code),
                $user->city,
                $user->state,
                'BRA',
                $user->complement
            );

            //Cobrança
            $creditCard->setBilling()->setAddress()->withParameters(
                $user->street_name,
                $user->street_number,
                $user->district,
                str_replace('-', '', $user->postal_code),
                $user->city,
                $user->state,
                'BRA',
                $user->complement
            );

            //Dados do cartao
            $creditCard->setToken($ccToken);
            $creditCard->setInstallment()->withParameters(1, $donationAmount);
            $creditCard->setHolder()->setName($request->post('creditCardHolderName'));
            $creditCard->setHolder()->setDocument()->withParameters('CPF', $request->post('creditCardHolderCPF'));
            $creditCard->setMode('DEFAULT');

            $appRUL = env('APP_URL');
            $creditCard->setNotificationUrl("{$appRUL}/notify");

            $credential = \PagSeguro\Configuration\Configure::getAccountCredentials();

            /** @var \PagSeguro\Parsers\Transaction\CreditCard\Response $result */
            $result = $creditCard->register($credential);

            return \response($result->getCode());

        } catch (\Exception $e) {
            $responseXML = simplexml_load_string($e->getMessage());
            $errorCode = (string) $responseXML->xpath('error/code')[0];
            $errorMessage = $this->getErrorMessageByCode($errorCode);

            return \response($errorMessage, 409);
        }
    }

    /**
     * Get Pag Seguro Session
     *
     * @return mixed
     * @throws \Exception
     */
    private function initializePagSeguro()
    {
        $environment = env('PAG_SEGURO_ENVIRONMENT');
        $accountToken = env('PAG_SEGURO_ACCOUNT_TOKEN');

        \PagSeguro\Library::initialize();

        \PagSeguro\Configuration\Configure::setEnvironment($environment);//production or sandbox
        \PagSeguro\Configuration\Configure::setCharset('UTF-8');
        \PagSeguro\Configuration\Configure::setAccountCredentials($this->accountEmail, $accountToken);

        /** @var Response $response */
        $response = \PagSeguro\Services\Session::create(
            \PagSeguro\Configuration\Configure::getAccountCredentials()
        );

        return $response->getResult();
    }

    /**
     * Handle notifications
     *
     * @param Request $request
     * @throws \Exception
     */
    public function notifications(Request $request)
    {
//        Log::debug($request->post('notificationCode'));
        try {
            $this->initializePagSeguro();
            $credential = \PagSeguro\Configuration\Configure::getAccountCredentials();
            if (\PagSeguro\Helpers\Xhr::hasPost()) {

                /** @var \PagSeguro\Parsers\Transaction\Response $response */
                $response = \PagSeguro\Services\Transactions\Notification::check(
                /** @var \PagSeguro\Domains\AccountCredentials | \PagSeguro\Domains\ApplicationCredentials $credential */
                    $credential
                );

                if (is_object($response)) {

                    $where = [
                        ['campaign_id', '=', $response->getReference()],
                        ['transaction_token', '=', $response->getCode()]
                    ];

                    $donation = Donation::where($where)->first();

                    /** @var \PagSeguro\Domains\CreditorFees $d */
                    $d = $response->getCreditorFees();

                    if ($donation instanceof Donation) {
                        $donation->intermediation_fee = $d->getIntermediationFeeAmount();
                        $donation->intermediation_rate = $d->getIntermediationRateAmount();
                        $donation->received_amount = $response->getNetAmount();
                        $donation->updated_at = date('Y-m-d H:i:s');
                        $donation->updated_by = 0;

                        $donation->save();
                    }

//                    Log::debug('-- --------------------------------');
//                    Log::debug('Net: ' . $response->getNetAmount());
//                    Log::debug('Gross: ' . $response->getGrossAmount());
//                    Log::debug('Ref: ' . $response->getReference());
//                    Log::debug('code: ' . $response->getCode());
//                    Log::debug('Taxa Cartao: ' . ($d->getIntermediationFeeAmount()));
//                    Log::debug('Taxa Pag Seguro: ' . ($d->getIntermediationRateAmount()));
                } else {
                    throw new \Exception('Pag seguro enviou response inesperado na notificação');
                }
            } else {
                throw new \InvalidArgumentException($_POST);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            die($e->getMessage());
        }
    }

    /**
     * Thanks page - Redirect after donation
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function thanks()
    {
        return view('thanks');
    }

    private function getErrorMessageByCode($errorCode)
    {
        $errorMessage = 'Erro desconhecido: ' . $errorCode;
        switch($errorCode)
        {
            case "5003": $errorMessage = "Falha de comunicação com a instituição financeira"; break;
            case "10000": $errorMessage = "Marca de cartão de crédito inválida"; break;
            case "10001": $errorMessage = "Número do cartão de crédito com comprimento inválido"; break;
            case "10002": $errorMessage = "Formato da data inválida"; break;
            case "10003": $errorMessage = "Campo de segurança CVV inválido"; break;
            case "10004": $errorMessage = "Código de verificação CVV é obrigatório"; break;
            case "10006": $errorMessage = "Campo de segurança com comprimento inválido"; break;
            case "53004": $errorMessage = "Quantidade inválida de itens"; break;
            case "53005": $errorMessage = "É necessário informar a moeda"; break;
            case "53006": $errorMessage = "Valor inválido para especificação da moeda"; break;
            case "53007": $errorMessage = "Referência inválida comprimento: {0}"; break;
            case "53008": $errorMessage = "URL de notificação inválida"; break;
            case "53009": $errorMessage = "URL de notificação com valor inválido"; break;
            case "53010": $errorMessage = "O e-mail do remetente é obrigatório"; break;
            case "53011": $errorMessage = "Email do remetente com comprimento inválido"; break;
            case "53012": $errorMessage = "Email do remetente está com valor inválido"; break;
            case "53013": $errorMessage = "O nome do remetente é obrigatório"; break;
            case "53014": $errorMessage = "Nome do remetente está com comprimento inválido"; break;
            case "53015": $errorMessage = "Nome do remetente está com valor inválido"; break;
            case "53017": $errorMessage = "Foi detectado algum erro nos dados do seu CPF"; break;
            case "53018": $errorMessage = "O código de área do remetente é obrigatório"; break;
            case "53019": $errorMessage = "Há um conflito com o código de área informado, em relação a outros dados seus"; break;
            case "53020": $errorMessage = "É necessário um telefone do remetente"; break;
            case "53021": $errorMessage = "Valor inválido do telefone do remetente"; break;
            case "53022": $errorMessage = "É necessário o código postal do endereço de entrega"; break;
            case "53023": $errorMessage = "Código postal está com valor inválido"; break;
            case "53024": $errorMessage = "O endereço de entrega é obrigatório"; break;
            case "53025": $errorMessage = "Endereço de entrega rua comprimento inválido: {0}"; break;
            case "53026": $errorMessage = "É necessário o número de endereço de entrega"; break;
            case "53027": $errorMessage = "Número de endereço de remessa está com comprimento inválido"; break;
            case "53028": $errorMessage = "No endereço de entrega há um comprimento inválido"; break;
            case "53029": $errorMessage = "O endereço de entrega é obrigatório"; break;
            case "53030": $errorMessage = "Endereço de entrega está com o distrito em comprimento inválido"; break;
            case "53031": $errorMessage = "É obrigatório descrever a cidade no endereço de entrega"; break;
            case "53032": $errorMessage = "O endereço de envio está com um comprimento inválido da cidade"; break;
            case "53033": $errorMessage = "É necessário descrever o Estado, no endereço de remessa"; break;
            case "53034": $errorMessage = "Endereço de envio está com valor inválido"; break;
            case "53035": $errorMessage = "O endereço do remetente é obrigatório"; break;
            case "53036": $errorMessage = "O endereço de envio está com o país em um comprimento inválido"; break;
            case "53037": $errorMessage = "O token do cartão de crédito é necessário"; break;
            case "53038": $errorMessage = "A quantidade da parcela é necessária"; break;
            case "53039": $errorMessage = "Quantidade inválida no valor da parcela"; break;
            case "53040": $errorMessage = "O valor da parcela é obrigatório."; break;
            case "53041": $errorMessage = "Conteúdo inválido no valor da parcela"; break;
            case "53042": $errorMessage = "O nome do titular do cartão de crédito é obrigatório"; break;
            case "53043": $errorMessage = "Nome do titular do cartão de crédito está com o comprimento inválido"; break;
            case "53044": $errorMessage = "O nome informado no formulário do cartão de Crédito precisa ser escrito exatamente da mesma forma que consta no seu cartão obedecendo inclusive, abreviaturas e grafia errada"; break;
            case "53045": $errorMessage = "O CPF do titular do cartão de crédito é obrigatório"; break;
            case "53046": $errorMessage = "O CPF do titular do cartão de crédito está com valor inválido"; break;
            case "53047": $errorMessage = "A data de nascimento do titular do cartão de crédito é necessária"; break;
            case "53048": $errorMessage = "TA data de nascimento do itular do cartão de crédito está com valor inválido"; break;
            case "53049": $errorMessage = "O código de área do titular do cartão de crédito é obrigatório"; break;
            case "53050": $errorMessage = "Código de área de suporte do cartão de crédito está com valor inválido"; break;
            case "53051": $errorMessage = "O telefone do titular do cartão de crédito é obrigatório"; break;
            case "53052": $errorMessage = "O número de Telefone do titular do cartão de crédito está com valor inválido"; break;
            case "53053": $errorMessage = "É necessário o código postal do endereço de cobrança"; break;
            case "53054": $errorMessage = "O código postal do endereço de cobrança está com valor inválido"; break;
            case "53055": $errorMessage = "O endereço de cobrança é obrigatório"; break;
            case "53056": $errorMessage = "A rua, no endereço de cobrança está com comprimento inválido"; break;
            case "53057": $errorMessage = "É necessário o número no endereço de cobrança"; break;
            case "53058": $errorMessage = "Número do endereço de cobrança está com comprimento inválido"; break;
            case "53059": $errorMessage = "Endereço de cobrança complementar está com comprimento inválido"; break;
            case "53060": $errorMessage = "O endereço de cobrança é obrigatório"; break;
            case "53061": $errorMessage = "O endereço de cobrança está com tamanho inválido"; break;
            case "53062": $errorMessage = "É necessário informar a cidade no endereço de cobrança"; break;
            case "53063": $errorMessage = "O item Cidade, está com o comprimento inválido no endereço de cobrança"; break;
            case "53064": $errorMessage = "O estado, no endereço de cobrança é obrigatório"; break;
            case "53065": $errorMessage = "No endereço de cobrança, o estado está com algum valor inválido"; break;
            case "53066": $errorMessage = "O endereço de cobrança do país é obrigatório"; break;
            case "53067": $errorMessage = "No endereço de cobrança, o país está com um comprimento inválido"; break;
            case "53068": $errorMessage = "O email do destinatário está com tamanho inválido"; break;
            case "53069": $errorMessage = "Valor inválido do e-mail do destinatário"; break;
            case "53070": $errorMessage = "A identificação do item é necessária"; break;
            case "53071": $errorMessage = "O ID do item está inválido"; break;
            case "53072": $errorMessage = "A descrição do item é necessária"; break;
            case "53073": $errorMessage = "Descrição do item está com um comprimento inválido"; break;
            case "53074": $errorMessage = "É necessária quantidade do item"; break;
            case "53075": $errorMessage = "Quantidade do item está irregular"; break;
            case "53076": $errorMessage = "Há um valor inválido na quantidade do item"; break;
            case "53077": $errorMessage = "O valor do item é necessário"; break;
            case "53078": $errorMessage = "O Padrão do valor do item está inválido"; break;
            case "53079": $errorMessage = "Valor do item está irregular"; break;
            case "53081": $errorMessage = "O remetente está relacionado ao receptor! Esse é um erro comum que só o lojista pode cometer ao testar como compras. O erro surge quando uma compra é realizada com os mesmos dados cadastrados para receber os pagamentos da loja ou com um e-mail que é administrador da loja"; break;
            case "53084": $errorMessage = "Receptor inválido! Esse erro decorre de quando o lojista usa dados relacionados com uma loja ou um conta do PagSeguro, como e-mail principal da loja ou o e-mail de acesso à sua conta não PagSeguro"; break;
            case "53085": $errorMessage = "Método de pagamento indisponível"; break;
            case "53086": $errorMessage = "A quantidade total do carrinho está inválida"; break;
            case "53087": $errorMessage = "Dados inválidos do cartão de crédito"; break;
            case "53091": $errorMessage = "O Hash do remetente está inválido"; break;
            case "53092": $errorMessage = "A Bandeira do cartão de crédito não é aceita"; break;
            case "53095": $errorMessage = "Tipo de transporte está com padrão inválido"; break;
            case "53096": $errorMessage = "Padrão inválido no custo de transporte"; break;
            case "53097": $errorMessage = "Custo de envio irregular"; break;
            case "53098": $errorMessage = "O valor total do carrinho não pode ser negativo"; break;
            case "53099": $errorMessage = "Montante extra inválido"; break;
            case "53101": $errorMessage = "Valor inválido do modo de pagamento. O correto seria algo do tipo default e gateway"; break;
            case "53102": $errorMessage = "Valor inválido do método de pagamento. O correto seria algo do tipo Credicard, Boleto, etc."; break;
            case "53104": $errorMessage = "O custo de envio foi fornecido, então o endereço de envio deve estar completo"; break;
            case "53105": $errorMessage = "As informações do remetente foram fornecidas, portanto o e-mail também deve ser informado"; break;
            case "53106": $errorMessage = "O titular do cartão de crédito está incompleto"; break;
            case "53109": $errorMessage = "As informações do endereço de remessa foram fornecidas, portanto o e-mail do remetente também deve ser informado"; break;
            case "53110": $errorMessage = "Banco EFT é obrigatório"; break;
            case "53111": $errorMessage = "Banco EFT não é aceito"; break;
            case "53115": $errorMessage = "Valor inválido da data de nascimento do remetente"; break;
            case "53117": $errorMessage = "Valor inválido do cnpj do remetente"; break;
            case "53122": $errorMessage = "O domínio do email do comprador está inválido. Você deve usar algo do tipo nome@dominio.com.br"; break;
            case "53140": $errorMessage = "Quantidade de parcelas fora do limite. O valor deve ser maior que zero"; break;
            case "53141": $errorMessage = "Este remetente está bloqueado"; break;
            case "53142": $errorMessage = "O cartão de crédito está com o token inválido"; break;
        }
        return $errorMessage;
    }
}
