<?php

namespace App\Http\Controllers\Performance;

use App\Models\company;
use App\Models\designation;
use App\Http\Controllers\Controller;
use App\Models\Indicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class IndicatorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $indicators = Indicator::with('designation:id,designation_name','company:id,company_name','department:id,department_name')->get();

            return DataTables::of($indicators)
                ->setRowId(function ($row)
                {
                    return $row->id;
                })
                ->addIndexColumn()
                ->addColumn('designation_name', function ($row)
                {
                    return $row->designation->designation_name ?? '' ;
                })
                ->addColumn('company_name', function ($row)
                {
                    return $row->company->company_name ?? '' ;
                })
                ->addColumn('department_name', function ($row)
                {
                    return $row->department->department_name ?? '';
                })
                ->addColumn('created_at', function ($row)
                {
                    return date("d M, Y", strtotime($row->created_at));
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

        return view('performance.indicator.index',compact('companies'));
    }

    public function getDesignationByComapny(Request $request)
    {
        if ($request->ajax()) 
        {
            $designations = designation::where('company_id',$request->company_id)
                                        ->select('id','designation_name')
                                        ->orderBy('designation_name','ASC')
                                        ->get();
            return response()->json(['designations' => $designations]);
        }
    }

    public function store(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('store-indicator'))
		{
            if ($request->ajax()){

                $validator = Validator::make($request->only('company_id','designation_id'),[ 
                                'company_id' => 'required',
                                'designation_id' => 'required'
                            ]);
                if ($validator->fails()){
                    return response()->json(['errors' => "<b>Please fill the required Option</b>"]);
                }
    
                $designation = designation::find($request->designation_id);
    
                $indicator = new Indicator();
                $indicator->company_id     = $request->company_id;
                $indicator->designation_id = $designation->id;
                $indicator->department_id  = $designation->department->id;
                $indicator->customer_experience  = $request->customer_experience;
                $indicator->marketing      = $request->marketing;
                $indicator->administrator  = $request->administrator;
                $indicator->professionalism= $request->professionalism;
                $indicator->integrity      = $request->integrity;
                $indicator->attendance     = $request->attendance;
                $indicator->added_by       = Auth::user()->username;
                $indicator->save();
    
                return response()->json(['success' => '<p><b>Data Saved Successfully.</b></p>']);
            }
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $indicator = Indicator::find($request->id);
            $designations = designation::select('id','designation_name')->where('company_id',$indicator->company_id)->get();

            return response()->json(['indicator' => $indicator, 'designations' => $designations]);
        }
    }

    public function update(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('edit-indicator'))
		{
            if ($request->ajax()) {

                $designation = designation::find($request->designation_id);
    
                $indicator = Indicator::find($request->indicator_id);
                $indicator->company_id     = $request->company_id;
                $indicator->designation_id = $request->designation_id;
                $indicator->department_id  = $designation->department_id; //If Designation is changed, then the department Id also be changed.
                $indicator->customer_experience = $request->customer_experience;
                $indicator->marketing      = $request->marketing;
                $indicator->administrator  = $request->administrator;
                $indicator->professionalism= $request->professionalism;
                $indicator->integrity      = $request->integrity;
                $indicator->attendance     = $request->attendance;
                $indicator->update();
    
                return response()->json(['success' => '<p><b>Data Updated Successfully.</b></p>']);
            }
        }
    }

    public function delete(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('delete-indicator'))
		{
            if ($request->ajax()) 
            {
                $data = Indicator::find($request->indicator_id);
                $data->delete();

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
                $data = Indicator::find($all_id[$i]);
                $data->delete();
            }

            return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
        }
    }
}
