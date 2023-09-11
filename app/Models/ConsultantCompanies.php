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


class ConsultantCompanies extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use HasApiTokens;
    protected $table = 'consultant_companies';

    protected $appends = ['profile'];
    // Status Values (requested,accepted,declined,expired)
    protected $fillable = [
        'consultant_id',
        'company_id',
        'status',
        'requested_date',
    ];

   }
