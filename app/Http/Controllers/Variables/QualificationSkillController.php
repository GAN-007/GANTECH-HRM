<?php

namespace App\Http\Controllers\Variables;

use App\Http\Controllers\Controller;
use App\Models\QualificationSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationSkillController extends Controller
{
	public function index()
	{

		if (request()->ajax())
		{
			return datatables()->of(QualificationSkill::select('id', 'name')->get())
				->setRowId(function ($general_skill)
				{
					return $general_skill->id;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_method'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="general_skill_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="general_skill_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

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
			$validator = Validator::make($request->only('general_skill_name'),
				[
					'general_skill_name' => 'required|unique:qualification_skills,name',
				]
//				,
//				[
//					'general_skill_name.required' => 'Skill can not be empty',
//					'general_skill_name.unique'  => 'Skill already exist',
//				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['name'] = $request->get('general_skill_name');

			QualificationSkill::create($data);

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
			$data = QualificationSkill::findOrFail($id);

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
			$id = $request->get('hidden_general_skill_id');

			$validator = Validator::make($request->only('general_skill_name_edit'),
				[
					'general_skill_name_edit' => 'required|unique:qualification_skills,name,'.$id,
				]
//				,
//				[
//					'general_skill_name_edit.required' => 'Skill can not be empty',
//					'general_skill_name_edit.unique'  => 'Skill already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['name'] = $request->get('general_skill_name_edit');

			QualificationSkill::whereId($id)->update($data);

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
			QualificationSkill::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}
}
