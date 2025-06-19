<!--Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">@lang('file.Add New Type')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="submit_form">
              @csrf

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><b>@lang('file.Goal Type')</b></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="goal_type" id="goalType" placeholder="Goal Type">
                      <div class="invalid-feedback">
                          <p id="message"></p>
                      </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="save-button">@lang('file.Save')</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('file.Close')</button>
        </div>
      </div>
    </div>
  </div>
