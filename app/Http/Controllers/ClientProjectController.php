<?php

namespace App\Http\Controllers;


use App\Models\company;
use App\Notifications\ClientProjectNotification;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ClientProjectController extends Controller
{
	public function index(Request $request)
	{
		$logged_user = auth()->user();

		$companies = company::all('id','company_name');

		if ($logged_user->role_users_id == 3)
		{
			if (request()->ajax())
			{
				return datatables()->of(Project::with( 'assignedEmployees')
					->where('client_id',$logged_user->id)
					->get())
					->setRowId(function ($project)
					{
						return $project->id;
					})
					->addColumn('summary', function ($row)
					{
						return  $row->title ;
					})
					->addColumn('assigned_employee', function ($row)
					{
						$assigned_name = $row->assignedEmployees()->pluck('last_name', 'first_name');
						$collection = [];
						foreach ($assigned_name as $first => $last)
						{
							$full_name = $first . ' ' . $last;
							array_push($collection, $full_name);
						}

						return $collection;
					})
					->rawColumns(['summary'])
					->make(true);
			}
			return view('client.project',compact('companies'));
		}

		return abort('403', __('You are not authorized'));
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->only('title','project_priority', 'description', 'start_date'
			, 'end_date', 'summary'),
			[
				'title' => 'required',
				'project_priority' => 'required',
				'start_date' => 'required',
				'end_date' => 'required|after_or_equal:start_date',
			]
		);


		if ($validator->fails())
		{
			return response()->json(['errors' => $validator->errors()->all()]);
		}


		$data = [];

		$data['summary'] = $request->summary;
		$data['title'] = $request->title;
		$data ['start_date'] = $request->start_date;
		$data ['end_date'] = $request->end_date;
		$data['client_id'] = auth()->user()->id;
		$data ['description'] = $request->description;
		$data ['project_priority'] = $request->project_priority;


		$project = Project::create($data);

		$notificable = User::where('role_users_id',1)
			->get();

		Notification::send($notificable,new ClientProjectNotification($project,'created'));

		return response()->json(['success' => __('Data Added successfully.')]);
	}

	public function status(Request $request)
	{
		$query_status = $request->query('status');
		$logged_user = auth()->user();

		if ($logged_user->role_users_id == 3)
		{
			$projects = Project::with( 'assignedEmployees')
				->where('client_id',$logged_user->id)
				->where('project_status',$query_status)
				->get();
			return view('client.project_status',compact('projects'));
		}

		return abort('403', __('You are not authorized'));
	}
}
