<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $fillable = [
        'company_id',
        'designation_id',
        'department_id',
        'customer_experience',
        'marketing',
        'administrator',
        'professionalism',
        'integrity',
        'attendance',
        'added_by',
    ];

    public function designation(){
		return $this->hasOne('App\Models\designation','id','designation_id');
    }

    public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
    }
    
    public function department(){
		return $this->hasOne('App\Models\department','id','department_id');
	}
}
