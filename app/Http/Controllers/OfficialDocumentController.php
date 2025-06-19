<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Console\Commands\DocumentExpiryReminder;
use App\Models\DocumentType;
use App\Models\FileManagerSetting;
use App\Models\OfficialDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;



class OfficialDocumentController extends Controller {

	//
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		$document_types = DocumentType::all('id', 'document_type');

		if ($logged_user->can('view-official_document'))
		{
			if (request()->ajax())
			{
				$official_documents = OfficialDocument::with('company:id,company_name', 'AddedBy:id,username', 'DocumentType:id,document_type')
					->get();

				return datatables()->of($official_documents)
					->setRowId(function ($official_document)
					{
						return $official_document->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ' ;
					})
					->addColumn('added_by', function ($row)
					{
						return $row->AddedBy->username ?? '';
					})
					->addColumn('expiry_date', function ($row)
					{
						return $row->expiry_date;
					})
					->addColumn('document', function ($row)
					{
						return $row->DocumentType->document_type;
					})
					->addColumn('title', function ($row)
					{
						if ($row->document_file)
						{
							return $row->document_title . $row->identificaton_number . '<br><h6><a href="' . route('official_documents.downloadFile', $row->id) . '">' . trans('file.File') . '</a></h6>';
						} else
						{
							return $row->document_title . $row->identificaton_number;
						}
					})
					->addColumn('action', function ($data)
					{
						$button = '<h4><a href="' . route('official_documents.downloadFile', $data->id) . '">' . trans('file.Download') . '</a></h4>';

						if (auth()->user()->can('edit-official_document'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';

						}
						if (auth()->user()->can('delete-official_document'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}
							return $button;
					})
					->rawColumns(['action', 'title'])
					->make(true);
			}

			return view('file_manager.official_documents', compact('companies', 'document_types'));
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

		if ($logged_user->can('store-official_document'))
		{
			$file_config = FileManagerSetting::select('allowed_extensions', 'max_file_size')->first();

			$allowed_ext = $file_config->allowed_extensions;
			$max_size = $file_config->max_file_size;

			$validator = Validator::make($request->only('company_id', 'document_title', 'description', 'document_file',
				'expiry_date', 'identification_number', 'is_notify', 'document_type_id'),
				[
					'document_title' => 'required',
					'document_type_id' => 'required',
					'expiry_date' => 'required',
					'identification_number' => 'required',
					'is_notify' => 'required',
					'company_id' => 'required',
					'document_file' => 'file',
					'document_file' => 'max:' . $max_size,
					'document_file' => 'mimes:' . $allowed_ext,
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['document_title'] = $request->document_title;
			$data['company_id'] = $request->company_id;
			$data['document_type_id'] = $request->document_type_id;
			$data ['expiry_date'] = $request->expiry_date;
			$data ['description'] = $request->description;
			$data ['identification_number'] = $request->identification_number;
			$data['is_notify'] = $request->is_notify;
			$data ['added_by'] = $logged_user->id;


			$file = $request->document_file;

			$file_name = null;

			if (isset($file))
			{
				$file_name = $data['document_title'];
				if ($file->isValid())
				{
					$file_name = $file_name . '.' . time() . '.' . $file->getClientOriginalExtension();
					$file->storeAs('official_documents', $file_name);
					$data['document_file'] = $file_name;
				}
			}


			OfficialDocument::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = OfficialDocument::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-official_document'))
		{
			$id = $request->hidden_id;

			$file = OfficialDocument::findOrFail($id);

			$file_path = $file->document_file;

			$file_config = FileManagerSetting::select('allowed_extensions', 'max_file_size')->first();

			$allowed_ext = $file_config->allowed_extensions;
			$max_size = $file_config->max_file_size;

			$validator = Validator::make($request->only('company_id', 'document_title', 'description',
				'expiry_date', 'identification_number', 'is_notify', 'document_type_id','document_file'),
				[
					'document_title' => 'required',
					'document_type_id' => 'required',
					'expiry_date' => 'required',
					'identification_number' => 'required',
					'is_notify' => 'required',
					'company_id' => 'required',
					'document_file' => 'file',
					'document_file' => 'max:' . $max_size,
					'document_file' => 'mimes:' . $allowed_ext,
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['document_title'] = $request->document_title;
			$data['company_id'] = $request->company_id;
			$data['document_type_id'] = $request->document_type_id;
			$data ['expiry_date'] = $request->expiry_date;
			$data ['description'] = $request->description;
			$data ['identification_number'] = $request->identification_number;
			$data['is_notify'] = $request->is_notify;
			$data ['added_by'] = $logged_user->id;


			$file = $request->document_file;

			$file_name = null;

			if (isset($file))
			{
				$this->unlink($id);
				$file_name = $data['document_title'];
				if ($file->isValid())
				{
					$file_name = $file_name . '.' . time() . '.' . $file->getClientOriginalExtension();
					$file->storeAs('official_documents', $file_name);
					$data['document_file'] = $file_name;
				}
			}

			OfficialDocument::find($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-official_document'))
		{
			$this->unlink($id);
			OfficialDocument::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('delete-official_document'))
		{
			$files_id = $request['official_documentsIdArray'];
			$files = OfficialDocument::whereIntegerInRaw('id', $files_id)->get();

			foreach ($files as $file)
			{
				$file_path = $file->document_file;

				if ($file_path)
				{
					$file_path = public_path('uploads/official_documents/' . $file_path);
					if (file_exists($file_path))
					{
						unlink($file_path);
					}
				}
				$file->delete();
			}

			return response()->json(['success' => __('Multi Delete', ['key' => trans('file.File')])]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function download($id)
	{

		$file = OfficialDocument::findOrFail($id);

		$file_path = $file->document_file;
		$download_path = public_path("uploads/official_documents/" . $file_path);

		if (file_exists($download_path))
		{
			$response = response()->download($download_path);

			return $response;
		} else
		{
			return abort('404', __('File not Found'));
		}
	}

	public function unlink($id)
	{

		$document = OfficialDocument::findOrFail($id);
		$file_path = $document->document_file;

		if ($file_path)
		{
			$file_path = public_path('uploads/official_documents/' . $file_path);
			if (file_exists($file_path))
			{
				unlink($file_path);
			}
		}
	}
}
