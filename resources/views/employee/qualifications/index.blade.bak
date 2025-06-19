<section>

    <span id="qualification_general_result"></span>


    <div class="container-fluid">
        @if(auth()->user()->can('store-details-employee') || auth()->user()->id == $employee->id)
            <button type="button" class="btn btn-info" name="create_record" id="create_qualification_record"><i
                        class="fa fa-plus"></i>{{__('Add Qualification')}}</button>
        @endif
    </div>


    <div class="table-responsive">
        <table id="qualification-table" class="table ">
            <thead>
            <tr>
                <th>{{trans('file.School/University')}}</th>
                <th>{{__('Time Period')}}</th>
                <th>{{__('Education Level')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>


    <div id="QualificationformModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Qualification')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="qualification-close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="qualification_form_result"></span>
                    <form method="post" id="qualification_sample_form" class="form-horizontal" autocomplete="off">

                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{trans('file.School/University')}} *</label>
                                <input type="text" name="institution_name" id="institution_name"
                                       placeholder={{trans('file.School/University')}}
                                               required class="form-control">
                            </div>


                            <div class="col-md-6 form-group">
                                <label>{{__('Education Level')}}</label>
                                <select name="education_level_id" id="education_level_id" required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="begins"
                                        title='{{__("Select Education Level...")}}'>
                                    @foreach($education_levels as $education_level)
                                        <option value="{{$education_level->id}}">{{$education_level->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6 form-group">
                                <label>{{trans('file.From')}} *</label>
                                <input type="text" name="from_date" id="qualification_from_date" required
                                       autocomplete="off" class="form-control date" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.To')}} *</label>
                                <input type="text" name="to_date" id="qualification_to_date" required autocomplete="off"
                                       class="form-control date" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Language')}}</label>
                                <select name="language_skill_id" id="language_skill_id" required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="begins"
                                        title='{{__('Selecting',['key'=>trans('file.Language')])}}...'>
                                    @foreach($language_skills as $language_skill)
                                        <option value="{{$language_skill->id}}">{{$language_skill->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Professional Skills')}}</label>
                                <select name="general_skill_id" id="general_skill_id" required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="begins"
                                        title='{{__('Selecting',['key'=>__('Professional Skills')])}}...'>
                                    @foreach($general_skills as $general_skill)
                                        <option value="{{$general_skill->id}}">{{$general_skill->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Description')}}</label>
                                    <textarea class="form-control" name="description" id="qualification_description"
                                              rows="3"></textarea>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="qualification_action"/>
                                    <input type="hidden" name="hidden_id" id="qualification_hidden_id"/>
                                    <input type="submit" name="action_button" id="qualification_action_button"
                                           class="btn btn-warning" value={{trans('file.Add')}} />
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade confirmModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                    <button type="button" class="qualification-close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button"  class="btn btn-danger qualification-ok">{{trans('file.OK')}}</button>
                    <button type="button" class="qualification-close btn-default" data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>

</section>

