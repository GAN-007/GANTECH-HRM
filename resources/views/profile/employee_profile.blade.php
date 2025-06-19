@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h2>{{$user->username}}</h2>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#General" role="tab"
                               aria-controls="General" aria-selected="true">{{trans('file.General')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Profile" role="tab"
                               aria-controls="Profile" aria-selected="false">{{trans('file.Profile')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="view_salary-tab" data-toggle="tab" href="#View_salary" role="tab"
                               aria-controls="View_salary" aria-selected="false">{{__('Salary')}}</a>
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
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="General" role="tabpanel"
                             aria-labelledby="general-tab">
                            <!--Contents for General starts here-->
                            {{__('General Info')}}
                            <hr>
                            <div class="row">
                                <div class="col-md-2">
                                    <ul class="nav nav-tabs vertical" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#Basic"
                                               role="tab" aria-controls="Basic"
                                               aria-selected="true">{{trans('file.Basic')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#Immigration"
                                               id="immigration-tab" data-toggle="tab" data-table="immigration"
                                               data-target="#Immigration" role="tab" aria-controls="Immigration"
                                               aria-selected="false">{{trans('file.Immigration')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#Emergency"
                                               id="emergency-tab" data-toggle="tab" data-table="emergency"
                                               data-target="#Emergency" role="tab" aria-controls="Emergency"
                                               aria-selected="false">{{__('Emergency Contacts')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#Social_profile"
                                               id="social_profile-tab" data-toggle="tab" data-table="social_profile"
                                               data-target="#Social_profile" role="tab" aria-controls="Social_profile"
                                               aria-selected="false">{{__('Social Profile')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#Document"
                                               id="document-tab" data-toggle="tab" data-table="document"
                                               data-target="#Document" role="tab" aria-controls="Document"
                                               aria-selected="false">{{trans('file.Document')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#Qualification"
                                               id="qualification-tab" data-toggle="tab" data-table="qualification"
                                               data-target="#Qualification" role="tab" aria-controls="Qualification"
                                               aria-selected="false">{{trans('file.Qualification')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#Work_experience"
                                               id="work_experience-tab" data-toggle="tab" data-table="work_experience"
                                               data-target="#Work_experience" role="tab" aria-controls="Work_experience"
                                               aria-selected="false">{{__('Work Experience')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#Bank_account"
                                               id="bank_account-tab" data-toggle="tab" data-table="bank_account"
                                               data-target="#Bank_account" role="tab" aria-controls="Bank_account"
                                               aria-selected="false">{{__('Bank Account')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#Change_Password"
                                               id="change_password-tab" data-toggle="tab" data-table="change_password"
                                               data-target="#Change_Password" role="tab" aria-controls="Change_Password"
                                               aria-selected="false">{{__('Change Password')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-10">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="Basic" role="tabpanel"
                                             aria-labelledby="basic-tab">
                                            <!--Contents for Basic starts here-->
                                            {{__('Basic Information')}}
                                            <hr>
                                            <div class="container">
                                                <div class="widget-user-image">
                                                    <img src={{ URL::to('/uploads/profile_photos')}}/{{$user->profile_photo ?? 'avatar.jpg'}}  width='150'
                                                         class='rounded-circle'>
                                                    <div class="mt-2">
                                                        <h4 class="font-weight-bold mb-0">{{$employee->full_name}} <span
                                                                    class="text-muted font-weight-normal">@-{{$employee->department->department_name}}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <span id="form_result"></span>
                                                <form method="post" id="basic_sample_form" class="form-horizontal"
                                                      enctype="multipart/form-data" autocomplete="off">

                                                    @csrf
                                                    <div class="row">

                                                        <div class="col-md-4 form-group">
                                                            <label>{{__('First Name')}}</label>
                                                            <input type="text" name="first_name" id="first_name"
                                                                   placeholder="{{__('First Name')}}"
                                                                   required class="form-control"
                                                                   value="{{ $employee->first_name }}">
                                                        </div>

                                                        <div class="col-md-4 form-group">
                                                            <label>{{__('Last Name')}}</label>
                                                            <input type="text" name="last_name" id="last_name"
                                                                   placeholder="{{__('Last Name')}}"
                                                                   required class="form-control"
                                                                   value="{{ $employee->last_name }}">
                                                        </div>



                                                        <div class="col-md-4 form-group">
                                                            <label>{{trans('file.Email')}}</label>
                                                            <input type="text" name="email" id="email"
                                                                   placeholder="{{trans('file.Email')}}"
                                                                   required class="form-control"
                                                                   value="{{ $employee->email }}">
                                                        </div>

                                                        <div class="col-md-4 form-group">
                                                            <label>{{trans('file.Phone')}}</label>
                                                            <input type="text" name="contact_no" id="contact_no"
                                                                   placeholder="{{trans('file.Phone')}}"
                                                                   required class="form-control"
                                                                   value="{{ $employee->contact_no }}">
                                                        </div>

                                                        <div class="col-md-4 form-group">
                                                            <label>{{trans('file.Gender')}} *</label>
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
                                                            <label>{{__('Marital Status')}} *</label>
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


                                                        <div class="col-md-8 form-group">
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
                                                            <label>{{trans('file.State/Province')}} </strong>
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
                                                                        title='{{__('Selecting',['key'=>trans('file.Country')])}}...'>
                                                                    @foreach($countries as $country)
                                                                        <option value="{{$country->id}}" {{ ($employee->country == $country->id) ? "selected" : '' }}>{{$country->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
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

                                        </div>


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
                                        <div class="tab-pane fade" id="Change_Password" role="tabpanel"
                                             aria-labelledby="change_password-tab">
                                            {{__('Change Password')}}
                                            <hr>
                                            @include('profile.employee_related.change_password')
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

                        <div class="tab-pane fade" id="View_salary" role="tabpanel" aria-labelledby="view_salary-tab">
                            <!--Contents for Contact starts here-->
                            {{__('Salary Info')}}
                            <hr>
                        @include('profile.employee_related.salary')

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

                    </div>
                </div>
            </div>
        </div>

    </section>

    <script type="text/javascript">
        (function($) {
          "use strict";

          $('select[name="gender"]').val($('input[name="gender_hidden"]').val());
          $('#role_users_id').selectpicker('val', $('input[name="role_user_hidden"]').val());
          $('#marital_status').selectpicker('val', $('input[name="marital_status_hidden"]').val());


          $(document).ready(function () {

              let date = $('.date');
              date.datepicker({
                  format: '{{ env('Date_Format_JS')}}',
                  autoclose: true,
                  todayHighlight: true
              });
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
            @include('employee.salary.basic.index_js')
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

          $('#leave-tab').one('click', function (e) {
              @include('employee.leave.index_js')
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
              $.ajax({
                  url: "{{ route('employee_profile_update',$employee->id) }}",
                  method: "POST",
                  data: new FormData(this),
                  contentType: false,
                  cache: false,
                  processData: false,
                  dataType: "json",
                  success: function (data) {
                      var html = '';
                      if (data.errors) {
                          html = '<div class="alert alert-danger">';
                          for (var count = 0; count < data.errors.length; count++) {
                              html += '<p>' + data.errors[count] + '</p>';
                          }
                          html += '</div>';
                      }
                      if (data.success) {
                          html = '<div class="alert alert-success">' + data.success + '</div>';
                          html = '<div class="alert alert-success">' + data.success + '</div>';
                      }
                      $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                  }
              });
          });

          $(function(){

              var hash = window.location.hash;


              if (hash == '#Employee_travel' || hash == '#Employee_ticket') {
                  let a = "#Employee_Core_hr";
                  a && $('ul.nav a[href="' + a + '"]').tab('show');
              }
              else {
                  hash && $('ul.nav a[href="' + hash + '"]').tab('show');
              }

              var tab = hash.toLowerCase() + '-tab';

              $( tab ).trigger( "click" );

              $('.nav-tabs a').on('click', function(e) {
                  $(this).tab('show');

                  var scrollmem = $('body').scrollTop();
                  window.location.hash = this.hash;
                  $('html,body').scrollTop(scrollmem);
              });

              // Change tab on hashchange
              window.addEventListener('hashchange', function() {
                  var changedHash = window.location.hash;
                  changedHash && $('ul.nav a[href="' + changedHash + '"]').tab('show');
              }, false);
          });
        })(jQuery);
    </script>

@endsection
