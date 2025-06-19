<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeQualificaiton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeQualificationController extends Controller
{
	public function show(Employee $employee)
	{
		$logged_user = auth()->user();
		$employee_id = $employee->id;

		if ($logged_user->can('view-details-employee')||$logged_user->id==$employee_id)
		{
			if (request()->ajax())
			{
				return datatables()->of(EmployeeQualificaiton::with('EducationLevel')->where('employee_id', $employee->id)->get())
					->setRowId(function ($qualification)
					{
						return $qualification->id;
					})
					->addColumn('education_level', function ($row)
					{
						return $row->EducationLevel->name;
					})
					->addColumn('action', function ($data) use ($logged_user,$employee_id)
					{
						if ($logged_user->can('modify-details-employee')||$logged_user->id==$employee_id)
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="qualification_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="qualification_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

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
			$validator = Validator::make($request->only( 'institution_name','education_level_id','from_date','to_date',
				'description','language_skill_id','general_skill_id'),
				[
					'institution_name' => 'required',
					'education_level_id' => 'required',
					'from_date' =>'required',
					'to_date' =>'required',
				]
//				,
//				[
//					'institution_name.required' => 'Institution Name can not be empty',
//					'from_date.required' => 'From Date can not be empty',
//					'to_date.required' => 'To Date can not be empty',
//					'education_level_id.required' => 'Please select Education Level',
//					]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['institution_name'] =  $request->institution_name;
			$data['employee_id'] = $employee;
			$data['education_level_id'] = $request->education_level_id;
			$data['language_skill_id'] = $request->language_skill_id;
			$data ['general_skill_id'] = $request->general_skill_id;
			$data ['from_year'] = $request->from_date;
			$data ['to_year'] = $request->to_date;
			$data ['description'] = $request->description;

			EmployeeQualificaiton::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return abort('403', __('You are not authorized'));

	}

	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = EmployeeQualificaiton::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		$id = $request->hidden_id;
		$logged_user = auth()->user();
		if ($logged_user->can('modify-details-employee')||$logged_user->id==$id)
		{
			$validator = Validator::make($request->only( 'institution_name','education_level_id','from_date','to_date',
				'description','language_skill_id','general_skill_id'),
				[
					'institution_name' => 'required',
					'education_level_id' => 'required',
					'from_date' =>'required',
					'to_date' =>'required',
				]
//				,
//				[
//					'institution_name.required' => 'Institution Name can not be empty',
//					'from_date.required' => 'From Date can not be empty',
//					'to_date.required' => 'To Date can not be empty',
//					'education_level_id.required' => 'Please select Education Level',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['institution_name'] =  $request->institution_name;
			$data['education_level_id'] = $request->education_level_id;
			$data['language_skill_id'] = $request->language_skill_id;
			$data ['general_skill_id'] = $request->general_skill_id;
			$data ['from_year'] = $request->from_date;
			$data ['to_year'] = $request->to_date;
			$data ['description'] = $request->description;


			EmployeeQualificaiton::find($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		} else
		{

			return abort('403', __('You are not authorized'));
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
			EmployeeQualificaiton::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}

}
