@php
    $general_settings = \App\Models\GeneralSetting::latest()->first();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="icon" type="image/png" href="{{url('logo', $general_settings->site_logo) ?? 'NO Logo'}}">
    <title>{{$general_settings->site_title ?? "NO Title"}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css') }}"
          type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}"
          type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap-datepicker.min.css') }}"
          type="text/css">

    <link rel="stylesheet" href="{{ asset('vendor/jquery-clockpicker/bootstrap-clockpicker.min.css') }}"
          type="text/css">
    <!-- Boostrap Tag Inputs-->
    <link rel="stylesheet" href="{{ asset('vendor/Tag_input/tagsinput.css') }}" type="text/css">

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap-select.min.css') }}"
          type="text/css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}"
          type="text/css">
    <!-- Dripicons icon font-->
    <link rel="stylesheet" href="{{ asset('vendor/dripicons/webfont.css') }}" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="{{ asset('css/grasp_mobile_progress_circle-1.0.0.min.css') }}" type="text/css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="{{ asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}" type="text/css">
    <!-- date range stylesheet-->
    <link rel="stylesheet" href="{{ asset('vendor/daterange/css/daterangepicker.min.css') }}"
          type="text/css">
    <!-- table sorter stylesheet-->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/datatable/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/datatable/dataTables.checkboxes.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/datatable/datatables.flexheader.boostrap.min.css') }}">

    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">

    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/RangeSlider/ion.rangeSlider.min.css') }}">

    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/datatable/datatable.responsive.boostrap.min.css') }}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet"
          type="text/css">

    <link rel="stylesheet" href="{{ asset('vendor/translation/css/main.css') }}">

    {{-- @stack('lang_css') --}}



    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/jquery/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript"
            src="{{ asset('vendor/jquery-clockpicker/bootstrap-clockpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/popper.js/umd/popper.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/bootstrap/js/bootstrap-select.min.js') }}"></script>

    <script type="text/javascript"
            src="{{ asset('js/grasp_mobile_progress_circle-1.0.0.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/charts-custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/front.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterange/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterange/js/knockout-3.4.2.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/daterange/js/daterangepicker.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

    <!-- JS for Boostrap Tag Inputs-->

    <script type="text/javascript" src="{{ asset('vendor/Tag_input/tagsinput.js') }}"></script>

    <script type="text/javascript"
            src="{{ asset('vendor/RangeSlider/ion.rangeSlider.min.js') }}"></script>

    <!-- table sorter js-->
    <script type="text/javascript" src="{{ asset('vendor/datatable/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/vfs_fonts.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/buttons.print.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/dataTables.select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/sum().js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/dataTables.checkboxes.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/datatable.fixedheader.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/datatable.responsive.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/datatable/datatable.responsive.boostrap.min.js') }}"></script>
    <style type="text/css">
        svg{width:20px;}
    </style>
</head>
<body>
<!-- navbar-->
<header class="header">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <a id="toggle-btn" href="#" class="menu-btn"><i class="dripicons-menu"> </i></a>
                <span class="brand-big">
                    @if($general_settings->site_logo)
                        <img src="{{asset('/images/logo/logo.png')}}" width="50">
                        &nbsp; &nbsp;
                    @endif
                    <h1 class="d-inline">{{$general_settings->site_title ?? "No title"}}</h1></span>


                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <li class="nav-item"><a id="btnFullscreen" href="" data-toggle="tooltip" title="{{__('Full Screen')}}"><i class="dripicons-expand"></i></a></li>
                    <li class="nav-item">
                        <a rel="nofollow" id="notify-btn"  href="#" class="nav-link dropdown-item" data-toggle="tooltip" title="{{__('Notifications')}}">
                            <i class="dripicons-bell"></i>
                            @if(auth()->user()->unreadNotifications->count())
                                <span class="badge badge-danger">
                                    {{auth()->user()->unreadNotifications->count()}}
                                </span>
                            @endif
                        </a>
                        <ul class="right-sidebar">
                            <li class="header">
                                <span class="pull-right"><a href="{{route('clearAll')}}">{{__('Clear All')}}</a></span>
                                <span class="pull-left"><a href="{{route('seeAllNoti')}}">{{__('See All')}}</a></span>
                            </li>
                            @foreach(auth()->user()->notifications as $notification)
                                <li><a class="unread-notification"
                                       href={{$notification->data['link']}}>{{$notification->data['data']}}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a rel="nofollow" href="#" class="nav-link dropdown-item">
                            <i class="dripicons-web"></i> <span>{{__('Language')}}</span>
                        </a>
                        <ul class="right-sidebar">

                        </ul>
                    </li>
                    @if (Auth::user()->role_users_id==1)
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('help/index.html')}}" target="_blank" data-toggle="tooltip"
                            title="{{__('Help')}}">
                                <i class="dripicons-information"></i>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a rel="nofollow" href="#" class="nav-link dropdown-item">
                            @if(!empty(auth()->user()->profile_photo))
                            <img class="profile-photo sm mr-1" src="{{ asset('uploads/profile_photos/')}}/{{auth()->user()->profile_photo}}">
                            @else
                            <img class="profile-photo sm mr-1" src="{{ asset('uploads/profile_photos/avatar.jpg')}}">
                            @endif
                            <span> {{auth()->user()->username}}</span>
                        </a>
                        <ul class="right-sidebar">
                            <li>
                                <a href="{{route('profile')}}">
                                    <i class="dripicons-user"></i>
                                    {{trans('file.Profile')}}
                                </a>
                            </li>
                            @if(auth()->user()->role_users_id == 1)
                                <li id="empty_database">
                                    <a href="#">
                                        <i class="dripicons-stack"></i>
                                        {{__('Empty Database')}}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->role_users_id == 1)
                                <li id="export_database">
                                    <a href="{{route('export_database')}}">
                                        <i class="dripicons-cloud-download"></i>
                                        {{__('Export Database')}}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-link" type="submit"><i class="dripicons-exit"></i> {{trans('file.logout')}}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>


