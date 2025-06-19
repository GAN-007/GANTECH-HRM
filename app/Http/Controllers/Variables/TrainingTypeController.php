<?php


namespace App\Http\Controllers\Variables;


use App\Models\TrainingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingTypeController {

	public function index()
	{

		if (request()->ajax())
		{
			return datatables()->of(TrainingType::select('id', 'type')->get())
				->setRowId(function ($training_type)
				{
					return $training_type->id;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_type'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="training_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="training_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

						return $button;
					} else
					{
						return '';
					}
				})
				->rawColumns(['action'])
				->make(true);

		}

		return view('training.training_type.training_type');

	}

	public function store(Request $request)
	{

		$logged_user = auth()->user();

		if ($logged_user->can('access-variable_type'))
		{
			$validator = Validator::make($request->only('type'),
				[
					'type' => 'required|unique:training_types',
				]
//				,
//				[
//					'type.required' => 'Training Type  can not be empty',
//					'type.unique'  => 'Training Type  already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

            try {
                $data = [];
                $data['type'] = $request->get('type');
                TrainingType::create($data);
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
			return response()->json(['success' => __('Data Added successfully.')]);
		}
		return abort('403', __('You are not authorized'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */


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
			$data = TrainingType::findOrFail($id);

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
			$id = $request->get('hidden_training_id');

			$validator = Validator::make($request->only('type_edit'),
				[
					'type_edit' => 'required|unique:training_types,type,'.$id,
				]
//				,
//				[
//					'type_edit.required' => 'Training Type  can not be empty',
//					'type_edit.unique'  => 'Training Type  already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['type'] = $request->get('type_edit');



			TrainingType::whereId($id)->update($data);

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

		if ($logged_user->can('access-variable_type')) {
			TrainingType::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}
}
