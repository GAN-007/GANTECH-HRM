<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceBankCash extends Model
{
	protected $fillable = [
		'account_name','initial_balance','account_balance','account_number','branch_code','bank_branch'
	];


}
