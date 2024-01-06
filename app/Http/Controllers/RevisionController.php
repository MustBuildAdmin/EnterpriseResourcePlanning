<?php

namespace App\Http\Controllers;

use App\Models\Con_task;
use App\Models\Instance;
use App\Models\NonWorkingDaysModal;
use App\Models\Project;
use App\Models\Project_holiday;
use App\Models\Task;
use App\Models\Task_progress;
use App\Models\User;
use App\Models\Utility;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class RevisionController extends Controller
{
    public function revision(Request $request)
    {

        $projectId = Session::get('project_id');
        $instanceId = Session::get('project_instance');
        $getInstance = Instance::where('project_id', $projectId)
            ->orderBy('id', 'DESC')->first();

        $nonWorkingDays = NonWorkingDaysModal::where('instance_id', $getInstance->instance)
            ->orderBy('id', 'DESC')->first();

        $projectHolidays = Project_holiday::where('instance_id', $getInstance->instance)
            ->orderBy('id', 'DESC')->get();

        if ($nonWorkingDays != null) {
            $setNonWorkingDays = explode(',', $nonWorkingDays->non_working_days);
        } else {
            $setNonWorkingDays = [];
        }

        return view('revision.revision', compact('setNonWorkingDays', 'projectHolidays'));
    }

    public function revision_store(Request $request)
    {
        try {
            $projectId = Session::get('project_id');
            $instanceId = Session::get('project_instance');
            $holidayDateGet = $request->holiday_date;

            $var = random_int('100000', '555555').date('dmyhisa').\Auth::user()->creatorId().$projectId;
            $instanceIdSet = Hash::make($var);
            $getPro = DB::table('projects')->where('id', $projectId)->first();

            if (isset($request->non_working_days)) {
                if (gettype($request->non_working_days) == 'array') {
                    $nonWorkingDays = implode(',', $request->non_working_days);
                    $nonWorkingDaysInsert = [
                        'project_id' => $projectId,
                        'non_working_days' => $nonWorkingDays,
                        'instance_id' => $instanceIdSet,
                        'created_by' => \Auth::user()->creatorId(),
                    ];

                    DB::table('non_working_days')->insert($nonWorkingDaysInsert);
                }
            }

            if ($getPro != null) {
                $instanceStore = new Instance;
                $instanceStore->instance = $instanceIdSet;
                $instanceStore->start_date = $getPro->start_date;
                $instanceStore->end_date = $getPro->end_date;
                $instanceStore->project_id = $projectId;
                $instanceStore->save();
            }

            if ($holidayDateGet != null) {
                foreach ($holidayDateGet as $holi_key => $holi_value) {

                    $holidayInsert = [
                        'project_id' => $projectId,
                        'date' => $holi_value,
                        'description' => $request->holiday_description[$holi_key],
                        'instance_id' => $instanceIdSet,
                        'created_by' => \Auth::user()->creatorId(),
                    ];

                    Project_holiday::insert($holidayInsert);
                }
            }

            $getConInstance = DB::table('con_tasks')->select('instance_id', 'project_id')
                ->where(['project_id' => $projectId, 'instance_id' => $instanceId])
                ->orderBy('main_id', 'DESC')->first();

            if ($getConInstance != null) {
                $conInstanceGet = $getConInstance->instance_id;
                $user_id = Auth::user()->id;
                DB::select(
                    "INSERT INTO con_tasks(
                        id,text,project_id,users,duration,progress,start_date,end_date,predecessors,instance_id,achive,
                        parent,sortorder,custom,reported_to,created_by,created_at,updated_at,float_val,type,iscritical,dependency_critical,entire_critical,free_slack,
                        total_slack,subcontractor,taskmode,micro_flag
                    )
                    SELECT id,text,project_id,users,duration,progress,start_date,end_date,predecessors,
                    '".$instanceIdSet."' as instance_id,achive,parent,sortorder,custom,reported_to,".$user_id.",created_at,updated_at,
                    float_val,type,iscritical,dependency_critical,entire_critical,free_slack,
                    total_slack,subcontractor,taskmode,micro_flag FROM con_tasks WHERE project_id = ".$projectId." AND
                    instance_id='".$conInstanceGet."'"
                );
            }

            return redirect()->route('construction_main')->with('success', __('Revision Added Successfully'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function instance_project($instance_id, $project_id,$name)
    {
        
        $getInstance = Instance::where('project_id', $project_id)->where(['id' => $instance_id])->first();
        $instanceId = $getInstance->instance;
        Session::forget('project_id');
        Session::forget('project_instance');
        Session::forget('latest_project_instance');
        Session::forget('current_revision_freeze');
        Session::forget('current_revision_name');
        Session::forget('latest_project_instance_frezee');
        Session::forget('second_latest_project_instance');
        
      
        ////
            Session::put('project_id',$project_id);
            Session::put('project_instance',$instanceId);
            Session::put('current_revision_name',$name);
            
            $checkInstanceFreeze = Instance::where('project_id',$project_id)->orderBy('id','DESC')->first();
            Session::put('latest_project_instance',$checkInstanceFreeze->instance);
            Session::put('latest_project_instance_frezee',$checkInstanceFreeze->freeze_status);

            //# second latest instance which for task update
            $secondInstance= Instance::where('project_id',$project_id)->orderBy('id','DESC')->skip(1)->take(1)->first();
            if($secondInstance){
                Session::put('second_latest_project_instance',$secondInstance->instance);
            }else{
                Session::put('second_latest_project_instance',0);
            }



            if($getInstance->freeze_status == 1){
                Session::put('current_revision_freeze', 1); //Freezed
            }
            else{
                Session::put('current_revision_freeze', 0); //Not Freeze
            }

            $instanceall = Instance::where('project_id',$project_id)->orderBy('id','DESC')->get();
            if(count($instanceall)>1){
                Session::put('revision_started', 1); //Not Freeze
            }

        ///
        return redirect(route('projects.show', $project_id));
       
    }

    public function instance_project_dairy($instance_id, $project_id)
    {
        
        $getInstance = Instance::where('project_id', $project_id)->where(['id' => $instance_id])->first();
        $instanceId = $getInstance->instance;
        Session::forget('project_id');
        Session::forget('project_instance');
        Session::forget('latest_project_instance');
        Session::forget('current_revision_freeze');
      
        ////
            Session::put('project_id',$project_id);
            Session::put('project_instance',$instanceId);
            
            $checkInstanceFreeze = Instance::where('project_id',$project_id)->orderBy('id','DESC')->first();
            Session::put('latest_project_instance',$checkInstanceFreeze->instance);

            if($getInstance->freeze_status == 1){
                Session::put('current_revision_freeze', 1); //Freezed
            }
            else{
                Session::put('current_revision_freeze', 0); //Not Freeze
            }

            $instanceall = Instance::where('project_id',$project_id)->orderBy('id','DESC')->get();
            if(count($instanceall)>1){
                Session::put('revision_started', 1); //Not Freeze
            }

        ///
        return redirect(route('show_dairy', $project_id));
       
    }
}