@extends('layout.client')
@section('content')

    <section>

    @include('shared.errors')
    @include('shared.flash_message')

    <!-- Content -->
        <div class="container-fluid">
            <div class="row">

                <div class="col-3 col-md-2 mb-3">
                    <img src={{ URL::to('/uploads/profile_photos')}}/{{$user->profile_photo ?? 'avatar.jpg'}}  width='150'
                         class='rounded-circle'>
                </div>

                <div class="col-9 col-md-10 mb-3">
                    <h4 class="font-weight-bold">{{$client->first_name}}  {{$client->last_name}} <span class="text-muted">({{$user->username}})</span>
                    </h4>
                    <div class="text-muted mb-2">{{trans('file.Company')}}: {{$client->company_name}}</div>
                    <p class="text-muted pb-0-5">{{__('Last Login')}}: {{$user->last_login_date}}</p>

                    <a href="{{route('clientProfile')}}">
                        <button class="btn btn-primary btn-block text-uppercase" id="my_profile"><i
                                    class="ion-person"></i>{{trans('file.Profile')}}</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid dashboard-counts">
            <div class="row">

                <div class="col-md-3 mt-3">
                    <div class="wrapper count-title text-center">
                        <div>
                            <a href="{{route('clientInvoicePaid')}}">
                                <div class="name"><strong class="purple-text">{{__('Paid Invoice')}}</strong></div>
                                <div class="count-number award_count">{{$paid_invoice_count}}</div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 mt-3">
                    <div class="wrapper count-title text-center">
                        <div>
                            <a href="{{route('clientInvoice')}}">
                                <div class="name"><strong class="green-text">{{__('Unpaid Invoice')}}</strong></div>
                                <div class="count-number award_count">{{$unpaid_invoice_count}}</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-3">
                    <div class="wrapper count-title text-center">
                        <div>
                            <a href="{{route('clientProjectStatus')}}?status=completed">
                                <div class="name"><strong class="blue-text">{{__('Completed Projects')}}</strong>
                                </div>
                                <div class="count-number award_count">{{$completed_project_count}}</div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 mt-3">
                    <div class="wrapper count-title text-center">
                        <div>
                            <a href="{{route('clientProjectStatus')}}?status=in_progress">
                                <div class="name"><strong class="orange-text">{{__('In Progress Projects')}}</strong>
                                </div>
                                <div class="count-number award_count">{{$in_progress_project_count}}</div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="wrapper count-title text-center">
                        <div class="ion ion-information display-4 text-warning"></div>
                        <div>
                            <a href="{{route('clientInvoicePaid')}}">
                                <div class="name"><strong class="green-text">{{__('Paid Amount')}}</strong></div>
                                <div class="count-number award_count">{{$invoice_paid_amount}}</div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mt-3">
                    <div class="wrapper count-title text-center">
                        <div class="ion ion-information display-4 text-warning"></div>
                        <div>
                            <a href="{{route('clientInvoice')}}">
                                <div class="name"><strong class="blue-text">{{__('Due Amount')}}</strong></div>
                                <div class="count-number award_count">{{$invoice_unpaid_amount}}</div>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </section>

@endsection