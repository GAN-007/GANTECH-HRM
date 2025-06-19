@extends('layout.main')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('leave_type.index')}}" id="Leave_type-tab" data-toggle="tab" data-table= "leave" data-target="#Leave_type" role="tab" aria-controls="Leave_type" aria-selected="true">{{__('Leave Type')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('award_type.index')}}" id="Award_type-tab" data-toggle="tab" data-table= "award" data-target="#Award_type" role="tab" aria-controls="Award_type" aria-selected="false">{{__('Award Type')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('warning_type.index')}}" id="Warning_type-tab" data-toggle="tab" data-table= "warning" data-target="#Warning_type" role="tab" aria-controls="Warning_type" aria-selected="false">{{__('Warning Type')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('termination_type.index')}}" id="Termination_type-tab" data-toggle="tab" data-table= "termination" data-target="#Termination_type" role="tab" aria-controls="Termination_type" aria-selected="false">{{__('Termination Type')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('expense_type.index')}}" id="Expense_type-tab" data-toggle="tab" data-table= "expense" data-target="#Expense_type" role="tab" aria-controls="Expense_type" aria-selected="false">{{__('Expense Type')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('status_type.index')}}" id="Status_type-tab" data-toggle="tab" data-table= "status" data-target="#Status_type" role="tab" aria-controls="Status_type" aria-selected="false">{{__('Employee Status')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('document_type.index')}}" id="Document_type-tab" data-toggle="tab" data-table= "document" data-target="#Document_type" role="tab" aria-controls="Document_type" aria-selected="false">{{__('Document Type')}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">

            <div class="pt-0 tab-pane fade show active" id="Leave_type" role="tab" aria-labelledby="Leave_type-tab">
              @include('settings.variables.partials.leave_type')
            </div>
            <div class="pt-0 tab-pane fade " id="Award_type" role="tab"  aria-labelledby="Award_type-tab">
               @include('settings.variables.partials.award_type')
            </div>

            <div class="pt-0 tab-pane fade " id="Warning_type" role="tab"  aria-labelledby="Warning_type-tab">
                @include('settings.variables.partials.warning_type')
            </div>

            <div class="pt-0 tab-pane fade " id="Termination_type" role="tab"  aria-labelledby="Termination_type-tab">
                @include('settings.variables.partials.termination_type')
            </div>

            <div class="pt-0 tab-pane fade " id="Expense_type" role="tab"  aria-labelledby="Expense_type-tab">
                @include('settings.variables.partials.expense_type')
            </div>

            <div class="pt-0 tab-pane fade " id="Status_type" role="tab"  aria-labelledby="Status_type-tab">
                @include('settings.variables.partials.status_type')
            </div>

            <div class="pt-0 tab-pane fade " id="Document_type" role="tab"  aria-labelledby="Document_type-tab">
                @include('settings.variables.partials.document_type')
            </div>
        </div>
    </section>


@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        let leaveLoad = 0;
        $(document).ready(function() {
            if (leaveLoad == 0) {
                @include('settings.variables.JS_DT.leave_type_js')
                    leaveLoad = 1;
            }
        });


        $('[data-table="award"]').one('click', function (e) {
            @include('settings.variables.JS_DT.award_type_js')
        });

        $('[data-table="warning"]').one('click', function (e) {
            @include('settings.variables.JS_DT.warning_type_js')
        });

        $('[data-table="termination"]').one('click', function (e) {
            @include('settings.variables.JS_DT.termination_type_js')
        });

        $('[data-table="expense"]').one('click', function (e) {
            @include('settings.variables.JS_DT.expense_type_js')
        });

        $('[data-table="status"]').one('click', function (e) {
            @include('settings.variables.JS_DT.status_type_js')
        });

        $('[data-table="document"]').on('click', function (e) {
            @include('settings.variables.JS_DT.document_type_js')
        });
    })(jQuery);
</script>
@endpush
