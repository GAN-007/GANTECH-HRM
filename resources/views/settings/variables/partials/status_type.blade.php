<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title">{{__('Add Status Type')}}</h3>
            <form method="post" id="status_type_form" class="form-horizontal" >
                @csrf
                <div class="input-group">
                    <input type="text" name="status_title" id="status_title"  class="form-control"
                           placeholder="{{__('Status Type')}}">
                    <input type="submit" name="status_type_submit" id="status_type_submit" class="btn btn-success" value={{trans("file.Save")}}>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="status_result"></span>
<div class="table-responsive">
    <table id="status_type-table" class="table ">
        <thead>
        <tr>
            <th>{{__('Status Type')}}</th>
            <th class="not-exported">{{trans('file.action')}}</th>
        </tr>
        </thead>

    </table>
</div>

<div id="StatusEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="StatusModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="status_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="status_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="status_type_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Status Type')}} *</label>
                        <input type="text" name="status_title_edit" id="status_title_edit"  class="form-control"
                               placeholder="{{__('Status Type')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_status_id" id="hidden_status_id" />
                        <input type="submit" name="status_type_edit_submit" id="status_type_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>