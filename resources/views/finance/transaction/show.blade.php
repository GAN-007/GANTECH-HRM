@extends('layout.main')
@section('content')


    <section>


        <div class="container-fluid">
            <h1>{{trans('file.Transaction')}} {{$account->account_name}} </h1>
        </div>


        <div class="table-responsive">
            <table id="transaction_show-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.Account')}}</th>
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
                    <th>{{trans('file.Type')}}</th>
                    <th>{{__('Reference No')}}</th>
                    @if(config('variable.currency_format')=='suffix')
                        <th>{{trans('file.Balance')}} ({{config('variable.currency')}})</th>
                    @else
                        <th>({{config('variable.currency')}}) {{trans('file.Balance')}}</th>
                    @endif
                </tr>
                <tr>
                    @if(config('variable.currency_format')=='suffix')
                        <th colspan="7" class="text-center">{{__('Initial Balance')}} ({{config('variable.currency')}}
                            )
                        </th>
                    @else
                        <th colspan="7" class="text-center">({{config('variable.currency')}}
                            ) {{__('Initial Balance')}}</th>
                    @endif
                    <th colspan="1">{{$account->initial_balance}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $key=>$transaction)
                    <tr data-id="{{$transaction->id}}">
                        <td>{{$key}}</td>
                        <td>{{$transaction->expense_reference ? $transaction->expense_date : $transaction->deposit_date }}</td>
                        <td>{{ $transaction->Account->account_name }}</td>
                        @if($transaction->deposit_reference ==null)
                            <td>0.00</td>
                            <td>{{ $transaction->amount }}</td>
                        @else
                            <td>{{ $transaction->amount }}</td>
                            <td>0.00</td>
                        @endif
                        @if ($transaction->category == 'transfer')
                            <td>{{trans('file.Transfer')}}</td>
                        @else
                            <td>{{ $transaction->expense_reference ? trans('file.Expense') : trans('file.Income') }}</td>
                        @endif
                        <td>{{ $transaction->expense_reference ?? $transaction->deposit_reference }}</td>
                        <td></td>

                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{trans('file.Credit')}}</th>
                    <th>{{trans('file.Debit')}}</th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
                </tfoot>
            </table>
        </div>
    </section>



@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";
        let bla = <?php echo json_encode($account->initial_balance) ?>

        $(document).ready(function () {


            var table_table = $('#transaction_show-table').DataTable({


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
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var debit = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);


                    var total = intVal(bla) + credit - debit;


                    $(api.column(3).footer()).html('<p>Credit: </p>' + credit);
                    $(api.column(4).footer()).html('<p>Debit: </p>' + debit);
                    $(api.column(7).footer()).html('<p>Balance: </p>' + total);
                },
                responsive: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                processing: true,


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
                        'targets': [0, 7],
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

        });

    })(jQuery);
</script>
@endpush
