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

class RevisionController extends Controller
{
    public function revision(Request $request){
        return view('revision.revision');
    }

    public function revision_store(Request $request){
        $project_id       = Session::get('project_id');
        $non_working_days = implode(',',$request->non_working_days);
        $holiday_date     = $request->holiday_date;
        $var              = rand('100000','555555').date('dmyhisa').\Auth::user()->creatorId().$project_id;
        $instance_id      = Hash::make($var);

        $non_working_days = array(
            'project_id'       => $project_id,
            'non_working_days' => $non_working_days,
            'instance_id'      => $instance_id,
            'created_by'       => \Auth::user()->creatorId()
        );

        DB::table('non_working_days')->insert($non_working_days);

        foreach($holiday_date as $holi_key => $holi_value){
            
            $holiday_insert = array(
                'project_id'  => $project_id,
                'date'        => $holi_value,
                'description' => $request->holiday_description[$holi_key],
                'instance_id' => $instance_id,
                'created_by'  => \Auth::user()->creatorId()
            );

            Project_holiday::insert($holiday_insert);
        }

        return redirect()->back()->with('success', __('Revision Added Successfully'));
    }
}
