<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Employee;
use App\Models\ExpenseType;
use App\Models\FinanceBankCash;
use App\Models\FinanceDeposit;
use App\Models\FinanceExpense;
use App\Models\FinanceTransaction;
use App\Models\Project;
use App\Models\Task;
use App\Models\Payslip;
use App\Models\TrainingList;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller {

	//
	public function payslip(Request $request)
	{
		$logged_user = auth()->user();
		$companies = company::all();
		$selected_date = empty($request->filter_month_year) ? now()->format('F-Y') : $request->filter_month_year ;

		if ($logged_user->can('report-payslip'))
		{
			if (request()->ajax())
			{
				if (!empty($request->filter_employee))
				{
					$payslips = DB::table('payslips')
						->join('employees', 'payslips.employee_id', '=', 'employees.id')
						->where('employees.id', $request->filter_employee)
						->where('payslips.month_year', $selected_date)
						->select('payslips.id', 'payslips.net_salary', 'payslips.month_year', 'payslips.payment_type', 'payslips.created_at',
							'employees.id', 'employees.first_name', 'employees.last_name'
						)
						->get();
				} elseif (!empty($request->filter_company))
				{
					$payslips = DB::table('payslips')
						->join('employees', 'payslips.employee_id', '=', 'employees.id')
						->where('employees.company_id', $request->filter_company)
						->where('payslips.month_year', $selected_date)
						->select('payslips.id', 'payslips.net_salary', 'payslips.month_year', 'payslips.payment_type', 'payslips.created_at',
							'employees.id', 'employees.first_name', 'employees.last_name'
						)
						->get();
				} else
				{
					$payslips = DB::table('payslips')
						->join('employees', 'payslips.employee_id', '=', 'employees.id')
						->where('payslips.month_year', $selected_date)
						->select('payslips.id', 'payslips.net_salary', 'payslips.month_year', 'payslips.payment_type', 'payslips.created_at',
							'employees.id', 'employees.first_name', 'employees.last_name'
						)
						->get();
				}


				return datatables()->of($payslips)
					->addColumn('employee_name', function ($row)
					{
						return $row->first_name . ' ' . $row->last_name;
					})
					->addColumn('created_at', function ($row)
					{
						return Carbon::parse($row->created_at)->format(env('Date_Format'));
					})
					->make(true);
			}

			return view('report.payslip_report', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}


	public function attendance(Request $request)
	{
		$logged_user = auth()->user();

		$companies = Company::all('id', 'company_name');

		$start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
		$end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';


		if ($logged_user->can('report-attendance'))
		{
			if (request()->ajax())
			{
				if ($request->employee_id)
				{
					$employee = Employee::with(['officeShift', 'employeeAttendance' => function ($query) use ($start_date, $end_date)
					{
						$query->whereBetween('attendance_date', [$start_date, $end_date]);
					},
						'employeeLeave' => function ($query) use ($start_date, $end_date)
						{
							$query->where('start_date', '>=', $start_date)
								->where('end_date', '<=', $end_date);
						},
						'company:id,company_name',
						'company.companyHolidays' => function ($query) use ($start_date, $end_date)
						{
							$query->where('start_date', '>=', $start_date)
								->where('end_date', '<=', $end_date);
						}
					])
						->select('id', 'company_id', 'first_name', 'last_name', 'office_shift_id')->findOrFail($request->employee_id);


					$all_attendances_array = $employee->employeeAttendance->groupBy('attendance_date')->toArray();


					$leaves = $employee->employeeLeave;

					$shift = $employee->officeShift;

					$holidays = $employee->company->companyHolidays;


					$begin = new DateTime($start_date);
					$end = new DateTime($end_date);
					$end->modify('+1 day');

					$interval = DateInterval::createFromDateString('1 day');
					$period = new DatePeriod($begin, $interval, $end);

					$date_range = [];
					foreach ($period as $dt)
					{
						$date_range[] = $dt->format(env('Date_Format'));
					}
				} else
				{
					$date_range = [];
					$employee = null;
					$all_attendances_array = null;
					$leaves = null;
					$holidays = null;
					$shift = null;
				}


				return datatables()->of($date_range)
					->setRowId(function ($row) use ($employee)
					{
						return $employee->id;
					})
					->addColumn('employee_name', function ($row) use ($employee)
					{
						return $employee->full_name;
					})
					->addColumn('company', function ($row) use ($employee)
					{
						return $employee->company->company_name;
					})
					->addColumn('attendance_date', function ($row)
					{
						return Carbon::parse($row)->format(env('Date_Format'));
					})
					->addColumn('attendance_status', function ($row) use ($all_attendances_array, $leaves, $holidays, $shift)
					{
						$day = strtolower(Carbon::parse($row)->format('l')) . '_in';

						if (is_null($shift->$day))
						{
							return __('Off Day');
						}

						if (array_key_exists($row, $all_attendances_array))
						{
							return trans('file.present');
						} else
						{
							foreach ($leaves as $leave)
							{
								if ($leave->start_date <= $row && $leave->end_date >= $row)
								{
									return __('On Leave');
								}
							}
							foreach ($holidays as $holiday)
							{
								if ($holiday->start_date <= $row && $holiday->end_date >= $row)
								{
									return __('On Holiday');
								}
							}

							return trans('Absent');
						}
					})
					->addColumn('clock_in', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$first = current($all_attendances_array[$row])['clock_in'];

							return $first;
						} else
						{
							return '---';
						}
					})
					->addColumn('clock_out', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$last = end($all_attendances_array[$row])['clock_out'];

							return $last;
						} else
						{
							return '---';
						}
					})
					->addColumn('total_work', function ($row) use ($all_attendances_array)
					{
						if (array_key_exists($row, $all_attendances_array))
						{

							$total = 0;
							foreach ($all_attendances_array[$row] as $all_attendance_item)
							{
								sscanf($all_attendance_item['total_work'], '%d:%d', $hour, $min);
								$total += $hour * 60 + $min;
							}
							if ($h = floor($total / 60))
							{
								$total %= 60;
							}

							return sprintf('%02d:%02d', $h, $total);
						} else
						{
							return '---';
						}
					})
					->make(true);
			}

			return view('report.attendance_report', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function training(Request $request)
	{

		$logged_user = auth()->user();

		$companies = Company::all('id', 'company_name');

		$start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
		$end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';


		if ($logged_user->can('report-training'))
		{
			if (request()->ajax())
			{
				if ($request->company_id)
				{
					$trainings = TrainingList::with('company:id,company_name', 'trainer:id,first_name,last_name',
						'TrainingType:id,type', 'employees')
						->where('start_date', '>=', $start_date)
						->where('end_date', '<=', $end_date)
						->where('company_id', $request->company_id)->get();
				} else
				{
					$trainings = array();
				}

				return datatables()->of($trainings)
					->setRowId(function ($training)
					{
						return $training->id;
					})
					->addColumn('TrainingType', function ($row)
					{
						return empty($row->TrainingType->type) ? '' : $row->TrainingType->type;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ' ;
					})
					->addColumn('employee', function ($row)
					{
						$name = $row->employees->pluck('last_name', 'first_name');
						$collection = [];
						foreach ($name as $first => $last)
						{
							$full_name = $first . ' ' . $last;
							array_push($collection, $full_name);
						}

						return $collection;
					})
					->addColumn('trainer', function ($row)
					{
						return $row->trainer->first_name . ' ' . $row->trainer->last_name;
					})
					->addColumn('training_duration', function ($row)
					{
						return $row->start_date . ' ' . trans('file.To') . ' ' . $row->end_date;
					})
					->make(true);
			}

			return view('report.training_report', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function project(Request $request)
	{

		$logged_user = auth()->user();
		$projects = Project::all('id', 'title');


		if ($logged_user->can('report-project'))
		{
			if (request()->ajax())
			{
				if (!empty($request->project_id && $request->project_status))
				{
					$projects = Project::with('assignedEmployees')
						->where('id', $request->project_id)
						->where('project_status', $request->project_status)
						->get();
				} elseif (!empty($request->project_id))
				{
					$projects = Project::with('assignedEmployees')
						->where('id', $request->project_id)
						->get();
				} elseif (!empty($request->project_status))
				{
					$projects = Project::with('assignedEmployees')
						->where('project_status', $request->project_status)
						->get();
				} else
				{
					$projects = Project::with('assignedEmployees')
						->get();
				}


				return datatables()->of($projects)
					->setRowId(function ($project)
					{
						return $project->id;
					})
					->addColumn('summary', function ($row)
					{
						$project = empty($row->title) ? '' : $row->title;

						return '<h6><a href="' . route('projects.show', $row) . '">' . $project . '</a></h6><br>';
					})
					->addColumn('assigned_employee', function ($row)
					{
						$assigned_name = $row->assignedEmployees()->pluck('last_name', 'first_name');
						$collection = [];
						foreach ($assigned_name as $first => $last)
						{
							$full_name = $first . ' ' . $last;
							array_push($collection, $full_name);
						}

						return $collection;
					})
					->rawColumns(['summary'])
					->make(true);
			}

			return view('report.project_report', compact('projects'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function task(Request $request)
	{

		$logged_user = auth()->user();
		$tasks = Task::all('id', 'task_name');


		if ($logged_user->can('report-task'))
		{
			if (request()->ajax())
			{
				if (!empty($request->task_id && $request->task_status))
				{
					$tasks = Task::with('project:id,title', 'assignedEmployees', 'addedBy:id,username')
						->where('id', $request->task_id)
						->where('task_status', $request->task_status)
						->get();
				} elseif (!empty($request->task_id))
				{
					$tasks = Task::with('project:id,title', 'assignedEmployees', 'addedBy:id,username')
						->where('id', $request->task_id)
						->get();
				} elseif (!empty($request->task_status))
				{
					$tasks = Task::with('project:id,title', 'assignedEmployees', 'addedBy:id,username')
						->where('task_status', $request->task_status)
						->get();
				} else
				{
					$tasks = Task::with('project:id,title', 'assignedEmployees', 'addedBy:id,username')
						->get();
				}


				return datatables()->of($tasks)
					->setRowId(function ($task)
					{
						return $task->id;
					})
					->addColumn('task_name', function ($row)
					{
						$task_name = $row->task_name;
						$project = empty($row->project->title) ? '' : $row->project->title;

						return $task_name . '<br><h6><a href="' . route('projects.show', $row->project) . '">' . $project . '</a></h6>';
					})
					->addColumn('created_by', function ($row)
					{
						return $row->addedBy->username;
					})
					->addColumn('assigned_employee', function ($row)
					{
						$assigned_name = $row->assignedEmployees()->pluck('last_name', 'first_name');
						$collection = [];
						foreach ($assigned_name as $first => $last)
						{
							$full_name = $first . ' ' . $last;
							array_push($collection, $full_name);
						}

						return $collection;
					})
					->rawColumns(['task_name'])
					->make(true);
			}

			return view('report.task_report', compact('tasks'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function employees(Request $request)
	{

		$logged_user = auth()->user();
		$companies = company::all('id', 'company_name');


		if ($logged_user->can('report-employee'))
		{
			if (request()->ajax())
			{
				if (!empty($request->designation_id))
				{
					$employees = Employee::with('company:id,company_name', 'user:id,username',
						'department:id,department_name', 'designation:id,designation_name')
						->where('designation_id', $request->designation_id)
                        ->where('is_active',1)->where('exit_date',NULL)
						->get();
				} elseif (!empty($request->department_id))
				{
					$employees = Employee::with('company:id,company_name', 'user:id,username',
						'department:id,department_name', 'designation:id,designation_name')
						->where('department_id', $request->department_id)
                        ->where('is_active',1)->where('exit_date',NULL)
						->get();
				} elseif (!empty($request->company_id))
				{
					$employees = Employee::with('company:id,company_name', 'user:id,username',
						'department:id,department_name', 'designation:id,designation_name')
						->where('company_id', $request->company_id)
                        ->where('is_active',1)->where('exit_date',NULL)
						->get();
				} else
				{
					$employees = Employee::with('company:id,company_name', 'user:id,username',
						'department:id,department_name', 'designation:id,designation_name')
                        ->where('is_active',1)->where('exit_date',NULL)
						->get();
				}


				return datatables()->of($employees)
					->setRowId(function ($employee)
					{
						return $employee->id;
					})
					->addColumn('username', function ($row)
					{
						return $username = $row->user->username ?? '---';

					})
					->addColumn('name', function ($row)
					{
						return $row->full_name ?? '';
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? '';
					})
					->addColumn('department', function ($row)
					{
						return $row->department->department_name ?? '';
					})
					->addColumn('designation', function ($row)
					{
						return $row->designation->designation_name ?? '';
					})
					->make(true);
			}

			return view('report.employees_report', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function account(Request $request)
	{

		$logged_user = auth()->user();
		$accounts = FinanceBankCash::all('id', 'account_name');
		$start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
		$end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';


		if ($logged_user->can('report-account'))
		{
			if (request()->ajax())
			{
				if (!empty($request->account_id))
				{
					$transactions = FinanceTransaction::where('account_id', $request->account_id)
						->where(function ($query) use ($start_date, $end_date)
						{
							$query->whereBetween('deposit_date', [$start_date, $end_date])
								->OrWhereBetween('expense_date', [$start_date, $end_date]);
						})
						->get();
				} else
				{
					$transactions = [];
				}

				return datatables()->of($transactions)
					->setRowId(function ($transaction)
					{
						return $transaction->id;
					})
					->addColumn('transaction_date', function ($row)
					{
						return empty($row->expense_reference) ? $row->deposit_date : $row->expense_date;
					})
					->addColumn('type', function ($row)
					{
						if ($row->category == 'transfer')
						{
							return trans('file.Transfer');
						} else
						{
							return $row->expense_reference ? trans('file.Expense') : trans('file.Income');
						}
					})
					->addColumn('reference_no', function ($row)
					{
						return empty($row->expense_reference) ? $row->deposit_reference : $row->expense_reference;
					})
					->addColumn('credit', function ($row)
					{
						if ($row->deposit_reference)
						{
							return $row->amount;
						} else
						{
							return '0.00';
						}
					})
					->addColumn('debit', function ($row)
					{
						if ($row->expense_reference)
						{
							return $row->amount;
						} else
						{
							return '0.00';
						}
					})
					->make(true);
			}

			return view('report.account_report', compact('accounts'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function expense(Request $request)
	{
		$logged_user = auth()->user();

		$categories = ExpenseType::select('id', 'type')->get();

		$start_date = empty($request->filter_start_date) ? '' : Carbon::parse($request->filter_start_date)->format('Y-m-d');
		$end_date = empty($request->filter_end_date) ? '' : Carbon::parse($request->filter_end_date)->format('Y-m-d') ;



		if ($request->category_id)
		{
			$expenses = FinanceExpense::with('Account:id,account_name', 'Payee:id,payee_name', 'Category:id,type')
				->where('category_id', $request->category_id)
				->whereBetween('expense_date', [$start_date, $end_date])
				->get();
		}
		else {
			$expenses = FinanceExpense::with('Account:id,account_name', 'Payee:id,payee_name', 'Category:id,type')
				->whereBetween('expense_date', [$start_date, $end_date])
				->get();
		}

		if ($logged_user->can('report-expense'))
		{
			if (request()->ajax())
			{
				return datatables()->of($expenses)
					->setRowId(function ($expense)
					{
						return $expense->id;
					})
					->addColumn('account', function ($row)
					{
						return empty($row->Account->account_name) ? '' : $row->Account->account_name;
					})
					->addColumn('payee', function ($row)
					{
						return empty($row->Payee->payee_name) ? '' : $row->Payee->payee_name;
					})
					->addColumn('category', function ($row)
					{
						return empty($row->Category->type) ? '' : $row->Category->type;
					})
					->make(true);
			}

			return view('report.expense_report', compact('categories'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function deposit(Request $request)
	{
		$logged_user = auth()->user();

		$start_date = empty($request->filter_start_date) ? '' : Carbon::parse($request->filter_start_date)->format('Y-m-d');
		$end_date = empty($request->filter_end_date) ? '' : Carbon::parse($request->filter_end_date)->format('Y-m-d') ;

		if ($request->category)
		{
			$deposits = FinanceDeposit::with('Account:id,account_name', 'Payer:id,payer_name')
				->where('category', $request->category)
				->whereBetween('deposit_date', [$start_date, $end_date])
				->get();
		}
		else {
			$deposits = FinanceDeposit::with('Account:id,account_name', 'Payer:id,payer_name')
				->whereBetween('deposit_date', [$start_date, $end_date])
				->get();
		}

		if ($logged_user->can('report-deposit'))
		{
			if (request()->ajax())
			{
				return datatables()->of($deposits)
					->setRowId(function ($deposit)
					{
						return $deposit->id;
					})
					->addColumn('account', function ($row)
					{
						return empty($row->Account->account_name) ? '' : $row->Account->account_name;
					})
					->addColumn('payer', function ($row)
					{
						return empty($row->Payer->payer_name) ? '' : $row->Payer->payer_name;
					})
					->addColumn('category', function ($row)
					{
						return empty($row->category) ? '' : $row->category;
					})
					->make(true);
			}

			return view('report.deposit_report');
		}

		return abort('403', __('You are not authorized'));
	}

	public function transaction(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('report-transaction'))
		{
			if (request()->ajax())
			{
				$start_date = empty($request->filter_start_date) ? '' : Carbon::parse($request->filter_start_date)->format('Y-m-d');
				$end_date = empty($request->filter_end_date) ? '' : Carbon::parse($request->filter_end_date)->format('Y-m-d') ;

				$transactions = FinanceTransaction::with('Account:id,account_name')
					->whereBetween('deposit_date', [$start_date, $end_date])
					->orWhereBetween('expense_date',[$start_date, $end_date])
					->get();
				return datatables()->of($transactions)
					->setRowId(function ($transaction)
					{
						return $transaction->id;
					})
					->addColumn('account', function ($row)
					{
						$button = '<h6><a href="' . route('transactions.show', $row->Account->id) . '">' . $row->Account->account_name . '</a></h6>';

						return $button;
					})
					->addColumn('date', function ($row)
					{
						return empty($row->expense_reference) ? $row->deposit_date : $row->expense_date;
					})
					->addColumn('ref_no', function ($row)
					{
						return empty($row->expense_reference) ? $row->deposit_reference : $row->expense_reference;
					})
					->rawColumns(['account'])
					->make(true);
			}
			return view('report.transaction_report');
		}
		return abort('403', __('You are not authorized'));
	}

    public function pension(Request $request)
    {
        $logged_user = auth()->user();
        $companies = company::all();
        $selected_date = empty($request->filter_month_year) ? now()->format('F-Y') : $request->filter_month_year ;


        if (request()->ajax())
		{
            // $payslips = Payslip::with( ['employee:id,first_name,last_name'])
            //             ->where('month_year',$selected_date)
            //             ->where('pension_type','!=',NULL)
            //             ->get();

            if (!empty($request->filter_employee))
            {
                $payslips = Payslip::with(['employee:id,first_name,last_name'])
                        ->where('employee_id', $request->filter_employee)
                        ->where('month_year', $selected_date)
                        ->where('pension_type','!=',NULL)
                        ->get();
            }
            elseif (!empty($request->filter_company)) {
                $payslips = Payslip::with(['employee:id,first_name,last_name'])
                        ->where('company_id', $request->filter_company)
                        ->where('month_year', $selected_date)
                        ->where('pension_type','!=',NULL)
                        ->get();
            }
            else {
                $payslips = Payslip::with( ['employee:id,first_name,last_name'])
                        ->where('month_year',$selected_date)
                        ->where('pension_type','!=',NULL)
                        ->latest('created_at')
                        ->get();
            }

            return datatables()->of($payslips)
					->setRowId(function ($payslip)
					{
						return $payslip->id;
					})
                    ->addColumn('employee_name', function ($row)
					{
						return $row->employee->full_name;
					})
                    ->addColumn('pension_amount', function ($row)
					{
                        if($row->pension_type=='percentage')
                        {
                            return '% '.$row->pension_amount;
                        }
                        else{
                            return config('variable.currency').' '.$row->pension_amount;
                        }

					})
                    ->addColumn('remaining', function ($row)
					{
                        if ($row->pension_type=='percentage') {
                            $remaining = $row->basic_salary - (($row->basic_salary * $row->pension_amount) /100);
                        } else {
                            $remaining = $row->basic_salary - $row->pension_amount;
                        }

						return config('variable.currency').' '.$remaining;
					})
					->make(true);

        }

        return view('report.pension_report',compact('companies'));
    }
}
