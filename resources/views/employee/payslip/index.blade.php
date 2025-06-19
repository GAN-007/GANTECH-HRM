<div class="row">    
    <div class="table-responsive">
        <table id="employee_payslip-table" class="table ">
            <thead>
            <tr>
                <th>{{__('Net Salary')}}</th>
                <th>{{__('Salary Month')}}</th>
                <th>{{__('Payroll Date')}}</th>
                <th>{{trans('file.Status')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>
</div>

<div class="modal fade" id="salary_model" tabindex="-1" role="dialog" aria-labelledby="basicModal"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
   <div class="modal-content">
       <div class="modal-header">
           <h4 class="modal-title" id="myModalLabel">{{__('Salary Info')}}</h4>
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       </div>
       <div class="modal-body">
           <div class="row">
               <div class="col-md-12">
                   <div class="d-flex">
                       <div id="employee_pp"></div>
                       <div class="ml-3">
                           <div class="h3 text-bold d-inline" id="employee_full_name"></div> (<span id="employee_username"></span>)
                           <p class="text-gray" id="employee_designation"></p>
                           <a id="employee_id" href="">{{ __('View Profile') }}</a>
                       </div>
                   </div>
               </div>
               <div class="col-md-12">
                   <h3 class="mt-5">{{__('Salary Details')}}</h3>
                   <hr>
                   <div class="card-block">
                       <div id="accordion">
                           <div class="card mb-2">
                               <div class="card-header"> <a class="text-dark" data-toggle="collapse" href="#basic_salary" aria-expanded="true"> <strong><span id="payslip_type"></span></strong> </a> </div>
                               <div id="basic_salary" class="collapse in" data-parent="#accordion" aria-expanded="true">
                                   <div class="card-body">
                                       <div class="table-responsive" data-pattern="priority-columns">
                                           <table class="table table-striped table-bordered dataTable no-footer">
                                               <tbody>
                                               <tr>
                                                   <td><strong><span id="monthly_hourly"></span>:</strong><span class="pull-right" id="basic_salary_amount"></span></td>
                                                   <td class="hide-div"><strong><span id="hours_worked"></span>:</strong> <span class="pull-right" id="total_hours_worked"></span></td>
                                                   <td class="hide-div"><strong><span id="hours_worked_amount"></span>:</strong> <span class="pull-right" id="total_hours_worked_amount"></span></td>
                                               </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <div class="card mb-2">
                               <div class="card-header"> <a class="text-dark" data-toggle="collapse" href="#pension" aria-expanded="true"> <strong>{{__('Pension')}}</strong></a> </div>
                               <div id="pension" class="collapse in" data-parent="#accordion" aria-expanded="true">
                                   <div class="card-body">
                                       <div class="table-responsive" data-pattern="priority-columns">
                                           <table class="table table-striped table-bordered dataTable no-footer">
                                               <tbody>
                                                   <tr>
                                                       <td><strong>{{__('Pension Type')}}</span>:</strong><span class="pull-right" id="pension_type"></span></td>
                                                   </tr>
                                                   <tr>
                                                       <td><strong>{{__('Pension Amount')}}</span>:</strong><span class="pull-right" id="pension_amount"></span></td>
                                                   </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="card mb-2">
                               <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_allowances" aria-expanded="false"> <strong>{{trans('file.Allowances')}}</strong></a> </div>
                               <div id="set_allowances" class="collapse" data-parent="#accordion">
                                   <div class="box-body">
                                       <div class="table-responsive" data-pattern="priority-columns">
                                           <table class="table table-striped table-bordered dataTable no-footer">
                                               <tbody>
                                               <tr id="allowance_info"></tr>
                                               <tr>
                                                   <td><strong>{{trans('file.Total')}}:</strong> <span id="total_allowance" class="pull-right"></span></td>
                                               </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="card mb-2">
                               <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_commissions" aria-expanded="false"> <strong>{{trans('file.Commissions')}}</strong></a> </div>
                               <div id="set_commissions" class="collapse" data-parent="#accordion">
                                   <div class="box-body">
                                       <div class="table-responsive" data-pattern="priority-columns">
                                           <table class="table table-striped table-bordered dataTable no-footer">
                                               <tbody>
                                               <tr id="commission_info"></tr>
                                               <tr>
                                                   <td><strong>{{trans('file.Total')}}:</strong> <span id="total_commission" class="pull-right"></span></td>
                                               </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="card  mb-2">
                               <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_loan_deductions" aria-expanded="false"> <strong>{{trans('file.Loan')}}</strong> </a> </div>
                               <div id="set_loan_deductions" class="collapse" data-parent="#accordion">
                                   <div class="box-body">
                                       <div class="table-responsive" data-pattern="priority-columns">
                                           <table class="table table-striped table-bordered dataTable no-footer">
                                               <tbody>
                                               <tr id="loan_info">

                                               </tr>
                                               <tr>
                                                   <td><strong>{{trans('file.Total')}}:</strong> <span id="total_loan"  class="pull-right"></span></td>
                                               </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="card mb-2">
                               <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#statutory_deductions" aria-expanded="false"> <strong>{{__('Statutory deductions')}}</strong></a> </div>
                               <div id="statutory_deductions" class="collapse" data-parent="#accordion">
                                   <div class="box-body">
                                       <div class="table-responsive" data-pattern="priority-columns">
                                           <table class="table table-striped table-bordered dataTable no-footer">
                                               <tbody>
                                               <tr id="deduction_info"></tr>
                                               <tr>
                                                   <td><strong>{{trans('file.Total')}}:</strong> <span id="total_deduction" class="pull-right"></span></td>
                                               </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <div class="card mb-2">
                               <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#set_other_payments" aria-expanded="false"> <strong>{{__('Other Payment')}}</strong></a> </div>
                               <div id="set_other_payments" class="collapse" data-parent="#accordion">
                                   <div class="box-body">
                                       <div class="table-responsive" data-pattern="priority-columns">
                                           <table class="table table-striped table-bordered dataTable no-footer">
                                               <tbody>
                                               <tr id="other_payment_info"></tr>
                                               <tr>
                                                   <td><strong>{{trans('file.Total')}}:</strong> <span id="total_other_payment" class="pull-right"></span></td>
                                               </tr>
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <div class="card mb-2">
                               <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#overtime" aria-expanded="false"> <strong>{{trans('file.Overtime')}}</strong></a>  </div>
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
                                               </tr>
                                               </thead>
                                               <tbody id="overtime_info">
                                               </tbody>
                                               <tfoot>
                                               <tr>
                                                   <td colspan="4" align="right"><strong>{{trans('file.Total')}}:</strong></td>
                                                   <td id="total_overtime"></td>
                                               </tr>
                                               </tfoot>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="card-header"> <strong class="text-dark">{{__('Net Salary')}}</strong> <strong class="float-right" id="total_salary"></strong></div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.Close')}}</button>
   </div>
</div>
</div>
