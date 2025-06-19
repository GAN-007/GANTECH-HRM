<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable =[
        "site_title",
        "site_logo",
        "time_zone",
        "currency",
        "currency_format",
        "default_payment_bank",
        "date_format",
        "theme",
        "footer",
        "footer_link"
    ];
}
