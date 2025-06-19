<div class="modal fade" id="payment_model" tabindex="-1" role="dialog" aria-labelledby="basicModal"
aria-hidden="true">

<div class="modal-dialog modal-dialog-centered modal-lg">
   <div class="modal-content">
       <div class="modal-header">
           <h4 class="modal-title" id="myModalLabel">{{__('Payment Info')}}--- <span id="payment_month_year_show"></span></h4>
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       </div>
       <div class="modal-body">
           <span id="form_result"></span>
           <form method="get" id="payment_form" class="form-horizontal" >

                  <input type="hidden" name="payslip_type" id="payslip_type_payment">

                  <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           <label for="name">{{__('Basic Salary')}}</label> &nbsp;&nbsp;&nbsp;&nbsp; <span id="payment_type_error"></span>
                           <input type="text" name="basic_salary" id="basic_salary_payment" class="form-control" value="0" readonly="readonly">
                           <input type="hidden" value="0" name="month_year" id="hidden_month_year">
                           <input type="hidden" value="" name="employee_id" id="employee_id">
                       </div>
                   </div>

                      <div class="col-md-6 hide-element">
                          <div class="form-group">
                              <label for="worked_hours">{{__('Total Hours(This Month)')}}</label>
                              <input type="text" readonly="readonly" name="worked_hours" id="worked_hours" class="form-control" value="0">
                          </div>
                      </div>

                      <div class="col-md-6 hide-element">
                          <div class="form-group">
                              <label for="worked_amount">{{__('Amount')}}</label> <a href="#" data-toggle="popover" data-placement="top" data-content="If you don't set this month's amount, the last month's amount will be treated as this month"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></a>
                              <input type="text" readonly="readonly" name="worked_amount" id="worked_amount" class="form-control" value="0">
                          </div>
                      </div>

                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="name">{{__('Total Allowance')}}</label> <a href="#" data-toggle="popover" data-placement="top" data-content="If you don't set this month's amount, the last month's amount will be treated as this month"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></a>
                           <input type="text" name="total_allowance" id="total_allowance_payment" class="form-control" value="0" readonly="readonly">
                       </div>
                   </div>


                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="name">{{trans('Commissions')}}</label> <a href="#" data-toggle="popover" data-placement="top" data-content="If you don't set this month's amount, 0 amount will be treated as this month"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></a>
                           <input type="text" name="total_commission" id="total_commission_payment" class="form-control" value="0" readonly="readonly">
                       </div>
                   </div>

                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="name">{{__('Total Overtime')}}</label> <a href="#" data-toggle="popover" data-placement="top" data-content="If you don't set this month's amount, 0 amount will be treated as this month"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></a>
                           <input type="text" name="total_overtime" id="total_overtime_payment" class="form-control" value="0" readonly="readonly">
                       </div>
                   </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">{{__('Other Payment')}}</label> <a href="#" data-toggle="popover" data-placement="top" data-content="If you don't set this month's amount, 0 amount will be treated as this month"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></a>
                              <input type="text" name="total_other_payment" id="total_other_payment_payment" class="form-control" value="0" readonly="readonly">
                          </div>
                      </div>

                      <div class="col-md-6">
                       <div class="form-group">
                           <label for="name">{{__('Statutory deductions')}}</label> <a href="#" data-toggle="popover" data-placement="top" data-content="If you don't set this month's amount, the last month's amount will be treated as this month"><i class="fa fa-exclamation-circle text-warning" aria-hidden="true"></i></a>
                           <input type="text" name="total_deduction" id="total_deduction_payment" class="form-control" value="0" readonly="readonly">
                       </div>
                   </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">{{__('Monthly Payable')}}</label>
                              <input type="text" name="monthly_payable" id="monthly_payable" class="form-control" value="0" readonly="readonly">
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">{{__('Loan Remaining')}}</label>
                              <input type="text" name="amount_remaining" id="amount_remaining" class="form-control" value="0" readonly="readonly">
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">{{__('Pension Amount')}}</label>
                              <input type="text" name="pension_amount" id="pension_amount_payment" class="form-control" value="0" readonly="readonly">
                          </div>
                      </div>



                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="name">{{__('Net Salary')}}</label>
                           <input type="text" readonly="readonly" name="net_salary" id="net_salary_payment" class="form-control" value="0">
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="name">{{__('Payment Amount')}}</label>
                           <input type="text" readonly="readonly" name="payment_amount" id="total_salary_payment" class="form-control" >
                       </div>
                   </div>

                   <div class="col-md-12">
                       <div class="form-group">
                           <span><strong>{{trans('file.NOTE')}}:</strong> {{__('Total Allowance,Commissions,Total Loan,Total Overtime,Statutory deductions,Other Payment, Pension are not editable.')}}</span>
                       </div>
                   </div>

               <div class="form-actions"> <button  type="submit" class="btn btn-primary"><i class="fa fa fa-check-square-o"></i> {{trans('file.Pay')}}</button>
               </div>
                  </div>
           </form>
       </div>
   </div>
</div>
</div>


@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).on('click', '.generate_payment', function (event) {
            event.preventDefault();
            //individual salary id from pay_list table
            let id = $(this).attr('id');
            $('#payment_month_year_show').html($('#month_year').val());
            let filter_month_year = $('#month_year').val();

            //target contains payslip.show
            // let target = '{{route('paySlip.index')}}/generate/' + id;
            let target = '{{route('paySlip.generate')}}';

            $.ajax({
                url: target,
                // dataType: "json",
                type: "GET",
                data: {id:id, filter_month_year:filter_month_year},
                success: function (result) {
                    console.log(result.data.total_salary);
                    if (result.data.payslip_type == 'Hourly') {
                        $('.hide-element').show();
                        $('#worked_hours').val(result.data.total_hours);
                        $('#worked_amount').val(result.data.worked_amount);
                    }
                    else
                    {
                        $('.hide-element').hide();
                        $('#worked_hours').val('');
                        $('#worked_amount').val('');
                    }
                    $('#payslip_type_payment').val(result.data.payslip_type);
                    $('#basic_salary_payment').val(result.data.basic_salary);
                    $('#total_allowance_payment').val(result.data.total_allowance);
                    $('#total_commission_payment').val(result.data.total_commission);
                    $('#monthly_payable').val(result.data.monthly_payable);
                    $('#amount_remaining').val(result.data.amount_remaining);
                    $('#total_deduction_payment').val(result.data.total_deduction);
                    $('#total_other_payment_payment').val(result.data.total_other_payment);
                    $('#total_overtime_payment').val(result.data.total_overtime);
                    $('#total_salary_payment').val(result.data.total_salary);
                    $('#net_salary_payment').val(result.data.total_salary);
                    $('#pension_amount_payment').val(result.data.pension_amount);
                    $('#employee_id').val(result.data.employee);
                    $('#payment_model').modal('show');
                }
            });
        });

    })(jQuery);
</script>
@endpush
