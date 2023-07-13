<?php

namespace App\Http\Controllers;

use App\Models\AwardType;
use Illuminate\Http\Request;

class AwardTypeController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage award type'))
        {
            $awardtypes = AwardType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('hrm.system_setup.awardtype.awardtype', compact('awardtypes'));
            // return view('awardtype.index', compact('awardtypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create award type'))
        {
            return view('hrm.system_setup.awardtype.awardtype_create');
            // return view('awardtype.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create award type'))
        {

            $validator = \Validator::make(
                $request->all(), [

                                   'name' => 'required|max:20|unique:award_types',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $awardtype             = new AwardType();
            $awardtype->name       = $request->name;
            $awardtype->created_by = \Auth::user()->creatorId();
            $awardtype->save();

            return redirect()->route('awardtype.index')->with('success', __('AwardType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(AwardType $awardtype)
    {
        return redirect()->route('awardtype.index');
    }

    public function edit(AwardType $awardtype)
    {
        if(\Auth::user()->can('edit award type'))
        {
            if($awardtype->created_by == \Auth::user()->creatorId())
            {

                return view('hrm.system_setup.awardtype.awardtype_edit', compact('awardtype'));
                // return view('awardtype.edit', compact('awardtype'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, AwardType $awardtype)
    {
        if(\Auth::user()->can('edit award type'))
        {
            if($awardtype->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [

                                       'name' => 'required|max:20|unique:award_types',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $awardtype->name = $request->name;
                $awardtype->save();

                return redirect()->route('awardtype.index')->with('success', __('AwardType successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(AwardType $awardtype)
    {
        if(\Auth::user()->can('delete award type'))
        {
            if($awardtype->created_by == \Auth::user()->creatorId())
            {
                $awardtype->delete();

                return redirect()->route('awardtype.index')->with('success', __('AwardType successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
