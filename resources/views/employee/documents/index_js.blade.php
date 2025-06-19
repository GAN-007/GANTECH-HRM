
    $('#document-table').DataTable().clear().destroy();
    var date = $('.date');
    date.datepicker({
        format: '{{ env('Date_Format_JS')}}',
        autoclose: true,
        todayHighlight: true
    });


    var table_table = $('#document-table').DataTable({
        initComplete: function () {
            this.api().columns([0]).every(function () {
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
            url: "{{ route('documents.show',$employee->id) }}",
        },

        columns: [

            {
                data: 'document',
                name: 'document',

            },
            {
                data: 'title',
                name: 'title',
            },
            {
                data: 'expiry_date',
                name: 'expiry_date',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            }
        ],


        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{__('records per page')}}',
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
        ],


        'select': {style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);


    $('#create_document_record').click(function () {

        $('.modal-title').text('{{__('Add Document')}}');
        $('#document_action_button').val('{{trans('file.Add')}}');
        $('#document_action').val('{{trans('file.Add')}}');
        $('#DocumentformModal').modal('show');
    });

    $('#document_sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#document_action').val() == '{{trans('file.Add')}}') {

            $.ajax({
                url: "{{ route('documents.store',$employee->id) }}",
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
                        $('#document_sample_form')[0].reset();
                        $('select').selectpicker('refresh');
                        $('.date').datepicker('update');
                        $('#document-table').DataTable().ajax.reload();
                    }
                    $('#document_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }

            });
        }

        if ($('#document_action').val() == '{{trans('file.Edit')}}') {
            $.ajax({
                url: "{{ route('documents.update') }}",
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
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }

                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function () {
                            $('#DocumentformModal').modal('hide');
                            $('.date').datepicker('update');
                            $('select').selectpicker('refresh');
                            $('#document-table').DataTable().ajax.reload();
                            $('#document_sample_form')[0].reset();
                        }, 2000);

                    }
                    $('#document_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        }
    });


    $(document).on('click', '.document_edit', function () {

        var id = $(this).attr('id');

        var target = "{{ route('documents.index') }}/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                let id = html.data.id;

                $('#document_title').val(html.data.document_title);
                $('#document_expiry_date').val(html.data.expiry_date);
                $('#document_description').val(html.data.description);
                $('#document_document_type_id').selectpicker('val', html.data.document_type_id);
                if (html.data.is_notify == 1) {
                    $('#document_is_notify').prop('checked', true);
                } else {
                    $('#document_is_notify').prop('checked', false);
                }


                {{--                if(html.data.document_file){--}}
                {{--                let d_link = '{{ route('documents_document.download')}}/' + id;--}}
                {{--                $('#stored_document_document').html('<a href="'+d_link+'"><b>Download</b></a>');--}}
                {{--                }--}}

                $('#document_hidden_id').val(html.data.id);
                $('.modal-title').text('{{trans('file.Edit')}}');
                $('#document_action_button').val('{{trans('file.Edit')}}');
                $('#document_action').val('{{trans('file.Edit')}}');
                $('#DocumentformModal').modal('show');
            }
        })
    });


    let document_delete_id;

    $(document).on('click', '.document_delete', function () {
    document_delete_id = $(this).attr('id');
        $('.confirmModal').modal('show');
        $('.modal-title').text('{{__('DELETE Record')}}');
        $('.document-ok').text('{{trans('file.OK')}}');
    });


    $('.document-close').click(function () {
        $('#document_sample_form')[0].reset();
        $('select').selectpicker('refresh');
        $('.date').datepicker('update');
    $('.confirmModal').modal('hide');
        $('#document-table').DataTable().ajax.reload();
    });

    $('.document-ok').click(function () {
        let target = "{{ route('documents.index') }}/" + document_delete_id + '/delete';
        $.ajax({
            url: target,
            beforeSend: function () {
                $('.document-ok').text('{{trans('file.Deleting...')}}');
            },
            success: function (data) {
                setTimeout(function () {
                    $('.confirmModal').modal('hide');
                    $('#document-table').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });

