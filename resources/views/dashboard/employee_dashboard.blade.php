@extends('layout.main')
@section('content')

    <section>

    @include('shared.errors')



    <!-- Content -->
        <div class="container-fluid">
            <div class="row">

                <div class="col-3 col-md-2 mb-3">
                    <img src={{ URL::to('/uploads/profile_photos')}}/{{$user->profile_photo ?? 'avatar.jpg'}}  width='150'
                         class='rounded-circle'>
                </div>

                <div class="col-9 col-md-10 mb-3">
                    <h4 class="font-weight-bold">{{$employee->full_name}} <span class="text-muted font-weight-normal"> ({{$user->username}})</span>
                    </h4>
                    <div class="text-muted mb-2">{{$employee->designation->designation_name ?? ''}}, {{$employee->department->department_name ?? ''}}</div>
                    <p class="text-muted">{{__('Last Login')}}: {{$user->last_login_date}}</p>
                    <p class="text-muted">{{__('My Office Shift')}}:
                    @if(!$shift_in)
                        {{__('No Shift Today')}}
                    @else
                        {{$shift_in}} To {{$shift_out}}
                    @endif
                    ({{$shift_name}})</p>
                    <a class="btn btn-default btn-sm" id="my_profile" href="{{route('profile')}}">
                        <i class="dripicons-user"></i> {{trans('file.Profile')}}
                    </a>
                    @if (env('ENABLE_CLOCKIN_CLOCKOUT')!=NULL)
                        <form class="d-inline m1-2" action="{{route('employee_attendance.post',$employee->id)}}" name="set_clocking"
                            id="set_clocking" autocomplete="off" class="form" method="post" accept-charset="utf-8">
                            @csrf

                            <input type="hidden" value="{{$shift_in}}" name="office_shift_in" id="shift_in">
                            <input type="hidden" value="{{$shift_out}}" name="office_shift_out" id="shift_out">
                            <input type="hidden" value="" name="in_out_value" id="in_out">

                            @if(!$employee_attendance || $employee_attendance->clock_in_out== 0)
                                <button class="btn btn-success btn-sm" @if($employee->attendance_type=='ip_based' && $ipCheck!=true) disabled @endif type="submit" id="clock_in_btn"><i class="dripicons-enter"></i> {{__('Clock IN')}}</button>
                            @else
                                <button class="btn btn-danger btn-sm" @if($employee->attendance_type=='ip_based' && $ipCheck!=true) disabled @endif type="submit" id="clock_out_btn"><i class="dripicons-exit"></i> {{__('Clock OUT')}}</button>
                            @endif
                            {{-- <br> --}}
                            @if($employee->attendance_type=='ip_based' && $ipCheck!=true) <small class="text-danger"><i>[Please login with your office's internet to clock in or clock out]</i></small> @endif
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3 mt-4">
                    <div class="d-flex wrapper count-title">
                        <div class="icon blue-text ml-2 mr-3">
                            <i class="dripicons-wallet display-5"></i>
                        </div>
                        <a href="{{route('profile').'#Employee_Payslip'}}">
                            <div class="name"><h4>{{__('Payslip')}}</h4></div>
                            <p>{{ __('View Details') }}</p>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 mt-4">
                    <div class="d-flex wrapper count-title">
                        <div class="icon purple-text ml-2 mr-3">
                            <i class="dripicons-trophy"></i>
                        </div>
                        <a href="{{route('profile').'#Employee_Core_hr'}}">
                            <div class="name"><h4>{{$employee_award_count}} {{__('Award')}}</h4></div>
                            <p>{{ __('View Details') }}</p>
                        </a>
                    </div>
                </div>


                <div class="col-md-3 mt-4">
                    <div class="d-flex wrapper count-title">
                        <div class="icon orange-text ml-2 mr-3">
                            <i class="dripicons-feed"></i>
                        </div>
                        <a href="{{route('announcements.index')}}">
                            <div class="text-center"><h4>{{ count($announcements) }} {{trans('file.Announcement')}}</h4>
                            </div>
                            <p>{{ __('View Details') }}</p>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 mt-4">
                    <div class="d-flex wrapper count-title">
                        <div class="icon green-text ml-2 mr-3">
                            <i class="dripicons-gaming"></i>
                        </div>
                        @if(count($holidays) > 0)
                        <div id="holiday" class="">
                        @else
                        <div class="">
                        @endif
                            <h4>{{ count($holidays) }} {{__('Upcoming Holidays')}}</h4>
                            <p>{{ __('View Details') }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Leave</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-link btn-block" href="{{route('profile').'#Leave'}}">
                                {{__(' View Leave Info')}}
                            </a>
                            <button class="btn btn-light btn-block mt-0" id="leave_request">{{__('Request Leave')}}</button>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Travel</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-link btn-block" href="{{route('profile').'#Employee_travel'}}">
                            {{__('View Travel Info')}}
                        </a>
                            <button class="btn btn-light btn-block mt-0" id="travel_request">{{__('Request Travel')}}</button>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">{{__('Ticket')}}</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-link btn-block"  href="{{route('profile').'#Employee_ticket'}}">
                                {{__('Ticket Info')}}
                            </a>
                            <button class="btn btn-light btn-block mt-0" id="ticket_request">{{__('Open A Ticket')}}</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="container-fluid">
            <div class="row">

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Assigned Projects')}} ({{$assigned_projects_count}})</h4>
                        </div>
                        <div class="card-body list pt-0">
                            <table class="table">
                                <tbody>
                                    @foreach($assigned_projects as $project)
                                        @if (count($project->assignedProjects)!=0)
                                            <tr>
                                                <td>
                                                    <a href="{{route('projects.show',$project->assignedProjects[0]->id)}}"><h5>{{$project->assignedProjects[0]->title}}</h5></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Assigned Tasks')}} ({{$assigned_tasks_count}})</h4>
                        </div>
                        <div class="card-body list pt-0">
                            <table class="table">
                                <tbody>
                                    @foreach($assigned_tasks as $task)
                                        @if (count($task->assignedTasks)!=0)
                                            <tr>
                                                <td>
                                                    <a href="{{route('tasks.show',$task->assignedTasks[0]->id)}}"><h5>{{$task->assignedTasks[0]->task_name}}</h5></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Assigned Tickets')}} ({{$assigned_tickets_count}})</h4>
                        </div>
                        <div class="card-body list pt-0">
                            <table class="table">
                                <tbody>
                                    @foreach($assigned_tickets as $ticket)
                                        @if (count($ticket->assignedTickets)!=0)
                                            <tr>
                                                <td>
                                                    <a href="{{route('tickets.show',$ticket->assignedTickets[0]->ticket_code)}}"><h5>{{$ticket->assignedTickets[0]->subject}}</h5></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="holidayModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{__('Holidays')}}</h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        @foreach($holidays as $holiday)
                            <div><strong class="name blue-text">{{$holiday->event_name}}</strong>{{trans('file.From')}}
                                :{{$holiday->start_date}} {{trans('file.To')}}:{{$holiday->end_date}}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div id="leaveModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{__('Leave Request')}}</h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <span id="leave_form_result"></span>
                        <form method="post" id="leaveSampleForm" class="form-horizontal">

                            @csrf
                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label>{{__('Leave Type')}} *</label>
                                    <select name="leave_type" id="leave_type" class="form-control selectpicker " data-live-search="true" data-live-search-style="contains" title='{{__('Leave Type')}}'>
                                        @foreach($leave_types as $leave_type)
                                            <option value="{{$leave_type->id}}" data-day="{{ $leave_type->allocated_day }}">{{$leave_type->leave_type}}
                                                ({{$leave_type->allocated_day}} Days)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-4 form-group">
                                    <label>{{__('Start Date')}} *</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control date" value="">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>{{__('End Date')}} *</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control test date" value="">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>{{__('Total Days')}}</label>
                                    <input type="text" readonly id="total_days" class="form-control">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="leave_reason">{{trans('file.Description')}}</label>
                                    <textarea class="form-control" id="leave_reason" name="leave_reason"
                                              rows="3"></textarea>
                                </div>

                                <div class="container">
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="company_id" value="{{$employee->company_id}}"/>
                                        <input type="hidden" name="department_id" value="{{$employee->department_id}}"/>
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
                                        <input type="hidden" name="status" value="pending"/>

                                        <input type="hidden" name="diff_date_hidden" id="diff_date_hidden"/>
                                        <input type="submit" name="action_button" class="btn btn-warning"
                                               value={{trans('file.Add')}} />
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div id="travelModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{__('Travel Request')}}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <span id="travel_form_result"></span>
                        <form method="post" id="travel_sample_form" class="form-horizontal">

                            @csrf
                            <div class="row">


                                <div class="col-md-6 form-group">
                                    <label>{{__('Arrangement Type')}}</label>
                                    <select name="travel_type_id" class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='{{__('Selecting',['key'=>trans('file.Arrangement')])}}...'>
                                        @foreach($travel_types as $travel_type)
                                            <option value="{{$travel_type->id}}">{{$travel_type->arrangement_type}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-6 form-group">
                                    <label>{{__('Purpose Of Visit')}} *</label>
                                    <input type="text" name="purpose_of_visit" class="form-control"
                                           placeholder="{{__('Purpose Of Visit')}}">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('Place Of Visit')}} *</label>
                                    <input type="text" name="place_of_visit" class="form-control"
                                           placeholder="{{__('Place Of Visit')}}">
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{trans('file.Description')}}</label>
                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('Start Date')}} *</label>
                                    <input type="text" name="start_date" class="form-control date" autocomplete="off"
                                           value="">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('End Date')}} *</label>
                                    <input type="text" name="end_date" class="form-control date" autocomplete="off"
                                           value="">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('Expected Budget')}}</label>
                                    <input type="text" name="expected_budget" class="form-control">
                                </div>


                                <div class="col-md-6 form-group">
                                    <label>{{__('Travel Mode')}}</label>
                                    <select name="travel_mode" class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='{{__('Travel Mode')}}'>
                                        <option value="By Bus">{{__('By Bus')}}</option>
                                        >
                                        <option value="By Train">{{__('By Train')}}</option>
                                        <option value="By Plane">{{__('By Plane')}}</option>
                                        <option value="By Taxi">{{__('By Taxi')}}</option>
                                        <option value="By Rental Car">{{__('By Rental Car')}}</option>
                                        <option value="By Other">{{__('By Other')}}</option>
                                    </select>
                                </div>


                                <div class="container">
                                    <div class="form-group" align="center">

                                        <input type="hidden" name="company_id" value="{{$employee->company_id}}"/>
                                        <input type="hidden" name="department_id" value="{{$employee->department_id}}"/>
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
                                        <input type="hidden" name="status" value="pending"/>

                                        <input type="submit" name="action_button" class="btn btn-warning"
                                               value={{trans('file.Add')}} />
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div id="ticketModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{__('Open Ticket')}}</h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <span id="ticket_form_result"></span>
                        <form method="post" id="ticket_sample_form" class="form-horizontal"
                              enctype="multipart/form-data">

                            @csrf

                            <div class="row">


                                <div class="col-md-6 form-group">
                                    <label>{{trans('file.Priority')}}</label>
                                    <select name="ticket_priority" id="ticket_priority"
                                            class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='{{__('Selecting',['key'=>trans('file.Priority')])}}...'>
                                        <option value="low">{{trans('file.Low')}}</option>
                                        <option value="medium">{{trans('file.Medium')}}</option>
                                        <option value="high">{{trans('file.High')}}</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{trans('file.Subject')}} *</label>
                                    <input type="text" name="subject" id="subject" class="form-control"
                                           placeholder="{{trans('file.Subject')}}">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('Ticket Note')}}</label>
                                    <input type="text" name="ticket_note" id="ticket_note" class="form-control"
                                           placeholder="{{trans('file.Optional')}}">
                                </div>

                                <div class="col-md-6 form-group hide_edit">
                                    <label>{{__('Ticket Attachments')}} </label>
                                    <input type="file" name="ticket_attachments" id="ticket_attachments"
                                           class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{trans('file.Description')}}</label>
                                        <textarea class="form-control" id="description" name="description"
                                                  rows="3"></textarea>
                                    </div>
                                </div>


                                <div class="container">
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="company_id" value="{{$employee->company_id}}"/>
                                        <input type="hidden" name="department_id" value="{{$employee->department_id}}"/>
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
                                        {{-- <input type="hidden" name="ticket_status" value="pending"/> --}}
                                        <input type="hidden" name="ticket_status" value="open"/>

                                        <input type="submit" name="action_button" class="btn btn-warning"
                                               value={{trans('file.Add')}} />

                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <script>
            (function($) {
                "use strict";


                let startDateInput = $('#start_date');
                let endDateInput = $('#end_date');
                let totalDaysInput = $('#total_days');

                $(document).ready(function () {
                    let date = $('.date');
                    date.datepicker({
                        format: '{{ env('Date_Format_JS')}}',
                        autoclose: true,
                        todayHighlight: true,
                        startDate: new Date(),
                    });

                    // const startDateInput = $('#start_date');
                    // const endDateInput = $('#end_date');
                    // const totalDaysInput = $('#total_days');

                    startDateInput.on('change', function() {
                        getDateResult();
                    });

                    endDateInput.on('change', function() {
                        getDateResult();
                    });

                    const getDateResult = ()  => {

                        // Convert Date formate to YYYY-MM-DD
                        if (!startDateInput.val() || !endDateInput.val()) {
                            return;
                        }

                        let startDateFormat = convertDataFormat(startDateInput.val());
                        let endDateFormat = convertDataFormat(endDateInput.val());

                        let startDate = new Date(startDateFormat);
                        let endDate = new Date(endDateFormat);
                        let timeDiff = endDate.getTime() - startDate.getTime();
                        // Convert the difference from milliseconds to days and update the totalDays input field
                        let totalDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                        if (totalDays < 0) {
                            totalDaysInput.val(0);
                        }else {
                            totalDaysInput.val(totalDays);
                        }
                    }

                    const convertDataFormat = getDateValue => {
                        const inputDate = getDateValue;
                        const parts = inputDate.split("-");
                        const date = new Date(parts[2], parts[1] - 1, parts[0]);
                        const outputDate = date.toISOString().substring(0, 10);
                        return outputDate;
                    }
                });

                // let date = $('.date');
                // date.datepicker({
                //     format: '{{ env('Date_Format_JS')}}',
                //     autoclose: true,
                //     todayHighlight: true
                // });

                $('#holiday').on('click', function () {
                    $('#holidayModal').modal('show');
                });

                $('#leave_request').on('click', function () {
                    $('#leaveModal').modal('show');
                });

                $('#travel_request').on('click', function () {
                    $('#travelModal').modal('show');
                });

                $('#ticket_request').on('click', function () {
                    $('#ticketModal').modal('show');
                });


                $('#leaveSampleForm').on('submit', function (event) {
                    event.preventDefault();

                    let start_date = $("#start_date").datepicker('getDate');
                    let end_date = $("#end_date").datepicker('getDate');
                    let dayDiff = Math.ceil((end_date - start_date) / (1000 * 60 * 60 * 24)) + 1;
                    $('#diff_date_hidden').val(dayDiff);

                    let allocatedDay = $("#leave_type option:selected").data('day');

                    let  html = '';
                    if (allocatedDay < totalDaysInput.val()) {
                        html += '<div class="alert alert-danger">' + '<p>Insufficient Allocated Day</p>' + '</div>';
                        return $('#leave_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }

                    $.ajax({
                        url: "{{ route('leaves.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            console.log(data);

                            if (data.errors) {
                                html += '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            else if (data.limit) {
                                html += '<div class="alert alert-danger">' + data.limit + '</div>';
                            }
                            else if (data.remaining_leave) {
                                html += '<div class="alert alert-danger">' + data.remaining_leave + '</div>';
                            }
                            else if (data.error) {
                                html += '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            else if (data.success) {
                                html += '<div class="alert alert-success">' + data.success + '</div>';
                                $('#leaveSampleForm')[0].reset();
                                $('select').selectpicker('refresh');
                                $('.date').datepicker('update');
                            }
                            $('#leave_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    });



                });

                $('#travel_sample_form').on('submit', function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: "{{ route('travels.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.error) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#travel_sample_form')[0].reset();
                                $('select').selectpicker('refresh');
                                $('.date').datepicker('update');
                            }
                            $('#travel_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    })
                });


                $('#ticket_sample_form').on('submit', function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: "{{ route('tickets.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#ticket_sample_form')[0].reset();
                                $('select').selectpicker('refresh');
                            }
                            $('#ticket_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    })
                });

            })(jQuery);
        </script>
    </section>
@endsection
