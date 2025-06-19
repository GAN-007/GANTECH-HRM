<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TicketComments extends Model
{
	protected $fillable = [
		'ticket_id', 'ticket_comments','user_id'
	];

	public function ticket(){
		return $this->hasOne('App\Models\SupportTicket','id','ticket_id');
	}


	public function user(){
		return $this->hasOne('App\Models\User','id','user_id');
	}

	public function employee(){
		return $this->hasOne('App\Models\Employee','id','user_id');
	}

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format').'--H:i');
	}

}
