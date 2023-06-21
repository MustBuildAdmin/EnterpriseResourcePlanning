<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competencies extends Model
{
    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];

//    public static $types = [
//        'technical' => 'Technical',
//        'organizational' => 'Organizational',
//        'behavioural' => 'Behavioural',
//    ];


    public function performance()
    {
        return $this->hasOne('App\Models\PerformanceType', 'id', 'type');
    }
}
