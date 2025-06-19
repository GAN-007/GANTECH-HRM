<div class="row">    
    <div class="table-responsive">
        <table id="employee_promotion-table" class="table ">
            <thead>
            <tr>
                <th>{{__('Promotion Title')}}</th>
                <th>{{trans('file.Date')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>
</div>
<div class="modal fade" id="employee_promotion_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{__('Transfer Info')}}</h4>
                <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <span id="promotion_promotion_photo_id"></span>

                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">

                            <table class="table  table-bordered">

                                <tr>
                                    <th>{{trans('file.Company')}}</th>
                                    <td id="promotion_company_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Promotion For')}}</th>
                                    <td id="promotion_employee_id_show"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Title')}}</th>
                                    <td id="promotion_title_id"></td>
                                </tr>

                                <tr>
                                    <th>{{trans('file.Description')}}</th>
                                    <td id="promotion_description_id"></td>
                                </tr>

                                <tr>
                                    <th>{{__('Promotion Date')}}</th>
                                    <td id="promotion_promotion_date_id"></td>
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





