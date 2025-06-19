<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;


class LocationController extends Controller
{
	public function index()
	{
		$countries = \DB::table('countries')->select('id','name')->get();
		$employees = Employee::select('id','first_name','last_name')->where('is_active',1)->where('exit_date',NULL)->get();

		if(request()->ajax())
		{
			return datatables()->of(location::with('Country:id,name','LocationHead:id,first_name,last_name')->latest()->get())
				->addColumn('country', function ($row)
				{
					return $row->Country->name ;
				})
				->addColumn('location_head', function ($row)
				{
					return $row->LocationHead->full_name ?? ' ' ;
				})
				->addColumn('action', function($data){
					$button = '';
					if (auth()->user()->can('edit-location'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
					}
					if (auth()->user()->can('edit-location'))
					{
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
					}
					return $button;
				})
				->rawColumns(['action'])
				->make(true);
		}
		return view('organization.location.index',compact('countries','employees'));
	}


	public function store(Request $request)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('store-location'))
		{

			$validator = Validator::make($request->only('location_name', 'location_head', 'address1', 'address2', 'city',
				'state', 'country', 'zip'),
				[
					'location_name' => 'required|unique:locations,location_name,',
					'address1' => 'required',
					'zip' => 'nullable|numeric',
					'country'=> 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['location_name'] = $request->location_name;
			if ($request->location_head)
			{
				$data['location_head'] = $request->location_head;
			}
			$data ['address1'] = $request->address1;
			$data ['address2'] = $request->address2;
			$data ['city'] = $request->city;
			$data ['state'] = $request->state;
			$data ['country'] = $request->country;
			$data ['zip'] = $request->zip;


			location::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	public function edit($id)
	{

		if(request()->ajax())
		{
			$data = location::findOrFail($id);
			return response()->json(['data' => $data]);
		}
	}






	public function update(Request $request)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('edit-location'))
		{
           $id = $request->hidden_id;

			$data = $request->only('location_name', 'location_head', 'address1', 'address2', 'city',
				'state', 'country', 'zip');

			if ($data['location_head'] == '')
			{
				$data['location_head'] = null;
			}


			$validator = Validator::make($request->only('location_name', 'location_head', 'address1', 'address2', 'city',
				'state', 'country', 'zip'),
				[
					'location_name' => 'required|unique:locations,location_name,' . $id,
					'location_head' => 'nullable',
					'address1' => 'required',
					'zip' => 'nullable|numeric',
					'country'=> 'required'
				]
			);



			if ($validator->fails())
			{
				return response()->json(['errors'=>$validator->errors()->all()]);
			}


			location::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);

		}
		return response()->json(['success' => __('You are not authorized')]);
	}


	public function delete($id)
	{

		if(!env('USER_VERIFIED'))
		{
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-location'))
		{
		     location::whereId($id)->delete();
		     return "success";

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

		if ($logged_user->can('delete-location'))
		{

			$location_id = $request['locationIdArray'];
			$location = location::whereIntegerInRaw('id', $location_id);
			if ($location->delete())
			{
				return response()->json(['success' => __('Multi Delete',['key'=>trans('file.Location')])]);
			}
			else {
				return response()->json(['error' => 'Error selected Locations can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


}
