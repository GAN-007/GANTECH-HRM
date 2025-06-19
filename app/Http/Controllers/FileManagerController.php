<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\FileManager;
use App\Models\FileManagerSetting;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class FileManagerController extends Controller
{
	public function index()
	{
		$logged_user = auth()->user();
		$departments = department::select('id', 'department_name')->get();

		if ($logged_user->can('view-file_manager'))
		{
			if (request()->ajax())
			{
				return datatables()->of(FileManager::with('department:id,department_name', 'AddedBy:id,username')->get())
					->setRowId(function ($files)
					{
						return $files->id;
					})
					->addColumn('department', function ($row)
					{
						return empty($row->department->department_name) ? '' : $row->department->department_name;
					})
					->addColumn('added_by', function ($row)
					{
						return $row->AddedBy->username ?? '' ;
					})
					->addColumn('external_link', function ($row)
					{
						if($row->external_link)
						{
							$button = '<h6><a href="https://' . $row->external_link . '" target="_blank">'.__('External Link').'</a></h6>';

							return $button;
						}
						else{
							return '';
						}
					})
					->addColumn('action', function ($data)
					{
						$button = '<a class="btn btn-info btn-sm" href="' . route('files.downloadFile', $data->id) . '"><i class="dripicons-download"></i></a>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-file_manager'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-file_manager'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}
							return $button;
					})
					->rawColumns(['action','external_link'])
					->make(true);
			}

			return view('file_manager.file_manager', compact('departments'));
		}

		return abort('403', __('You are not authorized'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-file_manager'))
		{
			$file_config = FileManagerSetting::select('allowed_extensions','max_file_size')->first();

			$allowed_ext = $file_config->allowed_extensions;
			$max_size = $file_config->max_file_size;

			$validator = Validator::make($request->only('department_id', 'file_name', 'external_link', 'document_file'),
				[
					'department_id' => 'required',
					'file_name' => 'required|unique:file_managers,file_name,',
					'document_file' => 'nullable|file',
					'document_file' =>'max:' .$max_size,
					'document_file' =>'mimes:' .$allowed_ext,
				]
//				,
//				[
//					'department_id.required' => 'Please select a department',
//					'file_name.required' => 'File Name can not be empty',
//					'file_name.unique' => 'File Name should be unique',
//					'document_file.file' => 'Must be a file of type ('.$allowed_ext . ' )',
//					'document_file.mimes' => 'Must be a file of type (' .$allowed_ext .' )',
//					'document_file.max' => 'File size should be less than,' .$max_size.'(mb)',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$file_name = $request->file_name;;

			$data['file_name'] = $file_name;

		 if($request->hasFile('document_file')) {


		 	$file = $request->document_file;


			 $bytes = $file->getSize();

			 if ($bytes >= 1073741824)
			 {
				 $data['file_size'] = number_format($bytes / 1073741824, 2) . ' GB';
			 }
			 elseif ($bytes >= 1048576)
			 {
				 $data['file_size'] = number_format($bytes / 1048576, 2) . ' MB';
			 }
			 elseif ($bytes >= 1024)
			 {
				 $data['file_size'] = number_format($bytes / 1024, 2) . ' KB';
			 }
			 elseif ($bytes > 1)
			 {
				 $data['file_size'] = $bytes . ' bytes';
			 }
			 elseif ($bytes == 1)
			 {
				 $data['file_size'] = $bytes . ' byte';
			 }
			 else
			 {
				 $data['file_size'] = '';
			 }


			 $data['file_extension'] = $file->getClientOriginalExtension();

		 }

			$data['department_id'] = $request->department_id;
			$data['file_extension'] = $file->getClientOriginalExtension();
			$data ['external_link'] = $request->external_link;
			$data ['added_by'] = $logged_user->id;


			if (isset($file))
			{
				if ($file->isValid())
				{
					$file_name_extension = $file_name. '.' . $file->getClientOriginalExtension();
					$file->storeAs('file_manager', $file_name_extension);
				}
			}



			FileManager::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}




	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = FileManager::findOrFail($id);
			$department_name = $data->department->department_name ?? '';

			return response()->json(['data' => $data, 'department_name' => $department_name]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-file_manager'))
		{
			$id = $request->hidden_id;

			$file = FileManager::findOrFail($id);

			$file_path = $file->file_name;
			$file_extension = $file->file_extension;

			$validator = Validator::make($request->only('department_id', 'file_name', 'external_link'),
				[
					'file_name' => 'required|unique:file_managers,file_name,'.$id,

				]
//				,
//				[
//					'file_name.required' => 'File Name can not be empty',
//					'file_name.unique' => 'File Name should be unique',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data ['external_link'] = $request->external_link;
			$file_name = $request->file_name;
			$data['file_name'] = $file_name;

			if($file_path)
			{
				$file_path_old = public_path("uploads/file_manager/" .$file_path.'.'.$file_extension);
				$file_path_new = public_path('uploads/file_manager/' . $file_name.'.'.$file_extension);
				File::move($file_path_old, $file_path_new);
			}

			if ($request->department_id)
			{
				$data ['department_id'] = $request->department_id;
			}

			FileManager::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		} else
		{

			return response()->json(['success' => __('You are not authorized')]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-file_manager'))
		{
			$file = FileManager::findOrFail($id);
			$file_path = $file->file_name;
			$file_extension = $file->file_extension;

			if($file_path)
			{
				$file_path = public_path('uploads/file_manager/' . $file_path.'.'.$file_extension);
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

	public function delete_by_selection(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-file_manager'))
		{
			$files_id = $request['file_managerIdArray'];
			$files = FileManager::whereIntegerInRaw('id', $files_id)->get();

			foreach ($files as $file)
			{
				$file_path = $file->file_name;
				$file_extension = $file->file_extension;

				if ($file_path)
				{
					$file_path = public_path('uploads/file_manager/' . $file_path.'.'.$file_extension);
					if (file_exists($file_path))
					{
						unlink($file_path);
					}
				}
				$file->delete();
			}

			return response()->json(['success' => __('Multi Delete',['key'=>trans('file.File')])]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function download($id)
	{

		$file = FileManager::findOrFail($id);

		$file_path = $file->file_name;
		$file_extension = $file->file_extension;
		$download_path = public_path("uploads/file_manager/" . $file_path . '.' . $file_extension);

		if (file_exists($download_path))
		{
			$response = response()->download($download_path);
			return $response;
		}
		else {
			return abort('404', __('File not Found'));
		}
	}

}
