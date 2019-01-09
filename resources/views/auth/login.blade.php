@extends('layouts.app')

@section('container')

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
                                            <button class="ui button addLoading">Login</button>
                                            <div class="or" data-text="ou"></div>
                                            <a href="{{route('logon_facebook')}}" class="ui facebook button addLoading"><i class="facebook f icon"></i> Facebook</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="middle aligned column">
                                <a class="ui big button addLoading" href="{{ route('register') }}">
                                    <i class="signup icon"></i>
                                    Registrar
                                </a>
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
