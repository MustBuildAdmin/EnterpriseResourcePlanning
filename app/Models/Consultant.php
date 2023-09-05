<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Consultant extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;
    use Notifiable;

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
        'is_deleted',
    ];

    public function creatorId()
    {
        if ($this->type == 'company' || $this->type == 'super admin') {
            return $this->id;
        } else {
            return $this->created_by;
        }
    }
}
