<?php

namespace App\Http\Controllers;

use App\Models\leave;

class EmployeeLeaveController extends Controller {

	//

	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(leave::with('department', 'LeaveType')->where('employee_id', $employee)->get())
					->setRowId(function ($leave)
					{
						return $leave->id;
					})
					->addColumn('leave_type', function ($row)
					{
						return empty($row->LeaveType->leave_type) ? '' : $row->LeaveType->leave_type;
					})
					->addColumn('department', function ($row)
					{
						return empty($row->department->department_name) ? '' : $row->department->department_name;
					})
					->addColumn('action', function ($data) use ($employee,$logged_user)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee') || $logged_user->id == $employee)
						{
							$button = '<button type="button" name="show_leave" id="' . $data->id . '" class="show_leave btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
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
			$data = leave::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$department = $data->department->department_name ?? '';
			$leave_type_name = $data->LeaveType->leave_type ?? '';
			$employee_name = $data->employee->full_name;
			$start_date_name = $data->start_date;
			$end_date_name = $data->end_date;

			return response()->json(['data' => $data, 'company_name' => $company_name, 'employee_name' => $employee_name, 'department' => $department, 'leave_type_name' => $leave_type_name,
				'start_date_name' => $start_date_name, 'end_date_name' => $end_date_name]);
		}
	}

}
