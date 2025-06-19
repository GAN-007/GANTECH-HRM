<!--Create Modal -->
<div class="modal fade" id="EditformModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel"><b>Edit Goal Tracking</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="edit-body"> 
        
        <form method="POST" id="updatetEditForm">
          @csrf 
          <input type="hidden" name="goal_tracking_id" id="goalTrackingIdEdit">

          <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Company</b></label>
                        <select name="company_id" id="companyIdEdit" class="form-control selectpicker dynamic"
                            data-live-search="true" data-live-search-style="begins"
                            data-first_name="first_name" data-last_name="last_name"
                            title='{{__('Selecting',['key'=>trans('file.Company')])}}'>
                            @foreach ($companies as $company)
                                <option value="{{$company->id}}" >{{$company->company_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Goal Type</b></label>
                        <select name="goal_type_id" id="goalTypeIdEdit" class="form-control selectpicker dynamic" data-live-search="true" data-live-search-style="begins">
                            @foreach ($goal_types as $goalTypes)
                                  <option value="{{$goalTypes->id}}" >{{$goalTypes->goal_type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Subject</b></label>
                        <input type="text" class="form-control" name="subject" id="subjectEdit">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Target Achievement</b></label>
                        <input type="text" class="form-control" name="target_achievement" id="targetAchievementEdit">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label><b>Description</b></label>
                        <textarea class="form-control" name="description" id="descriptionEdit" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Start Date</b></label>
                        <input type="text" class="form-control" name="start_date" id="startDateEdit">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>End Date</b></label>
                        <input type="text" class="form-control" name="end_date" id="endDateEdit">
                    </div>
                </div>


                <div class="col-md-12 form-group show-edit">
                    <label><b>{{__('Progress Bar')}}</b></label>
                    <input type="text" name="progress" id="progressEdit"
                           class="form-control range-slider "
                           placeholder="{{__('Progress Bar')}}">
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Status</b></label>
                        <select name="status" id="statusEdit" class="form-control selectpicker dynamic"
                              data-live-search="true" data-live-search-style="begins">
                              <option value="Not Started"><b>Not Started</b></option>
                              <option value="In Progress"><b>In Progress</b></option>
                              <option value="Completed"><b>Completed</b></option>
                        </select>
                    </div>
                </div>
          </div>    
      </form>

      </div>
      <div class="row mb-5">
          <div class="col-sm-2"></div>
          <div class="col-sm-6">
              <div id="alertMessageBoxEdit">
                  <div id="alertMessageEdit" class="text-light"></div>
              </div>
          </div>
          <div class="col-sm-1"></div>
          <div class="col-sm-3">
              <button type="button" class="btn btn-primary" id="update-button">Update</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>   
          </div>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> --}}
    </div>
  </div>
</div>

<script>
  $('#startDateEdit').datepicker({
      uiLibrary: 'bootstrap4'
  });
  $('#endDateEdit').datepicker({
      uiLibrary: 'bootstrap4'
  });

  $(".range-slider").ionRangeSlider({
    type: "single",
    min: 0,
    max: 100,
    step: 1,
    grid: true,
    postfix: "%",
    skin: "round"
});
</script>