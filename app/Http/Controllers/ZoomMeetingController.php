<?php

namespace App\Http\Controllers;

use App\Models\AssignProject;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Tag;
use App\Models\ZoomMeeting;
use App\Models\User;
use App\Models\Utility;
use App\Traits\ZoomMeetingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT               = 1;
    const MEETING_TYPE_SCHEDULE              = 2;
    const MEETING_TYPE_RECURRING             = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;
    const MEETING_URL                        = "https://api.zoom.us/v2/";


    public function index()
    {
        if(\Auth::user()->isClient())
        {
            $meetings = ZoomMeeting::where('client_id', \Auth::user()->id)->get();
        }
        else
        {
            $meetings = ZoomMeeting::where('created_by', \Auth::user()->creatorId())->get();
        }

        // $this->statusUpdate();
        return view('zoom-meeting.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::where('created_by', \Auth::user()->creatorId())->get()->pluck('project_name', 'id');
        $users    = User::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');


        return view('zoom-meeting.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if(\Auth::user()->type == 'company')
        {
            $validator = \Validator::make($request->all(), [
                'title' => 'required',
                'project_id' => 'required',
                'start_date' => 'required',
            ]);
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('zoom-meeting.index')->with('error', $messages->first());
            }
            $data['title']             = $request->title;
            $data['start_time']        = date('y:m:d H:i:s', strtotime($request->start_date));
            $data['duration']          = (int)$request->duration;
            $data['password']          = $request->password;
            $data['host_video']        = 0;
            $data['participant_video'] = 0;

            $meeting_create = $this->createmitting($data);

            \Log::info('Meeting');
            \Log::info((array)$meeting_create);
            if(isset($meeting_create['success']) && $meeting_create['success'] == true)
            {
                $meeting_id = isset($meeting_create['data']['id']) ? $meeting_create['data']['id'] : 0;
                $start_url  = isset($meeting_create['data']['start_url']) ? $meeting_create['data']['start_url'] : '';
                $join_url   = isset($meeting_create['data']['join_url']) ? $meeting_create['data']['join_url'] : '';
                $status     = isset($meeting_create['data']['status']) ? $meeting_create['data']['status'] : '';


                $client = Project::where('id', $request->project_id)->first();

                $zoommeeting             = new Zoommeeting();
                $zoommeeting->title      = $request->title;
                $zoommeeting->meeting_id = $meeting_id;
                $zoommeeting->project_id = $request->project_id;
                $zoommeeting->user_id    = implode(',', $request->user_id);
                $zoommeeting->start_date = date('y:m:d H:i:s', strtotime($request->start_date));
                $zoommeeting->duration   = $request->duration;
                $zoommeeting->start_url  = $start_url;
                $zoommeeting->client_id  = isset($request->client_id) ? $client->client_id : 0;
                $zoommeeting->join_url   = $join_url;
                $zoommeeting->status     = $status;
                $zoommeeting->created_by = \Auth::user()->creatorId();
                $zoommeeting->save();


                return redirect()->route('zoom-meeting.index')->with('success', __('Zoom Meeting successfully created.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ZoomMeeting $zoomMeeting
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ZoomMeeting $zoomMeeting)
    {

        if($zoomMeeting->created_by == \Auth::user()->creatorId())
        {

            return view('zoom-meeting.show', compact('zoomMeeting'));
        }
        else
        {
            return redirect()->back()->with('error', 'permission Denied');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ZoomMeeting $zoomMeeting
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ZoomMeeting $zoomMeeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ZoomMeeting $zoomMeeting
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ZoomMeeting $zoomMeeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ZoomMeeting $zoomMeeting
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZoomMeeting $zoomMeeting)
    {
        if($zoomMeeting->created_by == \Auth::user()->creatorId())
        {
            $zoomMeeting->delete();

            return redirect()->route('zoom-meeting.index')->with('success', __('Meeting successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function projectwiseuser($id)
    {
        $projects = ProjectUser::select('user_id')->where('project_id', $id)->get();

        $users = [];
        foreach($projects as $key => $value)
        {
            $user = User::select('id', 'name')->where('id', $value->user_id)->first();
            if(!empty($user))
            {
                $users1['id']   = !empty($user)?$user->id:0;
                $users1['name'] = !empty($user->name)?$user->name:'';
                $users[]        = $users1;
            }


        }

        return \Response::json($users);

    }

    public function statusUpdate()
    {
        $meetings = ZoomMeeting::where('created_by', \Auth::user()->id)->pluck('meeting_id');
        foreach($meetings as $meeting)
        {
            $data = $this->get($meeting);

            if(isset($data['data']) && !empty($data['data']))
            {
                $meeting = ZoomMeeting::where('meeting_id', $meeting)->update(['status' => $data['data']['status']]);
            }
        }

    }

    public function calender(Request $request)
    {
        $user      = \Auth::user();
        $transdate = date('Y-m-d', time());

        if($user->type == 'company' || $user->type == 'HR' || $user->type == 'accountant')
        {
            $zoomMeetings = ZoomMeeting::where('created_by', '=', \Auth::user()->creatorId())->get();
        }

        $calandar = [];
        $zoomMeetings =[];

        foreach($zoomMeetings as $zoomMeeting)
        {

            $arr['id']        = $zoomMeeting['id'];
            $arr['title']     = $zoomMeeting['title'];
            $arr['start']     = $zoomMeeting['start_date'];
            $arr['end']       = $zoomMeeting['end_date'];
            $arr['className'] = 'event-primary';
            $arr['url']       = route('zoom-meeting.show', $zoomMeeting['id']);
            $calandar[]     = $arr;


        }


            return view('zoom-meeting.calender', compact('calandar', 'transdate', 'zoomMeetings'));
    }


}
