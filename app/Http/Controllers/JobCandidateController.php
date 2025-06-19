<?php

namespace App\Http\Controllers;

use App\Models\JobCandidate;

class JobCandidateController extends Controller {

	//

	public function index()
	{

		$logged_user = auth()->user();
		if ($logged_user->can('view-job_candidate'))
		{
			if (request()->ajax())
			{

				$job_candidates = JobCandidate::with('AppliedJob')->get();


				return datatables()->of($job_candidates)
					->setRowId(function ($row)
					{
						return $row->id;
					})
					->addColumn('job_description', function ($row)
					{
						$title = $row->AppliedJob->job_title;
						return '<h4><a href="' . route('jobs.details', $row->AppliedJob) . '"> ' . $title . '</a></h4>';
					})
					->addColumn('candidate_details', function ($row)
					{
						$candidate_name = $row->full_name;
						$fb = $row->fb_id ?? '';
						$linkedin = $row->linkedin_id ?? '';

						return $candidate_name . '<h6><b> ' . trans('file.FB') . ': </b>' . $fb . '</h6>' . '<h6><b>' . trans('file.Linkedin') . ': </b>' . $linkedin . '</h6>';
					})
					->addColumn('cv', function ($row)
					{
						$cv_path = $row->cv;

						return $cv_path;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="details btn btn-light btn-sm">' . trans('Details') . '</button>';
						$button .= '&nbsp;&nbsp;';
						if (auth()->user()->can('delete-job_candidate'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action', 'job_description', 'candidate_details'])
					->make(true);
			}

			return view('recruitment.job_candidate.index');
		}
		return abort('403', __('You are not authorized'));
	}


	public function show($id){

		if(request()->ajax())
		{
			$data = JobCandidate::with('AppliedJob')->findOrFail($id);

			$data['job_title']= $data->AppliedJob->job_title;
			$data['short_description']= $data->AppliedJob->short_description;
			$data['company_name'] = $data->AppliedJob->PostJobEmployer->company_name ?? '';


			return response()->json(['data' => $data]);
		}
	}

	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

		if ($logged_user->can('delete-job_candidate'))
		{
			$data = JobCandidate::findOrFail($id);
			$cv_path = $data->cv;

			if($cv_path)
			{
				$cv_path = public_path('uploads/candidate_cv/' . $cv_path);
				if (file_exists($cv_path))
				{
					unlink($cv_path);
				}
			}

			$data->delete();
			return response()->json(['success' => __('Data is successfully deleted')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}
}
