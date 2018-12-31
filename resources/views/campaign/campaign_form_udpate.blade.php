@extends('layouts.app')

@section('container')

    <div class="row">&nbsp;</div>
    <form action="{{ route('campaign.update') }}" method="post">
        @method('put')
        @include('campaign/campaign_form_data')
    </form>

@endsection
