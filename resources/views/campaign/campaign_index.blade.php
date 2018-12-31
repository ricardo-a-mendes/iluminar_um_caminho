@extends('layouts.app')

@section('container')

    <div class="row s12">
        <table class="striped">
            <thead>
                <tr>
                    <th>Campanha</th>
                    <th>Descricao</th>
                    <th>Termina em</th>
                    <th>Valor Sugerido</th>
                    <th>Meta</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            @foreach($campaigns as $campaign)
                <tr>
                    <td>{{$campaign->name}}</td>
                    <td>{{$campaign->description}}</td>
                    <td>{{$campaign->ends_at}}</td>
                    <td>R$ {{number_format($campaign->suggested_donation, 2, ',', '.')}}</td>
                    <td>R$ {{number_format($campaign->target_amount, 2, ',', '.')}}</td>
                    <td><a class="btn blue btnLoading darken-1 waves-effect waves-light" href="{{route('checkout.index', ['id' => $campaign->id])}}">Doar<i class="material-icons right">send</i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
