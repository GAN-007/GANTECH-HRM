<section>

    <span id="bank_account_general_result"></span>


    <div class="container-fluid">
        @if(auth()->user()->can('store-details-employee') || auth()->user()->id == $employee->id)
            <button type="button" class="btn btn-info" name="create_record" id="create_bank_account_record"><i
                        class="fa fa-plus"></i>{{__('Add Bank Account')}}</button>
        @endif
    </div>


    <div class="table-responsive">
        <table id="bank_account-table" class="table ">
            <thead>
            <tr>
                <th>{{__('Account Title')}}</th>
                <th>{{__('Account Number')}}</th>
                <th>{{__('Bank Name')}}</th>
                <th>{{__('Bank Code')}}</th>
                <th>{{__('Bank Branch')}}</th>
                <th class="not-exported">{{trans('file.action')}}</th>
            </tr>
            </thead>

        </table>
    </div>


    <div id="BankAccountformModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Bank Account')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="bank-close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="bank_account_form_result"></span>
                    <form method="bank_code" id="bank_account_sample_form" class="form-horizontal" autocomplete="off">

                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{__('Account Title')}} *</label>
                                <input type="text" name="account_title" id="bank_account_title"
                                       placeholder={{__('Account Title')}}
                                               required class="form-control">
                            </div>


                            <div class="col-md-6 form-group">
                                <label>{{__('Account Number')}} *</label>
                                <input type="text" name="account_number" id="bank_account_number" required
                                       autocomplete="off" class="form-control" placeholder={{__('Account Number')}}>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Bank Name')}} *</label>
                                <input type="text" name="bank_name" id="bank_bank_name" required autocomplete="off"
                                       class="form-control" placeholder={{__('Bank Name')}} >
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Bank Code')}} *</label>
                                <input type="text" name="bank_code" id="bank_bank_code" placeholder={{__('Bank Code')}}
                                        required class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Bank Branch')}} *</label>
                                <input type="text" name="bank_branch" id="bank_bank_branch"
                                       placeholder={{__('Bank Code')}}
                                               required class="form-control">
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="bank_account_action"/>
                                    <input type="hidden" name="hidden_id" id="bank_account_hidden_id"/>
                                    <input type="submit" name="action_button" id="bank_account_action_button"
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
                    <button type="button" class="bank-close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button"  class="btn btn-danger bank-ok">{{trans('file.OK')}}</button>
                    <button type="button" class="bank-close btn-default" data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>

</section>

