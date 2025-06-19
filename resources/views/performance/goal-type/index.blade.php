@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>

    <div class="container-fluid mb-3">

        <h4 class="font-weight-bold mt-3">@lang('file.Goal Type')</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>{{__('file.Add New Type')}}</button>
        <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i>{{__('file.Bulk Delete')}}</button>

    </div>

    <div class="container">
        <div class="table-responsive">
            <table id="goalTypeTable" class="table">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>@lang('file.Type')</th>
                        <th class="not-exported">{{trans('file.action')}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

@include('performance.goal-type.create-modal')
@include('performance.goal-type.edit-modal')
@include('performance.goal-type.delete-confirm-modal')
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


        var table = $('#goalTypeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('performance.goal-type.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'goal_type', name: 'goal_type'},
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


        //----------Insert Data----------------------
        $("#save-button").on("click",function(e){
            e.preventDefault();
            var goalType = $("#goalType").val();

            $.ajax({
                url: "{{route('performance.goal-type.store')}}",
                type: "POST",
                data: {goal_type:goalType},
                success: function(data){
                    // console.log(data);
                    if (data.errors) {
                        $("#goalType").addClass('is-invalid');
                        $("#message").html(data.errors) //Check in create modal
                    }
                    else if(data.success){
                        table.draw();
                        // $('#submit_form').trigger("reset");
                        $('#submit_form')[0].reset();
                        $("#createModal").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                    }
                }
            });
        });


        //---------- Edit Data ----------
        $(document).on("click",".edit",function(e){
            var goalTypeId = $(this).data("id");
            var element = this;
            console.log(goalTypeId)

            $.ajax({
                url: "{{route('performance.goal-type.edit')}}",
                type: "GET",
                data: {goal_type_id:goalTypeId},
                success: function(data){
                    // console.log(data);
                    $('#edit-body').html(data);
                    $('#EditformModal').modal('show');
                }
            });
        });

        //---------- Update by Id----------
        $("#update-button").on("click",function(e){
            e.preventDefault();
            var goalTypeId = $("#goalTypeId").val();
            var goalEditType   = $("#goalEditType").val();
            // console.log(goalTypeId);

            $.ajax({
                url: "{{route('performance.goal-type.update')}}",
                type: "POST",
                data: {goal_type_id:goalTypeId, goal_type:goalEditType},
                success: function(data){
                    console.log(data);

                    if (data.errors) {
                        $(".goal_type_edit").addClass('is-invalid');
                        $("#error_edit_message").html(data.errors) //Check in edit modal
                    }
                    else if(data.success)
                    {
                        table.draw();
                        // $('#submitEditForm').trigger("reset");
                        $('#submitEditForm')[0].reset();
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
            var goalTypeIdDelete = $(this).data("id");
            var element = this;
            // console.log(goalTypeIdDelete);

            $("#deleteSubmit").on("click",function(e){
                $.ajax({
                    url: "{{route('performance.goal-type.delete')}}",
                    type: "GET",
                    data: {goal_type_id:goalTypeIdDelete},
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
            let table = $('#goalTypeTable').DataTable();
            allCheckboxId = table.rows({selected: true}).ids().toArray();
            console.log(allCheckboxId);

            if(allCheckboxId.length == 0){
                alert("Please Select at least one checkbox.");
            }
            else{
                $('#confirmDeleteCheckboxModal').modal('show');
                $("#deleteCheckboxSubmit").on("click",function(e){
                    $.ajax({
                        url : "{{route('performance.goal-type.delete.checkbox')}}",
                        type : "GET",
                        data : {all_checkbox_id : allCheckboxId},
                        success : function(data){
                            console.log(data);
                            if(data.success)
                            {
                                table.ajax.reload();
                                table.rows('.selected').detableselect();
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
