<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTicket extends Model
{
    //
	protected $table= "employee_support_ticket";

	public function assignedTickets(){
		return $this->hasMany(SupportTicket::class,'id','support_ticket_id');
	}
}
