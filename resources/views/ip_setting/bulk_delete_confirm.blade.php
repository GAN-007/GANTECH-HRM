{{-- Delete Confirm --}}
<div id="bulkDeleteConfirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" id="confirmMessage">{{__('Are you sure to delete the selected data?')}}</h4>
            </div>
            <div class="modal-footer">
                <button type="submit" id="bulkDeleteSubmitModal" class="btn btn-danger">{{trans('file.Yes')}}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('file.Cancel')}}</button>
            </div>
        </div>
    </div>
  </div>