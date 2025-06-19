<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title">{{__('Add Job Category')}}</h3>
            <form method="post" id="job_category_form" class="form-horizontal" >
                @csrf
                <div class="input-group">
                    <input type="text" name="job_category" id="job_category"  class="form-control"
                           placeholder="{{__('Job Category')}}">
                    <input type="submit" name="job_category_submit" id="job_category_submit" class="btn btn-success" value={{trans("file.Save")}}>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="job_category_result"></span>
<div class="table-responsive">
    <table id="job_category-table" class="table ">
        <thead>
        <tr>
            <th>{{__('Job Category')}}</th>
            <th class="not-exported">{{trans('file.action')}}</th>
        </tr>
        </thead>

    </table>
</div>

<div id="JobCategoryEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="JobCategoryModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="job_category_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="job_category_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="job_category_form_edit" class="form-horizontal" >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Job Category')}} *</label>
                        <input type="text" name="job_category_edit" id="job_category_edit"  class="form-control"
                               placeholder="{{__('Job Category')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_job_category_id" id="hidden_job_category_id" />
                        <input type="submit" name="job_category_edit_submit" id="job_category_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>