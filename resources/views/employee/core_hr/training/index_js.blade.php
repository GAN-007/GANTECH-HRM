
    $('#employee_training-table').DataTable().clear().destroy();
    var date = $('.date');
    date.datepicker({
        format: '{{ env('Date_Format_JS')}}',
        autoclose: true,
        todayHighlight: true
    });

    let table_table = $('#employee_training-table').DataTable({
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
            url: "{{ route('employee_training.index',$employee->id) }}",
        },

    columns: [
    {
    data: 'TrainingType',
    name: 'TrainingType',
    },
    {
    data: 'trainer',
    name: 'trainer',
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

    $(document).on('click', '.show_training', function () {

        let id = $(this).attr('id');

        let target = '{{route('employee_training.details')}}/' + id;

        $.ajax({
            url: target,
            dataType: "json",
            success: function (result) {

    $('#training_training_type_show').html(result.TrainingType_name);
    $('#training_company_id_show').html(result.company_name);
    $('#training_employee_id_show').html(result.employee_name);
    $('#training_description_show').html(result.data.description);
    $('#training_start_date_show').html(result.start_date_name);
    $('#training_end_date_show').html(result.end_date_name);
    $('#training_training_cost_show').html(result.data.training_cost);
    $('#training_trainer_id_show').html(result.trainer_name);



    $('#employee_training_model').modal('show');
                $('.modal-title').text("{{__('Travel Info')}}");
            }
        });
    });
