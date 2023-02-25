<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    protected $fillable = [
        'name',
        'created_by',
    ];

    public function stages()
    {
        return $this->hasMany('App\Models\Stage', 'pipeline_id', 'id')->where('created_by', '=', \Auth::user()->ownerId())->orderBy('order');
    }

    public function leadStages()
    {
        return $this->hasMany('App\Models\LeadStage', 'pipeline_id', 'id')->where('created_by', '=', \Auth::user()->ownerId())->orderBy('order');
    }
}
