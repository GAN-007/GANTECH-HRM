<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpSetting extends Model
{
    protected $fillable = [
        'name',
        'ip_address'
    ];
}
