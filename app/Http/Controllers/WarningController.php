<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Employee;
use App\Notifications\EmployeeWarningNotify;
use App\Models\User;
use App\Models\Warning;
use App\Models\WarningType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class WarningController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		$warning_types = WarningType::select('id', 'warning_title')->get();


		if ($logged_user->can('view-warning'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Warning::with('company', 'WarningTo')->get())
					->setRowId(function ($warnings)
					{
						return $warnings->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('warning_to', function ($row)
					{
						return $row->WarningTo->full_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-warning'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-warning'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('core_hr.warning.index', compact('companies', 'warning_types'));
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

		if ($logged_user->can('store-warning'))
		{
			$validator = Validator::make($request->only('subject', 'description', 'company_id', 'warning_to', 'warning_type', 'warning_date', 'status'
			),
				[
					'company_id' => 'required',
					'subject' => 'required',
					'warning_to' => 'required',
					'warning_type' => 'required',
					'warning_date' => 'required',
					'status' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['warning_to'] = $request->warning_to;
			$data['company_id'] = $request->company_id;
			$data['warning_type'] = $request->warning_type;
			$data['subject'] = $request->subject;
			$data ['description'] = $request->description;
			$data ['status'] = $request->status;;
			$data ['warning_date'] = $request->warning_date;

			Warning::create($data);

			$notifiable = User::findOrFail($data['warning_to']);

			$notifiable->notify(new EmployeeWarningNotify($data,'store'));

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
			$data = Warning::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$warning_to = $data->WarningTo->full_name;
			$warning_type_name = $data->WarningType->warning_title;

			return response()->json(['data' => $data, 'warning_to_employee' => $warning_to, 'company_name' => $company_name, 'warning_type_name' => $warning_type_name]);
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
			$data = Warning::findOrFail($id);
			$employees = Employee::select('id', 'first_name', 'last_name')->where('company_id', $data->company_id)->where('is_active',1)->where('exit_date',NULL)->get();


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

		if ($logged_user->can('edit-warning'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('subject', 'description', 'company_id', 'warning_to', 'warning_type', 'warning_date', 'status'
			),
				[
					'company_id' => 'required',
					'subject' => 'required',
					'warning_to' => 'required',
					'warning_type' => 'required',
					'warning_date' => 'required',
					'status' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];


			$data['subject'] = $request->subject;
			$data ['description'] = $request->description;
			$data ['warning_date'] = $request->warning_date;

			if ($request->company_id)
			{
				$data ['company_id'] = $request->company_id;
			}
			if ($request->warning_to)
			{
				$data['warning_to'] = $request->warning_to;
			}
			if ($request->warning_type)
			{
				$data ['warning_type'] = $request->warning_type;
			}
			if ($request->status)
			{
				$data ['status'] = $request->status;
			}


			Warning::whereId($id)->update($data);

			$notifiable = User::findOrFail($data['warning_to']);

			$notifiable->notify(new EmployeeWarningNotify($data,'update'));


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
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-warning'))
		{
			Warning::whereId($id)->delete();

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

		if ($logged_user->can('delete-warning'))
		{

			$warning_id = $request['warningIdArray'];
			$warning = Warning::whereIntegerInRaw('id', $warning_id);
			if ($warning->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Warning')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected Warnings can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}
}
