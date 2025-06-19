<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveTypeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_type_detail',
        'leave_type_remaining',
        'manual_leave_total',
        'manual_leave_remaining'
    ];
}
