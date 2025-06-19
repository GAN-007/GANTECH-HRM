$('#employee_award-table').DataTable().clear().destroy();


        let table_table = $('#employee_award-table').DataTable({
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
                url: "{{ route('employee_award.index',$employee->id) }}",
            },

            columns: [
                {
                    data: 'awardType',
                    name: 'awardType',
                },
                {
                    data: null,
                    render: function (data) {
                        return  "<b><i>Info:</i></b>" + data.award_information+ "<br><b><i>Cash:</i></b>" + data.cash;

                    }

                },
                {
                    data: 'gift',
                    name: 'gift',
                },
                {
                    data: 'award_date',
                    name: 'award_date',

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

$(document).on('click', '.show_award', function () {

    let id = $(this).attr('id');

    let target = '{{route('employee_award.details')}}/' + id;

    $.ajax({
        url: target,
        dataType: "json",
        success: function (result) {

            $('#award_award_information_id').html(result.data.award_information);
            $('#award_company_id_show').html(result.company_name);
            $('#award_employee_id_show').html(result.employee_name);
            $('#award_department_id_show').html(result.department);
            $('#award_award_type_id_show').html(result.award_name);
            $('#award_award_date_id').html(result.data.award_date);
$('#award_gift_id').html(result.data.gift);
$('#award_cash_id').html(result.data.cash);
$('#award_award_photo_id').html("<img src={{ URL::to('/public') }}/uploads/award_photos/" + result.data.award_photo +" width='70'  class='img-thumbnail' />");
            $('#award_award_photo_id').append("<input type='hidden'  name='hidden_image' value='"+result.data.award_photo+"'  />");


            $('#employee_award_modal').modal('show');
            $('.modal-title').text("{{__('Award Info')}}");
        }
    });
});
