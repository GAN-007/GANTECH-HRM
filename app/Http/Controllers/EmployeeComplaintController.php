<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class EmployeeComplaintController extends Controller
{
    //
	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee')||$logged_user->id==$employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(Complaint::with('complaint_from_employee','complaint_against_employee')
				->where('complaint_from', $employee)->get())
					->setRowId(function ($complaints)
					{
						return $complaints->id;
					})
					->addColumn('complaint_from', function ($row)
					{
						return $row->complaint_from_employee->full_name;
					})
					->addColumn('complaint_against', function ($row)
					{
						return	$row->complaint_against_employee->full_name;
					})
					->addColumn('action', function ($data) use ($logged_user,$employee)
					{
						$button = '';
						if(auth()->user()->can('view-details-employee') || $logged_user->id == $employee)
						{
							$button = '<button type="button" name="show_complaint" id="' . $data->id . '" class="show_complaint btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
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
		if(request()->ajax())
		{
			$data = Complaint::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$complaint_from = $data->complaint_from_employee->full_name;
			$complaint_against = $data->complaint_against_employee->full_name;

			return response()->json(['data' => $data,'complaint_from'=>$complaint_from,'company_name'=>$company_name,'complaint_against'=>$complaint_against]);
		}
	}
}
