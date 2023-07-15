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

class Reportemail implements ShouldQueue
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
    ///   sending report  ############################################
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
                           $planned_start=date("d-m-Y", strtotime($value->start_date));
                           $planned_end=date("d-m-Y", strtotime($value->end_date));

                           $actual_start=DB::table('task_progress')->where('project_id',$project_id)->where('task_id',$value->main_id)->max('created_at');
                           $actual_end=DB::table('task_progress')->where('project_id',$project_id)->where('task_id',$value->main_id)->min('created_at');
                           $flag=0;
                           if($actual_start){
                               $flag=1;
                               $actual_start=date("d-m-Y", strtotime($actual_start));
                           }else{
                               $actual_start='Task Not Started';
                           }

                           if($actual_end){
                               $actual_end=date("d-m-Y", strtotime($actual_end));
                           }else{
                               $actual_end='Task Not Finish';
                           }

                           if($actual_end < $planned_end){
                               $actual_end='Task Not Finish';
                           }
                           //finding planned percentage
                           ############### days finding ####################################################
                               $date1=date_create($value->start_date);
                               $date2=date_create($value->end_date);
                               $cur= date('Y-m-d');

                               $diff=date_diff($date1,$date2);
                               $no_working_days=$diff->format("%a");
                               $no_working_days=$value->duration;// include the last day
                               ############### END ##############################

                               ############### Remaining days ###################

                               $date2=date_create($value->end_date);
                               // update one report

                                    $remaining_working_days=Utility::remaining_duration_calculator($date2,$project->id);
                                    $remaining_working_days=$remaining_working_days-1;// include the last day

                                    $completed_days=$no_working_days-$remaining_working_days;

                                    // percentage calculator
                                    if($no_working_days>0){
                                        $perday=100/$no_working_days;
                                    }else{
                                        $perday=0;
                                    }

                                    $current_percentage=round($completed_days*$perday);
                                    if($current_percentage > 100){
                                        $current_percentage=100;
                                    }

                               //
                               $taskdata[]=array(
                                   'title'=>$value->text,
                                   'planed_start'=>$planned_start,
                                   'planed_end'=>$planned_end,
                                   'duration'=>$value->duration.' Days',
                                   'percentage_as_today'=>round($current_percentage).'%',
                                   'actual_start'=>$actual_start,
                                   'actual_end'=>$actual_end,
                                   'actual_duration'=>$value->duration.' Days',
                                   'remain_duration'=>$value->duration.' Days',
                                   'actual_percent'=>round($value->progress).'%',
                               );
                       }
                       $taskdata2=array();
                       $today_task_update=DB::table('task_progress')->where('project_id',$project_id)->where('record_date','like',Carbon::now()->format('Y-m-d').'%')->get();
                       foreach ($today_task_update as $key => $value) {
                           $main_task=Con_task::where('main_id',$value->task_id)->first();
                           $user=User::find($value->user_id);
                           if($user){
                               $user_name=$user->name;
                               $user_email=$user->email;
                           }else{
                               $user_name='';
                               $user_email='';
                           }

                           $taskdata2[]=array(
                               'title'=>$main_task->text,
                               'planed_start'=>date("d-m-Y", strtotime($main_task->start_date)),
                               'planed_end'=>date("d-m-Y", strtotime($main_task->start_date)),
                               'duration'=>$main_task->duration.' Days',
                               'percentage'=>$value->percentage.'%',
                               'progress_updated_date'=>date("d-m-Y", strtotime($value->record_date)),
                               'description'=>$value->description,
                               'user'=>$user_name,
                               'email'=>$user_email,

                           );
                       }
                       $to=array();
                       $to_array=explode(',',$project->report_to);
                       foreach ($to_array as $key => $value) {
                           $to[]=DB::table('users')->where('id',$value)->pluck('email')->first();
                       }

                       if($to){
                           $pdf = Pdf::loadView('project_report.email', compact('taskdata','project','project_task','actual_current_progress','actual_remaining_progress','taskdata2'))->setPaper('a4', 'landscape')->setWarnings(false);
                           $data["email"] = $to;
                           $data["title"] = "Daily Productivity Report";
                           $data["body"] = "Please find the attachment of the Today Productivity report";
                       }
                       try
                       {
                           Mail::send('construction_project.mail',$data, function($message)use($data, $pdf) {
                               $message->to($data["email"], $data["email"])
                                       ->subject($data["title"])
                                       ->attachData($pdf->output(),'Report.pdf');

                           });
                           $dir = 'uploads/cronreport/';
                           $image_path = date('ymdhis').$project_id.'.pdf';
                           $path = Utility::upload_file($pdf->output(),'attachment',$image_path,$dir,[]);
                           $insert=array(
                            'project_id'=>$project_id,
                            'url'=>$dir.$image_path,
                           );
                           DB::table('cron_report')->insert($insert);
                       }catch(\Exception $e)
                       {
                           $error = $e->getMessage();
                           dd($error);

                       }
                       //sending Report end ###########################################
    }
}
