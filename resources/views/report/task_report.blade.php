@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> {{__('Filter Task')}} </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" id="filter_form" class="form-horizontal">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{__('Selecting',['key'=>trans('file.Task')])}}
                                                            </label>
                                                        <select name="task_id" id="task_id"
                                                                class="form-control selectpicker"
                                                                data-live-search="true" data-live-search-style="contains">
                                                            <option value="0">{{trans('file.All')}}</option>
                                                            @foreach($tasks as $task)
                                                                <option value="{{$task->id}}">{{$task->task_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label>{{trans('file.Status')}}</label>
                                                    <select name="task_status" id="task_status"
                                                            class="form-control selectpicker "
                                                            data-live-search="true" data-live-search-style="contains">
                                                        <option value="0">{{trans('file.All')}}</option>
                                                        <option value="not started">{{__('Not Started')}}</option>
                                                        <option value="ongoing">{{trans('file.Ongoing')}}</option>
                                                        <option value="completed">{{trans('file.Completed')}}</option>
                                                    </select>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-actions">
                                                            <button type="submit" class="filtering btn btn-primary"><i
                                                                        class="fa fa-check-square-o"></i> {{trans('file.Search')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title text-center"><h3>{{__('Task Info')}} <span
                                        id="task_info"></span></h3></div>

                        <div class="table-responsive">
                            <table id="task_report-table" class="table ">
                                <thead>
                                <tr>
                                    <th class="not-exported"></th>
                                    <th>{{__('Task Summary')}}</th>
                                    <th>{{__('Start Date')}}</th>
                                    <th>{{__('End Date')}}</th>
                                    <th>{{trans('file.Status')}}</th>
                                    <th>{{__('Assigned Employees')}}</th>
                                    <th>{{__('Added By')}}</th>
                                    <th>{{__('Task Progress')}}</th>
                                </tr>
                                </thead>
                            </table>
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

        $(document).ready(function () {

            let date = $('.date');
            date.datepicker({
                format: '{{ env('Date_Format_JS')}}',
                autoclose: true,
                todayHighlight: true,
                endDate: new Date()
            });

        });


        fill_datatable();

        function fill_datatable(task_id = '', task_status = '') {

            let table_table = $('#task_report-table').DataTable({
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
                    url: "{{ route('report.task') }}",
                    data: {
                        task_id: task_id,
                        task_status: task_status,
                        "_token": "{{ csrf_token()}}"
                    }
                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'task_name',
                        name: 'task_name',
                    },

                    {
                        data: 'start_date',
                        name: 'start_date',
                    },

                    {
                        data: 'end_date',
                        name: 'end_date',
                    },
                    {
                        data: 'task_status',
                        name: 'task_status',
                    },
                    {
                        data: 'assigned_employee',
                        name: 'assigned_employee',
                        render: function (data) {
                            return   data.join("<br>");
                        }
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                    },
                    {
                        data: 'task_progress',
                        name: 'task_progress',
                        render: function (data) {
                            if (data !== null) {
                                if(data > 70) {
                                    return data + '% complete<div class="progress"><div class="progress-bar green" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                } else if (data > 50) {
                                    return data + '% complete<div class="progress"><div class="progress-bar yellow" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                } else {
                                    return data + '% complete<div class="progress"><div class="progress-bar red" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                }
                            } else {
                                return 0 + '% complete'
                            }
                        }
                    },

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

                        "orderable": true,
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
            new $.fn.dataTable.FixedHeader(table_table);
        }

        $('#filter_form').on('submit',function (e) {
            e.preventDefault();

            let task_id = $('#task_id').val();
            let task_status = $('#task_status').val();
            $('#task_report-table').DataTable().destroy();
            fill_datatable(task_id, task_status);
        });
    })(jQuery);

</script>

@endpush

