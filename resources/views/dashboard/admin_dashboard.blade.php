@extends('layout.main')
@section('content')

        <!-- Alert Section for version upgrade-->
        <div id="alertSection" class="{{ $alertVersionUpgradeEnable==true ? null : 'd-none' }} alert alert-primary alert-dismissible fade show" role="alert">
            <p id="announce" class="{{ $alertVersionUpgradeEnable==true ? null : 'd-none' }}"><strong>Announce !!!</strong> A new version {{config('auto_update.VERSION')}} <span id="newVersionNo"></span> has been released. Please <i><b><a href="{{route('new-release')}}">Click here</a></b></i> to check upgrade details.</p>
            <button type="button" id="closeButtonUpgrade" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- Alert Section for Bug update-->
        <div id="alertBugSection" class=" {{ $alertBugEnable==true ? null : 'd-none' }} alert alert-primary alert-dismissible fade show" style="background-color: rgb(248,215,218)" role="alert">
            <p id="alertBug" class=" {{ $alertBugEnable==true ? null : 'd-none' }} " style="color: rgb(126,44,52)"><strong>Alert !!!</strong> Minor bug fixed in version {{env('VERSION')}}. Please <i><b><a href="{{route('bug-update-page')}}">Click here</a></b></i> to update the system.</p>
            <button type="button" style="color: rgb(126,44,52)" id="closeButtonBugUpdate" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <section>
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb-30px">
                <div><h1 class="thin-text">{{trans('file.Welcome')}} {{auth()->user()->username}}</h1></div>
                <div><h4 class="thin-text">{{__('Today is')}} {{now()->englishDayOfWeek}} {{now()->format(env('Date_Format'))}}</h4></div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('employees.index')}}">
                            <div class="name"><strong class="purple-text">{{ trans('file.Employees') }}</strong>
                            </div>
                            <div class="count-number employee-count">{{$employees->count()}}</div>
                        </a>
                    </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('attendances.index')}}">
                            <div class="name"><strong class="orange-text">{{trans('file.Attendance')}}</strong></div>
                            <div class="count-number attendance-count">P:{{$attendance_count}}
                                A:{{$employees->count() - $attendance_count}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('leaves.index')}}">
                            <div class="name"><strong class="green-text">{{__('Total Leave')}}</strong></div>
                            <div class="count-number leave-count">{{$leave_count}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('expense.index')}}">
                            <div class="name"><strong class="blue-text">{{__('Total Expense')}}</strong></div>
                            <div class="count-number total_expense"> {{$total_expense}}</div>
                            {{-- <div class="count-number total_expense"> {{number_format((float)$total_expense, 2, '.', '') }}</div> --}}
                        </a>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('deposit.index')}}">
                            <div class="name"><strong class="green-text">{{__('Total Deposit')}}</strong></div>
                            <div class="count-number total_deposit">{{$total_deposit}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('payment_history.index')}}">
                            <div class="name"><strong class="blue-text">{{__('Total Salaries Paid')}}</strong>
                            </div>
                            <div class="count-number total_salaries_paid">{{$total_salaries_paid}}</div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{trans('file.Payment')}} --- {{__('Last 6 Months ')}}</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="payment_last_six" data-last_six_month_payment = "{{json_encode($per_month_payment) ?? ''}}" data-months="{{json_encode($per_month) ?? ''}}"  data-label1="{{trans('file.Payment')}}" ></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Employee Department')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="department_chart" data-dept_bgcolor='@json($dept_bgcolor_array)'
                                    data-hover_dept_bgcolor='@json($dept_hover_bgcolor_array)'
                                    data-dept_emp_count='@json($dept_count_array)'
                                    data-dept_label='@json($dept_name_array)' width="100" height="95"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Employee Designation')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="designation_chart" data-desig_bgcolor='@json($desig_bgcolor_array)'
                                    data-hover_desig_bgcolor='@json($desig_hover_bgcolor_array)'
                                    data-desig_emp_count='@json($desig_count_array)'
                                    data-desig_label='@json($desig_name_array)' width="100" height="95"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Expense Vs Deposit')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="expense_deposit_chart" data-expense_count='{{$total_expense_raw}}'
                                    data-expense_level="{{trans('Expense')}}"
                                    data-deposit_count='{{$total_deposit_raw}}'
                                    data-deposit_level="{{trans('Deposit')}}" width="100" height="95"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Project Status')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="project_chart" data-project_status='@json($project_count_array)'
                                    data-project_label='@json($project_name_array)' width="100" height="95"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon blue-text ml-2 mr-3"><i class="dripicons-volume-medium"></i></div>
                        <a href="{{route('announcements.index')}}">
                            <h3 class="mt-3">{{ count($announcements) }} {{trans('file.Announcement')}}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon green-text ml-2 mr-3"><i class="dripicons-ticket"></i></div>
                        <a href="{{route('tickets.index')}}">
                            <h3 class="mt-3">{{$ticket_count}} {{__('Open Ticket')}}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon orange-text ml-2 mr-3"><i class="dripicons-briefcase"></i></div>
                        <a href="{{route('projects.index')}}">
                            <h3 class="mt-3">{{$completed_projects}} {{__('Completed Projects')}}</h3>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                @include('calendarable.calendar')
            </div>
        </div>

    </section>
@endsection




@push('scripts')
    <script>
        let clientCurrrentVersion = {!! json_encode(env("VERSION"))  !!};
        let clientCurrrentBugNo   = {!! json_encode(env("BUG_NO"))  !!};
    </script>
    <script type="text/javascript" src="{{asset('js/admin/common/general_data.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/admin/dashboard/notification.js')}}"></script>
@endpush

