<?php

namespace App\Http\Controllers;

use App\Models\Warning;

class EmployeeWarningController extends Controller {

	//
	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Warning::where('warning_to', $employee)->get())
					->setRowId(function ($warnings)
					{
						return $warnings->id;
					})
					->addColumn('action', function ($data) use ($employee,$logged_user)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee')|| $logged_user->id == $employee)
						{
							$button = '<button type="button" name="show_warning" id="' . $data->id . '" class="show_warning btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
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
			$data = Warning::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$warning_to = $data->WarningTo->full_name;
			$warning_type_name = $data->WarningType->warning_title;

			return response()->json(['data' => $data, 'warning_to_employee' => $warning_to, 'company_name' => $company_name, 'warning_type_name' => $warning_type_name]);
		}
	}
}
