@extends('layout.main')
@section('content')


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>


        <div class="container-fluid mb-3">
            @can('store-details-employee')
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> {{__('Add Employee')}}</button>
            @endcan
            @can('modify-details-employee')
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> {{__('Bulk delete')}}</button>
            @endcan
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-filter" aria-hidden="true"></i> Filter
            </button>
        </div>
        <div class="col-12">
            <!-- Filtering -->
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <form action="" method="GET" id="filter_form">
                        <div class="row">
                            <!-- Company -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-bold"><strong>{{trans('file.Company')}}</strong></label>
                                    <select name="company_id" id="company_id_filter"
                                            class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="contains"
                                            data-shift_name="shift_name" data-dependent="department_name"
                                            title="{{__('Selecting',['key'=>trans('file.Company')])}}...">
                                            <option value=""></option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--/ Company-->

                            <!-- Department-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-bold"><b>{{trans('file.Department')}}</b></label>
                                    <select name="department_id" id="department_id_filter"
                                            class="selectpicker form-control designationFilter"
                                            data-live-search="true" data-live-search-style="contains"
                                            data-designation_name="designation_name"
                                            title="{{__('Selecting',['key'=>trans('file.Department')])}}...">
                                    </select>
                                </div>
                            </div>
                            <!--/ Department-->

                            <!-- Designation -->
                            <div class="col-md-3 form-group">
                                <label class="text-bold"><b>{{trans('file.Designation')}}</b></label>
                                <select name="designation_id" id="designation_id_filter" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Designation')])}}...">
                                </select>
                            </div>
                            <!--/ Designation -->

                            <!-- Office Shift -->
                            <div class="col-md-2 form-group">
                                <label class="text-bold"><b>{{__('Office Shift')}}</b></label>
                                <select name="office_shift_id" id="office_shift_id_filter" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting Office Shift')}}...">
                                </select>
                            </div>
                            <!--/ Office Shift -->

                            <div class="col-md-1">
                                <label class="text-bold"></label><br>
                                <button type="button" class="btn btn-dark" id="filterSubmit">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i> &nbsp; GET
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Filtering -->
        </div>


        <div class="table-responsive">
            <table id="employee-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Employee')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Contact')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Employee')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{__('First Name')}} <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" placeholder="{{__('First Name')}}"
                                       required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{__('Last Name')}} <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" placeholder="{{__('Last Name')}}"
                                       required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{__('Staff Id')}} <span class="text-danger">*</span></label>
                                <input type="text" name="staff_id" id="staff_id" placeholder="{{__('Staff Id')}}"
                                       required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{trans('file.Email')}}</label>
                                <input type="email" name="email" id="email" placeholder="example@example.com"
                                       class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{trans('file.Phone')}} <span class="text-danger">*</span></label>
                                <input type="text" name="contact_no" id="contact_no"
                                       placeholder="{{trans('file.Phone')}}" required
                                       class="form-control" value="{{ old('contact_no') }}">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{__('Date Of Birth')}} <span class="text-danger">*</span></label>
                                <input type="text" name="date_of_birth" id="date_of_birth" required autocomplete="off"
                                       class="form-control date" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{trans('file.Gender')}}</label>
                                <select name="gender" id="gender" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Gender')])}}...">
                                    <option value="Male">{{trans('file.Male')}}</option>
                                    <option value="Female">{{trans('file.Female')}}</option>
                                    <option value="Other">{{trans('file.Other')}}</option>
                                </select>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">{{trans('file.Company')}} <span class="text-danger">*</span></label>
                                    <select name="company_id" id="company_id" required
                                            class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="contains"
                                            data-shift_name="shift_name" data-dependent="department_name"
                                            title="{{__('Selecting',['key'=>trans('file.Company')])}}...">
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->company_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-bold">{{trans('file.Department')}} <span class="text-danger">*</span></label>
                                    <select name="department_id" id="department_id" required
                                            class="selectpicker form-control designation"
                                            data-live-search="true" data-live-search-style="contains"
                                            data-designation_name="designation_name"
                                            title="{{__('Selecting',['key'=>trans('file.Department')])}}...">
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{trans('file.Designation')}} <span class="text-danger">*</span></label>
                                <select name="designation_id" id="designation_id" required class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Designation')])}}...">
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{trans('file.Office_Shift')}} <span class="text-danger">*</span></label>
                                <select name="office_shift_id" id="office_shift_id" required class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Office_Shift')])}}...">
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{trans('file.Username')}} <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username"
                                       placeholder="{{__('Unique Value',['key'=>trans('file.Username')])}}"
                                       required class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{trans('file.Role')}} <span class="text-danger">*</span></label>
                                <select name="role_users_id" id="role_users_id" required
                                        class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Role')])}}...">
                                    @foreach ($roles as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                    {{-- <option value="1">Admin</option>
                                    <option value="2">Employee</option> --}}
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{trans('file.Password')}} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                           placeholder="{{trans('file.Password')}}"
                                           required class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{__('Confirm Password')}} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input id="confirm_pass" type="password"
                                           class="form-control "
                                           name="password_confirmation" placeholder="{{__('Re-type Password')}}"
                                           required autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{__('Attendance Type')}} <span class="text-danger">*</span></label>
                                <select name="attendance_type" id="attendance_type" required class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="contains" title="{{__('Select Attendance Type...')}}">
                                    <option value="general">{{__('General')}}</option>
                                    <option value="ip_based">{{__('IP Based')}}</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="text-bold">{{__('Date Of Joining')}} <span class="text-danger">*</span></label>
                                <input type="text" name="joining_date" id="joining_date" class="form-control date">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="profile_photo" class=""><strong>{{ __('Image') }}</strong></label>
                                <input type="file" id="profile_photo"
                                       class="form-control @error('photo') is-invalid @enderror"
                                       name="profile_photo" placeholder="{{__('Upload',['key'=>trans('file.Photo')])}}">
                            </div>

                            {{-- <div class="col-md-6 form-group"  id="ipField"></div> --}}


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning w-100" value="{{trans('file.Add')}}" />
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                    <button type="button" class="employee-close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button"
                            class="btn btn-danger">{{trans('file.OK')}}</button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">

    $(document).ready(function () {

        if (window.location.href.indexOf('#formModal') != -1) {
            $('#formModal').modal('show');
        }

        var date = $('.date');
        date.datepicker({
            format: '{{ env('Date_Format_JS')}}',
            autoclose: true,
            todayHighlight: true
        });

        var table_table = $('#employee-table').DataTable({
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
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('employees.index') }}",
                type: 'GET',
                data: function (d) {
                    d.company_id     = $("#company_id_filter").val();
                    d.department_id  = $('#department_id_filter').val();
                    d.designation_id = $('#designation_id_filter').val();
                    d.office_shift_id = $('#office_shift_id_filter').val();
                }
            },

            columns: [

                {
                    data: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',

                },
                {
                    data: 'company',
                    name: 'company',
                },
                {
                    data: 'contacts',
                    name: 'contacts',
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
                    'targets': [0,4],
                    "className": "text-left"
                },
                {
                    'render': function (data, type, row, meta) {
                        if (type == 'display') {
                            data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label class="text-bold"></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label class="text-bold"></label></div>'
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
                // {
                //     extend: 'csv',
                //     text: '<i title="export for device" class="fa fa-tablet"></i>',
                //     className: 'export-for-device',
                //     exportOptions: {
                //         columns: [1,2],
                //         rows: ':visible',
                //         format: {
                //             body: function ( data, row, column, node ) {
                //                 if (column === 0) {
                //                     var id = data.match(/<span>Staff Id: (.*?)<\/span>/)[1];
                //                     name = data.match(/<[a][^>]*>(.+?)<\/[a]>/)[1];
                //                     return id;
                //                 }
                //                 else {
                //                     return name;
                //                 }
                //             }
                //         }
                //     },
                //     customize: function (csv) {
                //         var csvRows = csv.split('\n');
                //         csvRows[0] = csvRows[0].replace(['"Employee"', '"Company"'], ['"Staff Id"','"Name"']);
                //         return csvRows.join('\n');
                //     }
                // },
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


    //-------------- Filter -----------------------

    $('#filterSubmit').on("click",function(e){
        $('#employee-table').DataTable().draw(true);
        //$('#filter_form')[0].reset();
        //$('select').selectpicker('refresh');
    });
    //--------------/ Filter ----------------------


    $('#create_record').click(function () {

        $('.modal-title').text("Add Employee");
        $('#action_button').val('{{trans('file.Add')}}');
        $('#action').val('{{trans('file.Add')}}');
        $('#formModal').modal('show');
    });

    $('#sample_form').on('submit', function (event) {
        event.preventDefault();
        // var attendance_type = $("#attendance_type").val();
        // console.log(attendance_type);

        $.ajax({
            url: "{{ route('employees.store') }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                console.log(data);
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
                    $('#sample_form')[0].reset();
                    $('select').selectpicker('refresh');
                    $('.date').datepicker('update');
                    $('#employee-table').DataTable().ajax.reload();
                }
                $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            }
        });
    });


    let employee_delete_id;

    $(document).on('click', '.delete', function () {
        employee_delete_id = $(this).attr('id');
        $('#confirmModal').modal('show');
        $('.modal-title').text('{{__('DELETE Record')}}');
        $('#ok_button').text('{{trans('file.OK')}}');

    });


    $(document).on('click', '#bulk_delete', function () {

        var id = [];
        let table = $('#employee-table').DataTable();
        id = table.rows({selected: true}).ids().toArray();
        if (id.length > 0) {
            if (confirm('{{__('Delete Selection',['key'=>trans('file.Employee')])}}')) {
                $.ajax({
                    url: '{{route('mass_delete_employees')}}',
                    method: 'POST',
                    data: {
                        employeeIdArray: id
                    },
                    success: function (data) {
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                        }
                        if (data.error) {
                            html = '<div class="alert alert-danger">' + data.error + '</div>';
                        }
                        table.ajax.reload();
                        table.rows('.selected').deselect();
                        $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);

                    }

                });
            }
        } else {
            alert('{{__('Please select atleast one checkbox')}}');
        }
    });


    $('#close').click(function () {
        $('#sample_form')[0].reset();
        $('select').selectpicker('refresh');
        $('.date').datepicker('update');
        $('#employee-table').DataTable().ajax.reload();
    });

    $('#ok_button').click(function () {
        let target = "{{ route('employees.index') }}/" + employee_delete_id + '/delete';
        $.ajax({
            url: target,
            beforeSend: function () {
                $('#ok_button').text('{{trans('file.Deleting...')}}');
            },
            success: function (data) {
                if (data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                }
                if (data.error) {
                    html = '<div class="alert alert-danger">' + data.error + '</div>';
                }
                setTimeout(function () {
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    $('#confirmModal').modal('hide');
                    $('#employee-table').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });




    $('#confirm_pass').on('input', function () {

        if ($('input[name="password"]').val() != $('input[name="password_confirmation"]').val())
            $("#divCheckPasswordMatch").html('{{__('Password does not match! please type again')}}');
        else
            $("#divCheckPasswordMatch").html('{{__('Password matches!')}}');

    });


    $('.dynamic').change(function () {
        if ($(this).val() !== '') {
            let value = $(this).val();
            let dependent = $(this).data('dependent');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_department') }}",
                method: "POST",
                data: {value: value, _token: _token, dependent: dependent},
                success: function (result) {

                    $('select').selectpicker("destroy");
                    $('#department_id').html(result);
                    $('select').selectpicker();

                }
            });
        }
    });


    $('.dynamic').change(function () {
        if ($(this).val() !== '') {
            let value = $(this).val();
            let dependent = $(this).data('shift_name');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_office_shifts') }}",
                method: "POST",
                data: {value: value, _token: _token, dependent: dependent},
                success: function (result) {
                    $('select').selectpicker("destroy");
                    $('#office_shift_id').html(result);
                    $('select').selectpicker();
                }
            });
        }
    });

    $('.designation').change(function () {
        if ($(this).val() !== '') {
            let value = $(this).val();
            let designation_name = $(this).data('designation_name');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_designation_department') }}",
                method: "POST",
                data: {value: value, _token: _token, designation_name: designation_name},
                success: function (result) {
                    $('select').selectpicker("destroy");
                    $('#designation_id').html(result);
                    $('select').selectpicker();

                }
            });
        }
    });


    // Login Type Change
    // $('#login_type').change(function() {
    //     var login_type = $('#login_type').val();
    //     if (login_type=='ip') {
    //         data = '<label class="text-bold">{{__("IP Address")}} <span class="text-danger">*</span></label>';
    //         data += '<input type="text" name="ip_address" id="ip_address" placeholder="Type IP Address" required class="form-control">';
    //         $('#ipField').html(data)
    //     }else{
    //         $('#ipField').empty();
    //     }
    // });



    //--------  Filter  ---------

    // Company--> Department
    $('.dynamic').change(function () {
        if ($(this).val() !== '') {
            let value = $('#company_id_filter').val();
            let dependent = $(this).data('dependent');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_department') }}",
                method: "POST",
                data: {value: value, _token: _token, dependent: dependent},
                success: function (result) {

                    $('select').selectpicker("destroy");
                    $('#department_id_filter').html(result);
                    $('select').selectpicker();

                }
            });
        }
    });

    //Department--> Designation
    $('.designationFilter').change(function () {
        if ($(this).val() !== '') {
            // let value = $(this).val();
            // let value = $('#company_id_filter').val();
            let value = $('#department_id_filter').val();
            let designation_name = $(this).data('designation_name');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_designation_department') }}",
                method: "POST",
                data: {value: value, _token: _token, designation_name: designation_name},
                success: function (result) {
                    $('select').selectpicker("destroy");
                    $('#designation_id_filter').html(result);
                    $('select').selectpicker();

                }
            });
        }
    });

    //Company--> Office Shift
    $('.dynamic').change(function () {
        if ($(this).val() !== '') {
            // let value = $(this).val();
            let value = $('#company_id_filter').val();
            let dependent = $(this).data('shift_name');
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamic_office_shifts') }}",
                method: "POST",
                data: {value: value, _token: _token, dependent: dependent},
                success: function (result) {
                    $('select').selectpicker("destroy");
                    $('#office_shift_id_filter').html(result);
                    $('select').selectpicker();
                }
            });
        }
    });

</script>
@endpush
