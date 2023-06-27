<?php

namespace App\Jobs;
use App\Models\Project;
use App\Models\Con_task;
use Carbon\Carbon;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Utility;

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
            $project_id=$this->podcast;
            $project=Project::where('id',$project_id)->first();
            $project_task=Con_task::where('project_id',$project_id)->whereIn('main_id', function($query){
                $query->select('task_id')
                ->from('task_progress')
                ->where('record_date','like',Carbon::now()->format('Y-m-d').'%');
            })->get();
            $actual_current_progress=Con_task::where('project_id',$project_id)->orderBy('id','ASC')->pluck('progress')->first();
            $actual_current_progress=round($actual_current_progress);
            $actual_remaining_progress=100-$actual_current_progress;
            $actual_remaining_progress=round($actual_remaining_progress);
            // current progress amount
            $taskdata=array();
            foreach ($project_task as $key => $value) {
                $task = Con_task::find($value->id);
                $check_parent=Con_task::where('project_id',$project_id)->where(['parent'=>$value->id])->get();
                if(count($check_parent)>0){
                    $task->type="project";
                }else{
                    $task->type="task";
                }
                $task->save();
            }
    }
}
