<?php


namespace App\Http\Controllers\Variables;

use App\Models\Employee;
use App\Models\EmployeeLeaveTypeDetail;
use App\Http\traits\LeaveTypeDataManageTrait;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveTypeController {

    use LeaveTypeDataManageTrait;

	public function index()
	{
		if (request()->ajax())
		{
            $data = LeaveType::select('id', 'leave_type','allocated_day')->get();

			return datatables()->of($data)
				->setRowId(function ($data)
				{
					return $data->id;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_type'))
					{
                        $button = "";
                        $button .= '<button type="button" name="edit" id="' . $data->id . '" class="leave_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        if (!($data->leave_type=="Others")) {
                            $button .= '<button type="button" name="delete" id="' . $data->id . '" class="leave_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                        }
						return $button;
					}
                    else
					{
						return '';
					}
				})
				->rawColumns(['action'])
				->make(true);
		}
	}

	public function store(Request $request)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			$validator = Validator::make($request->only('leave_type','allocated_day'),
				[
					'leave_type' => 'required|unique:leave_types',
					'allocated_day' => 'nullable|numeric',
				]
			);


			if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$newData = [];
			$newData['leave_type'] = $request->get('leave_type');
			$newData['allocated_day'] = $request->get('allocated_day');

			$leaveType =LeaveType::create($newData);

            // New
            $newData['leave_type_id'] = $leaveType->id;
            $newData['remaining_allocated_day'] = $request->get('allocated_day');

            $employees  = Employee::with('employeeLeave','employeeLeaveTypeDetail')->get();
            $leaveTypes = LeaveType::select('id','leave_type','allocated_day')->get();

            $existingData  = [];
            // $dataLeaveType = [];
            foreach($employees as $employee) {
                if($employee->employeeLeaveTypeDetail) {
                    $existingData = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
                    array_push($existingData, $newData);
                    $employee->employeeLeaveTypeDetail->leave_type_detail =  serialize($existingData);
                    $employee->employeeLeaveTypeDetail->update();
                }else{
                    $this->allLeaveTypeDataNewlyStore($employee);
                }
            }

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return abort('403', __('You are not authorized'));

	}


	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = LeaveType::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}


	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			$id = $request->get('hidden_leave_id');

			$validator = Validator::make($request->only('leave_type_edit'),
				[
					'leave_type_edit' => 'required|unique:leave_types,leave_type,'.$id,
					 'allocated_day' => 'nullable|numeric'
				]
			);


			if ($validator->fails()){
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];
			$data['leave_type'] = $request->get('leave_type_edit');
			$data['allocated_day'] = $request->get('allocated_day_edit');


			LeaveType::whereId($id)->update($data);

            $this->leaveTypeManageUpdate($request, $id);

			return response()->json(['success' => __('Data is successfully updated')]);
		} else
		{

			return abort('403', __('You are not authorized'));
		}
	}

    private function leaveTypeManageUpdate($request, $leaveTypeId)
    {
        $employees  = Employee::with('employeeLeave','employeeLeaveTypeDetail')->get(); //Have to Change
        $leaveTypes = LeaveType::select('id','leave_type','allocated_day')->get();

        foreach($employees as $employee){
            if($employee->employeeLeaveTypeDetail) {
                $leave_type_details = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
                $specificLeaveType = null;
                foreach ($leave_type_details as $value) {
                    if ($value["leave_type_id"] == $leaveTypeId) {
                        $specificLeaveType = $value;
                        break;
                    }
                }

                $dataLeaveType = [];
                foreach($leaveTypes as $key => $item) {
                    $dataLeaveType[$key]['leave_type_id'] = $item->id;
                    $dataLeaveType[$key]['leave_type'] = $item->leave_type;
                    $dataLeaveType[$key]['allocated_day'] = $item->allocated_day;

                    if($item->id == $leaveTypeId) {
                        // condition apply
                        if ($request->get('allocated_day_edit') > $specificLeaveType['allocated_day']) {
                            $dataLeaveType[$key]['remaining_allocated_day'] = $specificLeaveType['remaining_allocated_day'] + ($request->get('allocated_day_edit') - $specificLeaveType['allocated_day']);
                        }
                        elseif ($request->get('allocated_day_edit') < $specificLeaveType['allocated_day']) {
                            $remaining_leave = $specificLeaveType['remaining_allocated_day'] - ($specificLeaveType['allocated_day'] - $request->get('allocated_day_edit'));
                            $dataLeaveType[$key]['remaining_allocated_day'] = $remaining_leave < 0 ? 0 : $remaining_leave;
                        }else{
                            $dataLeaveType[$key]['remaining_allocated_day']  = $specificLeaveType['remaining_allocated_day'];
                        }
                    }else{
                        $totalPaidLeave = $employee->employeeLeave->where('leave_type_id',$item->id)->sum('total_days');
                        $remaining_leave = $item->allocated_day - $totalPaidLeave;
                        $dataLeaveType[$key]['remaining_allocated_day'] = $remaining_leave < 0 ? 0 : $remaining_leave;
                    }
                }
                EmployeeLeaveTypeDetail::updateOrCreate(
                    ['employee_id' => $employee->id],
                    ['leave_type_detail' => serialize($dataLeaveType)]
                );
            }else{
                $this->allLeaveTypeDataNewlyStore($employee);
            }

        }
    }



	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			LeaveType::whereId($id)->delete();

            $this->leaveTypeManageDelete($id);

			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}

    private function leaveTypeManageDelete($leaveTypeId)
    {
        $employees  = Employee::with('employeeLeave','employeeLeaveTypeDetail')->get();
        $existingData = [];
        foreach($employees as $employee) {
            if($employee->employeeLeaveTypeDetail) {
                $existingData = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
                foreach ($existingData as $key => $value) {
                    if ($value['leave_type_id'] == $leaveTypeId) {
                        unset($existingData[$key]);
                    }
                }
                $employee->employeeLeaveTypeDetail->leave_type_detail =  serialize($existingData);
                $employee->employeeLeaveTypeDetail->update();
            }
            else{
                $this->allLeaveTypeDataNewlyStore($employee);
            }
        }
    }

}



























