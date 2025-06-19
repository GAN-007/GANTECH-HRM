@extends('layout.main')
@section('content')

    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="table-responsive">
            <table id="job_candidate-table" class="table ">
                <thead>
                <tr>
                    <th>{{__('Job Title')}}</th>
                    <th>{{__('Candidate Name')}}</th>
                    <th>{{__('Candidate Email')}}</th>
                    <th>{{trans('file.CV')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th>{{__('Apply Date')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>


    <div class="modal fade" id="candidate_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{__('Candidate Info')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table  table-bordered">

                                    <tr>
                                        <th>{{__('Job Title')}}</th>
                                        <td id="job_description"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <td id="candidate_name"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Contact')}}</th>
                                        <td id="candidate_contact"></td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Address')}}</th>
                                        <td id="candidate_address"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Status')}}</th>
                                        <td id="status"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Cover Letter')}}</th>
                                        <td id="cover_letter"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Apply Date')}}</th>
                                        <td id="apply_date"></td>
                                    </tr>


                                </table>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.Close')}}</button>
            </div>
        </div>
    </div>



    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">{{trans('file.OK')}}'</button>
                    <button type="button" class="close btn-default" data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>



@endsection


@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).ready(function () {

            let table_table = $('#job_candidate-table').DataTable({
                initComplete: function () {
                    this.api().columns([1]).every(function () {
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
                    url: "{{ route('job_candidates.index') }}",
                },

                columns: [

                    {
                        data: 'job_description',
                        name: 'job_description',

                    },
                    {
                        data: 'candidate_details',
                        name: 'candidate_details',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'cv',
                        name: 'cv',
                        render:function (data)
                        {
                            return '<a href={{url('uploads/candidate_cv')}}'
                                +'/'+data +'>'+ 'CV' + '</a>';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
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
                    'lengthMenu': '_MENU_ {{__("records per page")}}',
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


        $(document).on('click', '.details', function () {

            var id = $(this).attr('id');
            $('#form_result').html('');


            var target = "{{ route('job_candidates.index') }}/"+id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (result) {

                    $('#job_description').html(result.data.job_title + '<br><h6>' + result.data.short_description + '</h6>' );
                    $('#candidate_name').html(result.data.full_name );
                    $('#candidate_contact').html('Email: '+result.data.email + '<br><h6> Phone: '+ result.data.phone + '<br><h6> Fb: '+ result.data.fb_id + '</h6><h6> Linkedin: '+result.data.linkedin_id+'</h6>');
                    $('#candidate_address').html(result.data.address);
                    $('#apply_date').html(result.data.created_at);
                    $('#status').html(result.data.status);
                    $('#cover_letter').html(result.data.cover_letter);
                    $('#candidate_modal').modal('show');
                    $('.modal-title').text("{{__('Candidate Info')}}");
                }
            });
        });


        let delete_id;

        $(document).on('click', '.delete', function () {
            delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('{{__('DELETE Record')}}');
            $('#ok_button').text('{{trans('file.OK')}}');

        });



        $('.close').on('click', function () {
            $('#job_candidate-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "{{ route('job_candidates.index') }}/" + delete_id + '/delete';
            $.ajax({
                url: target,
                beforeSend: function () {
                    $('#ok_button').text('{{trans('file.Deleting...')}}');
                },
                success: function (data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    setTimeout(function () {
                        $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        $('#confirmModal').modal('hide');
                        $('#job_candidate-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });

    })(jQuery);
</script>
@endpush
