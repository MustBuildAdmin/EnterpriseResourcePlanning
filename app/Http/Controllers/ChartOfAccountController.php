<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountSubType;
use App\Models\ChartOfAccountType;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{

    public function index()
    {



        if(\Auth::user()->can('manage chart of account'))
        {
            $types = ChartOfAccountType::where('created_by', '=', \Auth::user()->creatorId())->get();


            $chartAccounts = [];
            foreach($types as $type)
            {
                $accounts = ChartOfAccount::where('type', $type->id)->where('created_by', '=', \Auth::user()->creatorId())->get();

                $chartAccounts[$type->name] = $accounts;

            }
            return view('accounting.chartOfAccount.index', compact('chartAccounts', 'types'));
            // return view('chartOfAccount.index', compact('chartAccounts', 'types'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $types = ChartOfAccountType::where('created_by',\Auth::user()->creatorId())->get()->pluck('name', 'id');
        $types->prepend('--', '');

        return view('chartOfAccount.create', compact('types'));
    }


    public function store(Request $request)
    {

        if(\Auth::user()->can('create chart of account'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'type' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $account              = new ChartOfAccount();
            $account->name        = $request->name;
            $account->code        = $request->code;
            $account->type        = $request->type;
            $account->sub_type    = $request->sub_type;
            $account->description = $request->description;
            $account->is_enabled  = isset($request->is_enabled) ? 1 : 0;
            $account->created_by  = \Auth::user()->creatorId();
            $account->save();

            return redirect()->route('chart-of-account.index')->with('success', __('Account successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(ChartOfAccount $chartOfAccount)
    {
        //
    }


    public function edit(ChartOfAccount $chartOfAccount)
    {
        $types = ChartOfAccountType::get()->pluck('name', 'id');
        $types->prepend('--', '');

        return view('chartOfAccount.edit', compact('chartOfAccount', 'types'));
    }


    public function update(Request $request, ChartOfAccount $chartOfAccount)
    {

        if(\Auth::user()->can('edit chart of account'))
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


            $chartOfAccount->name        = $request->name;
            $chartOfAccount->code        = $request->code;
            $chartOfAccount->description = $request->description;
            $chartOfAccount->is_enabled  = isset($request->is_enabled) ? 1 : 0;
            $chartOfAccount->save();

            return redirect()->route('chart-of-account.index')->with('success', __('Account successfully updated.'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function destroy(ChartOfAccount $chartOfAccount)
    {
        if(\Auth::user()->can('delete chart of account'))
        {
            $chartOfAccount->delete();

            return redirect()->route('chart-of-account.index')->with('success', __('Account successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getSubType(Request $request)
    {
        $types = ChartOfAccountSubType::where('type', $request->type)->get()->pluck('name', 'id')->toArray();

        return response()->json($types);
    }
}
