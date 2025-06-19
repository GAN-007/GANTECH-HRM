@extends('layout.client')
@section('content')


    <section>

        <div class="table-responsive">
            <table id="client_paid_invoice-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Invoice')}}#</th>
                    <th>{{trans('file.Project')}}</th>
                    <th>{{trans('file.Total')}}</th>
                    <th>{{__('Invoice Date')}}</th>
                    <th>{{__('Due Date')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>

    <script type="text/javascript">
        (function($) {  
         
            "use strict";
            $(document).ready(function () {

                var table_table = $('#client_paid_invoice-table').DataTable({
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
                        url: "{{ route('clientInvoicePaid') }}",
                    },

                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'invoice_number',
                            name: 'invoice_number',
                        },
                        {
                            data: 'project',
                            name: 'project',
                        },
                        {
                            data: 'grand_total',
                            name: 'grand_total',
                            render: function (data, type, row) {
                                return '$' + data
                            }

                        },
                        {
                            data: 'invoice_date',
                            name: 'invoice_date',
                        },
                        {
                            data: 'invoice_due_date',
                            name: 'invoice_due_date',
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function (data, type, row) {
                                if (data == 1) {
                                    return "<td><div class = 'badge badge-success'>{{trans('file.Paid')}}</div></td>";
                                }
                                else {
                                    return "<td><div class = 'badge badge-info'>{{trans('file.Unpaid')}}</div></td>";
                                }
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
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
                new $.fn.dataTable.FixedHeader(table_table);
            });
        
        })(jQuery); 
    </script>

@endsection