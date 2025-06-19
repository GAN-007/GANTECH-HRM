<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
	protected $fillable = [
		'category_name','company_id'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}
}
