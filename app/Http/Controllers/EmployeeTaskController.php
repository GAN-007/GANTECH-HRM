<?php

namespace App\Http\Controllers;

use App\Models\Task;

class EmployeeTaskController extends Controller {

	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Task::with('project:id,title', 'assignedEmployees', 'addedBy:id,username')->join('employee_task', 'tasks.id', '=', 'employee_task.task_id')
					->where('employee_id', $employee)->get())
					->setRowId(function ($task)
					{
						return $task->id;
					})
					->addColumn('task_name', function ($row)
					{
						$task_name = $row->task_name;
						$project = empty($row->project->title) ? '' : $row->project->title;

						return $task_name . '<br><h6><a href="' . route('projects.show', $row->project) . '">' . $project . '</a></h6>';
					})
					->addColumn('created_by', function ($row)
					{
						return $row->addedBy->username;
					})
					->addColumn('assigned_employee', function ($row)
					{
						$assigned_name = $row->assignedEmployees()->pluck('last_name', 'first_name');
						$collection = [];
						foreach ($assigned_name as $first => $last)
						{
							$full_name = $first . ' ' . $last;
							array_push($collection, $full_name);
						}

						return $collection;
					})
					->addColumn('action', function ($data) use ($logged_user,$employee)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee') || $logged_user->id == $employee)
						{
							$button = '<a id="' . $data->id . '" class="show btn btn-success btn-sm" href="' . route('tasks.show', $data) . '"><i class="dripicons-preview"></i></a>';
						}

						return $button;
					})
					->rawColumns(['action', 'task_name'])
					->make(true);
			}
		}
	}
}
