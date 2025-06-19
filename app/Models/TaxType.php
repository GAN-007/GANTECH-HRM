<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxType extends Model
{

	protected $fillable = [
		'name','rate','type','description'
	];

//	public function getRateAttribute($value)
//	{
//		if (config('variable.currency_format') === 'suffix'){
//			return $value.config('variable.currency');
//		}
//		else {
//			return config('variable.currency').$value;
//		}
//	}

}
