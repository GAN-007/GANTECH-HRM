@extends('layout.main')

@section('content')

    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="container-fluid mb-3">
            {{-- @can('set-permission')
                <a href="{{route('roles.index')}}" class="btn btn-info mr-1"><i
                            class="fa fa-puzzle-piece"></i> {{trans('file.Role')}} </a>
            @endcan --}}
            {{-- @can('assign-role')
                <form id="mass_role_assign" class="d-inline">
                    <select id="mass_select" class="selectpicker" data-style="btn-primary" name="mass_role"
                            title="{{__('Selecting',['key'=>trans('file.Role')])}}...">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </form>
            @endcan --}}
            @can('view-role')
                <a href="{{route('roles.index')}}" class="btn btn-info mr-1"><i
                            class="fa fa-puzzle-piece"></i> {{trans('file.Role')}} </a>
            @endcan
            @can('role-access-user')
                <form id="mass_role_assign" class="d-inline">
                    <select id="mass_select" class="selectpicker" data-style="btn-primary" name="mass_role"
                            title="{{__('Selecting',['key'=>trans('file.Role')])}}...">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </form>
            @endcan

        </div>


        <div class="table-responsive">
            <table id="user-table" class="table table-striped">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{__('Image')}}</th>
                    <th>{{trans('file.Username')}}</th>
                    <th>{{__('Permission Role')}}</th>
                    <th class="not-exported">{{__('Assign Role')}}</th>
                </tr>
                </thead>
            </table>

        </div>
    </section>


@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function () {


            let table_table = $('#user-table').DataTable({
                initComplete: function () {
                    this.api().columns([2, 4]).every(function () {
                        let column = this;
                        let select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                let val = $.fn.dataTable.util.escapeRegex(
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
                    url: "{{ route('user-roles') }}",

                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'profile_photo',
                        name: 'profile_photo',
                        render: function (data) {
                            if (data) {
                                return "<img src={{ URL::to('/public') }}/uploads/profile_photos/" + data + " width='80' height='80' />";
                            } else {
                                return "<img src={{ URL::to('/public') }}/logo/avatar.jpg " + " width='80' height='80' />";
                            }
                        },
                        orderable: false

                    },
                    {
                        data: 'username',
                        name: 'username',

                    },
                    {
                        data: 'role_name',
                        name: 'role_name',

                    },
                    // {
                    //     data: 'assign_role',
                    //     name: 'assign_role',
                    //     render: function (data,type,row) {

                    //         if (row.role_name == 'admin' ) {
                    //             return 'Admin role can not be changed';
                    //         }
                    //         else if (row.role_name == 'client') {
                    //             return 'Client role can not be changed';
                    //         }
                    //         else {

                    //             return '@can('assign-role')<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assign Role &nbsp;</button><div class="dropdown-menu">@foreach($roles as $role)<li data-employee_id="'+row.id+'" data-role_id="{{$role->id}}" class="assign-role">{{$role->name}}</li>@endforeach</div></div>@endcan';

                    //         }

                    //     }
                    // }
                    {
                        data: 'role-access-user',
                        name: 'role-access-user',
                        render: function (data,type,row) {

                            if (row.role_name == 'admin' ) {
                                return 'Admin role can not be changed';
                            }
                            else if (row.role_name == 'client') {
                                return 'Client role can not be changed';
                            }
                            else {
                                // return '@can('assign-role')<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assign Role &nbsp;</button><div class="dropdown-menu">@foreach($roles as $role)<li data-employee_id="'+row.id+'" data-role_id="{{$role->id}}" class="assign-role">{{$role->name}}</li>@endforeach</div></div>@endcan';
                                return '@can('role-access-user')<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assign Role &nbsp;</button><div class="dropdown-menu">@foreach($roles as $role)<li data-employee_id="'+row.id+'" data-role_id="{{$role->id}}" class="assign-role">{{$role->name}}</li>@endforeach</div></div>@endcan';

                            }

                        }
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
                        'targets': [0, 4]
                    },
                    {
                        'render': function (data, type, row, meta) {
                            if (type == 'display') {
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
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
            new $.fn.dataTable.FixedHeader(table_table);
        });


        $('#series').on('change', function () {
           let formData = $('#role_assign').serialize();
        });

        $('#mass_select').on('change', function () {
            let table = $('#user-table').DataTable();
            let massFormData = $('[name=mass_role]').val();

            let id = [];

            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('{{__('Are you sure you want to assign this role to the selected users?')}}')) {
                    let target = "{{route('mass_assign_role')}}";

                    $.ajax({
                        url: target,
                        method: "POST",
                        data: {
                            userIdArray: id,
                            mass_role: massFormData
                        },
                        success: function (data) {
                            let html = '';
                            if (data.error) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';

                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#user-table').DataTable().ajax.reload();
                            }
                            $('#general_result').html(html);
                        }
                    });
                }
            } else {
                alert('{{__('No user is selected')}}')
            }
        });


        $('body').on('click', '.assign-role', function () {

            let role_id = $(this).attr('data-role_id');
            let employee_id = $(this).attr('data-employee_id');


            let target = "{{ url('/assign_role')}}/"+ employee_id;
            $.ajax({
                url: target,
                method: "POST",
                data: {
                    roleId: role_id,
                },

                success: function (data) {
                    let html = '';
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';

                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function () {
                            $('#user-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                    $('#general_result').html(html).slideDown(300).delay(3000).slideUp(300);
                }
            });
        });

        $('.close').on('click', function () {
            $('#role_assign')[0].reset();
        });

        $('#cancel').on('click', function () {
            $('#role_assign')[0].reset();
        });
    })(jQuery);
</script>
@endpush






