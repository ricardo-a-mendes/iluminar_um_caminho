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
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

    <!-- Icons https://fontawesome.com -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <style type="text/css">
        .error small.helper {
            color: #9F3A38 !important;
        }
    </style>

    <title>{{ config('app.name', 'Projeto Iluminar um Caminho') }}</title>

</head>
<body>
<div class="ui container">
    <div class="ui blue inverted menu">
        <a class="item" href="{{ route('home') }}">Projeto Iluminar um Caminho</a>
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
                        <a class="item" href="{{route('user.show', ['id' => \Illuminate\Support\Facades\Auth::id()])}}">Meus
                            dados</a>
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

        <div class="ui error message">
            <div class="header">Ops, precisamos de mais algumas informações:</div>
            <p>Verifique os campos em destaque no formulário abaixo.</p>
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


</div>


<script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dropdown.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/transition.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>

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

    });
</script>

@yield('js')

</body>
</html>
