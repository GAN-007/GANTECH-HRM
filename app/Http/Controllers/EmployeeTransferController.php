<?php

namespace App\Http\Controllers;

use App\Models\Transfer;

class EmployeeTransferController extends Controller {

	//
	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Transfer::with('company', 'to_department', 'from_department')
					->where('employee_id', $employee)->get())
					->setRowId(function ($transfer)
					{
						return $transfer->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('from_department', function ($row)
					{
						return empty($row->from_department->department_name) ? '' : $row->from_department->department_name;
					})
					->addColumn('to_department', function ($row)
					{
						return empty($row->to_department->department_name) ? '' : $row->to_department->department_name;
					})
					->addColumn('action', function ($data) use ($logged_user,$employee)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee') || $logged_user->id == $employee)
						{
							$button = '<button type="button" name="show_transfer" id="' . $data->id . '" class="show_transfer btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
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
			$data = Transfer::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$employee_name = $data->employee->full_name;
			$from_department = $data->from_department->department_name ?? '';
			$to_department = $data->to_department->department_name ?? '';


			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'from_department' => $from_department, 'to_department' => $to_department]);
		}
	}
}
