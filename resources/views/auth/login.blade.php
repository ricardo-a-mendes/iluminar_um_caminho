@extends('layouts.app')

@section('container')
    <!--
    <div class="row s12"></div>
    <div class="row">
        <div class="col s8 offset-s2">
            <form method="POST" action="{{ route('login') }}">
                <div class="card">
                    <div class="card-content grey lighten-3">
                        <span class="card-title ">{{ __('Login') }}</span>
                    </div>
                    <div class="card-content">

                        @csrf

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email"
                           class="validate @if ($errors->has('email')) invalid @endif" name="email"
                                       value="{{ old('email') }}" required>
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <span class="helper-text"
                                      data-error="@if ($errors->has('email')) {{ $errors->first('email') }} @endif"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" class="validate @if ($errors->has('password')) invalid @endif"
                                       type="password" name="password" required>
                                <label for="password">{{ __('Password') }}</label>
                                <span class="helper-text"
                                      data-error="@if ($errors->has('password')) {{ $errors->first('password') }} @endif"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="input-field col s12">
                                <button type="submit" class="btn blue darken-1">
                                    {{ __('Login') }}
            </button>
            <a class="waves-effect waves-light btn blue darken-1"
               href="{{route('logon_facebook')}}">
                                    <i class="fab fa-facebook"></i>
                                    {{ __('Login com Facebook') }}</a>

                                </button>

                                @if (Route::has('password.request'))
        <a class="btn blue darken-1 right" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                </a>
@endif

            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>
-->
    <br>
    <br>
    <br>
    <div class="ui container">
        <div class="ui equal width grid">
            <div class="column"></div>
            <div class="ten wide column">

                <div class="column wide">
                    <div class="ui blue message attached">
                        <div class="header">
                            Bem vindo ao Projeto Iluminar um Caminho!
                        </div>
                        <p>Você pode fazer login com sua conta ou utilizar seu Facebook</p>
                    </div>
                    <div class="ui placeholder attached segment showLoading">

                    <form class="ui form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="ui two column very relaxed stackable grid">
                            <div class="column">
                                <div class="ui">
                                    <div class="field">
                                        <label>e-mail</label>
                                        <div class="ui left icon input">
                                            <input type="email" name="email" placeholder="email">
                                            <i class="user icon"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>senha</label>
                                        <div class="ui left icon input">
                                            <input type="password" name="password">
                                            <i class="lock icon"></i>
                                        </div>
                                    </div>

                                    <div class="field">

                                        <div class="ui buttons">
                                            <button class="ui button">Login</button>
                                            <div class="or" data-text="ou"></div>
                                            <a href="{{route('logon_facebook')}}" class="ui facebook button addLoading"><i class="facebook f icon"></i> Facebook</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="middle aligned column">
                                <div class="ui big button">
                                    <i class="signup icon"></i>
                                    Registrar
                                </div>
                            </div>
                        </div>
                        <div class="ui vertical divider">OU</div>
                    </form>
                    </div>
                </div>

            </div>
            <div class="column"></div>
        </div>
    </div>


@endsection
