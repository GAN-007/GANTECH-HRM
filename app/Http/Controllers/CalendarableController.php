<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\company;
use App\Http\traits\CalendarableModelTrait;
use App\Models\LeaveType;
use App\Models\Project;
use App\Models\Trainer;
use App\Models\TrainingType;
use App\Models\TravelType;
use DateTime;

class CalendarableController extends Controller {

	Use CalendarableModelTrait;

	public function index()
	{
		$logged_user = auth()->user();
		if ($logged_user->can('view-calendar'))
		{
			$companies = company::select('id', 'company_name')->get();
			$leave_types = LeaveType::select('id', 'leave_type', 'allocated_day')->get();
			$travel_types = TravelType::select('id', 'arrangement_type')->get();
			$training_types = TrainingType::select('id', 'type')->get();
			$trainers = Trainer::select('id', 'first_name', 'last_name')->get();
			$clients = Client::select('id', 'first_name','last_name')->get();
			$projects = Project::select('id', 'title')->get();

			return view('calendarable.index', compact('companies', 'leave_types',
				'training_types', 'trainers', 'travel_types', 'clients', 'projects'));
		}
		return abort('403', __('You are not authorized'));
	}

	public function load()
	{

		$data = [];
		$a = [];
		$data['holidays'] = $this->getHolidays();
		$data['leaves'] = $this->getLeaves();
		$data['travels'] = $this->getTravels();
		$data['trainings'] = $this->getTrainings();
		$data['projects'] = $this->getProjects();
		$data['tasks'] = $this->getTasks();
		$data['events'] = $this->getEvents();
		$data['meetings'] = $this->getMeetings();

		foreach ($data['holidays'] as $row)
		{
			$a[] = array(
				'id' => $row["id"],
				'overlap' => 'Holiday',
				'title' => $row["event_name"],
				'start' => $row->getAttributes()["start_date"],
				'groupId' => route('holidays.calendarable',$row['id']),
				'end' => (new DateTime($row->getAttributes()["end_date"]))->modify('+1 day')->format('Y-m-d'),
			);
		}


		foreach ($data['leaves'] as $row)
		{
			$a[] = array(
				'id' => $row["id"],
				'overlap' => 'Leave',
				'title' => $row['LeaveType']['leave_type'] . ' leave by '. $row['employee']['first_name'],
				'backgroundColor' => '#fc486b',
				'start' => $row->getAttributes()["start_date"],
				'end' => (new DateTime($row->getAttributes()["end_date"]))->modify('+1 day')->format('Y-m-d'),
				'groupId' => route('leaves.calendarable',$row['id'])
			);
		}


		foreach ($data['travels'] as $row)
		{
			$a[] = array(
				'title' => $row["TravelType"]['arrangement_type'],
				'overlap' => 'Travel',
				'id' => $row["id"],
				'backgroundColor' => '#03ccac',
				'groupId' => route('travels.calendarable',$row['id']),
				'start' => $row->getAttributes()["start_date"],
                'end' => (new DateTime($row->getAttributes()["end_date"]))->modify('+1 day')->format('Y-m-d')
			);
		}

		foreach ($data['trainings'] as $row)
		{
			$a[] = array(
				'id' => $row["id"],
				'overlap' => 'Training',
				'title' => $row["TrainingType"]['type'],
				'backgroundColor' => '#f4ce17',
				'groupId' => route('training_lists.calendarable',$row['id']),
				'start' => $row->getAttributes()["start_date"],
                'end' => (new DateTime($row->getAttributes()["end_date"]))->modify('+1 day')->format('Y-m-d')
			);
		}

		foreach ($data['projects'] as $row)
		{
			$a[] = array(
				'id' => $row["id"],
				'title' => $row["title"],
				'backgroundColor' => '#168D7E',
				'start' => $row->getAttributes()["start_date"],
                'end' => (new DateTime($row->getAttributes()["end_date"]))->modify('+1 day')->format('Y-m-d'),
				'url' => route('projects.show',$row['id']),
			);
		}

		foreach ($data['tasks'] as $row)
        {
			$a[] = array(
				'id'    => $row["id"],
				'title' => $row["task_name"],
				'backgroundColor' => '#19aed9',
				'start' => $row->getAttributes()["start_date"],
                'end'   => (new DateTime($row->getAttributes()["end_date"]))->modify('+1 day')->format('Y-m-d'),
				'url'   => route('tasks.show',$row['id']),
			);
		}

		foreach ($data['events'] as $row)
		{
			$a[] = array(
				'id' => $row["id"],
				'overlap' => 'Event',
				'title' =>  $row["event_time"].' '.$row["event_title"],
				'backgroundColor' => '#784435',
				'start' => $row->getAttributes()["event_date"],
				'groupId' => route('events.calendarable',$row['id']),
			);
		}

		foreach ($data['meetings'] as $row)
		{
			$a[] = array(
				'id' => $row["id"],
				'overlap' => 'Meeting',
				'title' =>  $row["meeting_time"].' '.$row["meeting_title"],
				'backgroundColor' => 'red',
				'start' => $row->getAttributes()["meeting_date"],
				'groupId' => route('meetings.calendarable',$row['id']),
			);
		}

		return response()->json($a);
	}

}
