<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title">{{__('Add Award Type')}}</h3>
            <form method="post" id="award_type_form" class="form-horizontal" >
                @csrf
                <div class="input-group">
                    <input type="text" name="award_name" id="award_name"  class="form-control"
                           placeholder="{{__('Award Type')}}">

                    <input type="submit" name="award_type_submit" id="award_type_submit" class="btn btn-success" value={{trans("file.Save")}}>
                </div>
            </form>
        </div>
    </div>
</div>

<span class="award_result"></span>
<div class="table-responsive">
    <table id="award_type-table" class="table ">
        <thead>
        <tr>
            <th>{{__('Award name')}}</th>
            <th class="not-exported">{{trans('file.action')}}</th>
        </tr>
        </thead>

    </table>
</div>


<div id="AwardEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="AwardModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="award_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="award_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="award_type_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Award Type')}} *</label>
                        <input type="text" name="award_name_edit" id="award_name_edit"  class="form-control"
                               placeholder="{{__('Award Type')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_award_id" id="hidden_award_id" />
                        <input type="submit" name="award_type_edit_submit" id="award_type_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>