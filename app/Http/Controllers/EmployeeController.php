<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\department;
use App\Models\designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Http\traits\LeaveTypeDataManageTrait;
use App\Imports\UsersImport;
use App\Models\office_shift;
use App\Models\QualificationEducationLevel;
use App\Models\QualificationLanguage;
use App\Models\QualificationSkill;
use App\Models\status;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Spatie\Permission\Models\Role;
use Throwable;

class EmployeeController extends Controller
{
    use LeaveTypeDataManageTrait;


    protected function getEmployees($request, $currentDate)
    {
        if ($request->company_id && $request->department_id && $request->designation_id && $request->office_shift_id) {
            $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                ->where('company_id', '=', $request->company_id)
                ->where('department_id', '=', $request->department_id)
                ->where('designation_id', '=', $request->designation_id)
                ->where('office_shift_id', '=', $request->office_shift_id)
                ->where('is_active', 1)
                ->where(function($query) use ($currentDate) {
                    $query->whereNull('exit_date')
                    ->orWhere('exit_date', '>=', $currentDate)
                    ->orWhere('exit_date', '0000-00-00');
                })
                ->get();
        } elseif ($request->company_id && $request->department_id && $request->designation_id) {
            $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                ->where('company_id', '=', $request->company_id)
                ->where('department_id', '=', $request->department_id)
                ->where('designation_id', '=', $request->designation_id)
                ->where('is_active', 1)
                ->where(function($query) use ($currentDate) {
                    $query->whereNull('exit_date')
                    ->orWhere('exit_date', '>=', $currentDate)
                    ->orWhere('exit_date', '0000-00-00');
                })
                ->get();
        } elseif ($request->company_id && $request->department_id) {
            $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                ->where('company_id', '=', $request->company_id)
                ->where('department_id', '=', $request->department_id)
                ->where('is_active', 1)
                ->where(function($query) use ($currentDate) {
                    $query->whereNull('exit_date')
                    ->orWhere('exit_date', '>=', $currentDate)
                    ->orWhere('exit_date', '0000-00-00');
                })
                ->get();
        } elseif ($request->company_id && $request->office_shift_id) {
            $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                ->where('company_id', '=', $request->company_id)
                ->where('office_shift_id', '=', $request->office_shift_id)
                ->where('is_active', 1)
                ->where(function($query) use ($currentDate) {
                    $query->whereNull('exit_date')
                    ->orWhere('exit_date', '>=', $currentDate)
                    ->orWhere('exit_date', '0000-00-00');
                })
                ->get();
        } elseif ($request->company_id) {
            $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                ->where('company_id', '=', $request->company_id)
                ->where('is_active', 1)
                ->where(function($query) use ($currentDate) {
                    $query->whereNull('exit_date')
                    ->orWhere('exit_date', '>=', $currentDate)
                    ->orWhere('exit_date', '0000-00-00');
                })
                ->get();
        } else {
            $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                ->orderBy('company_id')
                ->where('is_active', 1)
                ->where(function($query) use ($currentDate) {
                    $query->whereNull('exit_date')
                    ->orWhere('exit_date', '>=', $currentDate)
                    ->orWhere('exit_date', '0000-00-00');
                })
                ->get();
        }

        return $employees;
    }

