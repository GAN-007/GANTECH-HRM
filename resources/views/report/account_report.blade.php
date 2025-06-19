@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> {{__('Account Report')}} </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" id="filter_form" class="form-horizontal">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>{{trans('file.Account')}} *</label>
                                                        <select name="account_id" id="account_id"  class="form-control selectpicker" required
                                                                data-live-search="true" data-live-search-style="contains"
                                                                title='{{__('Selecting',['key'=>trans('file.Account')])}}...'>
                                                            @foreach($accounts as $account)
                                                                <option value="{{$account->id}}">{{$account->account_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="start_date">{{__('Start Date')}}</label>
                                                        <input class="form-control month_year date"
                                                               placeholder="{{__('Select Date')}}"
                                                               id="start_date" name="start_date" type="text" required
                                                               >
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="end_date">{{__('End Date')}}</label>
                                                        <input class="form-control month_year date"
                                                               placeholder="{{__('Select Date')}}"
                                                               id="end_date" name="end_date" type="text" required
                                                               >
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

                        <div class="card-title text-center"><h3>{{__('Account Info')}} <span
                                        id="account_info"></span></h3></div>

                        <div class="table-responsive">
                            <table id="account_report-table" class="table ">
                                <thead>
                                <tr>
                                    <th class="not-exported"></th>
                                    <th>{{trans('file.Date')}}</th>
                                    <th>{{trans('file.Type')}}</th>
                                    <th>{{__('Reference No')}}</th>
                                    @if(config('variable.currency_format')=='suffix')
                                        <th>{{trans('file.Credit')}} ({{config('variable.currency')}})</th>
                                    @else
                                        <th>({{config('variable.currency')}}) {{trans('file.Credit')}}</th>
                                    @endif
                                    @if(config('variable.currency_format')=='suffix')
                                        <th>{{trans('file.Debit')}} ({{config('variable.currency')}})</th>
                                    @else
                                        <th>({{config('variable.currency')}}) {{trans('file.Debit')}}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>{{trans('file.Credit')}}</th>
                                    <th>{{trans('file.Debit')}}</th>
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

        function fill_datatable(filter_start_date = '', filter_end_date = '', account_id = '') {


            let table_table = $('#account_report-table').DataTable({

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
                    var credit = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var debit = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);



                    $(api.column(4).footer()).html('<p>Credit: </p>' + credit);
                    $(api.column(5).footer()).html('<p>Debit: </p>' + debit);
                },

                responsive: true,

                fixedHeader: {
                    header: true,
                    footer: true
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('report.account') }}",
                    data: {
                        filter_start_date: filter_start_date,
                        filter_end_date: filter_end_date,
                        account_id: account_id,
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
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'reference_no',
                        name: 'reference_no',
                    },
                    {
                        data: 'credit',
                        name: 'credit'
                    },
                    {
                        data: 'debit',
                        name: 'debit',
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
            let account_id = $('#account_id').val();

            if (filter_start_date !== '' && filter_end_date !== '' && account_id !== '') {
                $('#account_report-table').DataTable().destroy();
                fill_datatable(filter_start_date, filter_end_date, account_id);
            } else {
                alert('{{__('Select Both filter option')}}');
            }
        });
    })(jQuery);

</script>
@endpush

