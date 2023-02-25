<?php

namespace App\Http\Controllers;

use App\Models\LeadStage;
use App\Models\Pipeline;
use Illuminate\Http\Request;

class LeadStageController extends Controller
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
        if(\Auth::user()->can('manage lead stage'))
        {
            $lead_stages = LeadStage::select('lead_stages.*', 'pipelines.name as pipeline')->join('pipelines', 'pipelines.id', '=', 'lead_stages.pipeline_id')->where('pipelines.created_by', '=', \Auth::user()->ownerId())->where('lead_stages.created_by', '=', \Auth::user()->ownerId())->orderBy('lead_stages.pipeline_id')->orderBy('lead_stages.order')->get();
            $pipelines   = [];

            foreach($lead_stages as $lead_stage)
            {
                if(!array_key_exists($lead_stage->pipeline_id, $pipelines))
                {
                    $pipelines[$lead_stage->pipeline_id]                = [];
                    $pipelines[$lead_stage->pipeline_id]['name']        = $lead_stage['pipeline'];
                    $pipelines[$lead_stage->pipeline_id]['lead_stages'] = [];
                }
                $pipelines[$lead_stage->pipeline_id]['lead_stages'][] = $lead_stage;
            }

            return view('lead_stages.index')->with('pipelines', $pipelines);
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
        if(\Auth::user()->can('create lead stage'))
        {
            $pipelines = Pipeline::where('created_by', '=', \Auth::user()->ownerId())->get()->pluck('name', 'id');

            return view('lead_stages.create')->with('pipelines', $pipelines);
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
        if(\Auth::user()->can('create lead stage'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                                   'pipeline_id' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('lead_stages.index')->with('error', $messages->first());
            }
            $lead_stage              = new LeadStage();
            $lead_stage->name        = $request->name;
            $lead_stage->pipeline_id = $request->pipeline_id;
            $lead_stage->created_by  = \Auth::user()->ownerId();
            $lead_stage->save();

            return redirect()->route('lead_stages.index')->with('success', __('Lead Stage successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\LeadStage $leadStage
     *
     * @return \Illuminate\Http\Response
     */
    public function show(LeadStage $leadStage)
    {
        return redirect()->route('lead_stages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\LeadStage $leadStage
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadStage $leadStage)
    {
        if(\Auth::user()->can('edit lead stage'))
        {
            if($leadStage->created_by == \Auth::user()->ownerId())
            {
                $pipelines = Pipeline::where('created_by', '=', \Auth::user()->ownerId())->get()->pluck('name', 'id');

                return view('lead_stages.edit', compact('leadStage', 'pipelines'));
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
     * @param \App\LeadStage $leadStage
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadStage $leadStage)
    {
        if(\Auth::user()->can('edit lead stage'))
        {

            if($leadStage->created_by == \Auth::user()->ownerId())
            {

                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                       'pipeline_id' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('lead_stages.index')->with('error', $messages->first());
                }

                $leadStage->name        = $request->name;
                $leadStage->pipeline_id = $request->pipeline_id;
                $leadStage->save();

                return redirect()->route('lead_stages.index')->with('success', __('Lead Stage successfully updated!'));
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
     * @param \App\LeadStage $leadStage
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadStage $leadStage)
    {
        if(\Auth::user()->can('delete lead stage'))
        {
            $leadStage->delete();

            return redirect()->route('lead_stages.index')->with('success', __('Lead Stage successfully deleted!'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function order(Request $request)
    {
        $post = $request->all();
        foreach($post['order'] as $key => $item)
        {
            $lead_stage        = LeadStage::where('id', '=', $item)->first();
            $lead_stage->order = $key;
            $lead_stage->save();
        }
    }
}
