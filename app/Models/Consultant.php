<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;


class Consultant extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasApiTokens;


    protected $appends = ['profile'];

    protected $fillable = [
        'name',
        'lname',
        'email',
        'avatar',
        'phone',
        'gender',
        'country',
        'state',
        'city',
        'address',
        'zip',
        'type',
        'color_code',
        'created_by',
        'is_deleted'
    ];
    public function creatorId()
    {
        if($this->type == 'company' || $this->type == 'super admin')
        {
            return $this->id;
        }
        else
        {
            return $this->created_by;
        }
    }



   }
