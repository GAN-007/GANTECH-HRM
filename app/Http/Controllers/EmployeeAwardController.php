<?php

namespace App\Http\Controllers;

use App\Models\Award;

class EmployeeAwardController extends Controller {

	//
	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Award::with('award_type')->where('employee_id', $employee)->get())
					->setRowId(function ($award)
					{
						return $award->id;
					})
					->addColumn('awardType', function ($row)
					{
						return empty($row->award_type->award_name) ? '' : $row->award_type->award_name;
					})
					->addColumn('action', function ($data) use ($logged_user,$employee)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee') || $logged_user->id == $employee)
						{
							$button = '<button type="button" name="show_award" id="' . $data->id . '" class="show_award btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						}
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}
		}
	}

	public function show($id)
	{
		if (request()->ajax())
		{
			$data = Award::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$employee_name = $data->employee->full_name;
			$department = $data->department->department_name ?? '';
			$award_name = $data->award_type->award_name ?? '';

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'department' => $department, 'award_name' => $award_name]);
		}
	}
}
