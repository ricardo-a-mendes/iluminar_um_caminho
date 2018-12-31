@extends('layouts.app')

@section('container')

    <div class="container">

        <form action="{{route('checkout_process')}}" method="post" id="form_checkout">
            @csrf

            <div class="row">
                <ul class="collection">
                    <li class="collection-item avatar">
                        <i class="material-icons circle blue darken-1">card_giftcard</i>
                        <span class="title">{{$campaign->name}}</span>
                        <p>Iniciada em {{date('d/m/Y', strtotime($campaign->starts_at))}}<br>Finalizará
                            em {{date('d/m/Y', strtotime($campaign->ends_at))}}</p>
                    </li>
                </ul>
            </div>

            <div class="row hide" id="processError">
                <div class="col s12 card red lighten-4 z-depth-4">

                    <div class="card-content">
                        <p>Pagamento não processado:</p>
                        <ul id="errorList"></ul>
                    </div>

                </div>
            </div>

            <div class="row ">
                <ul class="collection z-depth-3">
                    <li class="collection-item ">
                        {{--<i class="material-icons circle blue darken-1">card_giftcard</i>--}}
                        <div class="input-field">

                            <input type="text" id="donationAmount" name="donationAmount"
                                   data-inputmask="'mask': '9{1,},9{2}', 'placeholder': ''">
                            <label for="donationAmount">Valor da Doação</label>
                            <span class="helper-text">Valor sugerido R$ {{number_format($campaign->suggested_donation, 2, ',', '.')}}</span>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    {{--<input type="text" id="cardNumber" value="4111111111111111">--}}
                    <input type="text" id="cardNumber" data-inputmask="'mask': '9999 9999 9999 9999', 'placeholder': ''"
                           value="4111111111111111">
                    <label for="cardNumber">Número do cartão</label>
                    <div id="card_brand"></div>
                </div>
                <div class="input-field col s2">
                    <input type="text" id="cvv" value="123">
                    <label for="cvv">cvv</label>

                </div>
                <div class="input-field col s4">
                    <input type="text" id="expiration" data-inputmask="'mask': '99/99', 'placeholder': ''"
                           placeholder="mm/aa" value="12/30">
                    <label for="expiration">Expira</label>
                </div>

            </div>

            <div id="holder_data">
                <div class="row">
                    <div class="input-field col s6">
                        <input type="text" id="creditCardHolderName" name="creditCardHolderName" value="João Comprador">
                        <label for="creditCardHolderName">Nome completo</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="text" id="creditCardHolderCPF" name="creditCardHolderCPF"
                               data-inputmask="'mask': '999.999.999-99', 'placeholder': ''" value="12345678909">
                        <label for="creditCardHolderCPF">CPF</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <a id="btnDoar" class="waves-effect waves-light btn blue darken-1">
                        <i class="material-icons right">child_care</i>doar</a>
                </div>
            </div>

            <div class="divider"></div>

            <div class="row"></div>
            <div class="row">

                <div class="col s1"><img
                            src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/mastercard.png"
                            alt="Mastercard"></div>
                <div class="col s1"><img
                            src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/visa.png"
                            alt="Visa"></div>
                <div class="col s1"><img
                            src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/elo.png"
                            alt="Alelo"></div>
                <div class="col s1"><img
                            src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/diners.png"
                            alt="Diners Club"></div>
                <div class="col s1"><img
                            src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/amex.png"
                            alt="American Express"></div>
                <div class="col s1"><img
                            src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/hipercard.png"
                            alt="Hipercard"></div>
            </div>

            <div class="row">
                <div class="input-field col s7">
                    <input type="hidden" name="campaign_id" value="{{$campaign->id}}">
                    <input type="hidden" name="campaign_name" value="{{$campaign->name}}">
                    <input type="hidden" name="creditCardToken" id="creditCardToken">
                    <input type="hidden" name="installmentValue" id="installmentValue" value="1">
                    <input type="hidden" name="installmentQuantity" id="installmentQuantity" value="1">
                </div>
            </div>
        </form>

        <!-- Modal Structure -->
        <div id="processing" class="modal">
            <div class="modal-content">
                <h3>Processando...</h3>
                <h4 id="steps">Passo 1 de 2</h4>
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('js')

    {{--<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>--}}
    <script type="text/javascript"
            src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

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

        $('#btnPrepare').on('click', function (e) {
            e.preventDefault();

            let progress = $('.modal').modal();
            let fullCard = $('#cardNumber').val();
            let numCard = fullCard.split('_').join('').split(' ').join('');

            progress.modal('open');

            let params = {
                cardNumber: numCard,
                cvv: $('#cvv').val(),
                expirationMonth: $('#expirationMonth').val(),
                expirationYear: $('#expirationYear').val(),
                brand: 'visa',
                success: function (response) {
                    //bandeira encontrada
                    $('#creditCardToken').val(response.card.token);
                },
                error: function (response) {
                    console.log('error');
                    console.log(response);
                },
                complete: function (response) {
                    //tratamento comum para todas chamadas
                    progress.modal('close');
                }
            };

            PagSeguroDirectPayment.createCardToken(params);

        });

        $('#btnDoar').on('click', function (e) {
            e.preventDefault();

            $('#steps').html('Passo 1 de 2 - Preparando os dados');
            let progress = $('#processing').modal();
            let fullCard = $('#cardNumber').val();
            let numCard = fullCard.split('_').join('').split(' ').join('');

            progress.modal('open');

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

                    $('#steps').html('Passo 2 de 2 - Integrando com PagSeguro!');

                    $.post(url, data).then(
                        function (result) {
                            window.location = '{{ route('checkout_thanks', ['id' => 0]) }}';
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

                            $('#errorList').html(errorHTL);
                            $('#processError').removeAttr('class', 'hide');
                            progress.modal('close');
                        });
                },
                error: function (response) {
                    progress.modal('close');
                }
            };

            PagSeguroDirectPayment.createCardToken(params);
        })

    </script>
@endsection

