<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryOtherPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryOtherPaymentController extends Controller
{
	public function show(Employee $employee)
	{
		if (auth()->user()->can('view-details-employee'))
		{
			if (request()->ajax())
			{
				return datatables()->of(SalaryOtherPayment::where('employee_id', $employee->id)->orderByRaw('DATE_FORMAT(first_date, "%y-%m")')->get())
					->setRowId(function ($other_payment)
					{
						return $other_payment->id;
					})
					->addColumn('action', function ($data)
					{
						if (auth()->user()->can('modify-details-employee'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="other_payment_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="other_payment_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

							return $button;
						} else
						{
							return '';
						}
					})
					->rawColumns(['action'])
					->make(true);
			}
			return view('employee.salary.other_payment.index',compact('employee'));
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function store(Request $request,Employee $employee)
	{
		if (auth()->user()->can('store-details-employee'))
		{
			$validator = Validator::make($request->only('month_year','other_payment_title','other_payment_amount',
				'is_taxable'),
				[
					'month_year' 		  => 'required',
					'other_payment_title' => 'required',
					'other_payment_amount'=> 'required|numeric',
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
			$data['other_payment_title'] =  $request->other_payment_title;
			$data['employee_id'] = $employee->id;
			$data['other_payment_amount'] = $request->other_payment_amount;

			SalaryOtherPayment::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = SalaryOtherPayment::findOrFail($id);
			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		if (auth()->user()->can('modify-details-employee'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('month_year','other_payment_title','other_payment_amount',
				'is_taxable'),
				[
					'month_year' => 'required',
					'other_payment_title' => 'required',
					'other_payment_amount' => 'required|numeric',
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
			$data['other_payment_title'] =  $request->other_payment_title;
			$data['other_payment_amount'] = $request->other_payment_amount;

			SalaryOtherPayment::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	public function destroy($id)
	{
		if (auth()->user()->can('modify-details-employee'))
		{
			SalaryOtherPayment::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
