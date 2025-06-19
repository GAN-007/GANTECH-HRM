@extends('layout.main')
@section('content')


    <section>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-2">
                        <div class="card-header d-flex justify-content-between">
                            <h2 class="card-title">{{__('Payslip')}} <span class="text-grey text-small">({{$payslip->month_year}})</span>
                            </h2>
                            <div class="pull-right"><a href="{{route('payslip.pdf',$payslip->payslip_key)}}"
                                                       class="btn btn-default btn-sm" data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="Download Payslip"><i
                                            class="fa fa-file-pdf-o"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between collapse-head" data-toggle="collapse"
                                 href="#collapseExample" role="button" aria-expanded="true"
                                 aria-controls="collapseExample">
                                <div>
                                    @if(!empty($employee->user()->profile_photo))
                                        <img class="profile-photo sm mr-1"
                                             src="{{ asset('uploads/profile_photos/')}}/{{$employee->user()->profile_photo}}">
                                    @else
                                        <img class="profile-photo sm mr-1"
                                             src="{{ asset('uploads/profile_photos/avatar.jpg')}}">
                                    @endif
                                    {{$employee->full_name}} ({{$employee->user->username ?? ''}})
                                </div>
                                <small class="show btn-light btn-sm" disabled><i class="dripicons-chevron-up"></i>
                                </small>
                            </div>
                            <div class="collapse show" id="collapseExample">
                                <div class="table-responsive">
                                    <table class="table  table-bordered dataTable no-footer">
                                        <tbody>
                                        <tr>
                                            <td><strong class="help-split">{{__('Payslip No.')}}
                                                    : </strong>{{$payslip->id}}</td>
                                            <td><strong class="help-split">{{__('Joining Date')}}
                                                    : </strong>{{$employee->joining_date}}</td>
                                            <td><strong class="help-split">{{trans('file.Phone')}}
                                                    : </strong>{{$employee->contact_no}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong class="help-split">{{trans('file.Designation')}}
                                                    : </strong>{{$employee->designation->designation_name}}</td>
                                            <td><strong class="help-split">{{trans('file.Department')}}
                                                    : </strong>{{$employee->department->department_name}}</td>
                                            <td><strong class="help-split">{{trans('file.Company')}}
                                                    : </strong>{{$employee->company->company_name}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            (function ($) {
                                "use strict";
                                $('.collapse-head').on('click', function () {
                                    if ($(this).attr('aria-expanded') == "true") {
                                        $(this + ' .show').html('<i class="dripicons-chevron-down"></i>');
                                    } else {
                                        $(this + ' .show').html('<i class="dripicons-chevron-up"></i>');
                                    }
                                })
                            })(jQuery);
                        </script>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title"> {{__('Payment Details')}} ( {{$payslip->payment_type}} ) </h3>
                        </div>
                        <div id="accordion">
                            <div class="card mb-2">
                                <div class="card-header"><a class="text-dark d-block" data-toggle="collapse"
                                                            href="#basic_salary" aria-expanded="true">
                                        <strong>{{__('Basic Salary')}}</strong> </a></div>
                                <div id="basic_salary" class="collapse in" data-parent="#accordion"
                                     aria-expanded="true">
                                    <div class="table-responsive">
                                        <table class="table  table-bordered dataTable no-footer">
                                            <tbody>
                                            <tr>
                                                @if($payslip->payment_type == 'Hourly')
                                                    <td><strong>{{__('Per Hour Salary')}}:</strong> <span
                                                                class="pull-right">{{$payslip->basic_salary}}</span>
                                                    </td>
                                                    <td>
                                                        <strong>{{__('Total Hours Worked This Month')}}:</strong><span
                                                                class="pull-right">{{$total_hours}}</span>
                                                    </td>
                                                    <td>
                                                        <strong>{{__('Amount')}}:</strong><span
                                                                class="pull-right">{{$amount_hours}}</span>
                                                    </td>
                                                @else
                                                    <td><strong>{{__('Basic Salary')}}:</strong> <span
                                                                class="pull-right">{{$payslip->basic_salary}}</span>
                                                    </td>
                                                    <td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @if($payslip->allowances)
                                <div class="card mb-2">
                                    <div class="card-header"><a class="text-dark collapsed d-block"
                                                                data-toggle="collapse" href="#set_allowances"
                                                                aria-expanded="false">
                                            <strong>{{trans('file.Allowances')}}</strong> </a></div>
                                    <div id="set_allowances" class="collapse" data-parent="#accordion">
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table  table-bordered dataTable no-footer">
                                                    <tbody>
                                                    @php
                                                        $allowance_total = 0;
                                                    @endphp
                                                    @foreach($payslip->allowances as $allowance)
                                                        <tr>
                                                            <td><strong>{{$allowance['allowance_title']}}:</strong>
                                                                <span class="pull-right">{{$allowance['allowance_amount']}}</span>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $allowance_total += $allowance['allowance_amount']
                                                        @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td><strong>{{trans('file.Total')}}:</strong> <span
                                                                    class="pull-right">{{$allowance_total}}</span></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($payslip->commissions)
                                <div class="card mb-2">
                                    <div class="card-header"><a class="text-dark collapsed d-block"
                                                                data-toggle="collapse" href="#set_commissions"
                                                                aria-expanded="false">
                                            <strong>{{trans('file.Commissions')}}</strong> </a></div>
                                    <div id="set_commissions" class="collapse" data-parent="#accordion">
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table  table-bordered dataTable no-footer">
                                                    <tbody>
                                                    @php
                                                        $commission_total = 0;
                                                    @endphp
                                                    @foreach($payslip->commissions as $commission)
                                                        <tr>
                                                            <td><strong>{{$commission['commission_title']}}:</strong>
                                                                <span class="pull-right">{{$commission['commission_amount']}}</span>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $commission_total += $commission['commission_amount']
                                                        @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td><strong>{{trans('file.Total')}}:</strong> <span
                                                                    class="pull-right">{{$commission_total}}</span></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($payslip->loans)
                                <div class="card  mb-2">
                                    <div class="card-header"><a class="text-dark collapsed d-block"
                                                                data-toggle="collapse" href="#set_loan_deductions"
                                                                aria-expanded="false">
                                            <strong>{{trans('file.Loan')}}</strong> </a></div>
                                    <div id="set_loan_deductions" class="collapse" data-parent="#accordion">
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table  table-bordered dataTable no-footer">
                                                    <tbody>
                                                    @php
                                                        $loan_total=0;
                                                    @endphp
                                                    @foreach($payslip->loans as $loan)
                                                        <tr>
                                                            <td><strong>{{__('Loan Amount')}}:</strong> <span
                                                                        class="pull-right">{{$loan['loan_amount']}}</span>
                                                            </td>
                                                            <td><strong>{{__('Monthly Payable')}}:</strong> <span
                                                                        class="pull-right">{{$loan['monthly_payable']}}</span>
                                                            </td>
                                                            <td><strong>{{__('Amount Remaining')}}:</strong> <span
                                                                        class="pull-right">{{$loan['amount_remaining']}}</span>
                                                            </td>
                                                            <td><strong>{{__('Installment Remaining')}}:</strong> <span
                                                                        class="pull-right">{{$loan['time_remaining']}}</span>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $loan_total += $loan['monthly_payable']
                                                        @endphp
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($payslip->deductions)
                                <div class="card mb-2">
                                    <div class="card-header"><a class="text-dark collapsed d-block"
                                                                data-toggle="collapse" href="#statutory_deductions"
                                                                aria-expanded="false">
                                            <strong>{{__('Statutory deductions')}}</strong> </a></div>
                                    <div id="statutory_deductions" class="collapse" data-parent="#accordion">
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table  table-bordered dataTable no-footer">
                                                    <tbody>
                                                    @php
                                                        $deduction_total = 0.00;
                                                    @endphp
                                                    @foreach($payslip->deductions as $deduction)
                                                        <tr>
                                                            <td><strong>{{$deduction['deduction_title']}}:</strong>
                                                                <span class="pull-right">{{$deduction['deduction_amount']}}</span>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $deduction_total += $deduction['deduction_amount']
                                                        @endphp

                                                    @endforeach
                                                    <tr>
                                                        <td><strong>{{trans('file.Total')}}:</strong> <span
                                                                    class="pull-right">{{$deduction_total}}</span></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($payslip->other_payments)
                                <div class="card mb-2">
                                    <div class="card-header"><a class="text-dark collapsed d-block"
                                                                data-toggle="collapse" href="#set_other_payments"
                                                                aria-expanded="false">
                                            <strong>{{__('Other Payment')}}</strong> </a></div>
                                    <div id="set_other_payments" class="collapse" data-parent="#accordion">
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table  table-bordered dataTable no-footer">
                                                    <tbody>
                                                    @php
                                                        $other_payment_total = 0;
                                                    @endphp
                                                    @foreach($payslip->other_payments as $other_payment)
                                                        <tr>
                                                            <td><strong>{{$other_payment['other_payment_title']}}
                                                                    :</strong> <span
                                                                        class="pull-right">{{$other_payment['other_payment_amount']}}</span>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $other_payment_total += $other_payment['other_payment_amount']
                                                        @endphp
                                                    @endforeach
                                                    <tr>
                                                        <td><strong>{{trans('file.Total')}}:</strong> <span
                                                                    class="pull-right">{{$other_payment_total}}</span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="card mb-2">
                                <div class="card-header"><a class="text-dark collapsed d-block"
                                                            data-toggle="collapse" href="#set_annual_leave_info"
                                                            aria-expanded="false">
                                        <strong>{{__('Annual Leave Info')}} (Year - {{date('Y')}})</strong> </a></div>
                                <div id="set_annual_leave_info" class="collapse" data-parent="#accordion">
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered dataTable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th>Leave Type</th>
                                                        <th>Allocated Day</th>
                                                        <th>Remaining Day</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($leaveTypeUnserialize as $item)
                                                        <tr>
                                                            <td> {{ $item['leave_type'] }} </td>
                                                            <td> {{ $item['allocated_day'] }} </td>
                                                            <td> {{ $item['remaining_allocated_day'] }} </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-danger">No Data Found</td>
                                                            <td></td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                {{-- <tbody>
                                                    <tr>
                                                        <td><strong>{{__('Total Annual Leave')}}
                                                                :</strong> <span
                                                                    class="pull-right">{{$employee->total_leave}}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>{{__('Reamaining Leave')}}:</strong> <span
                                                                    class="pull-right">{{$employee->remaining_leave}}</span>
                                                        </td>
                                                    </tr>
                                                </tbody> --}}
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($payslip->overtimes)
                                <div class="card mb-2">
                                    <div class="card-header"><a class="text-dark collapsed d-block"
                                                                data-toggle="collapse" href="#overtime"
                                                                aria-expanded="false">
                                            <strong>{{trans('file.Overtime')}}</strong> </a></div>
                                    <div id="overtime" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{__('Overtime Title')}}</th>
                                                        <th>{{__('Number of days')}}</th>
                                                        <th>{{trans('file.Hours')}}</th>
                                                        <th>{{trans('file.Rate')}}</th>
                                                        <th>{{trans('file.Amount')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $overtime_total = 0;
                                                    @endphp
                                                    @foreach($payslip->overtimes as $overtime)
                                                        <tr>
                                                            <td><strong>{{$loop->iteration}}</strong></td>
                                                            <td><strong>{{$overtime['overtime_title']}}</strong></td>
                                                            <td><strong>{{$overtime['no_of_days']}}</strong></td>
                                                            <td><strong>{{$overtime['overtime_hours']}}</strong></td>
                                                            <td><strong>{{$overtime['overtime_rate']}}</strong></td>
                                                            <td><strong>{{$overtime['overtime_amount']}}</strong></td>
                                                        </tr>
                                                        @php
                                                            $overtime_total += $overtime['overtime_amount']
                                                        @endphp
                                                    @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="5" align="right"><strong>{{trans('file.Total')}}
                                                                :</strong></td>
                                                        <td>{{$overtime_total}}</td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header with-border">
                                    <h3 class="card-title"> {{trans('file.Details')}} </h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table no-footer mt-0">
                                            <tbody>
                                            <tr>
                                                @if($payslip->payment_type == 'Hourly')
                                                    <td><strong>{{__('Basic Salary')}} ({{__('Total')}}):</strong> <span
                                                                class="pull-right">{{$amount_hours}}</span>
                                                    </td>
                                                @else
                                                    <td><strong>{{__('Basic Salary')}}:</strong> <span
                                                                class="pull-right">{{$payslip->basic_salary}}</span>
                                                    </td>
                                                @endif
                                            </tr>
                                            @isset($allowance_total)
                                                <tr>
                                                    <td><strong>Total Allowance:</strong> <span
                                                                class="pull-right">{{$allowance_total ?? 0.00}}</span>
                                                    </td>
                                                </tr>
                                            @endisset
                                            @isset($commission_total )
                                                <tr>
                                                    <td><strong>Total Commission:</strong> <span
                                                                class="pull-right">{{$commission_total ?? 0.00}}</span>
                                                    </td>
                                                </tr>
                                            @endisset
                                            @isset($payslip->pension_amount )
                                                <tr>
                                                    <td><strong>Pension Amount:</strong> <span
                                                                class="pull-right">{{$payslip->pension_amount ?? 0.00}}</span>
                                                    </td>
                                                </tr>
                                            @endisset
                                            @isset($loan_total)
                                                <tr>
                                                    <td><strong>Monthly Payable :</strong> <span
                                                                class="pull-right">{{$loan_total ?? 0.00}}</span></td>
                                                </tr>
                                            @endisset
                                            @isset($deduction_total)
                                                <tr>
                                                    <td><strong>Total Deduction:</strong> <span
                                                                class="pull-right">{{$deduction_total ?? 0.00}}</span>
                                                    </td>
                                                </tr>
                                            @endisset
                                            @isset($other_payment_total)
                                                <tr>
                                                    <td><strong>Total Other Payment:</strong> <span
                                                                class="pull-right">{{$other_payment_total ?? 0.00}}</span>
                                                    </td>
                                                </tr>
                                            @endisset
                                            @isset($overtime_total)
                                                <tr>
                                                    <td><strong>Total Overtime:</strong> <span
                                                                class="pull-right">{{$overtime_total ?? 0.00}}</span>
                                                    </td>
                                                </tr>
                                            @endisset
                                            </tbody>
                                            <tfooter>
                                                <tr>
                                                    @if(config('variable.currency_format') =='suffix')
                                                        <th class="text-dark"><strong>Paid Amount:</strong> <span
                                                                    class="pull-right">{{number_format($payslip->net_salary, 2, '.', '')}} {{config('variable.currency')}}</span>
                                                        </th>
                                                    @else
                                                        <th class="text-dark"><strong>Paid Amount:</strong> <span
                                                                    class="pull-right">{{config('variable.currency')}} {{number_format($payslip->net_salary, 2, '.', '')}}</span>
                                                        </th>
                                                    @endif

                                                </tr>
                                            </tfooter>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
