<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryLoanController extends Controller {

	public function show(Employee $employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee'))
		{
			if (request()->ajax())
			{
				return datatables()->of(SalaryLoan::where('employee_id', $employee->id)->orderByRaw('DATE_FORMAT(first_date, "%y-%m")')->get())
					->setRowId(function ($loan)
					{
						return $loan->id;
					})
					->addColumn('loan_remaining', function ($row)
					{
						return __('Amount Remaining: '). $row->amount_remaining. '<br>' .
							__('Installment Remaining: '). $row->time_remaining ;
					})
					->addColumn('action', function ($data)
					{
						if (auth()->user()->can('modify-details-employee'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="loan_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';

							return $button;
						} else
						{
							return '';
						}
					})
					->rawColumns(['action','loan_remaining'])
					->make(true);
			}
			return view('employee.salary.loan.index',compact('employee'));
		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public function store(Request $request, Employee $employee)
	{
		if (auth()->user()->can('store-details-employee'))
		{
			$validator = Validator::make($request->only('month_year','loan_title', 'loan_amount',
				'reason', 'loan_type'),
				[
					'month_year' => 'required',
					'loan_title' => 'required',
					'loan_type' => 'required',
					'loan_amount' => 'required|numeric',
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
			$data['loan_title'] = $request->loan_title;
			$data['employee_id'] = $employee->id;
			$data['loan_amount'] = $request->loan_amount;
			$data['loan_type'] = $request->loan_type;
			$data['loan_time'] = $request->loan_time;
			$data['time_remaining'] = $request->loan_time;
			$data['amount_remaining'] = $request->loan_amount;

			// $data ['monthly_payable'] = number_format ( ($data['loan_amount'] / $data['loan_time']) ,3);
			$data ['monthly_payable'] = bcdiv(($data['loan_amount'] / $data['loan_time']), 1, 2);
			$data ['reason'] = $request->reason;

			SalaryLoan::create($data);


			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = SalaryLoan::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		if (auth()->user()->can('modify-details-employee'))
		{
			$id = $request->hidden_id;

			$loan = SalaryLoan::findOrFail($id);

			$validator = Validator::make($request->only('month_year','loan_title', 'loan_amount',
				'reason', 'loan_type'),
				[
					'month_year' => 'required',
					'loan_title' => 'required',
					'loan_type' => 'required',
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
			$data['loan_title'] = $request->loan_title;
			$data['loan_type'] = $request->loan_type;
			$data['loan_time'] = $request->loan_time;
			$data['loan_amount'] = $loan->loan_amount;

			$paid_month = $loan->loan_time - $loan->time_remaining;

			$data['time_remaining'] = $data['loan_time'] - $paid_month ;
			// $data ['monthly_payable'] = number_format(($data['loan_amount'] / $data['time_remaining']), 3);
            $data ['monthly_payable'] = bcdiv(($data['loan_amount'] / $data['loan_time']), 1, 2);

			$data ['reason'] = $request->reason;

			SalaryLoan::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


}
