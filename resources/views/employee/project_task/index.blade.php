<div class="row">
    <div class="col-md-3">

        <ul class="nav nav-tabs vertical" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="employee_project-tab" data-toggle="tab" href="#Employee_project"
                   role="tab" aria-controls="Employee_project_task" aria-selected="true">{{trans('file.Project')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('employee_task.show',$employee)}}" id="employee_task-tab"
                   data-toggle="tab" data-table="employee_task" data-target="#Employee_task" role="tab"
                   aria-controls="Employee_task" aria-selected="false">{{trans('file.Task')}}</a>
            </li>
        </ul>

    </div>
    <div class="col-md-9">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="Employee_project" role="tabpanel"
                 aria-labelledby="employee_project-tab">
                <!--Contents for Basic starts here-->
                {{__('Project Info')}}
                <hr>
                @include('employee.project_task.project.index')
            </div>


            <div class="tab-pane fade" id="Employee_task" role="tabpanel" aria-labelledby="employee_task-tab">
                {{__('Task Info')}}
                <hr>
                @include('employee.project_task.task.index')
            </div>
        </div>
    </div>
</div>
