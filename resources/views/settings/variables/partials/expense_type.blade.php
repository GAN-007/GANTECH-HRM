<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title">{{__('Add Expense Type')}}</h3>
            <form method="post" id="expense_type_form" class="form-horizontal" >
                @csrf

                <div class="input-group">
                    <select name="company_id" id="company_id" class="form-control selectpicker"
                            data-live-search="true" data-live-search-style="contains"
                            title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                        @php
                        $companies = App\Models\company::select('id', 'company_name')->get();
                        @endphp
                        @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                        @endforeach
                    </select>
                    <input type="text" name="expense_type" id="expense_type"  class="form-control"
                           placeholder="{{__('Expense Type')}}">
                    <input type="submit" name="expense_type_submit" id="expense_type_submit" class="btn btn-success" value={{trans("file.Save")}}>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="expense_result"></span>
<div class="table-responsive">
    <table id="expense_type-table" class="table ">
        <thead>
        <tr>
            <th>{{trans('file.Company')}}</th>
            <th>{{__('Expense Type')}}</th>
            <th class="not-exported">{{trans('file.action')}}</th>
        </tr>
        </thead>

    </table>
</div>

<div id="ExpenseEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="ExpenseModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="expense_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="expense_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="expense_type_form_edit" class="form-horizontal"  >

                    @csrf

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{trans('file.Company')}}</label>
                            <select name="company_id_edit" id="company_id_edit" class="form-control selectpicker"
                                    data-live-search="true" data-live-search-style="contains"
                                    title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                @php
                                    $companies = App\Models\company::select('id', 'company_name')->get();
                                @endphp
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>{{__('Expense Type')}} *</label>
                        <input type="text" name="expense_type_edit" id="expense_type_edit"  class="form-control"
                               placeholder="{{__('Expense Type')}}">
                    </div>

                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_expense_id" id="hidden_expense_id" />
                        <input type="submit" name="expense_type_edit_submit" id="expense_type_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>