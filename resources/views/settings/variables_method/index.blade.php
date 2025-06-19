@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{route('travel_method.index')}}" id="Travel_method-tab" data-toggle="tab" data-target="#Travel_method" role="tab" aria-controls="Travel_method" aria-selected="true">{{__('Arrangement Method')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{route('payment_method.index')}}" id="Payment_method-tab" data-toggle="tab" data-table= "payment" data-target="#Payment_method" role="tab" aria-controls="Payment_method" aria-selected="false">{{__('Payment Type')}}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('employee_qualification.index')}}" id="employee_qualification-tab" data-toggle="tab" data-table= "employee_qualification" data-target="#employee_qualification" role="tab" aria-controls="employee_qualification" aria-selected="false">{{trans('file.Qualification')}}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('job_categories.index')}}" id="Job_category-tab" data-toggle="tab" data-table= "job_category" data-target="#job_category" role="tab" aria-controls="job_category" aria-selected="false">{{__('Job Category')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="Travel_method" role="tab" aria-labelledby="Travel_method-tab">
                @include('settings.variables_method.partials.travel_method')
            </div>

            <div class="tab-pane fade " id="Payment_method" role="tab"  aria-labelledby="Payment_method-tab">
               @include('settings.variables_method.partials.payment_method')
            </div>


            <div class="tab-pane fade " id="employee_qualification" role="tab"  aria-labelledby="employee_qualification-tab">
                @include('settings.variables_method.partials.employee_qualification')
            </div>

            <div class="tab-pane fade " id="job_category" role="tab"  aria-labelledby="job_category-tab">
                @include('settings.variables_method.partials.job_category')
            </div>

        </div>

    </section>


@endsection


@push('scripts')
    <script type="text/javascript">
        (function($) {
            "use strict";

            let travelLoad = 0;
            $(document).ready(function() {
                if (travelLoad == 0) {
                    @include('settings.variables_method.JS_DT.travel_method_js')
                        travelLoad = 1;
                }
            });

            $('[data-table="payment"]').one('click', function (e) {
                @include('settings.variables_method.JS_DT.payment_method_js')
            });

            $('[data-table="employee_qualification"]').one('click', function (e) {
                @include('settings.variables_method.JS_DT.employee_qualification_js')
            });

            $('[data-table="languageSkills"]').one('click', function (e) {
                @include('settings.variables_method.JS_DT.language_skills_js')
            });

            $('[data-table="otherSkills"]').one('click', function (e) {
                @include('settings.variables_method.JS_DT.general_skills_js')
            });

            $('[data-table="job_category"]').one('click', function (e) {
                @include('settings.variables_method.JS_DT.job_category_js')
            });
        })(jQuery);
    </script>
@endpush
