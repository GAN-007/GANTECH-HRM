@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>

    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">@lang('file.Performance Indicator')</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i>{{__('file.Add New Indicator')}}</button>
        <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i>{{__('file.Bulk Delete')}}</button>
    </div>

    <div class="table-responsive">
        <table id="indicatorTable" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Designation')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Department')}}</th>
                    <th>@lang('file.Added By')</th>
                    <th>@lang('file.Created At')</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
</section>

@include('performance.indicator.create-modal')
@include('performance.indicator.edit-modal')
@include('performance.indicator.delete-modal')
@include('performance.indicator.delete-checkbox-confirm-modal')






@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var table = $('#indicatorTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('performance.indicator.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'designation_name', name: 'designation_name'},
                {data: 'company_name',     name: 'company_name'},
                {data: 'department_name',  name: 'department_name'},
                {data: 'added_by',    name: 'added_by'},
                {data: 'created_at',  name: 'created_at'},
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


        //after selecting Company then Designation will be loaded
        $('#companyId').change(function() {
            var companyId = $(this).val();
            if (companyId){
                $.get("{{route('performance.indicator.get-designation-by-company')}}",{company_id:companyId}, function (data) {
                    // $('#designationId').empty().html(data);

                    let all_designations = '';
                    $.each(data.designations, function (index, value) {
                        all_designations += '<option value=' + value['id'] + '>' + value['designation_name'] + '</option>';
                    });
                    $('#designationId').selectpicker('refresh');
                    $('#designationId').empty().append(all_designations);
                    $('#designationId').selectpicker('refresh');
                });
            }else{
                $('#designationId').empty().html('<option>--Select --</option>');
            }
        });

        //----------Insert Data----------------------
        $("#save-button").on("click",function(e){
            e.preventDefault();
            var companyId = $("#companyId").val();

            $.ajax({
                url: "{{route('performance.indicator.store')}}",
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
                        ("#alertMessage").removeClass('bg-danger text-center text-light p-1');
                    }
                }
            });
        });


        //---------- Edit Data ----------

        $(document).on("click",".edit",function(e){
            e.preventDefault();
            var indicatorId = $(this).data("id");
            var element = this;

            $.ajax({
                url: "{{route('performance.indicator.edit')}}",
                type: "GET",
                data: {id:indicatorId},
                success: function(data){
                    console.log(data)
                    $('#indicatorHiddenIdEdit').val(data.indicator.id);
                    $('#companyIdEdit').selectpicker('val', data.indicator.company_id);

                    let all_designations = '';
                    $.each(data.designations, function (index, value) {
                        all_designations += '<option value=' + value['id'] + '>' + value['designation_name'] + '</option>';
                    });
                    $('#designationIdEdit').empty().append(all_designations);
                    $('#designationIdEdit').selectpicker('refresh');
                    $('#designationIdEdit').selectpicker('val', data.indicator.designation_id);
                    $('#designationIdEdit').selectpicker('refresh');


                    $('#customerExperienceEdit').selectpicker('val', data.indicator.customer_experience);
                    $('#marketingEdit').selectpicker('val', data.indicator.marketing);
                    $('#administratorEdit').selectpicker('val', data.indicator.administrator);
                    $('#professionalismEdit').selectpicker('val', data.indicator.professionalism);
                    $('#integrityEdit').selectpicker('val', data.indicator.integrity);
                    $('#attendanceEdit').selectpicker('val', data.indicator.attendance);
                    $('#EditformModal').modal('show');
                }
            });
        });


        // ---------- Update by Id----------
        $("#update-button").on("click",function(e){
            e.preventDefault();

            $.ajax({
                url: "{{route('performance.indicator.update')}}",
                type: "POST",
                data: $('#updatetForm').serialize(),
                success: function(data){
                    console.log(data);

                    // if (data.errors) {
                    //     $(".goal_type_edit").addClass('is-invalid');
                    //     $("#error_edit_message").html(data.errors) //Check in edit modal
                    // }
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
            var indicatorIdDelete = $(this).data("id");
            var element = this;
            // console.log(goalTypeIdDelete);

            $("#deleteSubmit").on("click",function(e){
                $.ajax({
                    url: "{{route('performance.indicator.delete')}}",
                    type: "GET",
                    data: {indicator_id:indicatorIdDelete},
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


        //


        // Multiple Data Delete using checkbox
        $("#bulk_delete").on("click",function(){
            var allCheckboxId = [];
            let table = $('#indicatorTable').DataTable();
            allCheckboxId = table.rows({selected: true}).ids().toArray();
            console.log(allCheckboxId);

            if(allCheckboxId.length == 0){
                alert("Please Select at least one checkbox.");
            }
            else{
                $('#confirmDeleteCheckboxModal').modal('show');
                $("#deleteCheckboxSubmit").on("click",function(e){
                    $.ajax({
                        url : "{{route('performance.indicator.delete.checkbox')}}",
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
