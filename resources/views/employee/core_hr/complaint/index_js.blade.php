    $('#employee_complaint-table').DataTable().clear().destroy();


    let table_table = $('#employee_complaint-table').DataTable({
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
            url: "{{ route('employee_complaint.index',$employee->id) }}",
        },
        columns: [

            {
                data: 'complaint_from',
                name: 'complaint_from',
            },
            {
                data: 'complaint_against',
                name: 'complaint_against',
            },
            {
                data: 'complaint_title',
                name: 'complaint_title',

            },
            {
                data: 'complaint_date',
                name: 'complaint_date',
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

    $(document).on('click', '.show_complaint', function () {

        let id = $(this).attr('id');

        let target = '{{route('employee_complaint.details')}}/' + id;

        $.ajax({
            url: target,
            dataType: "json",
            success: function (result) {

                $('#complaint_description_id').html(result.data.description);
                $('#complaint_company_id_show').html(result.company_name);
                $('#complaint_complaint_title_id').html(result.data.complaint_title);
                $('#complaint_complaint_from_id_show').html(result.complaint_from);
                $('#complaint_complaint_against_id_show').html(result.complaint_against);
                $('#complaint_complaint_date_id').html(result.data.complaint_date);

                $('#employee_complaint_modal').modal('show');
                $('.modal-title').text("{{__('Complaint Info')}}");
            }
        });
    });
