<?php


namespace App\Http\traits;





Trait TotalSalaryTrait {

	public function totalSalary($employee, $payslip_type , $basic_salary, $allowance_amount, $deduction_amount, $pension_amount, $total_minutes =1){

		if($payslip_type == 'Monthly')
		{
			$total = $basic_salary + $allowance_amount + $employee->commissions->sum('commission_amount')
				- $employee->loans->sum('monthly_payable') - $deduction_amount - $pension_amount // (basic_salary - pension_amount)
				+ $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');
		}
		else
		{
			$total =  ($basic_salary / 60) * $total_minutes + $allowance_amount +  $employee->commissions->sum('commission_amount')
				- $employee->loans->sum('monthly_payable') - $deduction_amount - $pension_amount // (basic_salary - pension_amount)
				+ $employee->otherPayments->sum('other_payment_amount') + $employee->overtimes->sum('overtime_amount');
		}

        if($total<0)
        {
            $total=0;
        }
		return $total;
	}
}


