@extends('layouts.app')

@section('container')

    <div class="ui attached message">
        <div class="header">{{ $campaign->name }}</div>
        <p>{{ $campaign->description }}</p>
    </div>
    <div class="ui blue attached segment showLoading">
        <form action="{{route('checkout_process')}}" method="post" id="form_checkout">
            @csrf
            @method('post')
            <div class="ui form">
                <div class="ui grid">
                    <!-- Vaor da doação -->
                    <div class="three column row">
                        <div class="four wide column">&nbsp;</div>
                        <div class="two wide column">
                            <div class="field">
                                <div class="required field">
                                    <label for="donationAmount">Valor da Doação</label>
                                    <input type="text" id="donationAmount" name="donationAmount" value="30,00"
                                           data-inputmask="'mask': '9{1,},9{2}', 'placeholder': ''">

                                </div>
                            </div>
                        </div>
                        <div class="ten wide column">
                            <div class="bottom aligned">Valor sugerido R$ {{number_format($campaign->suggested_donation, 2, ',', '.')}}</div>
                        </div>
                    </div>

                    <!-- Dados do Cartão -->
                    <div class="three column row">
                        <div class="four wide column">&nbsp;</div>
                        <div class="eight wide column">
                            <div class="three fields">
                                <div class="ten wide required field">
                                    <label for="cardNumber">Número do cartão</label>
                                    <input type="text" id="cardNumber" data-inputmask="'mask': '9999 9999 9999 9999', 'placeholder': ''"
                                           value="4111111111111111">
                                </div>
                                <div class="three wide required field">
                                    <label for="cvv">cvv</label>
                                    <input type="text" id="cvv" value="123">
                                </div>
                                <div class="three wide required field">
                                    <label for="expiration">Expira</label>
                                    <input type="text" id="expiration" data-inputmask="'mask': '99/99', 'placeholder': ''"
                                           placeholder="mm/aa" value="12/30">
                                </div>
                            </div>
                        </div>
                        <div class="four wide column">&nbsp;</div>
                    </div>

                    <!-- Dados do Proprietário do Cartão -->
                    <div class="three column row">
                        <div class="four wide column">&nbsp;</div>
                        <div class="eight wide column">
                            <div class="two fields">
                                <div class="ten wide required field">
                                    <label for="creditCardHolderName">Nome completo</label>
                                    <input type="text" id="creditCardHolderName" name="creditCardHolderName" value="João Comprador">
                                </div>
                                <div class="six wide required field">
                                    <label for="creditCardHolderCPF">CPF</label>
                                    <input type="text" id="creditCardHolderCPF" name="creditCardHolderCPF"
                                           data-inputmask="'mask': '999.999.999-99', 'placeholder': ''" value="12345678909">
                                </div>

                            </div>
                        </div>
                        <div class="four wide column">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="ui divider"></div>
            <div class="ui column grid">
                <div class="row">
                    <div class="column right aligned">
                        <button type="button" id="btnDoar" class="ui button addLoading blue">Doar <i class="smile outline right aligned icon"></i></button>
                        <button type="button" id="btnPasso1" class="ui button blue">Passo 1 <i class="smile outline right aligned icon"></i></button>
                        <button type="button" id="btnPasso2" class="ui button blue">Passo 2 <i class="smile outline right aligned icon"></i></button>
                        <button type="button" id="btnPasso3" class="ui button blue">Passo 3 <i class="smile outline right aligned icon"></i></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="campaign_id" id="campaignId" value="{{$campaign->id}}">
            <input type="hidden" name="campaign_name" value="{{$campaign->name}}">
            <input type="hidden" name="creditCardToken" id="creditCardToken">
            <input type="hidden" name="installmentValue" id="installmentValue" value="1">
            <input type="hidden" name="installmentQuantity" id="installmentQuantity" value="1">
        </form>
    </div>
    <div class="ui teal attached message hidden" id="steps">
        <div class="ui mini steps">
            <div class="active step" id="step_lock">
                <i class="lock icon"></i>
                <div class="content">
                    <div class="title">Passo 1 - Segurança</div>
                    <div class="description">Criptografando seus dados</div>
                </div>
            </div>
            <div class="disabled step" id="step_payment">
                <i class="payment icon"></i>
                <div class="content">
                    <div class="title">Passo 2 - Integração</div>
                    <div class="description">Recebendo sua doação através do Pag Seguro</div>
                </div>
            </div>
            <div class="disabled step" id="step_confirmation">
                <i class="info icon"></i>
                <div class="content">
                    <div class="title">PAsso 3 - Finalizando</div>
                    <div class="description">Confirmando sua doação</div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui attached message">
        <img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/mastercard.png" alt="Mastercard">
        <img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/visa.png" alt="Visa">
        <img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/elo.png" alt="Alelo">
        <img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/diners.png" alt="Diners Club">
        <img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/amex.png" alt="American Express">
        <img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/hipercard.png" alt="Hipercard">
    </div>
    <div class="ui bottom attached success message">
        <i class="info icon"></i>
            A doação será recebida através do PagSeguro
    </div>

