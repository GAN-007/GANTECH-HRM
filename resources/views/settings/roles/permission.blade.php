@extends('layout.main')
@section('content')


    <link rel="stylesheet" href="<?php echo asset('css/kendo.default.v2.min.css') ?>" type="text/css">

    <script type="text/javascript" src="<?php echo asset('js/kendo.all.min.js') ?>"></script>

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <span id="form_result_permission"></span>

                    <h1 class="text-center mt-2">{{$role->name}}</h1>
                    <p>{{__('You can assign permission for this role')}}</p>

                    <div id="all_resources">
                        <div class="demo-section k-content">

                            <h4>{{__('Select modules')}}</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="treeview1"></div>
                                </div>
                                <div class="col-md-4">
                                    <div  id="treeview2"></div>
                                </div>
                                <div class="col-md-4">
                                    <div id="treeview3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-4">
                        <div class="col-md-6 offset-md-3">
                            <input id="role_id" type="hidden" name="role_id" value={{$role->id}}>
                            <button class="btn btn-primary btn-block" id="set_permission_btn" type="submit" class="roles-btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        var checkedNodes;


        $(document).ready(function () {

            $("ul#setting").siblings('a').attr('aria-expanded', 'true');
            $("ul#setting").addClass("show");
            $("ul#setting #role-menu").addClass("active");

            var target = '{{route('permissionDetails',$role->id)}}';
            $.ajax({
                type: "GET",
                url: target,
                dataType: 'json',
                success: function (result) {

                    $("#treeview1").empty();
                    $("#treeview1").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: [
                            {
                                id: 'user',
                                text: "{{trans('User')}}",
                                expanded: true,
                                checked: ($.inArray('user', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-user',
                                        text: '{{__('View User')}}',
                                        checked: ($.inArray('view-user', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'store-user',
                                        text: '{{__('Add User')}}',
                                        checked: ($.inArray('store-user', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-user',
                                        text: '{{__('Edit User')}}',
                                        checked: ($.inArray('edit-user', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-user',
                                        text: "{{__('Delete User')}}",
                                        checked: ($.inArray('delete-user', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'last-login-user',
                                        text: "{{__('Users Last Login')}}",
                                        checked: ($.inArray('last-login-user', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'role-access-user',
                                        text: "{{__('Assign Role')}}",
                                        checked: ($.inArray('role-access-user', result) >= 0) ? true : false
                                    }
                                    // {
                                    //     id: 'assign-role',
                                    //     text: '{{__('Assign Role')}}',
                                    //     checked: ($.inArray('assign-role', result) >= 0) ? true : false
                                    // },
                                ]
                            },
                            {
                                id: 'details-employee',
                                text: "{{trans('Employee Details')}}",
                                expanded: true,
                                checked: ($.inArray('details-employee', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-details-employee',
                                        text: '{{__('View Employee Details')}}',
                                        checked: ($.inArray('view-details-employee', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'store-details-employee',
                                        text: '{{__('Add Employee Details')}}',
                                        checked: ($.inArray('store-details-employee', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'modify-details-employee',
                                        text: '{{__('Modify Employee Details')}}',
                                        checked: ($.inArray('modify-details-employee', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'import-employee',
                                        text: '{{__('Import Employee')}}',
                                        checked: ($.inArray('import-employee', result) >= 0) ? true : false
                                    },
                                ]
                            },

                            {
                                id: 'customize-setting',
                                text: "{{__('Customize Setting')}}",
                                expanded: true,
                                checked: ($.inArray('customize-setting', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'role',
                                        text: "{{trans('Role')}}",
                                        expanded: true,
                                        checked: ($.inArray('role', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-role',
                                                text: '{{__('View Role')}}',
                                                checked: ($.inArray('view-role', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-role',
                                                text: '{{__('Add Role')}}',
                                                checked: ($.inArray('store-role', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-role',
                                                text: '{{__('Edit Role')}}',
                                                checked: ($.inArray('edit-role', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-role',
                                                text: "{{__('Delete Role')}}",
                                                checked: ($.inArray('delete-role', result) >= 0) ? true : false
                                            },
                                            // {
                                            //     id: 'assign-role',
                                            //     text: '{{__('Assign Role')}}',
                                            //     checked: ($.inArray('assign-role', result) >= 0) ? true : false
                                            // },
                                            {
                                                id: 'set-permission',
                                                text: '{{__('Set Permission')}}',
                                                checked: ($.inArray('set-permission', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'general-setting',
                                        text: "{{__('General Setting')}}",
                                        expanded: true,
                                        checked: ($.inArray('general-setting', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-general-setting',
                                                text: '{{__('View General Setting')}}',
                                                checked: ($.inArray('view-general-setting', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-general-setting',
                                                text: '{{__('Store General Setting')}}',
                                                checked: ($.inArray('store-general-setting', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'mail-setting',
                                        text: "{{__('Mail Setting')}}",
                                        expanded: true,
                                        checked: ($.inArray('mail-setting', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-mail-setting',
                                                text: '{{__('View Mail Setting')}}',
                                                checked: ($.inArray('view-mail-setting', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-mail-setting',
                                                text: '{{__('Store Mail Setting')}}',
                                                checked: ($.inArray('store-mail-setting', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'access-variable_type',
                                        text: '{{__('Access Variable Type')}}',
                                        checked: ($.inArray('access-variable_type', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'access-variable_method',
                                        text: '{{__('Access Variable Method')}}',
                                        checked: ($.inArray('access-variable_method', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'access-language',
                                        text: '{{__('Access Language')}}',
                                        checked: ($.inArray('access-language', result) >= 0) ? true : false
                                    },
                                ]
                            },

                            {
                                id: 'core_hr',
                                text: "{{trans('Core HR')}}",
                                expanded: true,
                                checked: ($.inArray('core_hr', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-calendar',
                                        text: '{{__('View Calendar')}}',
                                        checked: ($.inArray('view-calendar', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'promotion',
                                        text: "{{trans('Promotion')}}",
                                        expanded: true,
                                        checked: ($.inArray('promotion', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-promotion',
                                                text: '{{__('View Promotion')}}',
                                                checked: ($.inArray('view-promotion', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-promotion',
                                                text: '{{__('Add Promotion')}}',
                                                checked: ($.inArray('store-promotion', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-promotion',
                                                text: '{{__('Edit Promotion')}}',
                                                checked: ($.inArray('edit-promotion', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-promotion',
                                                text: "{{__('Delete Promotion')}}",
                                                checked: ($.inArray('delete-promotion', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'award',
                                        text: "{{trans('Award')}}",
                                        expanded: true,
                                        checked: ($.inArray('award', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-award',
                                                text: '{{__('View Award')}}',
                                                checked: ($.inArray('view-award', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-award',
                                                text: '{{__('Add Award')}}',
                                                checked: ($.inArray('store-award', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-award',
                                                text: '{{__('Edit Award')}}',
                                                checked: ($.inArray('edit-award', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-award',
                                                text: "{{__('Delete Award')}}",
                                                checked: ($.inArray('delete-award', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'transfer',
                                        text: "{{trans('Transfer')}}",
                                        expanded: true,
                                        checked: ($.inArray('transfer', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-transfer',
                                                text: '{{__('View Transfer ')}}',
                                                checked: ($.inArray('view-transfer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-transfer',
                                                text: '{{__('Add Transfer')}}',
                                                checked: ($.inArray('store-transfer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-transfer',
                                                text: '{{__('Edit Transfer')}}',
                                                checked: ($.inArray('edit-transfer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-transfer',
                                                text: "{{__('Delete Transfer')}}",
                                                checked: ($.inArray('delete-transfer', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'travel',
                                        text: "{{trans('Travel')}}",
                                        expanded: true,
                                        checked: ($.inArray('travel', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-travel',
                                                text: '{{__('View Travel ')}}',
                                                checked: ($.inArray('view-travel', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-travel',
                                                text: '{{__('Add Travel')}}',
                                                checked: ($.inArray('store-travel', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-transfer',
                                                text: '{{__('Edit Travel')}}',
                                                checked: ($.inArray('edit-travel', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-travel',
                                                text: "{{__('Delete Travel')}}",
                                                checked: ($.inArray('delete-travel', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'resignation',
                                        text: "{{trans('Resignation')}}",
                                        expanded: true,
                                        checked: ($.inArray('resignation', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-resignation',
                                                text: '{{__('View Resignation')}}',
                                                checked: ($.inArray('view-resignation', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-resignation',
                                                text: '{{__('Add Resignation')}}',
                                                checked: ($.inArray('store-resignation', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-promotion',
                                                text: '{{__('Edit Resignation')}}',
                                                checked: ($.inArray('edit-promotion', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-resignation',
                                                text: "{{__('Delete Resignation')}}",
                                                checked: ($.inArray('delete-resignation', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'complaint',
                                        text: "{{trans('Complaint')}}",
                                        expanded: true,
                                        checked: ($.inArray('complaint', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-complaint',
                                                text: '{{__('View Complaint')}}',
                                                checked: ($.inArray('view-complaint', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-complaint',
                                                text: '{{__('Add Complaint')}}',
                                                checked: ($.inArray('store-complaint', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-complaint',
                                                text: '{{__('Edit Complaint')}}',
                                                checked: ($.inArray('edit-complaint', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-complaint',
                                                text: "{{__('Delete Complaint')}}",
                                                checked: ($.inArray('delete-complaint', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'warning',
                                        text: "{{trans('Warning')}}",
                                        expanded: true,
                                        checked: ($.inArray('warning', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-warning',
                                                text: '{{__('View Warning ')}}',
                                                checked: ($.inArray('view-warning', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-warning',
                                                text: '{{__('Add Warning')}}',
                                                checked: ($.inArray('store-warning', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-warning',
                                                text: '{{__('Edit Warning')}}',
                                                checked: ($.inArray('edit-warning', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-warning',
                                                text: "{{__('Delete Warning')}}",
                                                checked: ($.inArray('delete-warning', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'termination',
                                        text: "{{trans('Termination')}}",
                                        expanded: true,
                                        checked: ($.inArray('termination', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-termination',
                                                text: '{{__('View Termination')}}',
                                                checked: ($.inArray('view-termination', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-termination',
                                                text: '{{__('Add Termination')}}',
                                                checked: ($.inArray('store-termination', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-termination',
                                                text: '{{__('Edit Termination')}}',
                                                checked: ($.inArray('edit-termination', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-termination',
                                                text: "{{__('Delete Termination')}}",
                                                checked: ($.inArray('delete-termination', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },

                            {
                                id: 'timesheet',
                                text: "{{trans('Timesheet')}}",
                                expanded: true,
                                checked: ($.inArray('timesheet', result) >= 0) ? true : false,
                                items: [

                                    {
                                        id: 'attendance',
                                        text: "{{trans('Attendance')}}",
                                        expanded: true,
                                        checked: ($.inArray('attendance', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-attendance',
                                                text: '{{__('View Attendance ')}}',
                                                checked: ($.inArray('view-attendance', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-attendance',
                                                text: '{{__('Edit Attendance')}}',
                                                checked: ($.inArray('edit-attendance', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-attendance',
                                                text: "{{__('Delete Attendance')}}",
                                                checked: ($.inArray('delete-attendance', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'import-attendance',
                                                text: '{{__('Import Attendance')}}',
                                                checked: ($.inArray('import-attendance', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'office_shift',
                                        text: "{{trans('Office Shift')}}",
                                        expanded: true,
                                        checked: ($.inArray('office_shift', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-office_shift',
                                                text: '{{__('View Office Shift')}}',
                                                checked: ($.inArray('view-office_shift', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-office_shift',
                                                text: '{{__('Add Office Shift')}}',
                                                checked: ($.inArray('store-office_shift', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-office_shift',
                                                text: '{{__('Edit Office Shift')}}',
                                                checked: ($.inArray('edit-office_shift', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-office_shift',
                                                text: "{{__('Delete Office Shift')}}",
                                                checked: ($.inArray('delete-office_shift', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'holiday',
                                        text: "{{trans('Holiday')}}",
                                        expanded: true,
                                        checked: ($.inArray('holiday', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-holiday',
                                                text: '{{__('View Holiday')}}',
                                                checked: ($.inArray('view-holiday', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-holiday',
                                                text: '{{__('Add Holiday')}}',
                                                checked: ($.inArray('store-holiday', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-holiday',
                                                text: '{{__('Edit Holiday')}}',
                                                checked: ($.inArray('edit-holiday', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-holiday',
                                                text: "{{__('Delete Holiday')}}",
                                                checked: ($.inArray('delete-holiday', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'leave',
                                        text: "{{trans('Leave')}}",
                                        expanded: true,
                                        checked: ($.inArray('leave', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-leave',
                                                text: '{{__('View Leave')}}',
                                                checked: ($.inArray('view-leave', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-leave',
                                                text: '{{__('Add Leave')}}',
                                                checked: ($.inArray('store-leave', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-leave',
                                                text: '{{__('Edit Leave')}}',
                                                checked: ($.inArray('edit-leave', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-leave',
                                                text: "{{__('Delete Leave')}}",
                                                checked: ($.inArray('delete-leave', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'get-leave-notification',
                                                text: "{{__('Get Leave Notification')}}",
                                                checked: ($.inArray('get-leave-notification', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },
                        ]
                    });

                    $("#treeview2").empty();
                    $("#treeview2").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: [
                            {
                                id: 'payment-module',
                                text: "{{trans('Payment Module')}}",
                                expanded: true,
                                checked: ($.inArray('payment-module', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-payslip',
                                        text: '{{__('View Payslip')}}',
                                        checked: ($.inArray('view-payslip', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'make-payment',
                                        text: '{{__('Make Payment')}}',
                                        checked: ($.inArray('make-payment', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'make-bulk_payment',
                                        text: '{{__('Make Bulk Payment')}}',
                                        checked: ($.inArray('make-bulk_payment', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'view-paylist',
                                        text: "{{__('View Paylist')}}",
                                        checked: ($.inArray('view-paylist', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'set-salary',
                                        text: "{{__('Set Salary')}}",
                                        checked: ($.inArray('set-salary', result) >= 0) ? true : false
                                    },
                                ]
                            },
                            {
                                id: 'hr_report',
                                text: "{{trans('HR Reports')}}",
                                expanded: true,
                                checked: ($.inArray('hr_report', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'daily-attendances',
                                        text: '{{__('Daily Attendances')}}',
                                        checked: ($.inArray('daily-attendances', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'date-wise-attendances',
                                        text: '{{__('Date Wise Attendances')}}',
                                        checked: ($.inArray('date-wise-attendances', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'monthly-attendances',
                                        text: '{{__('Monthly Attendances')}}',
                                        checked: ($.inArray('monthly-attendances', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-training',
                                        text: '{{__('Training Report')}}',
                                        checked: ($.inArray('report-training', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-project',
                                        text: '{{__('Project Report')}}',
                                        checked: ($.inArray('report-project', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-task',
                                        text: '{{__('Task Report')}}',
                                        checked: ($.inArray('report-task', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-employee',
                                        text: '{{__('Employee Report')}}',
                                        checked: ($.inArray('report-employee', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-account',
                                        text: '{{__('Account Report')}}',
                                        checked: ($.inArray('report-account', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-deposit',
                                        text: '{{__('Deposit Report')}}',
                                        checked: ($.inArray('report-deposit', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-expense',
                                        text: '{{__('Expense Report')}}',
                                        checked: ($.inArray('report-expense', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-transaction',
                                        text: '{{__('Transaction Report')}}',
                                        checked: ($.inArray('report-transaction', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'report-pension',
                                        text: '{{__('Pension Report')}}',
                                        checked: ($.inArray('report-pension', result) >= 0) ? true : false
                                    },
                                ]
                            },
                            {
                                id: 'recruitment',
                                text: "{{__('Recruitment')}}",
                                expanded: true,
                                checked: ($.inArray('recruitment', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'job_post',
                                        text: "{{trans('Job Post')}}",
                                        expanded: true,
                                        checked: ($.inArray('job_post', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-job_post',
                                                text: '{{__('View Job Post')}}',
                                                checked: ($.inArray('view-job_post', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-job_post',
                                                text: '{{__('Add Job Post')}}',
                                                checked: ($.inArray('store-job_post', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-job_post',
                                                text: '{{__('Edit Job Post')}}',
                                                checked: ($.inArray('edit-job_post', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-job_post',
                                                text: "{{__('Delete Job Post')}}",
                                                checked: ($.inArray('delete-job_post', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'job_candidate',
                                        text: "{{trans('Job Candidate')}}",
                                        expanded: true,
                                        checked: ($.inArray('job_candidate', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-job_candidate',
                                                text: '{{__('View Job Candidate')}}',
                                                checked: ($.inArray('view-job_candidate', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-job_candidate',
                                                text: "{{__('Delete Job Candidate')}}",
                                                checked: ($.inArray('delete-job_candidate', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'job_interview',
                                        text: "{{trans('Job Interview')}}",
                                        expanded: true,
                                        checked: ($.inArray('job_interview', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-job_interview',
                                                text: '{{__('View Job Interview')}}',
                                                checked: ($.inArray('view-job_interview', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-job_interview',
                                                text: "{{__('Store Job Interview')}}",
                                                checked: ($.inArray('store-job_interview', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-job_interview',
                                                text: "{{__('Delete Job Interview')}}",
                                                checked: ($.inArray('delete-job_interview', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'cms',
                                        text: "{{__('CMS')}}",
                                        expanded: true,
                                        checked: ($.inArray('cms', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-cms',
                                                text: '{{__('View CMS')}}',
                                                checked: ($.inArray('view-cms', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-cms',
                                                text: "{{__('Add CMS')}}",
                                                checked: ($.inArray('store-cms', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },
                            {
                                id: 'project-management',
                                text: "{{trans('Project Management')}}",
                                expanded: true,
                                checked: ($.inArray('project-management', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'project',
                                        text: "{{trans('Project')}}",
                                        expanded: true,
                                        checked: ($.inArray('project', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-project',
                                                text: '{{__('View Project')}}',
                                                checked: ($.inArray('view-project', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-project',
                                                text: '{{__('Add Project')}}',
                                                checked: ($.inArray('store-project', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-project',
                                                text: '{{__('Edit Project')}}',
                                                checked: ($.inArray('edit-project', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-project',
                                                text: "{{__('Delete Project')}}",
                                                checked: ($.inArray('delete-project', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'assign-project',
                                                text: '{{__('Assign Project')}}',
                                                checked: ($.inArray('assign-project', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'task',
                                        text: "{{trans('Task')}}",
                                        expanded: true,
                                        checked: ($.inArray('task', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-task',
                                                text: '{{__('View Task')}}',
                                                checked: ($.inArray('view-task', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-task',
                                                text: '{{__('Add Task')}}',
                                                checked: ($.inArray('store-task', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-task',
                                                text: '{{__('Edit Task')}}',
                                                checked: ($.inArray('edit-task', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-task',
                                                text: "{{__('Delete Task')}}",
                                                checked: ($.inArray('delete-task', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'assign-task',
                                                text: "{{__('Assign Task')}}",
                                                checked: ($.inArray('assign-task', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'client',
                                        text: "{{trans('Client')}}",
                                        expanded: true,
                                        checked: ($.inArray('client', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-client',
                                                text: '{{__('View Client')}}',
                                                checked: ($.inArray('view-client', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-client',
                                                text: '{{__('Add Client')}}',
                                                checked: ($.inArray('store-client', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-client',
                                                text: '{{__('Edit Client')}}',
                                                checked: ($.inArray('edit-client', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-client',
                                                text: "{{__('Delete Client')}}",
                                                checked: ($.inArray('delete-client', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'invoice',
                                        text: "{{trans('Invoice')}}",
                                        expanded: true,
                                        checked: ($.inArray('invoice', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-invoice',
                                                text: '{{__('View Invoice')}}',
                                                checked: ($.inArray('view-invoice', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-invoice',
                                                text: '{{__('Add Invoice')}}',
                                                checked: ($.inArray('store-invoice', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-invoice',
                                                text: '{{__('Edit Invoice')}}',
                                                checked: ($.inArray('edit-invoice', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-invoice',
                                                text: "{{__('Delete Invoice')}}",
                                                checked: ($.inArray('delete-invoice', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },
                            {
                                id: 'ticket',
                                text: "{{trans('Ticket')}}",
                                expanded: true,
                                checked: ($.inArray('ticket', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-ticket',
                                        text: '{{__('View Ticket')}}',
                                        checked: ($.inArray('view-ticket', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'store-ticket',
                                        text: '{{__('Add Ticket')}}',
                                        checked: ($.inArray('store-ticket', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-ticket',
                                        text: '{{__('Edit Ticket')}}',
                                        checked: ($.inArray('edit-ticket', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-ticket',
                                        text: "{{__('Delete Ticket')}}",
                                        checked: ($.inArray('delete-ticket', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'assign-ticket',
                                        text: '{{__('Assign Ticket')}}',
                                        checked: ($.inArray('assign-ticket', result) >= 0) ? true : false
                                    },
                                ]
                            },
                            {
                                id: 'file_module',
                                text: "{{trans('File Module')}}",
                                expanded: true,
                                checked: ($.inArray('file_module', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'file_manager',
                                        text: "{{trans('File Manager')}}",
                                        expanded: true,
                                        checked: ($.inArray('file_manager', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-file_manager',
                                                text: '{{__('View File Manager')}}',
                                                checked: ($.inArray('view-file_manager', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-file_manager',
                                                text: '{{__('Add File Manager')}}',
                                                checked: ($.inArray('store-file_manager', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-file_manager',
                                                text: '{{__('Edit File Manager')}}',
                                                checked: ($.inArray('edit-file_manager', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-file_manager',
                                                text: "{{__('Delete File Manager')}}",
                                                checked: ($.inArray('delete-file_manager', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'view-file_config',
                                                text: "{{__('Access File Config')}}",
                                                checked: ($.inArray('view-file_config', result) >= 0) ? true : false
                                            },


                                        ]
                                    },
                                    {
                                        id: 'official_document',
                                        text: "{{trans('Official Document')}}",
                                        expanded: true,
                                        checked: ($.inArray('official_document', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-official_document',
                                                text: '{{__('View Official Document')}}',
                                                checked: ($.inArray('view-official_document', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-office_shift',
                                                text: '{{__('Add Official Document')}}',
                                                checked: ($.inArray('store-office_shift', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-official_document',
                                                text: '{{__('Edit Office Shift')}}',
                                                checked: ($.inArray('edit-official_document', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-official_document',
                                                text: "{{__('Delete Official Document')}}",
                                                checked: ($.inArray('delete-official_document', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },
                            {
                                id: 'event-meeting',
                                text: "{{trans('Event and Meeting')}}",
                                expanded: true,
                                checked: ($.inArray('event-meeting', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'meeting',
                                        text: "{{trans('Meeting')}}",
                                        expanded: true,
                                        checked: ($.inArray('meeting', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-meeting',
                                                text: '{{__('View Meeting')}}',
                                                checked: ($.inArray('view-meeting', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-meeting',
                                                text: '{{__('Add Location')}}',
                                                checked: ($.inArray('store-meeting', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-meeting',
                                                text: '{{__('Edit Location')}}',
                                                checked: ($.inArray('edit-meeting', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-meeting',
                                                text: "{{__('Delete Location')}}",
                                                checked: ($.inArray('delete-meeting', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'event',
                                        text: "{{trans('Event')}}",
                                        expanded: true,
                                        checked: ($.inArray('event', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-event',
                                                text: '{{__('View Event')}}',
                                                checked: ($.inArray('view-event', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-event',
                                                text: '{{__('Add Event')}}',
                                                checked: ($.inArray('store-event', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-event',
                                                text: '{{__('Edit Event')}}',
                                                checked: ($.inArray('edit-event', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-event',
                                                text: "{{__('Delete Event')}}",
                                                checked: ($.inArray('delete-event', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },
                            {
                                id: 'assets-and-category',
                                text: "{{trans('Assets And Category')}}",
                                expanded: true,
                                checked: ($.inArray('assets-and-category', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'category',
                                        text: "{{__('Category')}}",
                                        expanded: true,
                                        checked: ($.inArray('category', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-assets-category',
                                                text: '{{__('View Category')}}',
                                                checked: ($.inArray('view-assets-category', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-assets-category',
                                                text: '{{__('Add Category')}}',
                                                checked: ($.inArray('store-assets-category', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-assets-category',
                                                text: '{{__('Edit Category')}}',
                                                checked: ($.inArray('edit-assets-category', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-assets-category',
                                                text: "{{__('Delete Category')}}",
                                                checked: ($.inArray('delete-assets-category', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'assets',
                                        text: "{{trans('Asset')}}",
                                        expanded: true,
                                        checked: ($.inArray('assets', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-assets',
                                                text: '{{__('View Asset')}}',
                                                checked: ($.inArray('view-assets', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-assets',
                                                text: '{{__('Add Asset')}}',
                                                checked: ($.inArray('store-assets', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-assets',
                                                text: '{{__('Edit Asset')}}',
                                                checked: ($.inArray('edit-assets', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-assets',
                                                text: "{{__('Delete Asset')}}",
                                                checked: ($.inArray('delete-assets', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },
                        ]
                    });

                    $("#treeview3").empty();
                    $("#treeview3").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: [
                            {
                                id: 'finance',
                                text: "{{trans('Finance')}}",
                                expanded: true,
                                checked: ($.inArray('finance', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'account',
                                        text: "{{trans('Account')}}",
                                        expanded: true,
                                        checked: ($.inArray('account', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-account',
                                                text: '{{__('View Account')}}',
                                                checked: ($.inArray('view-account', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-account',
                                                text: '{{__('Add Account')}}',
                                                checked: ($.inArray('store-account', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-account',
                                                text: '{{__('Edit Account')}}',
                                                checked: ($.inArray('edit-account', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-account',
                                                text: "{{__('Delete Account')}}",
                                                checked: ($.inArray('delete-account', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'view-transaction',
                                                text: '{{__('View Transaction')}}',
                                                checked: ($.inArray('view-transaction', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'view-balance_transfer',
                                                text: '{{__('View Balance Transfer')}}',
                                                checked: ($.inArray('view-balance_transfer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-balance_transfer',
                                                text: '{{__('Store Balance Transfer')}}',
                                                checked: ($.inArray('store-balance_transfer', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'expense',
                                        text: "{{trans('Expense')}}",
                                        expanded: true,
                                        checked: ($.inArray('expense', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-expense',
                                                text: '{{__('View Expense')}}',
                                                checked: ($.inArray('view-expense', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-expense',
                                                text: '{{__('Add Expense')}}',
                                                checked: ($.inArray('store-expense', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-expense',
                                                text: '{{__('Edit Expense')}}',
                                                checked: ($.inArray('edit-expense', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-expense',
                                                text: "{{__('Delete Expense')}}",
                                                checked: ($.inArray('delete-expense', result) >= 0) ? true : false
                                            },
                                        ]
                                    },


                                    {
                                        id: 'deposit',
                                        text: "{{trans('Deposit')}}",
                                        expanded: true,
                                        checked: ($.inArray('deposit', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-deposit',
                                                text: '{{__('View Deposit')}}',
                                                checked: ($.inArray('view-deposit', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-deposit',
                                                text: '{{__('Add Deposit')}}',
                                                checked: ($.inArray('store-deposit', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-deposit',
                                                text: '{{__('Edit Deposit')}}',
                                                checked: ($.inArray('edit-deposit', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-deposit',
                                                text: "{{__('Delete Deposit')}}",
                                                checked: ($.inArray('delete-deposit', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'payer',
                                        text: "{{trans('Payer')}}",
                                        expanded: true,
                                        checked: ($.inArray('payer', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-payer',
                                                text: '{{__('View Payer')}}',
                                                checked: ($.inArray('view-payer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-payer',
                                                text: '{{__('Add Payer')}}',
                                                checked: ($.inArray('store-payer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-payer',
                                                text: '{{__('Edit Payer')}}',
                                                checked: ($.inArray('edit-payer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-payer',
                                                text: "{{__('Delete Payer')}}",
                                                checked: ($.inArray('delete-payer', result) >= 0) ? true : false
                                            },
                                        ]
                                    },

                                    {
                                        id: 'payee',
                                        text: "{{trans('payee')}}",
                                        expanded: true,
                                        checked: ($.inArray('payee', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-payee',
                                                text: '{{__('View payee')}}',
                                                checked: ($.inArray('view-payer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-payee',
                                                text: '{{__('Add payee')}}',
                                                checked: ($.inArray('store-payee', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-payee',
                                                text: '{{__('Edit payee')}}',
                                                checked: ($.inArray('edit-payee', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-payee',
                                                text: "{{__('Delete payee')}}",
                                                checked: ($.inArray('delete-payee', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },
                            {
                                id: 'training_module',
                                text: "{{trans('Training Module')}}",
                                expanded: true,
                                checked: ($.inArray('training_module', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'trainer',
                                        text: "{{trans('Trainer')}}",
                                        expanded: true,
                                        checked: ($.inArray('trainer', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-trainer',
                                                text: '{{__('View Trainer')}}',
                                                checked: ($.inArray('view-trainer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-trainer',
                                                text: '{{__('Add Trainer')}}',
                                                checked: ($.inArray('store-trainer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-trainer',
                                                text: '{{__('Edit Trainer')}}',
                                                checked: ($.inArray('edit-trainer', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-trainer',
                                                text: "{{__('Delete Trainer')}}",
                                                checked: ($.inArray('delete-trainer', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'training',
                                        text: "{{trans('Training')}}",
                                        expanded: true,
                                        checked: ($.inArray('training', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-training',
                                                text: '{{__('View Training')}}',
                                                checked: ($.inArray('view-training', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-training',
                                                text: '{{__('Add Training')}}',
                                                checked: ($.inArray('store-training', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-training',
                                                text: '{{__('Edit Training')}}',
                                                checked: ($.inArray('edit-training', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-training',
                                                text: "{{__('Delete Training')}}",
                                                checked: ($.inArray('delete-training', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },

                            {
                                id: 'announcement',
                                text: "{{trans('Announcement')}}",
                                expanded: true,
                                checked: ($.inArray('announcement', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'store-announcement',
                                        text: '{{__('Add Announcement')}}',
                                        checked: ($.inArray('store-announcement', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-announcement',
                                        text: '{{__('Edit Announcement')}}',
                                        checked: ($.inArray('edit-announcement', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-announcement',
                                        text: "{{__('Delete Announcement')}}",
                                        checked: ($.inArray('delete-announcement', result) >= 0) ? true : false
                                    },
                                ]
                            },

                            {
                                id: 'company',
                                text: "{{trans('Company')}}",
                                expanded: true,
                                checked: ($.inArray('company', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-company',
                                        text: '{{__('View Company')}}',
                                        checked: ($.inArray('view-company', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'store-company',
                                        text: '{{__('Add Company')}}',
                                        checked: ($.inArray('store-company', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-company',
                                        text: '{{__('Edit Company')}}',
                                        checked: ($.inArray('edit-company', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-company',
                                        text: "{{__('Delete Company')}}",
                                        checked: ($.inArray('delete-company', result) >= 0) ? true : false
                                    },
                                ]
                            },

                            {
                                id: 'department',
                                text: "{{trans('Department')}}",
                                expanded: true,
                                checked: ($.inArray('department', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-department',
                                        text: '{{__('View Department')}}',
                                        checked: ($.inArray('view-department', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'store-department',
                                        text: '{{__('Add Department')}}',
                                        checked: ($.inArray('store-department', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-department',
                                        text: '{{__('Edit Department')}}',
                                        checked: ($.inArray('edit-department', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-department',
                                        text: "{{__('Delete Department')}}",
                                        checked: ($.inArray('delete-department', result) >= 0) ? true : false
                                    },
                                ]
                            },
                            {
                                id: 'designation',
                                text: "{{trans('Designation')}}",
                                expanded: true,
                                checked: ($.inArray('designation', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-designation',
                                        text: '{{__('View Designation')}}',
                                        checked: ($.inArray('view-designation', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'store-designation',
                                        text: '{{__('Add Designation')}}',
                                        checked: ($.inArray('store-designation', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-designation',
                                        text: '{{__('Edit Designation')}}',
                                        checked: ($.inArray('edit-designation', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-designation',
                                        text: "{{__('Delete Designation')}}",
                                        checked: ($.inArray('delete-designation', result) >= 0) ? true : false
                                    },
                                ]
                            },
                            {
                                id: 'location',
                                text: "{{trans('Location')}}",
                                expanded: true,
                                checked: ($.inArray('location', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-location',
                                        text: '{{__('View Location')}}',
                                        checked: ($.inArray('view-location', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'store-location',
                                        text: '{{__('Add Location')}}',
                                        checked: ($.inArray('store-location', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-location',
                                        text: '{{__('Edit Location')}}',
                                        checked: ($.inArray('edit-location', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-location',
                                        text: "{{__('Delete Location')}}",
                                        checked: ($.inArray('delete-location', result) >= 0) ? true : false
                                    },
                                ]
                            },
                            {
                                id: 'policy',
                                text: "{{trans('Policy')}}",
                                expanded: true,
                                checked: ($.inArray('policy', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'store-policy',
                                        text: '{{__('Add Policy')}}',
                                        checked: ($.inArray('store-policy', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-policy',
                                        text: '{{__('Edit Policy')}}',
                                        checked: ($.inArray('edit-policy', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-policy',
                                        text: "{{__('Delete Policy')}}",
                                        checked: ($.inArray('delete-policy', result) >= 0) ? true : false
                                    },
                                ]
                            },
                            {
                                id: 'performance',
                                text: "{{trans('Performance')}}",
                                expanded: true,
                                checked: ($.inArray('performance', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'goal-type',
                                        text: "{{trans('Goal Type')}}",
                                        expanded: true,
                                        checked: ($.inArray('goal-type', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-goal-type',
                                                text: '{{__('View Goal Type')}}',
                                                checked: ($.inArray('view-goal-type', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-goal-type',
                                                text: '{{__('Add Goal Type')}}',
                                                checked: ($.inArray('store-goal-type', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-goal-type',
                                                text: '{{__('Edit Goal Type')}}',
                                                checked: ($.inArray('edit-goal-type', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-goal-type',
                                                text: "{{__('Delete Goal Type')}}",
                                                checked: ($.inArray('delete-goal-type', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'goal-tracking',
                                        text: "{{trans('Goal Tracking')}}",
                                        expanded: true,
                                        checked: ($.inArray('goal-tracking', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-goal-tracking',
                                                text: '{{__('View Goal Tracking')}}',
                                                checked: ($.inArray('view-goal-tracking', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-goal-tracking',
                                                text: '{{__('Add Goal Tracking')}}',
                                                checked: ($.inArray('store-goal-tracking', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-goal-tracking',
                                                text: '{{__('Edit Goal Tracking')}}',
                                                checked: ($.inArray('edit-goal-tracking', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-goal-tracking',
                                                text: "{{__('Delete Goal Tracking')}}",
                                                checked: ($.inArray('delete-goal-tracking', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'indicator',
                                        text: "{{trans('Indicator')}}",
                                        expanded: true,
                                        checked: ($.inArray('indicator', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-indicator',
                                                text: '{{__('View Indicator')}}',
                                                checked: ($.inArray('view-indicator', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-indicator',
                                                text: '{{__('Add Indicator')}}',
                                                checked: ($.inArray('store-indicator', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-indicator',
                                                text: '{{__('Edit Indicator')}}',
                                                checked: ($.inArray('edit-indicator', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-indicator',
                                                text: "{{__('Delete Indicator')}}",
                                                checked: ($.inArray('delete-indicator', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                    {
                                        id: 'appraisal',
                                        text: "{{trans('Appraisal')}}",
                                        expanded: true,
                                        checked: ($.inArray('appraisal', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-appraisal',
                                                text: '{{__('View Appraisal')}}',
                                                checked: ($.inArray('view-appraisal', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-appraisal',
                                                text: '{{__('Add Appraisal')}}',
                                                checked: ($.inArray('store-appraisal', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-appraisal',
                                                text: '{{__('Edit Appraisal')}}',
                                                checked: ($.inArray('edit-appraisal', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-appraisal',
                                                text: "{{__('Delete Appraisal')}}",
                                                checked: ($.inArray('delete-appraisal', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },
                        ]
                    });


                    // function that gathers IDs of checked nodes
                    function checkedNodeIds(nodes, checkedNodes) {

                        for (var i = 0; i < nodes.length; i++) {
                            if (nodes[i].checked) {
                                getParentIds(nodes[i], checkedNodes);
                                checkedNodes.push(nodes[i].id);
                            }

                            if (nodes[i].hasChildren) {
                                checkedNodeIds(nodes[i].children.view(), checkedNodes);
                            }
                        }
                    }

                    function getParentIds(node, checkedNodes) {
                        if (node.parent() && node.parent().parent() && checkedNodes.indexOf(node.parent().parent().id) == -1) {
                            getParentIds(node.parent().parent(), checkedNodes);
                            checkedNodes.push(node.parent().parent().id);
                        }
                    }

                    // show checked node IDs on datasource change
                    function onCheck() {
                        checkedNodes = [];
                        var treeView1 = $('#treeview1').data("kendoTreeView"),
                            message;
                        var treeView2 = $('#treeview2').data("kendoTreeView"),
                            message;
                        var treeView3 = $('#treeview3').data("kendoTreeView"),
                            message;

                        //console.log(treeView.dataSource.view());
                        //console.log(checkedNodes);

                        checkedNodeIds(treeView1.dataSource.view(), checkedNodes);
                        checkedNodeIds(treeView2.dataSource.view(), checkedNodes);
                        checkedNodeIds(treeView3.dataSource.view(), checkedNodes);

                        // if (checkedNodes.length > 0) {
                        //     message = "IDs of checked nodes: " + checkedNodes.join();
                        // } else {
                        //     message = "No nodes checked.";
                        // }
                        // $("#result").html(message);
                    }

                }
            });


            $('#set_permission_btn').on('click', function () {

                if (checkedNodes) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-T{{trans('file.OK')}}EN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var target = '{{route('set_permission')}}';

                    $.ajax({
                        type: 'POST',
                        url: target,
                        data: {
                            checkedId: checkedNodes,
                            roleId: "{{ $role->id}}",
                        },
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
                            }
                            if (data.error) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            $('#form_result_permission').html(html).slideDown(100).delay(3000).slideUp(100);
                        }
                    });
                } else {
                    alert('{{__('Please select atleast one checkbox')}}');
                }


            });

        });
    })(jQuery);
</script>
@endpush
