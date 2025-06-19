<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Task;
use App\Models\TaskDiscussion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskDiscussionController extends Controller {

	public function index(Task $task)
	{

		if (request()->ajax())
		{
			return datatables()->of(TaskDiscussion::with('user:id,username')->where('task_id', $task->id)->get())
				->setRowId(function ($discussion)
				{
					return $discussion->id;
				})
				->addColumn('user', function ($row)
				{
					$username = $row->user->username;

					try
					{
						$department_name = Employee::where('employee_id', $row->user->id)->select('department_name')->first();
					} catch (Exception $e)
					{
						$department_name = trans('file.Admin');
					}

					$department_name = empty($department_name) ? '' : $department_name;

					return $username . ' (' . $department_name . ')';

				})
				->addColumn('message', function ($row)
				{
					return $row->task_discussion;
				})
				->addColumn('action', function ($data)
				{

					$button = '<button type="button" name="delete" id="' . $data->id . '" class="delete-discussion btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

					return $button;
				})
				->rawColumns(['action'])
				->make(true);

		}
	}

	public function store(Request $request, Task $task)
	{

		$validator = Validator::make($request->only('task_discussions'),
			[
				'task_discussions' => 'required',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$data = [];

		$data['task_discussion'] = $request->get('task_discussions');
		$data['user_id'] = auth()->user()->id;
		$data ['task_id'] = $task->id;

		TaskDiscussion::create($data);

		return response()->json(['success' => __('Data Added successfully.')]);
	}


	public function destroy($id)
	{
		$task = TaskDiscussion::findOrFail($id);

		$task->delete();

		return response()->json(['success' => __('Data is successfully deleted')]);
	}
}
