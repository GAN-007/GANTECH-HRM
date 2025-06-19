<div id="trainingModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{__('Add Training')}}</h5>
                <button type="button" data-dismiss="modal"  aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                <span id="training_form_result"></span>
                <form method="post" id="training_sample_form" class="form-horizontal" >

                    @csrf
                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('file.Company')}} *</label>
                                <select name="company_id" id="training_company_id"  class="form-control selectpicker get_employee"
                                        data-live-search="true" data-live-search-style="contains"  data-first_name="first_name" data-last_name="last_name"
                                        title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6 form-group">
                            <label>{{__('Training Type')}} *</label>
                            <select name="training_type" id="training_type_new"  class="form-control selectpicker "
                                    data-live-search="true" data-live-search-style="contains"
                                    title='{{__('Selecting',['key'=>__('Training Type')])}}...'>
                                @foreach($training_types as $training_type)
                                    <option value="{{$training_type->id}}">{{$training_type->type}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Trainer')}} *</label>
                            <select name="trainer_id" id="trainer_id"  class="form-control selectpicker "
                                    data-live-search="true" data-live-search-style="contains"
                                    title='{{__('Selecting',['key'=>trans('file.Trainer')])}}...'>
                                @foreach($trainers as $trainer)
                                    <option value="{{$trainer->id}}">{{$trainer->first_name}} {{$trainer->last_name}} </option>
                                @endforeach
                            </select>
                        </div>



                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Employee')}} *</label>
                            <select name="employee_id[]" id="training_employee_id"  class="selectpicker form-control employee"
                                    data-live-search="true" data-live-search-style="contains" multiple
                                    title='{{__('Selecting',['key'=>trans('file.Employee')])}}...'>
                            </select>
                        </div>


                        <div class="col-md-6 form-group">
                            <label>{{__('Start Date')}} *</label>
                            <input type="text" name="start_date" id="training_start_date" required class="form-control date" value="">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>{{__('End Date')}} *</label>
                            <input type="text" name="end_date" id="training_end_date" required class="form-control date" value="">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>{{__('Training Cost.')}} *</label>
                            <input type="text" name="training_cost" id="training_cost" required class="form-control"
                                   placeholder="{{__('Training Cost.')}}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Description')}}</label>
                            <textarea class="form-control" id="training_description" name="description"
                                      rows="3"></textarea>
                        </div>

                        <div class="container">
                            <div class="form-group" align="center">
                                <input type="submit" name="action_button" class="btn btn-warning" value={{trans('file.Add')}} />
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

