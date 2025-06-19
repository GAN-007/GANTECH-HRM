<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class AttendancesImportDevice implements ToCollection, WithStartRow, ShouldQueue, WithChunkReading, WithBatchInserts
{
    public function collection(Collection $rows)
	{
        foreach ($rows as $row)
        {
            $staff_id = $row[0];
            $dt_time = explode(' ', $row[1], 2);

            $attendance_date_day = Carbon::createFromFormat(env('ATTENDANCE_DEVICE_DATE_FORMAT'), $dt_time[0]);
            $att_time = new DateTime(Carbon::parse($dt_time[1])->format('H:i'));

            $data = [];
            $employee = Employee::with('officeShift')->where('staff_id', $staff_id)->first();
            $current_day_in = strtolower($attendance_date_day->format('l')) . '_in';
            $current_day_out = strtolower($attendance_date_day->format('l')) . '_out';
            try
            {
                $shift_in = new DateTime($employee->officeShift->$current_day_in);
                $shift_out = new DateTime($employee->officeShift->$current_day_out);
            } catch (\Exception $e)
            {
                dd ('Error In Shift In and Out Time');
            }
            $employee_id = $employee->id;
            //getting the latest instance of employee_attendance
            $employee_attendance_last = Attendance::where('attendance_date', $attendance_date_day->format('Y-m-d'))
                    ->where('employee_id', $employee_id)->orderBy('id', 'desc')->first() ?? null;

            $data['employee_id'] = $employee_id;
            $data['attendance_date'] = $attendance_date_day->format(env('Date_Format'));

            //if employee attendance record was not found
            // FOR CLOCK IN
            if (!$employee_attendance_last)
            {
                // if employee is late
                if ($att_time > $shift_in)
                {
                    $data['clock_in'] = $att_time->format('H:i');
                    $timeDifference = $shift_in->diff(new DateTime($data['clock_in']))->format('%H:%I');
                    $data['time_late'] = $timeDifference;
                } // if employee is early or on time
                else
                {
                    if(env('ENABLE_EARLY_CLOCKIN')!=NULL) {
                        $data['clock_in'] = $att_time->format('H:i');
                    }
                    else {
                        $data['clock_in'] = $shift_in->format('H:i');
                    }
                }

                $data['attendance_status'] = 'present';
                $data['clock_in_out'] = 1;

                //creating new attendance record
                Attendance::create($data);
            }
            // if there is a record of employee attendance
            //FOR CLOCK OUT
            //if ($employee_attendance_last)
            else {
                //checking if the employee is not both clocked in + out (1)
                if ($employee_attendance_last->clock_in_out == 1) {
                    if ($att_time > $shift_in || env('ENABLE_EARLY_CLOCKIN')!=NULL) {
                        $employee_last_clock_in = new DateTime($employee_attendance_last->clock_in);
                        $data['clock_out'] = $att_time->format('H:i');
                        // if employee is early leaving
                        if ($att_time < $shift_out) {
                            $timeDifference = $shift_out->diff(new DateTime($data['clock_out']))->format('%H:%I');
                            $data['early_leaving'] = $timeDifference;
                        }
                        // calculating total work
                        $prev_work = new DateTime($employee_attendance_last->total_work);
                        $total_work = $prev_work->add($employee_last_clock_in->diff(new DateTime($data['clock_out'])));
                        $data['total_work'] = $total_work->format('H:i');

                        // Overtime calculation
                        $duty_time = new DateTime($shift_in->diff($shift_out)->format('%H:%I'));
                        if ($total_work > $duty_time) {
                            $data['overtime'] = $total_work->diff($duty_time)->format('%H:%I');
                        }
                        $data['clock_in_out'] = 0;
                        //updating record
                        Attendance::find($employee_attendance_last->id)->update($data);
                    }
                    else {
                        Attendance::whereId($employee_attendance_last->id)->delete();
                    }
                }
                // if employee is both clocked in + out
                // if ($employee_attendance_last->clock_in_out == 0)
                else {
                    $data['clock_in'] = $att_time->format('H:i');
                    // last clock out (needed for calculation rest time)
                    $employee_last_clock_out = new DateTime($employee_attendance_last->clock_out);
                    $data['total_rest'] = $employee_last_clock_out->diff(new DateTime($data['clock_in']))->format('%H:%I');
                    $data['total_work'] = $employee_attendance_last->total_work;
                    $data['overtime'] = $employee_attendance_last->overtime;
                    $data['clock_in_out'] = 1;
                    Attendance::whereId($employee_attendance_last->id)->update(['total_work'=> '00:00', 'overtime'=> '00:00']);
                    // creating new attendance
                    Attendance::create($data);
                }
            }
        }
	}

    public function startRow(): int
    {
        return 2;
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
