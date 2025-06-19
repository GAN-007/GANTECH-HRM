<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'role_users_id',
        'contact_no',
        'profile_photo',
        'profile_bg',
        'is_active',
        'last_login_ip',
        'last_login_date',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


	public function RoleUser()
	{
		// return $this->hasone('App\Models\Role_User','id',"role_users_id");
        return $this->hasone('Spatie\Permission\Models\Role','id',"role_users_id");
	}

//	public function scopeActive($query)
//	{
//		return $query->where('is_active',1);
//	}
//	public function scopeMonthly($query)
//	{
//		return $query->whereMonth('created_at','4');
//	}



	public function getLastLoginDateAttribute($value)
	{
		if ($value)
		{
			return Carbon::parse($value)->format(env('Date_Format').'--H:i');
		}
		else {
			return null;
		}
	}

}


