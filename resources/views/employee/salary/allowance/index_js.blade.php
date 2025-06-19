
    $('#allowance-table').DataTable().clear().destroy();

    var table_table = $('#allowance-table').DataTable({
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
            url: "{{ route('salary_allowance.show',$employee->id) }}",
        },

        columns: [

            {
                data: 'month_year',
                name: 'month_year',
            },
            {
                data: 'is_taxable',
                name: 'is_taxable',
                render: function (data, type, row) {
                    if (data == 1) {
                        return "{{trans('file.Taxable')}}";
                    } else {
                        return "{{trans('file.Non-Taxable')}}"
                    }
                }

            },
            {
                data: 'allowance_title',
                name: 'allowance_title'
            },
            {
                data: 'allowance_amount',
                name: 'allowance_amount',
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
                'targets': [0, 4],
            },
        ],


        {{-- 'select': {style: 'multi', selector: 'td:first-child'}, --}}
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);


    $('#create_allowance_record').click(function () {

        $('.modal-title').text('{{__('Add Allowance')}}');
        $('#allowance_action_button').val('{{trans('file.Add')}}');
        $('#allowance_action').val('{{trans('file.Add')}}');
        $('#AllowanceformModal').modal('show');
    });

    $('#allowance_sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#allowance_action').val() == '{{trans('file.Add')}}') {

            $.ajax({
                url: "{{ route('salary_allowance.store',$employee) }}",
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
                        $('#allowance_sample_form')[0].reset();
                        $('select').selectpicker('refresh');
                        $('#allowance-table').DataTable().ajax.reload();
                    }
                    $('#allowance_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }

            });
        }

        if ($('#allowance_action').val() == '{{trans('file.Edit')}}') {
            $.ajax({
                url: "{{ route('salary_allowance.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    console.log(data);
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
                            $('#AllowanceformModal').modal('hide');
                            $('select').selectpicker('refresh');
                            $('#allowance-table').DataTable().ajax.reload();
                            $('#allowance_sample_form')[0].reset();
                        }, 2000);

                    }
                    $('#allowance_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        }
    });


    $(document).on('click', '.allowance_edit', function () {

        var id = $(this).attr('id');
        var target = "{{ route('salary_allowance.index') }}/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {
                console.log(html);
                let id = html.data.id;
                $('.month_year').val(html.data.month_year);
                $('#allowance_amount').val(html.data.allowance_amount);
                $('#allowance_title').val(html.data.allowance_title);
                $('#allowance_is_taxable').selectpicker('val', html.data.is_taxable);

                $('#allowance_hidden_id').val(html.data.id);
                $('.modal-title').text('{{trans('file.Edit')}}');
                $('#allowance_action_button').val('{{trans('file.Edit')}}');
                $('#allowance_action').val('{{trans('file.Edit')}}');
                $('#AllowanceformModal').modal('show');
            }
        })
    });


    let allowance_delete_id;

    $(document).on('click', '.allowance_delete', function () {
    allowance_delete_id = $(this).attr('id');
        $('.confirmModal').modal('show');
        $('.modal-title').text('{{__('DELETE Record')}}');
        $('.allowance-ok').text('{{trans('file.OK')}}');
    });


    $('.allowance-close').click(function () {
        $('#allowance_sample_form')[0].reset();
        $('select').selectpicker('refresh');
        $('.confirmModal').modal('hide');
        $('#allowance-table').DataTable().ajax.reload();
    });

    $('.allowance-ok').click(function () {
        let target = "{{ route('salary_allowance.index') }}/" + allowance_delete_id + '/delete';
        $.ajax({
            url: target,
            beforeSend: function () {
                $('.allowance-ok').text('{{trans('file.Deleting...')}}');
            },
            success: function (data) {
                setTimeout(function () {
                    $('.confirmModal').modal('hide');
                    $('#allowance-table').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });
