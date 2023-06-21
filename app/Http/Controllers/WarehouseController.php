<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use App\Models\warehouse;
use App\Models\WarehouseProduct;
use DB;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $warehouses = warehouse::where('created_by', '=', \Auth::user()->creatorId())->get();

        return view('warehouse.index',compact('warehouses'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('warehouse.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('create warehouse'))
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

            $warehouse             = new warehouse();
            $warehouse->name       = $request->name;
            $warehouse->address    = $request->address;
            $warehouse->city       = $request->city;
            $warehouse->city_zip   = $request->city_zip;
            $warehouse->created_by = \Auth::user()->creatorId();
            $warehouse->save();

            return redirect()->route('warehouse.index')->with('success', __('Warehouse successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(warehouse $warehouse)
    {

        $id = WarehouseProduct::where('warehouse_id' , $warehouse->id)->first();

        if(\Auth::user()->can('show warehouse'))
        {
//            dd($warehouse->id);

            if(WarehouseProduct::where('warehouse_id' , $warehouse->id)->exists())
            {

                $warehouse = WarehouseProduct::where('warehouse_id' , $warehouse->id)->where('created_by', '=', \Auth::user()->creatorId())->get();

//                $data = DB::table('warehouse_products')
//                    ->select(DB::raw("SUM(quantity) as count"),'product_id')
//                    ->groupBy('product_id')
//                    ->get();
//                dd($data);


                return view('warehouse.show', compact('warehouse'));
            }
            else
            {


                $warehouse = [];
                return view('warehouse.show', compact('warehouse'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(warehouse $warehouse)
    {

        if(\Auth::user()->can('edit warehouse'))
        {
            if($warehouse->created_by == \Auth::user()->creatorId())
            {
                return view('warehouse.edit', compact('warehouse'));
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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, warehouse $warehouse)
    {

        if(\Auth::user()->can('edit warehouse'))
        {
            if($warehouse->created_by == \Auth::user()->creatorId())
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

                $warehouse->name       = $request->name;
                $warehouse->address    = $request->address;
                $warehouse->city       = $request->city;
                $warehouse->city_zip   = $request->city_zip;
                $warehouse->save();

                return redirect()->route('warehouse.index')->with('success', __('Warehouse successfully updated.'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(warehouse $warehouse)
    {
        if(\Auth::user()->can('delete warehouse'))
        {
            if($warehouse->created_by == \Auth::user()->creatorId())
            {
                $warehouse->delete();


                return redirect()->route('warehouse.index')->with('success', __('Warehouse successfully deleted.'));
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
