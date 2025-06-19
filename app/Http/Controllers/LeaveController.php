<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\department;
use App\Models\Employee;
use App\Models\leave;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

//Notification
use App\Notifications\EmployeeLeaveNotification; //Mail
use App\Notifications\LeaveNotification; //Database
use App\Notifications\LeaveNotificationToAdmin; //Database
use App\Models\User;
use App\Models\EmployeeLeaveTypeDetail;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{

    public function index()
    {
        $logged_user = auth()->user();
        $companies = company::select('id', 'company_name')->get();
        $leave_types = LeaveType::select('id', 'leave_type', 'allocated_day')->get();
        $leave = leave::with('employee', 'department', 'LeaveType')->orderBy('id', 'DESC')->get();


        if ($logged_user->can('view-leave')) {
            if (request()->ajax()) {
                return datatables()->of($leave)
                    ->setRowId(function ($row) {
                        return $row->id;
                    })
                    ->addColumn('leave_type', function ($row) {
                        return $row->LeaveType->leave_type ?? '';
                    })
                    ->addColumn('department', function ($row) {
                        return $row->department->department_name ?? '';
                    })
                    ->addColumn('employee', function ($row) {
                        return $row->employee->full_name ?? '';
                    })
                    ->addColumn('action', function ($data) {
                        $start_date = new DateTime($data->start_date);
                        $end_date = new DateTime($data->end_date);
                        $current_date = new DateTime();
                        if ($start_date < $current_date->setTime(0, 0, 0, 0) && $end_date < $current_date->setTime(0, 0, 0, 0)) {
                            return $button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
                        }

                        $button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        if (auth()->user()->can('edit-leave')) {
                            $button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                            $button .= '&nbsp;&nbsp;';
                        }
                        if (auth()->user()->can('delete-leave')) {
                            $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                        }
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('timesheet.leave.index', compact('companies', 'leave_types'));
        }

        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('store-leave') || auth()->user()) {
            $validator = Validator::make(
                $request->only('leave_type', 'company_id', 'department_id', 'employee_id', 'start_date', 'end_date', 'status'),
                [
                    'company_id' => 'required',
                    'department_id' => 'required',
                    'employee_id' => 'required',
                    'leave_type' => 'required',
                    'status' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required|after_or_equal:start_date'
                ]
            );


            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }


            $currentDate = new DateTime();
            $requestStartDate = new DateTime($request->start_date);
            $requestEndDate = new DateTime($request->end_date);

            if ($requestStartDate < $currentDate->setTime(0, 0, 0, 0)) {
                throw new Exception('The start date is less than the current date');
            } else if ($requestEndDate < $currentDate->setTime(0, 0, 0, 0)) {
                throw new Exception('The end date is less than the current date');
            }


            try {

                $leave = LeaveType::findOrFail($request->leave_type);
                $data = [];
                $data['employee_id'] = $request->employee_id;
                $data['company_id'] = $request->company_id;
                $data['department_id'] = $request->department_id;
                $data['leave_type_id'] = $request->leave_type;
                $data['leave_reason'] = $request->leave_reason;
                $data['remarks'] = $request->remarks;
                $data['status'] = $request->status;
                $data['is_notify'] = $request->is_notify;
                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;
                $data['total_days'] = $request->diff_date_hidden;

                if ($request->status == 'approved') {
                    try {
                        $this->employeeLeaveTypeDataManage(null, $request, $request->employee_id, false);
                    } catch (Exception $e) {
                        return response()->json(['error' => $e->getMessage()]);
                    }
                }

                $leave = leave::create($data);

                if ($leave->is_notify == 1) {
                    $text = "A new leave-notification has been published";
                    $notifiable = User::findOrFail($data['employee_id']);
                    $notifiable->notify(new LeaveNotification($text)); //To Employee
                } elseif ((Auth::user()->role_users_id != 1) && ($leave->is_notify == NULL)) {
                    //get-leave-notification - 294
                    $role_ids = DB::table('role_has_permissions')->where('permission_id', 294)->get()->pluck('role_id');
                    $role_ids[] = 1;

                    $notifiable = User::whereIn('role_users_id', $role_ids)->get();
                    foreach ($notifiable as $item) {
                        $item->notify(new LeaveNotificationToAdmin());
                    }

                    //Mail
                    $department = department::with('DepartmentHead:id,email')->where('id', $request->department_id)->first();
                    if(isset($department->DepartmentHead->email)) {
                        Notification::route('mail', $department->DepartmentHead->email)
                        ->notify(new EmployeeLeaveNotification(
                            $leave->employee->full_name,
                            $leave->total_days,
                            $leave->start_date,
                            $leave->end_date,
                            $leave->leave_reason,
                        ));
                    }

                }

            }
            catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }

            return response()->json(['success' => __('Data Added successfully.')]);
        }
        return response()->json(['success' => __('You are not authorized')]);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = leave::findOrFail($id);
            $company_name = $data->company->company_name ?? '';
            $employee_name = $data->employee->full_name;
            $department = $data->department->department_name ?? '';
            $leave_type_name = $data->LeaveType->leave_type ?? '';

            $start_date_name = $data->start_date;
            $end_date_name = $data->end_date;


            return response()->json([
                'data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'department' => $department, 'leave_type_name' => $leave_type_name,
                'start_date_name' => $start_date_name, 'end_date_name' => $end_date_name
            ]);
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = leave::findOrFail($id);

            $leaveStartDate = date('Y-m-d', strtotime($data->start_date));

            $departments = department::select('id', 'department_name')
                ->where('company_id', $data->company_id)->get();

            $employees = Employee::select('id', 'first_name', 'last_name')->where('department_id', $data->department_id)->where('is_active', 1)->where('exit_date', NULL)->get();

            return response()->json(['data' => $data, 'employees' => $employees, 'departments' => $departments, 'leaveStartDate' => $leaveStartDate]);
        }
    }

    public function update(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('edit-leave')) {
            $id = $request->hidden_id;

            $validator = Validator::make(
                $request->only(
                    'leave_type',
                    'company_id',
                    'department_id',
                    'employee_id',
                    'start_date',
                    'end_date',
                    'leave_reason',
                    'remarks',
                    'status',
                    'is_notify',
                    'diff_date_hidden',
                    'leave_type_hidden',
                    'employee_id_hidden'
                ),
                [
                    'company_id' => 'required',
                    'department_id' => 'required',
                    'employee_id' => 'required',
                    'leave_type' => 'required',
                    'status' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required|after_or_equal:start_date',
                    'diff_date_hidden' => 'nullable|numeric'
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }


            $data = [];
            global $employee_id;
            $data['leave_reason'] = $request->leave_reason;
            $data['remarks'] = $request->remarks;
            $data['is_notify'] = $request->is_notify;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;


            if ($request->diff_date_hidden != null) {
                $data['total_days'] = $request->diff_date_hidden;
            }
            if ($request->employee_id) {
                $employee_id = $request->employee_id;
                $data['employee_id'] = $employee_id;
            } else {
                $employee_id = $request->employee_id_hidden;
            }

            if ($request->company_id) {
                $data['company_id'] = $request->company_id;
            }

            if ($request->department_id) {
                $data['department_id'] = $request->department_id;
            }
            if ($request->status) {
                $data['status'] = $request->status;
            }


            $leave = leave::find($id);

            //Employee Remaining Leave Manage
            $isEmplyoeeRemaingLeaveRestore = null;
            if ($leave->status == 'approved' && ($request->status == 'pending' || $request->status == 'rejected')) {
                $isEmplyoeeRemaingLeaveRestore = true;
            } else if (($leave->status == 'pending' || $leave->status == 'rejected') && $request->status === 'approved') {
                $isEmplyoeeRemaingLeaveRestore = false;
            }

            try {
                $this->employeeLeaveTypeDataManage($leave, $request, $employee_id, $isEmplyoeeRemaingLeaveRestore);

                $leave->update($data);
                if ($data['is_notify'] != NULL) {
                    $text = "A leave-notification has been updated";
                    $notifiable = User::findOrFail($data['employee_id']);
                    $notifiable->notify(new LeaveNotification($text)); //To Employee
                }
            }
            catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
            return response()->json(['success' => __('Data is successfully updated')]);
        }
        return response()->json(['success' => __('You are not authorized')]);
    }


    private function employeeLeaveTypeDataManage($leave, $request, $employee_id, $isRestore)
    {
        if ($leave) {
            $currentDate = new DateTime();

            $previousStartDate = new DateTime($leave->start_date);
            $previousEndDate = new DateTime($leave->end_date);

            $requestStartDate = new DateTime($request->start_date);
            $requestEndDate = new DateTime($request->end_date);

            $isStartDateChange = true;
            $isEndDateChange = true;

            if ($previousStartDate == $requestStartDate) {
                $isStartDateChange = false;
            }
            if ($previousEndDate == $requestEndDate) {
                $isEndDateChange = false;
            }

            if ($requestStartDate < $currentDate->setTime(0, 0, 0, 0) && $isStartDateChange) {
                throw new Exception('The start date is less than the current date');
            }
            if ($requestEndDate < $currentDate->setTime(0, 0, 0, 0) && $isEndDateChange) {
                throw new Exception('The end date is less than the current date');
            }
        }



        $employeeLeaveTypeDetail = EmployeeLeaveTypeDetail::where('employee_id', $employee_id)->first();
        $dataLeaveType = [];
        if ($employeeLeaveTypeDetail) {
            $leaveTypeUnserialize = unserialize($employeeLeaveTypeDetail->leave_type_detail);

            //Find the specific leave type from the serilize data from database & compare
            foreach ($leaveTypeUnserialize as $key => $itemArr) {
                if (in_array($request->leave_type, $itemArr)) { //leave_type = leave_type_id
                    if ($request->diff_date_hidden > $itemArr['remaining_allocated_day']) {
                        throw new Exception('Allocated quota for this leave type is less then requested total days');
                    }
                    if ($isRestore === true) {
                        $dataLeaveType[$key]['remaining_allocated_day'] = $itemArr['remaining_allocated_day'] + $request->diff_date_hidden;
                    } else if ($isRestore === false) {
                        $dataLeaveType[$key]['remaining_allocated_day'] = $itemArr['remaining_allocated_day'] - $request->diff_date_hidden;
                    } else {
                        $dataLeaveType[$key]['remaining_allocated_day'] = $itemArr['remaining_allocated_day'];
                    }
                } else {
                    $dataLeaveType[$key]['remaining_allocated_day'] = $itemArr['remaining_allocated_day'];
                }
                $dataLeaveType[$key]['leave_type_id'] = $itemArr['leave_type_id'];
                $dataLeaveType[$key]['leave_type'] = $itemArr['leave_type'];
                $dataLeaveType[$key]['allocated_day'] = $itemArr['allocated_day'];
            }
        }

        if (!empty($dataLeaveType)) {
            EmployeeLeaveTypeDetail::updateOrCreate(
                ['employee_id' => $employee_id],
                ['leave_type_detail' => serialize($dataLeaveType)]
            );
        }
    }




    public function destroy($id)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['error' => 'This feature is disabled for demo!']);
        }
        $logged_user = auth()->user();

        if ($logged_user->can('delete-leave')) {
            leave::whereId($id)->delete();

            return response()->json(['success' => __('Data is successfully deleted')]);
        }
        return response()->json(['success' => __('You are not authorized')]);
    }






    public function delete_by_selection(Request $request)
    {
        if (!env('USER_VERIFIED')) {
            return response()->json(['error' => 'This feature is disabled for demo!']);
        }
        $logged_user = auth()->user();

        if ($logged_user->can('delete-leave')) {

            $leave_id = $request['leaveIdArray'];
            $leave = leave::whereIntegerInRaw('id', $leave_id);
            if ($leave->delete()) {
                return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Leave')])]);
            } else {
                return response()->json(['error' => 'Error, selected leaves can not be deleted']);
            }
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function calendarableDetails($id)
    {
        if (request()->ajax()) {
            $data = Leave::with(
                'company:id,company_name',
                'LeaveType:id,leave_type',
                'employee:id,first_name,last_name'
            )->findOrFail($id);

            $new = [];

            $new['Company'] = $data->company->company_name;
            $new['Employee'] = $data->employee->full_name;
            $new['Arrangement Type'] = $data->LeaveType->leave_type;
            $new['Start Date'] = $data->start_date;
            $new['End Date'] = $data->end_date;
            $new['Leave Reason'] = $data->leave_reason;
            $new['Remarks'] = $data->remarks;
            $new['Status'] = 'Approved';

            return response()->json(['data' => $new]);
        }
    }
}
