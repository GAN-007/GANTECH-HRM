<?php

namespace App\Http\Controllers;

use App\Models\Promotion;

class EmployeePromotionController extends Controller {

	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Promotion::where('employee_id', $employee)->get())
					->setRowId(function ($promotion)
					{
						return $promotion->id;
					})
					->addColumn('action', function ($data) use ($employee,$logged_user)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee') || $logged_user->id == $employee)
						{
							$button = '<button type="button" name="show_promotion" id="' . $data->id . '" class="show_promotion btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
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
			$data = Promotion::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$employee_name = $data->employee->full_name;

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name]);
		}
	}
}
