<?php

namespace App\Http\Controllers;

use App\Models\Company_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanytypeController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 'super admin') {
            $companytype = Company_type::where('status', 1)->get();

            return view('company_type.index', compact('companytype'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->type == 'super admin') {
            return view('company_type.create');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->type == 'super admin') {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $find = Company_type::where(['name' => $request->name, 'status' => '1'])->first();
            if ($find) {
                $messages = __('Business Name Already Exit');

                return redirect()->back()->with('error', $messages);
            }
            $companytype = new Company_type();
            $companytype['name'] = $request->name;
            $companytype->save();

            return redirect()->route('company_type.index');

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }

    public function edit($id)
    {

        if (Auth::user()->type == 'super admin') {
            $companytype = Company_type::where('id', $id)->first();

            return view('company_type.edit', compact('companytype'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->type == 'super admin') {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $find = Company_type::where('name', $request->name)->where('id', '!=', $id)->first();
            if ($find) {
                $messages = __('Business Name Already Exit');

                return redirect()->back()->with('error', $messages);
            }
            $companytype = Company_type::findOrFail($id);
            $companytype['name'] = $request->name;
            $companytype->save();

            return redirect()->route('company_type.index')->with(
                'success', 'Bussiness Type updated.'
            );

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->type == 'super admin') {
            $companytype = Company_type::findOrFail($id);
            $companytype['status'] = '0';
            $companytype->save();

            return redirect()->route('company_type.index');

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function setting(Request $request)
    {
        return view('construction.index');
    }
}
