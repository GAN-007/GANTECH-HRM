<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\AwardType;
use App\Models\company;
use App\Models\department;
use App\Models\Employee;
use App\Notifications\EmployeeAwardNotify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AwardController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		$award_types = AwardType::select('id', 'award_name')->get();


		if ($logged_user->can('view-award'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Award::with('company', 'employee', 'department', 'award_type')->get())
					->setRowId(function ($award)
					{
						return $award->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? '';
					})
					->addColumn('department', function ($row)
					{
						return $row->department->department_name ?? '';
					})
					->addColumn('employee', function ($row)
					{
						return $row->employee->full_name;
					})
					->addColumn('awardType', function ($row)
					{
						return empty($row->award_type->award_name) ? '' : $row->award_type->award_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-award'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('edit-award'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('core_hr.award.index', compact('companies', 'award_types'));
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

		if ($logged_user->can('store-award'))
		{
			$validator = Validator::make($request->only('award_information', 'gift', 'cash', 'company_id', 'department_id', 'employee_id', 'award_date', 'award_type_id', 'award_photo'
			),
				[
					'award_information' => 'required',
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'award_type_id' => 'required',
					'award_date' => 'required',
					'award_photo' => 'nullable|image|max:10240|mimes:jpeg,png,jpg,gif',
				]);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data['department_id'] = $request->department_id;
			$data['award_type_id'] = $request->award_type_id;
			$data ['award_information'] = $request->award_information;
			$data ['gift'] = $request->gift;
			$data ['cash'] = $request->cash;
			$data ['award_date'] = $request->award_date;


			$photo = $request->award_photo;
			$file_name = null;


			if (isset($photo))
			{
				$photo_name = 'award';
				if ($photo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $photo_name) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('award_photos', $file_name);
					$data['award_photo'] = $file_name;
				}
			}

			Award::create($data);

			$notifiable = User::findOrFail($data['employee_id']);

			$notifiable->notify(new EmployeeAwardNotify());

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
			$data = Award::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$employee_name = $data->employee->full_name ?? '';
			$department = $data->department->department_name ?? '';
			$award_name = $data->award_type->award_name ?? '';

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name, 'department' => $department, 'award_name' => $award_name]);
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
			$data = Award::findOrFail($id);

			$departments = department::select('id', 'department_name')->where('company_id', $data->company_id)->get();

			$employees = Employee::select('id', 'first_name', 'last_name')->where('department_id', $data->department_id)
                            ->where('is_active',1)
                            ->where('exit_date',NULL)
                            ->get();

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

		if ($logged_user->can('edit-award'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('award_information', 'gift', 'cash', 'company_id', 'department_id', 'employee_id', 'award_date', 'award_type_id', 'award_photo'
			),
				[
					'award_information' => 'required',
					'company_id' => 'required',
					'department_id' => 'required',
					'employee_id' => 'required',
					'award_type_id' => 'required',
					'award_date' => 'required',
					'award_photo' => 'nullable|image|max:10240|mimes:jpeg,png,jpg,gif',
				]);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];


			$data['award_type_id'] = $request->award_type_id;
			$data ['award_information'] = $request->award_information;
			$data ['gift'] = $request->gift;
			$data ['cash'] = $request->cash;
			$data ['award_date'] = $request->award_date;

			$photo = $request->award_photo;
			$file_name = null;


			if (isset($photo))
			{
				$photo_name = 'award';
				if ($photo->isValid())
				{
					$file_name = preg_replace('/\s+/', '', $photo_name) . '_' . time() . '.' . $photo->getClientOriginalExtension();
					$photo->storeAs('award_photos', $file_name);
					$data['award_photo'] = $file_name;
				}
			}


			$data['employee_id'] = $request->employee_id;

			$data['department_id'] = $request->department_id;


			Award::find($id)->update($data);

			$notifiable = User::findOrFail($data['employee_id']);

			$notifiable->notify(new EmployeeAwardNotify());

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

		if ($logged_user->can('delete-award'))
		{
			Award::whereId($id)->delete();

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

		if ($logged_user->can('delete-award'))
		{

			$award_id = $request['awardIdArray'];
			$award = Award::whereIntegerInRaw('id', $award_id);
			if ($award->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Award')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected resignation can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

}
