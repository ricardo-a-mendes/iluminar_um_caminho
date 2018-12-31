@extends('layouts.app')

@section('container')

    <div class="row">&nbsp;</div>
    <form action="{{ route('campaign.store') }}" method="post">
        @include('campaign/campaign_form_data')
    </form>

@endsection
