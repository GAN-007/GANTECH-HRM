@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> {{__('Deposit Report')}} </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" id="filter_form" class="form-horizontal">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-6 form-group">
                                                    <label>{{trans('file.category')}} *</label>
                                                    <select name="category" id="category" class="form-control selectpicker "
                                                            data-live-search="true" data-live-search-style="contains">
                                                        <option value="0">{{trans('file.All')}}</option>
                                                        <option value="Envato">{{trans('file.Envato')}}</option>
                                                        <option value="salary">{{trans('file.Salary')}}</option>
                                                        <option value="interest income">{{__('Interest Income')}}</option>
                                                        <option value="regular income">{{__('Regular Income')}}</option>
                                                        <option value="part time work">{{__('Part Time Work')}}</option>
                                                        <option value="other income">{{__('Other Income')}}</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="start_date">{{__('Start Date')}}</label>
                                                        <input class="form-control month_year date"
                                                               placeholder="{{__('Select Date')}}"
                                                               id="start_date" name="start_date" type="text" required>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="end_date">{{__('End Date')}}</label>
                                                        <input class="form-control month_year date"
                                                               placeholder="{{__('Select Date')}}"
                                                               id="end_date" name="end_date" type="text" required>
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

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title text-center"><h3>{{__('Deposit Info')}} <span
                                        id="expense_info"></span></h3></div>


                        <div class="table-responsive">
                            <table id="deposit_report-table" class="table ">
                                <thead>
                                <tr>
                                    <th class="not-exported"></th>
                                    <th>{{trans('file.Date')}}</th>
                                    <th>{{trans('file.Account')}}</th>
                                    <th>{{trans('file.Category')}}</th>
                                    <th>{{trans('file.Payer')}}</th>
                                    @if(config('variable.currency_format')=='suffix')
                                        <th>{{trans('file.Amount')}} ({{config('variable.currency')}})</th>
                                    @else
                                        <th>({{config('variable.currency')}}) {{trans('file.Amount')}}</th>
                                    @endif
                                    <th>{{__('Reference No')}}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>{{trans('file.Total')}}</th>
                                    <th></th>
                                </tr>
                                </tfoot>
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
            });

        });


        fill_datatable();

        function fill_datatable(filter_start_date = '', filter_end_date = '',category='') {


            let table_table = $('#deposit_report-table').DataTable({

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // converting to interger to find total
                    var intVal = function (i) {
                        return typeof i == 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i == 'number' ?
                                i : 0;
                    };

                    // computing column Total of the complete result
                    var total = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);



                    $(api.column(5).footer()).html('<p>Total: </p>' + total);
                },

                responsive: true,

                fixedHeader: {
                    header: true,
                    footer: true
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('report.deposit') }}",
                    data: {
                        filter_start_date: filter_start_date,
                        filter_end_date: filter_end_date,
                        category: category,
                        "_token": "{{ csrf_token()}}"
                    },
                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'deposit_date',
                        name: 'deposit_date',
                    },
                    {
                        data: 'account',
                        name: 'account',
                    },
                    {
                        data: 'category',
                        name: 'category',
                    },
                    {
                        data: 'payer',
                        name: 'payer',
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        render: function (data) {
                            if ('{{config('variable.currency_format') =='suffix'}}') {
                                return data + ' {{config('variable.currency')}}';
                            } else {
                                return '{{config('variable.currency')}} ' + data;

                            }
                        }
                    },
                    {
                        data: 'deposit_reference',
                        name: 'deposit_reference',
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
            let category = $('#category').val();

            if (filter_start_date !== '' && filter_end_date !== '' && category !== '' ) {
                $('#deposit_report-table').DataTable().destroy();
                fill_datatable(filter_start_date, filter_end_date,category);
            } else {
                alert('{{__('Select Both filter option')}}');
            }
        });
    })(jQuery);

</script>

@endpush