@endsection
@section('js')

    {{--<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>--}}
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

    <script>

        PagSeguroDirectPayment.setSessionId('{{$session}}');


        $('#cardNumber').on('keyup', function () {
            let fullCartao = $(this).val();
            let numCartao = fullCartao.split('_').join('').split(' ').join('');

            if (numCartao.length == 6) {

                PagSeguroDirectPayment.getBrand({
                    cardBin: numCartao,
                    success: function (response) {
                        //bandeira encontrada
                        console.log('Success');
                        console.log(response.brand.name);
                    },
                    error: function (response) {
                        console.log('error');
                        console.log(response);
                    },
                    complete: function (response) {
                        //tratamento comum para todas chamadas
                    }
                });
            }
        });

        $('#btnDoar').on('click', function (e) {
            e.preventDefault();

            $('#step_lock').removeClass('disabled').addClass('active');
            $('#step_payment').removeClass('active').addClass('disabled');
            $('#step_confirmation').removeClass('active').addClass('disabled');
            $('#steps').removeClass('hidden');

            // Passo 1
            let fullCard = $('#cardNumber').val();
            let numCard = fullCard.split('_').join('').split(' ').join('');

            // progress.modal('open');
            console.log(numCard);

            let expiration = $('#expiration').val().split('/');
            let params = {
                cardNumber: numCard,
                cvv: $('#cvv').val(),
                expirationMonth: expiration[0],
                expirationYear: '20' + expiration[1],
                // brand: 'mastercard',
                success: function (response) {
                    $('#creditCardToken').val(response.card.token);
                    let url = $('#form_checkout').attr('action');
                    let data = $('#form_checkout').serialize();

                    // Passo 2
                    $('#step_lock').removeClass('active');
                    $('#step_payment').removeClass('disabled').addClass('active');

                    $.post(url, data).then(
                        function (result) {

                            // Passo 3
                            $('#step_payment').removeClass('active');
                            $('#step_confirmation').removeClass('disabled').addClass('active');

                            let campaign_url = '{{ route('donation.store') }}';
                            let camp_data = {
                                campaign_id: $('#campaignId').val(),
                                donated_amount: $('#donationAmount').val(),
                                transaction_token: result,
                                '_token' : $('input[name=_token]').val()
                            };
                            $.post(campaign_url, camp_data).then(
                                function (camp_result) {
                                    $('#steps').addClass('hidden');
                                    window.location = '{{ route('checkout_thanks', ['id' => 0]) }}';
                                },
                                function (camp_error) {
                                    console.log(camp_error);
                                    $(".showLoading").removeClass('loading');
                                }
                            );
                        },
                        function (error) {
                            let errorHTL = '';
                            if (error.status == 403) {
                                errorHTL += '<p>Você deve finalizar seu cadastro para poder efetuar uma doação.</p>';
                                errorHTL += '<a href="{{ route('user.update', ['id' => \Illuminate\Support\Facades\Auth::id()]) }}">Clique aqui para fazer a atualização.</a>';
                            } else {
                                errorHTL += '<ul>';

                                for (let [key, value] of Object.entries(error.responseJSON.errors)) {
                                    errorHTL += '<li>' + value + '</li>';
                                }

                                errorHTL += '</ul>';
                            }

                            // $('#errorList').html(errorHTL);
                            // $('#processError').removeAttr('class', 'hide');
                            // progress.modal('close');
                            $(".showLoading").removeClass('loading');
                        });
                },
                error: function (response) {
                    // progress.modal('close');
                    console.log(response);
                    $(".showLoading").removeClass('loading');
                }
            };

            PagSeguroDirectPayment.createCardToken(params);
        })

    </script>
@endsection

