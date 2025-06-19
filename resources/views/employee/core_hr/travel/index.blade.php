<div class="row">    
    <div class="table-responsive">
        <table id="employee_travel-table" class="table ">
            <thead>
            <tr>
                <th>{{trans('file.Summary')}}</th>
                <th>{{__('Place Of Visit')}}</th>
                <th>{{__('Start Date')}}</th>
                <th>{{__('End Date')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>
</div>
<div class="modal fade" id="employee_travel_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('Travel Info')}}</h4>
                <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <span id="travel_travel_photo_id"></span>

                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">

                            <table class="table  table-bordered">

                                <tr>
                                    <th>{{trans('file.Company')}}</th>
                                    <td id="travel_company_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Employee')}}</th>
                                    <td id="travel_employee_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Start Date')}}</th>
                                    <td id="travel_start_date_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('End Date')}}</th>
                                    <td id="travel_end_date_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Purpose Of Visit')}}</th>
                                    <td id="travel_purpose_of_visit_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Place Of Visit')}}</th>
                                    <td id="travel_place_of_visit_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Travel Mode')}}</th>
                                    <td id="travel_travel_mode_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Arrangement Type')}}</th>
                                    <td id="travel_travel_type_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Expected Budget')}}</th>
                                    <td id="travel_expected_budget_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Actual Budget')}}</th>
                                    <td id="travel_actual_budget_show"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Status')}}</th>
                                    <td id="travel_status_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Travel Info')}}</th>
                                    <td id="travel_description_show"></td>
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





