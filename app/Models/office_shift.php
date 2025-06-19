<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class office_shift extends Model
{
	protected $table = 'office_shifts';

    protected $fillable=[
		'shift_name','company_id', 'default_shift','monday_in','monday_out','tuesday_in','tuesday_out','wednesday_in','wednesday_out','thursday_in','thursday_out','friday_in','friday_out','saturday_in','saturday_out','sunday_in','sunday_out'
    	];

	public function company(){
		return $this->hasOne('App\Models\company','id','company_id');
	}
}
