<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <ul class="nav nav-tabs vertical" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="educationLevel-tab" data-toggle="tab" href="#educationLevel"
                               role="tab" aria-controls="educationLevel"
                               aria-selected="true">{{__('Add Education Level')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#languageSkills"
                               id="languageSkills-tab" data-toggle="tab" data-table="languageSkills"
                               data-target="#languageSkills" role="tab" aria-controls="languageSkills"
                               aria-selected="false">{{__('Add Language Skills')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#otherSkills"
                               id="otherSkills-tab" data-toggle="tab" data-table="otherSkills"
                               data-target="#otherSkills" role="tab" aria-controls="otherSkills"
                               aria-selected="false">{{__('Add Other Skills')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active pt-0" id="educationLevel" role="tabpanel" aria-labelledby="educationLevel-tab">
                            <h3 class="card-title">{{__('Add Education Level')}}</h3>
                            <span class="education_level_result"></span>
                            <form method="post" id="education_level_form" class="form-horizontal mb-3" >
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="education_level_name" id="education_level_name"  class="form-control"
                                           placeholder="{{__('Education Level')}}">
                                    <input type="submit" name="education_level_submit" id="education_level_submit" class="btn btn-success" value={{trans("file.Save")}}>
                                </div>
                            </form>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="education_level-table" class="table ">
                                        <thead>
                                        <tr>
                                            <th>{{__('Education Level')}}</th>
                                            <th class="not-exported">{{trans('file.action')}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade pt-0" id="languageSkills" role="tabpanel" aria-labelledby="languageSkills-tab">
                            <h3 class="card-title">{{__('Add Language Skills')}}</h3>
                            <span class="language_skill_result"></span>
                            <form method="post" id="language_skill_form" class="form-horizontal mb-3" >
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="language_skill_name" id="language_skill_name"  class="form-control"
                                           placeholder="{{__('Language Skill')}}">
                                    <input type="submit" name="language_skill_submit" id="language_skill_submit" class="btn btn-success" value={{trans("file.Save")}}>
                                </div>
                            </form>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="language_skill-table" class="table ">
                                        <thead>
                                        <tr>
                                            <th>{{trans('file.Language')}}</th>
                                            <th class="not-exported">{{trans('file.action')}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade pt-0" id="otherSkills" role="tabpanel" aria-labelledby="otherSkills-tab">
                            <h3 class="card-title">{{__('Add Skills')}}</h3>
                            <span class="general_skill_result"></span>
                            <form method="post" id="general_skill_form" class="form-horizontal mb-3" >
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="general_skill_name" id="general_skill_name"  class="form-control"
                                           placeholder="{{__('Skill')}}">
                                    <input type="submit" name="general_skill_submit" id="general_skill_submit" class="btn btn-success" value={{trans("file.Save")}}>
                                </div>
                            </form>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="general_skill-table" class="table ">
                                        <thead>
                                        <tr>
                                            <th>{{__('Skill')}}</th>
                                            <th class="not-exported">{{trans('file.action')}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<div id="EducationLevelEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="EducationLevelModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="education_level_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="education_level_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="education_level_form_edit" class="form-horizontal"  >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Education Level')}} *</label>
                        <input type="text" name="education_level_name_edit" id="education_level_name_edit"  class="form-control"
                               placeholder="{{__('Education Level')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_education_level_id" id="hidden_education_level_id" />
                        <input type="submit" name="education_level_edit_submit" id="education_level_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="LanguageSkillEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="LanguageSkillModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="language_skill_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="language_skill_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="language_skill_form_edit" class="form-horizontal" >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Language Skill')}} *</label>
                        <input type="text" name="language_skill_name_edit" id="language_skill_name_edit"  class="form-control"
                               placeholder="{{__('Language Skill')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_language_skill_id" id="hidden_language_skill_id" />
                        <input type="submit" name="language_skill_edit_submit" id="language_skill_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="GeneralSkillEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="GeneralSkillModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="general_skill_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="general_skill_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="general_skill_form_edit" class="form-horizontal"  >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Skill')}} *</label>
                        <input type="text" name="general_skill_name_edit" id="general_skill_name_edit"  class="form-control"
                               placeholder="{{__('Skill')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_general_skill_id" id="hidden_general_skill_id" />
                        <input type="submit" name="general_skill_edit_submit" id="general_skill_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>