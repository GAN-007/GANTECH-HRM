<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
	protected $fillable = [
		'file_title','user_id','file_attachment','file_description','task_id'
	];

	public function task(){
		return $this->hasOne('App\Models\Project','id','task_id');
	}
	public function User(){
		return $this->hasOne('App\Models\User','id','user_id');
	}

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format').'--H:i');
	}
}
