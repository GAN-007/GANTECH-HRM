@extends('layout.client')
@section('content')


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>


        <div class="container-fluid">

            <button type="button" class="btn btn-info mb-4" name="create_record" id="create_record"><i
                        class="fa fa-plus"></i> {{__('Add Project')}}</button>


        </div>

        <div class="table-responsive">
            <table id="client_project-table" class="table">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{__('Project Summary')}}</th>
                    <th>{{trans('file.Priority')}}</th>
                    <th>{{__('Assigned Employees')}}</th>
                    <th>{{__('Start Date')}}</th>
                    <th>{{__('End Date')}}</th>
                    <th>{{__('Project Progress')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Project')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">

                        @csrf

                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Title')}} *</label>
                                <input type="text" name="title" id="title" required class="form-control"
                                       placeholder="{{trans('file.Title')}}">
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


                            <div class="col-md-6 form-group">
                                <label>{{__('Start Date')}} *</label>
                                <input type="text" name="start_date" id="start_date" autocomplete="off" required
                                       class="form-control date"
                                       value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('End Date')}} *</label>
                                <input type="text" name="end_date" id="end_date" autocomplete="off" required
                                       class="form-control date"
                                       value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{trans('file.Priority')}}</label>
                                <select name="project_priority" id="project_priority" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='{{__('Selecting',['key'=>trans('file.Priority')])}}...'>
                                    <option value="low">{{trans('file.Low')}}</option>
                                    <option value="medium">{{trans('file.Medium')}}</option>
                                    <option value="high">{{trans('file.High')}}</option>
                                    <option value="highest">{{trans('file.Highest')}}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Summary')}}</label>
                                    <textarea class="form-control" id="summary"
                                              name="summary" rows="3"></textarea>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{trans('file.Description')}}</label>
                                    <textarea class="form-control des-editor" id="description" name="description"
                                              rows="3"></textarea>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
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


                let table_table = $('#client_project-table').DataTable({
                    initComplete: function () {
                        this.api().columns([1]).every(function () {
                            let column = this;
                            let select = $('<select><option value=""></option></select>')
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
                        url: "{{ route('clientProject') }}",
                    },

                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'summary',
                            name: 'summary'

                        },
                        {
                            data: 'project_priority',
                            name: 'project_priority',
                        },
                        {
                            data: 'assigned_employee',
                            name: 'assigned_employee',
                            render: function (data) {
                                return data.join("<br>");
                            }
                        },
                        {
                            data: 'start_date',
                            name: 'start_date',
                        },
                        {
                            data: 'end_date',
                            name: 'end_date',
                        },
                        {
                            data: 'project_progress',
                            name: 'project_progress',
                            render: function (data) {
                                if (data !== null) {
                                    if(data > 70) {
                                        return data + '% complete<div class="progress"><div class="progress-bar green" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                    } else if (data > 50) {
                                        return data + '% complete<div class="progress"><div class="progress-bar yellow" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                    } else {
                                        return data + '% complete<div class="progress"><div class="progress-bar red" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                    }
                                } else {
                                    return 0 + '% complete'
                                }
                            }
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
                selector: '.des-editor',
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
                    var input = document.createElement('input');
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
                            let blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            let base64 = reader.result.split(',')[1];
                            let blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), { title: file.name });
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

                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function (event) {
                event.preventDefault();


                $.ajax({
                    url: "{{ route('clientProject.store') }}",
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
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#sample_form')[0].reset();
                            $('select').selectpicker('refresh');
                            $('#client_project-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            });

            $('.close').on('click', function () {
                $('#sample_form')[0].reset();
                $('#client_project-table').DataTable().ajax.reload();
            });
            
        })(jQuery); 
    </script>

@endsection