@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid"><span id="general_result"></span></div>

    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3">@lang('file.Goal Tracking')</h4>
        <div id="success_alert" role="alert"></div>
        <br>

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i>{{__('file.Add New Goal')}}</button>
        <button type="button" class="btn btn-danger" id="bulk_delete"><i class="fa fa-minus-circle"></i>{{__('file.Bulk Delete')}}</button>
    </div>

    <div class="table-responsive">
        <table id="goalTrackingTable" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>@lang('file.Goal Type')</th>
                    <th>@lang('file.Company')</th>
                    <th>@lang('file.Target Achievement')</th>
                    <th>@lang('file.Start Date')</th>
                    <th>@lang('file.End Date')</th>
                    <th>@lang('file.Progress')</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
        </table>
    </div>

</section>


@include('performance.goal-tracking.create-modal')
@include('performance.goal-tracking.edit-modal')
@include('performance.goal-tracking.delete-modal')
@include('performance.goal-tracking.delete-checkbox-confirm-modal')



@endsection

@push('scripts')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#goalTrackingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('performance.goal-tracking.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'goal_type', name: 'goal_type'},
                {data: 'company_name', name: 'company_name'},
                {data: 'target_achievement', name: 'target_achievement'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {
                    data: 'progress',
                    name: 'progress',
                    render: function (data) {
                        if (data !== null) {
                            if (data > 70) {
                                return data + '% complete<div class="progress"><div class="progress-bar green" role="progressbar" style="width: ' + data + '%" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100"></div></div>'
                            } else if (data > 50) {
                                return data + '% complete<div class="progress"><div class="progress-bar yellow" role="progressbar" style="width: ' + data + '%" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100"></div></div>'
                            } else {
                                return data + '% complete<div class="progress"><div class="progress-bar red" role="progressbar" style="width: ' + data + '%" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100"></div></div>'
                            }
                        } else {
                            return 0 + '% complete'
                        }
                    }
                },
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

        //----------Insert Data----------------------
        $("#save-button").on("click",function(e){
            e.preventDefault();

            $.ajax({
                url: "{{route('performance.goal-tracking.store')}}",
                type: "POST",
                data: $('#submitForm').serialize(),
                success: function(data){
                    console.log(data);
                    if (data.errors) {
                        $("#alertMessageBox").addClass('bg-danger text-center p-1')
                        if (data.errors) {
                            html = '<p>';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</p>';
                        }
                        $("#alertMessage").html(html)
                    }
                    else if (data.date_errors) {
                        $("#alertMessageBox").addClass('bg-danger text-center p-1')
                        $("#alertMessage").html(data.date_errors)
                    }
                    else if(data.success){
                        console.log(data.success);

                        table.draw();
                        // $('#submitForm').trigger("reset");
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




        //----------Edit Data----------------------
        //Fetch By Id
        $(document).on("click",".edit",function(e){
            e.preventDefault();
            var goalTrackingId = $(this).data("id");
            var element = this;

            $.ajax({
                url: "{{route('performance.goal-tracking.edit')}}",
                type: "GET",
                data: {id:goalTrackingId},
                success: function(data){
                    console.log(data.goalTracking)
                    $('#goalTrackingIdEdit').val(data.goalTracking.id);
                    $('#companyIdEdit').selectpicker('val', data.goalTracking.company_id);
                    $('#goalTypeIdEdit').selectpicker('val', data.goalTracking.goal_type_id);
                    $('#subjectEdit').val(data.goalTracking.subject);
                    $('#targetAchievementEdit').val(data.goalTracking.target_achievement);
                    $('#descriptionEdit').val(data.goalTracking.description);
                    $('#startDateEdit').val(data.goalTracking.start_date);
                    $('#endDateEdit').val(data.goalTracking.end_date);
                    // $('#progressEdit').val(data.goalTracking.progress);
                    if (data.goalTracking.progress) {
                        var instance = $('#progressEdit').data("ionRangeSlider");
                        instance.update({
                            from: data.goalTracking.progress
                        });
                    }
                    $('#statusEdit').selectpicker('val', data.goalTracking.status);
                    $('#EditformModal').modal('show');
                }
            });
        });


        // ---------- Update by Id----------
        $("#update-button").on("click",function(e){
            e.preventDefault();

            $.ajax({
                url: "{{route('performance.goal-tracking.update')}}",
                type: "POST",
                data: $('#updatetEditForm').serialize(),
                success: function(data){
                    console.log(data);
                    if (data.errors)
                    {
                        $("#alertMessageBoxEdit").addClass('bg-danger text-center p-1')
                        if (data.errors) {
                            html = '<p>';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</p>';
                        }
                        $("#alertMessageEdit").html(html)
                    }
                    else if(data.success)
                    {
                        table.draw();
                        // $('#updatetEditForm').trigger("reset");
                        $('#updatetEditForm')[0].reset();
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
            var goalTrackingIdDelete = $(this).data("id");
            var element = this;
            // console.log(goalTypeIdDelete);

            $("#deleteSubmit").on("click",function(e){
                $.ajax({
                    url: "{{route('performance.goal-tracking.delete')}}",
                    type: "GET",
                    data: {goal_tracking_id:goalTrackingIdDelete},
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
            let table = $('#goalTrackingTable').DataTable();
            allCheckboxId = table.rows({selected: true}).ids().toArray();
            console.log(allCheckboxId);

            if(allCheckboxId.length == 0){
                alert("Please Select at least one checkbox.");
            }
            else{
                $('#confirmDeleteCheckboxModal').modal('show');
                $("#deleteCheckboxSubmit").on("click",function(e){
                    $.ajax({
                        url : "{{route('performance.goal-tracking.delete.checkbox')}}",
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
