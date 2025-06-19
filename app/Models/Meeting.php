<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
	protected $fillable = [
		'meeting_title','company_id','meeting_note','meeting_date','meeting_time',
		'status','is_notify'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}

	public function employees(){
		return $this->belongsToMany(Employee::class);
	}

	public function setMeetingDateAttribute($value)
	{
		$this->attributes['meeting_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getMeetingDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

}
