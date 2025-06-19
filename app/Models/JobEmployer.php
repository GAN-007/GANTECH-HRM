<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobEmployer extends Model
{
	protected $guarded=[];

	public function getFullNameAttribute() {
		return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
	}

	public function user(){
		return $this->hasOne(User::class,'id','id');
	}
}
