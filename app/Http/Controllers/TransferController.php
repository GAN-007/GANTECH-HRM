<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\department;
use App\Models\Employee;
use App\Notifications\EmployeeTransferNotify;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if ($logged_user->can('view-transfer'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Transfer::with('company', 'employee', 'to_department', 'from_department')->get())
					->setRowId(function ($transfer)
					{
						return $transfer->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('from_department', function ($row)
					{
						return empty($row->from_department->department_name) ? '' : $row->from_department->department_name;
					})
					->addColumn('to_department', function ($row)
					{
						return empty($row->to_department->department_name) ? '' : $row->to_department->department_name;
					})
					->addColumn('employee', function ($row)
					{
						return $row->employee->full_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-transfer'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-transfer'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('core_hr.transfer.index', compact('companies'));
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

		if ($logged_user->can('store-transfer'))
		{
			$validator = Validator::make($request->only('description', 'company_id', 'from_department_id', 'to_department_id', 'employee_id', 'transfer_date'
			),
				[
					'company_id' => 'required',
					'from_department_id' => 'required',
					'employee_id' => 'required',
					'to_department_id' => 'required',
					'transfer_date' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data['from_department_id'] = $request->from_department_id;
			$data['to_department_id'] = $request->to_department_id;
			$data ['description'] = $request->description;
			$data ['transfer_date'] = $request->transfer_date;

			Transfer::create($data);

			$employee = Employee::findOrFail($data['employee_id']);
			$employee->department_id = $request->to_department_id;
			$employee->Save();

			$notifiable = User::findOrFail($data['employee_id']);

			$notifiable->notify(new EmployeeTransferNotify($request->to_departement_id));


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
			$data = Transfer::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$employee_name = $data->employee->full_name;
			$from_department = $data->from_department->department_name ?? '';
			$to_department = $data->to_department->department_name ?? '';

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'from_department' => $from_department, 'to_department' => $to_department]);
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
			$data = Transfer::findOrFail($id);

			$departments = department::select('id', 'department_name')
				->where('company_id', $data->company_id)->get();

			$employees = Employee::select('id', 'first_name', 'last_name')->where('company_id', $data->company_id)->where('is_active',1)->where('exit_date',NULL)->get();

			return response()->json(['data' => $data, 'employees' => $employees, 'departments' => $departments]);
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

		if ($logged_user->can('edit-transfer'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('description', 'company_id', 'from_department_id', 'to_department_id', 'employee_id', 'transfer_date'
			),
				[
					'company_id' => 'required',
					'from_department_id' => 'required',
					'employee_id' => 'required',
					'to_department_id' => 'required',
					'transfer_date' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data ['description'] = $request->description;
			$data ['transfer_date'] = $request->transfer_date;


			$data['employee_id'] = $request->employee_id;

			$data ['company_id'] = $request->company_id;

			$data['from_department_id'] = $request->from_department_id;

			$data ['to_department_id'] = $request->to_department_id;

			Transfer::find($id)->update($data);
			Employee::whereId($data['employee_id'])->update(['department_id' => $data ['to_department_id']]);

			$notifiable = User::findOrFail($data['employee_id']);

			$notifiable->notify(new EmployeeTransferNotify());

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

		if ($logged_user->can('delete-transfer'))
		{
			Transfer::whereId($id)->delete();

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

		if ($logged_user->can('delete-transfer'))
		{

			$transfer_id = $request['transferIdArray'];
			$transfer = Transfer::whereIntegerInRaw('id', $transfer_id);
			if ($transfer->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Transfer')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected transfers can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
