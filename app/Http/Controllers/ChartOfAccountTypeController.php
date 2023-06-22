<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccountType;
use Illuminate\Http\Request;

class ChartOfAccountTypeController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('manage constant chart of account type'))
        {
            $types = ChartOfAccountType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('chartOfAccountType.index', compact('types'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        return view('chartOfAccountType.create');
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create constant chart of account type'))
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

            $account             = new ChartOfAccountType();
            $account->name       = $request->name;
            $account->created_by = \Auth::user()->creatorId();
            $account->save();

            return redirect()->route('chart-of-account-type.index')->with('success', __('Chart of account type successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(ChartOfAccountType $chartOfAccountType)
    {
        //
    }


    public function edit(ChartOfAccountType $chartOfAccountType)
    {
        return view('chartOfAccountType.edit', compact('chartOfAccountType'));
    }


    public function update(Request $request, ChartOfAccountType $chartOfAccountType)
    {
        if(\Auth::user()->can('edit constant chart of account type'))
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

            $chartOfAccountType->name = $request->name;
            $chartOfAccountType->save();

            return redirect()->route('chart-of-account-type.index')->with('success', __('Chart of account type successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(ChartOfAccountType $chartOfAccountType)
    {
        if(\Auth::user()->can('delete constant chart of account type'))
        {
            $chartOfAccountType->delete();

            return redirect()->route('chart-of-account-type.index')->with('success', __('Chart of account type successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
