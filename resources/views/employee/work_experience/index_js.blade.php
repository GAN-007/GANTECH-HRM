

    $('#work_experience-table').DataTable().clear().destroy();
    var date = $('.date');
    date.datepicker({
        format: '{{ env('Date_Format_JS')}}',
        autoclose: true,
        todayHighlight: true
    });


    var table_table = $('#work_experience-table').DataTable({
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
            url: "{{ route('work_experience.show',$employee->id) }}",
        },

        columns: [

            {
                data: 'company_name',
                name: 'company_name',
            },
            {
                data: 'post',
                name: 'post',
            },
            {
                data: 'from_year',
                name: 'from_year',
            },
            {
                data: 'to_year',
                name: 'to_year',

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
                'targets': [0],
            },
        ],


        'select': {style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);


    $('#create_work_experience_record').click(function () {

        $('.modal-title').text('{{__('Add Work Experience')}}');
        $('#work_experience_action_button').val('{{trans('file.Add')}}');
        $('#work_experience_action').val('{{trans('file.Add')}}');
        $('#WorkExperienceformModal').modal('show');
    });

    $('#work_experience_sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#work_experience_action').val() == '{{trans('file.Add')}}') {

            $.ajax({
                url: "{{ route('work_experience.store',$employee->id) }}",
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
                        $('#work_experience_sample_form')[0].reset();
                        $('select').selectpicker('refresh');
                        $('.date').datepicker('update');
                        $('#work_experience-table').DataTable().ajax.reload();
                    }
                    $('#work_experience_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }

            });
        }

        if ($('#work_experience_action').val() == '{{trans('file.Edit')}}') {
            $.ajax({
                url: "{{ route('work_experience.update') }}",
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
                            $('#WorkExperienceformModal').modal('hide');
                            $('.date').datepicker('update');
                            $('select').selectpicker('refresh');
                            $('#work_experience-table').DataTable().ajax.reload();
                            $('#work_experience_sample_form')[0].reset();
                        }, 2000);

                    }
                    $('#work_experience_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        }
    });


    $(document).on('click', '.work_experience_edit', function () {

        var id = $(this).attr('id');

        var target = "{{ route('work_experience.index') }}/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                let id = html.data.id;

                $('#work_company_name').val(html.data.company_name);
                $('#work_experience_from_date').val(html.data.from_year);
                $('#work_experience_to_date').val(html.data.to_year);
                $('#work_experience_description').val(html.data.description);
                $('#work_post').val(html.data.post);




    $('#work_experience_hidden_id').val(html.data.id);
                $('.modal-title').text('{{trans('file.Edit')}}');
                $('#work_experience_action_button').val('{{trans('file.Edit')}}');
                $('#work_experience_action').val('{{trans('file.Edit')}}');
                $('#WorkExperienceformModal').modal('show');
            }
        })
    });


    let experience_delete_id;

    $(document).on('click', '.work_experience_delete', function () {
    experience_delete_id = $(this).attr('id');
        $('.confirmModal').modal('show');
        $('.modal-title').text('{{__('DELETE Record')}}');
        $('.experience-ok').text('{{trans('file.OK')}}');
    });


    $('.experience-close').click(function () {
        $('#work_experience_sample_form')[0].reset();
        $('select').selectpicker('refresh');
        $('.date').datepicker('update');
        $('.confirmModal').modal('hide');
        $('#work_experience-table').DataTable().ajax.reload();
    });

    $('.experience-ok').click(function () {
        let target = "{{ route('work_experience.index') }}/" + experience_delete_id + '/delete';
        $.ajax({
            url: target,
            beforeSend: function () {
                $('.experience-ok').text('{{trans('file.Deleting...')}}');
            },
            success: function (data) {
                setTimeout(function () {
                    $('.confirmModal').modal('hide');
                    $('#work_experience-table').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });
