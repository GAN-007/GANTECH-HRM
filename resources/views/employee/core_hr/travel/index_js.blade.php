    $('#employee_travel-table').DataTable().clear().destroy();
    var date = $('.date');
    date.datepicker({
        format: '{{ env('Date_Format_JS')}}',
        autoclose: true,
        todayHighlight: true
    });

    let table_table = $('#employee_travel-table').DataTable({
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
            url: "{{ route('employee_travel.index',$employee->id) }}",
        },


    columns: [
    {
    data: null,
    render: function (data) {
    return data.purpose_of_visit + "<br><br><td><b><i>{{__('Expected Budget :')}}</i></b>"+ data.expected_budget + "</td><br>" +
    "<td><b><i>{{__('Actual Budget :')}}</i></b>" + data.actual_budget + "</td>"
    + "<br><td><div class = 'badge badge-success'>" + data.status + "</div></td><br>";
    }
    },
    {
    data: 'place_of_visit',
    name: 'place_of_visit',
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

    $(document).on('click', '.show_travel', function () {

        let id = $(this).attr('id');

        let target = '{{route('employee_travel.details')}}/' + id;

        $.ajax({
            url: target,
            dataType: "json",
            success: function (result) {

                $('#travel_travel_type_show').html(result.TrainingType_name);
                $('#travel_company_id_show').html(result.company_name);
                $('#travel_employee_id_show').html(result.employee_name);
                $('#travel_description_show').html(result.data.description);
                $('#travel_start_date_show').html(result.data.start_date);
                $('#travel_end_date_show').html(result.data.end_date);
    $('#travel_purpose_of_visit_show').html(result.data.purpose_of_visit);
    $('#travel_place_of_visit_show').html(result.data.place_of_visit);
    $('#travel_travel_mode_show').html(result.data.travel_mode);
    $('#travel_travel_type_show').html(result.arrangement_name);
    $('#travel_expected_budget_show').html(result.data.expected_budget);
    $('#travel_actual_budget_show').html(result.data.actual_budget);
    $('#travel_status_show').html(result.data.status);

    $('#travel_trainer_id_show').html(result.trainer_name);



                $('#employee_travel_modal').modal('show');
                $('.modal-title').text("{{__('Travel Info')}}");
            }
        });
    });
