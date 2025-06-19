<section>

    <span id="immigration_general_result"></span>


    @if(auth()->user()->can('store-details-employee') || auth()->user()->id == $employee->id)
        <button type="button" class="btn btn-info" name="create_record" id="create_immigration_record"><i class="fa fa-plus"></i>{{__('Add Immigration')}}</button>
    @endif


        <div class="table-responsive row">
        <table id="immigration-table" class="table ">
            <thead>
            <tr>
                <th>{{trans('file.Document')}}</th>
                <th>{{__('Issue Date')}}</th>
                <th>{{__('Expired Date')}}</th>
                <th>{{__('Issue By')}}</th>
                <th>{{__('Review Date')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>


    <div id="ImmigrationformModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Immigration')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="immigration-close"><span
                                aria-hidden="true">×</span></button>
                </div>

                <div class="modal-body">
                    <span id="immigration_form_result"></span>
                    <form method="post" id="immigration_sample_form" class="form-horizontal"
                          enctype="multipart/form-data" autocomplete="off">

                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{__('Document Type')}}</label>
                                <select name="document_type_id" id="immigration_document_type_id" required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="begins"
                                        title='{{__('Selecting',['key'=>__('Document Type')])}}...'>
                                    @foreach($document_types as $document_type)
                                        <option value="{{$document_type->id}}">{{$document_type->document_type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Document Number')}} *</label>
                                <input type="text" name="document_number" id="immigration_document_number"
                                       placeholder={{__('Document Number')}}
                                               required class="form-control">
                            </div>


                            <div class="col-md-6 form-group">
                                <label>{{__('Issue Date')}} *</label>
                                <input type="text" name="issue_date" id="immigration_issue_date" required
                                       autocomplete="off" class="form-control date" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Expired Date')}} </label>
                                <input type="text" name="expiry_date" id="immigration_expiry_date"
                                       autocomplete="off" class="form-control date" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Eligible Review Date')}} </label>
                                <input type="text" name="eligible_review_date" id="immigration_eligible_review_date"
                                        autocomplete="off" class="form-control date" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Document')}} {{trans('file.File')}} *</label>
                                <input type="file" name="document_file" id="immigration_document_file"
                                       required class="form-control">
                                <span id="stored_immigration_document"></span>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Country')}} *</label>
                                    <select name="country" id="immigration_country" required
                                            class="form-control selectpicker"
                                            data-live-search="true" data-live-search-style="begins"
                                            title='{{__('Selecting',['key'=>trans('file.Country')])}}...'>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="immigration_action"/>
                                    <input type="hidden" name="hidden_id" id="immigration_hidden_id"/>
                                    <input type="submit" name="action_button" id="immigration_action_button"
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
                    <button type="button" class="immigration-close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button"  class="btn btn-danger immigration-ok">{{trans('file.OK')}}</button>
                    <button type="button" class="immigration-close btn-default" data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>


</section>

