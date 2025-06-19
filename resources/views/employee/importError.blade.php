@extends('layout.main')
@section('content')


    <section>

        <div class="container">

            {{__('There are some errors on')}}

            <button><a href="{{ URL::previous() }}">{{__('Go Back')}}</a></button>

        </div>

        <div class="container">

        @isset($failures)
            <div class="alert alert-danger" role="alert">
                <strong>{{trans('file.Errors')}}:</strong>

                <ul>
                    @foreach ($failures as $failure)
                        <li>Row No -{{$failure->row()}}</li>
                        @foreach ($failure->errors() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
    @endisset

        </div>

    </section>

    @endsection




