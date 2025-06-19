@extends('layout.main')
@section('content')

    <section>

        @can('store-assets-category')
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{__('Add Asset Category')}}</h3>
                        <form method="post" id="assets_category_form" class="form-horizontal" >
                            @csrf
                            <div class="input-group">

                                <input type="text" name="category_name" id="category_name"  required class="form-control"
                                    placeholder="{{trans('file.Name')}} *">
                                <input type="submit" name="assets_category_submit" id="assets_category_submit" class="btn btn-success" value={{trans("file.Save")}}>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        <span class="assets_result"></span>
        <div class="table-responsive">
            <table id="assets_category-table" class="table ">
                <thead>
                <tr>
                    <th>{{trans('file.Name')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>

    <div id="AssetCategoryEditModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="AssetCategoryModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                    <button type="button" data-dismiss="modal" id="assets_close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>
                <span class="assets_result_edit"></span>

                <div class="modal-body">
                    <form method="post" id="assets_category_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                        @csrf
                        <div class="col-md-4 form-group">
                            <label>{{trans('file.Name')}} *</label>
                            <input type="text" name="category_name_edit" id="category_name_edit" required class="form-control"
                                   placeholder="{{trans('file.Name')}}">
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="hidden" name="hidden_assets_id" id="hidden_assets_id" />
                            <input type="submit" name="assets_category_edit_submit" id="assets_category_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                        </div>
                    </form>
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

            let table_table = $('#assets_category-table').DataTable({
                initComplete: function () {
                    this.api().columns([1]).every(function () {
                        let column = this;
                        let select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                let val = $.fn.dataTable.util.escapeRegex(
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
                    url: "{{ route('assets_category.index') }}",

                },


                columns: [
                    {
                        data: 'category_name',
                        name: 'category_name',
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
                        'targets': [0, 1],
                    },

                ],


                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],

            });
            new $.fn.dataTable.FixedHeader(table_table);
        });

        $('#assets_category_submit').on('click', function(event) {
            event.preventDefault();
            let category_name = $('input[name="category_name"]').val();

            $.ajax({
                url: "{{ route('assets_category.store') }}",
                method: "POST",
                data: { category_name:category_name},
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#assets_category_form')[0].reset();
                        $('#assets_category-table').DataTable().ajax.reload();
                    }
                    $('.assets_result').html(html).slideDown(300).delay(5000).slideUp(300);

                }
            });

        });

        $(document).on('click', '.assets_category_edit', function(){
            let id = $(this).attr('id');
            $('.assets_result').html('');

            let target = "{{ route('assets_category.index') }}/"+id+'/edit';
            $.ajax({
                url:target,
                dataType:"json",
                success:function(html){

                    $('#category_name_edit').val(html.data.category_name);

                    $('#hidden_assets_id').val(html.data.id);
                    $('#AssetCategoryEditModal').modal('show');
                }
            })

        });

        $('#assets_category_edit_submit').on('click', function(event) {
            event.preventDefault();
            let category_name_edit = $('input[name="category_name_edit"]').val();
            let hidden_assets_id= $('#hidden_assets_id').val();

            $.ajax({
                url: "{{ route('assets_category.update') }}",
                method: "POST",
                data: { category_name_edit:category_name_edit,hidden_assets_id:hidden_assets_id},
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#assets_category_form_edit')[0].reset();
                        $('#assets_category-table').DataTable().ajax.reload();
                    }
                    $('.assets_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
                    setTimeout(function(){
                        $('#AssetCategoryEditModal').modal('hide')
                    }, 5000);

                }
            });

        });

        $(document).on('click', '.assets_category_delete', function() {

            let delete_id = $(this).attr('id');
            let target = "{{ route('assets_category.index') }}/" + delete_id + '/delete';
            if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
                $.ajax({
                    url: target,
                    success: function (data) {
                        let html = '';
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function () {
                            $('#assets_category-table').DataTable().ajax.reload();
                        }, 2000);
                        $('.assets_result').html(html).slideDown(300).delay(3000).slideUp(300);

                    }
                })
            }

        });

        $('.close').on('click', function() {
            $('#assets_category_form')[0].reset();
            $('#assets_category-table').DataTable().ajax.reload();
        });
    })(jQuery);
</script>
@endpush
