@extends('layouts.app')

@section('container')

    @admin
    <div class="ui grid">
        <div class="column row">
            <div class="column right aligned">
                <a href="{{ route('campaign.create') }}" class="ui circular blue button">Nova Campanha<i class="plus right aligned icon"></i></a>
            </div>
        </div>
    </div>
    @endadmin

    <div class="ui vertical segment showLoading">

        <table class="ui celled striped blue table">
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
                    <td>
                        <a class="ui button blue addLoading" href="{{route('checkout.index', ['id' => $campaign->id])}}">Doar <i class="paper plane right aligned icon"></i></a>
                        @admin
                        <a class="ui button blue addLoading" href="{{route('campaign.edit', ['id' => $campaign->id])}}">Editar<i class="edit outline right aligned icon"></i></a>
                        @endadmin
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
