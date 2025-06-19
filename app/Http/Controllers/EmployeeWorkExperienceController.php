<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeWorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeWorkExperienceController extends Controller
{
	public function show(Employee $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee')||$logged_user->id==$employee->id)
		{
			if (request()->ajax())
			{
                $work_experience = EmployeeWorkExperience::where('employee_id', $employee->id)->get();
				return datatables()->of($work_experience)
					->setRowId(function ($work_experience)
					{
						return $work_experience->id;
					})
					->addColumn('action', function ($data) use ($logged_user, $employee)
					{
						if ($logged_user->can('modify-details-employee')||$logged_user->id==$employee->id){
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="work_experience_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="work_experience_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
							return $button;
						} else
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
			$validator = Validator::make($request->only( 'company_name','from_date','to_date',
				'description','post'),
				[
					'company_name' => 'required',
					'post' => 'required',
					'from_date' =>'required',
					'to_date' =>'required',
				]
//				,
//				[
//					'company_name.required' => 'Company Name can not be empty',
//					'from_date.required' => 'From Date can not be empty',
//					'to_date.required' => 'To Date can not be empty',
//					'post.required' => 'Post can not be empty',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['company_name'] =  $request->company_name;
			$data['employee_id'] = $employee;
			$data['post'] = $request->post;
			$data ['from_year'] = $request->from_date;
			$data ['to_year'] = $request->to_date;
			$data ['description'] = $request->description;

			EmployeeWorkExperience::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = EmployeeWorkExperience::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		$id = $request->hidden_id;
		$logged_user = auth()->user();
		if ($logged_user->can('modify-details-employee')||$logged_user->id==$id)
		{
			$validator = Validator::make($request->only( 'company_name','from_date','to_date',
				'description','post'),
				[
					'company_name' => 'required',
					'post' => 'required',
					'from_date' =>'required',
					'to_date' =>'required',
				]
//				,
//				[
//					'company_name.required' => 'Company Name can not be empty',
//					'from_date.required' => 'From Date can not be empty',
//					'to_date.required' => 'To Date can not be empty',
//					'post.required' => 'Post can not be empty',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['company_name'] =  $request->company_name;
			$data['post'] = $request->post;
			$data ['from_year'] = $request->from_date;
			$data ['to_year'] = $request->to_date;
			$data ['description'] = $request->description;

			EmployeeWorkExperience::find($id)->update($data);

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
			EmployeeWorkExperience::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);

		}
		return response()->json(['success' => __('You are not authorized')]);
	}

}
