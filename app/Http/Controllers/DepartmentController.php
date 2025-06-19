<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller {

	public function index()
	{
		$companies = company::select('id', 'company_name')->get();

		if (request()->ajax())
		{
			return datatables()->of(department::with('company:id,company_name', 'DepartmentHead:id,first_name,last_name')->get())
				->setRowId(function ($department)
				{
					return $department->id;
				})
				->addColumn('company', function ($row)
				{
					return $row->company->company_name ?? '';
				})
				->addColumn('department_head', function ($row)
				{
					return $row->DepartmentHead->full_name ?? '';
				})
				->addColumn('action', function ($data)
				{
					$button = '';
					if (auth()->user()->can('edit-department'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
					}
					if (auth()->user()->can('delete-department'))
					{
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
					}

					return $button;

				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('organization.department.index', compact('companies'));
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

		if ($logged_user->can('store-department'))
		{
			$validator = Validator::make($request->only('department_name', 'company_id', 'department_head'),
				[
					'department_name' => 'required|unique:departments,department_name,NULL,id,company_id,'.$request->company_id,
					'company_id' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['department_name'] = str_replace('&amp;', '&', $request->department_name);
			$data['company_id'] = $request->company_id;
			if($request->employee_id){
				$data ['department_head'] = $request->employee_id;
			}


			department::create($data);

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
			$data = department::findOrFail($id);
			$employees = Employee::select('id', 'first_name', 'last_name')->where('company_id', $data->company_id)->where('is_active',1)
            ->where('exit_date',NULL)->get();

			return response()->json(['data' => $data, 'employees' => $employees]);
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

		if ($logged_user->can('edit-department'))
		{
			$id = $request->hidden_id;

			$data = $request->only('department_name', 'company_id', 'department_head');


			$validator = Validator::make($request->only('department_name', 'company_id', 'location_id'),
				[
					'department_name' => 'required|unique:departments,department_name,'. $id .',id,company_id,'.$request->company_id,
					'company_id' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['department_name'] = $request->department_name;
			$data['company_id'] = $request->company_id;
			if($request->employee_id)
			{
				$data ['department_head'] = $request->employee_id;
			}
			else{
				$data ['department_head'] = NULL;
			}

			department::whereId($id)->update($data);

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
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-department'))
		{
			department::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-department'))
		{

			$department_id = $request['departmentIdArray'];
			$department = department::whereIntegerInRaw('id', $department_id);
			if ($department->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Department')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected departments can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
