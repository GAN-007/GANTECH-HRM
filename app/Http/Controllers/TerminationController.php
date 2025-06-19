<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Employee;
use App\Notifications\EmployeeTerminationNotify;
use App\Models\Termination;
use App\Models\TerminationType;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TerminationController extends Controller
{
    public function index()
    {
        $logged_user = auth()->user();
        $companies = company::select('id', 'company_name')->get();
        $termination_types = TerminationType::select('id', 'termination_title')->get();

        if ($logged_user->can('view-termination')) {
            if (request()->ajax()) {
                return datatables()->of(Termination::with('company', 'employee')->get())
                    ->setRowId(function ($termination) {
                        return $termination->id;
                    })
                    ->addColumn('company', function ($row) {
                        return $row->company->company_name ?? ' ';
                    })
                    ->addColumn('terminated_employee', function ($row) {
                        return $row->employee->full_name;
                    })
                    ->addColumn('action', function ($data) {
                        $button = '<button type="button" name="show" id="'.$data->id.'" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
                        $button .= '&nbsp;&nbsp;';

                        $termination_date = new DateTime($data->termination_date);
                        $current_date = new DateTime();
                        if ($termination_date > $current_date->setTime(0, 0, 0, 0)) {
                            if (auth()->user()->can('edit-termination')) {
                                $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                                $button .= '&nbsp;&nbsp;';
                            }
                            if (auth()->user()->can('delete-termination')) {
                                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                            }
                        } elseif ($termination_date < $current_date->setTime(0, 0, 0, 0)) {
                            $button .= '<a href="'.route('terminations.restore', $data->id).'" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Restore Data"><i class="fa fa-undo"></i></button></a>';
                            $button .= '&nbsp;&nbsp;';
                        }

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('core_hr.termination.index', compact('companies', 'termination_types'));
        }

        return abort('403', __('You are not authorized'));
    }

    public function store(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('store-termination')) {
            $validator = Validator::make(
                $request->only('description', 'company_id', 'terminated_employee', 'termination_type', 'termination_date', 'notice_date'),
                [
                    'company_id' => 'required',
                    'terminated_employee' => 'required',
                    'termination_type' => 'required',
                    'termination_date' => 'required',
                    'notice_date' => 'required',
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];

            $data['terminated_employee'] = $request->terminated_employee;
            $data['company_id'] = $request->company_id;
            $data['termination_type'] = $request->termination_type;
            $data['description'] = $request->description;
            $data['termination_date'] = $request->termination_date;
            $data['notice_date'] = $request->notice_date;
            Termination::create($data);

            $notifiable = User::findOrFail($data['terminated_employee']);

            $this->employeeLeaveDateSet($request->terminated_employee, $request->termination_date);

            $notifiable->notify(new EmployeeTerminationNotify($data['termination_date']));

            return response()->json(['success' => __('Data Added successfully.')]);
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = Termination::findOrFail($id);
            $company_name = $data->company->company_name ?? '';

            $termination_to = $data->employee->full_name;

            $termination_type_name = $data->TerminationType->termination_title;

            return response()->json(['data' => $data, 'termination_to_employee' => $termination_to, 'company_name' => $company_name, 'termination_type_name' => $termination_type_name]);
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Termination::findOrFail($id);
            $employees = Employee::select('id', 'first_name', 'last_name')->where('company_id', $data->company_id)->where('is_active', 1)->get();

            return response()->json(['data' => $data, 'employees' => $employees]);
        }
    }

    public function update(Request $request)
    {

        $logged_user = auth()->user();

        if ($logged_user->can('edit-termination')) {
            $id = $request->hidden_id;
            $validator = Validator::make(
                $request->only(
                    'description',
                    'company_id',
                    'terminated_employee',
                    'termination_type',
                    'termination_date',
                    'notice_date'
                ),
                [
                    'company_id' => 'required',
                    'terminated_employee' => 'required',
                    'termination_type' => 'required',
                    'termination_date' => 'required',
                    'notice_date' => 'required',
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $data = [];
            $data['description'] = $request->description;
            $data['termination_date'] = $request->termination_date;
            $data['notice_date'] = $request->notice_date;
            $data['company_id'] = $request->company_id;
            $data['terminated_employee'] = $request->terminated_employee;
            $data['termination_type'] = $request->termination_type;

            Termination::find($id)->update($data);
            $notifiable = User::findOrFail($data['terminated_employee']);

            Employee::where('id', $request->terminated_employee)
                ->update(['exit_date' => $request->termination_date]);

            $this->employeeLeaveDateSet($request->terminated_employee, $request->termination_date);
            $notifiable->notify(new EmployeeTerminationNotify($data['termination_date']));

            return response()->json(['success' => __('Data is successfully updated')]);
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function destroy($id)
    {
        if (! env('USER_VERIFIED')) {
            return response()->json(['error' => 'This feature is disabled for demo!']);
        }
        $logged_user = auth()->user();

        if ($logged_user->can('delete-termination')) {
            $termination = Termination::find($id);
            $termination->delete();

            Employee::where('id', $termination->terminated_employee)
                ->update(['exit_date' => null]);

            return response()->json(['success' => __('Data is successfully deleted')]);
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function delete_by_selection(Request $request)
    {
        if (! env('USER_VERIFIED')) {
            return response()->json(['error' => 'This feature is disabled for demo!']);
        }
        $logged_user = auth()->user();

        if ($logged_user->can('delete-termination')) {

            $termination_id = $request['terminationIdArray'];
            $termination = Termination::whereIntegerInRaw('id', $termination_id);
            if ($termination->delete()) {
                return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Termination')])]);
            } else {
                return response()->json(['error' => 'Error, selected Terminations can not be deleted']);
            }
        }

        return response()->json(['success' => __('You are not authorized')]);
    }

    public function restore(Termination $termination)
    {
        Employee::where('id', $termination->terminated_employee)
            ->update(['exit_date' => null]);
        $termination->delete();

        return redirect()->back()->with([
            'message' => 'Successfully Restored',
            'type' => 'success',
        ]);
    }

    protected function employeeLeaveDateSet($employee_id, $date)
    {
        $employee = Employee::find($employee_id);
        $employee->exit_date = $date;
        $employee->update();
    }
}
