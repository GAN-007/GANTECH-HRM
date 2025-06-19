<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{
    //
	protected $table= "employee_task";

	public function assignedTasks(){
		return $this->hasMany(Task::class,'id','task_id');
	}
}
