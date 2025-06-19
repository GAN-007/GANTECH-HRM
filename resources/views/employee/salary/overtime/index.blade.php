<section>

    <span id="overtime_general_result"></span>


    <div class="mb-3">
        @can('set-salary')
            <button type="button" class="btn btn-info" name="create_record" id="create_overtime_record"><i
                        class="fa fa-plus"></i>{{__('Add Overtime')}}</button>
        @endcan
    </div>

    <div class="row">
        <div class="table-responsive">
            <table id="overtime-table" class="table ">
                <thead>
                <tr>
                    <th>{{__('Month-Year')}}</th>
                    <th>{{trans('file.Title')}}</th>
                    <th>{{__('Number Of Days')}}</th>
                    <th>{{__('Total Hours')}}</th>
                    @if(config('variable.currency_format')=='suffix')
                        <th>{{__('Rate')}} ({{config('variable.currency')}})</th>
                    @else
                        <th>({{config('variable.currency')}}) {{__('Rate')}}</th>
                    @endif
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>

    <div id="OvertimeformModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Overtime')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="overtime-close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="overtime_form_result"></span>
                    <form method="post" id="overtime_sample_form" class="form-horizontal" autocomplete="off">

                        @csrf
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label>{{__('Month Year')}} *</label>
                                <input class="form-control month_year" name="month_year" type="text" id="month_year">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Title')}} *</label>
                                <input type="text" name="overtime_title" id="overtime_title"
                                       placeholder={{trans('file.Title')}}
                                               required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{__('Number Of Days')}} *</label>
                                <input type="text" name="no_of_days" id="no_of_days"
                                       placeholder={{__('Number Of Days')}}
                                               required class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Total Hours')}} *</label>
                                <input type="text" name="overtime_hours" id="overtime_hours"
                                       placeholder={{__('Total Hours')}}
                                               required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                @if(config('variable.currency_format')=='suffix')
                                    <label>{{__('Rate')}} ({{config('variable.currency')}}) *</label>
                                @else
                                    <label>({{config('variable.currency')}}) {{__('Rate')}} *</label>
                                @endif <input type="text" name="overtime_rate" id="overtime_rate"
                                              placeholder={{trans('file.Rate')}}
                                                      required class="form-control">
                            </div>


                            <div class="container">
                                <br>
                                {{-- <span class="text-danger"><i>[NB: If you didn't pay the employee's previous due, the current amount will be treated as the previous amount.]</i></span> <br><br> --}}
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="overtime_action"/>
                                    <input type="hidden" name="hidden_id" id="overtime_hidden_id"/>
                                    <input type="submit" name="action_button" id="overtime_action_button"
                                           class="btn btn-warning" value={{trans('file.Add')}} />
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade confirmModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                    <button type="button" class="overtime-close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button"  class="btn btn-danger overtime-ok">{{trans('file.OK')}}</button>
                    <button type="button" class="overtime-close btn-default" data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>

</section>

