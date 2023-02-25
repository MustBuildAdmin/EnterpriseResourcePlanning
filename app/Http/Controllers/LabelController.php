<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Pipeline;
use Illuminate\Http\Request;

class LabelController extends Controller
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
     * Display a listing of the relabel.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('manage label'))
        {
            $labels   = Label::select('labels.*', 'pipelines.name as pipeline')->join('pipelines', 'pipelines.id', '=', 'labels.pipeline_id')->where('pipelines.created_by', '=', \Auth::user()->ownerId())->where('labels.created_by', '=', \Auth::user()->ownerId())->orderBy('labels.pipeline_id')->get();
            $label = Label::where('created_by',\Auth::user()->ownerId())->get();
            $pipelines = [];

            foreach($labels as $label)
            {
                if(!array_key_exists($label->pipeline_id, $pipelines))
                {
                    $pipelines[$label->pipeline_id]           = [];
                    $pipelines[$label->pipeline_id]['name']   = $label['pipeline'];
                    $pipelines[$label->pipeline_id]['labels'] = [];
                }
                $pipelines[$label->pipeline_id]['labels'][] = $label;
            }

            return view('labels.index')->with('pipelines', $pipelines);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new relabel.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('create label'))
        {
            $pipelines = Pipeline::where('created_by', '=', \Auth::user()->ownerId())->get()->pluck('name', 'id');
            $colors = Label::$colors;

            return view('labels.create')->with('pipelines', $pipelines)->with('colors', $colors);
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created relabel in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('create label'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                                   'pipeline_id' => 'required',
                                   'color' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('labels.index')->with('error', $messages->first());
            }

            $label              = new Label();
            $label->name        = $request->name;
            $label->color       = $request->color;
            $label->pipeline_id = $request->pipeline_id;
            $label->created_by  = \Auth::user()->ownerId();
            $label->save();

            return redirect()->route('labels.index')->with('success', __('Label successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified relabel.
     *
     * @param \App\Label $label
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified relabel.
     *
     * @param \App\Label $label
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        if(\Auth::user()->can('edit label'))
        {
            if($label->created_by == \Auth::user()->ownerId())
            {
                $pipelines = Pipeline::where('created_by', '=', \Auth::user()->ownerId())->get()->pluck('name', 'id');
                $colors    = Label::$colors;

                return view('labels.edit', compact('label', 'pipelines', 'colors'));
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
     * Update the specified relabel in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Label $label
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        if(\Auth::user()->can('edit label'))
        {

            if($label->created_by == \Auth::user()->ownerId())
            {

                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                       'pipeline_id' => 'required',
                                       'color' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('users')->with('error', $messages->first());
                }

                $label->name        = $request->name;
                $label->color       = $request->color;
                $label->pipeline_id = $request->pipeline_id;
                $label->save();

                return redirect()->route('labels.index')->with('success', __('Label successfully updated!'));
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
     * Remove the specified relabel from storage.
     *
     * @param \App\Label $label
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if(\Auth::user()->can('delete label'))
        {
            if($label->created_by == \Auth::user()->ownerId())
            {
                $label->delete();

                return redirect()->route('labels.index')->with('success', __('Label successfully deleted!'));
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
