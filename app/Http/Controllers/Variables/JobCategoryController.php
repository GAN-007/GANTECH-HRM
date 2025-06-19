<?php

namespace App\Http\Controllers\Variables;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    //
	public function index()
	{

		if (request()->ajax())
		{
			return datatables()->of(JobCategory::select('id', 'job_category')->get())
				->setRowId(function ($job_category)
				{
					return $job_category->id;
				})
				->addColumn('action', function ($data)
				{
					if (auth()->user()->can('access-variable_method'))
					{
						$button = '<button type="button" name="edit" id="' . $data->id . '" class="job_category_edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
						$button .= '&nbsp;&nbsp;';
						$button .= '<button type="button" name="delete" id="' . $data->id . '" class="job_category_delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

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
			$validator = Validator::make($request->only('job_category'),
				[
					'job_category' => 'required|unique:job_categories',
				]
//				,
//				[
//					'job_category.required' => 'Job Category  can not be empty',
//					'job_category.unique'  => 'Job Category  already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['job_category'] = $request->get('job_category');
			$data['url'] = Str::random('20');
			JobCategory::create($data);

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
			$data = JobCategory::findOrFail($id);

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
			$id = $request->get('hidden_job_category_id');

			$validator = Validator::make($request->only('job_category_edit'),
				[
					'job_category_edit' => 'required|unique:job_categories,job_category,'.$id,
				]
//				,
//				[
//					'job_category_edit.required' => 'Job Category can not be empty',
//					'job_category_edit.unique'  => 'Job Category already exist',
//				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['job_category'] = $request->get('job_category_edit');



			JobCategory::whereId($id)->update($data);

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
			JobCategory::whereId($id)->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return abort('403',__('You are not authorized'));
	}
}
