<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
	protected $fillable = [
		'company_name', 'company_type','trading_name', 'registration_no','contact_no','email','website','tax_no','location_id','company_logo',
	];

	public function companyHolidays(){
		return $this->hasMany(Holiday::class)
			->select('id','start_date','end_date','is_publish','company_id')
			->where('is_publish','=',1);
	}

	public function Location(){
		return $this->hasOne('App\Models\location','id','location_id');
	}
}
