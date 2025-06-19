<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Employee;
use App\Notifications\EmployeePromotion;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		if ($logged_user->can('view-promotion'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Promotion::with('company', 'employee')->get())
					->setRowId(function ($promotion)
					{
						return $promotion->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('employee', function ($row)
					{
						return $row->employee->full_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-promotion'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('edit-promotion'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;

					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('core_hr.promotion.index', compact('companies'));
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

		if ($logged_user->can('store-promotion'))
		{
			$validator = Validator::make($request->only('employee_id', 'company_id', 'promotion_title', 'description', 'promotion_date'),
				[
					'promotion_title' => 'required',
					'company_id' => 'required',
					'employee_id' => 'required',
					'promotion_date' => 'required'

				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['employee_id'] = $request->employee_id;
			$data['company_id'] = $request->company_id;
			$data ['promotion_title'] = $request->promotion_title;
			$data ['description'] = $request->description;
			$data ['promotion_date'] = $request->promotion_date;

			Promotion::create($data);

			$notifiable = User::findOrFail($data['employee_id']);

			$notifiable->notify(new EmployeePromotion($data['promotion_title']));


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
			$data = Promotion::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$employee_name = $data->employee->full_name;

			return response()->json(['data' => $data, 'employee_name' => $employee_name, 'company_name' => $company_name]);
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
			$data = Promotion::findOrFail($id);
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

		if ($logged_user->can('edit-promotion'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('employee_id', 'company_id', 'promotion_title', 'description', 'promotion_date'),
				[
					'promotion_title' => 'required',
					'promotion_date' => 'required',
					'company_id' => 'required',
					'employee_id' => 'required',

				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data ['promotion_title'] = $request->promotion_title;
			$data ['description'] = $request->description;
			$data ['promotion_date'] = $request->promotion_date;

			$data['employee_id'] = $request->employee_id;

			$data ['company_id'] = $request->company_id;

			Promotion::find($id)->update($data);

			$notifiable = User::findOrFail($data['employee_id']);

			$notifiable->notify(new EmployeePromotion($data['promotion_title']));

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

		if ($logged_user->can('delete-promotion'))
		{
			Promotion::whereId($id)->delete();

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

		if ($logged_user->can('delete-promotion'))
		{

			$promotion_id = $request['promotionIdArray'];
			$promotion = Promotion::whereIntegerInRaw('id', $promotion_id);
			if ($promotion->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Promotion')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected promotions can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}
}
