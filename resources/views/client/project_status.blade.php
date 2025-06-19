@extends('layout.client')
@section('content')

    <section>
        <div class="table-responsive">
            <table id="project_status-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{__('Project Summary')}}</th>
                    <th>{{trans('file.Priority')}}</th>
                    <th>{{__('Assigned Employees')}}</th>
                    <th>{{__('Start Date')}}</th>
                    <th>{{__('End Date')}}</th>
                    <th>{{__('Project Progress')}}</th>
                </tr>
                </thead>


                <tbody id="tablecontents">
                @foreach($projects as $key=>$project)
                    <tr class="row1" data-id="{{$project->id}}">
                        <td>{{$key}}</td>
                        <td>{{$project->title}}</td>
                        <td>{{ $project->project_priority }}</td>
                        <td>
                            @php
                        $assigned_name = $project->assignedEmployees()->pluck('last_name', 'first_name');
                        $collection = [];
                        foreach ($assigned_name as $first => $last)
                        {
                        $full_name = $first . ' ' . $last;
                        echo $full_name . '<br>';
                        }
                        @endphp

                        </td>
                        <td>{{$project->start_date}}</td>
                        <td>{{$project->end_date}}</td>
                        <td>{{$project->project_progress}} %</td>
                    </tr>
                @endforeach
                </tbody>



            </table>
        </div>
    </section>

    <script>
        (function($) { 
            "use strict"; 
            
            $('#project_status-table').DataTable({
                "order": [],
                'columnDefs': [
                    {
                        "orderable": false,
                        'targets': [0,3]
                    },
                    {
                        'checkboxes': {
                            'selectRow': true
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
                        customize: function (doc) {
                            for (let i = 1; i < doc.content[1].table.body.length; i++) {
                                if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                                    let imagehtml = doc.content[1].table.body[i][0].text;
                                    let regex = /<img.*?src=['"](.*?)['"]/;
                                    let src = regex.exec(imagehtml)[1];
                                    let tempImage = new Image();
                                    tempImage.src = src;
                                    let canvas = document.createElement("canvas");
                                    canvas.width = tempImage.width;
                                    canvas.height = tempImage.height;
                                    let ctx = canvas.getContext("2d");
                                    ctx.drawImage(tempImage, 0, 0);
                                    let imagedata = canvas.toDataURL("image/png");
                                    delete doc.content[1].table.body[i][0].text;
                                    doc.content[1].table.body[i][0].image = imagedata;
                                    doc.content[1].table.body[i][0].fit = [30, 30];
                                }
                            }
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
@endsection