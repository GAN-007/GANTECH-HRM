<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\company;
use App\Notifications\ClientTaskCreated;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ClientTaskController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();

		$companies = company::all('id', 'company_name');

		if ($logged_user->role_users_id == 3)
		{
			$client = Client::with('projects')->findOrFail($logged_user->id);
			$projects = $client->projects;
			$project_id = $projects->pluck('id');
			if (request()->ajax())
			{
				return datatables()->of(Task::with('assignedEmployees')
					->whereIn('project_id', $project_id)
					->get())
					->setRowId(function ($task)
					{
						return $task->id;
					})
					->addColumn('task_name', function ($row)
					{
						$task_name = $row->task_name;
						$project = empty($row->project->title) ? '' : $row->project->title;

						return $task_name . '<br><h6><a href="' . route('clientProject') . '">' . $project . '</a></h6>';
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
					->addColumn('action', function ($data)
					{

						$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';

						return $button;
					})
					->rawColumns(['action', 'task_name'])
					->make(true);
			}

			return view('client.task', compact('companies', 'projects'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();

		$validator = Validator::make($request->only('task_name', 'company_id', 'project_id', 'description', 'start_date'
			, 'end_date', 'task_hour'),
			[
				'task_name' => 'required',
				'company_id' => 'required',
				'project_id' => 'required',
				'task_hour' => 'required|numeric',
				'start_date' => 'required',
				'end_date' => 'required|after_or_equal:start_date',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}


		$data = [];

		$data['task_hour'] = $request->task_hour;
		$data['task_name'] = $request->task_name;
		$data['company_id'] = $request->company_id;
		$data['project_id'] = $request->project_id;
		$data ['start_date'] = $request->start_date;
		$data ['end_date'] = $request->end_date;

		$data ['description'] = $request->description;
		$data ['added_by'] = $logged_user->id;


		$task = Task::create($data);


		$notificable = User::where('role_users_id', 1)
			->get();

		Notification::send($notificable, new ClientTaskCreated($task, 'created'));

		return response()->json(['success' => __('Data Added successfully.')]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = Task::findOrFail($id);

			return response()->json(['data' => $data]);
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param Project $task
	 * @return Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		$id = $request->hidden_id;

		$validator = Validator::make($request->only('edit_task_name', 'edit_project_id', 'edit_task_hour', 'edit_description', 'edit_start_date'
			, 'edit_end_date', 'edit_task_status', 'edit_task_progress'),
			[
				'edit_task_name' => 'required',
				'edit_project_id' => 'required',
				'edit_task_hour' => 'required',
				'edit_start_date' => 'required',
				'edit_end_date' => 'required',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}


		$data = [];

		$data['task_name'] = $request->edit_task_name;
		$data['project_id'] = $request->edit_project_id;
		$data ['start_date'] = $request->edit_start_date;
		$data ['end_date'] = $request->edit_end_date;
		$data ['company_id'] = $request->edit_company_id;


		if ($request->edit_description)
		{
			$data ['description'] = $request->edit_description;
		}

		$data ['task_hour'] = $request->edit_task_hour;
		$data ['task_status'] = $request->edit_task_status;
		if ($request->edit_task_progress)
		{
			$data ['task_progress'] = $request->edit_task_progress;
		}


		Task::find($id)->update($data);

		$task = Task::findOrFail($id);

		$notificable = User::where('role_users_id', 1)
			->get();

		Notification::send($notificable, new ClientTaskCreated($task, 'updated'));

		return response()->json(['success' => __('Data is successfully updated')]);
	}

}
