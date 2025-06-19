<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryBasic extends Model
{
    protected $fillable = ['employee_id','month_year','payslip_type','basic_salary'];

    public function payslipMonthYear(){
		return $this->hasMany(Payslip::class,'employee_id','employee_id');
	}
}
