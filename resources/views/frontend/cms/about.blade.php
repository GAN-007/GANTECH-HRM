@extends('frontend.Layout.master')

@section('title_front','About')

@section('content')
<section class="jumbotron">
    <div class="container">
        <h1 class="h4">{{__('About Us')}}</h1>
    </div>
</section>
<div class="container">
    {!!  html_entity_decode($about) !!}
</div>
@endsection
