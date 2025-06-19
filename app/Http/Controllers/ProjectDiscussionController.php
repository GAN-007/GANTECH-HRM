<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectDiscussion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectDiscussionController extends Controller {

	public function index(Project $project)
	{

		if (request()->ajax())
		{
			return datatables()->of(ProjectDiscussion::with('user:id,username')->where('project_id', $project->id)->get())
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
					if ($row->discussion_attachment)
					{
						return $row->project_discussion . '<br><h6><a href="' . route('projects.downloadAttachment', $row->id) . '">' . trans('file.File') . '</a></h6>';
					} else
					{
						return $row->project_discussion;
					}
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('delete-project'))
					{
						$button = '<button type="button" name="delete" id="' . $data->id . '" class="delete-discussion btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

						return $button;
					} else
					{
						return '';
					}
				})
				->rawColumns(['action', 'message'])
				->make(true);

		}
	}

	public function store(Request $request, Project $project)
	{
		$logged_user = auth()->user();


		$validator = Validator::make($request->only('project_discussions', 'discussion_attachments'),
			[
				'project_discussions' => 'required',
				'discussion_attachments' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$data = [];

		$data['project_discussion'] = $request->get('project_discussions');
		$data['user_id'] = $logged_user->id;
		$data ['project_id'] = $project->id;

		$file = $request->discussion_attachments;

		$file_name = null;

		if (isset($file))
		{
			if ($file->isValid())
			{
				$file_name = 'discussion_' . time() . '.' . $file->getClientOriginalExtension();
				$file->storeAs('project_discussion_attachments', $file_name);
				$data['discussion_attachment'] = $file_name;
			}
		}

		ProjectDiscussion::create($data);

		return response()->json(['success' => __('Data Added successfully.')]);
	}


	public function destroy($id)
	{

		$project = ProjectDiscussion::findOrFail($id);
		$file_path = $project->discussion_attachment;

		if ($file_path)
		{
			$file_path = public_path('uploads/project_discussion_attachments/' . $file_path);
			if (file_exists($file_path))
			{
				unlink($file_path);
			}
		}

		$project->delete();

		return response()->json(['success' => __('Data is successfully deleted')]);
	}


	public function download($id)
	{

		$file = ProjectDiscussion::findOrFail($id);

		$file_path = $file->discussion_attachment;

		$download_path = public_path("uploads/project_discussion_attachments/" . $file_path);

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
