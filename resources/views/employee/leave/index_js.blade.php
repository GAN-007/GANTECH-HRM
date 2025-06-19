$('#employee_leave-table').DataTable().clear().destroy();
var date = $('.date');
date.datepicker({
format: '{{ env('Date_Format_JS')}}',
autoclose: true,
todayHighlight: true
});







        let table_table = $('#employee_leave-table').DataTable({
            responsive: true,
            fixedHeader: {
                header: true,
                footer: true
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('employee_leave.index',$employee->id) }}",
            },

            columns: [
                {
                    data: null,
                    render: function (data) {
return data.leave_type + "<br><td><div class = 'badge badge-success'>"+data.status+"</div></td><br>" + "<b><i>Reason:</i></b>" + data.leave_reason;

                    }

                },

                {
                    data: 'department',
                    name: 'department',

                },

                {
                    data: null,
                    render: function ( data) {

                        return data.start_date + ' to ' + data.end_date
                            + "<br>" +' Total '+ data.total_days + ' Days ' ;


                    }

                },
                {
                    data: 'created_at',
                    name: 'created_at',

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

$(document).on('click', '.show_leave', function () {

    let id = $(this).attr('id');

    let target = '{{route('employee_leave.details')}}/' + id;

    $.ajax({
        url: target,
        dataType: "json",
        success: function (result) {

            $('#leave_leave_type_id').html(result.leave_type_name);
            $('#leave_company_id_show').html(result.company_name);
$('#leave_employee_id_show').html(result.employee_name);

            $('#leave_department_id_show').html(result.department);
            $('#leave_start_date_id').html(result.start_date_name);
            $('#leave_end_date_id').html(result.end_date_name);
            $('#leave_applied_date_id').html(result.data.created_at);
            $('#leave_total_days_id').html(result.data.total_days);
            $('#leave_status_id').html(result.data.status);
            $('#leave_leave_reason_id').html(result.data.leave_reason);
            $('#leave_remarks_id').html(result.data.remarks);

            if (result.data.is_half==1)
                $('#leave_is_half_id').html('Yes');
            else{
                $('#leave_is_half_id').html('No');
            }
            if (result.data.is_notify==1)
                $('#leave_is_notify_id').html('On');
            else{
                $('#leave_is_notify_id').html('Off');
            }





            $('#leave_model').modal('show');
            $('.modal-title').text("{{__('Leave Info')}}");
        }
    });
});


