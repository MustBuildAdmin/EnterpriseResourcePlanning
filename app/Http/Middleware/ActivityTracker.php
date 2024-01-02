<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
use App\Models\ActivityLog;
class ActivityTracker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route_url=url()->current();
        if(str_contains($route_url,'construction_main')) {
            $user_name='dsfdsdf';
            $activity = $user_name." Visited Project Listing Page";

            $insertdata=array(
                'user_id'   => \Auth::user()->creatorId(),
                'project_id'    =>  Session::get("project_id"),
                'task_id'      => 0,
                'deal_id'    => 0,
                'log_type'         => $activity,
                'remark' => 'dfgfdg',
            );

            ActivityLog::insert($insertdata);

        }
    
        
        return $next($request);
    }
}
