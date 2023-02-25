<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Pipeline;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
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
     * Display a listing of the restage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('manage stage'))
        {
            $stages    = Stage::select('stages.*', 'pipelines.name as pipeline')->join('pipelines', 'pipelines.id', '=', 'stages.pipeline_id')->where('pipelines.created_by', '=', \Auth::user()->ownerId())->where('stages.created_by', '=', \Auth::user()->ownerId())->orderBy('stages.pipeline_id')->orderBy('stages.order')->get();
            $pipelines = [];

            foreach($stages as $stage)
            {
                if(!array_key_exists($stage->pipeline_id, $pipelines))
                {
                    $pipelines[$stage->pipeline_id]           = [];
                    $pipelines[$stage->pipeline_id]['name']   = $stage['pipeline'];
                    $pipelines[$stage->pipeline_id]['stages'] = [];
                }
                $pipelines[$stage->pipeline_id]['stages'][] = $stage;
            }

            return view('stages.index')->with('pipelines', $pipelines);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new restage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('create stage'))
        {
            $pipelines = Pipeline::where('created_by', '=', \Auth::user()->ownerId())->get()->pluck('name', 'id');

            return view('stages.create')->with('pipelines', $pipelines);
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created restage in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('create stage'))
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
                return redirect()->route('stages.index')->with('error', $messages->first());
            }
            $stage              = new Stage();
            $stage->name        = $request->name;
            $stage->pipeline_id = $request->pipeline_id;
            $stage->created_by  = \Auth::user()->ownerId();
            $stage->save();

            return redirect()->route('stages.index')->with('success', __('Deal Stage successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified restage.
     *
     * @param \App\Stage $stage
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Stage $stage)
    {
        return redirect()->route('stages.index');
    }

    /**
     * Show the form for editing the specified restage.
     *
     * @param \App\Stage $stage
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Stage $stage)
    {
        if(\Auth::user()->can('edit stage'))
        {
            if($stage->created_by == \Auth::user()->ownerId())
            {
                $pipelines = Pipeline::where('created_by', '=', \Auth::user()->ownerId())->get()->pluck('name', 'id');

                return view('stages.edit', compact('stage', 'pipelines'));
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
     * Update the specified restage in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Stage $stage
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stage $stage)
    {
        if(\Auth::user()->can('edit stage'))
        {

            if($stage->created_by == \Auth::user()->ownerId())
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
                    return redirect()->route('stages.index')->with('error', $messages->first());
                }

                $stage->name        = $request->name;
                $stage->pipeline_id = $request->pipeline_id;
                $stage->save();
                return redirect()->route('stages.index')->with('success', __('Deal Stage successfully updated!'));
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
     * Remove the specified restage from storage.
     *
     * @param \App\Stage $stage
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stage $stage)
    {
        if(\Auth::user()->can('delete stage'))
        {
            if($stage->created_by == \Auth::user()->ownerId())
            {
                $deals = Deal::where('stage_id', '=', $stage->id)->where('created_by', '=', $stage->created_by)->count();

                if($deals == 0)
                {
                    $stage->delete();

                    return redirect()->route('stages.index')->with('success', __('Deal Stage successfully deleted!'));
                }
                else
                {
                    return redirect()->route('stages.index')->with('error', __('There are some deals on stage, please remove it first!'));
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

    public function order(Request $request)
    {
        $post = $request->all();
        foreach($post['order'] as $key => $item)
        {
            $stage        = Stage::where('id', '=', $item)->first();
            $stage->order = $key;
            $stage->save();
        }
    }

    public function json(Request $request)
    {
        $stage = new Stage();
        if($request->pipeline_id)
        {
            $stage = $stage->where('pipeline_id', '=', $request->pipeline_id);
            $stage = $stage->get()->pluck('name', 'id');
        }
        else
        {
            $stage = [];
        }


        return response()->json($stage);
    }
}
