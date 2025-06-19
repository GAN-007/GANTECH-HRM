<div class="row">    
    <div class="table-responsive">
        <table id="employee_transfer-table" class="table ">
            <thead>
            <tr>
                <th>{{__('From Department')}}</th>
                <th>{{__('To Department')}}</th>
                <th>{{trans('file.Company')}}</th>
                <th>{{trans('file.Date')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>
</div>
<div class="modal fade" id="employee_transfer_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('Transfer Info')}}</h4>
                <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <span id="transfer_transfer_photo_id"></span>

                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">

                            <table class="table  table-bordered">

                                <tr>
                                    <th>{{trans('file.Company')}}</th>
                                    <td id="transfer_company_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Transfer For')}}</th>
                                    <td id="transfer_employee_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('From Department')}}</th>
                                    <td id="transfer_from_department_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('To Department')}}</th>
                                    <td id="transfer_to_department_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Description')}}</th>
                                    <td id="transfer_description_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Transfer Date')}}</th>
                                    <td id="transfer_transfer_date_id"></td>
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





