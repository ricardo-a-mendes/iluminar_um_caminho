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

            echo $result->getCode();

        } catch (\Exception $e) {
            echo $e->getMessage();
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
}
