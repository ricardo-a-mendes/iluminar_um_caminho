@extends('layouts.app')

@section('container')
    <form action="{{route('user.update', ['id' => \Illuminate\Support\Facades\Auth::id()])}}" method="post">
        @csrf
        @method('put')
        <div class="section">
            <div class="row s12">
                <div class="col s5">
                    <h3>Dados Pessoais</h3>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}">
                            <label for="name">Nome</label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="input-field col s5">
                            <input id="cpf" type="text" name="cpf" data-inputmask="'mask': '999.999.999-99', 'placeholder': ''" value="{{ old('cpf', $user->cpf) }}">
                            <label for="cpf">CPF</label>
                        </div>
                        <div class="input-field col s2">
                            <input id="area_code" type="number" name="area_code" data-inputmask="'mask': '99', 'placeholder': ''" value="{{ old('area_code', $user->area_code) }}">
                            <label for="area_code">DDD</label>
                        </div>
                        <div class="input-field col s5">
                            <input id="phone_number" type="text" name="phone_number" data-inputmask="'mask': '9999[9]-9999', 'greedy': false, 'placeholder': ''" value="{{ old('phone_number', $user->phone_number) }}">
                            <label for="phone_number">Telefone</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <input id="password" type="password" name="password">
                            <label for="password">Senha</label>
                            <span class="helper-text">Para não alterar, não preencha.</span>
                        </div>
                        <div class="input-field col s6">
                            <input id="password_confirmation" type="password" name="password_confirmation">
                            <label for="password_confirmation">Confirmar Senha</label>
                        </div>
                    </div>
                </div>


                <div class="col s7">
                    <h3>Endereço</h3>
                    <div class="row">
                        <div class="col s3">
                            <div class="input-field">
                                <input id="postal_code" type="text" id="postal_code" name="postal_code" data-inputmask="'mask': '99999-999', 'placeholder': ''" value="{{ old('postal_code', $user->postal_code) }}">
                                <label for="postal_code">CEP</label>
                            </div>
                        </div>
                        <div class="col s2">
                            <div class="input-field">
                                <a href="#" id="consultaCEP" class="btn-small blue darken-1"><i class="material-icons">search</i></a>
                            </div>
                        </div>
                        <div class="col s7">
                            <div class="input-field">
                                <input id="street_name" type="text" name="street_name" value="{{ old('street_name', $user->street_name) }}">
                                <label for="street_name">Endereço</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s3">
                            <input id="street_number" type="text" name="street_number" value="{{ old('street_number', $user->street_number) }}">
                            <label for="street_number">Número</label>
                        </div>
                        <div class="input-field col s3">
                            <input id="complement" type="text" name="complement" value="{{ old('complement', $user->complement) }}">
                            <label for="complement">Complemento</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="district" type="text" name="district" value="{{ old('district', $user->district) }}">
                            <label for="district">Bairro</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="city" type="text" name="city" value="{{ old('city', $user->city) }}">
                            <label for="city">Cidade</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="state" type="text" name="state" data-inputmask="'mask': 'AA', 'placeholder': ''" value="{{ old('state', $user->state) }}">
                            <label for="state">Estado</label>
                        </div>
                    </div>

                </div>


            </div>
        </div>
        <div class="divider"></div>
        <div class="section">
            <div class="row">
                <div class="col s12 right-align">
                    <button type="submit" class="btn btnLoading blue darken-1"><i class="material-icons left">save</i>Salvar</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')

    <script type="text/javascript">

        $('#consultaCEP').on('click', function(e){
            e.preventDefault();

            let cep = $('#postal_code').val().replace('-', '');
            if (cep.length == 8) {

                let progress = $('#loading').modal({
                    'dismissible': false,
                    'onOpenStart': function (element) {
                        let attr = $('#'+element.id).css('width', '30%');
                        console.log(attr);
                    }
                });
                progress.modal('open');

                $.get('https://viacep.com.br/ws/'+ cep +'/json').then(function (response) {

                    if (response.erro == true) {
                        M.toast({html: 'CEP não localizado!'});
                    } else {
                        $('#street_name').val(response.logradouro);
                        $('#district').val(response.bairro);
                        $('#city').val(response.localidade);
                        $('#state').val(response.uf);
                        $('#street_number').focus();
                    }

                    progress.modal('close');
                });
            }
        });

    </script>

@endsection
