<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractType;
use Illuminate\Http\Request;

class ContractTypeController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('manage contract type'))
        {
            if(\Auth::user()->type == 'company')
            {
                $types = ContractType::where('created_by', '=', \Auth::user()->creatorId())->get();
                return view('contractType.index', compact('types'));
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

    public function create()
    {
        return view('contractType.create');
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create contract type'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $types             = new ContractType();
            $types->name       = $request->name;
            $types->created_by = \Auth::user()->creatorId();
            $types->save();

            return redirect()->route('contractType.index')->with('success', __('Contract Type successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(ContractType $contractType)
    {
        //
    }


    public function edit(ContractType $contractType)
    {
        return view('contractType.edit', compact('contractType'));
    }


    public function update(Request $request, ContractType $contractType)
    {
        if(\Auth::user()->can('edit contract type'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $contractType->name       = $request->name;
            $contractType->created_by = \Auth::user()->creatorId();
            $contractType->save();

            return redirect()->route('contractType.index')->with('success', __('Contract Type successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(ContractType $contractType)
    {
        if(\Auth::user()->can('delete contract type'))
        {
            $data = Contract::where('type', $contractType->id)->first();
            if(!empty($data))
            {
                return redirect()->back()->with('error', __('this type is already use so please transfer or delete this type related data.'));
            }

            $contractType->delete();

            return redirect()->route('contractType.index')->with('success', __('Contract Type successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
