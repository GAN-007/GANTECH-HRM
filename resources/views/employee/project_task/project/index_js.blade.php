
    $('#employee_project-table').DataTable().clear().destroy();

    let table_table = $('#employee_project-table').DataTable({
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
            url: "{{ route('employee_project.index',$employee->id) }}",
        },

        columns: [
            {
                data: 'summary',
                name: 'summary'

            },
            {
                data: 'project_priority',
                name: 'project_priority',
            },
            {
                data: 'assigned_employee',
                name: 'assigned_employee',
                render: function (data) {
                    return   data.join("<br>");
                }
            },
            {
                data: 'client',
                name: 'client',
            },
            {
                data: 'end_date',
                name: 'end_date',

            },
            {
                data: 'project_progress',
                name: 'project_progress',
                render: function (data)
                {
                    if (data !== null) {
                        return data + '% completed'
                    }
                    else {
                        return 0 + '% completed'
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
                'targets': [0, 6],
            },
        ],


        'select': {style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
    new $.fn.dataTable.FixedHeader(table_table);

