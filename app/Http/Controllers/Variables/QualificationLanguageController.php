<?php

namespace App\Http\Controllers\Variables;

use App\Http\Controllers\Controller;
use App\Models\QualificationLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationLanguageController extends Controller
{

	public function index()
	{

		if (request()->ajax())
		{
			return datatables()->of(QualificationLanguage::select('id', 'name')->get())
				->setRowId(function ($language_skill)
				{
					return $language_skill->id;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_method'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="language_skill_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="language_skill_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

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
			$validator = Validator::make($request->only('language_skill_name'),
				[
					'language_skill_name' => 'required|unique:qualification_languages,name',
				]
//				,
//				[
//					'language_skill_name.required' => 'Language can not be empty',
//					'language_skill_name.unique'  => 'Language already exist',
//				]
			);

			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['name'] = $request->get('language_skill_name');

			QualificationLanguage::create($data);

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
			$data = QualificationLanguage::findOrFail($id);

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
			$id = $request->get('hidden_language_skill_id');

			$validator = Validator::make($request->only('language_skill_name_edit'),
				[
					'language_skill_name_edit' => 'required|unique:qualification_languages,name,'.$id,
				]
//				,
//				[
//					'language_skill_name_edit.required' => 'Language can not be empty',
//					'language_skill_name_edit.unique'  => 'Language already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}



			$data = [];

			$data['name'] = $request->get('language_skill_name_edit');

		QualificationLanguage::whereId($id)->update($data);

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
			QualificationLanguage::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}
}
