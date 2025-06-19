<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Employee;
use App\Notifications\EmployeeTravelStatus;
use App\Models\Travel;
use App\Models\TravelType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TravelController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		$travel_types = TravelType::select('id', 'arrangement_type')->get();

		if ($logged_user->can('view-travel'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Travel::with('company', 'employee')->get())
					->setRowId(function ($travel)
					{
						return $travel->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name;
					})
					->addColumn('employee', function ($row)
					{
						return $row->employee->full_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('user-edit'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('user-edit'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('core_hr.travel.index', compact('companies', 'travel_types'));
		}

		return abort('403', __('You are not authorized'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		if (auth()->user()->can('store-travel') || auth()->user())
		{
			$validator = Validator::make($request->only('description', 'travel_type_id', 'status', 'company_id', 'travel_mode', 'employee_id', 'start_date', 'end_date', 'purpose_of_visit',
				'place_of_visit', 'expected_budget', 'actual_budget'),
				[
					'company_id' => 'required',
					'employee_id' => 'required',
					'travel_type_id' => 'required',
					'place_of_visit' => 'required',
					'purpose_of_visit' => 'required',
					'start_date' => 'required',
					'end_date' => 'required|after_or_equal:start_date',
					'status' => 'required',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data['travel_type'] = $request->travel_type_id;
			$data ['description'] = $request->description;
			$data['travel_mode'] = $request->travel_mode;
			$data['purpose_of_visit'] = $request->purpose_of_visit;
			$data['place_of_visit'] = $request->place_of_visit;
			$data['expected_budget'] = $request->expected_budget;
			$data ['actual_budget'] = $request->actual_budget;
			$data ['status'] = $request->status;
			$data ['start_date'] = $request->start_date;
			$data ['end_date'] = $request->end_date;


			$travel = Travel::create($data);

			if($travel->status != 'pending')
			{
				$notifiable = User::findOrFail($data['employee_id']);

				$notifiable->notify(new EmployeeTravelStatus($travel->status));
			}
			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function show($id)
	{
		if (request()->ajax())
		{
			$data = Travel::findOrFail($id);

			$company_name = $data->company->company_name ?? '';
			$first_name = $data->employee->first_name ?? '';
			$last_name = $data->employee->last_name ?? '';
			$employee_name = $first_name . ' ' . $last_name;
			$arrangement_name = $data->TravelType->arrangement_type ?? '';

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'arrangement_name' => $arrangement_name]);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (request()->ajax())
		{
			$data = Travel::with('company:id,company_name', 'employee:id,first_name,last_name')
				->findOrFail($id);

			$employees = Employee::select('id', 'first_name', 'last_name')
				->where('company_id', $data->company_id)->where('is_active',1)->where('exit_date',NULL)->get();

			return response()->json(['data' => $data, 'employees' => $employees]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-travel'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('description', 'travel_type_id', 'status', 'company_id', 'travel_mode', 'employee_id', 'start_date', 'end_date', 'purpose_of_visit',
				'place_of_visit', 'expected_budget', 'actual_budget'),
				[
					'company_id' => 'required',
					'employee_id' => 'required',
					'travel_type_id' => 'required',
					'place_of_visit' => 'required',
					'purpose_of_visit' => 'required',
					'start_date' => 'required',
					'end_date' => 'required|after_or_equal:start_date',
					'status' => 'required',

				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];


			$data ['description'] = $request->description;
			$data['travel_mode'] = $request->travel_mode;
			$data['purpose_of_visit'] = $request->purpose_of_visit;
			$data['place_of_visit'] = $request->place_of_visit;
			$data['expected_budget'] = $request->expected_budget;
			$data ['actual_budget'] = $request->actual_budget;
			$data ['start_date'] = $request->start_date;
			$data ['end_date'] = $request->end_date;

			$data['employee_id'] = $request->employee_id;

			$data ['company_id'] = $request->company_id;

			$data['status'] = $request->status;

			$data['travel_type'] = $request->travel_type_id;

			Travel::find($id)->update($data);

			if($data['status'] != 'pending')
			{
				$notifiable = User::findOrFail($data['employee_id']);

				$notifiable->notify(new EmployeeTravelStatus($data['status']));
			}

			return response()->json(['success' => __('Data is successfully updated')]);
		} else
		{

			return response()->json(['success' => __('You are not authorized')]);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-travel'))
		{
			Travel::whereId($id)->delete();

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

		if ($logged_user->can('delete-travel'))
		{

			$travel_id = $request['travelIdArray'];
			$travel = Travel::whereIntegerInRaw('id', $travel_id);
			if ($travel->delete())
			{
				return response()->json(['success' => 'Selected travels has been deleted']);
			} else
			{
				return response()->json(['error' => 'Error, selected travels can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}


	public function calendarableDetails($id)
	{
		if (request()->ajax())
		{
			$data = Travel::with('company:id,company_name',
				'TravelType:id,arrangement_type', 'employee:id,first_name,last_name')->findOrFail($id);

			$new = [];

			$new['Company'] = $data->company->company_name;
			$new['Employee'] = $data->employee->full_name;
			$new['Start Date'] = $data->start_date;
			$new['End Date'] = $data->end_date;
			$new['Purpose Of Visit'] = $data->purpose_of_visit;
			$new['Place Of Visit'] = $data->place_of_visit;
			$new['Arrangement Type'] = $data->TravelType->arrangement_type;
			$new['Description'] = $data->description;
			$new['Expected Budget'] = $data->expected_budget;
			$new['Actual Budget'] = $data->actual_budget;
			$new['Travel Mode'] = $data->travel_mode;
			$new['Status'] = $data->status;

			return response()->json(['data' => $new]);
		}
	}
}
