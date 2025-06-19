<!DOCTYPE html>
<html>

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
    <link rel="stylesheet"
          href="{{ asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}"
          type="text/css">
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

    @if(strpos($_SERVER['REQUEST_URI'], "calendar") > 0 || strpos($_SERVER['REQUEST_URI'], "dashboard") > 0 )
        @include('calendarable.css')
    @endif

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

    @if(strpos($_SERVER['REQUEST_URI'], "calendar") > 0 || strpos($_SERVER['REQUEST_URI'], "dashboard") > 0 )
        @include('calendarable.js')
    @endif
</head>

<body>
<div id="loader"></div>
<!-- navbar-->
<header class="header">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <a id="toggle-btn" href="#" class="menu-btn"><i class="dripicons-menu"> </i></a>
                <span class="brand-big" id="site_logo_main">@if($general_settings->site_logo ?? "no")<img
                            src="{{url('logo', $general_settings->site_logo ?? "no")}}" width="50">&nbsp;
                    &nbsp;@endif<h1 class="d-inline"
                                    id="site_title_main">{{$general_settings->site_title ?? "No title"}}</h1></span>


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
                        <a rel="nofollow" href="#" class="nav-link dropdown-item" data-toggle="tooltip" title="{{__('Language')}}">
                            <i class="dripicons-web"></i>
                        </a>
                        <ul class="right-sidebar">
                            @foreach($languages as $lang)
                                <li>
                                    <a href="{{route('language.switch',$lang)}}">{{$lang}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('help/index.html')}}" target="_blank" data-toggle="tooltip"
                           title="{{__('Help')}}">
                            <i class="dripicons-information"></i>
                        </a>
                    </li>
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

                <li><a href="{{url('/client/dashboard')}}"> <i
                                class="dripicons-meter"></i><span>{{trans('file.Dashboard')}}</span></a>
                </li>

                <li><a href="#Project_Management" aria-expanded="false" data-toggle="collapse"> <i
                                class="dripicons-checklist"></i><span>{{__('Project Management')}}</span></a>
                    <ul id="Project_Management" class="collapse list-unstyled ">

                        <li id="projects"><a
                                    href="{{route('clientProject')}}">{{trans(('file.Projects'))}}</a>
                        </li>

                        <li id="tasks"><a
                                    href="{{route('clientTask')}}">{{trans(('file.Tasks'))}}</a>
                        </li>
                    </ul>
                </li>


                <li><a href="#invoices" aria-expanded="false" data-toggle="collapse"> <i
                                class="dripicons-ticket"></i><span>{{trans('file.Invoice')}}</span></a>
                    <ul id="invoices" class="collapse list-unstyled ">
                        <li id="invoice"><a href="{{route('clientInvoice')}}">{{trans('file.Invoice')}}</a>
                        </li>

                        <li id="paid_invoice"><a href="{{route('clientInvoicePaid')}}">{{__('Invoice Payment')}}</a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>


<div id="content" class="page animate-bottom d-none">
    @yield('content')
    <footer class="main-footer">
        <div class="container-fluid">
            <p>&copy; {{$general_settings->site_title ?? "no title"}}
                | {{ __('Developed by')}} <a href="https://lion-coders.com" class="external">{{ __('LionCoders')}}</a>
            </p>
        </div>
    </footer>
</div>


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


</body>
</html>