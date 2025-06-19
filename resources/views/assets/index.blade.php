@extends('layout.main')
@section('content')


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="container-fluid">
            @if (Auth::user()->can('store-assets'))
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                    class="fa fa-plus"></i> {{__('Add Assets')}}</button>
            @endif

            @if (Auth::user()->can('delete-assets'))
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                    class="fa fa-minus-circle"></i> {{__('Bulk delete')}}</button>
            @endcan
        </div>


        <div class="table-responsive">
            <table id="asset-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{__('Asset Name')}}</th>
                    <th>{{trans('file.category')}}</th>
                    <th>{{__('Company Asset Code')}}</th>
                    <th>{{__('Is Working')}}?</th>
                    <th>{{__('Assign To')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Warranty')}} {{trans('file.Date')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                    {{-- @if (Auth::user()->can('delete-assets'))

                    @endcan --}}
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Assets')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i
                                class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">

                        @csrf
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label>{{__('Asset Name')}} *</label>
                                <input type="text" name="asset_name" id="asset_name" required class="form-control"
                                       placeholder="{{__('Asset Name')}}">
                            </div>


                            <div class="col-md-6 form-group">
                                <label>{{__('Company Asset Code')}} </label>
                                <input type="text" name="asset_code" id="asset_code" class="form-control"
                                       placeholder="{{__('Company Asset Code')}}">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.category')}}</label>
                                <select name="assets_category_id" id="assets_category_id"
                                        class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='{{__('Selecting',['key'=>trans('file.Category')])}}...'>
                                    @foreach($asset_categories as $asset_category)
                                        <option value="{{$asset_category->id}}">{{$asset_category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Is Working')}}</label>
                                <select name="status" id="status" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='{{__('Selecting',['key'=>trans('file.Status')])}}...'>
                                    <option value="yes">{{trans('file.Yes')}}</option>
                                    <option value="no">{{trans('file.No')}}</option>
                                    <option value="on maintenance">{{__('On Maintenance')}}</option>
                                </select>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Company')}}</label>
                                    <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="contains"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Employee')}}</label>
                                    <select name="employee_id" id="employee_id" class="selectpicker form-control"
                                            data-live-search="true" data-live-search-style="contains"
                                            title='{{__('Selecting',['key'=>trans('file.Employee')])}}...'>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Purchase')}} {{trans('file.Date')}} *</label>
                                <input type="text" name="purchase_date" id="purchase_date" required
                                       class="form-control date" autocomplete="off" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Warranty/AMC')}} {{__('End Date')}} *</label>
                                <input type="text" name="warranty_date" id="warranty_date" required
                                       class="form-control date" autocomplete="off" value="">
                            </div>


                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Manufacturer')}} *</label>
                                <input type="text" name="manufacturer" id="manufacturer" required class="form-control"
                                       autocomplete="off" value="">
                            </div>


                            <div class="col-md-6 form-group">
                                <label>{{__('Invoice Number')}}</label>
                                <input type="text" name="invoice_number" id="invoice_number" class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Serial Number')}}</label>
                                <input type="text" name="serial_number" id="serial_number" class="form-control">
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Asset Note')}}</label>
                                    <textarea class="form-control" id="asset_note" name="asset_note"
                                              rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Assets')}} {{__('Image')}} </label>
                                <input type="file" name="asset_image" id="asset_image" class="form-control"
                                       placeholder={{trans("file.Optional")}}>
                                <span id="asset_logo_link"></span>
                                <span id="asset_logo"></span>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                           value={{trans('file.Add')}}>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>





    <div class="modal fade" id="asset_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"
        >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{__('Assets Info')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table  table-bordered">

                                    <tr>
                                        <th>{{__('Asset Name')}}</th>
                                        <td id="asset_name_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Company Asset Code')}}</th>
                                        <td id="asset_code_show"></td>
                                    </tr>


                                    <tr>
                                        <th>{{trans('file.Category')}}</th>
                                        <td id="assets_category_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Company')}}</th>
                                        <td id="company_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Employee')}}</th>
                                        <td id="employee_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Manufacturer')}}</th>
                                        <td id="manufacturer_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Purchase')}} {{trans('file.Date')}}</th>
                                        <td id="purchase_date_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('(file.Warranty/AMC')}} {{__('End Date')}}</th>
                                        <td id="warranty_date_show"></td>
                                    </tr>


                                    <tr>
                                        <th>{{__('Invoice Number')}}</th>
                                        <td id="invoice_number_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Serial Number')}}</th>
                                        <td id="serial_number_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Status')}}</th>
                                        <td id="status_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Assets Info')}}</th>
                                        <td id="asset_note_show"></td>
                                    </tr>


                                    <tr>
                                        <th>{{trans('file.Assets')}} {{__('Image')}}</th>
                                        <td><p id="asset_image_show"></p>
                                            <p id="asset_image_show_link"></p>
                                        </td>
                                    </tr>

                                </table>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.Close')}}</button>
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
                todayHighlight: true
            });


            let table_table = $('#asset-table').DataTable({
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
                    url: "{{ route('assets.index') }}",
                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'asset_name',
                        name: 'asset_name',
                    },
                    {
                        data: 'category',
                        name: 'category',
                    },

                    {
                        data: 'asset_code',
                        name: 'asset_code',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'employee',
                        name: 'employee',
                    },
                    {
                        data: 'company',
                        name: 'company',
                    },
                    {
                        data: 'warranty_date',
                        name: 'warranty_date',
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
                        // 'targets': [0, 7],
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
        });


        tinymce.init({
            selector: 'textarea',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
            height: 130,

            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            /*
              URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
              images_upload_url: 'postAcceptor.php',
              here we add custom filepicker only to Image dialog
            */
            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: function (cb, value, meta) {
                let input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                /*
                  Note: In modern browsers input[type="file"] is functional without
                  even adding it to the DOM, but that might not be the case in some older
                  or quirky browsers like IE, so you might want to add it to the DOM
                  just in case, and visually hide it. And do not forget do remove it
                  once you do not need it anymore.
                */

                input.onchange = function () {
                    let file = this.files[0];

                    let reader = new FileReader();
                    reader.onload = function () {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        let id = 'blobid' + (new Date()).getTime();
                        let blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        let base64 = reader.result.split(',')[1];
                        let blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), {title: file.name});
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },

            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code wordcount'
            ],
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            branding: false
        });


        $('#create_record').on('click', function () {

            $('.modal-title').text('{{__('Add Assets')}}');
            $('#action_button').val('{{trans("file.Add")}}');
            $('#action').val('{{trans("file.Add")}}');
            $('#asset_logo').html('');
            $('#asset_logo_link').html('');
            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function (event) {
            event.preventDefault();
            if ($('#action').val() == '{{trans("file.Add")}}') {

                $.ajax({
                    url: "{{ route('assets.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        let html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (let count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#sample_form')[0].reset();
                            $('select').selectpicker('refresh');
                            $('.date').datepicker('update');
                            $('#asset-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            }

            if ($('#action').val() == '{{trans("file.Edit")}}') {
                $.ajax({
                    url: "{{ route('assets.update') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        let html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (let count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            setTimeout(function () {
                                $('#formModal').modal('hide');
                                $('.date').datepicker('update');
                                $('select').selectpicker('refresh');
                                $('#asset-table').DataTable().ajax.reload();
                                $('#sample_form')[0].reset();
                            }, 2000);

                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                });
            }
        });

        $(document).on('click', '.show_new', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            let target = '{{route('assets.index')}}/' + id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (result) {

                    if (result.data.Asset_note) {
                        function htmlDecode(input) {
                            let e = document.createElement('div');
                            e.innerHTML = input;
                            return e.childNodes.length == 0 ? "" : e.childNodes[0].nodeValue;
                        }

                        $('#asset_note_show').html(htmlDecode(result.data.Asset_note));
                    }
                    $('#company_id_show').html(result.company_name);
                    $('#employee_id_show').html(result.employee_name);
                    $('#assets_category_id_show').html(result.assets_category_name);
                    $('#purchase_date_show').html(result.data.purchase_date);
                    $('#warranty_date_show').html(result.data.warranty_date);
                    $('#status_show').html(result.data.status);
                    $('#manufacturer_show').html(result.data.manufacturer);
                    $('#invoice_number_show').html(result.data.invoice_number);
                    $('#serial_number_show').html(result.data.serial_number);
                    $('#asset_name_show').html(result.data.asset_name);
                    $('#asset_code_show').html(result.data.asset_code);

                    if (result.data.asset_image) {
                        let d_link = '{{ route('assets.download')}}/' + id;
                        $('#asset_image_show_link').html('<a href="' + d_link + '"><strong>{{ __('Download') }}</strong></a><br>');
                        $('#asset_image_show').html("<img src={{ URL::to('/public') }}/uploads/asset_file/" + result.data.asset_image + " width='70'  class='img-thumbnail' />");

                    }

                    $('#asset_modal').modal('show');
                    $('.modal-title').text('{{__('Assets Info')}}');
                }
            });
        });


        $(document).on('click', '.edit', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            let target = "{{ route('assets.index') }}/" + id + '/edit';


            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {
                    if (html.data.Asset_note) {
                        function htmlDecode(input){
                            let e = document.createElement('div');
                            e.innerHTML = input;
                            return e.childNodes.length == 0 ? "" : e.childNodes[0].nodeValue;
                        }
                        tinymce.get('asset_note').setContent(htmlDecode(html.data.Asset_note));
                    }
                    $('#purchase_date').val(html.data.purchase_date);
                    $('#warranty_date').val(html.data.warranty_date);
                    $('#asset_name').val(html.data.asset_name);
                    $('#asset_code').val(html.data.asset_code);
                    $('#manufacturer').val(html.data.manufacturer);
                    $('#invoice_number').val(html.data.invoice_number);
                    $('#serial_number').val(html.data.serial_number);
                    $('#assets_category_id').selectpicker('val', html.data.assets_category_id);
                    $('#status').selectpicker('val', html.data.status);
                    $('#company_id').selectpicker('val', html.data.company_id);

                    let all_employees = '';
                    $.each(html.employees, function (index, value) {
                        all_employees += '<option value=' + value['id'] + '>' + value['first_name'] + ' ' + value['last_name'] + '</option>';
                    });
                    $('#employee_id').empty().append(all_employees);
                    $('#employee_id').selectpicker('refresh');
                    $('#employee_id').selectpicker('val', html.data.employee_id);
                    $('#employee_id').selectpicker('refresh');

                    if (html.data.asset_image) {
                        let d_link = '{{ route('assets.download')}}/' + id;
                        $('#asset_logo_link').html('<a href="' + d_link + '"><strong>{{ __('Download') }}</strong></a><br>');
                        $('#asset_logo').html("<img src={{ URL::to('/public') }}/uploads/asset_file/" + html.data.asset_image + " width='70'  class='img-thumbnail' />");

                    }


                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text('{{trans("file.Edit")}}');
                    $('#action_button').val('{{trans("file.Edit")}}');
                    $('#action').val('{{trans("file.Edit")}}');
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

            let id = [];
            let table = $('#asset-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('{{__('Delete Selection',['key'=>trans('file.Asset Info')])}}')) {
                    $.ajax({
                        url: '{{route('mass_delete_assets')}}',
                        method: 'POST',
                        data: {
                            assetIdArray: id
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
            $('#asset_logo').html('');
            $('.date').datepicker('update');
            $('#asset-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "{{ route('assets.index') }}/" + delete_id + '/delete';
            $.ajax({
                url: target,
                beforeSend: function () {
                    $('#ok_button').text('{{trans('file.Deleting...')}}');
                },
                success: function (data) {
                    setTimeout(function () {
                        $('#confirmModal').modal('hide');
                        $('#asset-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });

        $('.dynamic').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let first_name = $(this).data('first_name');
                let last_name = $(this).data('last_name');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('dynamic_employee') }}",
                    method: "POST",
                    data: {value: value, _token: _token, first_name: first_name, last_name: last_name},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#employee_id').html(result);
                        $('select').selectpicker();

                    }
                });
            }
        });
    })(jQuery);
</script>
@endpush
