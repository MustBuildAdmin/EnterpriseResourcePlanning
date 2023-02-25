<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'meeting_id', 'client_id','project_id','start_date','duration','start_url','password','join_url','status','created_by',
    ];
    protected $appends  = array(
        'client_name',
        'project_name',
    );
    public function getClientNameAttribute($value)
    {
        $client = User::select('id', 'name')->where('id', $this->client_id)->first();

        return $client ? $client->name : '';
    }
    public function getProjectNameAttribute($value)
    {
        $project = Project::select('id', 'project_name')->where('id', $this->project_id)->first();

        return $project ? $project->project_name : '';
    }

    public function checkDateTime(){
        $m = $this;
        if (\Carbon\Carbon::parse($m->start_date)->addMinutes($m->duration)->gt(\Carbon\Carbon::now())) {
            return 1;
        }else{
            return 0;
        }
    }

    public function projectName()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    public function userName()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function users($users)
    {

        $userArr = explode(',', $users);
        $users  = [];
        foreach($userArr as $user)
        {
            $users[] = User::find($user);
        }

        return $users;
    }

}
