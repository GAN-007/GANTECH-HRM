@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header with-border">
                    <h3 class="card-title text-center"> {{__('Generate Payslip')}} </h3>
                </div>
                <span id="bulk_payment_result"></span>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" id="filter_form" class="form-horizontal" >
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control ss selectpicker dynamic" name="filter_company" id="company_id" data-dependent="department_name" data-placeholder="Company" data-column="1" required tabindex="-1" aria-hidden="true">
                                                <option value="0">{{__('All Companies')}}</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}">{{$company->company_name}}</option>
                                                @endforeach
                                                {{ csrf_field() }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control selectpicker default_dept" name="filter_department" id="department_id" data-placeholder="Department" required tabindex="-1" aria-hidden="true">
                                                <option value="0">{{__('All Departments')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input class="form-control month_year date" placeholder="{{__('Select Month')}}" readonly id="month_year" name="month_year" type="text" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div class="form-group">
                                        <div class="form-actions">
                                            <button id="payslip_filter" type="submit" class="filtering btn btn-primary"> <i class="fa fa-search"></i> {{trans('file.Search')}} </button>
                                            <button id="bulk_payment" type="submit" class="filtering btn btn-primary"> <i class="fa fa-check-square-o"></i> {{__('BULK PAYMENT')}} </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-title text-center"><h3>{{__('Payment Info')}} <span id="details_month_year"></span></h3></div>
        <div class="container-fluid"><span id="general_result"></span></div>
        <div class="table-responsive">
            <table id="pay_list-table" class="table">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Name')}}</th>
                    <th>{{__('Payslip Type')}}</th>
                    <th>{{__('Basic Salary')}}</th>
                    <th>{{__('Net Salary')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>
            </table>
        </div>

        <!-- View Details -->
        @include('salary.pay_list.includes.view_details')


        <!--  Generate Payment -->
        @include('salary.pay_list.includes.payslip_generate_info_show')
    </section>
@endsection


@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).ready(function () {

            let date = $('.date');
            date.datepicker({
                format: "MM-yyyy",
                startView: "months",
                minViewMode: 1,
                autoclose: true,
            }).datepicker("setDate", new Date());

            fill_datatable();

            function fill_datatable(filter_company = '', filter_department = '',filter_month_year = '') {
                $('#details_month_year').html($('#month_year').val());
                let table_table = $('#pay_list-table').DataTable({
                    initComplete: function () {
                        this.api().columns([1]).every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                                $('select').selectpicker('refresh');
                            });
                        });
                    },
                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('payroll.index') }}",
                        data: {
                            filter_company: filter_company,
                            filter_department: filter_department,
                            filter_month_year: filter_month_year,
                            "_token": "{{ csrf_token()}}"
                        }
                    },

                    columns: [
                        {
                            data: 'id',
                            orderable:false,
                            searchable:false
                        },
                        {
                            data: 'employee_name',
                            name: 'employee_name'
                        },
                        {
                            data: 'payslip_type',
                            name: 'payslip_type'
                        },
                        {
                            data: 'basic_salary',
                            name: 'basic_salary',
                            render: function (data) {
                                if ('{{config('variable.currency_format') =='suffix'}}') {
                                    return data + ' {{config('variable.currency')}}';
                                } else {
                                    return '{{config('variable.currency')}} ' + data;

                                }
                            }
                        },
                        {
                            data: 'net_salary',
                            name: 'net_salary',
                            render: function (data) {
                                if ('{{config('variable.currency_format') =='suffix'}}') {
                                    return data + ' {{config('variable.currency')}}';
                                } else {
                                    return '{{config('variable.currency')}} ' + data;

                                }
                            }
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function (data) {
                                if (data == 1) {
                                    return "<td><div class = 'badge badge-success'>{{trans('file.Paid')}}</div>"
                                } else {
                                    return "<td><div class = 'badge badge-danger'>{{trans('file.Unpaid')}}</div>"
                                }
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }
                    ],


                    "order": [],
                    'language': {
                        'lengthMenu': '_MENU_ {{__("records per page")}}',
                        "info": '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                        "search": '{{trans("file.Search")}}',
                        'paginate': {
                            'previous': '{{trans("file.Previous")}}',
                            'next': '{{trans("file.Next")}}'
                        }
                    },
                    'columnDefs': [
                        {
                            "orderable": false,
                            'targets': [0],
                        },
                        {
                            'render': function (data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                                }

                                return data;
                            },
                            'checkboxes': {
                                'selectRow': true,
                                'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                            },
                            'targets': [0]
                        }
                    ],

                    'select': {style: 'multi', selector: 'td:first-child'},
                    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    dom: '<"row"lfB>rtip',
                    buttons: [
                        {
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            }

            new $.fn.dataTable.FixedHeader($('#pay_list-table').DataTable());

            $('#filter_form').on('submit',function (e) {
                e.preventDefault();
                var filter_company = $('#company_id').val();
                var filter_department = $('#department_id').val();
                var filter_month_year = $('#month_year').val();
                if (filter_company !== '' && filter_department !== '' && filter_month_year !== '' ) {
                    $('#pay_list-table').DataTable().destroy();
                    fill_datatable(filter_company, filter_department,filter_month_year);
                } else {
                    alert('{{__('Select Both filter option')}}');
                }
            });
        });

        $('#payment_form').on('submit', function(event) {
            event.preventDefault();
            //individual salary id from pay_list table
            let id = $('#employee_id').val();

           $('#hidden_month_year').val($('#month_year').val());

            //target contains payslip.pay
            let target = '{{route('paySlip.index')}}/pay/' + id;
            $.ajax({
                url: target,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    let html = '';
                    if (data.payment_type_error) {
                        html = '<div class="alert alert-danger">' + data.payment_type_error + '</div>';
                        $('#payment_type_error').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#pay_list-table').DataTable().ajax.reload();
                        $('#payment_model').modal('hide').delay(3000);
                    }
                    $('#bulk_payment_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });

        });

        $('#bulk_payment').on('click', function(event) {
            event.preventDefault();

            // var filter_company = $("#filter_company").val();
            // var filter_department = $("#filter_department").val();
            var month_year = $("#month_year").val();

            var allCheckboxId = [];
            let table = $('#pay_list-table').DataTable();
            allCheckboxId = table.rows({selected: true}).ids().toArray();

            //console.log(allCheckboxId);

            let target = '{{route('paySlip.bulk_pay')}}' ;

            $.ajax({
                url: target,
                method: "POST",
                data : {all_checkbox_id : allCheckboxId, month_year:month_year},
                // data: new FormData(document.getElementById("filter_form")),
                // contentType: false,
                // cache: false,
                // processData: false,
                // dataType: "json",
                success: function (data) {
                    console.log(data);
                    let html = '';
                    if (data.payment_type_error) {
                        html = '<div class="alert alert-danger">' + data.payment_type_error + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    $('#bulk_payment_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    $('#pay_list-table').DataTable().rows('.selected').deselect();
                    $('#pay_list-table').DataTable().ajax.reload();
                }
            });

        });

        $('.dynamic').change(function() {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let dependent = $(this).data('dependent');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('dynamic_department') }}",
                    method:"POST",
                    data:{ value:value, _token:_token, dependent:dependent},
                    success:function(result)
                    {
                        $('select').selectpicker("destroy");
                        $('#department_id').html(result);
                        $('.default_dept').prepend('<option value="0" selected>{{__('All Departments')}}</option>');
                        $('select').selectpicker();
                    }
                });
            }
        });

        $('.payment_dynamic').change(function() {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let dependent = $(this).data('dependent');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('dynamic_department') }}",
                    method:"POST",
                    data:{ value:value, _token:_token, dependent:dependent},
                    success:function(result)
                    {
                        $('select').selectpicker("destroy");
                        $('#payment_department_id').html(result);
                        $('.payment_default_dept').prepend('<option value="0" selected>{{__('All Departments')}}</option>');
                        $('select').selectpicker();
                    }
                });
            }
        });

        $(document).on('click', '.delete', function () {
            //individual salary id from pay_list table
            let id = $(this).attr('id');


            $.ajax({
                url: "{{ route('paySlip.index') }}/delete/" + id,
                success: function (data) {
                    let html = '';
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    $('#pay_list-table').DataTable().ajax.reload();
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });

        $('.close').on('click', function () {
            $('#allowance_info').html('');
            $('#commission_info').html('');
            $('#loan_info').html('');
            $('#deduction_info').html('');
            $('#overtime_info').html('');
            $('#other_payment_info').html('');
            $('#total_salary').html('');
            $('#total_deduction').html('');
            $('#total_allowance').html('');
            $('#total_loan').html('');
            $('#total_overtime').html('');
            $('#total_other_payment').html('');
            $('#total_commission').html('');
            $('#pay_list-table').DataTable().ajax.reload();

        });
    })(jQuery);


    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
@endpush
