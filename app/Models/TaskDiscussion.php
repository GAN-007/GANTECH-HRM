<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TaskDiscussion extends Model
{
	protected $fillable = [
		'task_discussion','user_id','task_id'
	];

	public function task(){
		return $this->hasOne('App\Models\Task','id','task_id');
	}
	public function User(){
		return $this->hasOne('App\Models\User','id','user_id');
	}

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format').'--H:i');
	}
}
