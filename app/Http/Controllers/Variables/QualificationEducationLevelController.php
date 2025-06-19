<?php

namespace App\Http\Controllers\Variables;

use App\Http\Controllers\Controller;
use App\Models\QualificationEducationLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationEducationLevelController extends Controller
{
	public function index()
	{

		if (request()->ajax())
		{
			return datatables()->of(QualificationEducationLevel::select('id', 'name')->get())
				->setRowId(function ($education_level)
				{
					return $education_level->id;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_method'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="education_level_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="education_level_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

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

		if ($logged_user->can('access-variable_method'))
		{
			$validator = Validator::make($request->only('education_level_name'),
				[
					'education_level_name' => 'required|unique:qualification_education_levels,name',
				]
//				,
//				[
//					'education_level_name.required' => 'Education Level can not be empty',
//					'education_level_name.unique'  => 'Education Level already exist',
//				]
			);



			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['name'] = $request->get('education_level_name');

			QualificationEducationLevel::create($data);

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
			$data = QualificationEducationLevel::findOrFail($id);

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

		if ($logged_user->can('access-variable_method'))
		{
			$id = $request->get('hidden_education_level_id');

			$validator = Validator::make($request->only('education_level_name_edit'),
				[
					'education_level_name_edit' => 'required|unique:qualification_education_levels,name,'.$id,
				]
//				,
//				[
//					'education_level_name_edit.required' => 'Education Level can not be empty',
//					'education_level_name_edit.unique'  => 'Education Level already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}



			$data = [];

			$data['name'] = $request->get('education_level_name_edit');



			QualificationEducationLevel::whereId($id)->update($data);

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

		if ($logged_user->can('access-variable_method'))
		{
			QualificationEducationLevel::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}
}
