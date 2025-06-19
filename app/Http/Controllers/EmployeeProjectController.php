<?php

namespace App\Http\Controllers;

use App\Models\Project;

class EmployeeProjectController extends Controller {

	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Project::with('client:id,first_name,last_name', 'assignedEmployees')->join('employee_project', 'projects.id', '=', 'employee_project.project_id')
					->where('employee_id', $employee)->get())
					->setRowId(function ($project)
					{
						return $project->id;
					})
					->addColumn('summary', function ($row)
					{
						$title = $row->title;
						$summary = empty($row->summary) ? '' : substr($row->summary, 0, 50);

						return $title . ' (' . $summary . '.....)';
					})
					->addColumn('client', function ($row)
					{
                        if ($row->client) {
                            return $row->client->first_name.' '.$row->client->last_name ?? null;
                        }else {
                            return '';
                        }
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
					->addColumn('action', function ($data) use ($employee)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee') || auth()->user()->id == $employee)
						{
							$button = '<a id="' . $data->id . '" class="show btn btn-primary btn-sm" href="' . route('projects.show', $data) . '"><i class="dripicons-preview"></i></a>';
						}
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}
		}
	}
}
