<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeImmigration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeImmigrationController extends Controller {

	public function show(Employee $employee)
	{

		$logged_user = auth()->user();
		$employee_id = $employee->id;

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee_id)
		{
			if (request()->ajax())
			{
				return datatables()->of(EmployeeImmigration::where('employee_id', $employee->id)->get())
					->setRowId(function ($immigration)
					{
						return $immigration->id;
					})
					->addColumn('document', function ($row)
					{
						if ($row->document_file)
						{
							return $row->document_number . '<br><h6><a href="' . route('immigrations_document.download', $row->id) . '">' . trans('file.File') . '</a></h6>';
						} else
						{
							return $row->document_number;
						}
					})
					->addColumn('country', function ($row)
					{
						$country_id = $row->country_id;
						$country = DB::table('countries')->find($country_id);

						return $country->name;
					})
					->addColumn('action', function ($data)use ($logged_user,$employee_id)
					{
						if ($logged_user->can('modify-details-employee')||$logged_user->id==$employee_id)
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="immigration_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="immigration_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

							return $button;
						}
						else
						{
							return '';
						}
					})
					->rawColumns(['action', 'document'])
					->make(true);
			}
		} else
		{
			return response()->json(__('You are not authorized'));
		}
	}

	public function store(Request $request, $employee)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('store-details-employee') || $logged_user->id == $employee)
		{
			$validator = Validator::make($request->only('document_number', 'document_type_id', 'issue_date', 'expiry_date',
				'eligible_review_date', 'document_file', 'country'),
				[
					'document_number' => 'required|unique:employee_immigrations',
					'document_type_id' => 'required',
					'document_file' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
				]
//				[
//					'document_number.required' => 'Document Number can not be empty',
//					'document_number.unique' => 'Document Number must be unique',
//					'document_type_id.required' => 'Please select document Type',
//					'document_file.file'=>'File is not valid',
//					'document_file.max'=>'File must be less than 10 mb',
//					'document_file.mimes'=>'File must be of (jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf) type',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['document_number'] = $request->document_number;
			$data['employee_id'] = $employee;
			$data['document_type_id'] = $request->document_type_id;
			$data ['issue_date'] = $request->issue_date;
			$data ['expiry_date'] = $request->expiry_date;
			$data ['eligible_review_date'] = $request->eligible_review_date;
			$data['country_id'] = $request->country;

			$file = $request->document_file;

			$file_name = null;

			if (isset($file))
			{
				$file_name = $data['document_number'];
				if ($file->isValid())
				{
					$file_name = 'immigration_' . $file_name . '.' . $file->getClientOriginalExtension();
					$file->storeAs('immigration_documents', $file_name);
					$data['document_file'] = $file_name;
				}
			}

			EmployeeImmigration::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = EmployeeImmigration::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		$id = $request->hidden_id;
		$logged_user = auth()->user();
		if ($logged_user->can('modify-details-employee') || $logged_user->id == $id)
		{
			$validator = Validator::make($request->only('document_number', 'document_type_id', 'issue_date', 'expiry_date',
				'eligible_review_date', 'document_file', 'country'),
				[
					'document_number' => 'required|unique:employee_immigrations,document_number,' . $id,
					'document_type_id' => 'required',
					'document_file' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
				]
//				,
//				[
//					'document_number.required' => 'Document Number can not be empty',
//					'document_number.unique' => 'Document Number must be unique',
//					'document_type_id.required' => 'Please select document Type',
//					'document_file.file'=>'File is not valid',
//					'document_file.max'=>'File must be less than 10 mb',
//					'document_file.mimes'=>'File must be of (jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf) type',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['document_number'] = $request->document_number;
			$data['document_type_id'] = $request->document_type_id;
			$data ['issue_date'] = $request->issue_date;
			$data ['expiry_date'] = $request->expiry_date;
			$data ['eligible_review_date'] = $request->eligible_review_date;
			$data['country_id'] = $request->country;

			$file = $request->document_file;

			$file_name = null;

			if (isset($file))
			{
				$this->unlink($id);
				$file_name = $data['document_number'];
				if ($file->isValid())
				{
					$file_name = 'immigration_' . $file_name . '.' . $file->getClientOriginalExtension();
					$file->storeAs('immigration_documents', $file_name);
					$data['document_file'] = $file_name;
				}
			}

			EmployeeImmigration::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		} else
		{

			return response()->json(['success' => __('You are not authorized')]);
		}
	}

	public function unlink($id)
	{

		$immigration = EmployeeImmigration::findOrFail($id);
		$file_path = $immigration->document_file;

		if ($file_path)
		{
			$file_path = public_path('uploads/immigration_documents/' . $file_path);
			if (file_exists($file_path))
			{
				unlink($file_path);
			}
		}
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
		if ($logged_user->can('modify-details-employee')||$logged_user->id==$id)
		{
			$this->unlink($id);
			EmployeeImmigration::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function download($id)
	{
		$file = EmployeeImmigration::findOrFail($id);

		$file_path = $file->document_file;

		$download_path = public_path("uploads/immigration_documents/" . $file_path);

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
