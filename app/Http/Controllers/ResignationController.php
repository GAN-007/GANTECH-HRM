<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\department;
use App\Models\Employee;
use App\Notifications\EmployeeResignationNotify;
use App\Models\Resignation;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ResignationController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if ($logged_user->can('view-resignation'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Resignation::with('company', 'employee', 'department')->get())
					->setRowId(function ($resignation)
					{
						return $resignation->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? '';
					})
					->addColumn('department', function ($row)
					{
						return $row->department->department_name ?? '';
					})
					->addColumn('employee', function ($row)
					{
						return $row->employee->full_name;
					})
					->addColumn('action', function ($data)
					{
                        $button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';

                        $resignation_date = new DateTime($data->resignation_date);
                        $current_date = new DateTime();
                        if ($resignation_date > $current_date->setTime(0, 0, 0, 0)) {
                            if (auth()->user()->can('edit-resignation')) {
                                $button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                                $button .= '&nbsp;&nbsp;';
                            }
                            if (auth()->user()->can('delete-resignation')) {
                                $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                            }

                        } elseif ($resignation_date < $current_date->setTime(0, 0, 0, 0)) {
                            $button .= '<a href="'.route('resignations.restore', $data->id).'" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Restore Data"><i class="fa fa-undo"></i></button></a>';
                            $button .= '&nbsp;&nbsp;';
                        }
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('core_hr.resignation.index', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

    protected function employeeLeaveDateSet($employee_id, $date){
        $employee = Employee::find($employee_id);
        $employee->exit_date = $date;
        $employee->update();
    }

	public function store(Request $request)
	{

		$logged_user = auth()->user();
		if ($logged_user->can('store-resignation'))
		{
			$validator = Validator::make($request->only('description', 'company_id', 'department_id', 'employee_id', 'resignation_date', 'notice_date'
			),
				[
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'resignation_date' => 'required',
					'notice_date' => 'required'
				]
			);

			if ($validator->fails()){
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];
			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data['department_id'] = $request->department_id;
			$data['description'] = $request->description;
			$data['resignation_date'] = $request->resignation_date;
			$data['notice_date'] = $request->notice_date;
			Resignation::create($data);
            $this->employeeLeaveDateSet($request->employee_id, $request->resignation_date);
			$notifiable = User::findOrFail($data['employee_id']);
            $this->setEmployeeExitDate($request->employee_id, $request->resignation_date);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function show($id)
	{
		if (request()->ajax())
		{
			$data = Resignation::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$first_name = $data->employee->first_name ?? '';
			$last_name = $data->employee->full_name ?? '';
			$employee_name = $first_name . ' ' . $last_name;
			$department = $data->department->department_name ?? '';

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'department' => $department]);
		}
	}

	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = Resignation::findOrFail($id);

			$departments = department::select('id', 'department_name')
				->where('company_id', $data->company_id)->get();

			$employees = Employee::select('id', 'first_name', 'last_name')->where('department_id', $data->department_id)->where('is_active',1)->get();


			return response()->json(['data' => $data, 'employees' => $employees, 'departments' => $departments]);
		}
	}

	public function update(Request $request)
	{
		$logged_user = auth()->user();
		if ($logged_user->can('edit-resignation'))
		{
			$id = $request->hidden_id;
			$validator = Validator::make($request->only('description', 'company_id', 'department_id', 'employee_id', 'resignation_date', 'notice_date'
			),
				[
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'resignation_date' => 'required',
					'notice_date' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];
			$data['description'] = $request->description;
			$data['resignation_date'] = $request->resignation_date;
			$data['notice_date'] = $request->notice_date;
			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data['department_id'] = $request->department_id;

			Resignation::find($id)->update($data);
            $this->employeeLeaveDateSet($request->employee_id, $request->resignation_date);
            $this->setEmployeeExitDate($request->employee_id, $request->resignation_date);

			return response()->json(['success' => __('Data is successfully updated')]);
		}
		return response()->json(['success' => __('You are not authorized')]);

	}


	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-resignation'))
		{
            $resignation = Resignation::find($id);
            $resignation->delete();

            $this->setEmployeeExitDate($resignation->employee_id , null);

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-resignation'))
		{

			$resignation_id = $request['resignationIdArray'];
			$resignation = Resignation::whereIntegerInRaw('id', $resignation_id);
			if ($resignation->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Resignation')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected resignation can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

    public function restore(Resignation $resignation)
    {
        Employee::where('id', $resignation->employee_id)
            ->update(['exit_date' => null]);
        $resignation->delete();

        return redirect()->back()->with([
            'message' => 'Successfully Restored',
            'type' => 'success',
        ]);
    }

    protected function setEmployeeExitDate($employeeId, $resignationDate)
    {
        $exitDate = null;
        if(!is_null($resignationDate)) {
            $exitDate = Carbon::parse($resignationDate)->toDateString();
        }
        Employee::where('id', $employeeId)
                ->update(['exit_date' => $exitDate]);
    }
}
