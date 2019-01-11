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

        body {
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1 0 auto;
        }

        .footer {
            flex-shrink: 0;
        }

    </style>

    <title>{{ config('app.name', 'Projeto Iluminar um Caminho') }}</title>

</head>
<body>
<div class="ui container content">
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

    @if (count($errors) > 0)

        <div class="ui error message">
            <div class="header">Ops, precisamos de mais algumas informações:</div>
            <p>Verifique os campos em destaque no formulário abaixo.</p>
        </div>

    @endif
    @if (isset($success))
        <div class="ui success message">
            <div class="header">Boooa!!</div>
            <p>{{$success}}</p>
        </div>
    @endif

    @yield('container')
</div>

<div class="ui container">
<footer class="ui bottom floating blue message footer">
    <i class="copyright outline icon"></i>
    Copyright {{ date('Y') }} | Projeto Iluminar um Caminho | Todos os direitos reservados.
</footer>
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
