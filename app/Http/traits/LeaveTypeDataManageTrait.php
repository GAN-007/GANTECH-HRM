<?php
namespace App\Http\traits;

use App\Models\EmployeeLeaveTypeDetail;
use App\Models\LeaveType;

trait LeaveTypeDataManageTrait{

    public function allLeaveTypeDataNewlyStore($employee)
    {
        $leaveTypes = LeaveType::select('id','leave_type','allocated_day')->get();

        $dataLeaveType = [];
        foreach($leaveTypes as $key => $item) {
            $dataLeaveType[$key]['leave_type_id'] = $item->id;
            $dataLeaveType[$key]['leave_type'] = $item->leave_type;
            $dataLeaveType[$key]['allocated_day'] = $item->allocated_day;

            $totalPaidLeave = $employee->employeeLeave->where('leave_type_id',$item->id)->sum('total_days');
            $remaining_leave = $item->allocated_day - $totalPaidLeave;
            $dataLeaveType[$key]['remaining_allocated_day'] = $remaining_leave < 0 ? 0 : $remaining_leave;
        }

        if(!empty($dataLeaveType)) {
            EmployeeLeaveTypeDetail::updateOrCreate(
                ['employee_id' => $employee->id],
                ['leave_type_detail' => serialize($dataLeaveType)]
            );
        }
    }

}
