@extends('layout.main')
@section('content')



    <section>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> {{__('Training Report')}} </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" id="filter_form" class="form-horizontal">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="start_date">{{__('Start Date')}}</label>
                                                        <input class="form-control month_year date"
                                                               placeholder="{{__('Select Date')}}" readonly=""
                                                               id="start_date" name="start_date" type="text" required
                                                               value="">
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="start_date">{{__('End Date')}}</label>
                                                        <input class="form-control month_year date"
                                                               placeholder="{{__('Select Date')}}" readonly=""
                                                               id="end_date" name="end_date" type="text" required
                                                               value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('file.Company')}} *</label>
                                                        <select name="company_id" id="company_id"
                                                                class="form-control selectpicker" required
                                                                data-live-search="true" data-live-search-style="contains"
                                                                title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                                            @foreach($companies as $company)
                                                                <option value="{{$company->id}}">{{$company->company_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
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

            <div class="table-responsive">
                <table id="training_report-table" class="table ">
                    <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{trans('file.Company')}}</th>
                        <th>{{trans('file.Employee')}}</th>
                        <th>{{__('Training Type')}}</th>
                        <th>{{trans('file.Trainer')}}</th>
                        <th>{{__('Training Duration')}}</th>
                        <th>{{trans('file.Cost')}}</th>
                    </tr>
                    </thead>

                </table>
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
                todayHighlight: true
            });

        });


        fill_datatable();

        function fill_datatable(filter_start_date = '', filter_end_date = '', company_id = '') {

            let table_table = $('#training_report-table').DataTable({
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
                    url: "{{ route('report.training') }}",
                    data: {
                        filter_start_date: filter_start_date,
                        filter_end_date: filter_end_date,
                        company_id: company_id,
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
                        data: 'company',
                        name: 'company',
                    },
                    {
                        data: 'employee',
                        render: function (data) {
                            return data.join("<br>");
                        }
                    },
                    {
                        data: 'TrainingType',
                        name: 'TrainingType',
                    },
                    {
                        data: 'trainer',
                        name: 'trainer',
                    },
                    {
                        data: 'training_duration',
                        name: 'training_duration',

                    },
                    {
                        data: 'training_cost',
                        name: 'training_cost',
                        render: function (data) {
                            if ('{{config('variable.currency_format') =='suffix'}}') {
                                return data + ' {{config('variable.currency')}}';
                            } else {
                                return '{{config('variable.currency')}} ' + data;

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
            var filter_start_date = $('#start_date').val();
            var filter_end_date = $('#end_date').val();
            let company_id = $('#company_id').val();
            if (filter_start_date !== '' && filter_end_date !== '' && company_id !== '') {
                $('#training_report-table').DataTable().destroy();
                fill_datatable(filter_start_date, filter_end_date, company_id);
            } else {
                alert('{{__('Select Date and Company')}}');
            }
        });

    })(jQuery);

</script>
@endpush
