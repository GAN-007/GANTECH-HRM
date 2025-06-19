<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class designation extends Model
{
	protected $fillable = [
		'designation_name', 'company_id','department_id', 'is_active',
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}

	public function department(){
		return $this->hasOne('App\Models\department','id','department_id');
	}
}
