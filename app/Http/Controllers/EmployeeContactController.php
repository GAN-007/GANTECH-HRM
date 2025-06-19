<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeContactController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @param Employee $employee
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function show(Employee $employee)
	{
		$logged_user = auth()->user();
		$employee_id = $employee->id;

		if ($logged_user->can('view-details-employee')||$logged_user->id==$employee_id)
		{
			if (request()->ajax())
			{
				return datatables()->of(EmployeeContact::where('employee_id', $employee->id)->get())
					->setRowId(function ($contact)
					{
						return $contact->id;
					})
					->addColumn('action', function ($data) use ($logged_user,$employee_id)
					{
						if ($logged_user->can('modify-details-employee')||$logged_user->id==$employee_id)
						{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="contact_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="contact_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

						return $button;
						}
						else
						{
							return '';
						}
					})
					->rawColumns(['action'])
					->make(true);
			}
		}

	}

	/**
	 * @param Request $request
	 * @param $employee
	 * @return \Illuminate\Http\JsonResponse|void
	 */
	public function store(Request $request, $employee)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('store-details-employee')||$logged_user->id==$employee)
		{
			$validator = Validator::make($request->only( 'work_email','relation','personal_email','contact_name',
				'work_phone','home_phone','personal_phone','document_file','country'),
				[
					'personal_email' => 'required|email',
					'relation' => 'required',
					'work_email' => 'email|nullable',
					'contact_name' => 'required',
					'personal_phone' => 'required|numeric',
					'home_phone' => 'nullable|numeric',
					'work_phone' => 'nullable|numeric',
				]
//				,
//				[
//					'personal_email.required' => 'Personal Email is required',
//					'personal_email.email' => 'Incorrect Email format',
//					'relation.required' => 'Please select document Type',
//					'work_email.email' => 'Incorrect Email format',
//					'name.required' => 'Name is required',
//					'personal_phone.required' => 'Personal Phone is required',
//					'personal_phone.numeric' => 'Personal Phone is required',
//					'home_phone.required' => 'Home Phone is required',
//					'home_phone.numeric' => 'Home Phone is required',
//					'work_phone.required' => 'Work Phone is required',
//					'work_phone.numeric' => 'Work Phone is required',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['relation'] =  $request->relation;
			$data['employee_id'] =  $employee;
			$data['is_primary'] = $request->is_primary;
			$data['is_dependent'] = $request->is_dependent;
			$data['contact_name'] = $request->contact_name;
			$data['work_email'] = $request->work_email;
			$data['personal_email'] = $request->personal_email;
			$data['address1'] = $request->address_1;
			$data['address2'] = $request->address_2;
			$data['work_phone'] = $request->work_phone;
			$data['work_phone_ext'] = $request->work_phone_ext;
			$data['personal_phone'] = $request->personal_phone;
			$data['home_phone'] = $request->home_phone;
			$data['city'] = $request->city;
			$data['state'] = $request->state;
			$data['zip'] = $request->zip;
			$data['country_id'] =  $request->country_id;


			EmployeeContact::create($data);

			return response()->json(['success' => __('Data is successfully added')]);
		}

		return abort('403', __('You are not authorized'));

	}

	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = EmployeeContact::findOrFail($id);
			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		$id = $request->hidden_id;
		$logged_user = auth()->user();
		if ($logged_user->can('modify-details-employee')||$logged_user->id==$id)
		{
			$validator = Validator::make($request->only( 'work_email','relation','personal_email','contact_name',
				'work_phone','home_phone','personal_phone','document_file','country'),
				[
					'personal_email' => 'required|email',
					'relation' => 'required',
					'work_email' => 'email',
					'contact_name' => 'required',
					'personal_phone' => 'required|numeric',
					'home_phone' => 'nullable|numeric',
					'work_phone' => 'nullable|numeric',
				]
//				,
//				[
//					'personal_email.required' => 'Personal Email is required',
//					'personal_email.email' => 'Incorrect Email format',
//					'relation.required' => 'Please select document Type',
//					'work_email.email' => 'Incorrect Email format',
//					'name.required' => 'Name is required',
//					'personal_phone.required' => 'Personal Phone is required',
//					'personal_phone.numeric' => 'Personal Phone is required',
//					'home_phone.required' => 'Home Phone is required',
//					'home_phone.numeric' => 'Home Phone is required',
//					'work_phone.required' => 'Work Phone is required',
//					'work_phone.numeric' => 'Work Phone is required',
//				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['relation'] =  $request->relation;
			$data['is_primary'] = $request->is_primary;
			$data['is_dependent'] = $request->is_dependent;
			$data['contact_name'] = $request->contact_name;
			$data['work_email'] = $request->work_email;
			$data['personal_email'] = $request->personal_email;
			$data['address1'] = $request->address_1;
			$data['address2'] = $request->address_2;
			$data['work_phone'] = $request->work_phone;
			$data['work_phone_ext'] = $request->work_phone_ext;
			$data['personal_phone'] = $request->personal_phone;
			$data['home_phone'] = $request->home_phone;
			$data['city'] = $request->city;
			$data['state'] = $request->state;
			$data['zip'] = $request->zip;
			$data['country_id'] =  $request->country_id;

			EmployeeContact::whereId($id)->update($data);

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
		if ($logged_user->can('modify-details-employee')||$logged_user->id==$id)
		{
			EmployeeContact::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

}
