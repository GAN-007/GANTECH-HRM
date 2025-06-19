<div class="row">    
    <div class="table-responsive">
        <table id="employee_warning-table" class="table ">
            <thead>
            <tr>
                <th>{{trans('file.Subject')}}</th>
                <th>{{__('Warning Date')}}</th>
                <th>{{trans('file.Status')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>
</div>
<div class="modal fade" id="employee_warning_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('Complaint Info')}}</h4>
                <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">

                            <table class="table  table-bordered">

                                <tr>
                                    <th>{{trans('file.Company')}}</th>
                                    <td id="warning_company_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Warning To')}}</th>
                                    <td id="warning_warning_to_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Warning Type')}}</th>
                                    <td id="warning_warning_type_id"></td>
                                </tr>


                                <tr>
                                    <th>{{trans('file.subject')}}</th>
                                    <td id="warning_subject_id"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Description')}}</th>
                                    <td id="warning_description_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Warning Date')}}</th>
                                    <td id="warning_warning_date_id"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Status')}}</th>
                                    <td id="warning_status_id"></td>
                                </tr>

                            </table>

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





