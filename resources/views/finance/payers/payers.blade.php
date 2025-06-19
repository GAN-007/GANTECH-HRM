@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">

                        <div class="card-header"><h3 class="card-title">{{__('Add Payers')}}</h3></div>
                        <form method="post" id="payers_form" class="form-horizontal" >
                            @csrf
                            <div class="col-md-4 form-group">
                                <label>{{__('Payer Name')}} *</label>
                                <input type="text" name="payer_name" id="payer_name"  required class="form-control required"
                                       placeholder="{{__('Payer Name')}}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>{{trans('file.Phone')}}*</label>
                                <input type="text" name="contact_no" id="contact_no"  required class="form-control required"
                                       placeholder="{{trans('file.Phone')}}">
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="submit" name="payers_form_submit" id="payers_form_submit" class="btn btn-success" value={{trans("file.Save")}}>
                            </div>
                        </form>
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-body">
                                    <span class="payers_result"></span>
                                    <div class="table-responsive">
                                        <table id="payers-table" class="table ">
                                            <thead>
                                            <tr>
                                                <th>{{__('Payer Name')}}</th>
                                                <th>{{trans('file.Phone')}}</th>
                                                <th>{{__('Created At')}}</th>
                                                <th class="not-exported">{{trans('file.action')}}</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="PayersEditModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 id="PayersModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                                        <button type="button" data-dismiss="modal" id="payers_close" aria-label="Close" class="close"><span
                                                    aria-hidden="true">×</span></button>
                                    </div>
                                    <span class="payers_result_edit"></span>

                                    <div class="modal-body">
                                        <form method="post" id="payers_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                                            @csrf
                                            <div class="col-md-4 form-group">
                                                <label>{{__('Payer Name')}} *</label>
                                                <input type="text" name="payer_name_edit" id="payer_name_edit"  required class="form-control required"
                                                       placeholder="{{__('Payer Name')}}">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label>{{trans('file.Phone')}}*</label>
                                                <input type="text" name="contact_no_edit" id="contact_no_edit"  required class="form-control required"
                                                       placeholder="{{trans('file.Phone')}}">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                                <input type="submit" name="payers_edit_submit" id="payers_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
        $(document).ready(function() {
            var table_table = $('#payers-table').DataTable({
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
                    url: "{{ route('payers.index') }}",

                },


                columns: [

                    {
                        data: 'payer_name',
                        name: 'payer_name',
                        searchable: true
                    },
                    {
                        data: 'contact_no',
                        name: 'contact_no',
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
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
                        'targets': [0, 2],
                    },

                ],


                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],

            });
            new $.fn.dataTable.FixedHeader(table_table);

            $('#payers_form_submit').on('click', function(event) {
                event.preventDefault();
                let payer_name = $('input[name="payer_name"]').val();
                let contact_no = $('input[name="contact_no"]').val();

                $.ajax({
                    url: "{{ route('payers.store') }}",
                    method: "POST",
                    data: { payer_name:payer_name,contact_no:contact_no},
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
                            $('#payers_form')[0].reset();
                            $('#payers-table').DataTable().ajax.reload();
                        }
                        $('.payers_result').html(html).slideDown(300).delay(5000).slideUp(300);

                    }
                });

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('.payers_result').html('');

                var target = "{{ route('payers.index') }}/"+id+'/edit';
                $.ajax({
                    url:target,
                    dataType:"json",
                    success:function(html){

                        $('#payer_name_edit').val(html.data.payer_name);
                        $('#contact_no_edit').val(html.data.contact_no);

                        $('#hidden_id').val(html.data.id);
                        $('#PayersEditModal').modal('show');
                    }
                })

            });

            $('#payers_edit_submit').on('click', function(event) {
                event.preventDefault();
                let payer_name_edit = $('input[name="payer_name_edit"]').val();
                let contact_no_edit = $('input[name="contact_no_edit"]').val();
                let hidden_id= $('#hidden_id').val();

                $.ajax({
                    url: "{{ route('payers.update') }}",
                    method: "POST",
                    data: { payer_name_edit:payer_name_edit,contact_no_edit:contact_no_edit,hidden_id:hidden_id},
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
                            $('#payers_form_edit')[0].reset();
                            $('#payers-table').DataTable().ajax.reload();
                        }
                        $('.payers_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
                        setTimeout(function(){
                            $('#PayersEditModal').modal('hide')
                        }, 5000);

                    }
                });

            });



            $(document).on('click', '.delete', function() {

                let delete_id = $(this).attr('id');
                let target = "{{ route('payers.index') }}/" + delete_id + '/delete';
                if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
                    $.ajax({
                        url: target,
                        success: function (data) {
                            var html = '';
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            setTimeout(function () {
                                $('#payers-table').DataTable().ajax.reload();
                            }, 2000);
                            $('.payers_result').html(html).slideDown(300).delay(3000).slideUp(300);

                        }
                    })
                }

            });

            $('.close').on('click', function() {
                $('#payers_form')[0].reset();
                $('#payers-table').DataTable().ajax.reload();
            });
        });
    })(jQuery);
</script>

@endpush
