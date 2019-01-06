@extends('layouts.app')

@section('container')

    <div class="ui blue segment showLoading">
        <form action="{{ route('campaign.update', ['id' => $campaign->id]) }}" method="post">
            @method('put')
            @include('campaign/campaign_form_data')
        </form>
    </div>
@endsection
