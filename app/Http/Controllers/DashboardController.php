<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Award;
use App\Models\GeneralSetting;
use App\Models\Client;
use App\Models\company;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\EmployeeProject;
use App\Models\EmployeeTask;
use App\Models\EmployeeTicket;
use App\Models\EmployeeWorkExperience;
use App\Models\FinanceDeposit;
use App\Models\FinanceExpense;
use App\Models\Holiday;
use App\Http\traits\AutoUpdateTrait;
use App\Http\traits\CalendarableModelTrait;
use App\Http\traits\ShiftTimingOnDay;
use App\Models\Invoice;
use App\Models\IpSetting;
use App\Models\leave;
use App\Models\LeaveType;
use App\Models\Payslip;
use App\Models\Project;
use App\Models\QualificationEducationLevel;
use App\Models\QualificationLanguage;
use App\Models\QualificationSkill;
use App\Models\SalaryBasic;
use App\Models\status;
use App\Models\SupportTicket;
use App\Models\Trainer;
use App\Models\TrainingType;
use App\Models\TravelType;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class DashboardController extends Controller {

    use CalendarableModelTrait, AutoUpdateTrait;


	public function __construct()
    {
		$this->middleware(['auth']);
	}


	public function index()
	{
        $autoUpdateData = $this->general();
        $alertVersionUpgradeEnable = $autoUpdateData['alertVersionUpgradeEnable'];
        $alertBugEnable =  $autoUpdateData['alertBugEnable'];

		$employees = Employee::with('department:id,department_name', 'designation:id,designation_name')
			->select('id', 'department_id', 'designation_id', 'is_active')
			->where('is_active', '=', 1)->where('is_active',1)
            ->where('exit_date',NULL)->get();

		$departments = $employees->groupBy('department_id');


		$dept_count_array = [];
		$dept_name_array = [];
		$dept_bgcolor_array = [];
		$dept_hover_bgcolor_array = [];

		mt_srand(127);
		if ($departments)
		{
			foreach ($departments as $key => $dept)
			{
				$r = mt_rand(0, 255);
				$g = mt_rand(0, 255);
				$b = mt_rand(0, 255);
				$dept_bgcolor_array[] = 'rgba(' . $r . ',' . $g . ',' . $b . ', 0.7)';
				$dept_hover_bgcolor_array[] = 'rgb(' . $r . ',' . $g . ',' . $b . ')';

				$dept_count_array[] = $dept->count();
				if ($key == null)
				{
					$dept_name_array[] = __('No Department');
				} else
				{
					$dept_name_array[] = $dept->first()->department->department_name;
				}
			}
		}


		$designations = $employees->groupBy('designation_id');

		$desig_count_array = [];
		$desig_name_array = [];
		$desig_bgcolor_array = [];
		$desig_hover_bgcolor_array = [];
		mt_srand(200);
		if ($designations)
		{
			foreach ($designations as $key => $desig)
			{
				$r = mt_rand(0, 255);
				$g = mt_rand(0, 255);
				$b = mt_rand(0, 255);
				$desig_bgcolor_array[] = 'rgba(' . $r . ',' . $g . ',' . $b . ', 0.7)';
				$desig_hover_bgcolor_array[] = 'rgb(' . $r . ',' . $g . ',' . $b . ')';
				$desig_count_array[] = $desig->count();
				if ($key == null)
				{
					$desig_name_array[] = __('No Designation');
				} else
				{
					$desig_name_array[] = $desig->first()->designation->designation_name;
				}
			}
		}

		$attendance_count = Attendance::where('attendance_date', now()->format('Y-m-d'))->distinct('employee_id')->count();


		$leave_count = leave::where('start_date', '<=', now()->format('Y-m-d'))
			->where('end_date', '>=', now()->format('Y-m-d'))->count();

		$total_expense_raw = FinanceExpense::sum('amount');
		$total_deposit_raw = FinanceDeposit::sum('amount');
		$total_salaries_paid = Payslip::sum('net_salary');


		if (config('variable.currency_format') == 'suffix')
		{
			// $total_expense = $total_expense_raw . config('variable.currency');
            $total_expense = number_format((float)$total_expense_raw, 3, '.', '') . config('variable.currency');
			$total_deposit = $total_deposit_raw . config('variable.currency');
			$total_salaries_paid = $total_salaries_paid . config('variable.currency');

		} else
		{
			// $total_expense = config('variable.currency') . $total_expense_raw;
			$total_expense = config('variable.currency') . number_format((float)$total_expense_raw, 3, '.', '');
			$total_deposit = config('variable.currency') . $total_deposit_raw;
			$total_salaries_paid = config('variable.currency') . $total_salaries_paid;
		}


		$months = [];
		for ($i = 0; $i < 6
		; $i++)
		{
			$months[] = date("F-Y", strtotime(date('Y-m-01') . " -$i months"));
		}

		$payslips = Payslip::all('id', 'net_salary', 'month_year');

		for ($i=5; $i >=0 ; $i--) {
			$payslips_last_six_months[$months[$i]] = $payslips->where('month_year', $months[$i])->sum('net_salary');
		}

		$per_month_payment = array_values($payslips_last_six_months);
		$per_month = array_keys($payslips_last_six_months);


		$this_month_payment = $payslips->where('month_year', date('F-Y'))->sum('net_salary');
		$last_six_month_payment = $payslips->whereIn('month_year', $months)->sum('net_salary');


		$companies = company::select('id', 'company_name')->get();
		$leave_types = LeaveType::select('id', 'leave_type', 'allocated_day')->get();
		$travel_types = TravelType::select('id', 'arrangement_type')->get();
		$training_types = TrainingType::select('id', 'type')->get();
		$trainers = Trainer::select('id', 'first_name', 'last_name')->get();
		// $clients = Client::select('id', 'name')->get();
		$clients = Client::select('id', 'first_name','last_name')->get();

		$projects = Project::select('id', 'title', 'project_status')->get();

		$projects_group = $projects->groupBy('project_status');

		$project_count_array = [];
		$project_name_array = [];

		foreach ($projects_group as $key => $item)
		{
			$project_count_array[] = $item->count();
			$project_name_array[] = $key;
		}

		$completed_projects = $projects->where('project_status', 'completed')->count();

		$announcements = Announcement::where('start_date', '<=', now()->format('Y-m-d'))
			->where('end_date', '>=', now()->format('Y-m-d'))->select('id', 'title', 'summary')->get();

		$ticket_count = SupportTicket::where('ticket_status', 'open')->count();


		return view('dashboard.admin_dashboard', compact('employees', 'attendance_count', 'leave_count', 'total_expense_raw', 'total_deposit_raw', 'total_expense', 'total_deposit', 'total_salaries_paid',
			'dept_count_array', 'dept_name_array', 'dept_bgcolor_array', 'dept_hover_bgcolor_array',
			'desig_count_array', 'desig_name_array', 'desig_bgcolor_array', 'desig_hover_bgcolor_array',
			'payslips', 'companies', 'leave_types',
			'training_types', 'trainers', 'travel_types', 'clients', 'projects',
			'project_count_array', 'project_name_array', 'completed_projects',
			'announcements', 'ticket_count', 'per_month', 'per_month_payment', 'months', 'this_month_payment', 'last_six_month_payment',
            'alertBugEnable','alertVersionUpgradeEnable'
        ));
	}

	public function profile()
	{
		$user = auth()->user();

		$employee = Employee::find($user->id);

		if (!$employee)
		{
			if ($user->role_users_id == 3)
			{
				return view('profile.client_profile', compact('user'));
			}

			return view('profile.user_profile', compact('user'));
		} else
		{
			$statuses = status::select('id', 'status_title')->get();

			$countries = DB::table('countries')->select('id', 'name')->get();
			$document_types = DocumentType::select('id', 'document_type')->get();

			$education_levels = QualificationEducationLevel::select('id', 'name')->get();
			$language_skills = QualificationLanguage::select('id', 'name')->get();
			$general_skills = QualificationSkill::select('id', 'name')->get();

			$salary_basics = SalaryBasic::where('employee_id', $employee->id)
                                        ->orderByRaw('DATE_FORMAT(first_date, "%y-%m")')
                                        ->get();

			return view('profile.employee_profile', compact('user', 'employee', 'statuses',
				'countries', 'document_types', 'education_levels', 'language_skills', 'general_skills','salary_basics'));
		}
	}

	public function profile_update(Request $request, $id)
	{

		if (!env('USER_VERIFIED'))
		{
			return redirect()->back()->with('msg', 'This feature is disabled for demo!');
		}
		$user = User::findOrFail($id);

		$validator = Validator::make($request->all(),
			[
				'first_name' => 'required|unique:users,first_name,' . $id,
				'last_name' => 'required|unique:users,last_name,' . $id,
				'username' => 'required|unique:users,username,' . $id,
				'email' => 'required|email|unique:users,email,' . $id,
				'contact_no' => 'required|unique:users,contact_no,' . $id,
				'profile_photo' => 'nullable|image|max:10240|mimes:jpeg,png,jpg,gif',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}
		$photo = $request->profile_photo;


		if (isset($photo))
		{
			$new_user = $request->username;
			if ($photo->isValid())
			{
				$file_name = preg_replace('/\s+/', '', $new_user) . '_' . time() . '.' . $photo->getClientOriginalExtension();
				$photo->storeAs('profile_photos', $file_name);
				$user->profile_photo = $file_name;
			}
		}

		$username = strtolower(trim($request->username));
		$contact_no = $request->contact_no;
		$email = strtolower(trim($request->email));

		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->username = $username;
		$user->contact_no = $contact_no;
		$user->email = $email;

		$user->save();

		if ($user->role_users_id == 3)
		{
			Client::whereId($user->id)->update(['username' => $username, 'contact_no' => $contact_no,
				'email' => $email]);
			$this->setSuccessMessage(__('User Info Updated'));

			return redirect()->route('clientProfile');
		}

		$this->setSuccessMessage(__('User Info Updated'));

		return redirect()->route('profile');
	}

	public function employeeProfileUpdate(Request $request, $id)
	{

		$validator = Validator::make($request->only('first_name', 'last_name', 'email', 'contact_no', 'gender'
		),
			[
				'first_name' => 'required',
				'last_name' => 'required',
				'email' => 'required|email|unique:users,email,' . $id,
				'contact_no' => 'required|numeric|unique:users,contact_no,' . $id,
				'gender' => 'required',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$data = [];
		$data['first_name'] = $request->first_name;
		$data['last_name'] = $request->last_name;
		$data['gender'] = $request->gender;
		$data ['marital_status'] = $request->marital_status;

		$data ['address'] = $request->address;
		$data ['city'] = $request->city;
		$data['state'] = $request->state;
		$data ['country'] = $request->country;
		$data ['zip_code'] = $request->zip_code;


		$data['email'] = strtolower(trim($request->email));
		$data['contact_no'] = $request->contact_no;


		$user = [];

		$user['email'] = strtolower(trim($request->email));
		$user['contact_no'] = $request->contact_no;


		DB::beginTransaction();
			try
			{
				User::whereId($id)->update($user);

				employee::whereId($id)->update($data);

				DB::commit();
			} catch (Exception $e)
			{
				DB::rollback();
				return response()->json(['error' =>  $e->getMessage()]);
			} catch (Throwable $e)
			{
				DB::rollback();
				return response()->json(['error' => $e->getMessage()]);
			}

			return response()->json(['success' => __('Data Added successfully.')]);
	}


	public function change_password(Request $request, $id)
	{

		if (!env('USER_VERIFIED'))
		{
			return redirect()->back()->with('msg', 'This feature is disabled for demo!');
		}

		$user = User::findOrFail($id);

		$validator = Validator::make($request->all(),
			[
				'password' => 'required|min:4|confirmed',
			]
		);


		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}


		$user->password = bcrypt($request->password);
		$user->save();

		$this->setSuccessMessage(__('Password has been changed'));

		return redirect('login')->with(Auth::logout());

	}


	protected function getIp($ip)
    {
        $data  = [];
        $data  = str_split($ip);
        $length= strlen($ip).'<br>';

        $count = 0;
        $get_ip ="";
        for ($i=0; $i < $length ; $i++) {
            if ($data[$i]=='.') {
                $count++;
            }
            $get_ip .= $data[$i];
            if ($count==3) {
                break;
            }
        }

        return $get_ip;
    }


	public function employeeDashboard(Request $request)
	{
        // return EmployeeWorkExperience::where('employee_id', 52)->get();

		$user = auth()->user();
		$employee = Employee::with('department:id,department_name', 'officeShift')->findOrFail($user->id);
		$current_day_in = strtolower(Carbon::now()->format('l')) . '_in';
		$current_day_out = strtolower(Carbon::now()->format('l')) . '_out';

		$shift_in = $employee->officeShift->$current_day_in;
		$shift_out = $employee->officeShift->$current_day_out;
		$shift_name = $employee->officeShift->shift_name;

		$announcements = Announcement::where('start_date', '<=', now()->format('Y-m-d'))
			->where('end_date', '>=', now()->format('Y-m-d'))->where('is_notify', 1)->select('id', 'title', 'summary')->latest()->take(3)->get();

		$employee_award_count = Award::where('employee_id', $user->id)->count();

		$holidays = Holiday::where('is_publish', 1)
			->where('end_date', '>=', now()->format('Y-m-d'))
			->where('company_id', $employee->company_id)
			->select('id', 'event_name', 'start_date', 'end_date')->latest()->take(3)->get();

		$leave_types = LeaveType::select('id', 'leave_type', 'allocated_day')->get();
		$travel_types = TravelType::select('id', 'arrangement_type')->get();


		$assigned_projects = EmployeeProject::with(['assignedProjects' => function ($query) use ($employee)
		{
			$query->where('project_status', '!=', 'completed')->select('id', 'title', 'project_status');
		},])
			->where('employee_id', $employee->id)->get();
		// $assigned_projects_count = $assigned_projects->count();
        $assigned_projects_count = 0;
        foreach($assigned_projects as $task){
            if (count($task->assignedProjects)!=0) {
                $assigned_projects_count++;
            }
        }


		$assigned_tasks = EmployeeTask::with(['assignedTasks' => function ($query) use ($employee)
		{
			$query->where('task_status', '!=', 'completed')->select('id', 'task_name', 'task_status');
		},])
           ->where('employee_id', $employee->id)->get();

		// $assigned_tasks_count = $assigned_tasks->count();
        $assigned_tasks_count = 0;
        foreach($assigned_tasks as $task){
            if (count($task->assignedTasks)!=0) {
                $assigned_tasks_count++;
            }
        }


		$assigned_tickets = EmployeeTicket::with(['assignedTickets' => function ($query) use ($employee)
		{
			$query->where('ticket_status', '=', 'open')->select('id', 'subject', 'ticket_code', 'ticket_status');
		},])
			->where('employee_id', $employee->id)->get();

        //$assigned_tickets_count = $assigned_tickets->count();
        $assigned_tickets_count = 0;
        foreach($assigned_tickets as $ticket){
            if (count($ticket->assignedTickets)!=0) {
                $assigned_tickets_count++;
            }
        }



		//checking if emoloyee has attendance on current day
		$employee_attendance = Attendance::where('attendance_date', now()->format('Y-m-d'))
				->where('employee_id', $employee->id)->orderBy('id', 'desc')->first() ?? null;

		//IP Check

        $ip_setting = IpSetting::get();

        if (count($ip_setting)==0) {
            $ipCheck =  false;
        }else {
            foreach ($ip_setting as $key => $value) {
                $db_ip = $this->getIp($value->ip_address);

                $client_ip = $this->getIp($request->ip());

                if ($db_ip==$client_ip) {
                    $ipCheck =  true;
                    break;
                }else {
                    $ipCheck =  false;
                }
            }
        }
		return view('dashboard.employee_dashboard', compact('user', 'employee', 'employee_attendance',
			'shift_in', 'shift_out', 'shift_name', 'announcements',
			'employee_award_count', 'holidays', 'leave_types', 'travel_types',
			'assigned_projects', 'assigned_projects_count',
			'assigned_tasks', 'assigned_tasks_count', 'assigned_tickets', 'assigned_tickets_count','ipCheck'));
	}



	public function clientDashboard()
	{
        // Auth::logout();
        // return redirect()->back();

		$user = auth()->user();

		$client = Client::with('invoices', 'projects')->findOrFail($user->id);

		$paid_invoices = $client->invoices->where('status', 1);

		$paid_invoice_count = $paid_invoices->count();

		$unpaid_invoices = $client->invoices->where('status', 0);

		$unpaid_invoice_count = $unpaid_invoices->count();

		$completed_project_count = $client->projects->where('project_status', 'completed')->count();

		$in_progress_project_count = $client->projects->where('project_status', 'in_progress')->count();

		$invoice_paid_amount_raw = $paid_invoices->sum('grand_total');

		$invoice_unpaid_amount_raw = $unpaid_invoices->sum('grand_total');

		if (config('variable.currency_format') == 'suffix')
		{
			$invoice_paid_amount = $invoice_paid_amount_raw . config('variable.currency');
			$invoice_unpaid_amount = $invoice_unpaid_amount_raw . config('variable.currency');

		} else
		{
			$invoice_paid_amount = config('variable.currency') . $invoice_paid_amount_raw;
			$invoice_unpaid_amount = config('variable.currency') . $invoice_unpaid_amount_raw;
		}


		return view('dashboard.client_dashboard', compact('user', 'client',
			'paid_invoice_count', 'unpaid_invoice_count', 'completed_project_count', 'in_progress_project_count',
			'invoice_paid_amount', 'invoice_unpaid_amount'));
	}

	public function clientProfile()
	{
		$user = auth()->user();
		if ($user->role_users_id == 3)
		{
			return view('profile.client_profile', compact('user'));
		}

		return redirect('profile');
	}
}


