@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">

            {{-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div> --}}

            <div class="card">
                <div class="card-body">

                    <div class="card-title text-center"><h3>{{__('Daily Attendances')}}<span id="details_month_year"></span></h3></div>

                    <form method="post" id="filter_form" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 offset-md-3 mb-2">
                                <label for="day_month_year">{{__('Select Date')}}</label>
                                <div class="input-group">
                                    <input class="form-control month_year date" placeholder="{{__('Select Date')}}" readonly="" id="day_month_year" name="day_month_year" type="text" value="{{now()->format(env('date_format'))}}">
                                    <button type="submit" class="filtering btn btn-primary"><i class="fa fa-search"></i> {{trans('file.Search')}}
                                        </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="daily_attendance-table" class="table ">
                <thead>
                <tr>
                    <th>{{trans('file.Employee')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.status')}}</th>
                    <th>{{__('Clock In')}}</th>
                    <th>{{__('Clock Out')}}</th>
                    <th>{{trans('file.Late')}}</th>
                    <th>{{__('Early Leaving')}}</th>
                    <th>{{trans('file.Overtime')}}</th>
                    <th>{{__('Total Work')}}</th>
                    <th>{{__('Total Rest')}}</th>
                </tr>
                </thead>
            </table>
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


            fill_datatable();

            function fill_datatable(filter_month_year = '') {

                let table_table = $('#daily_attendance-table').DataTable({
                initComplete: function () {
                    this.api().columns([2, 4]).every(function () {
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
                        url: "{{ route('attendances.index') }}",
                        data: {
                            filter_month_year: filter_month_year,
                            "_token": "{{ csrf_token()}}"
                        }
                    },

                    columns: [
                        {
                            data: 'employee_name',
                            name: 'employee_name'
                        },
                        {
                            data: 'company',
                            name: 'company'
                        },
                        {
                            data: 'attendance_date',
                            name: 'attendance_date',
                        },
                        {
                            data: 'attendance_status',
                            name: 'attendance_status'
                        },
                        {
                            data: 'clock_in',
                            name: 'clock_in',
                        },
                        {
                            data: 'clock_out',
                            name: 'clock_out',
                        },
                        {
                            data: 'time_late',
                            name: 'time_late',
                        },
                        {
                            data: 'early_leaving',
                            name: 'early_leaving',
                        },
                        {
                            data: 'overtime',
                            name: 'overtime',
                        },
                        {
                            data: 'total_work',
                            name: 'total_work'
                        },
                        {
                            data: 'total_rest',
                            name: 'total_rest'
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
                            "orderable": false,
                            'targets': [0, 10],
                        },
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

            new $.fn.dataTable.FixedHeader($('#daily_attendance-table').DataTable());

            $('#filter_form').on('submit',function (e) {
                e.preventDefault();
                var filter_month_year = $('#day_month_year').val();
                if (filter_month_year !== '') {
                    $('#daily_attendance-table').DataTable().destroy();
                    fill_datatable(filter_month_year);
                } else {
                    alert('{{__('Select Both filter option')}}');
                }
            });
        });
    })(jQuery);
</script>
@endpush
