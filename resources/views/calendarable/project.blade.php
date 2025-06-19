<div id="projectModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{__('Add Project')}}</h5>
                <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                <span id="project_form_result"></span>
                <form method="post" id="project_sample_form" class="form-horizontal" >

                    @csrf
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label for="project_title">{{trans('file.Title')}} *</label>
                            <input type="text" name="title" id="project_title" required class="form-control" placeholder="{{trans('file.Title')}}">
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="project_client_id">{{trans('file.Client')}}*</label>
                                <select name="client_id" id="project_client_id"
                                        class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="contains"
                                        title='{{__('Selecting',['key'=>trans('file.Client')])}}...'>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->first_name.' '.$client->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6 form-group">
                            <label for="project_start_date" >{{__('Start Date')}} *</label>
                            <input type="text" name="start_date" id="project_start_date" autocomplete="off" required class="form-control date"
                                   value="">
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="project_end_date">{{__('End Date')}} *</label>
                            <input type="text" name="end_date" id="project_end_date" autocomplete="off" required class="form-control date"
                                   value="">
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="project_priority" >{{trans('file.Priority')}}</label>
                            <select name="project_priority" id="project_priority" class="form-control selectpicker "
                                    data-live-search="true" data-live-search-style="contains"
                                    title='{{__('Selecting',['key'=>trans('file.Priority')])}}...'>
                                <option value="low">{{trans('file.Low')}}</option>
                                <option value="medium">{{trans('file.Medium')}}</option>
                                <option value="high">{{trans('file.High')}}</option>
                                <option value="highest">{{trans('file.Highest')}}</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="project_summary" >{{trans('file.Summary')}}</label>
                                <textarea class="form-control" id="project_summary"
                                          name="summary" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="project_company_id">{{trans('file.Company')}}</label>
                                <select name="company_id" id="project_company_id" class="form-control selectpicker get_employee"
                                        data-live-search="true" data-live-search-style="contains"  data-first_name="first_name" data-last_name="last_name"
                                        title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>



                        <div class="col-md-4 form-group">
                            <label for="project_employee_id">{{__('Project Users')}} *</label>
                            <select name="employee_id[]" id="project_employee_id" class="js-example-responsive employee w-100"
                                    multiple="multiple">

                            </select>
                        </div>




                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="project_description">{{trans('file.Description')}}</label>
                                <textarea class="form-control des-editor" id="project_description" name="description"
                                          rows="3"></textarea>
                            </div>
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

