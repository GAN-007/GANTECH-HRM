<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AttendancesImport implements ToCollection,WithHeadingRow,ShouldQueue,WithChunkReading,WithBatchInserts, WithValidation
{
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function collection(Collection $rows)
	{
        foreach ($rows as $row)
        {
            try
            {
                $clock_in = new DateTime($row['clock_in']);
                $clock_out = new DateTime($row['clock_out']);
            } catch (\Exception $e)
            {
                dd ('Please check clock in and clock out');
            }

            $employee = Employee::with('officeShift')
                ->select('id','office_shift_id')
                ->where('staff_id',$row['staff_id'])->first();

            $att_dt = Carbon::createFromFormat(env('Date_Format'), $row['attendance_date']);
            $attendance_day_in =  strtolower($att_dt->format('l')).'_in';
            $attendance_day_out =  strtolower($att_dt->format('l')).'_out';
            try
            {
                $shift_in = new DateTime($employee->officeShift->$attendance_day_in);
                $shift_out = new DateTime($employee->officeShift->$attendance_day_out);
            } catch (\Exception $e)
            {
                dd ('Error In Shift In and Out Time');
            }

            $employee_attendance_last = Attendance::where('attendance_date', $att_dt->format('Y-m-d'))
                    ->where('employee_id', $employee->id)->orderBy('id', 'desc')->first() ?? null;


            $time_late = '00:00';
            $early_leaving = '00:00';
            $overtime = '00:00';
            $total_work = '00:00';
            $total_rest = '00:00';
            //if employee attendance record was not found
            if (!$employee_attendance_last)
            {
                // if employee is late
                if ($clock_in > $shift_in)
                {
                    $time_late = $shift_in->diff($clock_in)->format('%H:%I');
                } // if employee is early or on time
                else
                {
                    if(env('ENABLE_EARLY_CLOCKIN') == NULL) {
                        $clock_in = $shift_in;
                    }
                }

                if ($clock_out > $shift_in || env('ENABLE_EARLY_CLOCKIN')!=NULL) {
                    // if employee is early leaving
                    if ($clock_out < $shift_out) {
                        $timeDifference = $shift_out->diff($clock_out)->format('%H:%I');
                        $early_leaving = $timeDifference;
                    }

                    // calculating total work
                    $total_work = $clock_in->diff($clock_out)->format('%H:%I');
                    $total_work_dt = new DateTime($total_work);
                    // Overtime calculation
                    $duty_time = new DateTime($shift_in->diff($shift_out)->format('%H:%I'));
                    if ($total_work_dt > $duty_time) {
                        $overtime = $total_work_dt->diff($duty_time)->format('%H:%I');
                    }
                    try
                    {
                        Attendance::create([
                            'employee_id' => $employee->id,
                            'attendance_date' => $row['attendance_date'],
                            'clock_in' => $clock_in->format('H:i'),
                            'clock_out' => $clock_out->format('H:i'),
                            'clock_in_out' => 0,
                            'time_late' => $time_late,
                            'early_leaving' => $early_leaving,
                            'overtime' => $overtime,
                            'total_work' => $total_work
                        ]);
                    }
                    catch (\Exception $e)
                    {
                        dd ('Import Error');
                    }
                }
            }
            // if there is a record of employee attendance
            else {
                // last clock out (needed for calculation rest time)
                $employee_last_clock_out = new DateTime($employee_attendance_last->clock_out);
                $total_rest = $employee_last_clock_out->diff($clock_in)->format('%H:%I');

                // if employee is early leaving
                if ($clock_out < $shift_out) {
                    $timeDifference = $shift_out->diff($clock_out)->format('%H:%I');
                    $early_leaving = $timeDifference;
                }
                $prev_work = new DateTime($employee_attendance_last->total_work);
                $total_work_dt = $prev_work->add($clock_in->diff($clock_out));
                $total_work = $total_work_dt->format('H:i');
                // Overtime calculation
                $duty_time = new DateTime($shift_in->diff($shift_out)->format('%H:%I'));
                if ($total_work_dt > $duty_time) {
                    $overtime = $total_work_dt->diff($duty_time)->format('%H:%I');
                }
                Attendance::whereId($employee_attendance_last->id)->update(['total_work'=> '00:00', 'overtime'=> '00:00']);
                try
                {
                    Attendance::create([
                        'employee_id' => $employee->id,
                        'attendance_date' => $row['attendance_date'],
                        'clock_in' => $clock_in->format('H:i'),
                        'clock_out' => $clock_out->format('H:i'),
                        'clock_in_out' => 0,
                        'time_late' => $time_late,
                        'early_leaving' => $early_leaving,
                        'overtime' => $overtime,
                        'total_work' => $total_work,
                        'total_rest' => $total_rest
                    ]);
                }
                catch (\Exception $e)
                {
                    dd ('Import Error');
                }

            }
        }
	}


	public function rules(): array
	{
		return [
			'staff_id' => 'required',
			'clock_in' => 'required',
			'clock_out' => 'required',
			'attendance_date' => 'required',
		];
	}



	public function chunkSize(): int
	{
		return 500;
	}

	public function batchSize(): int
	{
		return 500;
	}
}
