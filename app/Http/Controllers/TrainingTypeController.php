<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('manage training type'))
        {
            $trainingtypes = TrainingType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('hrm.system_setup.training.training', compact('trainingtypes'));
            // return view('trainingtype.index', compact('trainingtypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create training type'))
        {
            return view('hrm.system_setup.training.training_create');
            // return view('trainingtype.create');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create training type'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|unique:training_types',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $trainingtype             = new TrainingType();
            $trainingtype->name       = $request->name;
            $trainingtype->created_by = \Auth::user()->creatorId();
            $trainingtype->save();

            return redirect()->route('trainingtype.index')->with('success', __('TrainingType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(TrainingType $trainingType)
    {
        //
    }


    public function edit($id)
    {

        if(\Auth::user()->can('edit training type'))
        {
            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {
                return view('hrm.system_setup.training.training_edit', compact('trainingType'));
                // return view('trainingtype.edit', compact('trainingType'));
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


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit training type'))
        {
            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|unique:training_types',

                                   ]
                );

                $trainingType->name = $request->name;
                $trainingType->save();

                return redirect()->route('trainingtype.index')->with('success', __('TrainingType successfully updated.'));
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


    public function destroy($id)
    {
        if(\Auth::user()->can('delete training type'))
        {

            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {
                $trainingType->delete();

                return redirect()->route('trainingtype.index')->with('success', __('TrainingType successfully deleted.'));
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
