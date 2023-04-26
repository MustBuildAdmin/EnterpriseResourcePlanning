<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        if(\Auth::user()->can('manage constant custom field'))
        {
            $custom_fields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('customFields.index', compact('custom_fields'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create constant custom field'))
        {
            $types   = CustomField::$fieldTypes;
            $modules = CustomField::$modules;

            return view('customFields.create', compact('types', 'modules'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create constant custom field'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:40',
                                   'type' => 'required',
                                   'module' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('custom-field.index')->with('error', $messages->first());
            }

            $custom_field             = new CustomField();
            $custom_field->name       = $request->name;
            $custom_field->type       = $request->type;
            $custom_field->module     = $request->module;
            $custom_field->created_by = \Auth::user()->creatorId();
            $custom_field->save();

            return redirect()->route('custom-field.index')->with('success', __('Custom Field successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function show(CustomField $customField)
    {
        return redirect()->route('custom-field.index');
    }

    public function edit(CustomField $customField)
    {
        if(\Auth::user()->can('edit constant custom field'))
        {
            if($customField->created_by == \Auth::user()->creatorId())
            {
                $types   = CustomField::$fieldTypes;
                $modules = CustomField::$modules;

                return view('customFields.edit', compact('customField', 'types', 'modules'));
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


    public function update(Request $request, CustomField $customField)
    {
        if(\Auth::user()->can('edit constant custom field'))
        {

            if($customField->created_by == \Auth::user()->creatorId())
            {

                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:40',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('custom-field.index')->with('error', $messages->first());
                }

                $customField->name = $request->name;
                $customField->save();

                return redirect()->route('custom-field.index')->with('success', __('Custom Field successfully updated!'));
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


    public function destroy(CustomField $customField)
    {
        if(\Auth::user()->can('delete constant custom field'))
        {
            if($customField->created_by == \Auth::user()->creatorId())
            {
                $customField->delete();

                return redirect()->route('custom-field.index')->with('success', __('Custom Field successfully deleted!'));
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
