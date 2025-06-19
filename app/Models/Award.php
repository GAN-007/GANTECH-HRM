<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
	protected $fillable = [
		'award_information', 'gift','cash','company_id','department_id','employee_id','award_date','award_type_id','award_photo'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}

	public function department(){
		return $this->hasOne('App\Models\department','id','department_id');
	}

	public function employee(){
		return $this->hasOne('App\Models\Employee','id','employee_id');
	}

	public function award_type(){
		return $this->hasOne('App\Models\AwardType','id','award_type_id');
	}


	public function setAwardDateAttribute($value)
	{
		$this->attributes['award_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getAwardDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}


}
