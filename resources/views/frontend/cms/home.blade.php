@extends('frontend.Layout.master')

@section('title_front','Home')

@section('content')
<div class="container">
    {!!  html_entity_decode($home) !!}
</div>
@endsection
