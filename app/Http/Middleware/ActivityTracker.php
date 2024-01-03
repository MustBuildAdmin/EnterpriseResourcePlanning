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
        
        if(Session::has('ses_current_clientId')){
            $current_id_old=Session::get('ses_current_clientId');
            $client_name_old=Session::get('ses_current_clientName');
        }else{
            $current_id_old=Session::get('ses_user_id');
            $client_name_old='Admin';
        }

        $route_url_old=url()->current();
        $form_data_old=json_encode($request->all());
            
        if ($request->isMethod('post')) {
            $activity_old='Data changed in the form';
        }else{
            $activity_old='Visit the page';
        }
       
        $insertdata=array(
            'user_id'   => \Auth::user()->creatorId(),
            'project_id'    =>  Session::get("project_id"),
            'task_id'      => 0,
            'deal_id'    => 0,
            'log_type'         => $activity,
            'remark' => 'dfgfdg',
        );
        if(str_contains($route_url_old,'overallactivity')||str_contains($route_url_old,'overaluserlactivity')||str_contains($route_url_old,'getlogodata')||str_contains($route_url_old,'tabsession_store_check')||str_contains($route_url_old,'tabsession_store')) { 
            
        }else{
            ActivityLog::insert($insertdata);
            $old_date=Tracer_activities::where('created_at','<',Carbon::now()->subYear(1))->Delete();
            // deactivate the user older than 90 days
            // Usertable::where('login_at','<',Carbon::now()->subDays(90))->where('login_at','!=',NULL)->update(['status'=>0]);
        }
        
       
        
        return $next($request);
    }
}
