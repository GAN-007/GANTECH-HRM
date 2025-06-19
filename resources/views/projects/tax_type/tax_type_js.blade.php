
    $('#tax_type-table').DataTable().clear().destroy();

    var table_table = $('#tax_type-table').DataTable({
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
            url: "{{ route('tax_type.index') }}",

        },


        columns: [

            {
                data: 'name',
                name: 'name',
            },
            {
                data: null,
                render: function (data,type,row) {
                    if (row.type == 'fixed') {
                        if ('{{config('variable.currency_format') =='suffix'}}') {
                            return row.rate+ ' {{config('variable.currency')}}';
                        } else {
                            return '{{config('variable.currency')}} ' + row.rate;
                        }
                    } else {
                        return row.rate + '%';
                    }
                    }
            },
            {
                data: 'type',
                name: 'type',
            },
            {
                data: 'description',
                name: 'description',
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
                'targets': [0, 4],
            },

        ],


        'select': {style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
    new $.fn.dataTable.FixedHeader(table_table);

    $('#tax_type_submit').on('click', function (event) {
        event.preventDefault();
        let name = $('input[name="name"]').val();
        let rate = $('input[name="rate"]').val();
        let description = $('textarea[name="description"]').val();
        let type = $('select[name="type"]').val();

        $.ajax({
            url: "{{ route('tax_type.store') }}",
            method: "POST",
            data: {name: name, rate: rate, description: description, type: type},
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
                    $('#tax_type_form')[0].reset();
                    $('select').selectpicker('refresh');
                    $('#tax_type-table').DataTable().ajax.reload();
                }
                $('.tax_result').html(html).slideDown(300).delay(5000).slideUp(300);

            }
        });

    });

    $(document).on('click', '.tax_edit', function () {
        var id = $(this).attr('id');
        $('.tax_result').html('');

        var target = "{{ route('tax_type.index') }}/" + id + '/edit';
        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                $('#name_edit').val(html.data.name);
                $('#rate_edit').val(html.data.rate);
                $('#description_edit').val(html.data.description);
                $('#type_edit').selectpicker('val', html.data.type);

                $('#hidden_tax_id').val(html.data.id);
                $('#TaxEditModal').modal('show');
            }
        })

    });

    $('#tax_type_edit_submit').on('click', function (event) {
        event.preventDefault();
        let name_edit = $('input[name="name_edit"]').val();
        let rate_edit = $('input[name="rate_edit"]').val();
        let description_edit = $('textarea[name="description_edit"]').val();
        let type_edit = $('select[name="type_edit"]').val();

        let hidden_tax_id = $('#hidden_tax_id').val();

        $.ajax({
            url: "{{ route('tax_type.update') }}",
            method: "POST",
            data: {
                name_edit: name_edit,
                rate_edit: rate_edit,
                description_edit: description_edit,
                type_edit: type_edit,
                hidden_tax_id: hidden_tax_id
            },
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
                    $('#tax_type_form_edit')[0].reset();
                    $('select').selectpicker('refresh');
                    $('#tax_type-table').DataTable().ajax.reload();
                }
                $('.tax_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
                setTimeout(function () {
                    $('#TaxEditModal').modal('hide')
                }, 5000);

            }
        });

    });


    $(document).on('click', '.tax_delete', function () {

        let delete_id = $(this).attr('id');
        let target = "{{ route('tax_type.index') }}/" + delete_id + '/delete';
        if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
            $.ajax({
                url: target,
                success: function (data) {
                    var html = '';
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    setTimeout(function () {
                        $('#tax_type-table').DataTable().ajax.reload();
                    }, 2000);
                    $('.tax_result').html(html).slideDown(300).delay(3000).slideUp(300);

                }
            })
        }

    });

    $('#tax_close').on('click', function () {
        $('#tax_type_form')[0].reset();
        $('select').selectpicker('refresh');
        $('#tax_type-table').DataTable().ajax.reload();
    });

