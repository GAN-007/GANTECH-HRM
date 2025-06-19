<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualificationEducationLevel extends Model
{
    protected $guarded= [];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}
}
