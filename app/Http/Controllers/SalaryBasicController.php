<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryBasic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryBasicController extends Controller
{
    public function show(Employee $employee)
    {
        $logged_user = auth()->user();
        if ($logged_user->can('view-details-employee'))
        {
            if (request()->ajax())
            {
                $salary_basics = SalaryBasic::with('payslipMonthYear')
                                            ->where('employee_id', $employee->id)
                                            ->orderByRaw('DATE_FORMAT(first_date, "%y-%m")')
                                            ->get();

                return datatables()->of($salary_basics)
                ->setRowId(function ($row)
                {
                    return $row->id;
                })
                ->addColumn('action', function ($row)
                {
                    if (auth()->user()->can('modify-details-employee'))
                    {
                        $paid = 0;
                        foreach ($row->payslipMonthYear as $key => $value) {
                            if ($row->month_year == $value->month_year) {
                                $paid = 1;
                            }
                        }
                        if ($paid==1) {
                            $button = '<button type="button" name="edit" data-id="'.$row->id.'" disabled class="salary_basic_edit btn btn-primary btn-sm" title="Can not edit"><i class="dripicons-pencil"></i></button>';
                            $button .= '&nbsp;&nbsp;';
                            $button .= '<button type="button" name="delete" data-id="'.$row->id.'" disabled class="salary_basic_delete btn btn-danger btn-sm" title="Can not delete"><i class="dripicons-trash"></i></button>';
                        }else {
                            $button = '<button type="button" name="edit" data-id="'.$row->id.'" class="salary_basic_edit btn btn-primary btn-sm" title="Edit"><i class="dripicons-pencil"></i></button>';
                            $button .= '&nbsp;&nbsp;';
                            $button .= '<button type="button" name="delete" data-id="'.$row->id.'" class="salary_basic_delete btn btn-danger btn-sm" title="Delete"><i class="dripicons-trash"></i></button>';
                        }

                        return $button;
                    } else
                    {
                        return '';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return view('employee.salary.basic.index',compact('employee'));
        }
        return response()->json(['success' => __('You are not authorized')]);

    }


    public function store(Request $request, Employee $employee)
    {
        $logged_user = auth()->user();
		if ($logged_user->can('store-details-employee'))
		{
            $validator = Validator::make($request->only('month_year', 'payslip_type','basic_salary'),[
                'month_year' => 'required',
                'payslip_type' => 'required',
                'basic_salary' => 'required|numeric',
            ]);

            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $check_month_year = SalaryBasic::where('month_year',$request->month_year)->where('employee_id',$employee->id)->exists();
            if ($check_month_year==true) {
                return response()->json(['check_month_year' => "Salary has already been assigned for this month."]);
            }

            $first_date = date('Y-m-d', strtotime('first day of ' . $request->month_year));

            $salary_basic = new SalaryBasic();
            $salary_basic->employee_id  = $employee->id;
            $salary_basic->month_year   = $request->month_year;
            $salary_basic->first_date   = $first_date;
            $salary_basic->payslip_type = $request->payslip_type;
            $salary_basic->basic_salary = $request->basic_salary;
            $salary_basic->save();

            $salary_latest = SalaryBasic::where('employee_id',$salary_basic->employee_id)->select('payslip_type','basic_salary')->orderByRaw('DATE_FORMAT(first_date, "%y-%m") DESC')->first();
            $employee = Employee::find($salary_basic->employee_id);
            $employee->payslip_type = $salary_latest->payslip_type;
            $employee->basic_salary = $salary_latest->basic_salary; //Alawys Updated Last Month-Year wise
            $employee->update();

            return response()->json(['success' => __('Data Added successfully.')]);
        }
        return response()->json(['success' => __('You are not authorized')]);
    }

    public function edit($id)
    {
        if (request()->ajax())
		{
			$data = SalaryBasic::findOrFail($id);

			return response()->json(['data' => $data]);
		}
    }


    public function update(Request $request)
    {
        $logged_user = auth()->user();

		if ($logged_user->can('modify-details-employee'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('month_year', 'payslip_type','basic_salary'),[
                'month_year' => 'required',
                'payslip_type' => 'required',
                'basic_salary' => 'required|numeric',
            ]);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

            $check_month_year = SalaryBasic::where('month_year',$request->month_year)
                                    ->where('employee_id',$request->employee_id)
                                    ->where('id','!=',$id)
                                    ->exists();

            if ($check_month_year==true) {
                return response()->json(['check_month_year' => "Salary has already been assigned for this month."]);
            }

            $first_date = date('Y-m-d', strtotime('first day of ' . $request->month_year));

            $salary_basic = SalaryBasic::find($id);
            $salary_basic->month_year   = $request->month_year;
            $salary_basic->first_date   = $first_date;
            $salary_basic->payslip_type = $request->payslip_type;
            $salary_basic->basic_salary = $request->basic_salary;
            $salary_basic->update();

            $salary_latest = SalaryBasic::where('employee_id',$salary_basic->employee_id)->select('payslip_type','basic_salary')->orderByRaw('DATE_FORMAT(first_date, "%y-%m") DESC')->first();

            $employee = Employee::find($salary_basic->employee_id);
            $employee->payslip_type = $salary_latest->payslip_type;
            $employee->basic_salary = $salary_latest->basic_salary; //Alawys Updated Last Month-Year wise
            $employee->update();

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
    }


    public function destroy($id)
    {
        $logged_user = auth()->user();

		if ($logged_user->can('modify-details-employee'))
		{
			$salary_basic = SalaryBasic::find($id);
            $salary_basic->delete();

            //Extra
            $salary_basic_latest = SalaryBasic::where('employee_id',$salary_basic->employee_id)->select('payslip_type','basic_salary')->orderByRaw('DATE_FORMAT(first_date, "%y-%m") DESC')->first();
            $employee = Employee::find($salary_basic->employee_id);
            $employee->payslip_type = $salary_basic_latest->payslip_type;
            $employee->basic_salary = $salary_basic_latest->basic_salary; //Alawys Updated Last Month-Year wise
            $employee->update();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
    }
}
