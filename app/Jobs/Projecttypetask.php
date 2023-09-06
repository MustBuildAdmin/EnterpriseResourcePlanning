<?php

namespace App\Jobs;

use App\Models\Con_task;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Projecttypetask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     */
    public function __construct($podcast)
    {
        $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $project_id = $this->podcast;
        $project = Project::where('id', $project_id)->first();
        $instance_id = $project->instance_id;

        $project_task = Con_task::where(['project_id' => $project_id, 'instance_id' => $instance_id])->get();
        foreach ($project_task as $key => $value) {
            $check_parent = Con_task::where(['project_id' => $project_id, 'instance_id' => $instance_id])
                ->where(['parent' => $value->id])->first();
            if ($check_parent) {
                Con_task::where(['main_id' => $value->main_id, 'instance_id' => $instance_id])
                    ->update(['type' => 'project']);
            } else {
                Con_task::where(['main_id' => $value->main_id, 'instance_id' => $instance_id])
                    ->update(['type' => 'task']);
            }
        }

    }
}
