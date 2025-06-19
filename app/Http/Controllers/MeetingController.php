<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Employee;
use App\Models\Meeting;
use App\Notifications\EventNotify;
use App\Notifications\MeetingNotify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		if ($logged_user->can('view-meeting'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Meeting::with('company', 'employees')->get())
					->setRowId(function ($meeting)
					{
						return $meeting->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('employee', function ($row)
					{
						$name = $row->employees->pluck('last_name', 'first_name');
						$collection = [];
						foreach ($name as $first => $last)
						{
							$full_name = $first . ' ' . $last;
							array_push($collection, $full_name);
						}

						return $collection;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-meeting'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-meeting'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('event and meeting.meeting.index', compact('companies'));
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
		$logged_user = auth()->user();

		if ($logged_user->can('store-meeting'))
		{
			$validator = Validator::make($request->only('meeting_title', 'company_id', 'employee_id', 'meeting_note', 'meeting_date', 'meeting_time',
				'status', 'is_notify'
			),
				[
					'company_id' => 'required',
					'employee_id' => 'required',
					'meeting_title' => 'required',
					'status' => 'required',
					'meeting_date' => 'required',
					'meeting_time' => 'required'
				]
//				,
//				[
//					'company_id.required' => 'Please select an company',
//					'employee_id.required' => 'Please select the employee',
//					'meeting_title.required' => 'Meeting Title can not be empty',
//					'status.required' => 'Please select status',
//					'meeting_date.required' => 'Please select a date',
//					'meeting_time.required' => 'Please select time',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['company_id'] = $request->company_id;
			$data['meeting_title'] = $request->meeting_title;
			$data ['meeting_note'] = $request->meeting_note;
			$data ['status'] = $request->status;
			$data ['is_notify'] = $request->is_notify;
			$data ['meeting_date'] = $request->meeting_date;
			$data ['meeting_time'] = $request->meeting_time;

			$meeting = Meeting::create($data);

			$employees = $request->input('employee_id');
			$meeting->employees()->attach($employees);

			if ($data ['is_notify'] == 1 && ($data ['status'] == 'pending' || ($data ['status'] == 'postponed')))
			{
				$notifiable = User::whereIntegerInRaw('id', $employees)->get();
				Notification::send($notifiable, new MeetingNotify($meeting));
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
			$data = Meeting::findOrFail($id);
			$company_name = $data->company->company_name ?? '';

			$name = $data->employees->pluck('last_name', 'first_name');
			$collection = [];
			foreach ($name as $first => $last)
			{
				$full_name = $first . ' ' . $last . '<br>';
				array_push($collection, $full_name);
			}

			$meeting_date_name = $data->meeting_date;

			return response()->json(['data' => $data, 'company_name' => $company_name, 'employee_name' => $collection,
				'meeting_date_name' => $meeting_date_name]);
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
			$data = Meeting::findOrFail($id);
			$employees = Employee::select('id', 'first_name', 'last_name')->where('company_id', $data->company_id)->where('is_active',1)->where('exit_date',NULL)->get();

			$selected_employee = $data->employees->pluck('id');

			return response()->json(['data' => $data, 'employees' => $employees,
				'selected_employee' => $selected_employee]);
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

		if ($logged_user->can('edit-meeting'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('meeting_title', 'company_id', 'employee_id', 'meeting_note', 'meeting_date', 'meeting_time',
				'status', 'is_notify'
			),
				[
					'company_id' => 'required',
					'employee_id' => 'required',
					'meeting_title' => 'required',
					'status' => 'required',
					'meeting_date' => 'required',
					'meeting_time' => 'required'
				]
//				,
//				[
//					'meeting_title.required' => 'Meeting Title can not be empty',
//					'meeting_date.required' => 'Please select a date',
//					'meeting_time.required' => 'Please select time',
//				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['meeting_title'] = $request->meeting_title;
			$data ['meeting_note'] = $request->meeting_note;
			$data ['is_notify'] = $request->is_notify;
			$data ['meeting_date'] = $request->meeting_date;
			$data ['meeting_time'] = $request->meeting_time;


			$data ['company_id'] = $request->company_id;
			$data ['status'] = $request->status;

			Meeting::find($id)->update($data);

			if ($request->input('employee_id'))
			{
				$training = Meeting::findOrFail($id);
				$employees = $request->input('employee_id');
				$training->employees()->sync($employees);
			}

			return response()->json(['success' => __('Data is successfully updated')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-meeting'))
		{
			Meeting::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		if (!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-meeting'))
		{

			$meeting_id = $request['meetingIdArray'];
			$meeting = Meeting::whereIntegerInRaw('id', $meeting_id);
			if ($meeting->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Meeting')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected Meetings can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function calendarableDetails($id)
	{
		if (request()->ajax())
		{
			$data = Meeting::with('company:id,company_name',
				'employees:id,first_name,last_name')->findOrFail($id);

			$new = [];

			$new['Company'] = $data->company->company_name;
			$name = $data->employees->pluck('last_name', 'first_name');
			$collection = [];
			foreach ($name as $first => $last)
			{
				$full_name = $first . ' ' . $last . '<br>';
				array_push($collection, $full_name);
			}

			$new['Employee'] = $collection;
			$new['Meeting Title'] = $data->meeting_title;
			$new['Meeting Date'] = $data->meeting_date;
			$new['Meeting Time'] = $data->meeting_time;
			$new['Meeting Note'] = $data->meeting_note;

			return response()->json(['data' => $new]);
		}
	}
}
