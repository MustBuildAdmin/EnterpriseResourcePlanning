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

class SubContractorCompanies extends Model
{
    use HasRoles;
    use Notifiable;
    use HasApiTokens;
    protected $table = 'sub_contractor_companies';

    protected $appends = ['profile'];
    // Status Values (requested,accepted,declined,expired)
    protected $fillable = [
        'sub_contractor_id',
        'company_id',
        'status',
        'requested_date',
    ];
}
