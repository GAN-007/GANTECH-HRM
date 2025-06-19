<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = [
		'task_name','project_id','company_id','start_date','end_date','task_hour','description',
		'task_status','task_note','is_notify','added_by','task_progress'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}
	public function project(){
		return $this->hasOne('App\Models\Project','id','project_id');
	}
	public function addedBy(){
		return $this->hasOne('App\Models\User','id','added_by');
	}
	public function assignedEmployees(){
		return $this->belongsToMany(Employee::class);
	}

	public function setStartDateAttribute($value)
	{
		$this->attributes['start_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getStartDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

	public function setEndDateAttribute($value)
	{
		$this->attributes['end_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getEndDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}
}
