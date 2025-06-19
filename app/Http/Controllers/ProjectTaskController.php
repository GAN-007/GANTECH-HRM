<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectTaskController extends Controller {

	public function index(Project $project)
	{

		if (request()->ajax())
		{
			return datatables()->of(Task::with('addedBy:id,username')->where('project_id', $project->id)->get())
				->setRowId(function ($project)
				{
					return $project->id;
				})
				->addColumn('created_by', function ($row)
				{
					$username = $row->addedBy->username;

					return $username;

				})
				->addColumn('action', function ($data)
				{

					$button = '<a id="' . $data->id . '" class="show-task btn btn-success btn-sm" href="' . route('tasks.show', $data) . '"><i class="dripicons-preview"></i></a>';
					$button .= '&nbsp;&nbsp;';

					if (auth()->user()->can('delete-project'))
					{
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete-task btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
					}
					return $button;
				})
				->rawColumns(['action'])
				->make(true);

		}
	}

	public function store(Request $request, Project $project)
	{
		$logged_user = auth()->user();


		if ($logged_user->can('store-project'))
		{
			$validator = Validator::make($request->only('task_title', 'estimated_hour', 'description', 'start_date'
				, 'end_date'),
				[
					'task_title' => 'required',
					'estimated_hour' => 'required|numeric',
					'start_date' => 'required',
					'end_date' => 'required|after_or_equal:start_date',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['task_name'] = $request->task_title;
			$data['company_id'] = $project->company_id;
			$data['added_by'] = $logged_user->id;
			$data['project_id'] = $project->id;
			$data ['start_date'] = $request->start_date;
			$data ['end_date'] = $request->end_date;

			$data ['description'] = $request->task_description;
			$data ['task_hour'] = $request->estimated_hour;


			Task::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function destroy($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-project'))
		{
			$task = Task::findOrFail($id);

			$task->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}
}
