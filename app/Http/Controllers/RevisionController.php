<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Con_task;
use App\Models\Task_progress;
use App\Models\User;
use App\Models\Task;
use App\Models\Utility;
use App\Models\TaskFile;
use App\Models\Bug;
use App\Models\BugStatus;
use App\Models\TaskStage;
use App\Models\ActivityLog;
use App\Models\ProjectTask;
use App\Models\Project_holiday;
use App\Models\TaskComment;
use App\Models\TaskChecklist;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Session;
use Hash;
use Exception;
use App\Models\Instance;

class RevisionController extends Controller
{
    public function revision(Request $request){
        return view('revision.revision');
    }

    public function revision_store(Request $request){
        try {
            $projectId       = Session::get('project_id');
            $instanceId=Session::get('project_instance');
            $nonWorkingDays  = implode(',',$request->non_working_days);
            $holidayDateGet  = $request->holiday_date;
            $var             = rand('100000','555555').date('dmyhisa').\Auth::user()->creatorId().$projectId;
            $instanceIdSet   = Hash::make($var);
            $getPro = DB::table('projects')->where('id',$projectId)->first();

            if($getPro != null){
                $instanceStore = new Instance;
                $instanceStore->instance   = $instanceIdSet;
                $instanceStore->start_date = $getPro->start_date;
                $instanceStore->end_date   = $getPro->end_date;
                $instanceStore->project_id = $projectId;
                $instanceStore->save();
            }

            $nonWorkingDaysInsert = array(
                'project_id'       => $projectId,
                'non_working_days' => $nonWorkingDays,
                'instance_id'      => $instanceIdSet,
                'created_by'       => \Auth::user()->creatorId()
            );

            DB::table('non_working_days')->insert($nonWorkingDaysInsert);

            if($holidayDateGet != ""){
                foreach($holidayDateGet as $holi_key => $holi_value){
                
                    $holidayInsert = array(
                        'project_id'  => $projectId,
                        'date'        => $holi_value,
                        'description' => $request->holiday_description[$holi_key],
                        'instance_id' => $instanceIdSet,
                        'created_by'  => \Auth::user()->creatorId()
                    );
    
                    Project_holiday::insert($holidayInsert);
                }
            }

            $getConInstance = DB::table('con_tasks')->select('instance_id','project_id')
                            ->where(['project_id'=>$projectId,'instance_id'=>$instanceId])
                            ->orderBy('main_id','DESC')->first();

            if($getConInstance != null){
                $conInstanceGet = $getConInstance->instance_id;

                DB::select(
                    "INSERT INTO con_tasks(
                        id,text,project_id,users,duration,progress,start_date,end_date,predecessors,instance_id,achive,
                        parent,sortorder,custom,created_at,updated_at,float_val,type
                    )
                    SELECT id,text,project_id,users,duration,progress,start_date,end_date,predecessors,
                    '".$instanceIdSet."' as instance_id,achive,parent,sortorder,custom,created_at,updated_at,
                    float_val,type FROM con_tasks WHERE project_id = " . $projectId . " AND
                    instance_id='" . $conInstanceGet . "'"
                );
            }

            return redirect()->back()->with('success', __('Revision Added Successfully'));
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