    public function index(Request $request)
    {
        $logged_user = auth()->user();
        if ($logged_user->can('view-details-employee')) {
            $companies = company::select('id', 'company_name')->get();
            $roles = Role::where('id', '!=', 3)->where('is_active', 1)->select('id', 'name')->get();
            $currentDate = date('Y-m-d');

            if (request()->ajax()) {

                // if ($request->company_id && $request->department_id && $request->designation_id && $request->office_shift_id) {
                //     $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                //         ->where('company_id', '=', $request->company_id)
                //         ->where('department_id', '=', $request->department_id)
                //         ->where('designation_id', '=', $request->designation_id)
                //         ->where('office_shift_id', '=', $request->office_shift_id)
                //         ->where('is_active', 1)
                //         ->where(function($query) use ($currentDate) {
                //             $query->whereNull('exit_date')
                //             ->orWhere('exit_date', '>=', $currentDate)
                //             ->orWhere('exit_date', '0000-00-00');
                //         })
                //         ->get();
                // } elseif ($request->company_id && $request->department_id && $request->designation_id) {
                //     $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                //         ->where('company_id', '=', $request->company_id)
                //         ->where('department_id', '=', $request->department_id)
                //         ->where('designation_id', '=', $request->designation_id)
                //         ->where('is_active', 1)
                //         ->where(function($query) use ($currentDate) {
                //             $query->whereNull('exit_date')
                //             ->orWhere('exit_date', '>=', $currentDate)
                //             ->orWhere('exit_date', '0000-00-00');
                //         })
                //         ->get();
                // } elseif ($request->company_id && $request->department_id) {
                //     $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                //         ->where('company_id', '=', $request->company_id)
                //         ->where('department_id', '=', $request->department_id)
                //         ->where('is_active', 1)
                //         ->where(function($query) use ($currentDate) {
                //             $query->whereNull('exit_date')
                //             ->orWhere('exit_date', '>=', $currentDate)
                //             ->orWhere('exit_date', '0000-00-00');
                //         })
                //         ->get();
                // } elseif ($request->company_id && $request->office_shift_id) {
                //     $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                //         ->where('company_id', '=', $request->company_id)
                //         ->where('office_shift_id', '=', $request->office_shift_id)
                //         ->where('is_active', 1)
                //         ->where(function($query) use ($currentDate) {
                //             $query->whereNull('exit_date')
                //             ->orWhere('exit_date', '>=', $currentDate)
                //             ->orWhere('exit_date', '0000-00-00');
                //         })
                //         ->get();
                // } elseif ($request->company_id) {
                //     $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                //         ->where('company_id', '=', $request->company_id)
                //         ->where('is_active', 1)
                //         ->where(function($query) use ($currentDate) {
                //             $query->whereNull('exit_date')
                //             ->orWhere('exit_date', '>=', $currentDate)
                //             ->orWhere('exit_date', '0000-00-00');
                //         })
                //         ->get();
                // } else {
                //     $employees = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name')
                //         ->orderBy('company_id')
                //         ->where('is_active', 1)
                //         ->where(function($query) use ($currentDate) {
                //             $query->whereNull('exit_date')
                //             ->orWhere('exit_date', '>=', $currentDate)
                //             ->orWhere('exit_date', '0000-00-00');
                //         })
                //         ->get();
                // }

                $employees = $this->getEmployees($request, $currentDate);

                return datatables()->of($employees)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('name', function ($row) {
                        if ($row->user->profile_photo) {
                            $url = url('uploads/profile_photos/'.$row->user->profile_photo);
                            $profile_photo = '<img src="'.$url.'" class="profile-photo md" style="height:35px;width:35px"/>';
                        } else {
                            $url = url('logo/avatar.jpg');
                            $profile_photo = '<img src="'.$url.'" class="profile-photo md" style="height:35px;width:35px"/>';
                        }
                        $name = '<span><a href="employees/'.$row->id.'" class="d-block text-bold" style="color:#24ABF2">'.$row->full_name.'</a></span>';
                        $username = '<span>'.__('file.Username').': '.($row->user->username ?? '').'</span>';
                        $staff_id = '<span>'.__('file.Staff Id').': '.($row->staff_id ?? '').'</span>';
                        $gender = '';
                        if ($row->gender != null) {
                            $gender = '<span>'.__('file.Gender').': '.__('file.'.$row->gender ?? '').'</span></br>';
                        }

                        $shift = '<span>'.__('file.Shift').': '.($row->officeShift->shift_name ?? '').'</span>';
                        if (config('variable.currency_format') == 'suffix') {
                            $salary = '<span>'.__('file.Salary').': '.($row->basic_salary ?? '').' '.config('variable.currency').'</span>';
                        } else {
                            $salary = '<span>'.__('file.Salary').': '.config('variable.currency').' '.($row->basic_salary ?? '').'</span>';
                        }

                        if ($row->payslip_type) {
                            $payslip_type = '<span>'.__('file.Payslip Type').': '.__('file.'.$row->payslip_type).'</span>';
                        } else {
                            $payslip_type = ' ';
                        }

                        return "<div class='d-flex'>
                                        <div class='mr-2'>".$profile_photo.'</div>
                                        <div>'
                                            .$name.'</br>'.$username.'</br>'.$staff_id.'</br>'.$gender.$shift.'</br>'.$salary.'</br>'.$payslip_type;

                    })
                    ->addColumn('company', function ($row) {
                        $company = "<span class='text-bold'>".strtoupper($row->company->company_name ?? '').'</span>';
                        $department = '<span>'.__('file.Department').' : '.($row->department->department_name ?? '').'</span>';
                        $designation = '<span>'.__('file.Designation').' : '.($row->designation->designation_name ?? '').'</span>';

                        return $company.'</br>'.$department.'</br>'.$designation;
                    })
                    ->addColumn('contacts', function ($row) {
                        $email = "<i class='fa fa-envelope text-muted' title='Email'></i> ".$row->email;
                        $contact_no = "<i class='text-muted fa fa-phone' title='Phone'></i> ".$row->contact_no;
                        $skype_id = "<i class='text-muted fa fa-skype' title='Skype'></i> ".$row->skype_id;
                        $whatsapp_id = "<i class='text-muted fa fa-whatsapp' title='Whats App'></i> ".$row->whatsapp_id;

                        return $email.'</br>'.$contact_no.'</br>'.$skype_id.'</br>'.$whatsapp_id;
                    })
                    ->addColumn('action', function ($data) {
                        $button = '';
                        if (auth()->user()->can('view-details-employee')) {
                            $button .= '<a href="employees/'.$data->id.'"  class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
                            $button .= '&nbsp;&nbsp;&nbsp;';
                        }
                        if (auth()->user()->can('modify-details-employee')) {
                            if ($data->role_users_id != 1) {
                                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete"><i class="dripicons-trash"></i></button>';
                                $button .= '&nbsp;&nbsp;&nbsp;';
                            }

                            $button .= '<a class="download btn-sm" style="background:#FF7588; color:#fff" title="PDF" href="'.route('employees.pdf', $data->id).'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                        }

                        return $button;
                    })
                    ->rawColumns(['name', 'company', 'contacts', 'action'])
                    ->make(true);
            }
            return view('employee.index', compact('companies', 'roles'));
        } else {
            return response()->json(['success' => __('You are not authorized')]);
        }
    }

    public function store(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('store-details-employee')) {
            if (request()->ajax()) {
                $validator = Validator::make($request->only('first_name', 'last_name', 'staff_id', 'email', 'contact_no', 'date_of_birth', 'gender',
                    'username', 'role_users_id', 'password', 'password_confirmation', 'company_id', 'department_id', 'designation_id', 'office_shift_id', 'attendance_type', 'joining_date'),
                    [
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'staff_id' => 'required|numeric|unique:employees',
                        'email' => 'nullable|email|unique:users',
                        'contact_no' => 'required|numeric|unique:users',
                        'date_of_birth' => 'required',
                        'company_id' => 'required',
                        'department_id' => 'required',
                        'designation_id' => 'required',
                        'office_shift_id' => 'required',
                        'username' => 'required|unique:users',
                        'role_users_id' => 'required',
                        'password' => 'required|min:4|confirmed',
                        'attendance_type' => 'required',
                        'joining_date' => 'required',
                        'profile_photo' => 'nullable|image|max:10240|mimes:jpeg,png,jpg,gif',
                    ]
                );

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $data = [];
                $data['first_name'] = $request->first_name;
                $data['last_name'] = $request->last_name;
                $data['staff_id'] = $request->staff_id;
                $data['date_of_birth'] = $request->date_of_birth;
                $data['gender'] = $request->gender;
                $data['department_id'] = $request->department_id;
                $data['company_id'] = $request->company_id;
                $data['designation_id'] = $request->designation_id;
                $data['office_shift_id'] = $request->office_shift_id;

                $data['email'] = strtolower(trim($request->email));
                $data['role_users_id'] = $request->role_users_id;
                $data['contact_no'] = $request->contact_no;
                $data['attendance_type'] = $request->attendance_type; //new
                $data['joining_date'] = $request->joining_date; //new
                $data['is_active'] = 1;

                $user = [];
                $user['first_name'] = $request->first_name;
                $user['last_name'] = $request->last_name;
                $user['username'] = strtolower(trim($request->username));
                $user['email'] = strtolower(trim($request->email));
                $user['password'] = bcrypt($request->password);
                $user['role_users_id'] = $request->role_users_id;
                $user['contact_no'] = $request->contact_no;
                $user['is_active'] = 1;

                $photo = $request->profile_photo;
                $file_name = null;

                if (isset($photo)) {
                    $new_user = $request->username;
                    if ($photo->isValid()) {
                        $file_name = preg_replace('/\s+/', '', $new_user).'_'.time().'.'.$photo->getClientOriginalExtension();
                        $photo->storeAs('profile_photos', $file_name);
                        $user['profile_photo'] = $file_name;
                    }
                }

                DB::beginTransaction();
                try {
                    $created_user = User::create($user);
                    $created_user->syncRoles($request->role_users_id); //new

                    $data['id'] = $created_user->id;

                    $employee = employee::create($data);
                    $this->allLeaveTypeDataNewlyStore($employee);

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();

                    return response()->json(['error' => $e->getMessage()]);
                } catch (Throwable $e) {
                    DB::rollback();

                    return response()->json(['error' => $e->getMessage()]);
                }

                return response()->json(['success' => __('Data Added successfully.')]);
            }
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function show(Employee $employee)
    {
        if (auth()->user()->can('view-details-employee')) {
            $companies = Company::select('id', 'company_name')->get();
            $departments = department::select('id', 'department_name')
                ->where('company_id', $employee->company_id)
                ->get();

            $designations = designation::select('id', 'designation_name')
                ->where('department_id', $employee->department_id)
                ->get();

            $office_shifts = office_shift::select('id', 'shift_name')
                ->where('company_id', $employee->company_id)
                ->get();

            $statuses = status::select('id', 'status_title')->get();
            // $roles = Role::select('id', 'name')->get();
            $countries = DB::table('countries')->select('id', 'name')->get();
            $document_types = DocumentType::select('id', 'document_type')->get();

            $education_levels = QualificationEducationLevel::select('id', 'name')->get();
            $language_skills = QualificationLanguage::select('id', 'name')->get();
            $general_skills = QualificationSkill::select('id', 'name')->get();

            $roles = Role::where('id', '!=', 3)->where('is_active', 1)->select('id', 'name')->get(); //--new--

            return view('employee.dashboard', compact('employee', 'countries', 'companies',
                'departments', 'designations', 'statuses', 'office_shifts', 'document_types', 'education_levels', 'language_skills', 'general_skills', 'roles'));
        } else {
            return response()->json(['success' => __('You are not authorized')]);
        }
    }

    public function destroy($id)
    {
        if (! env('USER_VERIFIED')) {
            return response()->json(['error' => 'This feature is disabled for demo!']);
        }
        $logged_user = auth()->user();

        if ($logged_user->can('modify-details-employee')) {
            DB::beginTransaction();
            try {
                Employee::whereId($id)->delete();
                $this->unlink($id);
                User::whereId($id)->delete();

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            } catch (Throwable $e) {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            }

            return response()->json(['success' => __('Data is successfully deleted')]);
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function unlink($employee)
    {

        $user = User::findOrFail($employee);
        $file_path = $user->profile_photo;

        if ($file_path) {
            $file_path = public_path('uploads/profile_photos/'.$file_path);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
    }

    public function delete_by_selection(Request $request)
    {
        if (! env('USER_VERIFIED')) {
            return response()->json(['error' => 'This feature is disabled for demo!']);
        }
        $logged_user = auth()->user();

        if ($logged_user->can('modify-details-employee')) {
            $employee_id = $request['employeeIdArray'];

            $user = User::whereIntegerInRaw('id', $employee_id)->where('role_users_id', '!=', 1);

            if ($user->delete()) {
                return response()->json(['success' => __('Data is successfully deleted')]);
            }
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function infoUpdate(Request $request, $employee)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('modify-details-employee')) {
            if (request()->ajax()) {
                $validator = Validator::make($request->only('first_name', 'last_name', 'staff_id', 'email', 'contact_no', 'date_of_birth', 'gender',
                    'username', 'role_users_id', 'company_id', 'department_id', 'designation_id', 'office_shift_id', 'location_id', 'status_id',
                    'marital_status', 'joining_date', 'permission_role_id', 'address', 'city', 'state', 'country', 'zip_code', 'attendance_type', 'total_leave'
                ),
                    [
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'username' => 'required|unique:users,username,'.$employee,
                        'staff_id' => 'required|numeric|unique:employees,staff_id,'.$employee,
                        'email' => 'nullable|email|unique:users,email,'.$employee,
                        'contact_no' => 'required|numeric|unique:users,contact_no,'.$employee,
                        'date_of_birth' => 'required',
                        'company_id' => 'required',
                        'department_id' => 'required',
                        'designation_id' => 'required',
                        'office_shift_id' => 'required',
                        'role_users_id' => 'required',
                        'attendance_type' => 'required',
                        'total_leave' => 'numeric|min:0',
                        'joining_date' => 'required',
                        'exit_date' => 'nullable',
                    ]
                );

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $data = [];
                $data['first_name'] = $request->first_name;
                $data['last_name'] = $request->last_name;
                $data['staff_id'] = $request->staff_id;
                $data['date_of_birth'] = $request->date_of_birth;
                $data['gender'] = $request->gender;
                $data['department_id'] = $request->department_id;
                $data['company_id'] = $request->company_id;
                $data['designation_id'] = $request->designation_id;
                $data['office_shift_id'] = $request->office_shift_id;
                $data['status_id'] = $request->status_id;
                $data['marital_status'] = $request->marital_status;
                if ($request->joining_date) {
                    $data['joining_date'] = $request->joining_date;
                }

                if ($request->exit_date) {
                    $data['exit_date'] = $request->exit_date;
                }
                // else {
                //     $data['exit_date'] = NULL;
                // }

                $data['address'] = $request->address;
                $data['city'] = $request->city;
                $data['state'] = $request->state;
                $data['country'] = $request->country;
                $data['zip_code'] = $request->zip_code;

                $data['email'] = strtolower(trim($request->email));
                $data['role_users_id'] = $request->role_users_id;
                $data['contact_no'] = $request->contact_no;
                $data['attendance_type'] = $request->attendance_type;
                $data['is_active'] = 1;

                //Leave Calculation
                // $employee_leave_info = Employee::find($employee);
                // if ($employee_leave_info->total_leave==0) {
                // 	$data['total_leave'] = $request->total_leave;
                // 	$data['remaining_leave'] = $request->total_leave;
                // }
                // elseif ($request->total_leave > $employee_leave_info->total_leave) {
                // 	$data['total_leave'] = $request->total_leave;
                // 	$data['remaining_leave'] = $request->remaining_leave + ($request->total_leave - $employee_leave_info->total_leave);
                // }
                // elseif ($request->total_leave < $employee_leave_info->total_leave) {
                // 	$data['total_leave']     = $request->total_leave;
                // 	$remaining_leave         = $request->remaining_leave - ($employee_leave_info->total_leave - $request->total_leave);
                //     $data['remaining_leave'] = $remaining_leave < 0 ? 0 : $remaining_leave;
                // }else {
                // 	$data['total_leave'] = $request->total_leave;
                // 	$data['remaining_leave'] = $employee_leave_info->remaining_leave;
                // }

                $user = [];
                $user['first_name'] = $request->first_name;
                $user['last_name'] = $request->last_name;
                $user['username'] = strtolower(trim($request->username));
                $user['email'] = strtolower(trim($request->email));
                $user['role_users_id'] = $request->role_users_id;
                $user['contact_no'] = $request->contact_no;
                $user['is_active'] = 1;

                DB::beginTransaction();
                try {
                    User::whereId($employee)->update($user);
                    employee::find($employee)->update($data);

                    $usertest = User::find($employee); //--new--
                    $usertest->syncRoles($data['role_users_id']); //--new--

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();

                    return response()->json(['error' => $e->getMessage()]);
                } catch (Throwable $e) {
                    DB::rollback();

                    return response()->json(['error' => $e->getMessage()]);
                }

                return response()->json(['success' => __('Data Added successfully.')]);
            }
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function socialProfileShow(Employee $employee)
    {
        return view('employee.social_profile.index', compact('employee'));
    }

    public function storeSocialInfo(Request $request, $employee)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('modify-details-employee') || $logged_user->id == $employee) {
            $data = [];
            $data['fb_id'] = $request->fb_id;
            $data['twitter_id'] = $request->twitter_id;
            $data['linkedIn_id'] = $request->linkedIn_id;
            $data['whatsapp_id'] = $request->whatsapp_id;
            $data['skype_id'] = $request->skype_id;

            Employee::whereId($employee)->update($data);

            return response()->json(['success' => __('Data is successfully updated')]);

        }

        return response()->json(['success' => __('You are not authorized')]);

    }

    public function indexProfilePicture(Employee $employee)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('modify-details-employee')) {
            return view('employee.profile_picture.index', compact('employee'));
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function storeProfilePicture(Request $request, $employee)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('modify-details-employee') || $logged_user->id == $employee) {

            $data = [];
            $photo = $request->profile_photo;
            $file_name = null;

            if (isset($photo)) {
                $new_user = $request->employee_username;
                if ($photo->isValid()) {
                    $file_name = preg_replace('/\s+/', '', $new_user).'_'.time().'.'.$photo->getClientOriginalExtension();
                    $photo->storeAs('profile_photos', $file_name);
                    $data['profile_photo'] = $file_name;
                }
            }

            $this->unlink($employee);

            User::whereId($employee)->update($data);

            return response()->json(['success' => 'Data is successfully updated', 'profile_picture' => $file_name]);

        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function setSalary(Employee $employee)
    {
        $logged_user = auth()->user();
        if ($logged_user->can('modify-details-employee')) {
            return view('employee.salary.index', compact('employee'));
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function storeSalary(Request $request, $employee)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('modify-details-employee')) {

            $validator = Validator::make($request->only('payslip_type', 'basic_salary'
            ),
                [
                    'basic_salary' => 'required|numeric',
                    'payslip_type' => 'required',
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::beginTransaction();
            try {
                Employee::updateOrCreate(['id' => $employee], [
                    'payslip_type' => $request->payslip_type,
                    'basic_salary' => $request->basic_salary]);
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            } catch (Throwable $e) {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            }

            return response()->json(['success' => __('Data Added successfully.')]);
        }

        return response()->json(['error' => __('You are not authorized')]);
    }

    public function employeesPensionUpdate(Request $request, $employee)
    {
        //return response()->json('ok');
        $logged_user = auth()->user();

        if ($logged_user->can('modify-details-employee')) {

            $validator = Validator::make($request->only('pension_type', 'pension_amount'), [
                'pension_type' => 'required',
                'pension_amount' => 'required|numeric',
            ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::beginTransaction();
            try {
                Employee::updateOrCreate(['id' => $employee], [
                    'pension_type' => $request->pension_type,
                    'pension_amount' => $request->pension_amount]);
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            } catch (Throwable $e) {
                DB::rollback();

                return response()->json(['error' => $e->getMessage()]);
            }

            return response()->json(['success' => __('Data Added successfully.')]);
        }

        return response()->json(['success' => __('You are not authorized')]);

    }

    public function import()
    {

        if (auth()->user()->can('import-employee')) {
            return view('employee.import');
        }

        return abort(404, __('You are not authorized'));
    }

    public function importPost()
    {

        if (! env('USER_VERIFIED')) {
            $this->setErrorMessage('This feature is disabled for demo!');

            return redirect()->back();
        }
        try {
            Excel::queueImport(new UsersImport(), request()->file('file'));
        } catch (ValidationException $e) {
            $failures = $e->failures();

            return view('employee.importError', compact('failures'));
        }

        $this->setSuccessMessage(__('Imported Successfully'));

        return back();

    }

    public function employeePDF($id)
    {
        $employee = Employee::with('user:id,profile_photo,username', 'company:id,company_name', 'department:id,department_name', 'designation:id,designation_name', 'officeShift:id,shift_name', 'role:id,name')
            ->where('id', $id)
            ->first()
            ->toArray();

        PDF::setOptions(['dpi' => 10, 'defaultFont' => 'sans-serif', 'tempDir' => storage_path('temp')]);
        $pdf = PDF::loadView('employee.pdf', $employee);
        return $pdf->download('employee.pdf');

        // return $pdf->stream();
    }
}
