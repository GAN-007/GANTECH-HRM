<?php


namespace App\Http\Controllers\Variables;


use App\Models\TerminationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TerminationTypeController {

	public function index()
	{
		if (request()->ajax()) {
			return datatables()->of(TerminationType::select('id', 'termination_title')->get())
				->setRowId(function ($termination_type)
				{
					return $termination_type->id;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_type'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="termination_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="termination_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

						return $button;
					} else
					{
						return '';
					}
				})
				->rawColumns(['action'])
				->make(true);
		}

	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			$validator = Validator::make($request->only('termination_title'),
				[
					'termination_title' => 'required|unique:termination_types',
				]
//				,
//				[
//					'termination_title.required' => 'Termination name can not be empty',
//					'termination_title.unique'  => 'Termination name already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['termination_title'] = $request->get('termination_title');

			TerminationType::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}

		return abort('403', __('You are not authorized'));

	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = TerminationType::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			$id = $request->hidden_termination_id;

			$validator = Validator::make($request->only('termination_title_edit'),
				[
					'termination_title_edit' => 'required|unique:termination_types,termination_title,'.$id,
				]
//				,
//				[
//					'termination_title_edit.required' => 'Termination name can not be empty',
//					'termination_title_edit.unique'  => 'Termination name already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['termination_title'] = $request->get('termination_title_edit');



			TerminationType::whereId($id)->update($data);

			return response()->json(['success' => __('Data is successfully updated')]);
		} else
		{

			return abort('403', __('You are not authorized'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			TerminationType::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}


	}
