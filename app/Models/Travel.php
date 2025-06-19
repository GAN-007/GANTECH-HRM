<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
	protected $table = 'travels';
	protected $fillable = [
		'description', 'travel_type','status','company_id','travel_mode','employee_id','start_date','end_date','purpose_of_visit',
		'place_of_visit','expected_budget','actual_budget'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}

	public function TravelType(){
		return $this->hasOne('App\Models\TravelType','id','travel_type');
	}

	public function employee(){
		return $this->hasOne('App\Models\Employee','id','employee_id');
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
