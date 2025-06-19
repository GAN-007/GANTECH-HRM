<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title">{{__('Add Termination Type')}}</h3>
            <form method="post" id="termination_type_form" class="form-horizontal" >
                @csrf
                <div class="input-group">
                    <input type="text" name="termination_title" id="termination_title"  class="form-control"
                           placeholder="{{__('Termination Type')}}">
                    <input type="submit" name="termination_type_submit" id="termination_type_submit" class="btn btn-success" value={{trans("file.Save")}}>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="termination_result"></span>
<div class="table-responsive">
    <table id="termination_type-table" class="table ">
        <thead>
        <tr>
            <th>{{__('Termination Type')}}</th>
            <th class="not-exported">{{trans('file.action')}}</th>
        </tr>
        </thead>

    </table>
</div>


<div id="TerminationEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="TerminationModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="termination_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="termination_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="termination_type_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Termination Type')}} *</label>
                        <input type="text" name="termination_title_edit" id="termination_title_edit"  class="form-control"
                               placeholder="{{__('Termination Type')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_termination_id" id="hidden_termination_id" />
                        <input type="submit" name="termination_type_edit_submit" id="termination_type_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>