<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropdown.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/transition.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('css/icon.min.css') }}">--}}

    <!--Import Google Icon Font-->
{{--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">--}}

    <!-- Compiled and minified CSS -->
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">--}}

    <!-- Icons https://fontawesome.com -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{--<style type="text/css">--}}
        {{--/* label color */--}}
        {{--.input-field label {--}}
            {{--color: #278AE2 !important;--}}
        {{--}--}}

        {{--/* label focus color */--}}
        {{--.input-field input:focus + label {--}}
            {{--color: #278AE2 !important;--}}
        {{--}--}}

        {{--/* label underline focus color */--}}
        {{--.input-field input:focus {--}}
            {{--border-bottom: 1px solid #278AE2 !important;--}}
            {{--box-shadow: 0 1px 0 0 #278AE2 !important;--}}
        {{--}--}}

        {{--/* valid color */--}}
        {{--.input-field input.valid {--}}
            {{--border-bottom: 1px solid #278AE2 !important;--}}
            {{--box-shadow: 0 1px 0 0 #278AE2 !important;--}}
        {{--}--}}

        {{--/* invalid color */--}}
        {{--.input-field input.invalid {--}}
            {{--border-bottom: 1px solid #278AE2;--}}
            {{--box-shadow: 0 1px 0 0 #278AE2;--}}
        {{--}--}}

        {{--/* icon prefix focus color */--}}
        {{--.input-field .prefix.active {--}}
            {{--color: #278AE2 !important;--}}
        {{--}--}}

        {{--.progress {--}}
            {{--background-color: #bbdefb;--}}
        {{--}--}}

        {{--.progress .indeterminate {--}}
            {{--background-color: #278AE2;--}}
        {{--}--}}
    {{--</style>--}}
</head>
<body>
<div class="ui container">
<div class="ui blue inverted menu">
    <a class="item" href="{{ route('home') }}">Projeto Ilumenar um caminho</a>
    <a class="item" href="{{ route('campaign.index') }}">Campanhas</a>
    <div class="right menu">
        <a class="item">Quem Somos</a>



        @guest
            <a class="item" href="{{ route('login') }}">{{ __('Login') }}</a>
            @if (Route::has('register'))
                <a class="item" href="{{ route('register') }}">{{ __('Registrar') }}</a>
            @endif
        @else

                <div class="ui dropdown item"><i class="user icon"></i>{{ Auth::user()->name }}
                    <div class="menu">
                        <a class="item" href="{{route('user.show', ['id' => \Illuminate\Support\Facades\Auth::id()])}}">Meus dados</a>
                        <a class="item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </div>
                </div>



            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        @endguest

    </div>
</div>
</div>

<div class="grid">&nbsp;</div>

<div class="ui container">

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
    <!--
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
    -->
</div>

{{--<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>--}}

<!--JavaScript at end of body for optimized loading-->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>--}}

<script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dropdown.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/transition.min.js') }}"></script>

{{--https://github.com/RobinHerbots/Inputmask--}}
<script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

<script>
    $(function () {

        $('.ui.dropdown')
            .dropdown()
        ;

        $(":input").inputmask();
        $(".dropdown-trigger").dropdown();
        $(".addLoading").on('click', function () {
            $(".showLoading").addClass('loading');
        });
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
