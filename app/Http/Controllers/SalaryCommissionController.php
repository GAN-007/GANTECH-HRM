<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryCommissionController extends Controller
{

	public function show(Employee $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee'))
		{
			if (request()->ajax())
			{
				return datatables()->of(SalaryCommission::where('employee_id', $employee->id)->orderByRaw('DATE_FORMAT(first_date, "%y-%m")')->get())
					->setRowId(function ($commission)
					{
						return $commission->id;
					})
					->addColumn('action', function ($data)
					{
						if (auth()->user()->can('modify-details-employee'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="commission_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="commission_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

							return $button;
						} else
						{
							return '';
						}
					})
					->rawColumns(['action'])
					->make(true);
			}
			return view('employee.salary.commission.index',compact('employee'));
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function store(Request $request,Employee $employee)
	{
		//return response()->json($request->month_year);

		if (auth()->user()->can('store-details-employee'))
		{
			$validator = Validator::make($request->only('month_year', 'commission_title','commission_amount'
				),
				[
					'month_year' 	   => 'required',
					'commission_title' => 'required',
					'commission_amount'=> 'required|numeric',
				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$first_date = date('Y-m-d', strtotime('first day of ' . $request->month_year));

			$data = [];
			$data['month_year'] = $request->month_year;
			$data['first_date'] = $first_date;
			$data['commission_title'] =  $request->commission_title;
			$data['employee_id'] = $employee->id;
			$data['commission_amount'] = $request->commission_amount;

			SalaryCommission::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = SalaryCommission::findOrFail($id);
			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{


		if (auth()->user()->can('modify-details-employee'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('month_year','commission_title','commission_amount'),
				[
					'month_year' => 'required',
					'commission_title' => 'required',
					'commission_amount' => 'required|numeric',
				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$first_date = date('Y-m-d', strtotime('first day of ' . $request->month_year));

			$data = [];
			$data['month_year'] = $request->month_year;
			$data['first_date'] = $first_date;
			$data['commission_title'] =  $request->commission_title;
			$data['commission_amount'] = $request->commission_amount;

			SalaryCommission::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function destroy($id)
	{
		if (auth()->user()->can('modify-details-employee'))
		{
			SalaryCommission::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
