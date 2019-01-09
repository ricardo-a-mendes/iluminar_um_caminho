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
                            <div class="required field @if ($errors->has('name')) error @endif">
                                <label for="name">Nome</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}">
                                @if ($errors->has('name'))<small class="helper">{{ $errors->first('name') }}</small>@endif
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="required field @if ($errors->has('cpf')) error @endif">
                                <label for="cpf">CPF</label>
                                <input id="cpf" type="text" name="cpf" data-inputmask="'mask': '999.999.999-99', 'placeholder': ''" value="{{ old('cpf', $user->cpf) }}">
                                @if ($errors->has('cpf'))<small class="helper">{{ $errors->first('cpf') }}</small>@endif
                            </div>
                            <div class="required field @if ($errors->has('area_code')) error @endif">
                                <label for="area_code">DDD</label>
                                <input id="area_code" type="number" name="area_code" data-inputmask="'mask': '99', 'placeholder': ''" value="{{ old('area_code', $user->area_code) }}">
                                @if ($errors->has('area_code'))<small class="helper">{{ $errors->first('area_code') }}</small>@endif
                            </div>
                            <div class="required field @if ($errors->has('phone_number')) error @endif">
                                <label for="phone_number">Telefone</label>
                                <input id="phone_number" type="text" name="phone_number" data-inputmask="'mask': '9999[9]-9999', 'greedy': false, 'placeholder': ''" value="{{ old('phone_number', $user->phone_number) }}">
                                @if ($errors->has('phone_number'))<small class="helper">{{ $errors->first('phone_number') }}</small>@endif
                            </div>
                        </div>
                        <div class="two fields @if ($errors->has('password')) error @endif">
                            <div class="required field @if ($errors->has('password')) error @endif">
                                <label for="password">Senha</label>
                                <input id="password" type="password" name="password">
                                @if ($errors->has('password'))<small class="helper">{{ $errors->first('password') }}</small>@endif
                            </div>
                            <div class="required field">
                                <label for="password_confirmation">Confirmar Senha</label>
                                <input id="password_confirmation" type="password" name="password_confirmation">
                            </div>
                        </div>
                        <small> <i class="info icon"></i> Se os campos de senha não forem preenchidos, a senha não será alterada!</small>
                    </div>
                    <!-- Endereco -->
                    <div class="eight wide column">
                        <div class="three fields">
                            <div class="required four wide field @if ($errors->has('postal_code')) error @endif">
                                <label for="postal_code">CEP</label>
                                <input id="postal_code" type="text" id="postal_code" name="postal_code" data-inputmask="'mask': '99999-999', 'placeholder': ''" value="{{ old('postal_code', $user->postal_code) }}">
                                @if ($errors->has('postal_code'))<small class="helper">{{ $errors->first('postal_code') }}</small>@endif
                            </div>
                            <div class="one wide field">
                                <label for="">&nbsp;</label>
                                <a href="#" id="consultaCEP"><i class="magnify large icon"></i></a>
                            </div>
                            <div class="required eleven wide field @if ($errors->has('street_name')) error @endif">
                                <label for="street_name">Endereço</label>
                                <input id="street_name" type="text" name="street_name" value="{{ old('street_name', $user->street_name) }}">
                                @if ($errors->has('street_name'))<small class="helper">{{ $errors->first('street_name') }}</small>@endif
                            </div>
                        </div>
                        <div class="three fields">
                            <div class="required four wide field @if ($errors->has('street_number')) error @endif">
                                <label for="street_number">Número</label>
                                <input id="street_number" type="text" name="street_number" value="{{ old('street_number', $user->street_number) }}">
                                @if ($errors->has('street_number'))<small class="helper">{{ $errors->first('street_number') }}</small>@endif
                            </div>
                            <div class="four wide field @if ($errors->has('suggested_donation')) error @endif">
                                <label for="complement">Complemento</label>
                                <input id="complement" type="text" name="complement" value="{{ old('complement', $user->complement) }}">
                            </div>
                            <div class="required eight wide field @if ($errors->has('district')) error @endif">
                                <label for="district">Bairro</label>
                                <input id="district" type="text" name="district" value="{{ old('district', $user->district) }}">
                                @if ($errors->has('district'))<small class="helper">{{ $errors->first('district') }}</small>@endif
                            </div>
                        </div>
                        <div class="two fields">
                            <div class="required eleven wide field @if ($errors->has('city')) error @endif">
                                <label for="city">Cidade</label>
                                <input id="city" type="text" name="city" value="{{ old('city', $user->city) }}">
                                @if ($errors->has('city'))<small class="helper">{{ $errors->first('city') }}</small>@endif
                            </div>
                            <div class="required seven wide field @if ($errors->has('state')) error @endif">
                                <label for="state">Estado</label>
                                <input id="state" type="text" name="state" data-inputmask="'mask': 'AA', 'placeholder': ''" value="{{ old('state', $user->state) }}">
                                @if ($errors->has('state'))<small class="helper">{{ $errors->first('state') }}</small>@endif
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
                $(".showLoading").addClass('loading');
                $.get('https://viacep.com.br/ws/'+ cep +'/json').then(function (response) {

                    if (response.erro == true) {
                        toastr.error('Você pode preencher os dados manualmente ou pesquisar outro CEP.', 'CEP não localizado =(');
                    } else {
                        $('#street_name').val(response.logradouro);
                        $('#district').val(response.bairro);
                        $('#city').val(response.localidade);
                        $('#state').val(response.uf);
                        $('#complement').val('');
                        $('#street_number').val('').focus();
                    }
                });
                $(".showLoading").removeClass('loading');
            }
        });

    </script>

@endsection
