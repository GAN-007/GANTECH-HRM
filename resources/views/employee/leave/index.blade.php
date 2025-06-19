<div class="row">
    <div class="table-responsive">
        <table id="employee_leave-table" class="table ">
            <thead>
            <tr>
                <th>{{__('Leave Type')}}</th>
                <th>{{trans('file.Department')}}</th>
                <th>{{trans('file.Duration')}}</th>
                <th>{{__('Applied Date')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>
</div>
<div class="modal fade" id="leave_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"
     style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('Leave Info')}}</h4>
                <button type="button" class="leave-close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">

                            <table class="table  table-bordered">

                                <tr>
                                    <th>{{trans('file.Company')}}</th>
                                    <td id="leave_company_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Leave For')}}</th>
                                    <td id="leave_employee_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Department')}}</th>
                                    <td id="leave_department_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Leave Type')}}</th>
                                    <td id="leave_leave_type_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Leave Reason')}}</th>
                                    <td id="leave_leave_reason_id"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Remarks')}}</th>
                                    <td id="leave_remarks_id"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Status')}}</th>
                                    <td id="leave_status_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Start Date')}}</th>
                                    <td id="leave_start_date_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('End Date')}}</th>
                                    <td id="leave_end_date_id"></td>
                                </tr>


                                <tr>
                                    <th>{{__('Applied Date')}}</th>
                                    <td id="leave_applied_date_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Total Days')}}</th>
                                    <td id="leave_total_days_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Half Day')}}</th>
                                    <td id="leave_is_half_id"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Notification')}}</th>
                                    <td id="leave_is_notify_id"></td>
                                </tr>

                            </table>

                        </div>

                    </div>
                </div>


            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default " data-dismiss="modal">{{trans('file.Close')}}</button>

        </div>
    </div>
</div>
