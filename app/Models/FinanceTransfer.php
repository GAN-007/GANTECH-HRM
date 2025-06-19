<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinanceTransfer extends Model
{
	protected $fillable = [
		'id','company_id','amount','from_account_id','to_account_id','description','payment_method_id',
		'reference','date'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}

	public function FromAccount(){
		return $this->hasOne('App\Models\FinanceBankCash','id','from_account_id');
	}

	public function ToAccount(){
		return $this->hasOne('App\Models\FinanceBankCash','id','to_account_id');
	}

	public function PaymentMethod(){
		return $this->hasOne('App\Models\PaymentMethod','id','payment_method_id');
	}

	public function setDateAttribute($value)
	{
		$this->attributes['date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}


}
