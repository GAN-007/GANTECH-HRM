<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title">{{__('Add Document Type')}}</h3>
            <form method="post" id="document_type_form" class="form-horizontal" >
                @csrf
                <div class="input-group">
                    <input type="text" name="document_type" id="document_type"  class="form-control"
                           placeholder="{{__('Document Type')}}">
                    <input type="submit" name="document_type_submit" id="document_type_submit" class="btn btn-success" value={{trans("file.Save")}}>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="document_result"></span>
<div class="table-responsive">
    <table id="document_type-table" class="table ">
        <thead>
        <tr>
            <th>{{__('Document Type')}}</th>
            <th class="not-exported">{{trans('file.action')}}</th>
        </tr>
        </thead>

    </table>
</div>

<div id="DocumentEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="DocumentModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="document_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="document_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="document_type_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Document Type')}} *</label>
                        <input type="text" name="document_type_edit" id="document_type_edit"  class="form-control"
                               placeholder="{{__('Document Type')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_document_id" id="hidden_document_id" />
                        <input type="submit" name="document_type_edit_submit" id="document_type_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>