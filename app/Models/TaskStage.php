<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStage extends Model
{
    protected $fillable = [
        'name',
        'complete',
        'project_id',
        'color',
        'order',
        'created_by',
    ];

    public static $stages = [
        "Todo",
        "In Progress",
        "Review",
        "Done",
    ];
    public static function getChartData()
    {
        $usr     = \Auth::user();
        $m       = date("m");
        $de      = date("d");
        $y       = date("Y");
        $format  = 'Y-m-d';
        $arrDate = [];
        $arrDay  = [];

        for($i = 0; $i <= 7 - 1; $i++)
        {
            $date              = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
            $arrDay['label'][] = __(date('D', mktime(0, 0, 0, $m, ($de - $i), $y)));
            $arrDate[]         = $date;
        }

        $stages  = TaskStage::where('created_by', '=', $usr->creatorId())->get();
        $arrTask = [];

        $i = 0;
        if($usr->type == 'company')
        {
            foreach($stages as $key => $stage)
            {
                $data = [];
                foreach($arrDate as $d)
                {
                    $data[] = ProjectTask::where('stage_id', '=', $stage->id)->whereDate('updated_at', '=', $d)->count();
                }

                $dataset['name']           = $stage->name;
//                $dataset['fill']            = true;
                $dataset['backgroundColor'] = 'transparent';
                $dataset['borderColor']     = $stage->color;
                $dataset['data']            = $data;
                $arrTask[]                  = $dataset;
                $i++;
            }

            $arrTaskData = array_merge($arrDay, ['dataset' => $arrTask]);
            unset($arrTaskData['dataset'][$i - 1]['fill']);
            $arrTaskData['dataset'][$i - 1]['backgroundColor'] = '#ccc';

            return $arrTaskData;
        }
        elseif($usr->type == 'client')
        {
            foreach($stages as $key => $stage)
            {
                $data = [];
                foreach($arrDate as $d)
                {
                    $data[] = ProjectTask::join('projects', 'project_tasks.project_id', '=', 'projects.id')->where('projects.client_id', '=', $usr->id)->where('stage_id', '=', $stage->id)->whereDate('project_tasks.updated_at', '=', $d)->count();
                }

                $dataset['name']           = $stage->name;
//                $dataset['fill']            = '!0';
                $dataset['backgroundColor'] = 'transparent';
                $dataset['borderColor']     = $stage->color;
                $dataset['data']            = $data;
                $arrTask[]                  = $dataset;
                $i++;
            }
            $arrTaskData = array_merge($arrDay, ['dataset' => $arrTask]);
            unset($arrTaskData['dataset'][$i - 1]['fill']);
            $arrTaskData['dataset'][$i - 1]['backgroundColor'] = '#ccc';

            return $arrTaskData;
        }
        else
        {
            foreach($stages as $key => $stage)
            {
                $data = [];
                foreach($arrDate as $d)
                {
                    $data[] = ProjectTask::where('assign_to', '=', $usr->id)->where('stage_id', '=', $stage->id)->whereDate('project_tasks.updated_at', '=', $d)->count();
                }


                $dataset['name']           = $stage->name;
//                $dataset['fill']            = '!0';
                $dataset['backgroundColor'] = 'transparent';
                $dataset['borderColor']     = $stage->color;
                $dataset['data']            = $data;
                $arrTask[]                  = $dataset;
                $i++;
            }
            $arrTaskData = array_merge($arrDay, ['dataset' => $arrTask]);
            unset($arrTaskData['dataset'][$i - 1]['fill']);
            $arrTaskData['dataset'][$i - 1]['backgroundColor'] = '#ccc';

            return $arrTaskData;
        }
    }
}
