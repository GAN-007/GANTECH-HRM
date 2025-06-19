@extends('layout.main')

@section('content')

    <section>

        @include('shared.errors')
        @include('shared.flash_message')

        <div class="table-responsive">
            <table id="user-login-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{__('Image')}}</th>
                    <th>{{trans('file.Username')}}</th>
                    <th>{{__('Last Login Date')}}</th>
                    <th>{{__('Last Login IP')}}</th>
                    <th>{{trans('file.status')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($login_info as $key=>$user)
                    <tr data-id="{{$user->id}}">
                        <td>{{$key}}</td>
                        @if($user->profile_photo)
                            <td><img src="{{url('uploads/profile_photos',$user->profile_photo)}}" height="80"
                                     width="80">
                            </td>
                        @else
                            <td><img src="{{url('logo/avatar.jpg')}}" height="80" width="80">
                            </td>
                        @endif
                        <td>{{ $user->username }}</td>
                        @if($user->last_login_date == null)
                            <td></td>
                        @else
                        <td>{{  $user->last_login_date  }}</td>
                        @endif
                        <td>{{ $user->last_login_ip }}</td>
                        @if($user->is_active)
                            <td>
                                <div class="badge badge-success">{{trans('file.Active')}}</div>
                            </td>
                        @else
                            <td>
                                <div class="badge badge-danger">{{trans('file.Inactive')}}</div>
                            </td>
                        @endif

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>




@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).ready(function(){
            $(".alert").slideDown(300).delay(5000).slideUp(300);
        });

        $("ul#hrm").siblings('a').attr('aria-expanded', 'true');
        $("ul#hrm").addClass("show");
        $("ul#hrm #employee-menu").addClass("active");



        $('#user-login-table').DataTable({
            initComplete: function () {
                this.api().columns([2, 4]).every(function () {
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
                    'targets': [0]
                },
                {
                    'render': function(data, type, row, meta){
                        if(type == 'display'){
                            data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                }
            ],
            'select': {style: 'multi', selector: 'td:first-child'},
            'lengthMenu': [[20, 50,100, -1], [20, 50,100, "All"]],
            dom: '<"row"lfB>rtip',
            buttons: [
                    {
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ],
        });
    })(jQuery);
</script>
@endpush


