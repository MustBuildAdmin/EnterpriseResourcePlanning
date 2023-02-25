<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use App\Models\ProductServiceUnit;
use Illuminate\Http\Request;

class ProductServiceUnitController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage constant unit'))
        {
            $units = ProductServiceUnit::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('productServiceUnit.index', compact('units'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create constant unit'))
        {
            return view('productServiceUnit.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create constant unit'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $category             = new ProductServiceUnit();
            $category->name       = $request->name;
            $category->created_by = \Auth::user()->creatorId();
            $category->save();

            return redirect()->route('product-unit.index')->with('success', __('Unit successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($id)
    {
        if(\Auth::user()->can('edit constant unit'))
        {
            $unit = ProductServiceUnit::find($id);

            return view('productServiceUnit.edit', compact('unit'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit constant unit'))
        {
            $unit = ProductServiceUnit::find($id);
            if($unit->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $unit->name = $request->name;
                $unit->save();

                return redirect()->route('product-unit.index')->with('success', __('Unit successfully updated.'));
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
        if(\Auth::user()->can('delete constant unit'))
        {
            $unit = ProductServiceUnit::find($id);
            if($unit->created_by == \Auth::user()->creatorId())
            {
                $units = ProductService::where('unit_id', $unit->id)->first();
                if(!empty($units))
                {
                    return redirect()->back()->with('error', __('this unit is already assign so please move or remove this unit related data.'));
                }
                $unit->delete();

                return redirect()->route('product-unit.index')->with('success', __('Unit successfully deleted.'));
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
