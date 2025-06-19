<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinancePayers extends Model
{
	protected $fillable = [
		'payer_name','contact_no'
	];

	public function getUpdatedAtAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}
}
