<?php

namespace App\Http\Controllers\Performance;

use App\Models\company;
use App\Models\GoalTracking;
use App\Models\GoalType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class GoalTrackingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $goal_trackings = GoalTracking::with('company:id,company_name','goalType:id,goal_type')->orderBy('id','ASC')->get();

            return DataTables::of($goal_trackings)
                ->setRowId(function ($row)
                {
                    return $row->id;
                })
                ->addIndexColumn()
                ->addColumn('goal_type', function ($row)
                {
                    return $row->goalType->goal_type ?? '' ;
                })
                ->addColumn('company_name', function ($row)
                {
                    return $row->company->company_name ?? '' ;
                })
                ->addColumn('start_date', function ($row)
                {
                    return date("d M, Y", strtotime($row->start_date));
                })
                ->addColumn('end_date', function ($row)
                {
                    return date("d M, Y", strtotime($row->end_date));
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
        $goal_types = GoalType::select('id','goal_type')->get();

        return view('performance.goal-tracking.index',compact('companies','goal_types'));
    }

    public function store(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('store-goal-tracking'))
		{
            if ($request->ajax()) 
            {
            
                $validator = Validator::make($request->all(),[ 
                    'company_id'   => 'required',
                    'goal_type_id' => 'required',
                    'subject'      => 'required',
                    'target_achievement' => 'required',
                    'start_date'   => 'required',
                    'end_date'     => 'required',
                ]);


                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                if($request->start_date > $request->end_date)
                {
                    return response()->json(['date_errors' => '<p style="color:#FFFFFF"><b>Start-Date</b> can not be greater than <b>End-Date</b></p>']);
                }

                $goal_tracking = new GoalTracking();
                $goal_tracking->company_id   = $request->company_id;
                $goal_tracking->goal_type_id = $request->goal_type_id;
                $goal_tracking->subject      = $request->subject;   
                $goal_tracking->target_achievement = $request->target_achievement;
                $goal_tracking->description  = $request->description;
                $goal_tracking->start_date   = $request->start_date;
                $goal_tracking->end_date     = $request->end_date;
                $goal_tracking->save();

                return response()->json(['success' => '<p><b>Data Saved Successfully.</b></p>']);
                
            }
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $goalTracking = GoalTracking::findOrFail($request->id);
            return response()->json(['goalTracking' => $goalTracking]);
        }
    }

    public function update(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('edit-goal-tracking'))
		{
            if ($request->ajax())
            {
                $validator = Validator::make($request->only('subject','target_achievement'),[ 
                    'subject'      => 'required',
                    'target_achievement' => 'required',
                ]);

                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $goal_tracking = GoalTracking::find($request->goal_tracking_id);
                $goal_tracking->company_id   = $request->company_id;
                $goal_tracking->goal_type_id = $request->goal_type_id;
                $goal_tracking->subject      = $request->subject;   
                $goal_tracking->target_achievement = $request->target_achievement;
                $goal_tracking->description  = $request->description;
                $goal_tracking->start_date   = $request->start_date;
                $goal_tracking->progress     = $request->progress;
                $goal_tracking->status       = $request->status;
                $goal_tracking->update();

                return response()->json(['success' => '<p><b>Data Updated Successfully.</b></p>']);
            }
        }        
    }

    public function delete(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('delete-goal-tracking'))
		{
            if ($request->ajax()) 
            {
                $goal_tracking = GoalTracking::find($request->goal_tracking_id);
                $goal_tracking->delete();

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
                $data = GoalTracking::find($all_id[$i]);
                $data->delete();
            }

            return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
        }
    }
}
