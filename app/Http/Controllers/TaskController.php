<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Project;
use App\Models\Task;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		$projects = Project::select('id', 'title')->get();
		if ($logged_user->can('view-task'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Task::with('project:id,title', 'assignedEmployees', 'addedBy:id,username')->get())
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
						return $row->addedBy->username ?? '';
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
						$button = '<a id="' . $data->id . '" class="show btn btn-success btn-sm" href="' . route('tasks.show', $data) . '"><i class="dripicons-preview"></i></a>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-task'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-task'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action', 'task_name'])
					->make(true);
			}

			return view('projects.task.index', compact('companies', 'projects'));
		}

		return abort('403', __('You are not authorized'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('store-task'))
		{
			$validator = Validator::make($request->only('task_name', 'company_id', 'employee_id', 'project_id', 'description', 'start_date'
				, 'end_date', 'task_hour'),
				[
					'task_name' => 'required',
					'company_id' => 'required',
					'project_id' => 'required',
					'employee_id' => 'required',
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
			$employees = $request->input('employee_id');
			$task->assignedEmployees()->sync($employees);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Project $task
	 * @return Response
	 */
	public function show(Task $task)
	{
		$company_name = $task->company->company_name ?? '';

		try
		{
			$name = DB::table('employee_task')->where('task_id', $task->id)->pluck('employee_id')->toArray();
		} catch (Exception $e)
		{
			$name = null;
		}
		$logged_user = auth()->user();

		if ($logged_user->can('view-task') || in_array($logged_user->id, $name))
		{

			$employees = DB::table('employees')->where('company_id', $task->company_id)
				->select('employees.id', DB::raw("CONCAT(employees.first_name,' ',employees.last_name) as full_name"))
				->get();

			return view('projects.task.details', compact('task', 'employees', 'company_name', 'name'));
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Project $task
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
		if ($logged_user->can('edit-task'))
		{
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

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Project $task
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-task'))
		{
			Task::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	public function progressStore(Request $request, Task $task)
	{
			$validator = Validator::make($request->only('task_hour'),
				[
					'task_hour' => 'required|numeric',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			if ($request->task_progress)
			{
				$data['task_progress'] = $request->task_progress;
			}
			$data['task_hour'] = $request->task_hour;

			if ($request->task_status)
			{
				$data['task_status'] = $request->task_status;
			}


			$task->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}


	public function notesStore(Request $request, Task $task)
	{
		$validator = Validator::make($request->only('task_note'),
			[
				'task_note' => 'required',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}


		$data = [];

		$data['task_note'] = $request->task_note;

		$task->update($data);

		return response()->json(['success' => __('Data is successfully updated')]);
	}
}
