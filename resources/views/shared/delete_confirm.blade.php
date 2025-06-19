<div class="modal fade confirmModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center">{{__('Are you sure you want to remove this data?')}}</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button"  class="btn btn-danger ok">{{trans('file.OK')}}</button>
                <button type="button" class="close btn-default" data-dismiss="modal">{{trans('file.Cancel')}}</button>
            </div>
        </div>
    </div>
</div>