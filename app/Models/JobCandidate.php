<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobCandidate extends Model
{
	use Notifiable;
	protected $guarded=[];

	public function AppliedJob(){
		return $this->belongsTo('App\Models\JobPost','job_id','id');
	}

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}
}
