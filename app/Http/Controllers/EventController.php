<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\department;
use App\Models\Employee;
use App\Models\Event;
use App\Notifications\EventNotify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if ($logged_user->can('view-event'))
		{
			if (request()->ajax())
			{
				return datatables()->of(event::with('company', 'department')->get())
					->setRowId(function ($event)
					{
						return $event->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('department', function ($row)
					{
						return $row->department->department_name ?? '';
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-event'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-event'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('event and meeting.event.index', compact('companies'));
		}

		return abort('403', __('You are not authorized'));
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


		if ($logged_user->can('store-event'))
		{
			$validator = Validator::make($request->only('event_title', 'company_id', 'department_id', 'event_note', 'event_date', 'event_time',
				'status', 'is_notify'
			),
				[
					'company_id' => 'required',
					'department_id' => 'required',
					'event_title' => 'required',
					'status' => 'required',
					'event_date' => 'required',
					'event_time' => 'required'
				]
//				,
//				[
//					'company_id.required' => 'Please select an company',
//					'department_id.required' => 'Please select the department',
//					'event_title.required' => 'Event Title can not be empty',
//					'status.required' => 'Please select status',
//					'event_date.required' => 'Please select a date',
//					'event_time.required' => 'Please select time',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['company_id'] = $request->company_id;
			$data['department_id'] = $request->department_id;
			$data['event_title'] = $request->event_title;
			$data ['event_note'] = $request->event_note;
			$data ['status'] = $request->status;
			$data ['is_notify'] = $request->is_notify;
			$data ['event_date'] = $request->event_date;
			$data ['event_time'] = $request->event_time;

			Event::create($data);

			if($data ['is_notify'] == 1 && $data ['status']== 'approved' )
			{
				if ($data['department_id'] == null)
				{
					$employee_id = Employee::where('company_id', $data ['company_id'])->pluck('id');
					$notifiable = User::whereIntegerInRaw('id', $employee_id)->get();
				} else
				{
					$employee_id = Employee::where('department_id', $data ['department_id'])->pluck('id');
					$notifiable = User::whereIntegerInRaw('id', $employee_id)->get();
				}
				Notification::send($notifiable, new EventNotify($data));
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
			$data = Event::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$department = $data->department->department_name ?? '';

			$event_date_name = $data->event_date;


			return response()->json(['data' => $data, 'company_name' => $company_name, 'department' => $department,
				'event_date_name' => $event_date_name]);
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
			$data = Event::findOrFail($id);


			$departments = department::select('id', 'department_name')
				->where('company_id', $data->company_id)->get();

			return response()->json(['data' => $data, 'departments' => $departments
			]);
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

		if ($logged_user->can('edit-event'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('event_title', 'company_id', 'department_id', 'event_note', 'event_date', 'event_time',
				'status', 'is_notify'
			),
				[
					'company_id' => 'required',
					'department_id' => 'required',
					'event_title' => 'required',
					'status' => 'required',
					'event_date' => 'required',
					'event_time' => 'required'
				]
//				,
//				[
//					'event_title.required' => 'Event Title can not be empty',
//					'event_date.required' => 'Please select a date',
//					'event_time.required' => 'Please select time',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['event_title'] = $request->event_title;
			$data ['event_note'] = $request->event_note;
			$data ['is_notify'] = $request->is_notify;
			$data ['event_date'] = $request->event_date;
			$data ['event_time'] = $request->event_time;

			$data ['company_id'] = $request->company_id;

			$data ['department_id'] = $request->department_id;

			$data ['status'] = $request->status;



			Event::find($id)->update($data);

			if ($data ['is_notify'] == 1 && $data ['status'] == 'approved')
			{
				if ($data['department_id'] == null)
				{
					$employee_id = Employee::where('company_id', $data ['company_id'])
                                    ->where('is_active',1)
                                    ->where('exit_date',NULL)
                                    ->pluck('id');
					$notifiable = User::whereIntegerInRaw('id', $employee_id)->get();
				} else
				{
					$employee_id = Employee::where('department_id', $data ['department_id'])
                                    ->where('is_active',1)
                                    ->where('exit_date',NULL)
                                    ->pluck('id');
					$notifiable = User::whereIntegerInRaw('id', $employee_id)->get();
				}
				Notification::send($notifiable, new EventNotify($data));
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

		if ($logged_user->can('delete-event'))
		{
			Event::whereId($id)->delete();

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

		if ($logged_user->can('delete-event'))
		{

			$event_id = $request['eventIdArray'];
			$event = Event::whereIntegerInRaw('id', $event_id);
			if ($event->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Event')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected Events can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function calendarableDetails($id)
	{
		if (request()->ajax())
		{
			$data = Event::with('company:id,company_name',
				'department:id,department_name')->findOrFail($id);

			$new = [];

			$new['Company Name'] = $data->company->company_name;
			$new['Department'] = $data->department->department_name;
			$new['Event Title'] = $data->event_title;
			$new['Event Date'] = $data->event_date;
			$new['Event Time'] = $data->event_time;
			$new['Event Note'] = $data->event_note;

			return response()->json(['data' => $new]);
		}
	}

}
