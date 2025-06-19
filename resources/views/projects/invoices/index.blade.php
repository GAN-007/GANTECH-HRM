@extends('layout.main')
@section('content')


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>


        <div class="container-fluid">
            @can('store-invoice')
                <a class="btn btn-info" id="create_record" href="{{route('invoices.create')}}"><i class="fa fa-plus"></i> {{__('Add Invoice')}}</a>
            @endcan
        </div>

        <div class="table-responsive">
            <table id="invoice-table" class="table ">
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
                    <th>{{__('Change Status')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>


    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">{{trans('file.OK')}}'
                    </button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>






@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).ready(function () {


            var table_table = $('#invoice-table').DataTable({
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
                    url: "{{ route('invoices.index') }}",
                },

                columns: [
                    {
                        data: 'id',
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
                            if("{{config('variable.currency_format')=='suffix'}}") {
                                return data + "{{config('variable.currency')}}"
                            }
                            else {
                                return  "{{config('variable.currency')}}" + data
                            }
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
                            if (data == 0) {
                                return "<td><div class = 'badge badge-info'>{{trans('file.Unpaid')}}</div></td>";
                            } if (data == 1) {
                                return "<td><div class = 'badge badge-success'>{{trans('file.Paid')}}</div></td>";
                            }
                            else {
                                return "<td><div class = 'badge badge-success'>{{trans('file.Sent')}}</div></td>";
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                    {
                        data: 'change_status',
                        name: 'change_status',
                        render: function (data,type,row) {
                            if (row.status == 1) {
                                return '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change Status &nbsp;</button><div class="dropdown-menu">' +
                                    '<li data-status_id="'+0+'" data-invoice_id="'+row.id+'"  class="invoice_status">{{trans('file.Unpaid')}}</li>'+
                                    '</div></div>';
                            }
                            if (row.status == 2) {
                                return '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change Status &nbsp;</button><div class="dropdown-menu">' +
                                    '<li data-status_id="'+1+'" data-invoice_id="'+row.id+'"  class="invoice_status">{{trans('file.Paid')}}</li>'+
                                    '</div></div>';
                            }
                            return '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change Status &nbsp;</button><div class="dropdown-menu">' +
                                '<li data-status_id="'+1+'" data-invoice_id="'+row.id+'"  class="invoice_status">{{trans('file.Paid')}}</li><hr>'+
                                '<li data-status_id="'+2+'" data-invoice_id="'+row.id+'" class="invoice_status">{{trans('file.Send')}}</li>'+
                                '</div></div>';
                        }
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


        let delete_id;

        $(document).on('click', '.delete', function () {
            delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('{{__('DELETE Record')}}');
            $('#ok_button').text('{{trans('file.OK')}}');

        });


        $('.close').on('click', function () {
            $('#sample_form')[0].reset();
            $('select').selectpicker('refresh');
            $('#invoice-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "{{ route('invoices.index') }}/" + delete_id + '/delete';
            $.ajax({
                url: target,
                beforeSend: function () {
                    $('#ok_button').text('{{trans('file.Deleting...')}}');
                },
                success: function (data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    setTimeout(function () {
                        $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        $('#confirmModal').modal('hide');
                        $('#invoice-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });


        $('body').on('click', '.invoice_status', function () {

            let status_id = $(this).attr('data-status_id');
            let invoice_id = $(this).attr('data-invoice_id');


            var target = "{{ url('project-management/invoices/status')}}/" + status_id +'/'+invoice_id;

            $.ajax({
                url: target,
                method: "get",

                success: function (data) {
                    console.log(data);
                    var html = '';
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';

                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function () {
                            $('#general_result').html(html);
                            $('#invoice-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                }
            });
        });
    })(jQuery);
</script>
@endpush
