<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ClientDeal;
use App\Models\Deal;
use App\Models\DealDiscussion;
use App\Models\DealFile;
use App\Models\DealTask;
use App\Models\Pipeline;
use App\Models\UserDeal;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            [
                'auth',
                'XSS',
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('manage pipeline'))
        {
            $pipelines = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('pipelines.index')->with('pipelines', $pipelines);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('create pipeline'))
        {
            return view('pipelines.create');
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
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
        if(\Auth::user()->can('create pipeline'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('pipelines.index')->with('error', $messages->first());
            }

            $pipeline             = new Pipeline();
            $pipeline->name       = $request->name;
            $pipeline->created_by = \Auth::user()->creatorId();
            $pipeline->save();

            return redirect()->route('pipelines.index')->with('success', __('Pipeline successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Pipeline $pipeline
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Pipeline $pipeline)
    {
        return redirect()->route('pipelines.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Pipeline $pipeline
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Pipeline $pipeline)
    {
        if(\Auth::user()->can('edit pipeline'))
        {
            if($pipeline->created_by == \Auth::user()->creatorId())
            {
                return view('pipelines.edit', compact('pipeline'));
            }
            else
            {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Pipeline $pipeline
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pipeline $pipeline)
    {
        if(\Auth::user()->can('edit pipeline'))
        {

            if($pipeline->created_by == \Auth::user()->creatorId())
            {

                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('pipelines.index')->with('error', $messages->first());
                }

                $pipeline->name = $request->name;
                $pipeline->save();

                return redirect()->route('pipelines.index')->with('success', __('Pipeline successfully updated!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Pipeline $pipeline
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pipeline $pipeline)
    {
        if(\Auth::user()->can('delete pipeline'))
        {
            if($pipeline->created_by == \Auth::user()->creatorId())
            {
                if(count($pipeline->stages) == 0)
                {
                    foreach($pipeline->stages as $stage)
                    {
                        $deals = Deal::where('pipeline_id', '=', $pipeline->id)->where('stage_id', '=', $stage->id)->get();
                        foreach($deals as $deal)
                        {
                            DealDiscussion::where('deal_id', '=', $deal->id)->delete();
                            DealFile::where('deal_id', '=', $deal->id)->delete();
                            ClientDeal::where('deal_id', '=', $deal->id)->delete();
                            UserDeal::where('deal_id', '=', $deal->id)->delete();
                            DealTask::where('deal_id', '=', $deal->id)->delete();
                            ActivityLog::where('deal_id', '=', $deal->id)->delete();

                            $deal->delete();
                        }

                        $stage->delete();
                    }

                    $pipeline->delete();

                    return redirect()->route('pipelines.index')->with('success', __('Pipeline successfully deleted!'));
                }
                else
                {
                    return redirect()->route('pipelines.index')->with('error', __('There are some Stages and Deals on Pipeline, please remove it first!'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
