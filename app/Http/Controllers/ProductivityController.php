<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Construction_project;
use App\Models\Construction_asign;
use App\Models\User;
use App\Models\Activity_logs_con;
use App\Models\Project_tasks_con;
use App\Models\Utility;
use App\Models\Milestone_con;
use Carbon\Carbon;
use App\Models\Time_tracker_con;

class ProductivityController extends Controller
{
    public function index($view = 'grid')
    {

        // if(\Auth::user()->can('manage project'))
        // {
            $projects=Construction_project::with(['users'])->where('created_by', \Auth::user()->creatorId())->get();

            return view('productivity.index', compact('projects'));
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }
    }
    
    public function inviteMemberView(Request $request, $project_id)
    {

        $usr          = Auth::user();
        $project      = Construction_project::find($project_id);

        $user_project = $project->users->pluck('id')->toArray();
        $user_contact = User::where('created_by', \Auth::user()->creatorId())->where('type','!=','client')->whereNOTIn('id', $user_project)->pluck('id')->toArray();
        $arrUser      = array_unique($user_contact);
        $users        = User::whereIn('id', $arrUser)->get();
        return view('productivity.invite', compact('project_id', 'users'));
    }

    public function inviteProjectUserMember(Request $request)
    {
        $authuser = Auth::user();

        // Make entry in project_user tbl
        Construction_asign::create(
            [
                'project_id' => $request->project_id,
                'user_id' => $request->user_id,
                'invited_by' => $authuser->id,
            ]
        );

        // Make entry in activity_log tbl
        Activity_logs_con::create(
            [
                'user_id' => $authuser->id,
                'project_id' => $request->project_id,
                'log_type' => 'Invite User',
                'remark' => json_encode(['title' => $authuser->name]),
            ]
        );

        return json_encode(
            [
                'code' => 200,
                'status' => 'success',
                'success' => __('User invited successfully.'),
            ]
        );
    }
    public function edit($id)
    {
            $projects = Construction_project::where('id',$id)->first();
            $clients = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 'client')->get()->pluck('name', 'id');
            return view('productivity.edit', compact('projects','clients'));

    }
    public function update(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required|max:120',
                               'project_location'=>'required',
                               'start_date'=>'required',
                               'end_date'=>'required',
                               'project_budget'=>'required',
                               'non_working_days'=>'required',
                               'status'=>'required'
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $find=Construction_project::where('name',$request->name)->where('id','!=',$id)->first();
        if($find){
            $messages = __('Project Name already exit');

            return redirect()->back()->with('error', $messages);
        }
        $project = Construction_project::find($id);
        $project['name']= $request->name;
        $project['project_location']= $request->project_location;
        $project['start_date']     = $request->start_date;
        $project['end_date']       = $request->end_date;
        $project['project_budget'] = $request->project_budget;
        $project['status'] = $request->status;
        if(isset($request->holidays)){
            $project['holidays'] = $request->holidays;
        }
       
        $project['created_by'] = \Auth::user()->creatorId();
        if(!empty($request->non_working_days)){
            $project['non_working_days'] =implode(',',$request->non_working_days);
        }
        $project ->save();

        return redirect()->route('productivity');

    }
    public function destroy($id)
    {

            $project = Construction_project::find($id)->delete();
            return redirect()->route('productivity');
        
    }

    public function show($id)
    {

        // if(\Auth::user()->can('view project'))
        // {
            $project=Construction_project::find($id);

            $usr           = Auth::user();
            if(\Auth::user()->type == 'client'){
              $user_projects = Construction_project::where('created_by',\Auth::user()->creatorId())->pluck('id','id')->toArray();
            }else{
              $user_projects = $usr->cons_projects->pluck('id')->toArray();
            }
            // dd($user_projects);
            if(in_array($project->id, $user_projects))
            {
                $project_data = [];
                // Task Count
                $tasks = Project_tasks_con::where('project_id',$project->id)->get();
                $project_task         = $tasks->count();
                $completedTask = Project_tasks_con::where('project_id',$project->id)->where('is_complete',1)->get();

                $project_done_task    = $completedTask->count();

                $project_data['task'] = [
                    'total' => number_format($project_task),
                    'done' => number_format($project_done_task),
                    'percentage' => Utility::getPercentage($project_done_task, $project_task),
                ];

                // end Task Count

                // Expense
                $expAmt = 0;
                foreach($project->expense as $expense)
                {
                    $expAmt += $expense->amount;
                }

                $project_data['expense'] = [
                    'allocated' => $project->budget,
                    'total' => $expAmt,
                    'percentage' => Utility::getPercentage($expAmt, $project->budget),
                ];
                // end expense


                // Users Assigned
                $total_users = User::where('created_by', '=', $usr->id)->count();


                $project_data['user_assigned'] = [
                    'total' => number_format($total_users) . '/' . number_format($total_users),
                    'percentage' => Utility::getPercentage($total_users, $total_users),
                ];
                // end users assigned

                // Day left
                $total_day                = Carbon::parse($project->start_date)->diffInDays(Carbon::parse($project->end_date));
                $remaining_day            = Carbon::parse($project->start_date)->diffInDays(now());
                $project_data['day_left'] = [
                    'day' => number_format($remaining_day) . '/' . number_format($total_day),
                    'percentage' => Utility::getPercentage($remaining_day, $total_day),
                ];
                // end Day left

                // Open Task
                    $remaining_task = Project_tasks_con::where('project_id', '=', $project->id)->where('is_complete', '=', 0)->where('created_by',\Auth::user()->creatorId())->count();
                    $total_task     = $project->tasks->count();

                $project_data['open_task'] = [
                    'tasks' => number_format($remaining_task) . '/' . number_format($total_task),
                    'percentage' => Utility::getPercentage($remaining_task, $total_task),
                ];
                // end open task

                // Milestone
                $total_milestone           = $project->milestones()->count();
                $complete_milestone        = $project->milestones()->where('status', 'LIKE', 'complete')->count();
                $project_data['milestone'] = [
                    'total' => number_format($complete_milestone) . '/' . number_format($total_milestone),
                    'percentage' => Utility::getPercentage($complete_milestone, $total_milestone),
                ];
                // End Milestone

                // Time spent

                    $times = $project->timesheets()->where('created_by', '=', $usr->id)->pluck('time')->toArray();
                $totaltime                  = str_replace(':', '.', Utility::timeToHr($times));
                $project_data['time_spent'] = [
                    'total' => number_format($totaltime) . '/' . number_format($totaltime),
                    'percentage' => Utility::getPercentage(number_format($totaltime), $totaltime),
                ];
                // end time spent

                // Allocated Hours
                $hrs = Construction_project::projectHrs($project->id);
                $project_data['task_allocated_hrs'] = [
                    'hrs' => number_format($hrs['allocated']) . '/' . number_format($hrs['allocated']),
                    'percentage' => Utility::getPercentage($hrs['allocated'], $hrs['allocated']),
                ];
                // end allocated hours

                // Chart
                $seven_days      = Utility::getLastSevenDays();
                $chart_task      = [];
                $chart_timesheet = [];
                $cnt             = 0;
                $cnt1            = 0;

                foreach(array_keys($seven_days) as $k => $date)
                {
                        $task_cnt     = $project->tasks()->where('is_complete', '=', 1)->whereRaw("find_in_set('" . $usr->id . "',assign_to)")->where('marked_at', 'LIKE', $date)->count();
                        $arrTimesheet = $project->timesheets()->where('created_by', '=', $usr->id)->where('date', 'LIKE', $date)->pluck('time')->toArray();

                    // Task Chart Count
                    $cnt += $task_cnt;

                    // Timesheet Chart Count
                    $timesheet_cnt = str_replace(':', '.', Utility::timeToHr($arrTimesheet));
                    $cn[]          = $timesheet_cnt;
                    $cnt1          += $timesheet_cnt;

                    $chart_task[]      = $task_cnt;
                    $chart_timesheet[] = $timesheet_cnt;
                }

                $project_data['task_chart']      = [
                    'chart' => $chart_task,
                    'total' => $cnt,
                ];
                $project_data['timesheet_chart'] = [
                    'chart' => $chart_timesheet,
                    'total' => $cnt1,
                ];

                // end chart


                return view('productivity.view',compact('project','project_data'));
            }
            // else
            // {
            //     return redirect()->back()->with('error', __('Permission Denied.'));
            // }
        // }
        // else                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
        // {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }
    }

    
    public function loadUser(Request $request)
    {
        if($request->ajax())
        {
            $project    = Construction_project::find($request->project_id);
            $returnHTML = view('productivity.users', compact('project'))->render();

            return response()->json(
                [
                    'success' => true,
                    'html' => $returnHTML,
                ]
            );
        }
    }

    
    public function destroyProjectUser($id, $user_id)
    {
        $project = Construction_project::find($id);
            if($project->created_by == \Auth::user()->ownerId())
            {
                Construction_asign::where('project_id', '=', $project->id)->where('user_id', '=', $user_id)->delete();

                return redirect()->back()->with('success', __('User successfully deleted!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }

    }

    
    public function milestone($project_id)
    {
        if(\Auth::user()->can('create milestone'))
        {
            $project = Construction_project::find($project_id);

            return view('productivity.milestone', compact('project'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneStore(Request $request, $project_id)
    {
        if(\Auth::user()->can('create milestone'))
        {
            $project   = Construction_project::find($project_id);
            $validator = Validator::make(
                $request->all(), [
                                    'title' => 'required',
                                    'status' => 'required',
                                    'cost' => 'required',
                                    'due_date' => 'required',
                                    'start_date'=>'required'
                               ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $milestone              = new Milestone_con();
            $milestone->project_id  = $project->id;
            $milestone->title       = $request->title;
            $milestone->status      = $request->status;
            $milestone->cost        = $request->cost;
            $milestone->start_date    = $request->start_date;
            $milestone->due_date    = $request->due_date;
            $milestone->description = $request->description;
            $milestone->save();

            Activity_logs_con::create(
                [
                    'user_id' => \Auth::user()->id,
                    'project_id' => $project->id,
                    'log_type' => 'Create Milestone',
                    'remark' => json_encode(['title' => $milestone->title]),
                ]
            );

            return redirect()->back()->with('success', __('Milestone successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneEdit($id)
    {
        if(\Auth::user()->can('edit milestone'))
        {
            $milestone = Milestone_con::find($id);

            return view('productivity.milestoneEdit', compact('milestone'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function milestoneUpdate($id, Request $request)
    {
        if(\Auth::user()->can('edit milestone'))
        {
            $validator = Validator::make(
                $request->all(), [
                                    'title' => 'required',
                                    'status' => 'required',
                                    'cost' => 'required',
                                    'due_date' => 'required',
                                    'start_date'=>'required'
                            ]
            );

            if($validator->fails())
                {
                    return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
                }

            $milestone              = Milestone_con::find($id);
            $milestone->title       = $request->title;
            $milestone->status      = $request->status;
            $milestone->cost        = $request->cost;
            $milestone->progress    = $request->progress;
            $milestone->due_date    = $request->duedate;
            $milestone->start_date  = $request->start_date;
            $milestone->description = $request->description;
            $milestone->save();

            return redirect()->back()->with('success', __('Milestone updated successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneDestroy($id)
    {
        if(\Auth::user()->can('delete milestone'))
        {
            $milestone = Milestone_con::find($id);
            $milestone->delete();

            return redirect()->back()->with('success', __('Milestone successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneShow($id)
    {
        if(\Auth::user()->can('view milestone'))
        {
            $milestone = Milestone_con::find($id);

            return view('productivity.milestoneShow', compact('milestone'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

     // Project Gantt Chart
     public function gantt($projectID, $duration = 'Week')
     {
         if(\Auth::user()->can('view grant chart'))
         {
             $project = Construction_project::find($projectID);
             $tasks   = [];
 
             if($project)
             {
                 $tasksobj = $project->tasks;
 
                 foreach($tasksobj as $task)
                 {
                     $tmp                 = [];
                     $tmp['id']           = 'task_' . $task->id;
                     $tmp['name']         = $task->name;
                     $tmp['start']        = $task->start_date;
                     $tmp['end']          = $task->end_date;
                     $tmp['custom_class'] = (empty($task->priority_color) ? '#ecf0f1' : $task->priority_color);
                     $tmp['progress']     = str_replace('%', '', $task->taskProgress()['percentage']);
                     $tmp['extra']        = [
                         'priority' => ucfirst(__($task->priority)),
                         'comments' => count($task->comments),
                         'duration' => Utility::getDateFormated($task->start_date) . ' - ' . Utility::getDateFormated($task->end_date),
                     ];
                     $tasks[]             = $tmp;
                 }
             }
 
             return view('productivity.gantt', compact('project', 'tasks', 'duration'));
         }
 
         else
         {
             return redirect()->back()->with('error', __('Permission Denied.'));
         }
     }
     
     public function ganttPost($projectID, Request $request)
    {
        $project = Construction_project::find($projectID);

        if($project)
        {
            if(\Auth::user()->can('view project task'))
            {
                $id               = trim($request->task_id, 'task_');
                $task             = Project_tasks_con::find($id);
                $task->start_date = $request->start;
                $task->end_date   = $request->end;
                $task->save();

                return response()->json(
                    [
                        'is_success' => true,
                        'message' => __("Time Updated"),
                    ], 200
                );
            }
            else
           {
                return response()->json(
                    [
                        'is_success' => false,
                        'message' => __("You can't change Date!"),
                    ], 400
                );
            }
        }
        else
        {
            return response()->json(
                [
                    'is_success' => false,
                    'message' => __("Something is wrong."),
                ], 400
            );
        }
    }
    public function tracker($id)
    {
        $treckers=Time_tracker_con::where('project_id',$id)->get();
        return view('time_trackers.index',compact('treckers'));
    }

}
