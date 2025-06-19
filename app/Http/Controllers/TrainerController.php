<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TrainerController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$logged_user = auth()->user();
		$companies = company::select('id', 'company_name')->get();

		if ($logged_user->can('view-trainer'))
		{
			if (request()->ajax())
			{
				return datatables()->of(Trainer::with('company')->get())
					->setRowId(function ($trainer)
					{
						return $trainer->id;
					})
					->addColumn('company', function ($row)
					{
						return $row->company->company_name ?? ' ';
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="show_new btn btn-success btn-sm"><i class="dripicons-preview"></i></button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-trainer'))
						{
							$button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('delete-trainer'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
			}

			return view('training.trainer.index', compact('companies'));
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


		if ($logged_user->can('store-trainer'))
		{
			$validator = Validator::make($request->only('first_name', 'last_name', 'contact_no', 'company_id', 'email', 'address',
				'expertise', 'status'),
				[
					'company_id' => 'required',
					'contact_no' => 'required|unique:trainers,contact_no,',
					'email' => 'required|unique:trainers,email,',
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['first_name'] = $request->first_name;
			$data['last_name'] = $request->last_name;
			$data['contact_no'] = $request->contact_no;
			$data['email'] = $request->email;
			$data['address'] = $request->address;
			$data['expertise'] = $request->expertise;
			$data['company_id'] = $request->company_id;


			Trainer::create($data);

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
			$data = Trainer::findOrFail($id);
			$company_name = $data->company->company_name ?? '';

			return response()->json(['data' => $data, 'company_name' => $company_name]);
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
			$data = Trainer::findOrFail($id);
			$company_name = $data->company->company_name ?? '';


			return response()->json(['data' => $data, 'company_name' => $company_name]);
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

		if ($logged_user->can('edit-trainer'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('first_name', 'last_name', 'contact_no', 'company_id', 'email', 'address',
				'expertise', 'status'),
				[
					'contact_no' => 'required|unique:trainers,contact_no,' . $id,
					'email' => 'required|unique:trainers,email,' . $id,
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}


			$data = [];

			$data['first_name'] = $request->first_name;
			$data['last_name'] = $request->last_name;
			$data['contact_no'] = $request->contact_no;
			$data['email'] = $request->email;
			$data['address'] = $request->address;
			$data['expertise'] = $request->expertise;

			if ($request->company_id)
			{
				$data['company_id'] = $request->company_id;
			}


			Trainer::whereId($id)->update($data);

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

		if ($logged_user->can('delete-trainer'))
		{
			Trainer::whereId($id)->delete();

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

		if ($logged_user->can('delete-trainer'))
		{

			$trainer_id = $request['trainerIdArray'];
			$trainer = Trainer::whereIntegerInRaw('id', $trainer_id);
			if ($trainer->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => trans('file.Trainer')])]);
			} else
			{
				return response()->json(['error' => 'Error,selected trainers can not be deleted']);
			}
		}
		return response()->json(['success' => __('You are not authorized')]);
	}
}
