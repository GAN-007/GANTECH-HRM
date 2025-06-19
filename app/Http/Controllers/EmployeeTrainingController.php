<?php

namespace App\Http\Controllers;

use App\Models\TrainingList;

class EmployeeTrainingController extends Controller {

	//
	public function index($employee)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('view-details-employee') || $logged_user->id == $employee)
		{
			if (request()->ajax())
			{
				return datatables()->of(TrainingList::with('trainer', 'TrainingType')->join('employee_training_list', 'training_lists.id', '=', 'employee_training_list.training_list_id')
					->where('employee_id', $employee)->get())
					->setRowId(function ($training)
					{
						return $training->id;
					})
					->addColumn('TrainingType', function ($row)
					{
						return empty($row->TrainingType->type) ? '' : $row->TrainingType->type;
					})
					->addColumn('trainer', function ($row)
					{
						return $row->trainer->first_name . ' ' . $row->trainer->last_name;
					})
					->addColumn('action', function ($data) use ($employee,$logged_user)
					{
						$button = '';
						if (auth()->user()->can('view-details-employee') || $logged_user->id == $employee)
						{
							$button = '<button type="button" name="show_training" id="' . $data->id . '" class="show_training btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						}

						return $button;

					})
					->rawColumns(['action'])
					->make(true);
			}
		}
	}

	public function show($id)
	{
		if (request()->ajax())
		{
			$data = TrainingList::findOrFail($id);
			$company_name = $data->company->company_name ?? '';
			$first_name = $data->trainer->first_name ?? '';
			$last_name = $data->trainer->last_name ?? '';
			$trainer_name = $first_name . ' ' . $last_name;
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

}

