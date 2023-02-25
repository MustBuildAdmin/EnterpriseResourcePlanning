<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage assets'))
        {
            $assets = Asset::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('assets.index', compact('assets'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create assets'))
        {

            return view('assets.create');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create assets'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'purchase_date' => 'required',
                                   'supported_date' => 'required',
                                   'amount' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $assets                 = new Asset();
            $assets->name           = $request->name;
            $assets->purchase_date  = $request->purchase_date;
            $assets->supported_date = $request->supported_date;
            $assets->amount         = $request->amount;
            $assets->description    = $request->description;
            $assets->created_by     = \Auth::user()->creatorId();
            $assets->save();

            return redirect()->route('account-assets.index')->with('success', __('Assets successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Asset $asset)
    {
        //
    }


    public function edit($id)
    {

        if(\Auth::user()->can('edit assets'))
        {
            $asset = Asset::find($id);

            return view('assets.edit', compact('asset'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit assets'))
        {
            $asset = Asset::find($id);
            if($asset->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required',
                                       'purchase_date' => 'required',
                                       'supported_date' => 'required',
                                       'amount' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $asset->name           = $request->name;
                $asset->purchase_date  = $request->purchase_date;
                $asset->supported_date = $request->supported_date;
                $asset->amount         = $request->amount;
                $asset->description    = $request->description;
                $asset->save();

                return redirect()->route('account-assets.index')->with('success', __('Assets successfully updated.'));
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
        if(\Auth::user()->can('delete assets'))
        {
            $asset = Asset::find($id);
            if($asset->created_by == \Auth::user()->creatorId())
            {
                $asset->delete();

                return redirect()->route('account-assets.index')->with('success', __('Assets successfully deleted.'));
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
