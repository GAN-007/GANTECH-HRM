<!--Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
            <div class="modal-body">
                <h4 align="center" style="margin:0;">@lang('file.Are you sure to remove this data') ?</h4>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteSubmit">@lang('file.Yes')</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('file.Cancel')</button>
        </div>
      </div>
    </div>
  </div>
