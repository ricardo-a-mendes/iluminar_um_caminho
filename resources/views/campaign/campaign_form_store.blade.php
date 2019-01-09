@extends('layouts.app')

@section('container')

    <div class="ui blue segment showLoading">
        <form action="{{ route('campaign.store') }}" method="post">
            @include('campaign/campaign_form_data')
        </form>
    </div>
@endsection
