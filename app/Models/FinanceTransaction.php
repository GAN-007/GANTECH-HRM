<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FinanceTransaction extends Model
{
	protected $fillable = [
		'company_id','account_id','amount','category_id','description','payment_method_id','payee_id',
		'expense_reference','expense_date','expense_file'
		,'category','payer_id',
		'deposit_reference','deposit_date','deposit_file'
	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}

	public function Account(){
		return $this->hasOne('App\Models\FinanceBankCash','id','account_id');
	}


	public function setExpenseDateAttribute($value)
	{
		$this->attributes['expense_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getExpenseDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
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
