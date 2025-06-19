@extends('layout.main')
@section('content')

    <section>

        <div class="container-fluid mb-3">
            <h2>{{__('Account Balances')}}</h2>
        </div>


        <div class="table-responsive">
            <table id="account_balance-table" class="table ">
                <thead>
                <tr>
                    <th>{{trans('file.Account')}}</th>
                    @if(config('variable.currency_format')=='suffix')
                        <th>{{trans('file.Balance')}} ({{config('variable.currency')}})</th>
                    @else
                        <th>({{config('variable.currency')}}) {{trans('file.Balance')}}</th>
                    @endif
                </tr>
                </thead>

                <tfoot>
                <tr>
                    @if(config('variable.currency_format')=='suffix')
                        <th>{{trans('file.Total')}} ({{config('variable.currency')}})</th>
                    @else
                        <th>({{config('variable.currency')}}) {{trans('file.Total')}}</th>
                    @endif
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
        let total;
        let pageTotal;


        $(document).ready(function() {


            $("ul#hrm").siblings('a').attr('aria-expanded', 'true');
            $("ul#hrm").addClass("show");
            $("ul#hrm #Finance").addClass("active");


         let  table = $('#account_balance-table').DataTable({

             "footerCallback": function ( row, data, start, end, display ) {
                 var api = this.api(), data;

                 // Remove the formatting to get integer data for summation
                 var intVal = function ( i ) {
                     return typeof i == 'string' ?
                         i.replace(/[\$,]/g, '')*1 :
                         typeof i == 'number' ?
                             i : 0;
                 };

                 // Total over all pages
                 total = api
                     .column( 1 )
                     .data()
                     .reduce( function (a, b) {
                         return intVal(a) + intVal(b);
                     }, 0 );

                 // Total over this page
                 pageTotal = api
                     .column( 1, { page: 'current'} )
                     .data()
                     .reduce( function (a, b) {
                         return intVal(a) + intVal(b);
                     }, 0 );

                 // Update footer
                 $( api.column( 1 ).footer() ).html(
                     +pageTotal +' ('+ total +' {{trans('file.Total')}})'
                 );
             },

                responsive: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('account_balances') }}",
                },

                columns: [
                    {
                        data: 'account_name',
                        name: 'account_name',
                    },
                    {
                        data: 'account_balance',
                        name: 'account_balance',
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
                        'targets': [0, 1],
                    }

                ],
                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });
        });
    })(jQuery);
</script>
@endpush
