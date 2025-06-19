<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class location extends Model
{
	protected $fillable = [
		'location_name', 'location_head', 'address1','address2','city','state','country','zip',
	];

	public function country(){
		return $this->hasOne('App\Models\Country','id','country');
	}

	public function LocationHead(){
		return $this->hasOne('App\Models\Employee','id','location_head');
	}


}
