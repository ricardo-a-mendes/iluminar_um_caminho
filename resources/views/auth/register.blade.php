@extends('layouts.app')

@section('container')

    <div class="row s12"></div>
    <div class="row">
        <div class="col s10 offset-2">
            <form method="POST" action="{{ route('register') }}">
                <div class="card">
                    <div class="card-content grey lighten-3">{{ __('Register') }}</div>

                    <div class="card-content">

                        @csrf

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                <label for="name">{{ __('Name') }}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <label for="email">{{ __('E-Mail Address') }}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" type="password" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <label for="password">{{ __('Password') }}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password-confirm" type="password" name="password_confirmation" required>
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            </div>
                        </div>


                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="input-field col s12">
                                <button type="submit" class="btn blue darken-1">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection
