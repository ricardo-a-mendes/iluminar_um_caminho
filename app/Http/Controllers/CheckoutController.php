<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckOutRequest;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PagSeguro\Parsers\Session\Response;

class CheckoutController extends Controller
{

    private $accountEmail = 'eng.rmendes@gmail.com';

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

    public function process(CheckOutRequest $request)
    {
        try {
            $ccToken = $request->post('creditCardToken');
            $campaignId = $request->post('campaign_id');
            $campaignName = $request->post('campaign_name');
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
            if (env('APP_ENV') == 'dev') {
                $senderEmail = 'c05883669321348108367@sandbox.pagseguro.com.br';
            }

            //Comprador
            $creditCard->setSender()->setName($user->name);
            $creditCard->setSender()->setEmail($senderEmail);
            $creditCard->setSender()->setPhone()->withParameters($user->area_code, $user->phone_number);
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

            $creditCard->setNotificationUrl('https://b2e48ddd.ngrok.io/notify');

            $credential = \PagSeguro\Configuration\Configure::getAccountCredentials();

            /** @var \PagSeguro\Parsers\Transaction\CreditCard\Response $result */
            $result = $creditCard->register($credential);

            echo $result->getReference() . '|' . $result->getCode();

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function initializePagSeguro() {
        $environment = 'sandbox';
        $accountToken = 'DF47D0B7F0054EDF8A15434211598273';

//            $environment = 'production';
//            $accountToken = '0AB117C85F5E4AAB9F866CD753EA9D08';

        $this->accountEmail = 'eng.rmendes@gmail.com';

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

    public function notifications(Request $request)
    {
        Log::debug(json_encode($request->all()));
    }

    public function thanks()
    {
        return view('thanks');
    }
}
