
$('#bank_account-table').DataTable().clear().destroy();


    var table_table = $('#bank_account-table').DataTable({
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
            url: "{{ route('bank_account.show',$employee->id) }}",
        },

        columns: [

            {
                data: 'account_title',
                name: 'account_title',
            },
            {
                data: 'account_number',
                name: 'account_number',
            },
            {
                data: 'bank_name',
                name: 'bank_name',
            },
            {
                data: 'bank_branch',
                name: 'bank_branch',
            },
            {
                data: 'bank_code',
                name: 'bank_code',
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
                'targets': [0, 5],
            },
        ],


        'select': {style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);


    $('#create_bank_account_record').click(function () {

        $('.modal-title').text("{{__('Add Bank Account')}}");
        $('#bank_account_action_button').val('{{trans('file.Add')}}');
        $('#bank_account_action').val('{{trans('file.Add')}}');
        $('#BankAccountformModal').modal('show');
    });

    $('#bank_account_sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#bank_account_action').val() == '{{trans('file.Add')}}') {

            $.ajax({
                url: "{{ route('bank_account.store',$employee->id) }}",
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
                        $('#bank_account_sample_form')[0].reset();
                        $('#bank_account-table').DataTable().ajax.reload();
                    }
                    $('#bank_account_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }

            });
        }

        if ($('#bank_account_action').val() == '{{trans('file.Edit')}}') {
            $.ajax({
                url: "{{ route('bank_account.update') }}",
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
                            $('#BankAccountformModal').modal('hide');
                            $('#bank_account-table').DataTable().ajax.reload();
                            $('#bank_account_sample_form')[0].reset();
                        }, 2000);

                    }
                    $('#bank_account_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        }
    });


    $(document).on('click', '.bank_account_edit', function () {

        var id = $(this).attr('id');

        var target = "{{ route('bank_account.index') }}/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                let id = html.data.id;

                $('#bank_account_title').val(html.data.account_title);
                $('#bank_account_number').val(html.data.account_number);
                $('#bank_bank_name').val(html.data.bank_name);
                $('#bank_bank_code').val(html.data.bank_code);
                $('#bank_bank_branch').val(html.data.bank_branch);


                $('#bank_account_hidden_id').val(html.data.id);
                $('.modal-title').text('{{trans('file.Edit')}}');
                $('#bank_account_action_button').val('{{trans('file.Edit')}}');
                $('#bank_account_action').val('{{trans('file.Edit')}}');
                $('#BankAccountformModal').modal('show');
            }
        })
    });


    let bank_delete_id;

    $(document).on('click', '.bank_account_delete', function () {
bank_delete_id = $(this).attr('id');
        $('.confirmModal').modal('show');
        $('.modal-title').text('{{__('DELETE Record')}}');
        $('.bank-ok').text('{{trans('file.OK')}}');
    });


    $('.bank-close').click(function () {
        $('#bank_account_sample_form')[0].reset();
        $('.confirmModal').modal('hide');
        $('#bank_account-table').DataTable().ajax.reload();
    });

    $('.bank-ok').click(function () {
        let target = "{{ route('bank_account.index') }}/" + bank_delete_id + '/delete';
        $.ajax({
            url: target,
            beforeSend: function () {
                $('.bank-ok').text('{{trans('file.Deleting...')}}');
            },
            success: function (data) {
                setTimeout(function () {
                    $('.confirmModal').modal('hide');
                    $('#bank_account-table').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });
