<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
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
        if(\Auth::user()->can('manage source'))
        {
            $sources = Source::where('created_by', '=', \Auth::user()->ownerId())->get();

            return view('sources.index')->with('sources', $sources);
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
        if(\Auth::user()->can('create source'))
        {
            return view('sources.create');
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
        if(\Auth::user()->can('create source'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('sources.index')->with('error', $messages->first());
            }

            $source             = new Source();
            $source->name       = $request->name;
            $source->created_by = \Auth::user()->ownerId();
            $source->save();

            return redirect()->route('sources.index')->with('success', __('Source successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Source $source
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source)
    {
        return redirect()->route('sources.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Source $source
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source)
    {
        if(\Auth::user()->can('edit source'))
        {
            if($source->created_by == \Auth::user()->ownerId())
            {
                return view('sources.edit', compact('source'));
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
     * @param \App\Source $source
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source)
    {
        if(\Auth::user()->can('edit source'))
        {
            if($source->created_by == \Auth::user()->ownerId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('sources.index')->with('error', $messages->first());
                }

                $source->name = $request->name;
                $source->save();

                return redirect()->route('sources.index')->with('success', __('Source successfully updated!'));
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
     * @param \App\Source $source
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        if(\Auth::user()->can('delete source'))
        {
            if($source->created_by == \Auth::user()->ownerId())
            {
                $source->delete();

                return redirect()->route('sources.index')->with('success', __('Source successfully deleted!'));
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
