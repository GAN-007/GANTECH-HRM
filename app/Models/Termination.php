<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
	protected $fillable = [
		'description', 'company_id','terminated_employee','termination_type','termination_date','notice_date','status'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}
	public function employee(){
		return $this->hasOne('App\Models\Employee','id','terminated_employee');
	}
	public function TerminationType(){
		return $this->hasOne('App\Models\TerminationType','id','termination_type');
	}

	public function setTerminationDateAttribute($value)
	{
		$this->attributes['termination_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getTerminationDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

	public function setNoticeDateAttribute($value)
	{
		$this->attributes['notice_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getNoticeDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

}
