<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryDeduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryDeductionController extends Controller
{

	public function show(Employee $employee)
	{
		$logged_user = auth()->user();

		if (auth()->user()->can('view-details-employee'))
		{
			if (request()->ajax())
			{
				return datatables()->of(SalaryDeduction::where('employee_id', $employee->id)->orderByRaw('DATE_FORMAT(first_date, "%y-%m")')->get())
					->setRowId(function ($deduction)
					{
						return $deduction->id;
					})
					->addColumn('action', function ($data)
					{
						if (auth()->user()->can('modify-details-employee'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="deduction_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="deduction_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

							return $button;
						} else
						{
							return '';
						}
					})
					->rawColumns(['action'])
					->make(true);
			}
			return view('employee.salary.deduction.index',compact('employee'));
		}
		return response()->json(['success' => __('You are not authorized')]);

	}

	public function store(Request $request,Employee $employee)
	{
		if (auth()->user()->can('store-details-employee'))
		{
			$validator = Validator::make($request->only('month_year','deduction_title', 'deduction_amount',
				'deduction_type'),
				[
					'month_year' => 'required',
					'deduction_title' => 'required',
					'deduction_amount' => 'required|numeric',
					'deduction_type' => 'required',
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
			$data['deduction_title'] = $request->deduction_title;
			$data['employee_id'] = $employee->id;
			$data['deduction_amount'] = $request->deduction_amount;
			$data ['deduction_type'] = $request->deduction_type;


			SalaryDeduction::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


		public function edit($id)
	{
		if(request()->ajax())
		{
			$data = SalaryDeduction::findOrFail($id);
			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		if (auth()->user()->can('modify-details-employee'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('month_year', 'deduction_title','deduction_amount',
				'deduction_type'),
				[
					'month_year' => 'required',
					'deduction_title' => 'required',
					'deduction_amount' => 'required|numeric',
					'deduction_type' =>'required',
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
			$data['deduction_title'] =  $request->deduction_title;
			$data['deduction_amount'] = $request->deduction_amount;
			$data ['deduction_type'] = $request->deduction_type;

			SalaryDeduction::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if (auth()->user()->can('modify-details-employee'))
		{

			SalaryDeduction::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
