<?php

namespace App\Http\Controllers;

use App\Models\Payslip;

class EmployeePayslipController extends Controller
{
    //
	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee')||$logged_user->id==$employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Payslip::where('employee_id',$employee)->get())
					->setRowId(function ($payslip)
					{
						return $payslip->id;
					})
					->addColumn('action', function ($data) use ($employee,$logged_user)
					{
						if ($logged_user->can('modify-details-employee')||$logged_user->id==$employee)
						{
							// $button  = '<button type="button" name="show" id="' . $employee . '" class="show_payslip btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
							$button  = '<a id="' . $data->payslip_key . '" class="show btn btn-primary btn-sm" href="' . route('payslip_details.show', $data->payslip_key) . '"><i class="dripicons-preview"></i></a>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<a id="' . $data->payslip_key . '" class="download btn btn-info btn-sm" href="' . route('payslip.pdf', $data->payslip_key) . '"><i class="dripicons-download"></i></a>';
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
		return abort('403', __('You are not authorized'));
	}
}
