<div class="row">    
    <div class="table-responsive">
        <table id="employee_training-table" class="table ">
            <thead>
            <tr>
                <th>{{__('Training Type')}}</th>
                <th>{{trans('file.Trainer')}}</th>
                <th>{{__('Start Date')}}</th>
                <th>{{__('End Date')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>
</div>
<div class="modal fade" id="employee_training_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"
     style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('Training Info')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">

                            <table class="table  table-bordered">

                                <tr>
                                    <th>{{trans('file.Company')}}</th>
                                    <td id="training_company_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Trainer')}}</th>
                                    <td id="training_trainer_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Training Type')}}</th>
                                    <td id="training_training_type_show"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Employee')}}</th>
                                    <td id="training_employee_id_show"></td>
                                </tr>



                                <tr>
                                    <th>{{__('Start Date')}}</th>
                                    <td id="training_start_date_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('End Date')}}</th>
                                    <td id="training_end_date_show"></td>
                                </tr>


                                <tr>
                                    <th>{{trans('file.Description')}}</th>
                                    <td id="training_description_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Training Cost')}}</th>
                                    <td id="training_training_cost_show"></td>
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





