<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Peoplepro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<style>
    h6 {
        font-size: 100%;
    }

    tbody {
        font-size: 80%;
    }

    .table th, .table td {
        border: 1px solid #000;
        font-size: smaller;
    }
</style>

<body>
<h5>HR1</h5>
<h6>22,westwood</h6>
<h6>Boston,Canada-7678</h6>
<h6>Phone: 54324| Email: omega@gmail.com</h6>
<hr>

<div class="center">
    <h4>Payslip: March-2021</h4>
</div>
<hr>
<div class="table-responsive">
    <table class="table  table-bordered">
        <tbody>
        <tr>
            <td><strong class="help-split">{{__('Employee ID')}}: </strong>neo22</td>
            <td><strong class="help-split">{{__('Employee Name')}}: </strong>Neo Dezhi</td>
            <td><strong class="help-split">{{__('Payslip NO')}}: </strong>151</td>
        </tr>
        <tr>
            <td><strong class="help-split">Phone: </strong>67278232</td>
            <td><strong class="help-split">{{__('Joining Date')}}: </strong>2020/07/01</td>
            <td><strong class="help-split">{{__('Payslip Type')}}: </strong>Hourly</td>

        </tr>
        <tr>
            <td><strong class="help-split">Company: </strong>HR</td>
            <td><strong class="help-split">Department: </strong>Finance
            </td>
            <td><strong class="help-split">Designation:: </strong>Finance Manager
            </td>
        </tr>
        </tbody>
    </table>
</div>

<hr>


<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table  table-bordered">

            <thead>
            <tr>
                <th colspan="2">Earnings</th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
            </thead>

            <tr>
                <td class="py-3"><strong>{{__('Basic Salary')}} ({{__('Total')}})</strong></td>
                    <td>1800</td>
            </tr>
            {{-- @if($allowances)
                @foreach($allowances as $allowance)
                    <tr>
                        <td class="py-3"><strong>{{$allowance['allowance_title']}}</strong></td>
                        <td>{{$allowance['allowance_amount']}}</td>
                    </tr>
                    @php
                        $total_earnings = $total_earnings + $allowance['allowance_amount'] ;
                    @endphp
                @endforeach
            @endif

            @if($commissions)
                @foreach($commissions as $commission)
                    <tr>
                        <td class="py-3"><strong>{{$commission['commission_title']}}</strong></td>
                        <td>{{$commission['commission_amount']}}</td>
                    </tr>
                    @php
                        $total_earnings = $total_earnings + $commission['commission_amount'] ;
                    @endphp
                @endforeach
            @endif

            @if($other_payments)
                @foreach($other_payments as $other_payment)
                    <tr>
                        <td class="py-3"><strong>{{$other_payment['other_payment_title']}}</strong></td>
                        <td>{{$other_payment['other_payment_amount']}}</td>
                    </tr>
                    @php
                        $total_earnings = $total_earnings + $other_payment['other_payment_amount'] ;
                    @endphp
                @endforeach
            @endif

            @if($overtimes)
                @foreach($overtimes as $overtime)
                    <tr>
                        <td class="py-3"><strong>{{$overtime['overtime_title']}}</strong></td>
                        <td>{{$overtime['overtime_amount']}}</td>
                    </tr>
                    @php
                        $total_earnings = $total_earnings + $overtime['overtime_amount'] ;
                    @endphp
                @endforeach
            @endif --}}

            <tr>
                <td class="py-3"><strong>Total</strong></td>
                <td id="total_earnings">:$ 2090</td>     
            </tr>


        </table>
    </div>
    <!-- /.col -->
</div>

{{-- <div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table  table-bordered">

            <thead>
            <tr>
                <th colspan="2">{{trans('file.Deductions')}}</th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th>{{trans('file.Description')}}</th>
                <th>{{trans('file.Amount')}}</th>
            </tr>
            </thead>

            @php
                $total_deductions = 0;
            @endphp

            @if($loans)
                @foreach($loans as $loan)
                    <tr>
                        <td class="py-3"><strong>{{$loan['loan_title']}}</strong></td>
                        <td>{{$loan['monthly_payable']}}</td>
                    </tr>
                    @php
                        $total_deductions = $total_deductions + $loan['monthly_payable'] ;
                    @endphp
                @endforeach
            @endif

            @if($deductions)
                @foreach($deductions as $deduction)
                    <tr>
                        <td class="py-3"><strong>{{$deduction['deduction_title']}}</strong></td>
                        <td>{{$deduction['deduction_amount']}}</td>
                    </tr>
                    @php
                        $total_deductions = $total_deductions + $deduction['deduction_amount'] ;
                    @endphp
                @endforeach
            @endif

        </table>
    </div>
</div> --}}
<h4>{{__('Total Paid')}} ::$  <strong>2090</strong></h4>


</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>

