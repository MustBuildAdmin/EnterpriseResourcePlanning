<?php

namespace App\Exports;

use App\Models\Project;
use App\Models\project_report;
use App\Models\Milestone;
use App\Models\ProjectTask;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class task_reportExport implements FromCollection,WithHeadings
{


    protected $id;

     function __construct($id)
     {
        $this->id = $id;
     }

     public function collection()
     {
         $data = ProjectTask::where('project_id' ,$this->id)->get();
         foreach($data as $k => $tasks)
         {
             unset($tasks->estimated_hrs,$tasks->priority_color,$tasks->project_id,$tasks->order,
                 $tasks->created_by,$tasks->is_favourite,$tasks->is_complete,$tasks->marked_at,$tasks->progress,
                 $tasks->created_at,$tasks->updated_at);

             $data[$k]["id"]            = $tasks->id;
             $data[$k]["title"]         = $tasks->title;
             $data[$k]["description"]    = $tasks->description;
             $data[$k]["start_date"]     = $tasks->start_date;
             $data[$k]["end_date"]       = $tasks->end_date;
             $data[$k]["priority"]      = $tasks->priority;
             $user_name =   project_report::assign_user($tasks->assign_to);
             $data[$k]["assign_to"]      = $user_name;
             $milestone_name =   project_report::milestone($tasks->milestone_id);
             $data[$k]["milestone_id"]   = $milestone_name;
             $status_name =   project_report::status($tasks->stage_id);
             $data[$k]["stage_id"]         = $status_name;
         }
            return $data;
     }

     public function headings(): array
     {
         return [
                "ID",
                "Title",
                "Description",
                "Start Date",
                "End Date",
                "Priority",
                "Assign To",
                "Milestone",
                "Status",
            ];
     }

}
