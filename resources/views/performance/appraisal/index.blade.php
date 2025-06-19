@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>

    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">@lang('file.Performance Appraisal')</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i>{{__('file.Add New')}}</button>
        <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i>{{__('file.Bulk Delete')}}</button>
    </div>

    <div class="table-responsive">
        <table id="appraisalTable" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Employee')}}</th>
                    <th>{{trans('file.Department')}}</th>
                    <th>{{trans('file.Designation')}}</th>
                    <th>@lang('file.Appraisal Date')</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
</section>


@include('performance.appraisal.create-modal')
@include('performance.appraisal.edit-modal')
@include('performance.indicator.delete-modal')
@include('performance.goal-type.delete-checkbox-confirm-modal')



@endsection


@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#appraisalTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('performance.appraisal.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'company_name', name: 'company_name'},
                {data: 'employee_name', name: 'employee_name'},
                {data: 'department_name', name: 'department_name'},
                {data: 'designation_name', name: 'designation_name'},
                {data: 'date', name: 'date'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ],

            //----- Start Checkbox ----
            'columnDefs': [
                {
                    "orderable": false,
                    'targets': [0]
                },
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" id="checkbox"><label></label></div>'
                    },
                    'render': function (data, type, row, meta) {
                        if (type == 'display') {
                            data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                }
            ],
            'select': {style: 'multi', selector: 'td:first-child'},
            'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
            //------ End Checkbox ------


            "order": [],
            'language': {
                'lengthMenu': '_MENU_ {{__("records per page")}}',
                "info": '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                "search": '{{trans("file.Search")}}',
                'paginate': {
                    'previous': '{{trans("file.Previous")}}',
                    'next': '{{trans("file.Next")}}'
                }
            },

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
            ]
        });

    // });

        //after selecting Company then Designation will be loaded
        $('#companyId').change(function() {
            var companyId = $(this).val();
            if (companyId){
                $.get("{{route('performance.appraisal.get-employee')}}",{company_id:companyId}, function (data){
                    // $('#designationId').empty().html(data);

                    let all_employees = '';
                    $.each(data.employees, function (index, value) {
                        all_employees += '<option value=' + value['id'] + '>' + value['first_name'] + ' ' + value['last_name'] + '</option>';
                    });
                    $('#employeeId').selectpicker('refresh');
                    $('#employeeId').empty().append(all_employees);
                    $('#employeeId').selectpicker('refresh');
                });
            }else{
                $('#employeeId').empty().html('<option>--Select --</option>');
            }
        });


        //----------Insert Data----------------------
        $("#save-button").on("click",function(e){
            e.preventDefault();

            $.ajax({
                url: "{{route('performance.appraisal.store')}}",
                type: "POST",
                data: $('#submitForm').serialize(),
                success: function(data){
                    console.log(data);
                    if (data.errors) {
                        $("#alertMessage").addClass('bg-danger text-center text-light p-1').html(data.errors) //Check in create modal
                    }
                    else if(data.success){
                        table.draw();
                        $('#submitForm')[0].reset();
                        $('select').selectpicker('refresh');
                        $("#createModalForm").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                        $("#alertMessage").removeClass('bg-danger text-center text-light p-1');
                    }
                }
            });
        });

        // --------------------- Edit ------------------
        $(document).on("click",".edit",function(e){
            e.preventDefault();
            // $('#EditformModal').modal('show');
            var appraisalId = $(this).data("id");
            var element = this;
            console.log(appraisalId)

            $.ajax({
                url: "{{route('performance.appraisal.edit')}}",
                type: "GET",
                data: {id:appraisalId},
                success: function(data){
                    console.log(data)
                    $('#appraisalIdEdit').val(data.appraisal.id);
                    $('#companyIdEdit').selectpicker('val', data.appraisal.company_id);

                    let all_employees = '';
                    $.each(data.employees, function (index, value) {
                        all_employees += '<option value=' + value['id'] + '>' + value['first_name'] + value['last_name'] + '</option>';
                    });
                    $('#employeeIdEdit').empty().append(all_employees);
                    $('#employeeIdEdit').selectpicker('refresh');
                    $('#employeeIdEdit').selectpicker('val', data.appraisal.employee_id);
                    $('#employeeIdEdit').selectpicker('refresh');


                    $('#dateEdit').val(data.appraisal.date);
                    $('#customerExperienceEdit').selectpicker('val', data.appraisal.customer_experience);
                    $('#marketingEdit').selectpicker('val', data.appraisal.marketing);
                    $('#administrationEdit').selectpicker('val', data.appraisal.administration);
                    $('#professionalismEdit').selectpicker('val', data.appraisal.professionalism);
                    $('#integrityEdit').selectpicker('val', data.appraisal.integrity);
                    $('#attendanceEdit').selectpicker('val', data.appraisal.attendance);
                    // $('#remarksEdit').selectpicker('val', data.appraisal.remarks);
                    $('#remarksEdit').val(data.appraisal.remarks);
                    $('#EditformModal').modal('show');
                }
            });
        });


        // --------------------- EDit ------------------



        // ---------- Update by Id----------
        $("#update-button").on("click",function(e){
            e.preventDefault();

            $.ajax({
                url: "{{route('performance.appraisal.update')}}",
                type: "POST",
                data: $('#updatetForm').serialize(),
                success: function(data){
                    console.log(data);
                    if(data.success)
                    {
                        table.draw();
                        $('#updatetForm')[0].reset();
                        $('select').selectpicker('refresh');
                        $("#EditformModal").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                    }
                }
            });
        });

        //---------- Delete Data ----------
        $(document).on("click",".delete",function(e){

            $('#confirmDeleteModal').modal('show');
            var appraisalIdDelete = $(this).data("id");
            var element = this;
            // console.log(goalTypeIdDelete);

            $("#deleteSubmit").on("click",function(e){
                $.ajax({
                    url: "{{route('performance.appraisal.delete')}}",
                    type: "GET",
                    data: {appraisal_id:appraisalIdDelete},
                    success: function(data){
                        console.log(data);
                        if(data.success)
                        {
                            table.draw();
                            $("#confirmDeleteModal").modal('hide');
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                        }
                    }
                });
            });
        });

        // Multiple Data Delete using checkbox
        $("#bulk_delete").on("click",function(){
            var allCheckboxId = [];
            let table = $('#appraisalTable').DataTable();
            allCheckboxId = table.rows({selected: true}).ids().toArray();
            console.log(allCheckboxId);


            if(allCheckboxId.length == 0){
                alert("Please Select at least one checkbox.");
            }
            else{
                $('#confirmDeleteCheckboxModal').modal('show');
                $("#deleteCheckboxSubmit").on("click",function(e){
                    $.ajax({
                        url : "{{route('performance.appraisal.delete.checkbox')}}",
                        type : "GET",
                        data : {all_checkbox_id : allCheckboxId},
                        success : function(data){
                            console.log(data);
                            if(data.success)
                            {
                                table.ajax.reload();
                                table.rows('.selected').deselect();
                                $("#confirmDeleteCheckboxModal").modal('hide');
                                $('#success_alert').fadeIn("slow"); //Check in top in this blade
                                $('#success_alert').addClass('alert alert-success').html(data.success);
                                setTimeout(function() {
                                    $('#success_alert').fadeOut("slow");
                                }, 3000);
                            }
                        }
                    });
                });
            }
        });

    });

</script>
@endpush
