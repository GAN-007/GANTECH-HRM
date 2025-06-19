<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeBankAccountController extends Controller
{
	public function show(Employee $employee)
	{
		$logged_user = auth()->user();
		$employee_id = $employee->id;

		if ($logged_user->can('view-details-employee')||$logged_user->id==$employee_id)
		{
			if (request()->ajax())
			{
				return datatables()->of(EmployeeBankAccount::where('employee_id', $employee->id)->get())
					->setRowId(function ($bank_account)
					{
						return $bank_account->id;
					})
					->addColumn('action', function ($data) use ($logged_user,$employee_id)
					{
						if ($logged_user->can('modify-details-employee')||$logged_user->id==$employee_id)
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="bank_account_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="bank_account_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

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

	public function store(Request $request,$employee)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('store-details-employee')||$logged_user->id==$employee)
		{
			$validator = Validator::make($request->only( 'account_title','account_number','bank_name',
				'bank_code','bank_branch'),
				[
					'account_title' => 'required',
					'bank_branch' => 'required',
					'account_number' =>'required',
					'bank_name' =>'required',
					'bank_code' =>'required'
				]
//				,
//				[
//					'account_title.required' => 'Account Title can not be empty',
//					'account_number.required' => 'Account Number can not be empty',
//					'bank_name.required' => 'Bank Name can not be empty',
//					'bank_branch.required' => 'Bank Branch can not be empty',
//					'bank_code.required' => 'Bank Code can not be empty',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['account_title'] =  $request->account_title;
			$data['employee_id'] = $employee;
			$data['bank_branch'] = $request->bank_branch;
			$data ['account_number'] = $request->account_number;
			$data ['bank_name'] = $request->bank_name;
			$data ['bank_code'] = $request->bank_code;

			EmployeeBankAccount::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = EmployeeBankAccount::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		$id = $request->hidden_id;
		$logged_user = auth()->user();
		if ($logged_user->can('modify-details-employee')||$logged_user->id==$id)
		{

			$validator = Validator::make($request->only( 'account_title','account_number','bank_name',
				'bank_code','bank_branch'),
				[
					'account_title' => 'required',
					'bank_branch' => 'required',
					'account_number' =>'required',
					'bank_name' =>'required',
					'bank_code' =>'required',
				]
//				,
//				[
//					'account_title.required' => 'Account Title can not be empty',
//					'account_number.required' => 'Account Number can not be empty',
//					'bank_name.required' => 'Bank Name can not be empty',
//					'bank_branch.required' => 'Bank Branch can not be empty',
//					'bank_code.required' => 'Bank Code can not be empty',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['account_title'] =  $request->account_title;
			$data['bank_branch'] = $request->bank_branch;
			$data ['account_number'] = $request->account_number;
			$data ['bank_name'] = $request->bank_name;
			$data ['bank_code'] = $request->bank_code;

			EmployeeBankAccount::whereId($id)->update($data);

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
			EmployeeBankAccount::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
