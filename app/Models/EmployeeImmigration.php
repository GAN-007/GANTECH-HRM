<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmployeeImmigration extends Model
{
    protected $guarded=[];

	public function employee(){
		return $this->hasOne('App\Models\Employee','id','employee_id');
	}

	public function DocumentType(){
		return $this->hasOne('App\Models\DocumentType','id','document_type_id');
	}

	public function setIssueDateAttribute($value)
	{
		$this->attributes['issue_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

//	public function getIssueDateAttribute($value)
//	{
//		return Carbon::parse($value)->format(env('Date_Format'));
//	}

	public function setExpiryDateAttribute($value)
	{
		$this->attributes['expiry_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

//	public function getExpiryDateAttribute($value)
//	{
//		return Carbon::parse($value)->format(env('Date_Format'));
//	}

	public function setEligibleReviewDateAttribute($value)
	{
		$this->attributes['eligible_review_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

//	public function getEligibleReviewDateAttribute($value)
//	{
//		return Carbon::parse($value)->format(env('Date_Format'));
//	}

}
