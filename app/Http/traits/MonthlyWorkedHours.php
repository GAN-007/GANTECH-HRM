<?php


namespace App\Http\traits;



Trait MonthlyWorkedHours {

	public function totalWorkedHours($employee)
	{
		if($employee->employeeAttendance->isEmpty()){
			return 0;
		}else{
			$total = 0;
			foreach ($employee->employeeAttendance as $a)
			{
				sscanf($a->total_work, '%d:%d', $hour, $min);
				$total += $hour * 60 + $min;
			}

			if ($h = floor($total / 60))
			{
				$total %= 60;
			}
			$sum_total = sprintf('%02d:%02d', $h, $total);

			return $sum_total;
		}
	}




    //************* Test */
    // public function totalOvertimeHours($employee)
	// {
	// 	if($employee->employeeAttendance->isEmpty()){
	// 		return 0;
	// 	}else{
	// 		$total = 0;
	// 		foreach ($employee->employeeAttendance as $a)
	// 		{
	// 			sscanf($a->overtime, '%d:%d', $hour, $min);
	// 			$total += $hour * 60 + $min;
	// 		}

	// 		if ($h = floor($total / 60))
	// 		{
	// 			$total %= 60;
	// 		}
	// 		$sum_total = sprintf('%02d:%02d', $h, $total);

	// 		return $sum_total;
	// 	}
	// }

    //************* Test End */











	// public function totalWorkedHours($employee)
	// {
	// 	$total = 0;
	// 	$current_year =  date('Y');
	// 	$current_month =  date('m');


	// 	$att = $employee->load( ['employeeAttendance' => function ($query) use ($current_year, $current_month)
	// 	{
	// 		$query->whereYear('attendance_date',$current_year)->whereMonth('attendance_date',$current_month);
	// 	},]);

	// 	return $att;

	// 	foreach ($att->employeeAttendance as $a)
	// 	{
	// 		sscanf($a->total_work, '%d:%d', $hour, $min);
	// 		$total += $hour * 60 + $min;

	// 	}

	// 	if ($h = floor($total / 60))
	// 	{
	// 		$total %= 60;
	// 	}
	// 	$sum_total = sprintf('%02d:%02d', $h, $total);

	// 	return $sum_total;
	// }
}
