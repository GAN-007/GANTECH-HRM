@extends('layout.main')
@section('content')
    <style>
        .nav-tabs li a {
            padding: 0.75rem 1.25rem;
        }

        .nav-tabs.vertical li {
            border: 1px solid #ddd;
            display: block;
            width: 100%
        }

        .tab-pane {
            padding: 15px 0
        }

    </style>
    <section>
        @can('view-details-employee')
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h2>{{$employee->user->username}}</h2>
                    </div>
                    <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#General" role="tab"
                               aria-controls="General" aria-selected="true">{{trans('file.General')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Profile" role="tab"
                               aria-controls="Profile" aria-selected="false">{{trans('file.Profile')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="set_salary-tab" data-toggle="tab" href="#Set_salary" role="tab"
                               aria-controls="Set_salary" aria-selected="false">{{__('Set Salary')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="leave-tab" data-toggle="tab" href="#Leave" role="tab"
                               aria-controls="Leave" aria-selected="false">{{trans('file.Leave')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="employee_core_hr-tab" data-toggle="tab" href="#Employee_Core_hr"
                               role="tab" aria-controls="Employee_Core_hr" aria-selected="false">{{__('Core HR')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="employee_project_task-tab" data-toggle="tab"
                               href="#Employee_project_task" role="tab" aria-controls="Employee_project_task"
                               aria-selected="false">{{trans('file.Project')}} & {{trans('file.Task')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="employee_payslip-tab" data-toggle="tab" href="#Employee_Payslip"
                               role="tab" aria-controls="Employee_Payslip"
                               aria-selected="false">{{trans('file.Payslip')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="remainingLeaveType-tab" data-toggle="tab" href="#remainingLeaveType"
                               role="tab" aria-controls="remainingLeaveType"
                               aria-selected="false">{{trans('file.Remaining Leave')}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="General" role="tabpanel"
                             aria-labelledby="general-tab">
                            <!--Contents for General starts here-->
                            {{__('General Info')}}
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="nav nav-tabs vertical" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#Basic"
                                               role="tab" aria-controls="Basic"
                                               aria-selected="true">{{trans('file.Basic')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('immigrations.show',$employee)}}"
                                               id="immigration-tab" data-toggle="tab" data-table="immigration"
                                               data-target="#Immigration" role="tab" aria-controls="Immigration"
                                               aria-selected="false">{{trans('file.Immigration')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('contacts.show',$employee)}}"
                                               id="emergency-tab" data-toggle="tab" data-table="emergency"
                                               data-target="#Emergency" role="tab" aria-controls="Emergency"
                                               aria-selected="false">{{__('Emergency Contacts')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('social_profile.show',$employee)}}"
                                               id="social_profile-tab" data-toggle="tab" data-table="social_profile"
                                               data-target="#Social_profile" role="tab" aria-controls="Social_profile"
                                               aria-selected="false">{{__('Social Profile')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('documents.show',$employee)}}"
                                               id="document-tab" data-toggle="tab" data-table="document"
                                               data-target="#Document" role="tab" aria-controls="Document"
                                               aria-selected="false">{{trans('file.Document')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('qualifications.show',$employee)}}"
                                               id="qualification-tab" data-toggle="tab" data-table="qualification"
                                               data-target="#Qualification" role="tab" aria-controls="Qualification"
                                               aria-selected="false">{{trans('file.Qualification')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('work_experience.show',$employee)}}"
                                               id="work_experience-tab" data-toggle="tab" data-table="work_experience"
                                               data-target="#Work_experience" role="tab" aria-controls="Work_experience"
                                               aria-selected="false">{{__('Work Experience')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('bank_account.show',$employee)}}"
                                               id="bank_account-tab" data-toggle="tab" data-table="bank_account"
                                               data-target="#Bank_account" role="tab" aria-controls="Bank_account"
                                               aria-selected="false">{{__('Bank Account')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                @endcan
                                @can('modify-details-employee')
                                <div class="col-md-9">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="Basic" role="tabpanel"
                                             aria-labelledby="basic-tab">
                                            <!--Contents for Basic starts here-->
                                            {{__('Basic Information')}}
                                            <hr>
                                            <span id="form_result"></span>
                                            <form method="post" id="basic_sample_form" class="form-horizontal"
                                                  enctype="multipart/form-data" autocomplete="off">

                                                @csrf
                                                <div class="row">

                                                    <div class="col-md-4 form-group">
                                                        <label>{{__('First Name')}} <span class="text-danger">*</span></label>
                                                        <input type="text" name="first_name" id="first_name"
                                                               placeholder="{{__('First Name')}}"
                                                               required class="form-control"
                                                               value="{{ $employee->first_name }}">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{__('Last Name')}} <span class="text-danger">*</span></label>
                                                        <input type="text" name="last_name" id="last_name"
                                                               placeholder="{{__('Last Name')}}"
                                                               required class="form-control"
                                                               value="{{ $employee->last_name }}">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>{{__('Staff Id')}} <span class="text-danger">*</span></label>
                                                        <input type="text" name="staff_id" id="staff_id"
                                                               placeholder="{{__('Staff Id')}}"
                                                               required class="form-control"
                                                               value="{{ $employee->staff_id }}">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.Username')}} <span class="text-danger">*</span></label>
                                                        <input type="text" name="username" id="username"
                                                               placeholder="{{trans('file.Username')}}" required
                                                               class="form-control"
                                                               value="{{$employee->user->username}}">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.Email')}}</label>
                                                        <input type="text" name="email" id="email"
                                                               placeholder="{{trans('file.Email')}}"
                                                               class="form-control"
                                                               value="{{ $employee->email }}">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.Phone')}} <span class="text-danger">*</span></label>
                                                        <input type="text" name="contact_no" id="contact_no"
                                                               placeholder="{{trans('file.Phone')}}"
                                                               required class="form-control"
                                                               value="{{ $employee->contact_no }}">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.Address')}} </label>
                                                        <input type="text" name="address" id="address"
                                                               placeholder="Address"
                                                               value="{{$employee->address}}" class="form-control">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.City')}} </label>
                                                        <input type="text" name="city" id="city"
                                                               placeholder="{{trans('file.City')}}"
                                                               value="{{$employee->city}}" class="form-control">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.State/Province')}}
                                                        </label>
                                                        <input type="text" name="state" id="state"
                                                               placeholder="{{trans('file.State/Province')}}"
                                                               value="{{$employee->state}}" class="form-control">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.ZIP')}} </label>
                                                        <input type="text" name="zip_code" id="zip_code"
                                                               placeholder="{{trans('file.ZIP')}}"
                                                               value="{{$employee->zip_code}}" class="form-control">
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>{{trans('file.Country')}}</label>
                                                            <select name="country" id="country"
                                                                    class="form-control selectpicker"
                                                                    data-live-search="true"
                                                                    data-live-search-style="contains"
                                                                    title="{{__('Selecting',['key'=>trans('file.Country')])}}...">
                                                                @foreach($countries as $country)
                                                                    <option value="{{$country->id}}" {{ ($employee->country == $country->id) ? "selected" : '' }}>{{$country->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{__('Date Of Birth')}} <span class="text-danger">*</span></label>
                                                        <input type="text" name="date_of_birth" id="date_of_birth"
                                                               required autocomplete="off" class="form-control date"
                                                               value="{{$employee->date_of_birth}}">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.Gender')}}</label>
                                                        <input type="hidden" name="gender_hidden"
                                                               value="{{ $employee->gender }}"/>
                                                        <select name="gender" id="gender"
                                                                class="selectpicker form-control"
                                                                data-live-search="true"
                                                                data-live-search-style="contains"
                                                                title="{{__('Selecting',['key'=>trans('file.Gender')])}}...">
                                                            <option value="Male">{{trans('file.Male')}}</option>
                                                            <option value="Female">{{trans('file.Female')}}</option>
                                                            <option value="Other">{{trans('file.Other')}}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{__('Marital Status')}} </label>
                                                        <input type="hidden" name="marital_status_hidden"
                                                               value="{{ $employee->marital_status }}"/>
                                                        <select name="marital_status" id="marital_status"
                                                                class="selectpicker form-control"
                                                                data-live-search="true"
                                                                data-live-search-style="contains"
                                                                title="{{__('Selecting',['key'=>__('Marital Status')])}}...">
                                                            <option value="single">{{trans('file.Single')}}</option>
                                                            <option value="married">{{trans('file.Married')}}</option>
                                                            <option value="widowed">{{trans('file.Widowed')}}</option>
                                                            <option value="divorced">{{trans('file.Divorced/Separated')}}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>{{trans('file.Company')}} <span class="text-danger">*</span></label>
                                                            <input type="hidden" name="company_id_hidden"
                                                               value="{{ $employee->company_id }}"/>
                                                            <select name="company_id" id="company_id"
                                                                    class="form-control selectpicker dynamic"
                                                                    data-live-search="true"
                                                                    data-live-search-style="contains"
                                                                    data-dependent="department_name"
                                                                    data-shift_name="shift_name"
                                                                    title="{{__('Selecting',['key'=>trans('file.Company')])}}...">
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->company_name}}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>{{trans('file.Department')}} <span class="text-danger">*</span> </label>
                                                            <input type="hidden" name="department_id_hidden"
                                                               value="{{ $employee->department_id }}"/>
                                                            <select name="department_id" id="department_id"
                                                                    class="selectpicker form-control designation"
                                                                    data-live-search="true"
                                                                    data-live-search-style="contains"
                                                                    data-designation_name="designation_name"
                                                                    title="{{__('Selecting',['key'=>trans('file.Department')])}}...">
                                                                @foreach($departments as $department)
                                                                    <option value="{{$department->id}}">{{$department->department_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.Designation')}} <span class="text-danger">*</span> </label>
                                                        <input type="hidden" name="designation_id_hidden"
                                                               value="{{ $employee->designation_id }}"/>
                                                        <select name="designation_id" id="designation_id"
                                                                class="selectpicker form-control"
                                                                data-live-search="true"
                                                                data-live-search-style="contains"
                                                                title="{{__('Selecting',['key'=>trans('file.Designation')])}}...">
                                                            @foreach($designations as $designation)
                                                                <option value="{{$designation->id}}">{{$designation->designation_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.Role')}} <span class="text-danger">*</span></label>
                                                        <input type="hidden" name="role_user_hidden"
                                                               value="{{ $employee->role_users_id }}"/>
                                                        <select name="role_users_id" id="role_users_id" required @if($employee->role_users_id==1) disabled  @endif
                                                                class="selectpicker form-control"
                                                                data-live-search="true"
                                                                data-live-search-style="contains"
                                                                title="{{__('Selecting',['key'=>trans('file.Role')])}}...">
                                                            {{-- <option value="1">Admin</option>
                                                            <option value="2">Employee</option> --}}
                                                            @foreach($roles as $item)
                                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>{{trans('file.Status')}} <span class="text-danger">*</span></label>
                                                            <input type="hidden" name="status_id_hidden"
                                                               value="{{ $employee->status_id }}"/>
                                                            <select name="status_id" id="status_id" required
                                                                    class="form-control selectpicker"
                                                                    data-live-search="true"
                                                                    data-live-search-style="contains"
                                                                    title="{{__('Selecting',['key'=>trans('file.Status')])}}...">
                                                                @foreach($statuses as $status)
                                                                    <option value="{{$status->id}}">{{$status->status_title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{trans('file.Office_Shift')}} <span class="text-danger">*</span></label>
                                                        <input type="hidden" name="office_shift_id_hidden"
                                                               value="{{ $employee->office_shift_id }}"/>
                                                        <select name="office_shift_id" id="office_shift_id"
                                                                class="selectpicker form-control"
                                                                data-live-search="true"
                                                                data-live-search-style="contains"
                                                                title="{{__('Selecting',['key'=>trans('file.Office Shift')])}}...">
                                                            @foreach($office_shifts as $office_shift)
                                                                <option value="{{$office_shift->id}}">{{$office_shift->shift_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{__('Date Of Joining')}} <span class="text-danger">*</span> </label>
                                                        <input type="text" name="joining_date" id="joining_date"
                                                               autocomplete="off" class="form-control date"
                                                               value="{{$employee->joining_date }}">
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label>{{__('Date Of Leaving')}}</label>
                                                        <input type="text" name="exit_date" id="exit_date"
                                                            class="form-control date"
                                                               value="{{$employee->exit_date}}">
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="text-bold">{{__('Attendance Type')}} <span class="text-danger">*</span></label>
                                                        <select name="attendance_type" id="attendance_type" required class="selectpicker form-control"
                                                                data-live-search="true" data-live-search-style="contains" title="{{__('Select Login Type...')}}">
                                                                <option value="general" @if($employee->attendance_type=='general') selected  @endif>{{__('General')}}</option>
                                                                <option value="ip_based" @if($employee->attendance_type=='ip_based') selected  @endif>{{__('IP Based')}}</option>
                                                        </select>
                                                    </div>

                                                    {{-- <div class="col-md-4 form-group">
                                                        <label>{{__('Total Annual Leave')}}  (Year - {{date('Y')}})</label>
                                                        <input type="number" min="0" name="total_leave" id="total_leave" autocomplete="off" class="form-control" value="{{$employee->total_leave}}">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>{{__('Remaining Leave')}}  (Year - {{date('Y')}})</label>
                                                        <input type="number" readonly name="remaining_leave" id="remaining_leave" autocomplete="off" class="form-control" value="{{$employee->remaining_leave}}">
                                                        <small class="text-danger"><i>(Read Only)</i></small>
                                                    </div> --}}


                                                    {{-- <div class="col-md-4"></div> --}}
                                                    <div class="col-md-4"></div>

                                                    <div class="mt-3 form-group row">
                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-6 offset-md-4">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{trans('file.Save')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        @endcan

                                        @can('view-details-employee')
                                        <div class="tab-pane fade" id="Immigration" role="tabpanel"
                                             aria-labelledby="immigration-tab">
                                            {{__('Assigned Immigration')}}
                                            <hr>
                                            @include('employee.immigration.index')
                                        </div>
                                        <div class="tab-pane fade" id="Emergency" role="tabpanel"
                                             aria-labelledby="emergency-tab">
                                            {{__('Emergency Contacts')}}
                                            <hr>
                                            @include('employee.emergency_contacts.index')
                                        </div>
                                        <div class="tab-pane fade" id="Social_profile" role="tabpanel"
                                             aria-labelledby="social_profile-tab">
                                            {{__('Social Profile')}}
                                            <hr>
                                            @include('employee.social_profile.index')
                                        </div>
                                        <div class="tab-pane fade" id="Document" role="tabpanel"
                                             aria-labelledby="document-tab">
                                            {{__('All Documents')}}
                                            <hr>
                                            @include('employee.documents.index')
                                        </div>
                                        <div class="tab-pane fade" id="Qualification" role="tabpanel"
                                             aria-labelledby="qualification-tab">
                                            {{__('All Qualifications')}}
                                            <hr>
                                            @include('employee.qualifications.index')
                                        </div>
                                        <div class="tab-pane fade" id="Work_experience" role="tabpanel"
                                             aria-labelledby="work_experience-tab">
                                            {{__('Work Experience')}}
                                            <hr>
                                            @include('employee.work_experience.index')
                                        </div>
                                        <div class="tab-pane fade" id="Bank_account" role="tabpanel"
                                             aria-labelledby="bank_account-tab">
                                            {{__('Bank Account')}}
                                            <hr>
                                            @include('employee.bank_account.index')
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <!--Contents for General Ends here-->
                        </div>
                        <div class="tab-pane fade" id="Profile" role="tabpanel" aria-labelledby="profile-tab">
                            <!--Contents for Profile starts here-->
                            {{__('Profile Picture')}}
                            <hr>

                        @include('employee.profile_picture.index')

                        <!--Contents for Profile ends here-->
                        </div>

                        <div class="tab-pane fade" id="Set_salary" role="tabpanel" aria-labelledby="set_salary-tab">
                            <!--Contents for Contact starts here-->
                            {{__('Salary Info')}}
                            <hr>
                        @include('employee.salary.index')

                        <!--Contents for Contact ends here-->
                        </div>

                        <div class="tab-pane fade" id="Leave" role="tabpanel" aria-labelledby="leave-tab">
                            <!--Contents for Contact starts here-->
                            {{__('Leave Info')}}
                            <hr>
                        @include('employee.leave.index')

                        <!--Contents for Contact ends here-->
                        </div>

                        <div class="tab-pane fade" id="Employee_Core_hr" role="tabpanel"
                             aria-labelledby="employee_core_hr-tab">
                            <!--Contents for Contact starts here-->
                            {{__('Core HR')}}
                            <hr>
                        @include('employee.core_hr.award.index')

                        <!--Contents for Contact ends here-->
                        </div>

                        <div class="tab-pane fade" id="Employee_project_task" role="tabpanel"
                             aria-labelledby="employee_project_task-tab">
                            <!--Contents for Contact starts here-->
                            {{trans('file.Project')}} & {{trans('file.Task')}}
                            <hr>
                        @include('employee.project_task.index')

                        <!--Contents for Contact ends here-->
                        </div>

                        <div class="tab-pane fade" id="Employee_Payslip" role="tabpanel"
                             aria-labelledby="employee_payslip-tab">
                            <!--Contents for Contact starts here-->
                            {{trans('file.Payslip')}}
                            <hr>
                            @include('employee.payslip.index')
                            <!--Contents for Contact ends here-->
                        </div>


                        <div class="tab-pane fade" id="remainingLeaveType" role="tabpanel"
                             aria-labelledby="remainingLeaveType-tab">
                            {{trans('file.Remaining Leave')}}
                            <hr>
                            @include('employee.remaining_leave.index')
                        </div>

                    </div>
                </div>
            </div>
        </div>

            @endcan

    </section>



@endsection


@push('scripts')
<script type="text/javascript">

    $('select[name="gender"]').val($('input[name="gender_hidden"]').val());
    $('#role_users_id').selectpicker('val', $('input[name="role_user_hidden"]').val());
    $('#marital_status').selectpicker('val', $('input[name="marital_status_hidden"]').val());

    $('#company_id').selectpicker('val', $('input[name="company_id_hidden"]').val());
    $('#department_id').selectpicker('val', $('input[name="department_id_hidden"]').val());
    $('#designation_id').selectpicker('val', $('input[name="designation_id_hidden"]').val());

    $('#status_id').selectpicker('val', $('input[name="status_id_hidden"]').val());
    $('#office_shift_id').selectpicker('val', $('input[name="office_shift_id_hidden"]').val());


    $(document).ready(function () {

        let date = $('.date');
        date.datepicker({
            format: '{{ env('Date_Format_JS')}}',
            autoclose: true,
            todayHighlight: true
        });

        let month_year = $('.month_year');
        month_year.datepicker({
            format: "MM-yyyy",
            startView: "months",
            minViewMode: 1,
            autoclose: true,
        }).datepicker("setDate", new Date());
    });

    $('[data-table="immigration"]').one('click', function (e) {
            @include('employee.immigration.index_js')

    });

    $('[data-table="emergency"]').one('click', function (e) {
        @include('employee.emergency_contacts.index_js')
    });

    $('[data-table="document"]').one('click', function (e) {
            @include('employee.documents.index_js')
    });

    $('[data-table="qualification"]').one('click', function (e) {
        @include('employee.qualifications.index_js')
    });

    $('[data-table="work_experience"]').one('click', function (e) {
        @include('employee.work_experience.index_js')
    });

    $('[data-table="bank_account"]').one('click', function (e) {
        @include('employee.bank_account.index_js')
    });

    $('#profile-tab').one('click', function (e) {
        @include('employee.profile_picture.index_js')
    });

    $('#set_salary-tab').one('click', function (e) {
       @include('employee.salary.basic.index_js') //employee.salary.index_js.blade.php - both are same
    });

    $('#salary_allowance-tab').one('click', function (e) {
        @include('employee.salary.allowance.index_js')
    });

    $('#salary_commission-tab').one('click', function (e) {
        @include('employee.salary.commission.index_js')
    });

    $('#salary_loan-tab').one('click', function (e) {
        @include('employee.salary.loan.index_js')
    });

    $('#salary_deduction-tab').one('click', function (e) {
        @include('employee.salary.deduction.index_js')
    });

   $('#other_payment-tab').one('click', function (e) {
        @include('employee.salary.other_payment.index_js')
    });

    $('#salary_overtime-tab').one('click', function (e) {
        @include('employee.salary.overtime.index_js')
    });

    $('#salary_pension-tab').one('click', function (e) {
        @include('employee.salary.pension_amount_js')
    });


    $('#leave-tab').one('click', function (e) {
        @include('employee.leave.index_js')
    });


    $('#remainingLeaveType-tab').one('click', function (e) {
        @include('employee.remaining_leave.index_js')
    });



    $('#employee_core_hr-tab').one('click', function (e) {
        @include('employee.core_hr.award.index_js')
    });

    $('#employee_travel-tab').one('click', function (e) {
        @include('employee.core_hr.travel.index_js')
    });

    $('#employee_training-tab').one('click', function (e) {
        @include('employee.core_hr.training.index_js')
    });

    $('#employee_ticket-tab').one('click', function (e) {
        @include('employee.core_hr.ticket.index_js')
    });


    $('#employee_transfer-tab').one('click', function (e) {
        @include('employee.core_hr.transfer.index_js')
    });


    $('#employee_promotion-tab').one('click', function (e) {
        @include('employee.core_hr.promotion.index_js')
    });

    $('#employee_complaint-tab').one('click', function (e) {
        @include('employee.core_hr.complaint.index_js')
    });


    $('#employee_warning-tab').one('click', function (e) {
        @include('employee.core_hr.warning.index_js')
    });

    $('#employee_project_task-tab').one('click', function (e) {
        @include('employee.project_task.project.index_js')

    });

    $('#employee_task-tab').one('click', function (e) {
        @include('employee.project_task.task.index_js')
    });

    $('#employee_payslip-tab').one('click', function (e) {
        @include('employee.payslip.index_js')
    });


    $('#basic_sample_form').on('submit', function (event) {
        event.preventDefault();
        var attendance_type = $("#attendance_type").val();
        // console.log(attendance_type);

        $.ajax({
            url: "{{ route('employees_basicInfo.update',$employee->id) }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                console.log(data);
                var html = '';
                if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if (data.success) {
                    $('#remaining_leave').val(data.remaining_leave)
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                }
                $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            }
        });
    });

    $('.dynamic').change(function () {
        if ($(this).val() !== '') {
            let value = $(this).val();
            let dependent = $(this).data('shift_name');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_office_shifts') }}",
                method: "POST",
                data: {value: value, _token: _token, dependent: dependent},
                success: function (result) {
                    $('select').selectpicker("destroy");
                    $('#office_shift_id').html(result);
                    $('#designation_id').html('');
                    $('select').selectpicker();
                }
            });
        }
    });

    $('.dynamic').change(function () {
        if ($(this).val() !== '') {
            let value = $(this).val();
            let dependent = $(this).data('dependent');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_department') }}",
                method: "POST",
                data: {value: value, _token: _token, dependent: dependent},
                success: function (result) {
                    $('select').selectpicker("destroy");
                    $('#department_id').html(result);
                    $('select').selectpicker();
                }
            });
        }
    });

    $('.designation').change(function () {
        if ($(this).val() !== '') {
            let value = $(this).val();
            let designation_name = $(this).data('designation_name');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_designation_department') }}",
                method: "POST",
                data: {value: value, _token: _token, designation_name: designation_name},
                success: function (result) {
                    $('select').selectpicker("destroy");
                    $('#designation_id').html(result);
                    $('select').selectpicker();

                }
            });
        }
    });

    // Login Type Change
    // $('#login_type').change(function() {
    //     var login_type = $('#login_type').val();
    //     if (login_type=='ip') {
    //         data = '<label class="text-bold">{{__("IP Address")}} <span class="text-danger">*</span></label>';
    //         data += '<input type="text" name="ip_address" id="ip_address" placeholder="Type IP Address" required class="form-control">';
    //         $('#ipField').html(data)
    //     }else{
    //         $('#ipField').empty();
    //     }
    // });
</script>
@endpush
