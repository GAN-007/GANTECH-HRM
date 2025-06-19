<?php

namespace App\Http\Controllers;

use App\Models\IpSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class IPSettingController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->can('view-general-setting'))
		{
            if ($request->ajax())
            {
                $ip_settings = IpSetting::orderBy('id','DESC')->get();
                return DataTables::of($ip_settings)
                    ->setRowId(function ($row)
                    {
                        return $row->id;
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

            return view('ip_setting.index');
        }

        return abort('403', __('You are not authorized'));


    }



    public function store(Request $request)
    {
        if (auth()->user()->can('store-general-setting'))
		{
            if ($request->ajax()) {
                $validator = Validator::make($request->only('name','ip_address'),[
                    'name' => 'required|unique:ip_settings',
                    'ip_address' => 'required|unique:ip_settings',
                ]);

                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $ip_setting             = new IpSetting();
                $ip_setting->name       = $request->name;
                $ip_setting->ip_address = $request->ip_address;
                $ip_setting->save();

                return response()->json(['success' => 'Data Saved Successfully']);
            }
        }

        return abort('403', __('You are not authorized'));
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $ip_setting = IpSetting::find($request->id);
            return response()->json(['id'=>$request->id ,'name' => $ip_setting->name, 'ip_address'=>$ip_setting->ip_address]);
        }

    }


    public function update(Request $request)
    {
        if (auth()->user()->can('store-general-setting'))
		{

            if ($request->ajax()) {

                $validator = Validator::make($request->only('name','ip_address'),[
                    'name' => 'required|unique:ip_settings,name,'.$request->id,
                    'ip_address' => 'required|unique:ip_settings,ip_address,'.$request->id,
                ]);

                if ($validator->fails()){
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $ip_setting = IpSetting::find($request->id);
                $ip_setting->name       = $request->name;
                $ip_setting->ip_address = $request->ip_address;
                $ip_setting->update();

                return response()->json(['success' => 'Data Updated Successfully']);
            }
        }
        return abort('403', __('You are not authorized'));
    }


    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $ip_setting = IpSetting::find($request->id);
            $ip_setting->delete();

            return response()->json(['success' => '<div class="alert alert-success">Data Deleted Successfully</div>']);
        }
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ajax()) {

            IpSetting::whereIntegerInRaw('id',$request->idsArray)->delete();
            return response()->json(['success' => '<div class="alert alert-success">Data Deleted Successfully</div>']);
        }
    }
}
