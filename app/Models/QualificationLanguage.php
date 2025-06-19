<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualificationLanguage extends Model
{
	protected $guarded= [];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}
}
