<div class="row">
    <div class="col-md-3">
        @can('view-details-employee')
            <ul class="nav nav-tabs vertical" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="salary-tab" data-toggle="tab" href="#Salary" role="tab"
                       aria-controls="Salary" aria-selected="true">{{__('Basic Salary')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('salary_allowance.show',$employee)}}" id="salary_allowance-tab"
                       data-toggle="tab" data-table="salary_allowance" data-target="#Salary_allowance" role="tab"
                       aria-controls="Salary_allowance" aria-selected="false">{{trans('file.Allowances')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('salary_commission.show',$employee)}}" id="salary_commission-tab"
                       data-toggle="tab" data-table="salary_commission" data-target="#Salary_commission" role="tab"
                       aria-controls="Salary_commission" aria-selected="false">{{trans('file.Commissions')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('salary_loan.show',$employee)}}" id="salary_loan-tab"
                       data-toggle="tab" data-table="salary_loan" data-target="#Salary_loan" role="tab"
                       aria-controls="Salary_loan" aria-selected="false">{{trans('file.Loan')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('salary_deduction.show',$employee)}}" id="salary_deduction-tab"
                       data-toggle="tab" data-table="salary_deduction" data-target="#Salary_deduction" role="tab"
                       aria-controls="Salary_deduction" aria-selected="false">{{__('Statutory Deductions')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('other_payment.show',$employee)}}" id="other_payment-tab"
                       data-toggle="tab" data-table="other_payment" data-target="#Other_payment" role="tab"
                       aria-controls="Other_payment" aria-selected="false">{{__('Other Payment')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('salary_overtime.show',$employee)}}" id="salary_overtime-tab"
                       data-toggle="tab" data-table="salary_overtime" data-target="#Salary_overtime" role="tab"
                       aria-controls="Salary_overtime" aria-selected="false">{{__('Overtime')}}</a>
                </li>

                <!-- New -->
                <li class="nav-item">
                    <a class="nav-link" href="#" id="salary_pension-tab"
                        data-toggle="tab" data-table="salary_pension" data-target="#salary_pension" role="tab"
                        aria-controls="salary_pension" aria-selected="true">{{__('Salary Pension')}}
                    </a>
                </li>
                <!--/ New -->
            </ul>
        @endcan
    </div>

    <div class="col-md-9">
        <div class="tab-content" id="myTabContent">
            @can('set-salary')
            <div class="tab-pane fade show active" id="Salary" role="tabpanel" aria-labelledby="salary-tab">
                {{__('All Basic Salary')}}
                <hr>
                @include('employee.salary.basic.index')
            </div>
            @endcan

            <!-- New Pension-->
            <div class="tab-pane fade" id="salary_pension" role="tabpanel" aria-labelledby="salary_pension-tab">
                <!--Contents for Basic starts here-->
                {{trans('file.Update')}} {{__('Pension')}}

                <div class="modal-body">
                    <span id="pension_form_result"></span>
                    <form method="post" id="salary_pension_form" class="form-horizontal" autocomplete="off">

                        @csrf
                        <div class="row">

                            <div class="col-md-4 form-group">
                                <label>{{__('Pension Type')}}</label>
                                <input type="hidden" name="pension_type_hidden" value="{{ $employee->pension_type ?? '' }}"/>
                                <select name="pension_type" id="pension_type" required class="selectpicker form-control"  title="{{__('Selecting',['key'=>__('Pension Type')])}}...">
                                    <option value="fixed" @if($employee->pension_type=='fixed') selected @endif>{{__('Fixed')}}</option>
                                    <option value="percentage" @if($employee->pension_type=='percentage') selected @endif>{{__('Percentage')}}</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                @if(config('variable.currency_format')=='suffix')
                                    <label>{{__('Amount')}} ({{config('variable.currency')}})</label>
                                @else
                                    <label>({{config('variable.currency')}}) {{__('Amount')}}</label>
                                @endif
                                <input type="text" min="0" name="pension_amount" id="pension_amount" placeholder="{{__('Amount')}}" required class="form-control" value="{{ $employee->pension_amount ?? '' }}">
                            </div>
                        </div>

                        <div class="container mt-5px">
                            <span class="text-danger"></span> <br><br>
                            <div class="form-group">
                                <input type="submit" class="btn btn-warning" value={{trans('file.Add')}} />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ New Pension -->



            <div class="tab-pane fade" id="Salary_allowance" role="tabpanel" aria-labelledby="salary_allowance-tab">
                {{__('All allowances')}}
                <hr>
                @include('employee.salary.allowance.index')
            </div>

            <div class="tab-pane fade" id="Salary_commission" role="tabpanel" aria-labelledby="Salary_commission-tab">
                {{__('All commission')}}
                <hr>

                @include('employee.salary.commission.index')

            </div>

            <div class="tab-pane fade" id="Salary_loan" role="tabpanel" aria-labelledby="Salary_loan-tab">
                {{__('All Loan')}}
                <hr>

                @include('employee.salary.loan.index')

            </div>


            <div class="tab-pane fade" id="Salary_deduction" role="tabpanel" aria-labelledby="Salary_deduction-tab">
                {{__('All Statutory Deduction')}}
                <hr>

                @include('employee.salary.deduction.index')
            </div>
            <div class="tab-pane fade" id="Other_payment" role="tabpanel" aria-labelledby="Other_payment-tab">
                {{__('Other Payment')}}
                <hr>

                @include('employee.salary.other_payment.index')
            </div>
            <div class="tab-pane fade" id="Salary_overtime" role="tabpanel" aria-labelledby="Salary_overtime-tab">
                {{__('Overtime')}}
                <hr>
                @include('employee.salary.overtime.index')
            </div>
        </div>
    </div>
</div>

<script>
$('select[name="payslip_type"]').val($('input[name="payslip_type_hidden"]').val());
</script>

