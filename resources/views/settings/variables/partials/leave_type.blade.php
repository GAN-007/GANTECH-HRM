<div class="container-fluid">    
    <div class="card mb-0">
        <div class="card-body">
            <h3 class="card-title">{{__('Add Leave Type')}}</h3>
            <form method="post" id="leave_type_form" class="form-horizontal">
                @csrf
                <div class="input-group">
                    <input type="text" name="leave_type" id="leave_type"  class="form-control"
                               placeholder="{{__('Leave Name')}} *">
                    <input type="text" name="allocated_day" id="allocated_day"  class="form-control"
                               placeholder="{{__('Days Per Year')}} *">
                    <input type="submit" name="leave_type_submit" id="leave_type_submit" class="btn btn-success" value={{trans("file.Save")}}>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="leave_result"></span>
<div class="table-responsive">
    <table id="leave_type-table" class="mt-0 table">
        <thead>
        <tr>
            <th>{{__('Leave name')}}</th>
            <th>{{__('Days Per Year')}}</th>
            <th class="not-exported">{{trans('file.action')}}</th>
        </tr>
        </thead>

    </table>
</div>


<div id="LeaveEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="LeaveModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="leave_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="leave_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="leave_type_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Leave Type')}} *</label>
                        <input type="text" name="leave_type_edit" id="leave_type_edit"  class="form-control"
                               placeholder="{{__('Leave Type')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>{{__('Days Per Year')}} *</label>
                        <input type="text" name="allocated_day_edit" id="allocated_day_edit"  class="form-control"
                               placeholder="{{__('Days Per Year')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_leave_id" id="hidden_leave_id" />
                        <input type="submit" name="leave_type_edit_submit" id="leave_type_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>