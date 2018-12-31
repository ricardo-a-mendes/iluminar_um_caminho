@extends('layouts.app')

@section('container')

    <div class="container">
        <div class="title m-b-md">
            Projeto Iluminar Um Caminho
        </div>

    </div>

@endsection
@section('js')

    {{--<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>--}}
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="/js/pagseguro.js"></script>

@endsection

