<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\JobCandidate;
use App\Models\JobInterview;
use App\Models\JobPost;
use App\Notifications\InterviewHostNotification;
use App\Notifications\JobInterviewNotification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Throwable;


class JobInterviewController extends Controller {

	public function index()
	{
		$jobs = JobPost::whereStatus(1)->select('id', 'job_title')->get();
		$employees = Employee::select('id', 'first_name', 'last_name')
                        ->where('is_active',1)
                        ->where('exit_date',NULL)
                        ->get();

		$logged_user = auth()->user();
		if ($logged_user->can('view-job_interview'))
		{
			if (request()->ajax())
			{

				$job_interviews = JobInterview::with('InterviewJob')->get();
				return datatables()->of($job_interviews)
					->setRowId(function ($row)
					{
						return $row->id;
					})
					->addColumn('job_description', function ($row)
					{
						$title = $row->InterviewJob->job_title;

						return '<h4><a href="' . route('jobs.details', $row->InterviewJob) . '"> ' . $title;
					})
					->addColumn('added_by', function ($row)
					{
						return $row->User->username;
					})
					->addColumn('action', function ($data)
					{
						$button = '<button type="button" name="show" id="' . $data->id . '" class="details btn btn-success btn-sm">Details</button>';
						$button .= '&nbsp;&nbsp;';

						if (auth()->user()->can('delete-job_interview'))
						{
							$button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
						}

						return $button;
					})
					->rawColumns(['action', 'job_description'])
					->make(true);
			}
			return view('recruitment.job_interview.index', compact('jobs', 'employees'));
		}

		return abort('403', __('You are not authorized'));
	}


	public function store(Request $request)
	{
		$logged_user = auth()->user();

		if ($logged_user->can('store-job_interview'))
		{
			$validator = Validator::make($request->only('job_id', 'candidate_id', 'employee_id', 'interview_place', 'interview_date', 'interview_time',
				'description'
			),
				[
					'job_id' => 'required',
					'employee_id' => 'required',
					'candidate_id' => 'required',
					'interview_place' => 'required',
					'interview_date' => 'required',
					'interview_time' => 'required',
					'description' => 'required'
				]
			);


			if ($validator->fails()){
				return response()->json(['errors' => $validator->errors()->all()]);
			}elseif (!env('MAIL_MAILER')  && !env('MAIL_HOST') && !env('MAIL_PORT') && !env('MAIL_USERNAME') && !env('MAIL_PASSWORD') && !env('MAIL_ENCRYPTION') && !env('MAIL_FROM_ADDRESS')) {
                return response()->json(['errors' => ['Please setup your mail setting properly']]);
            }

			DB::beginTransaction();
				try
				{
					$data = [];

					$data['job_id'] = $request->job_id;
					$data['interview_place'] = $request->interview_place;
					$data ['interview_date'] = $request->interview_date;
					$data ['interview_time'] = $request->interview_time;
					$data ['description'] = $request->description;
					$data['added_by'] = $logged_user->id;

					$interview = JobInterview::create($data);

					$employees = $request->input('employee_id');
					$candidates = $request->input('candidate_id');

					$interview->employees()->attach($employees);
					$interview->candidates()->attach($candidates);

					JobCandidate::whereIntegerInRaw('id', $candidates)->update(['status' => 'Called For Interview']);

					$mailable_candiadtes = JobCandidate::whereIntegerInRaw('id', $candidates)->get();
					$notificable_employees = User::whereIntegerInRaw('id', $employees)->get();

					Notification::send($mailable_candiadtes, new JobInterviewNotification($interview));
					Notification::send($notificable_employees, new InterviewHostNotification($interview));

					DB::commit();
				} catch (Exception $e)
				{
					DB::rollback();
					return response()->json(['error' =>  $e->getMessage()]);
				} catch (Throwable $e)
				{
					DB::rollback();
					return response()->json(['error' => $e->getMessage()]);
				}

				return response()->json(['success' => __('Data Added successfully.')]);

		}

		return response()->json(['success' => __('You are not authorized')]);
	}

	public function show($id)
	{

		if (request()->ajax())
		{
            // ------ Test ----------

            $jobinterview = JobInterview::with('InterviewJob','employees:id,first_name,last_name','candidates:id,full_name')->findOrFail($id);
            $data         = [];
            $candidates   = [];
            $interviewers = [];
            $data['job_title']       = $jobinterview->InterviewJob->job_title; //Job Description
            $data['interview_place'] = $jobinterview->interview_place; //Interview Place
            $data ['interview_date'] = $jobinterview->interview_date; //Interview Date
            $data ['interview_time'] = $jobinterview->interview_time; //Interview time

            if (!$jobinterview->candidates->isEmpty()) {
                foreach ($jobinterview->candidates as $key => $value) {
                    array_push($candidates, $value->full_name);
                }
            }
            if (!$jobinterview->employees->isEmpty()) {
                foreach ($jobinterview->employees as $key => $value) {
                    array_push($interviewers, $value->first_name.' '.$value->last_name);
                }
            }
            $data['candidates']   = $candidates;
            $data['interviewers'] = $interviewers;
            $data['description']  = $jobinterview->description; //Interview Description
            $data['added_by']     = $jobinterview->User->username;

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

		if ($logged_user->can('delete-job_interview'))
		{
			JobInterview::whereId($id)->delete();

			return response()->json(['success' => __('Data is successfully deleted')]);
		}

		return response()->json(['success' => __('You are not authorized')]);
	}
}
