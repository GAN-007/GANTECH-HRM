@extends('layout.main')
@section('content')


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="container-fluid">
            @can('store-official_document')
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> {{__('Add Official Document')}}</button>
            @endcan
            @can('delete-official_document')
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> {{__('Bulk delete')}}</button>
            @endcan
        </div>


        <div class="table-responsive">
            <table id="official_documents-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Title')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Type')}}</th>
                    <th>{{__('Expiry Date')}}</th>
                    <th>{{trans('file.Notification')}}</th>
                    <th>{{__('Added By')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Document')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">

                        @csrf
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Title')}} *</label>
                                <input type="text" name="document_title" id="document_title" required
                                       class="form-control"
                                       placeholder="{{trans('file.Title')}}">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Document Type')}}</label>
                                <select name="document_type_id" id="document_type_id" required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="begins"
                                        title='{{__('Selecting',['key'=>__('Document Type')])}}...'>
                                    @foreach($document_types as $document_type)
                                        <option value="{{$document_type->id}}">{{$document_type->document_type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Identification Number')}}</label>
                                <input type="text" name="identification_number" id="identification_number"
                                       class="form-control"
                                       placeholder="{{__('Identification Number')}}">
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Company')}}</label>
                                    <select name="company_id" id="company_id" class="form-control selectpicker"
                                            data-live-search="true" data-live-search-style="begins" required
                                            title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Expired Date')}} *</label>
                                <input type="text" name="expiry_date" id="expiry_date" required autocomplete="off"
                                       class="form-control date" placeholder="{{__('Expired Date')}}">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Notification')}}</label>
                                <select name="is_notify" id="is_notify" required class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="begins"
                                        title='{{trans('file.Notification')}}'>
                                    <option value="0">{{__('No Alarm')}}</option>
                                    <option value="7">{{__('One Week')}}</option>
                                    <option value="15">{{__('15 Days')}}</option>
                                    <option value="30">{{__('One Month')}}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Description')}}</label>
                                    <textarea class="form-control" name="description" id="description"
                                              rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Document')}} {{trans('file.File')}} </label>
                                <input type="file" name="document_file" id="document_file" class="form-control">
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                           value={{trans('file.Add')}} />
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>



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


                var table_table = $('#official_documents-table').DataTable({

                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('official_documents.index') }}",
                    },

                    columns: [
                        {
                            data: 'id',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'document_title',
                            name: 'document_title',
                        },
                        {
                            data: 'company',
                            name: 'company',
                        },
                        {
                            data: 'document',
                            name: 'document',
                        },
                        {
                            data: 'expiry_date',
                            name: 'expiry_date',
                        },
                        {
                            data: 'is_notify',
                            name: 'is_notify',
                            render: function (data, type, row) {
                                return data + '{{trans('file.Days')}}';
                            }
                        },
                        {
                            data: 'added_by',
                            name: 'added_by',
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


            $('#create_record').on('click', function () {

                $('.modal-title').text('{{__('Add Document')}}');
                $('#action_button').val('{{trans("file.Add")}}');
                $('#action').val('{{trans("file.Add")}}');
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();
                if ($('#action').val() == '{{trans('file.Add')}}') {

                    $.ajax({
                        url: "{{ route('official_documents.store') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('select').selectpicker('refresh');
                                $('#official_documents-table').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    })
                }

                if ($('#action').val() == '{{trans('file.Edit')}}') {
                    $.ajax({
                        url: "{{ route('official_documents.update') }}",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                setTimeout(function () {
                                    $('#formModal').modal('hide');
                                    $('select').selectpicker('refresh');
                                    $('#official_documents-table').DataTable().ajax.reload();
                                    $('#sample_form')[0].reset();
                                }, 2000);

                            }
                            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    });
                }
            });


            $(document).on('click', '.edit', function () {

                var id = $(this).attr('id');
                $('#form_result').html('');
                $('.file_hide').hide();

                var target = "{{ route('official_documents.index') }}/" + id + '/edit';


                $.ajax({
                    url: target,
                    dataType: "json",
                    success: function (html) {


                        $('#document_title').val(html.data.document_title);
                        $('#identification_number').val(html.data.identification_number);
                        $('#document_type_id').selectpicker('val', html.data.document_type_id);
                        $('#company_id').selectpicker('val', html.data.company_id);
                        $('#expiry_date').val(html.data.expiry_date);
                        $('#is_notify').selectpicker('val', html.data.is_notify);
                        $('#description').val(html.data.description);


                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text('{{trans('file.Edit')}}');
                        $('#action_button').val('{{trans('file.Edit')}}');
                        $('#action').val('{{trans('file.Edit')}}');
                        $('#formModal').modal('show');
                    }
                })
            });


            let delete_id;

            $(document).on('click', '.delete', function () {
                delete_id = $(this).attr('id');
                $('#confirmModal').modal('show');
                $('.modal-title').text('{{__('DELETE Record')}}');
                $('#ok_button').text('{{trans('file.OK')}}');

            });


            $(document).on('click', '#bulk_delete', function () {

                var id = [];
                let table = $('#official_documents-table').DataTable();
                id = table.rows({selected: true}).ids().toArray();
                if (id.length > 0) {
                    if (confirm('{{__('Delete Selection',['key'=>trans('file.Document')])}}')) {
                        $.ajax({
                            url: '{{route('mass_delete_official_documents')}}',
                            method: 'POST',
                            data: {
                                official_documentsIdArray: id
                            },
                            success: function (data) {
                                let html = '';
                                if (data.success) {
                                    html = '<div class="alert alert-success">' + data.success + '</div>';
                                }
                                if (data.error) {
                                    html = '<div class="alert alert-danger">' + data.error + '</div>';
                                }
                                table.ajax.reload();
                                table.rows('.selected').deselect();
                                if (data.errors) {
                                    html = '<div class="alert alert-danger">' + data.error + '</div>';
                                }
                                $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);

                            }

                        });
                    }
                } else {
                    alert('{{__('Please select atleast one checkbox')}}');
                }
            });


            $('.close').on('click', function () {
                $('#sample_form')[0].reset();
                $('select').selectpicker('refresh');
                $('#official_documents-table').DataTable().ajax.reload();
            });

            $('#ok_button').on('click', function () {
                let target = "{{ route('official_documents.index') }}/" + delete_id + '/delete';
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
                            $('#official_documents-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });

        })(jQuery);
    </script>

@endsection
