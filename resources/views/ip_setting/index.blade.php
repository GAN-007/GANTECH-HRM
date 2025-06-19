@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>

    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">{{__('IP Settings')}}</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>{{__('Add New')}}</button>
        <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i>{{__('Bulk Delete')}}</button>
    </div>

    <div class="container">
        <div class="table-responsive">
            <table id="ipSettingTable" class="table">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('IP Address')}}</th>
                        <th class="not-exported">{{__('Action')}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

@include('ip_setting.create_modal')
@include('ip_setting.edit_modal')
@include('ip_setting.confirm_modal')
@include('ip_setting.bulk_delete_confirm')

{{-- @include('performance.goal-type.delete-confirm-modal') --}}
{{-- @include('performance.goal-type.delete-checkbox-confirm-modal')  --}}




@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = $('#ipSettingTable').DataTable({
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
                    url: "{{ route('ip_setting.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
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
                        'targets': [0, 3],
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

            new $.fn.dataTable.FixedHeader(table);
        });


        //----------Insert Data----------------------
        $("#submit_form").on("submit", function (event) {
            event.preventDefault();
            var name = $("#name").val();
            var ipAddress = $("#ipAddress").val();

            $.ajax({
                url: "{{ route('ip_setting.store') }}",
                method: "POST",
                data: {name:name, ip_address:ipAddress},
                success: function (data) {
                    //console.log(data);
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
                        $('#submit_form')[0].reset();
                        $('#createModal').modal('hide');
                        $('#ipSettingTable').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });


        //--------- Edit -------
        $(document).on('click', '.edit', function () {

            var id = $(this).data("id");
            //$('#update_form').html('');

            $.ajax({
                url: "{{ route('ip_setting.edit') }}",
                method: "GET",
                data: {id:id},
                success: function (data) {
                    $('#id').val(data.id);
                    $('#nameEdit').val(data.name);
                    $('#ipAddressEdit').val(data.ip_address);
                    $('#editModal').modal('show');
                }
            })
        });


        //----------Update Data----------------------
        $("#update_form").on("submit", function (event) {
            event.preventDefault();

            var id        = $("#id").val();
            var name      = $("#nameEdit").val();
            var ipAddress = $("#ipAddressEdit").val();

            $.ajax({
                url: "{{ route('ip_setting.update') }}",
                method: "POST",
                data: {id:id, name:name, ip_address:ipAddress},
                success: function (data) {
                    //console.log(data);
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    else if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#submit_form')[0].reset();
                        $('#editModal').modal('hide');
                        $('#ipSettingTable').DataTable().ajax.reload();
                    }
                    $('#form_result_edit').html(html).slideDown(300).delay(5000).slideUp(300);
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });


        //--------- Delete -------
        $(document).on('click', '.delete', function () {

            $('#confirmDeleteModal').modal('show');
            var id = $(this).data("id");

            $("#deleteSubmit").on("click",function(e){
                $.ajax({
                    url: "{{ route('ip_setting.delete') }}",
                    method: "GET",
                    data: {id:id},
                    success: function (data) {
                        if (data.success) {
                            $('#confirmDeleteModal').modal('hide');
                            $('#ipSettingTable').DataTable().ajax.reload();
                        }
                        $('#general_result').html(data.success).slideDown(300).delay(5000).slideUp(300);
                    }
                });
            });
        });


        //------ Bulk Delete ---------
        $("#bulk_delete").on("click",function(){
            var idsArray = [];
            let table = $('#ipSettingTable').DataTable();
            idsArray = table.rows({selected: true}).ids().toArray();
            // console.log(idsArray);

            if(idsArray.length == 0){
                alert("Please Select at least one checkbox.");
            }else{

                $('#bulkDeleteConfirmModal').modal('show');
                $("#bulkDeleteSubmitModal").on("click",function(e){
                    $.ajax({
                        url: "{{ route('ip_setting.bulk_delete') }}",
                        method: "GET",
                        data: {idsArray:idsArray},
                        success: function (data) {
                            console.log(data);
                            if (data.success) {
                                $('#bulkDeleteConfirmModal').modal('hide');
                                table.rows('.selected').deselect();
                                $('#ipSettingTable').DataTable().ajax.reload();
                            }
                            $('#general_result').html(data.success).slideDown(300).delay(5000).slideUp(300);
                        }
                    });
                });
            }

        });
    </script>
@endpush
