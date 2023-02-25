<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Utility;
use App\Models\Timesheet;
use App\Models\ProjectTask;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    public function timesheetView(Request $request, $project_id)
    {
        $authuser = Auth::user();
        if(\Auth::user()->can('manage timesheet'))
        {
            $project_ids = $authuser->projects()->pluck('project_id')->toArray();

            if(in_array($project_id, $project_ids))
            {
                $project = Project::where('id', $project_id)->first();

                return view('projects.timesheets.index', compact('project'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function appendTimesheetTaskHTML(Request $request)
    {

        $project_id     = $request->has('project_id') ? $request->project_id : null;

        $task_id        = $request->has('task_id') ? $request->task_id : null;
        $selected_dates = $request->has('selected_dates') ? $request->selected_dates : null;

        $returnHTML = '';

        $project = Project::find($project_id);

        if($project)
        {
            $task = ProjectTask::find($task_id);

            if($task && $selected_dates)
            {
                $twoDates = explode(' - ', $selected_dates);

                $first_day   = $twoDates[0];
                $seventh_day = $twoDates[1];

                $period = CarbonPeriod::create($first_day, $seventh_day);

                $returnHTML .= '<tr><td><span class="task-name">' . $task->name . '</span></td>';

                foreach($period as $key => $dateobj)
                {
                    $returnHTML .= '<td><span class="task-time" data-ajax-timesheet-popup="true" data-type="create" data-task-id="' . $task->id . '" data-date="' . $dateobj->format('Y-m-d') . '" data-url="' . route('timesheet.create', $project_id) . '">-</span></td>';
                }

                $returnHTML .= '<td><span class="total-task-time">00:00</span></td></tr>';
            }
        }

        return response()->json(
            [
                'success' => true,
                'html' => $returnHTML,
            ]
        );
    }

    public function filterTimesheetTableView(Request $request)
    {
//        dd($request);

        $sectionTaskArray = [];
        $authuser         = Auth::user();
        $week             = $request->week;
        $project_id       = $request->project_id;
        $timesheet_type   = 'task';
        if($request->has('week') && $request->has('project_id'))
        {
          if(\Auth::user()->type == 'client'){
            $project_ids = Project::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();
          }else{
            $project_ids = $authuser->projects()->pluck('project_id','project_id')->toArray();
          }
            $timesheets  = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id');
            if($timesheet_type == 'task')
            {
                $projects_timesheet = $timesheets->join('project_tasks', 'project_tasks.id', '=', 'timesheets.task_id');
            }
            if($project_id == '0')
            {
                $projects_timesheet = $timesheets->whereIn('projects.id', $project_ids);
            }
            else if(in_array($project_id, $project_ids))
            {
                $projects_timesheet = $timesheets->where('timesheets.project_id', $project_id);
            }


            $days               = Utility::getFirstSeventhWeekDay($week);
            $first_day          = $days['first_day'];
            $seventh_day        = $days['seventh_day'];
            $onewWeekDate       = $first_day->format('M d') . ' - ' . $seventh_day->format('M d, Y');
            $selectedDate       = $first_day->format('Y-m-d') . ' - ' . $seventh_day->format('Y-m-d');
            $projects_timesheet = $projects_timesheet->whereDate('date', '>=', $first_day->format('Y-m-d'))->whereDate('date', '<=', $seventh_day->format('Y-m-d'));

            if($project_id == '0')
            {
                $timesheets = $projects_timesheet->get()->groupBy(
                    [
                        'project_id',
                        'task_id',
                    ]
                )->toArray();
            }
            else if(in_array($project_id, $project_ids))
            {
                $timesheets = $projects_timesheet->get()->groupBy('task_id')->toArray();
            }

            $returnHTML = Project::getProjectAssignedTimesheetHTML($projects_timesheet, $timesheets, $days, $project_id);

            $totalrecords = count($timesheets);
            if($project_id != '0')
            {
                $task_ids = array_keys($timesheets);
                $project  = Project::find($project_id);
                $sections = ProjectTask::getAllSectionedTaskList($request, $project, [], $task_ids);
                foreach($sections as $key => $section)
                {
                    $taskArray                              = [];
                    $sectionTaskArray[$key]['section_id']   = $section['section_id'];
                    $sectionTaskArray[$key]['section_name'] = $section['section_name'];
                    foreach($section['sections'] as $taskkey => $task)
                    {
                        $taskArray[$taskkey]['task_id']   = $task['id'];
                        $taskArray[$taskkey]['task_name'] = $task['taskinfo']['task_name'];
                    }
                    $sectionTaskArray[$key]['tasks'] = $taskArray;
                }
            }
//            dd($returnHTML);
            return response()->json(
                [
                    'success' => true,
                    'totalrecords' => $totalrecords,
                    'selectedDate' => $selectedDate,
                    'sectiontasks' => $sectionTaskArray,
                    'onewWeekDate' => $onewWeekDate,
                    'html' => $returnHTML,
                ]
            );
        }
    }

    public function timesheetCreate(Request $request)
    {
        if(\Auth::user()->can('create timesheet'))
        {
            $parseArray = [];

            $authuser      = Auth::user();
            $project_id    = $request->has('project_id') ? $request->project_id : null;
            $task_id       = $request->has('task_id') ? $request->task_id : null;
            $selected_date = $request->has('date') ? $request->date : null;
            $user_id       = $request->has('date') ? $request->user_id : null;

            $created_by = $user_id != null ? $user_id : $authuser->id;

            $projects = $authuser->projects();

            if($project_id)
            {
                $project = $projects->where('projects.id', '=', $project_id)->pluck('projects.project_name', 'projects.id')->all();

                if(!empty($project) && count($project) > 0)
                {

                    $project_id   = key($project);
                    $project_name = $project[$project_id];

                    $task = ProjectTask::where(
                        [
                            'project_id' => $project_id,
                            'id' => $task_id,
                        ]
                    )->pluck('name', 'id')->all();

                    $task_id   = key($task);
                    $task_name = $task[$task_id];

                    $tasktime = Timesheet::where('task_id', $task_id)->where('created_by', $created_by)->pluck('time')->toArray();

                    $totaltasktime = Utility::calculateTimesheetHours($tasktime);

                    $totalhourstimes = explode(':', $totaltasktime);

                    $totaltaskhour   = $totalhourstimes[0];
                    $totaltaskminute = $totalhourstimes[1];

                    $parseArray = [
                        'project_id' => $project_id,
                        'project_name' => $project_name,
                        'task_id' => $task_id,
                        'task_name' => $task_name,
                        'date' => $selected_date,
                        'totaltaskhour' => $totaltaskhour,
                        'totaltaskminute' => $totaltaskminute,
                    ];

                    return view('projects.timesheets.create', compact('parseArray'));
                }
            }
            else
            {
                $projects = $projects->get();

                return view('projects.timesheets.create', compact('projects', 'project_id', 'selected_date'));
            }
        }

        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function timesheetStore(Request $request)
    {
        if(\Auth::user()->can('create timesheet'))
        {
            $authuser = Auth::user();
            $project  = Project::find($request->project_id);

            if($project)
            {

                $request->validate(
                    [
                        'date' => 'required',
                        'time_hour' => 'required',
                        'time_minute' => 'required',
                    ]
                );

                $hour   = $request->time_hour;
                $minute = $request->time_minute;

                $time = ($hour != '' ? ($hour < 10 ? '0' + $hour : $hour) : '00') . ':' . ($minute != '' ? ($minute < 10 ? '0' + $minute : $minute) : '00');

                $timesheet              = new Timesheet();
                $timesheet->project_id  = $request->project_id;
                $timesheet->task_id     = $request->task_id;
                $timesheet->date        = $request->date;
                $timesheet->time        = $time;
                $timesheet->description = $request->description;
                $timesheet->created_by  = $authuser->id;
                $timesheet->save();

                return redirect()->back()->with('success', __('Timesheet Created Successfully!'));
            }
        }

        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function timesheetEdit(Request $request, $project_id, $timesheet_id)
    {
        if(\Auth::user()->can('edit timesheet'))
        {
            $authuser = Auth::user();

            $task_id    = $request->has('task_id') ? $request->task_id : null;
            $user_id    = $request->has('date') ? $request->user_id : null;
            $created_by = $user_id != null ? $user_id : $authuser->id;

            $project_view = '';

            if($request->has('project_view'))
            {
                $project_view = $request->project_view;
            }

            $projects = $authuser->projects();

            $timesheet = Timesheet::find($timesheet_id);

            if($timesheet)
            {

                $project = $projects->where('projects.id', '=', $project_id)->pluck('projects.project_name', 'projects.id')->all();

                if(!empty($project) && count($project) > 0)
                {

                    $project_id   = key($project);
                    $project_name = $project[$project_id];

                    $task = ProjectTask::where(
                        [
                            'project_id' => $project_id,
                            'id' => $task_id,
                        ]
                    )->pluck('name', 'id')->all();

                    $task_id   = key($task);
                    $task_name = $task[$task_id];

                    $tasktime = Timesheet::where('task_id', $task_id)->where('created_by', $created_by)->pluck('time')->toArray();

                    $totaltasktime = Utility::calculateTimesheetHours($tasktime);

                    $totalhourstimes = explode(':', $totaltasktime);

                    $totaltaskhour   = $totalhourstimes[0];
                    $totaltaskminute = $totalhourstimes[1];

                    $time = explode(':', $timesheet->time);

                    $parseArray = [
                        'project_id' => $project_id,
                        'project_name' => $project_name,
                        'task_id' => $task_id,
                        'task_name' => $task_name,
                        'time_hour' => $time[0] < 10 ? $time[0] : $time[0],
                        'time_minute' => $time[1] < 10 ? $time[1] : $time[1],
                        'totaltaskhour' => $totaltaskhour,
                        'totaltaskminute' => $totaltaskminute,
                    ];

                    return view('projects.timesheets.edit', compact('timesheet', 'parseArray'));
                }
            }
        }

        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function timesheetUpdate(Request $request, $timesheet_id)
    {
        if(\Auth::user()->can('edit timesheet'))
        {
            $project = Project::find($request->project_id);

            if($project)
            {

                $request->validate(
                    [
                        'date' => 'required',
                        'time_hour' => 'required',
                        'time_minute' => 'required',
                    ]
                );

                $hour   = $request->time_hour;
                $minute = $request->time_minute;

                $time = ($hour != '' ? ($hour < 10 ? '0' + $hour : $hour) : '00') . ':' . ($minute != '' ? ($minute < 10 ? '0' + $minute : $minute) : '00');

                $timesheet              = Timesheet::find($timesheet_id);
                $timesheet->project_id  = $request->project_id;
                $timesheet->task_id     = $request->task_id;
                $timesheet->date        = $request->date;
                $timesheet->time        = $time;
                $timesheet->description = $request->description;
                $timesheet->save();

                return redirect()->back()->with('success', __('Timesheet Updated Successfully!'));
            }
        }

        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function timesheetDestroy($timesheet_id)
    {
        if(\Auth::user()->can('delete timesheet'))
        {
            $timesheet = Timesheet::find($timesheet_id);

            if($timesheet)
            {
                $timesheet->delete();
            }

            return redirect()->back()->with('success', __('Timesheet deleted Successfully!'));
        }

        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function timesheetList()
    {
            return view('projects.timesheet_list');
    }

    public function timesheetListGet(Request $request)
    {
        $authuser = Auth::user();
        $week     = $request->week;

        if($request->has('week') && $request->has('project_id'))
        {
            $project_id = $request->project_id;

            $project_ids        = $authuser->projects()->pluck('project_id')->toArray();
            $timesheets         = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id');
            $projects_timesheet = $timesheets->join('project_tasks', 'project_tasks.id', '=', 'timesheets.task_id');

            if($project_id == '0')
            {
                $projects_timesheet = $timesheets->whereIn('projects.id', $project_ids);
            }
            else if(in_array($project_id, $project_ids))
            {
                $projects_timesheet = $timesheets->where('timesheets.project_id', $project_id);
            }

            $days        = Utility::getFirstSeventhWeekDay($week);
            $first_day   = $days['first_day'];
            $seventh_day = $days['seventh_day'];

            $onewWeekDate = $first_day->format('M d') . ' - ' . $seventh_day->format('M d, Y');
            $selectedDate = $first_day->format('Y-m-d') . ' - ' . $seventh_day->format('Y-m-d');

            $projects_timesheet = $projects_timesheet->whereDate('date', '>=', $first_day->format('Y-m-d'))->whereDate('date', '<=', $seventh_day->format('Y-m-d'));

            if($project_id == '0')
            {
                $timesheets = $projects_timesheet->get()->groupBy(
                    [
                        'project_id',
                        'task_id',
                    ]
                )->toArray();
            }
            else if(in_array($project_id, $project_ids))
            {
                $timesheets = $projects_timesheet->get()->groupBy('task_id')->toArray();
            }

            $returnHTML = Project::getProjectAssignedTimesheetHTML($projects_timesheet, $timesheets, $days, $project_id);

            $totalrecords = count($timesheets);

            if($project_id != '0')
            {
                $task_ids = array_keys($timesheets);
                $project  = Project::find($project_id);
                $sections = ProjectTask::getAllSectionedTaskList($request, $project, [], $task_ids);

                foreach($sections as $key => $section)
                {
                    $taskArray = [];

                    $sectionTaskArray[$key]['section_id']   = $section['section_id'];
                    $sectionTaskArray[$key]['section_name'] = $section['section_name'];

                    foreach($section['sections'] as $taskkey => $task)
                    {
                        $taskArray[$taskkey]['task_id']   = $task['id'];
                        $taskArray[$taskkey]['task_name'] = $task['taskinfo']['task_name'];
                    }
                    $sectionTaskArray[$key]['tasks'] = $taskArray;
                }
            }

            return response()->json(
                [
                    'success' => true,
                    'totalrecords' => $totalrecords,
                    'selectedDate' => $selectedDate,
                    'sectiontasks' => $sectionTaskArray,
                    'onewWeekDate' => $onewWeekDate,
                    'html' => $returnHTML,
                ]
            );
        }
    }


}
