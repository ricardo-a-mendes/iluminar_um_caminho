@extends('layouts.app')

@section('container')

    <div class="ui grid">

        <div class="four wide column">&nbsp;</div>
        <div class="eight wide column">

            <div class="ui blue segment showLoading">
                <form action="{{route('register')}}" method="post">
                    @csrf
                    @method('post')
                    <div class="ui form">

                        <div class="field">
                            <div class="required field @if ($errors->has('name')) error @endif">
                                <label for="name">Nome</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))<small class="helper">{{ $errors->first('name') }}</small>@endif
                            </div>
                        </div>

                        <div class="two fields @if ($errors->has('email')) error @endif">
                            <div class="required field">
                                <label for="email">E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))<small class="helper">{{ $errors->first('email') }}</small>@endif
                            </div>
                            <div class="required field">
                                <label for="email_confirmation">Confirmar E-mail</label>
                                <input id="email_confirmation" type="email" name="email_confirmation">
                            </div>
                        </div>

                        <div class="two fields @if ($errors->has('password')) error @endif">
                            <div class="required field">
                                <label for="password">Senha</label>
                                <input id="password" type="password" name="password">
                                @if ($errors->has('password'))<small class="helper">{{ $errors->first('password') }}</small>@endif
                            </div>
                            <div class="required field">
                                <label for="password_confirmation">Confirmar Senha</label>
                                <input id="password_confirmation" type="password" name="password_confirmation">
                            </div>
                        </div>
                        <div class="ui divider"></div>
                        <div class="ui column grid">
                            <div class="row">
                                <div class="column right aligned">
                                    <button type="submit" class="ui button addLoading blue">Registrar <i
                                                class="signup right aligned icon"></i></button>
                                </div>
                            </div>
                        </div>


                    </div>
                </form>
            </div>

        </div>
    </div>





@endsection
