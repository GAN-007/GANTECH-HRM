<div id="leaveModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{__('Add Leave')}}</h5>
                <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                <span id="leave_form_result"></span>
                <form method="post" id="leave_sample_form" class="form-horizontal" >

                    @csrf
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label>{{__('Leave Type')}}</label>
                            <select name="leave_type" id="leave_type" class="form-control selectpicker "
                                    data-live-search="true" data-live-search-style="contains"
                                    title='{{__('Selecting',['key'=>__('Leave Type')])}}...'>
                                @foreach($leave_types as $leave_type)
                                    <option value="{{$leave_type->id}}">{{$leave_type->leave_type}} ({{$leave_type->allocated_day}} Days)</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('file.Company')}}</label>
                                <select name="company_id" id="leave_company_id" class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-dependent="department_name"
                                        title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach
                                        
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('file.Department')}}</label>
                                <select name="department_id"  class="selectpicker form-control department"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title='{{__('Selecting',['key'=>trans('file.Department')])}}...'>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Employee')}}</label>
                            <select name="employee_id"  class="selectpicker form-control employee"
                                    data-live-search="true" data-live-search-style="contains"
                                    title='{{__('Selecting',['key'=>trans('file.Employee')])}}...'>
                            </select>
                        </div>


                        <div class="col-md-6 form-group">
                            <label>{{__('Start Date')}}</label>
                            <input type="text" name="start_date" id="leave_start_date" class="form-control date" value="" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>{{__('End Date')}}</label>
                            <input type="text" name="end_date" id="leave_end_date" class="form-control date" value="" required>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="leave_reason">{{trans('file.Description')}}</label>
                                <textarea class="form-control" id="leave_reason" name="leave_reason" rows="3"></textarea>
                            </div>
                        </div>


                        <div class="col-md-6 form-group">
                            <label for="leave_remarks">{{trans('file.Remarks')}}</label>
                            <textarea class="form-control" id="leave_remarks" name="remarks"
                                      rows="3"></textarea>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="leave_status">{{trans('file.Status')}}</label>
                            <select name="status" id="leave_status" class="form-control selectpicker "
                                    data-live-search="true" data-live-search-style="contains"
                                    title='{{__('Selecting',['key'=>trans('file.Status')])}}...'>
                                <option value="pending">{{trans('file.Pending')}}</option>
                                <option value="first level approval">{{__('First Level Approval')}}</option>
                                <option value="approved">{{trans('file.Approved')}}</option>
                                <option value="rejected">{{trans('file.Rejected')}}</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="is_half" id="leave_is_half" value="1"  >
                                <label for="leave_is_half" class="custom-control-label" >{{__('Half Day')}}</label>

                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="is_notify" id="leave_is_notify" value="1" >
                                <label class="custom-control-label" for="leave_is_notify">{{trans('file.Notification')}}</label>
                            </div>
                        </div>


                        <div class="container">
                            <div class="form-group" align="center">
                                <input type="hidden" name="diff_date_hidden" id="diff_date_hidden"/>
                                <input type="submit" name="action_button" class="btn btn-warning" value={{trans('file.Add')}} />
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

