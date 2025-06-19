<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class status extends Model
{
	protected $fillable = [
		'status_title','employee_id'
	];
}
