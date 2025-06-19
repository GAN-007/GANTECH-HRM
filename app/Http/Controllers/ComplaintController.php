<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Complaint;
use App\Models\Employee;
use App\Notifications\ComplainAgainstNotify;
use App\Notifications\ComplaintFromNotify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if ($logged_user->can('view-complaint'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Complaint::with('company', 'complaint_from_employee', 'complaint_against_employee')->get())
					->setRowId(function ($complaints)
					{
						return $complaints->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('complaint_from', function ($row)
					{
						return $row->complaint_from_employee->full_name;
					})
					->addColumn('complaint_against', function ($row)
					{
						return $row->complaint_against_employee->full_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-complaint'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-complaint'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;

					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('core_hr.complaint.index', compact('companies'));
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

		if ($logged_user->can('add-complaint'))
		{
			$validator = Validator::make($request->only('complaint_title', 'description', 'company_id', 'complaint_from_id', 'complaint_against_id', 'complaint_date'
			),
				[
					'company_id' => 'required',
					'complaint_title' => 'required',
					'complaint_date' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['complaint_from'] = $request->complaint_from_id;
			$data['company_id'] = $request->company_id;
			$data['complaint_against'] = $request->complaint_against_id;
			$data['complaint_title'] = $request->complaint_title;
			$data ['description'] = $request->description;
			$data ['status'] = 'Yes';
			$data ['complaint_date'] = $request->complaint_date;

			Complaint::create($data);

			$notifiable_against = User::findOrFail($data['complaint_against']);

			$notifiable_from = User::findOrFail($data['complaint_from']);

			$notifiable_against->notify(new ComplainAgainstNotify($data['complaint_from'],$data['complaint_title']));
			$notifiable_from->notify(new ComplaintFromNotify($data['complaint_against'],$data['complaint_title']));


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
			$data = Complaint::findOrFail($id);
			$company_name = $data->company->company_name ?? '';

			$complaint_from = $data->complaint_from_employee->full_name;
			$complaint_against = $data->complaint_against_employee->full_name;

			return response()->json(['data' => $data, 'complaint_from' => $complaint_from, 'company_name' => $company_name, 'complaint_against' => $complaint_against]);
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
			$data = Complaint::findOrFail($id);
			$employees = Employee::select('id', 'first_name', 'last_name')->where('company_id', $data->company_id)->where('is_active',1)
            ->where('exit_date',NULL)->get();

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

		if ($logged_user->can('edit-complaint'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('complaint_title', 'description', 'company_id', 'complaint_from_id', 'complaint_against_id', 'complaint_date'
			),
				[
					'company_id' => 'required',
					'complaint_title' => 'required',
					'complaint_date' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];


			$data['complaint_title'] = $request->complaint_title;
			$data ['description'] = $request->description;
			$data ['complaint_date'] = $request->complaint_date;

			$data ['company_id'] = $request->company_id;
			$data['complaint_from'] = $request->complaint_from_id;
			$data ['complaint_against'] = $request->complaint_against_id;

			Complaint::find($id)->update($data);

			$notifiable_against = User::findOrFail($data['complaint_against']);

			$notifiable_from = User::findOrFail($data['complaint_from']);

			$notifiable_against->notify(new ComplainAgainstNotify($data['complaint_from'],$data['complaint_title']));
			$notifiable_from->notify(new ComplaintFromNotify($data['complaint_against'],$data['complaint_title']));

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

		if ($logged_user->can('delete-complaint'))
		{
			Complaint::whereId($id)->delete();

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

		if ($logged_user->can('delete-complaint'))
		{

			$complaint_id = $request['complaintIdArray'];
			$complaint = Complaint::whereIntegerInRaw('id', $complaint_id);
			if ($complaint->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Complaint')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected complaints can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}
}
