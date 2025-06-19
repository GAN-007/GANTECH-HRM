<?php


namespace App\Http\traits;


use App\Models\Event;
use App\Models\Holiday;
use App\Models\leave;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\Task;
use App\Models\TrainingList;
use App\Models\Travel;

Trait CalendarableModelTrait {

	protected function getHolidays(){
		$holidays = Holiday::where('is_publish',1)->get();
		return $holidays;
	}


	protected function getLeaves(){
		$leaves = leave::with('LeaveType:id,leave_type','employee:id,first_name,last_name')
			->where('status','approved')->get();
		return $leaves;
	}

	protected function getTravels(){
		$travels = Travel::with('TravelType:id,arrangement_type')->whereStatus('approved')->get();
		return $travels;
	}

	protected function getTrainings(){
		$training = TrainingList::with('TrainingType:id,type','employees:id,first_name,last_name',
			'trainer:id,first_name,last_name')
		->get();
		return $training;
	}

	protected function getProjects(){
		$projects = Project::all('id','title','start_date','end_date');
		return $projects;
	}

	protected function getTasks(){
		$tasks = Task::all('id','task_name','start_date','end_date');
		return $tasks;
	}


	protected function getEvents(){
		$events = Event::where('status','approved')->get();
		return $events;
	}

	protected function getMeetings(){
		$meetings = Meeting::select('id','meeting_title','meeting_date','meeting_time')
			->where('status','=','ongoing')->get();
		return $meetings;
	}

//	protected function getBirthdays(){
//		$birthdays = Employee::select('id','first_name','last_name','date_of_birth')->get();
//		return $birthdays;
//	}



}