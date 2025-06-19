<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\company;
use App\Models\department;
use App\Models\Employee;
use App\Notifications\AnnouncementPublished;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller {

	public function index()
	{

		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if (request()->ajax())
		{
			if ($logged_user->role_users_id == 1)
			{
				$announcements = Announcement::with('company', 'department')->latest();
			}
			else
			{
				$employee = Employee::findOrFail($logged_user->id);
				$announcements = Announcement::with('company', 'department')
					->where('company_id',$employee->company_id)
					->where('department_id',$employee->department_id)
					->orWhere('department_id','=',NULL)
					->get();
			}

			return datatables()->of($announcements)
				->setRowId(function ($announcement)
				{
					return $announcement->id;
				})
				->addColumn('company', function ($row)
				{
					return $row->company->company_name ?? ' ';
				})
				->addColumn('department', function ($row)
				{
					// return empty($row->department->department_name) ? 'All Department' : $row->department->department_name;
					return empty($row->department->department_name) ? __(trans('file.All_Department')) : $row->department->department_name;
				})
				->addColumn('action', function ($data)
				{
					$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
					$button .= '&nbsp;&nbsp;';
					if (auth()->user()->can('edit-announcement'))
					{
						$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
					}
					if (auth()->user()->can('delete-announcement'))
					{
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
					}

					return $button;
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('organization.announcement.index', compact('companies'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public
	function store(Request $request)
	{
		$logged_user = auth()->user();


		if ($logged_user->can('store-announcement'))
		{
			$validator = Validator::make($request->only('title', 'start_date', 'end_date', 'summary', 'description', 'is_notify', 'company_id', 'department_id', 'is_active'),
				[
					'title' => 'required|unique:announcements,title,',
					'start_date' => 'required',
					'end_date' => 'required',
					'company_id' => 'required',
					'department_id' => 'required',

				]);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['title'] = $request->title;
			$data['start_date'] = $request->start_date;
			$data['end_date'] = $request->end_date;
			$data['summary'] = $request->summary;
			$data['description'] = $request->description;
			$data['company_id'] = $request->company_id;
			if($request->department_id != 0)
			{
				$data ['department_id'] = $request->department_id;
			}
			else {
				$data ['department_id'] = null;
			}
			$data['added_by'] = $logged_user->username;
			$data['is_notify'] = $request->is_notify;


			Announcement::create($data);

			if ($data['department_id'] == null)
			{
				$employee_id = Employee::where('company_id',$data ['company_id'])->where('is_active',1)->pluck('id');
				$notifiable = User::whereIntegerInRaw('id',$employee_id)->get();
			}
			else
			{
				$employee_id = Employee::where('department_id',$data ['department_id'])->where('is_active',1)->pluck('id');
				$notifiable = User::whereIntegerInRaw('id',$employee_id)->get();
			}

			Notification::send($notifiable,new AnnouncementPublished());

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
	public
	function show($id)
	{
		if (request()->ajax())
		{
			$data = Announcement::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$department_name = $data->department->department_name ?? '';

			return response()->json(['data' => $data, 'department_name' => $department_name, 'company_name' => $company_name]);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public
	function edit($id)
	{

		if (request()->ajax())
		{
			$data = Announcement::findOrFail($id);

			$departments = Department::select('id', 'department_name')->where('company_id', $data->company_id)->get();

			return response()->json(['data' => $data, 'departments' => $departments]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return Response
	 */
	public
	function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('edit-announcement'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('title', 'start_date', 'end_date', 'summary', 'description', 'is_notify', 'company_id', 'department_id', 'is_active'),
				[
					'title' => 'required|unique:announcements,title,' . $id,
					'start_date' => 'required',
					'end_date' => 'required',
					'company_id' => 'required',
				]);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['title'] = $request->title;
			$data['start_date'] = $request->start_date;
			$data['end_date'] = $request->end_date;
			$data['summary'] = $request->summary;
			$data['description'] = $request->description;
			$data['company_id'] = $request->company_id;

			if($request->department_id)
			{
				$data ['department_id'] = $request->department_id;
			}
			else {
				$data ['department_id'] = null;
			}
			$data['added_by'] = $logged_user->username;
			$data['is_notify'] = $request->is_notify;

			Announcement::find($id)->update($data);

			if ($data['department_id'] == null)
			{
				$employee_id = Employee::where('company_id',$data ['company_id'])->where('is_active',1)->pluck('id');
				$notifiable = User::whereIntegerInRaw('id',$employee_id)->get();
			}
			else
			{
				$employee_id = Employee::where('department_id',$data ['department_id'])->where('is_active',1)->pluck('id');
				$notifiable = User::whereIntegerInRaw('id',$employee_id)->get();
			}

			Notification::send($notifiable,new AnnouncementPublished());


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
			return response()->json(['success' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-announcement'))
		{
			Announcement::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function delete_by_selection(Request $request)
	{
		if(!env('USER_VERIFIED')){
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-announcement'))
		{

			$announcement_id = $request['announcementIdArray'];
			$announcement = Announcement::whereIntegerInRaw('id', $announcement_id);
			if ($announcement->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Announcement')])]);
			} else
			{
				return response()->json(['error' => 'Error,selected announcements can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
