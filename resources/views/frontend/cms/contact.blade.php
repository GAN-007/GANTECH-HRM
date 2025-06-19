@extends('frontend.Layout.master')

@section('title_front','Contact')

@section('content')
<section class="jumbotron">
    <div class="container">
        <h1 class="h4">{{ __('Contact Us') }}</h1>
    </div>
</section>
<div class="container">
    {!!  html_entity_decode($contact) !!}
</div>
@endsection
