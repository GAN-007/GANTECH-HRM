<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectBug;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectBugController extends Controller {

	public function index(Project $project)
	{

		if (request()->ajax())
		{
			return datatables()->of(ProjectBug::with('user:id,username')->where('project_id', $project->id)->get())
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
				->addColumn('title', function ($row)
				{
					if ($row->bug_attachment)
					{
						return $row->title . '<br><h6><a href="' . route('projects.downloadBug', $row->id) . '">' . trans('file.File') . '</a></h6>';
					} else
					{
						return $row->title;
					}
				})
				->addColumn('action', function ($data)
				{
					$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit-bug btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
					$button .= '&nbsp;&nbsp;';
					if (auth()->user()->can('delete-project'))
					{
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete-bug btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
					}

					return $button;
				})
				->rawColumns(['action', 'title'])
				->make(true);

		}
	}

	public function store(Request $request, Project $project)
	{
		$logged_user = auth()->user();

		$validator = Validator::make($request->only('bugs_title', 'bug_attachment'),
			[
				'bugs_title' => 'required',
				'bug_attachment' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$data = [];

		$data['title'] = $request->get('bugs_title');
		$data['user_id'] = $logged_user->id;
		$data ['project_id'] = $project->id;

		$file = $request->bug_attachment;

		$file_name = null;

		if (isset($file))
		{
			if ($file->isValid())
			{
				$file_name = 'bug' . time() . '.' . $file->getClientOriginalExtension();
				$file->storeAs('project_bug_attachments', $file_name);
				$data['bug_attachment'] = $file_name;
			}
		}

		ProjectBug::create($data);

		return response()->json(['success' => __('Data Added successfully.')]);
	}


	public function editStatus($id)
	{

		$bug = ProjectBug::findOrFail($id);

		return response()->json(['id' => $bug->id, 'status' => $bug->status]);
	}

	public function updateStatus(Request $request)
	{
		$id = $request->bug_status_id;


		$data = [];

		$data['status'] = $request->bug_status;

		ProjectBug::whereId($id)->update($data);

		return response()->json(['success' => __('Data is successfully updated')]);

	}

	public function destroy($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-project'))
		{
			$bug = ProjectBug::findOrFail($id);
			$file_path = $bug->discussion_attachment;

			if ($file_path)
			{
				$file_path = public_path('uploads/project_bug_attachments/' . $file_path);
				if (file_exists($file_path))
				{
					unlink($file_path);
				}
			}

			$bug->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return abort('403', __('You are not authorized'));
	}

	public function download($id)
	{

		$file = ProjectBug::findOrFail($id);

		$file_path = $file->bug_attachment;

		$download_path = public_path("uploads/project_bug_attachments/" . $file_path);

		if (file_exists($download_path))
		{
			$response = response()->download($download_path);

			return $response;
		} else
		{
			return abort('404', __('File not Found'));
		}
	}

}
