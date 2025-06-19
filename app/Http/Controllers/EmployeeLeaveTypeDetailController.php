<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeaveTypeDetail;
use App\Models\leave;
use Illuminate\Http\Request;

class EmployeeLeaveTypeDetailController extends Controller
{
    public function index($employee)
	{
        if (request()->ajax())
        {
            // $data = EmployeeLeaveTypeDetail::where('employee_id',$employee)->get();

            $employeeLeaveTypeDetail = EmployeeLeaveTypeDetail::where('employee_id',$employee)->first();
            $leaveTypeUnserialize = [];

            if ($employeeLeaveTypeDetail) {
                $leaveTypeUnserialize = unserialize($employeeLeaveTypeDetail->leave_type_detail);
            }



            return datatables()->of($leaveTypeUnserialize)
                ->setRowId(function ($row)
                {
                    return $row['leave_type_id'];
                })
                ->addColumn('leave_type', function ($row)
                {
                    return $row['leave_type'];
                })
                ->addColumn('allocated_day', function ($row)
                {
                    return $row['allocated_day'];
                })
                ->addColumn('remaining', function ($row)
                {
                    return $row['remaining_allocated_day'];
                })
                ->make(true);
        }
    }
}



// if ($employeeLeaveTypeDetail) {
//     $leaveTypeUnserialize = unserialize($employeeLeaveTypeDetail->leave_type_detail);

    // $remainingleaveTypeUnserialize = unserialize($employeeLeaveTypeDetail->leave_type_remaining);
    // for($i=0; $i< count($leaveTypeUnserialize) ; $i++) {
    //     $data[$i]['leave_type_id'] = $leaveTypeUnserialize[$i]['leave_type_id'];
    //     $data[$i]['leave_type'] = $leaveTypeUnserialize[$i]['leave_type'];
    //     $data[$i]['allocated_day'] = $leaveTypeUnserialize[$i]['allocated_day'];
    //     $data[$i]['remaining_allocated_day'] = $leaveTypeUnserialize[$i]['remaining_allocated_day'];
    // }
// }
