<?php


namespace App\Http\Controllers\FrontEnd;


use App\Models\JobCandidate;
use App\Models\JobCategory;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JobController {

	public function index(){

		$job_posts = JobPost::with('PostJobCategory:id,job_category,url',
			'Company:id,company_name')
			->whereStatus(1)->where('is_featured',1)->get();

		$job_types = JobPost::select('id','job_type')
			->whereStatus(1)->groupBY('job_type')->get();



		$job_categories = JobCategory::select('job_categories.id','job_categories.url','job_categories.job_category')
			->leftJoin('job_posts','job_categories.id','=','job_posts.job_category_id')
			->whereStatus(1)->where('is_featured',1)->groupBy('job_categories.job_category')->get();

		return view('frontend.jobs.index',compact('job_posts','job_categories','job_types'));
	}

	public function details(JobPost $job_post){
		$job_post->load('PostJobCategory:id,job_category,url','Company:id,company_name');
		return view('frontend.jobs.details',compact('job_post'));
	}

	public function searchByCategory($url){

		$job_posts = JobPost::with('PostJobCategory:id,job_category,url')
			->whereStatus(1)
			->where('is_featured',1)
			->leftJoin('job_categories','job_posts.job_category_id','=','job_categories.id')
			->where('job_categories.url',$url)->get();

		$job_types = JobPost::select('id','job_type')
			->whereStatus(1)->where('is_featured',1)->groupBY('job_type')->get();

		$job_categories = JobCategory::select('job_categories.id','job_categories.url','job_categories.job_category')
			->leftJoin('job_posts','job_categories.id','=','job_posts.job_category_id')
			->whereStatus(1)->where('is_featured',1)->groupBy('job_categories.job_category')->get();

		return view('frontend.jobs.index',compact('job_posts','job_categories','job_types'));

	}

	public function searchByJobType($job_type){

		$job_posts = JobPost::with('PostJobCategory:id,job_category,url')
			->whereStatus(1)
			->where('is_featured',1)
			->where('job_posts.job_type',$job_type)->get();


		$job_types = JobPost::select('id','job_type')
			->whereStatus(1)->where('is_featured',1)->groupBY('job_type')->get();

		$job_categories = JobCategory::select('job_categories.id','job_categories.url','job_categories.job_category')
			->leftJoin('job_posts','job_categories.id','=','job_posts.job_category_id')
			->whereStatus(1)->where('is_featured',1)->groupBy('job_categories.job_category')->get();

		return view('frontend.jobs.index',compact('job_posts','job_categories','job_types'));

	}

	public function applyForJob(Request $request,$id)
    {
		$validator = Validator::make($request->only('full_name', 'email', 'phone', 'cover_letter',
			 'cv'),
			[
				'full_name' => 'required',
				'email' => 'required|email',
				'phone' => 'required',
				'cover_letter' => 'required',
				'cv' => 'required|file|max:5120|mimes:jpeg,png,jpg,gif,doc,docx,pdf',
			],
			[
				'full_name.required' => 'Name is not given,it cannot be empty',
				'email.required' => 'Email is required',
				'email.email' => 'Email is not valid',
				'phone.required' => 'Phone number is required',
				'cover_letter.required' => 'Cover Letter/message is required',
				'cv.required' => 'CV is required',
				'cv.file' => 'Must be of type file(jpeg,png,jpg,gif,doc,docx,pdf)',
				'cv.mimes' => 'Must be of type file(jpeg,png,jpg,gif,doc,docx,pdf)',
				'cv.max' => 'File Size should be less than 5 mb',

			]);


		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()]);
		}

		$data = [];

		$data['full_name'] = $request->full_name;
		$data['job_id'] = $id;
		$data['email'] = $request->email;
		$data['phone'] = $request->phone;
		$data['address'] = $request->address;
		$data['fb_id'] = $request->fb_id;
		$data['linkedin_id'] = $request->linkedin_id;
		$data['cover_letter'] = $request->cover_letter;
		$data['status'] =  'applied';

		$cv =  $request->cv;

		$file_name = null;



		if (isset($cv))
		{
			if ($cv->isValid())
			{
				$file_name = preg_replace('/\s+/', '', $request->full_name) . '_' . time() . '.' . $cv->getClientOriginalExtension();
				$cv->storeAs('candidate_cv', $file_name);
				$data['cv'] = $file_name;
			}
		}

		JobCandidate::create($data);

		return response()->json(['success' => 'Applied successfully.']);

	}
}
