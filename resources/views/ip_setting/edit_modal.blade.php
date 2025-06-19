<!--Create Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">{{__('Edit IP')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <span id="form_result_edit"></span>
            <form method="POST" id="update_form">
                <input type="hidden" id="id">
              @csrf

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><b>{{__('Name')}}</b></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" id="nameEdit" placeholder="Name">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><b>{{__('IP Address')}}</b></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="ip_address" id="ipAddressEdit" placeholder="IP Address">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save-button">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>