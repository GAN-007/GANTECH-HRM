<!--Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">{{__('Add New IP')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <span id="form_result"></span>
            <form method="POST" id="submit_form">
              @csrf

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><b>{{__('Name')}}</b></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><b>{{__('IP Address')}}</b></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="ip_address" id="ipAddress" placeholder="IP Address">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save-button">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>