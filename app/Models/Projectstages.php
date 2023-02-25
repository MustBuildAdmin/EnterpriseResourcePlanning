<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectstages extends Model
{
    protected $fillable = [
        'name',
        'color',
        'created_by',
        'order',
    ];

    protected $hidden = [];

    public function tasks($project_id)
    {
        if(\Auth::user()->type == 'client' || \Auth::user()->type == 'company')
        {
            return Task::where('stage', '=', $this->id)->where('project_id', '=', $project_id)->orderBy('order')->get();
        }
        else
        {
            return Task::where('stage', '=', $this->id)->where('assign_to', '=', \Auth::user()->id)->where('project_id', '=', $project_id)->orderBy('order')->get();
        }
    }

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

        $stages  = Projectstages::where('created_by', '=', $usr->creatorId())->get();
        $arrTask = [];

        $i = 0;
        if($usr->type == 'company')
        {
            foreach($stages as $key => $stage)
            {
                $data = [];
                foreach($arrDate as $d)
                {
                    $data[] = Task::where('stage', '=', $stage->id)->whereDate('updated_at', '=', $d)->count();
                }

                $dataset['label']           = $stage->name;
                $dataset['fill']            = '!0';
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
                    $data[] = Task::join('projects', 'tasks.project_id', '=', 'projects.id')->where('projects.client', '=', $usr->id)->where('stage', '=', $stage->id)->whereDate('tasks.updated_at', '=', $d)->count();
                }

                $dataset['label']           = $stage->name;
                $dataset['fill']            = '!0';
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
                    $data[] = Task::where('assign_to', '=', $usr->id)->where('stage', '=', $stage->id)->whereDate('tasks.updated_at', '=', $d)->count();
                }


                $dataset['label']           = $stage->name;
                $dataset['fill']            = '!0';
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
