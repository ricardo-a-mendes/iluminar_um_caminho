<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Icons https://fontawesome.com -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style type="text/css">
        /* label color */
        .input-field label {
            color: #278AE2 !important;
        }

        /* label focus color */
        .input-field input:focus + label {
            color: #278AE2 !important;
        }

        /* label underline focus color */
        .input-field input:focus {
            border-bottom: 1px solid #278AE2 !important;
            box-shadow: 0 1px 0 0 #278AE2 !important;
        }

        /* valid color */
        .input-field input.valid {
            border-bottom: 1px solid #278AE2 !important;
            box-shadow: 0 1px 0 0 #278AE2 !important;
        }

        /* invalid color */
        .input-field input.invalid {
            border-bottom: 1px solid #278AE2;
            box-shadow: 0 1px 0 0 #278AE2;
        }

        /* icon prefix focus color */
        .input-field .prefix.active {
            color: #278AE2 !important;
        }

        .progress {
            background-color: #bbdefb;
        }

        .progress .indeterminate {
            background-color: #278AE2;
        }
    </style>
</head>
<body>
<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">

    @auth
        <li>
            <a href="{{route('user.show', ['id' => \Illuminate\Support\Facades\Auth::id()])}}">Meus dados</a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        </li>
    @endauth
</ul>
<nav>
    <div class="nav-wrapper blue darken-1">
        <a href="{{ route('home') }}" class="brand-logo">&nbsp;&nbsp;Projeto Iluminar Um Caminho</a>
        <ul class="right hide-on-med-and-down">
            <li><a href="{{ route('campaign.index') }}">Campanhas</a></li>
            <li><a href="#">Quem Somos</a></li>
            <!-- Authentication Links -->
            @guest
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @endif
            @else
                <li>
                    <a class="dropdown-trigger" href="#!" data-target="dropdown1">{{ Auth::user()->name }}
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>
            @endguest
        </ul>
    </div>
</nav>


<div class="container">

    @if (count($errors) > 0)
        {{--<div class="row">&nbsp;</div>--}}
        <div class="row">
            <div class="col s12 card red lighten-4 z-depth-4">
                <div class="card-content">
                    <p><i class="fa fa-times-circle">&nbsp;</i>Verifique os seguintes campos:</p>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @if (isset($success))
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col s12 teal lighten-4 z-depth-4">
                <p><i class="fa fa-check-circle">&nbsp;</i>{{$success}}</p>
            </div>
        </div>
    @endif

    @if(Session::has('success'))
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col s12 teal lighten-4 z-depth-4">
                    <p><i class="fa fa-check-circle">&nbsp;</i>{{session('success')}}</p>
                </div>
            </div>
    @endif
    @if(Session::has('info'))
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col s12 blue lighten-4 z-depth-4">
                    <p><i class="fa fa-info-circle">&nbsp;</i>{{session('info')}}</p>
                </div>
            </div>
    @endif
    @if(Session::has('error'))
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col s12 red lighten-4 z-depth-4">
                    <p><i class="fa fa-times-circle">&nbsp;</i>{{session('error')}}</p>
                </div>
            </div>
    @endif

    @yield('container')

    <!-- Modal Structure -->
    <div id="generalLoading" class="modal">
        <div class="modal-content center-align">
            <h3 class="">Aguarde...</h3>
            <div class="preloader-wrapper active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!--JavaScript at end of body for optimized loading-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

{{--https://github.com/RobinHerbots/Inputmask--}}
<script type="text/javascript"
        src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

<script>
    $(function () {

        $(":input").inputmask();
        $(".dropdown-trigger").dropdown();
        $(".btnLoading").on('click', function () {
            let progress = $('#generalLoading').modal({
                'dismissible': false,
                'onOpenStart': function (element) {
                    let attr = $('#'+element.id).css('width', '30%');
                    console.log(attr);
                }
            });
            progress.modal('open');
        });
    });
</script>

@yield('js')

</body>
</html>
