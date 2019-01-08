@extends('layouts.app')

@section('container')

    <div class="ui blue segment showLoading">
        <form action="{{route('user.update', ['id' => \Illuminate\Support\Facades\Auth::id()])}}" method="post">
            @csrf
            @method('put')
            <div class="ui form">
                <div class="ui grid">
                    <!-- Dados Pessoais -->
                    <div class="eight wide column">
                        <div class="field">
                            <div class="required field">
                                <label for="name">Nome</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}">
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="required field">
                                <label for="cpf">CPF</label>
                                <input id="cpf" type="text" name="cpf" data-inputmask="'mask': '999.999.999-99', 'placeholder': ''" value="{{ old('cpf', $user->cpf) }}">
                            </div>
                            <div class="required field">
                                <label for="area_code">DDD</label>
                                <input id="area_code" type="number" name="area_code" data-inputmask="'mask': '99', 'placeholder': ''" value="{{ old('area_code', $user->area_code) }}">
                            </div>
                            <div class="required field">
                                <label for="phone_number">Telefone</label>
                                <input id="phone_number" type="text" name="phone_number" data-inputmask="'mask': '9999[9]-9999', 'greedy': false, 'placeholder': ''" value="{{ old('phone_number', $user->phone_number) }}">
                            </div>
                        </div>
                        <div class="two fields">
                            <div class="required field">
                                <label for="password">Senha</label>
                                <input id="password" type="password" name="password">
                            </div>
                            <div class="required field">
                                <label for="password_confirmation">Confirmar Senha</label>
                                <input id="password_confirmation" type="password" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <!-- Endereco -->
                    <div class="eight wide column">
                        <div class="three fields">
                            <div class="required four wide field">
                                <label for="postal_code">CEP</label>
                                <input id="postal_code" type="text" id="postal_code" name="postal_code" data-inputmask="'mask': '99999-999', 'placeholder': ''" value="{{ old('postal_code', $user->postal_code) }}">
                            </div>
                            <div class="one wide field">
                                <label for="">&nbsp;</label>
                                <a href="#" id="consultaCEP" class="btn-small blue darken-1"><i class="magnify large icon"></i></a>
                            </div>
                            <div class="required eleven wide field">
                                <label for="street_name">Endereço</label>
                                <input id="street_name" type="text" name="street_name" value="{{ old('street_name', $user->street_name) }}">
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="required four wide field">
                                <label for="street_number">Número</label>
                                <input id="street_number" type="text" name="street_number" value="{{ old('street_number', $user->street_number) }}">
                            </div>
                            <div class="required four wide field">
                                <label for="complement">Complemento</label>
                                <input id="complement" type="text" name="complement" value="{{ old('complement', $user->complement) }}">
                            </div>
                            <div class="required eight wide field">
                                <label for="district">Bairro</label>
                                <input id="district" type="text" name="district" value="{{ old('district', $user->district) }}">
                            </div>
                        </div>
                        <div class="two fields">
                            <div class="required eleven wide field">
                                <label for="city">Cidade</label>
                                <input id="city" type="text" name="city" value="{{ old('city', $user->city) }}">
                            </div>
                            <div class="required seven wide field">
                                <label for="state">Estado</label>
                                <input id="state" type="text" name="state" data-inputmask="'mask': 'AA', 'placeholder': ''" value="{{ old('state', $user->state) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui divider"></div>
                <div class="ui column grid">
                    <div class="row">
                        <div class="column right aligned">
                            <button type="submit" class="ui button addLoading blue">Salvar <i class="save right aligned icon"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('js')

    <script type="text/javascript">

        $('#consultaCEP').on('click', function(e){
            e.preventDefault();

            let cep = $('#postal_code').val().replace('-', '');
            if (cep.length == 8) {

                $.get('https://viacep.com.br/ws/'+ cep +'/json').then(function (response) {

                    if (response.erro == true) {
                        console.log('cep nao localixado')
                    } else {
                        $('#street_name').val(response.logradouro);
                        $('#district').val(response.bairro);
                        $('#city').val(response.localidade);
                        $('#state').val(response.uf);
                        $('#complement').val('');
                        $('#street_number').val('').focus();
                    }

                });
            }
        });

    </script>

@endsection
