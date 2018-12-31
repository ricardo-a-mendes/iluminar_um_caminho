@extends('layouts.app')

@section('container')

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
                                <input id="email" type="email" class="validate @if ($errors->has('email')) invalid @endif" name="email" value="{{ old('email') }}" required>
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <span class="helper-text" data-error="@if ($errors->has('email')) {{ $errors->first('email') }} @endif"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" class="validate @if ($errors->has('password')) invalid @endif" type="password" name="password" required>
                                <label for="password">{{ __('Password') }}</label>
                                <span class="helper-text" data-error="@if ($errors->has('password')) {{ $errors->first('password') }} @endif"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="input-field col s12">
                                <button type="submit" class="btn blue darken-1">
                                    {{ __('Login') }}
                                </button>
                                <a class="waves-effect waves-light btn blue darken-1" href="{{route('logon_facebook')}}">
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

@endsection
