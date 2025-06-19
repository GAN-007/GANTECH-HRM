<?php

namespace App\Http\Controllers\Performance;

use App\Models\Appraisal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\company;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AppraisalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $appraisals = Appraisal::with('company:id,company_name','employee:id,first_name,last_name','department:id,department_name','designation:id,designation_name')
                        ->orderBy('id','DESC')->get();

            return DataTables::of($appraisals)
                ->setRowId(function ($row)
                {
                    return $row->id;
                })
                ->addIndexColumn()
                ->addColumn('company_name', function ($row)
                {
                    return $row->company->company_name ?? '' ;
                })
                ->addColumn('employee_name', function ($row)
                {
                    if ($row->employee) {
                        return $row->employee->first_name.' '.$row->employee->last_name;
                    }else {
                        return '';
                    }

                })
                ->addColumn('department_name', function ($row)
                {
                    return $row->department->department_name ?? '';
                })
                ->addColumn('designation_name', function ($row)
                {
                    return $row->designation->designation_name ?? '' ;
                })
                ->addColumn('date', function ($row)
                {
                    return date("d M, Y", strtotime($row->date));;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" name="edit" data-id="'.$row->id.'" class="edit btn btn-success btn-sm"><i class="dripicons-pencil"></i></a>
                                &nbsp;
                                <a href="javascript:void(0)" name="delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $companies = company::select('id','company_name')->get();

        return view('performance.appraisal.index',compact('companies'));
    }

    public function getEmployee(Request $request)
    {
        $employees = Employee::where('company_id',$request->company_id)
                    ->select('id','first_name','last_name')
                    ->where('is_active',1)->where('exit_date',NULL)
                    ->get();

        return response()->json(['employees' => $employees]);
    }

    public function store(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('store-appraisal'))
		{
            if ($request->ajax())
            {
                $validator = Validator::make($request->only('company_id','employee_id'),[
                    'company_id' => 'required',
                    'employee_id' => 'required'
                ]);

                if ($validator->fails())
                {
                    return response()->json(['errors' => "<h3>Please fill the required option</h3>"]);
                }

                $employee = Employee::find($request->employee_id);

                $appraisal                = new Appraisal();
                $appraisal->company_id    = $request->company_id;
                $appraisal->employee_id   = $request->employee_id;
                $appraisal->department_id = $employee->department_id;
                $appraisal->designation_id= $employee->designation_id;
                $appraisal->customer_experience = $request->customer_experience;
                $appraisal->marketing     = $request->marketing;
                $appraisal->administration= $request->administration;
                $appraisal->professionalism = $request->professionalism;
                $appraisal->integrity     = $request->integrity;
                $appraisal->attendance    = $request->attendance;
                $appraisal->remarks       = $request->remarks;
                $appraisal->date          = $request->date;
                $appraisal->save();

                return response()->json(['success' => '<p><b>Data Saved Successfully.</b></p>']);
            }
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax())
        {
            $appraisal = Appraisal::find($request->id);
            $employees = Employee::select('id','first_name','last_name')->where('company_id',$appraisal->company_id)->where('is_active',1)->where('exit_date',NULL)->get();

            return response()->json(['appraisal' => $appraisal, 'employees'=> $employees]);
        }
    }

    public function update(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('edit-appraisal'))
		{
            if ($request->ajax())
            {
                $appraisal = Appraisal::find($request->appraisal_id);
                $employee  = Employee::find($request->employee_id);

                $appraisal->company_id    = $request->company_id;
                $appraisal->employee_id   = $request->employee_id;
                $appraisal->department_id = $employee->department_id;
                $appraisal->designation_id= $employee->designation_id;
                $appraisal->date          = $request->date          ;
                $appraisal->customer_experience = $request->customer_experience;
                $appraisal->marketing     = $request->marketing;
                $appraisal->administration= $request->administration;
                $appraisal->professionalism = $request->professionalism;
                $appraisal->integrity     = $request->integrity;
                $appraisal->attendance    = $request->attendance;
                $appraisal->remarks       = $request->remarks;
                $appraisal->update();

                return response()->json(['success' => '<p><b>Data Updated Successfully.</b></p>']);
            }
        }
    }

    public function delete(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('delete-appraisal'))
		{
            if ($request->ajax()) {
                $appraisal = Appraisal::find($request->appraisal_id);
                $appraisal->delete();

                return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
            }
        }
    }

    public function deleteCheckbox(Request $request)
    {
        if ($request->ajax())
        {
            $all_id   = $request->all_checkbox_id;
            $total_id = count($all_id);
            for ($i=0; $i < $total_id; $i++) {
                $data = Appraisal::find($all_id[$i]);
                $data->delete();
            }

            return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
        }
    }
}
