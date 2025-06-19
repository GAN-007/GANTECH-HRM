<?php

namespace App\Http\Controllers;

use App\Models\Travel;

class EmployeeTravelController extends Controller {

	//
	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Travel::where('employee_id', $employee)->get())
					->setRowId(function ($travel)
					{
						return $travel->id;
					})
					->addColumn('action', function ($data) use ($employee,$logged_user)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee') || $logged_user->id == $employee)
						{
							$button = '<button type="button" name="show_travel" id="' . $data->id . '" class="show_travel btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
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
			$data = Travel::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$employee_name = $data->employee->full_name;
			$arrangement_name = $data->TravelType->arrangement_type ?? '';

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'arrangement_name' => $arrangement_name]);
		}
	}
}
