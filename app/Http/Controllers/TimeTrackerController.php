<?php

namespace App\Http\Controllers;

use App\Models\TimeTracker;
use App\Models\TrackPhoto;
use App\Models\Utility;
use Illuminate\Http\Request;

class TimeTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treckers = TimeTracker::where('created_by', \Auth::user()->id)->get();

        return view('time_trackers.index', compact('treckers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(TimeTracker $timeTracker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeTracker $timeTracker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeTracker $timeTracker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeTracker  $timeTracker
     * @return \Illuminate\Http\Response
     */
    public function destroy($timetracker_id)
    {
        //        return redirect()->back()->with('error',__('This operation is not perform due to demo mode.'));
        // if(Auth::user()->can('delete timesheet'))
        // {
        $timetrecker = TimeTracker::find($timetracker_id);
        $timetrecker->delete();

        return redirect()->back()->with('success', __('TimeTracker successfully deleted.'));
        // }
        // else
        // {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }

    }

    public function getTrackerImages(Request $request)
    {

        $tracker = TimeTracker::find($request->id);

        $images = TrackPhoto::where('track_id', $request->id)->get();

        // dd($images->toArray());
        // dd($tracker);
        return view('time_trackers.images', compact('images', 'tracker'));
    }

    public function removeTrackerImages(Request $request)
    {

        $images = TrackPhoto::find($request->id);
        if ($images) {
            $url = $images->img_path;
            if ($images->delete()) {
                \Storage::delete($url);

                return Utility::success_res(__('Tracker Photo remove successfully.'));
            } else {
                return Utility::error_res(__('opps something wren wrong.'));
            }
        } else {
            return Utility::error_res(__('opps something wren wrong.'));
        }

    }

    public function removeTracker(Request $request)
    {

        $track = TimeTracker::find($request->input('id'));
        if ($track) {
            $track->delete();

            return Utility::success_res(__('Track remove successfully.'));
        } else {
            return Utility::error_res(__('Track not found.'));
        }
    }
}
