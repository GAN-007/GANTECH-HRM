<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinanceDeposit extends Model
{
	protected $fillable = [
		'id','company_id','account_id','amount','category','description','payment_method_id','payer_id',
		'deposit_reference','deposit_date','deposit_file'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}

	public function Account(){
		return $this->hasOne('App\Models\FinanceBankCash','id','account_id');
	}

	public function PaymentMethod(){
		return $this->hasOne('App\Models\PaymentMethod','id','payment_method_id');
	}

	public function Payer(){
		return $this->hasOne('App\Models\FinancePayers','id','payer_id');
	}

	public function setDepositDateAttribute($value)
	{
		$this->attributes['deposit_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getDepositDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}


}
