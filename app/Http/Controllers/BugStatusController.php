<?php

namespace App\Http\Controllers;

use App\Models\BugStatus;
use Illuminate\Http\Request;

class BugStatusController extends Controller
{

    public function index()
    {
        $bugStatus = BugStatus::where('created_by', '=', \Auth::user()->creatorId())->orderBy('order')->get();
        return view('bugstatus.index', compact('bugStatus'));
    }


    public function create()
    {
        return view('bugstatus.create');
    }


    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'title' => 'required|max:20',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->route('bugstatus.index')->with('error', $messages->first());
        }
        $all_status         = BugStatus::where('created_by', \Auth::user()->creatorId())->orderBy('id', 'DESC')->first();
        $status             = new BugStatus();
        $status->title      = $request->title;
        $status->created_by = \Auth::user()->creatorId();
        $status->order      = (!empty($all_status) ? ($all_status->order + 1) : 0);
        $status->save();

        return redirect()->route('bugstatus.index')->with('success', __('Bug status successfully created.'));
    }


    public function edit($id)
    {
        $bugStatus = BugStatus::findOrfail($id);
        if($bugStatus->created_by == \Auth::user()->creatorId())
        {
            return view('bugstatus.edit', compact('bugStatus'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, $id)
    {

        $bugstatus = BugStatus::findOrfail($id);
        if($bugstatus->created_by == \Auth::user()->creatorId())
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'title' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('bugstatus.index')->with('error', $messages->first());
            }

            $bugstatus->title = $request->title;
            $bugstatus->save();

            return redirect()->route('bugstatus.index')->with('success', __('Bug status successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy($id)
    {

        $bugstatus = BugStatus::findOrfail($id);
        if($bugstatus->created_by == \Auth::user()->creatorId())
        {

            $bugstatus->delete();

            return redirect()->route('bugstatus.index')->with('success', __('Bug status successfully deleted.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function order(Request $request)
    {
        $post = $request->all();
        foreach($post['order'] as $key => $item)
        {
            $status        = BugStatus::where('id', '=', $item)->first();
            $status->order = $key;
            $status->save();
        }
    }
}
