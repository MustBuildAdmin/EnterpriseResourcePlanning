<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Construction_asign extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'invited_by',
    ];

    public function projectUsers()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function project_name()
    {
        return $this->belongsTo('App\Models\Construction_project', 'project_id', 'id');
    }
    public function user_name()
    {
        return $this->belongsTo('App\Models\User', 'employe_id', 'id');
    }


}
