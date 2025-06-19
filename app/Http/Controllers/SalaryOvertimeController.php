<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryOvertime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SalaryOvertimeController extends Controller {

	public function show(Employee $employee)
	{
		if (auth()->user()->can('view-details-employee'))
		{
			if (request()->ajax())
			{
				return datatables()->of(SalaryOvertime::where('employee_id', $employee->id)->orderByRaw('DATE_FORMAT(first_date, "%y-%m")')->get())
					->setRowId(function ($overtime)
					{
						return $overtime->id;
					})
					->addColumn('action', function ($data)
					{
						if (auth()->user()->can('modify-details-employee'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="overtime_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="overtime_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

							return $button;
						} else
						{
							return '';
						}
					})
					->rawColumns(['action'])
					->make(true);
			}
			return view('employee.salary.overtime.index',compact('employee'));
		}

		return response()->json(['success' => __('You are not authorized')]);

	}

	public function store(Request $request, Employee $employee)
	{
		if (auth()->user()->can('store-details-employee'))
		{
			$validator = Validator::make($request->only('month_year','overtime_title',
				'no_of_days', 'overtime_hours', 'overtime_rate'
			),
				[
					'month_year' => 'required',
					'overtime_title' => 'required',
					'overtime_hours' => 'required',
					'no_of_days' => 'required',
					'overtime_rate' => 'required|numeric',
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
			$data['overtime_title'] = $request->overtime_title;
			$data['employee_id'] = $employee->id;
			$data['overtime_hours'] = $request->overtime_hours;
			$data['overtime_rate'] = $request->overtime_rate;
			$data['no_of_days'] = $request->no_of_days;

			$overtime_amount = ($request->overtime_hours) * ($request->overtime_rate);

			$data['overtime_amount'] = $overtime_amount;

			SalaryOvertime::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = SalaryOvertime::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	public function update(Request $request)
	{
		if (auth()->user()->can('modify-details-employee'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('month_year','overtime_title',
				'no_of_days', 'overtime_hours', 'overtime_rate'
			),
				[
					'month_year' => 'required',
					'overtime_title' => 'required',
					'overtime_hours' => 'required',
					'no_of_days' => 'required',
					'overtime_rate' => 'required|numeric',
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
			$data['overtime_title'] = $request->overtime_title;
			$data['overtime_hours'] = $request->overtime_hours;
			$data['overtime_rate'] = $request->overtime_rate;
			$data['no_of_days'] = $request->no_of_days;

			$overtime_amount = ($request->overtime_hours) * ($request->overtime_rate);

			$data['overtime_amount'] = $overtime_amount;

			SalaryOvertime::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (auth()->user()->can('modify-details-employee'))
		{

			SalaryOvertime::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
