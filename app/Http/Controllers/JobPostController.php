<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\JobCategory;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JobPostController extends Controller {

	//

	public function index()
	{
		$logged_user = auth()->user();

		$companies = company::all('id','company_name');

		$job_categories = JobCategory::select('id', 'job_category')->get();

		if ($logged_user->can('view-job_post'))
		{
			if (request()->ajax())
			{

				$job_posts = JobPost::with('Company:id,company_name',
					'PostJobCategory:id,job_category')->get();

				return datatables()->of($job_posts)
					->setRowId(function ($row)
					{
						return $row->id;
					})
					->addColumn('job_description', function ($row)
					{
						$title = $row->job_title;
						$category = $row->PostJobCategory->job_category;

						return $title . '<br><h6><b>Category: </b>' . $category .
							'</h6><h6><b>No of Vacancy: </b>' . $row->no_of_vacancy . ' </h6>';
					})
					->addColumn('company', function ($row)
					{
						$company_name = $row->Company->company_name;

						return $company_name ;
					})
					->addColumn('action', function ($data)
					{
						$button = '<a id="' . $data->id . '" class="show btn btn-success btn-sm" href="' . route('jobs.details', $data) . '"><i class="dripicons-preview"></i></a>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('edit-job_post'))
						{
							$button .= '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
							$button .= '&nbsp;&nbsp;';
						}
						if (auth()->user()->can('edit-job_post'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action', 'job_description'])
					->make(true);
			}

			return view('recruitment.job_post.index', compact('job_categories', 'companies'));
		}
		return abort('403', __('You are not authorized'));
	}

	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-job_post'))
		{
			$validator = Validator::make($request->only('company_id', 'job_type', 'job_category_id',
				'no_of_vacancy', 'job_title', 'closing_date', 'gender', 'min_experience',
				'is_featured', 'status', 'short_description', 'long_description'),
				[
					'company_id' => 'required',
					'job_title' => 'required',
					'job_type' => 'required',
					'no_of_vacancy' => 'nullable|numeric',
					'job_category_id' => 'required',
					'status' => 'required',
					'is_featured' => 'required',
					'short_description' => 'required',
					'long_description' => 'required',
					'closing_date' => 'required'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['job_title'] = $request->job_title;
			$data['company_id'] = $request->company_id;
			$data['job_category_id'] = $request->job_category_id;
			$data['job_type'] = $request->job_type;
			$data['no_of_vacancy'] = $request->no_of_vacancy;
			$data['closing_date'] = $request->closing_date;
			$data['gender'] = $request->gender;
			$data['min_experience'] = $request->min_experience;
			$data['status'] = $request->status;
			$data['is_featured'] = $request->is_featured;
			$data['short_description'] = $request->short_description;
			$data['long_description'] = $request->long_description;
			$data['job_url'] = Str::random('20');

			JobPost::create($data);

			return response()->json(['success' => __('Data Added successfully.')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}

	public function show(JobPost $jobPost)
	{

		return abort('404');
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
			$data = JobPost::findOrFail($id);

			return response()->json(['data' => $data]);
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

		if ($logged_user->can('edit-job_post'))
		{
			$id = $request->hidden_id;

			$validator = Validator::make($request->only('company_id', 'job_type', 'job_category_id',
				'no_of_vacancy', 'job_title', 'closing_date', 'gender', 'min_experience',
				'is_featured', 'status', 'short_description', 'long_description'),
				[
					'company_id' => 'required',
					'job_title' => 'required',
					'job_type' => 'required',
					'no_of_vacancy' => 'nullable|numeric',
					'job_category_id' => 'required',
					'status' => 'required',
					'is_featured' => 'required',
					'short_description' => 'required',
					'closing_date' => 'required|date'
				]
			);


			if ($validator->fails())
			{
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];

			$data['job_title'] = $request->job_title;
			$data['company_id'] = $request->company_id;
			$data['job_category_id'] = $request->job_category_id;
			$data['job_type'] = $request->job_type;
			$data['no_of_vacancy'] = $request->no_of_vacancy;
			$data['closing_date'] = $request->closing_date;
			$data['gender'] = $request->gender;
			$data['min_experience'] = $request->min_experience;
			$data['status'] = $request->status;
			$data['is_featured'] = $request->is_featured;
			$data['short_description'] = $request->short_description;
			if($request->long_description)
			{
				$data['long_description'] = $request->long_description;
			}


			JobPost::find($id)->update($data);


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

		if ($logged_user->can('delete-job_post'))
		{
			JobPost::whereId($id)->delete();

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

		if ($logged_user->can('delete-job_post'))
		{
			$job_post_id = $request['job_postIdArray'];
			$job_post = JobPost::whereIntegerInRaw('id', $job_post_id);
			if ($job_post->delete())
			{
				return response()->json(['success' => __('Multi Delete', ['key' => __('Job Post')])]);
			} else
			{
				return response()->json(['error' => 'Error, selected Job Posts can not be deleted']);
			}
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}