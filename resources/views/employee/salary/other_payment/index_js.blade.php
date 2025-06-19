    $('#other_payment-table').DataTable().clear().destroy();

   var table_table = $('#other_payment-table').DataTable({
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
            url: "{{ route('other_payment.show',$employee->id) }}",
        },

        columns: [
            {
                data: 'month_year',
                name : 'month_year'
            },
            {
                data: 'other_payment_title',
                name : 'other_payment_title'
            },
            {
                data: 'other_payment_amount',
                name: 'other_payment_amount',
                render: function (data) {
                    if ('{{config('variable.currency_format') =='suffix'}}') {
                        return data + ' {{config('variable.currency')}}';
                    } else {
                        return '{{config('variable.currency')}} ' + data;
                    }
                }
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


        {{-- 'select': {style: 'multi', selector: 'td:first-child'}, --}}
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);


    $('#create_other_payment_record').click(function () {

        $('.modal-title').text('{{__('Add Other Payment')}}');
        $('#other_payment_action_button').val('{{trans('file.Add')}}');
        $('#other_payment_action').val('{{trans('file.Add')}}');
        $('#OtherPaymentformModal').modal('show');
    });

    $('#other_payment_sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#other_payment_action').val() == '{{trans('file.Add')}}') {

            $.ajax({
                url: "{{ route('other_payment.store',$employee) }}",
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
                        $('#other_payment_sample_form')[0].reset();
                        $('#other_payment-table').DataTable().ajax.reload();
                    }
                    $('#other_payment_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }

            });
        }

        if ($('#other_payment_action').val() == '{{trans('file.Edit')}}') {
            $.ajax({
                url: "{{ route('other_payment.update') }}",
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
                            $('#OtherPaymentformModal').modal('hide');
                            $('#other_payment-table').DataTable().ajax.reload();
                            $('#other_payment_sample_form')[0].reset();
                        }, 2000);

                    }
                    $('#other_payment_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        }
    });


    $(document).on('click', '.other_payment_edit', function () {

        var id = $(this).attr('id');

        var target = "{{ route('other_payment.index') }}/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                let id = html.data.id;
                $('.month_year').val(html.data.month_year);
                $('#other_payment_amount').val(html.data.other_payment_amount);
                $('#other_payment_title').val(html.data.other_payment_title);

                $('#other_payment_hidden_id').val(html.data.id);
                $('.modal-title').text('{{trans('file.Edit')}}');
                $('#other_payment_action_button').val('{{trans('file.Edit')}}');
                $('#other_payment_action').val('{{trans('file.Edit')}}');
                $('#OtherPaymentformModal').modal('show');
            }
        })
    });


    let other_payment_delete_id;

    $(document).on('click', '.other_payment_delete', function () {
    other_payment_delete_id = $(this).attr('id');
        $('.confirmModal').modal('show');
        $('.modal-title').text('{{__('DELETE Record')}}');
        $('.other_payment-ok').text('{{trans('file.OK')}}');
    });


    $('.other_payment-close').click(function () {
        $('#other_payment_sample_form')[0].reset();
        $('.confirmModal').modal('hide');
        $('#other_payment-table').DataTable().ajax.reload();
    });

    $('.other_payment-ok').click(function () {
        let target = "{{ route('other_payment.index') }}/" + other_payment_delete_id + '/delete';
        $.ajax({
            url: target,
            beforeSend: function () {
                $('.other_payment-ok').text('{{trans('file.Deleting...')}}');
            },
            success: function (data) {
                setTimeout(function () {
                    $('.confirmModal').modal('hide');
                    $('#other_payment-table').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });
