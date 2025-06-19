<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Employee;
use App\Models\Trainer;
use App\Models\TrainingList;
use App\Models\TrainingType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TrainingListController extends Controller {

	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();
		$training_types = TrainingType::select('id', 'type')->get();
		$trainers = Trainer::select('id', 'first_name', 'last_name')->get();

		if ($logged_user->can('view-training'))
		{
			if (request()->ajax())
			{
				return datatables()->of(TrainingList::with('company', 'trainer', 'TrainingType', 'employees')->get())
					->setRowId(function ($TrainingList)
					{
						return $TrainingList->id;
					})
					->addColumn('TrainingType', function ($row)
					{
						return $row->TrainingType->type ?? '';
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
					->addColumn('trainer', function ($row)
					{
						return $row->trainer->full_name;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-training'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('edit-training'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;

					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('training.training_list.index', compact('companies', 'training_types', 'trainers'));
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


		if ($logged_user->can('store-training'))
		{
			$validator = Validator::make($request->only('description', 'company_id', 'employee_id', 'trainer_id', 'training_type', 'start_date', 'end_date',
				'training_cost', 'status', 'remarks'
			),
				[
					'company_id' => 'required',
					'employee_id' => 'required',
					'trainer_id' => 'required',
					'training_type' => 'required',
					'training_cost' => 'required',
					'start_date' => 'required',
					'end_date' => 'required|after_or_equal:start_date'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['company_id'] = $request->company_id;
			$data['trainer_id'] = $request->trainer_id;
			$data['training_type_id'] = $request->training_type;
			$data ['description'] = $request->description;
			$data ['remarks'] = $request->remarks;
			$data ['training_cost'] = $request->training_cost;
			$data ['start_date'] = $request->start_date;
			$data ['end_date'] = $request->end_date;

			$training = TrainingList::create($data);

			$employees = $request->input('employee_id');
			$training->employees()->attach($employees);


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
			$data = TrainingList::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$trainer_name = $data->trainer->full_name;
			$TrainingType_name = $data->TrainingType->type ?? '';

			$name = $data->employees->pluck('last_name', 'first_name');
			$collection = [];
			foreach ($name as $first => $last)
			{
				$full_name = $first . ' ' . $last . '<br>';
				array_push($collection, $full_name);
			}

			$start_date_name = $data->start_date;
			$end_date_name = $data->end_date;


			return response()->json(['data' => $data, 'trainer_name' => $trainer_name, 'company_name' => $company_name, 'TrainingType_name' => $TrainingType_name,
				'start_date_name' => $start_date_name, 'end_date_name' => $end_date_name, 'employee_name' => $collection]);
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
			$data = TrainingList::findOrFail($id);

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

		if ($logged_user->can('edit-training'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('description', 'employee_id', 'company_id', 'trainer_id', 'training_type', 'start_date', 'end_date',
				'training_cost', 'status', 'remarks'
			),
				[
					'company_id' => 'required',
					'employee_id' => 'required',
					'trainer_id' => 'required',
					'training_type' => 'required',
					'training_cost' => 'required',
					'start_date' => 'required',
					'end_date' => 'required|after_or_equal:start_date'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data ['description'] = $request->description;
			$data ['remarks'] = $request->remarks;
			$data ['training_cost'] = $request->training_cost;
			$data ['start_date'] = $request->start_date;
			$data ['end_date'] = $request->end_date;

			$data ['training_type_id'] = $request->training_type;

			$data ['company_id'] = $request->company_id;
			$data ['trainer_id'] = $request->trainer_id;


			TrainingList::find($id)->update($data);

			if ($request->input('employee_id'))
			{
				$training = TrainingList::findOrFail($id);
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
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-training'))
		{
			TrainingList::whereId($id)->delete();

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

		if ($logged_user->can('delete-training'))
		{

			$TrainingList_id = $request['TrainingListIdArray'];
			$TrainingList = TrainingList::whereIntegerInRaw('id', $TrainingList_id);


			if ($TrainingList->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => __('Training List')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected TrainingLists can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function calendarableDetails($id)
	{
		if (request()->ajax())
		{
			$data = TrainingList::with('company:id,company_name',
				'TrainingType:id,type', 'trainer:id,first_name,last_name', 'employees:id,first_name,last_name')->findOrFail($id);

			$new = [];

			$new['Company'] = $data->company->company_name;
			$new['Arrangement Type'] = $data->TrainingType->type;
			$new['Trainer'] = $data->trainer->full_name;
			$new['Training Cost'] = $data->training_cost;
			$new['Start Date'] = $data->start_date;
			$new['End Date'] = $data->end_date;
			$name = $data->employees->pluck('last_name', 'first_name');
			$collection = [];
			foreach ($name as $first => $last)
			{
				$full_name = $first . ' ' . $last . "<br>";
				array_push($collection, $full_name);
			}
			$new['Employee'] = $collection;
			$new['Description'] = $data->description ?? '';

			return response()->json(['data' => $new]);
		}
	}
}
