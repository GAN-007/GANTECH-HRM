
    $('#contact-table').DataTable().clear().destroy();


    var table_table = $('#contact-table').DataTable({
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
            url: "{{ route('contacts.show',$employee->id) }}",
        },

        columns: [

            {
                data: 'contact_name',
                name: 'contact_name',
            },
            {
                data: 'relation',
                name: 'relation',
            },
            {
                data: 'personal_email',
                name: 'personal_email',
            },

            {
                data: 'personal_phone',
                name: 'personal_phone',
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
                'targets': [0, 4],
            },
        ],


        'select': {style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);


    $('#create_contact_record').click(function () {

        $('.modal-title').text("Add New Contact");
        $('#contact_action_button').val('{{trans('file.Add')}}');
        $('#contact_action').val('{{trans('file.Add')}}');
        $('#ContactformModal').modal('show');
    });

    $('#contact_sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#contact_action').val() == '{{trans('file.Add')}}') {

            $.ajax({
                url: "{{ route('contacts.store',$employee->id) }}",
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
                        $('#contact_sample_form')[0].reset();
                        $('select').selectpicker('refresh');
                        $('#contact-table').DataTable().ajax.reload();
                    }
                    $('#contact_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }

            });
        }

        if ($('#contact_action').val() == '{{trans('file.Edit')}}') {
            $.ajax({
                url: "{{ route('contacts.update') }}",
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
                            $('#ContactformModal').modal('hide');
                            $('select').selectpicker('refresh');
                            $('#contact-table').DataTable().ajax.reload();
                            $('#contact_sample_form')[0].reset();
                        }, 2000);

                    }
                    $('#contact_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        }
    });


    $(document).on('click', '.contact_edit', function () {

        var id = $(this).attr('id');

        var target = "{{ route('contacts.index') }}/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                let id = html.data.id;

                $('#contact_name').val(html.data.contact_name);
                $('#contact_work_email').val(html.data.work_email);
                $('#contact_personal_email').val(html.data.personal_email);
                $('#contact_address_1').val(html.data.address1);
                $('#contact_address_2').val(html.data.address2);
                $('#contact_work_phone').val(html.data.work_phone);
                $('#contact_work_phone_ext').val(html.data.work_phone_ext);
                $('#contact_personal_phone').val(html.data.personal_phone);
                $('#contact_home_phone').val(html.data.home_phone);
                $('#contact_city').val(html.data.city);
                $('#contact_state').val(html.data.state);
                $('#contact_zip').val(html.data.zip);
                if (html.data.is_primary == 1) {
                    $('#contact_is_primary').prop('checked', true);
                } else {
                    $('#contact_is_primary').prop('checked', false);
                }
                if (html.data.is_dependent == 1) {
                    $('#contact_is_dependent').prop('checked', true);
                } else {
                    $('#contact_is_dependent').prop('checked', false);
                }

                $('#contact_relation').selectpicker('val', html.data.relation);
                $('#contact_country').selectpicker('val', html.data.country_id);


                $('#contact_hidden_id').val(html.data.id);
                $('.modal-title').text('{{trans('file.Edit')}}');
                $('#contact_action_button').val('{{trans('file.Edit')}}');
                $('#contact_action').val('{{trans('file.Edit')}}');
                $('#ContactformModal').modal('show');
            }
        })
    });


    let contact_delete_id;

    $(document).on('click', '.contact_delete', function () {
    contact_delete_id = $(this).attr('id');
        $('.confirmModal').modal('show');
        $('.modal-title').text('{{__('DELETE Record')}}');
        $('.contact-ok').text('{{trans('file.OK')}}');
    });


    $('.contact-close').click(function () {
        $('#contact_sample_form')[0].reset();
        $('select').selectpicker('refresh');
    $('.confirmModal').modal('hide');
        $('#contact-table').DataTable().ajax.reload();
    });

    $('.contact-ok').click(function () {
        let target = "{{ route('contacts.index') }}/" + contact_delete_id + '/delete';
        $.ajax({
            url: target,
            beforeSend: function () {
                $('.contact-ok').text('{{trans('file.Deleting...')}}');
            },
            success: function (data) {
                setTimeout(function () {
                    $('.confirmModal').modal('hide');
                    $('#contact-table').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });

