<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectFileController extends Controller {

	public function index(Project $project)
	{

		if (request()->ajax())
		{
			return datatables()->of(ProjectFile::with('user:id,username')->where('project_id', $project->id)->get())
				->setRowId(function ($file)
				{
					return $file->id;
				})
				->addColumn('file_description', function ($row)
				{
					if ($row->file_description)
					{
						return $row->file_description . '<br><h6><a href="' . route('projects.downloadFile', $row->id) . '">' . trans('file.File') . '</a></h6>';
					} else
					{
						return '';
					}
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('delete-project'))
					{
						$button = '<button type="button" name="delete" id="' . $data->id . '" class="delete-file btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

						return $button;
					} else
					{
						return '';
					}
				})
				->rawColumns(['action', 'file_description'])
				->make(true);

		}
	}

	public function store(Request $request, Project $project)
	{
		$logged_user = auth()->user();

		$validator = Validator::make($request->only('file_title', 'file_description', 'file_attachment'),
			[
				'file_title' => 'required',
				'file_attachment' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$data = [];

		$data['file_description'] = $request->get('file_description');
		$data['file_title'] = $request->file_title;
		$data ['project_id'] = $project->id;

		$file = $request->file_attachment;

		$file_name = null;

		if (isset($file))
		{
			if ($file->isValid())
			{
				$file_name = 'project_file_' . time() . '.' . $file->getClientOriginalExtension();
				$file->storeAs('project_file_attachments', $file_name);
				$data['file_attachment'] = $file_name;
			}
		}

		ProjectFile::create($data);

		return response()->json(['success' => __('Data Added successfully.')]);
	}


	public function destroy($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-project'))
		{
			$file = ProjectFile::findOrFail($id);
			$file_path = $file->file_attachment;

			if ($file_path)
			{
				$file_path = public_path('uploads/project_file_attachments/' . $file_path);
				if (file_exists($file_path))
				{
					unlink($file_path);
				}
			}

			$file->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function download($id)
	{

		$file = ProjectFile::findOrFail($id);

		$file_path = $file->file_attachment;

		$download_path = public_path("uploads/project_file_attachments/" . $file_path);

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