<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">
                @if(auth()->user()->role_users_id ==1)
                    <li class="{{ (request()->is('admin/dashboard*')) ? 'active' : '' }}"><a
                                href="{{url('/admin/dashboard')}}"> <i
                                    class="dripicons-meter"></i><span>{{trans('file.Dashboard')}}</span></a>
                    </li>
                @else
                    <li class="{{ (request()->is('employee/dashboard*')) ? 'active' : '' }}"><a
                                href="{{url('/employee/dashboard')}}"> <i
                                    class="dripicons-meter"></i><span>{{trans('file.Dashboard')}}</span></a>
                    </li>
                @endif

                @can('user')
                    <li class="has-dropdown @if(request()->is('user*')){{ (request()->is('user*')) ? 'active' : '' }}@elseif(request()->is('add-user*')){{ (request()->is('add-user*')) ? 'active' : '' }}@endif">
                        @if(auth()->user()->can('view-user'))
                            <a href="#users" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-user"></i>
                                <span>{{trans('file.User')}}</span>
                            </a>
                        @endif
                        <ul id="users" class="collapse list-unstyled ">
                            @can('view-user')
                                <li id="users-menu"><a href="{{route('users-list')}}">{{__('Users List')}}</a></li>
                            @endcan
                            {{-- @can('role-access-user')
                                <li id="user-roles"><a
                                            href={{route('user-roles')}}>{{__('User Roles and Access')}}</a></li>
                            @endcan --}}
                            @can('role-access-user')
                                <li id="user-roles"><a
                                            href={{route('user-roles')}}>{{__('Assign Role')}}</a></li>
                            @endcan
                            @can('last-login-user')
                                <li id="user-last-login"><a
                                            href="{{route('login-info')}}">{{__('Users Last Login')}}</a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                @can('view-details-employee')
                    <li class="has-dropdown {{ (request()->is('staff*')) ? 'active' : '' }}">
                        <a href="#employees" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-user-group"></i><span>{{trans('file.Employees')}}</span></a>
                        <ul id="employees" class="collapse list-unstyled ">
                            @can('view-details-employee')
                                <li id="employee_list"><a href="{{route('employees.index')}}">{{__('Employee Lists')}}</a></li>
                            @endcan
                            @can('import-employee')
                                <li id="user-import"><a href="{{route('employees.import')}}">{{__('Import Employees')}}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('customize-setting')
                    <li class="has-dropdown {{ (request()->is('settings*')) ? 'active' : '' }}">


                        @if(auth()->user()->can('view-role')||auth()->user()->can('view-general-setting')||auth()->user()->can('access-language')||auth()->user()->can('access-variable_type')||auth()->user()->can('access-variable_method')||auth()->user()->can('view-general-setting'))
                            <a href="#Customize_settings" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-toggles"></i><span>{{__('Customize Setting')}}</span>
                            </a>
                        @endif
                        {{-- <a href="#Customize_settings" aria-expanded="false" data-toggle="collapse">
                            <i class="dripicons-toggles"></i><span>{{__('Customize Setting')}}</span>
                        </a> --}}

                        <ul id="Customize_settings" class="collapse list-unstyled ">
                            @can('view-role')
                                <li id="roles"><a href="{{route('roles.index')}}">{{__('Roles and Access')}}</a></li>
                            @endcan
                            @can('view-general-setting')
                                <li id="general_settings"><a
                                            href="{{route('general_settings.index')}}">{{__('General Settings')}}</a>
                                </li>
                            @endcan

                            @can('view-mail-setting')
                                <li id="mail_setting"><a
                                            href="{{route('setting.mail')}}">{{__('Mail Setting')}}</a>
                                </li>
                            @endcan

                            @can('access-language')
                                <li id="language_switch"><a
                                            href="{{route('languages.translations.index','English')}}">{{__('Language Settings')}}</a>
                                </li>
                            @endcan

                            @can('access-variable_type')
                                <li id="variable_type"><a
                                            href="{{route('variables.index')}}">{{__('Variable Type')}}</a>
                                </li>
                            @endcan
                            @can('access-variable_method')
                                <li id="variable_method"><a
                                            href="{{route('variables_method.index')}}">{{__('Variable Method')}}</a>
                                </li>
                            @endcan
                            @can('view-general-setting')
                                <li id="ip_setting"><a href="{{route('ip_setting.index')}}">{{__('IP Settings')}}</a></li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                @can('core_hr')
                    <li class="has-dropdown {{ (request()->is('core_hr*')) ? 'active' : '' }}">

                        @if(auth()->user()->can('view-promotion')||auth()->user()->can('view-award') || auth()->user()->can('view-travel')||auth()->user()->can('view-transfer')||auth()->user()->can('view-resignation')||auth()->user()->can('view-complaint')||auth()->user()->can('view-warning')||auth()->user()->can('view-termination'))
                            <a href="#Core_hr" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-briefcase"></i><span>{{__('Core HR')}}</span>
                            </a>
                        @endcan

                        <ul id="Core_hr" class="collapse list-unstyled">

                            @can('view-promotion')
                                <li id="promotion"><a
                                            href="{{route('promotions.index')}}">{{trans('file.Promotion')}}</a>
                                </li>
                            @endcan
                            @can('view-award')
                                <li id="award"><a href="{{route('awards.index')}}">{{trans('file.Award')}}</a></li>
                            @endcan
                            @can('view-travel')
                                <li id="travel"><a href="{{route('travels.index')}}">{{trans('file.Travel')}}</a></li>
                            @endcan
                            @can('view-transfer')
                                <li id="transfer"><a href="{{route('transfers.index')}}">{{trans('file.Transfer')}}</a>
                                </li>
                            @endcan
                            @can('view-resignation')
                                <li id="resignation"><a
                                            href="{{route('resignations.index')}}">{{trans('file.Resignations')}}</a>
                                </li>
                            @endcan
                            @can('view-complaint')
                                <li id="complaint"><a
                                            href="{{route('complaints.index')}}">{{trans('file.Complaints')}}</a>
                                </li>
                            @endcan
                            @can('view-warning')
                                <li id="warning"><a href="{{route('warnings.index')}}">{{trans('file.Warnings')}}</a>
                                </li>
                            @endcan
                            @can('view-termination')
                                <li id="termination"><a
                                            href="{{route('terminations.index')}}">{{trans('file.Terminations')}}</a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan


                <li class="has-dropdown {{ (request()->is('organization*')) ? 'active' : '' }}"><a href="#Organization"
                                                                                                   aria-expanded="false"
                                                                                                   data-toggle="collapse">
                        <i
                                class="dripicons-view-thumb"></i><span>{{trans('file.Organization')}}</span></a>
                    <ul id="Organization" class="collapse list-unstyled ">
                        @can('view-company')
                            <li id="company"><a href="{{route('companies.index')}}">{{trans('file.Company')}}</a></li>
                        @endcan
                        @can('view-department')
                            <li id="department"><a
                                        href="{{route('departments.index')}}">{{trans('file.Department')}}</a>
                            </li>
                        @endcan

                        @can('view-location')
                            <li id="location"><a href="{{route('locations.index')}}">{{trans('file.Location')}}</a></li>
                        @endcan
                        @can('view-designation')
                            <li id="designation"><a
                                        href="{{route('designations.index')}}">{{trans('file.Designation')}}</a>
                            </li>
                        @endcan

                        <li id="announcements"><a
                                    href="{{route('announcements.index')}}">{{trans('file.Announcements')}}</a></li>

                        <li id="company_policy"><a href="{{route('policy.index')}}">{{__('Company Policy')}}</a>
                        </li>

                    </ul>
                </li>

                @can('timesheet')
                    <li class="has-dropdown {{ (request()->is('timesheet*')) ? 'active' : '' }}"><a href="#Timesheets"
                                                                                                    aria-expanded="false"
                                                                                                    data-toggle="collapse">
                            <i class="dripicons-clock"></i><span>{{trans('file.Timesheets')}}</span></a>
                        <ul id="Timesheets" class="collapse list-unstyled ">
                        {{-- @can('view-attendance') --}}
                                {{-- <li id="attendance"><a
                                            href="{{route('attendances.index')}}">{{trans('file.Attendances')}}</a>
                                </li>
                                <li id="date_wise_attendance"><a
                                            href="{{route('date_wise_attendances.index')}}"> {{__('Date wise Attendances')}}</a>
                                </li>


                                <li id="monthly_attendance"><a
                                            href="{{route('monthly_attendances.index')}}"> {{__('Monthly Attendances')}}</a>
                                </li> --}}
                        {{-- @endcan  --}}

                            @can('edit-attendance')
                                <li id="update_attendance"><a
                                            href="{{route('update_attendances.index')}}"> {{__('Add/Update Attendances')}}</a>
                                </li>
                            @endcan

                            @can('import-attendance')
                                <li id="import_attendance"><a
                                            href="{{route('attendances.import')}}"> {{__('Import Attendances')}}</a>
                                </li>
                            @endcan
                            @can('view-office_shift')
                                <li id="office_shift"><a
                                            href="{{route('office_shift.index')}}">{{__('Office Shift')}}</a>
                                </li>
                            @endcan
                            @can('view-holiday')
                                <li id="holiday"><a href="{{route('holidays.index')}}">{{__('Manage Holiday')}}</a></li>
                            @endcan
                            @can('view-leave')
                                <li id="leave"><a href="{{route('leaves.index')}}">{{__('Manage Leaves')}}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('payment-module')
                    <li class="has-dropdown {{ (request()->is('payroll*')) ? 'active' : '' }}">

                        @if(auth()->user()->can('view-payslip') || auth()->user()->can('view-paylist'))
                            <a href="#Payroll" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-wallet"></i><span>{{trans('file.Payroll')}}</span>
                            </a>
                        @endif

                        <ul id="Payroll" class="collapse list-unstyled ">
                            @can('view-payslip')
                                <li><a href="{{route('payroll.index')}}">{{__('New Payment')}}</a>
                                </li>
                            @endcan
                            @can('view-paylist')
                                <li><a href="{{route('payment_history.index')}}">{{__('Payment History')}}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan


                @can('performance')
                        <li class="has-dropdown {{ (request()->is('performance*')) ? 'active' : '' }}">
                            @if(auth()->user()->can('view-goal-type') || auth()->user()->can('view-goal-tracking') || auth()->user()->can('view-indicator') || auth()->user()->can('view-appraisal'))
                                <a href="#performance" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart"></i>
                                    <span>Performance</span>
                                </a>
                            @endif
                            <ul id="performance" class="collapse list-unstyled ">
                                @can('view-goal-type')
                                    <li id="goal-type"><a href="{{route('performance.goal-type.index')}}">{{__('Goal type')}}</a></li>
                                @endcan
                                @can('view-goal-tracking')
                                    <li id="goal-tracking"><a href="{{route('performance.goal-tracking.index')}}">{{__('Goal Tracking')}}</a></li>
                                @endcan
                                @can('view-indicator')
                                    <li id="indicator"><a href="{{route('performance.indicator.index')}}">{{__('Indicator')}}</a></li>
                                @endcan
                                @can('view-appraisal')
                                    <li id="appraisal"><a href="{{route('performance.appraisal.index')}}">{{__('Appraisal')}}</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                @can('view-calendar')
                    <li class="{{ (request()->is('calendar*')) ? 'active' : '' }}"><a
                                href="{{route('calendar.index')}}"> <i
                                    class="dripicons-calendar"></i><span>{{__('HR Calendar')}}</span></a>
                    </li>
                @endcan

                {{-- @can('hr_report') --}}
                    <li class="has-dropdown {{ (request()->is('report*')) ? 'active' : '' }}"><a href="#HR_Reports"
                                                                                                 aria-expanded="false"
                                                                                                 data-toggle="collapse">
                            <i class="dripicons-document"></i><span>{{__('HR Reports')}}</span></a>
                        <ul id="HR_Reports" class="collapse list-unstyled ">

                            {{-- @can('report-payslip')
                                <li id="payslip_report"><a
                                            href="{{route('report.payslip')}}">{{__('Payslip Report')}}</a>
                                </li>
                            @endcan --}}

                            <!--New added-->
                            <li id="attendance"><a href="{{route('attendances.index')}}">{{__('Daily Attendances')}}</a></li>
                            <li id="date_wise_attendance"><a href="{{route('date_wise_attendances.index')}}"> {{__('Date wise Attendances')}}</a></li>
                            <li id="monthly_attendance"><a href="{{route('monthly_attendances.index')}}"> {{__('Monthly Attendances')}}</a></li>
                            <!--New added End-->

                            {{-- @can('report-attendance')
                                <li id="attendance_report"><a
                                            href="{{route('report.attendance')}}">{{__('Attendance Report')}}</a>
                                </li>
                            @endcan --}}

                            @can('report-training')
                                <li id="training_report"><a
                                            href="{{route('report.training')}}">{{__('Training Report')}}</a>
                                </li>
                            @endcan
                            @can('report-project')
                                <li id="project_report"><a
                                            href="{{route('report.project')}}">{{__('Project Report')}}</a>
                                </li>
                            @endcan
                            @can('report-task')
                                <li id="task_report"><a
                                            href="{{route('report.task')}}">{{__('Task Report')}}</a></li>
                            @endcan
                            @can('report-employee')
                                <li id="employees_report"><a
                                            href="{{route('report.employees')}}">{{__('Employees Report')}}</a>
                                </li>
                            @endcan
                            @can('report-account')
                                <li id="account_report"><a
                                            href="{{route('report.account')}}">{{__('Account Report')}}</a>
                                </li>
                            @endcan
                            @can('report-expense')
                                <li id="expense_report"><a
                                            href="{{route('report.expense')}}">{{__('Expense Report')}}</a>
                                </li>
                            @endcan
                            @can('report-deposit')
                                <li id="deposit_report"><a
                                            href="{{route('report.deposit')}}">{{__('Deposit Report')}}</a>
                                </li>
                            @endcan
                            @can('report-transaction')
                                <li id="transaction_report"><a
                                            href="{{route('report.transaction')}}">{{__('Transaction Report')}}</a>
                                </li>
                            @endcan

                            {{-- New --}}
                            @can('report-pension')
                                <li id="pension_report"><a href="{{route('report.pension')}}">{{__('Pension Report')}}</a></li>
                            @endcan
                        </ul>
                    </li>
                {{-- @endcan --}}

                @can('recruitment')
                    <li class="has-dropdown {{ (request()->is('recruitment*')) ? 'active' : '' }}">

                        @if(auth()->user()->can('view-job_post') || auth()->user()->can('view-job_candidate')|| auth()->user()->can('view-job_interview') || auth()->user()->can('view-cms'))
                            <a href="#Recruitment" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-user-id"></i><span>{{trans('file.Recruitment')}}</span>
                            </a>
                        @endif

                        <ul id="Recruitment" class="collapse list-unstyled ">

                            @can('view-job_post')
                                <li id="job_post"><a
                                            href="{{route('job_posts.index')}}">{{__('Job Post')}}</a></li>
                            @endcan
                            @can('view-job_candidate')
                                <li id="job_candidate"><a
                                            href="{{route('job_candidates.index')}}">{{__('Job Candidates')}}</a>
                                </li>
                            @endcan
                            @can('view-job_interview')
                                <li id="job_interview"><a
                                            href="{{route('job_interviews.index')}}">{{__('Job Interview')}}</a>
                                </li>
                            @endcan
                            @can('view-cms')
                                <li id="cms"><a
                                            href="{{route('cms.index')}}">{{__('CMS')}}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('training_module')
                    <li class="has-dropdown @if(request()->is('training*')){{ (request()->is('training*')) ? 'active' : '' }}@elseif(request()->is('dynamic_variable/training_type*')){{ (request()->is('dynamic_variable/training_type*')) ? 'active' : '' }}@endif">
                        @if(auth()->user()->can('view-training') || auth()->user()->can('access-variable_type')|| auth()->user()->can('access-trainer'))
                            <a href="#Training" aria-expanded="false" data-toggle="collapse"> <i
                                        class="dripicons-trophy"></i><span>{{trans('file.Training')}}</span>
                            </a>
                        @endcan
                        <ul id="Training" class="collapse list-unstyled ">
                            @can('view-training')
                                <li id="training_list"><a
                                            href="{{route('training_lists.index')}}">{{__('Training List')}}</a>
                                </li>
                            @endcan
                            @can('access-variable_type')
                                <li id="training_type"><a
                                            href="{{route('training_type.index')}}">{{__('Training Type')}}</a>
                                </li>
                            @endcan
                            @can('view-trainer')
                                <li id="trainers"><a
                                            href="{{route('trainers.index')}}">{{trans('file.Trainers')}}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('event-meeting')
                    <li class="has-dropdown @if(request()->is('events*')){{ (request()->is('events*')) ? 'active' : '' }}@elseif(request()->is('meetings*')){{ (request()->is('meetings*')) ? 'active' : '' }}@endif">

                        @if(auth()->user()->can('view-event') || auth()->user()->can('view-meeting'))
                            <a href="#Events_Meetings" aria-expanded="false" data-toggle="collapse"> <i
                                        class="dripicons-to-do"></i><span>{{trans('file.Events')}} & {{trans('file.Meetings')}}</span>
                            </a>
                        @endcan
                        <ul id="Events_Meetings" class="collapse list-unstyled ">
                            @can('view-event')
                                <li id="events"><a
                                            href="{{route('events.index')}}">{{trans('file.Events')}}</a>
                                </li>
                            @endcan
                            @can('view-meeting')
                                <li id="meetings"><a
                                            href="{{route('meetings.index')}}">{{trans('file.Meetings')}}</a>
                                </li>
                            @endcan
                        </ul>
                        @endcan
                    </li>

                    @can('project-management')
                        <li class="has-dropdown {{ (request()->is('project-management*')) ? 'active' : '' }}">
                            @if(auth()->user()->can('view-project') || auth()->user()->can('view-task') || auth()->user()->can('client') || auth()->user()->can('view-invoice'))
                                <a href="#Project_Management" aria-expanded="false" data-toggle="collapse">
                                    <i class="dripicons-checklist"></i><span>{{__('Project Management')}}</span>
                                </a>
                            @endcan
                            <ul id="Project_Management" class="collapse list-unstyled ">
                                @can('view-project')
                                    <li id="projects"><a
                                                href="{{route('projects.index')}}">{{trans(('file.Projects'))}}</a>
                                    </li>
                                @endcan
                                @can('view-task')
                                    <li id="tasks"><a
                                                href="{{route('tasks.index')}}">{{trans(('file.Tasks'))}}</a>
                                    </li>
                                @endcan
                                @can('client')
                                    <li id="clients"><a
                                                href="{{route('clients.index')}}">{{trans(('file.Client'))}}</a>
                                    </li>
                                @endcan
                                @can('view-invoice')
                                    <li id="invoices"><a
                                                href="{{route('invoices.index')}}">{{trans(('file.Invoice'))}}</a>
                                    </li>
                                @endcan
                                @can('access-variable_type')
                                    <li id="tax_type"><a
                                                href="{{route('tax_type.index')}}">{{__('Tax Type')}}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('view-ticket')
                        <li class="{{ (request()->is('tickets*')) ? 'active' : '' }}">
                                <a href="{{route('tickets.index')}}"> <i
                                            class="dripicons-ticket"></i><span>{{__('Support Tickets')}}</span>
                                </a>
                        </li>
                    @endcan
                    @can('finance')
                        <li class="has-dropdown {{ (request()->is('accounting*')) ? 'active' : '' }}">

                            @if(auth()->user()->can('view-account') || auth()->user()->can('view-payee') || auth()->user()->can('view-payer') ||auth()->user()->can('view-deposit')||auth()->user()->can('view-expense')||auth()->user()->can('view-transaction')||auth()->user()->can('view-balance_transfer'))
                                <a href="#Finance" aria-expanded="false" data-toggle="collapse">
                                    <i class="dripicons-graph-pie"></i><span>{{trans('file.Finance')}}</span>
                                </a>
                            @endcan

                            <ul id="Finance" class="collapse list-unstyled ">
                                @can('view-account')
                                    <li id="accounting_list"><a
                                                href="{{route('accounting_list.index')}}">{{__('Accounts List')}}</a>
                                    </li>
                                @endcan
                                @can('view-account')
                                    <li id="account_balances"><a
                                                href="{{route('account_balances')}}">{{__('Account Balances')}}</a>
                                    </li>
                                @endcan
                                @can('view-payee')
                                    <li id="payees"><a
                                                href="{{route('payees.index')}}">{{trans(('file.Payee'))}}</a>
                                    </li>
                                @endcan
                                @can('view-payer')
                                    <li id="payers"><a
                                                href="{{route('payers.index')}}">{{trans(('file.Payer'))}}</a>
                                    </li>
                                @endcan
                                @can('view-deposit')
                                    <li id="deposit"><a
                                                href="{{route('deposit.index')}}">{{trans(('file.Deposit'))}}</a>
                                    </li>
                                @endcan
                                @can('view-expense')
                                    <li id="expense"><a
                                                href="{{route('expense.index')}}">{{trans(('file.Expense'))}}</a>
                                    </li>
                                @endcan
                                @can('view-transaction')
                                    <li id="transactions"><a
                                                href="{{route('transactions.index')}}">{{trans(('file.Transaction'))}}</a>
                                    </li>
                                @endcan
                                @can('view-balance_transfer')
                                    <li id="finance_transfer"><a
                                                href="{{route('finance_transfer.index')}}">{{trans(('file.Transfer'))}}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('assets-and-category')
                        <li class="has-dropdown @if(request()->is('assets*')){{ (request()->is('assets*')) ? 'active' : '' }}@elseif(request()->is('dynamic_variable/assets_category*')){{ (request()->is('dynamic_variable/assets_category*')) ? 'active' : '' }}@endif">
                            @if(auth()->user()->can('category') || auth()->user()->can('assets'))
                                <a href="#assets" aria-expanded="false" data-toggle="collapse"> <i
                                            class="dripicons-box"></i><span>{{trans(('file.Assets'))}}</span>
                                </a>
                            @endcan
                            <ul id="assets" class="collapse list-unstyled ">
                                @can('category')
                                    <li id="assets_category"><a
                                        href="{{route('assets_category.index')}}">{{trans(('file.Category'))}}</a>
                                    </li>
                                @endcan

                                @can('assets')
                                    <li id="assets"><a href="{{route('assets.index')}}">{{trans(('file.Assets'))}}</a></li>
                                @endcan

                            </ul>
                        </li>
                    @endcan

                    @can('file_module')
                        <li class="has-dropdown {{ (request()->is('file_manager*')) ? 'active' : '' }}">

                            @if(auth()->user()->can('view-file_manager') || auth()->user()->can('view-official_documents'))
                                <a href="#file_manager" aria-expanded="false" data-toggle="collapse"> <i
                                            class="dripicons-archive"></i><span>{{__('File Manager')}}</span>
                                </a>
                            @endcan

                            <ul id="file_manager" class="collapse list-unstyled ">

                                @can('view-file_manager')
                                    <li id="files"><a
                                                href="{{route('files.index')}}">{{__('File Manager')}}</a>
                                    </li>
                                @endcan

                                @can('view-official_documents')
                                    <li id="official_documents"><a
                                                href="{{route('official_documents.index')}}">{{__('Official Documents')}}</a>
                                    </li>
                                @endcan

                                @can('view-file_config')
                                    <li id="file_config"><a
                                                href="{{route('file_config.index')}}">{{__('File Configuration')}}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
            </ul>
        </div>
    </div>
</nav>

<div class="page">
    <div id="app">

        @include('translation::notifications')

        @yield('body')

    </div>

    <footer class="main-footer">
        <div class="container-fluid">
            <p>&copy; {{$general_settings->site_title ?? "no title"}} | {{ __('Developed by')}} <a href="https://lion-coders.com" class="external">{{ __('LionCoders')}}</a></p>
        </div>
    </footer>
</div>

<script src="{{ asset('vendor/translation/js/app.js') }}"></script>

<script type="text/javascript">
    (function($) {

        "use strict";


        $('#notify-btn').on('click',function () {
            $.ajax({
                url: '{{route('markAsRead')}}',
                dataType: "json",
                success: function (result) {
                },
            });
        })

    })(jQuery);
</script>

@stack('lang_scripts')


</body>
</html>
