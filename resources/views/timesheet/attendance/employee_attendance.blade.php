@extends('layout.main')
@section('content')

<section>

    @include('shared.errors')
    @include('shared.flash_message')

    <div class="col-md-4">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><small>{{__('Mark Attendance')}}</small></a></li>
                <li><a href="#tab_2" data-toggle="tab">{{trans('Attendance')}} <small>{{trans('Overview')}}</small></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="box-widget widget-user">

                        <div class="widget-user-image"> <img  src={{ URL::to('/uploads/profile_photos')}}/{{$user->profile_photo ?? 'avatar.jpg'}}  width='100'  class='rounded-circle'> </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="widget-user-header bg-light bg-darken-2">
                                        <h3 class="widget-user-username">{{$user->username}} </h3>
                                        <h5 class="widget-user-desc">{{$employee->department->department_name}}</h5>
                                    </div>
                                    <div class="description-block">
                                        <p class="text-muted pb-0-5">Last Login: {{$user->last_login_date}}</p>
                                        <p class="text-muted pb-0-5">My Office Shift: {{$shift_in}} To
                                            {{$shift_out}}</p>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-xs-center">
                                        <div class="text-xs-center pb-0-5">
                                            <form action="{{route('employee_attendance.post',$employee->id)}}" name="set_clocking" id="set_clocking" autocomplete="off" class="form" method="post" accept-charset="utf-8">
                                                @csrf

                                                <input type="hidden" value="{{$shift_in}}" name="office_shift_in" id="shift_in">
                                                <input type="hidden" value="{{$shift_out}}" name="office_shift_out" id="shift_out">
                                                <input type="hidden" value="" name="in_out_value" id="in_out">

                                                <div class="row">
                                                    @if(!$employee_attendance || $employee_attendance->clock_in_out== 0)
                                                    <div class="col-md-6">
                                                        <button class="btn btn-success btn-block text-uppercase" type="submit" id="clock_in_btn"><i class="fa fa-arrow-circle-right"></i>{{__('Clock IN')}}</button>
                                                    </div>
                                                   @else
                                                    <div class="col-md-6">
                                                        <button class="btn btn-danger btn-block text-uppercase"  type="submit" id="clock_out_btn"><i class="fa fa-arrow-circle-left"></i>{{__('Clock Out')}}</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12 col-md-offset-1">
                                    <div class="margin">
                                        <div class="btn-group"> <a type="button" href="#" class="btn btn-default btn-flat">{{__('My Attendance Timesheet')}}</a> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="">
                        <div class="box-body">
                            <div class="table-responsive" data-pattern="priority-columns">
                                <table class="table  m-md-b-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row" colspan="2" class="text-center">{{__('This Month')}}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Total Present')}}</th>
                                        <td class="text-right">2</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Total Absent')}}</th>
                                        <td class="text-right">14</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Total Leave')}}</th>
                                        <td class="text-right">0</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="2" class="text-center"><a href="#">{{__('View attendance calendar')}}</a></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- Widget: user widget style 1 -->
    </div>

    <script type="text/javascript">
        (function($) {  
            "use strict";

            $(document).ready(function() {

                $('#clock_in_btn').on('click',function () {
                    $('#in_out').val('1');
                });

                $('#clock_out_btn').on('click',function () {
                    $('#in_out').val('0');
                });

            });
        })(jQuery);
    </script>
</section>




@endsection