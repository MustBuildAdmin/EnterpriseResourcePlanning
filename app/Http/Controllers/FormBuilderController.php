<?php

namespace App\Http\Controllers;

use App\Models\FormBuilder;
use App\Models\FormField;
use App\Models\FormFieldResponse;
use App\Models\FormResponse;
use App\Models\Lead;
use App\Models\LeadStage;
use App\Models\Pipeline;
use App\Models\User;
use App\Models\UserLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormBuilderController extends Controller
{
    public function index()
    {
        $usr = \Auth::user();
        if($usr->can('manage form builder'))
        {
            $forms = FormBuilder::where('created_by', '=', $usr->creatorId())->get();

            return view('form_builder.index', compact('forms'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        return view('form_builder.create');
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create form builder'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('form_builder.index')->with('error', $messages->first());
            }

            $form_builder             = new FormBuilder();
            $form_builder->name       = $request->name;
            $form_builder->code       = uniqid() . time();
            $form_builder->is_active  = $request->is_active;
            $form_builder->created_by = \Auth::user()->creatorId();
            $form_builder->save();

            return redirect()->route('form_builder.index')->with('success', __('Form successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(FormBuilder $formBuilder)
    {
        if(\Auth::user()->can('manage form field'))
        {
            if($formBuilder->created_by == \Auth::user()->creatorId())
            {
                return view('form_builder.show', compact('formBuilder'));
            }
            else
            {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(FormBuilder $formBuilder)
    {
        if(\Auth::user()->can('edit form builder'))
        {
            if($formBuilder->created_by == Auth::user()->creatorId())
            {
                return view('form_builder.edit', compact('formBuilder'));
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


    public function update(Request $request, FormBuilder $formBuilder)
    {
        $usr = \Auth::user();
        if($usr->can('edit form builder'))
        {
            if($formBuilder->created_by == $usr->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('form_builder.index')->with('error', $messages->first());
                }

                $formBuilder->name           = $request->name;
                $formBuilder->is_active      = $request->is_active;
                $formBuilder->is_lead_active = 0;
                $formBuilder->save();

                return redirect()->route('form_builder.index')->with('success', __('Form successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(FormBuilder $formBuilder)
    {
        if(Auth::user()->can('delete form builder'))
        {
            if($formBuilder->created_by == \Auth::user()->ownerId())
            {
                FormField::where('form_id', '=', $formBuilder->id)->delete();
                FormFieldResponse::where('form_id', '=', $formBuilder->id)->delete();
                FormResponse::where('form_id', '=', $formBuilder->id)->delete();

                $formBuilder->delete();

                return redirect()->route('form_builder.index')->with('success', __('Form successfully deleted!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // Field curd
    public function fieldCreate($id)
    {
        $usr = \Auth::user();
        if($usr->can('create form field'))
        {
            $formbuilder = FormBuilder::find($id);
            if($formbuilder->created_by == $usr->creatorId())
            {
                $types = FormBuilder::$fieldTypes;

                return view('form_builder.field_create', compact('types', 'formbuilder'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fieldStore($id, Request $request)
    {
        $usr = \Auth::user();
        if($usr->can('create form field'))
        {
            $formbuilder = FormBuilder::find($id);
            if($formbuilder->created_by == $usr->creatorId())
            {
                $names = $request->name;
                $types = $request->type;

                foreach($names as $key => $value)
                {
                    if(!empty($value))
                    {
                        // create form field
                        FormField::create(
                            [
                                'form_id' => $formbuilder->id,
                                'name' => $value,
                                'type' => $types[$key],
                                'created_by' => $usr->creatorId(),
                            ]
                        );
                    }
                }

                return redirect()->back()->with('success', __('Field successfully created.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fieldEdit($id, $field_id)
    {
        $usr = \Auth::user();
        if($usr->can('edit form field'))
        {
            $form = FormBuilder::find($id);
            if($form->created_by == $usr->creatorId())
            {
                $form_field = FormField::find($field_id);

                if(!empty($form_field))
                {
                    $types = FormBuilder::$fieldTypes;

                    return view('form_builder.field_edit', compact('form_field', 'types', 'form'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Field not found.'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fieldUpdate($id, $field_id, Request $request)
    {
        $usr = \Auth::user();
        if($usr->can('edit form field'))
        {
            $form = FormBuilder::find($id);
            if($form->created_by == $usr->creatorId())
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

                $field = FormField::find($field_id);
                $field->update(
                    [
                        'name' => $request->name,
                        'type' => $request->type,
                    ]
                );

                return redirect()->back()->with('success', __('Form successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function fieldDestroy($id, $field_id)
    {
        $usr = \Auth::user();
        if($usr->can('delete form field'))
        {
            $form = FormBuilder::find($id);
            if($form->created_by == $usr->creatorId())
            {
                $form_field_response = FormFieldResponse::orWhere('subject_id', '=', $field_id)->orWhere('name_id', '=', $field_id)->orWhere('email_id', '=', $field_id)->first();

                if(!empty($form_field_response))
                {
                    return redirect()->back()->with('error', __('Please remove this field from Convert Lead.'));
                }
                else
                {
                    $form_field = FormField::find($field_id);
                    if(!empty($form_field))
                    {
                        $form_field->delete();
                    }
                    else
                    {
                        return redirect()->back()->with('error', __('Field not found.'));
                    }


                    return redirect()->back()->with('success', __('Form successfully deleted.'));
                }
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // For Response
    public function viewResponse($form_id)
    {
        if(Auth::user()->can('view form response'))
        {
            $form = FormBuilder::find($form_id);
            if($form->created_by == \Auth::user()->creatorId())
            {
                return view('form_builder.response', compact('form'));
            }
            else
            {
                return response()->json(['error' => __('Permission Denied . ')], 401);
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // For Response Detail
    public function responseDetail($response_id)
    {
        if(Auth::user()->can('view form response'))
        {
            $formResponse = FormResponse::find($response_id);
            $form         = FormBuilder::find($formResponse->form_id);
            if($form->created_by == \Auth::user()->creatorId())
            {
                $response = json_decode($formResponse->response, true);

                return view('form_builder.response_detail', compact('response'));
            }
            else
            {
                return response()->json(['error' => __('Permission Denied . ')], 401);
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // For Front Side View
    public function formView($code)
    {

        if(!empty($code))
        {
            $form = FormBuilder::where('code', 'LIKE', $code)->first();

            if(!empty($form))
            {
                if($form->is_active == 1)
                {
                    $objFields = $form->form_field;

                    return view('form_builder.form_view', compact('objFields', 'code', 'form'));
                }
                else
                {
                    return view('form_builder.form_view', compact('code', 'form'));
                }
            }
            else
            {
                return redirect()->route('login')->with('error', __('Form not found please contact to admin.'));
            }
        }
        else
        {
            return redirect()->route('login')->with('error', __('Permission Denied.'));
        }
    }

    // For Front Side View Store
    public function formViewStore(Request $request)
    {
        // Get form
        $form = FormBuilder::where('code', 'LIKE', $request->code)->first();

        if(!empty($form))
        {
            $arrFieldResp = [];
            foreach($request->field as $key => $value)
            {
                $arrFieldResp[FormField::find($key)->name] = (!empty($value)) ? $value : '-';
            }

            // store response
            FormResponse::create(
                [
                    'form_id' => $form->id,
                    'response' => json_encode($arrFieldResp),
                ]
            );

            // in form convert lead is active then creat lead
            if($form->is_lead_active == 1)
            {
                $objField = $form->fieldResponse;

                // validation
                $email = User::where('email', 'LIKE', $request->field[$objField->email_id])->first();

                if(!empty($email))
                {
                    return redirect()->back()->with('error', __('Email already exist in our record.!'));
                }

                $usr   = User::find($form->created_by);
                $stage = LeadStage::where('pipeline_id', '=', $objField->pipeline_id)->where('created_by',$form->created_by)->first();

                if(!empty($stage))
                {
                    $lead              = new Lead();
                    $lead->name        = $request->field[$objField->name_id];
                    $lead->email       = $request->field[$objField->email_id];
                    $lead->subject     = $request->field[$objField->subject_id];
                    $lead->user_id     = $objField->user_id;
                    $lead->pipeline_id = $objField->pipeline_id;
                    $lead->stage_id    = $stage->id;
                    $lead->created_by  = $usr->creatorId();
                    $lead->date        = date('Y-m-d');
                    $lead->save();

                    $usrLeads = [
                        $usr->id,
                        $objField->user_id,
                    ];

                    foreach($usrLeads as $usrLead)
                    {
                        UserLead::create(
                            [
                                'user_id' => $usrLead,
                                'lead_id' => $lead->id,
                            ]
                        );
                    }
                }
            }

            return redirect()->back()->with('success', __('Data submit successfully.'));
        }
        else
        {
            return redirect()->route('login')->with('error', __('Something went wrong.'));
        }

    }

    // Convert into lead Modal
    public function formFieldBind($form_id)
    {
        $usr = \Auth::user();
        if($usr->type == 'company')
        {
            $form = FormBuilder::find($form_id);

            if($form->created_by == $usr->creatorId())
            {
                $types = $form->form_field->pluck('name', 'id');

                $formField = FormFieldResponse::where('form_id', '=', $form_id)->first();

                // Get Users
                $users = User::where('created_by', '=', $usr->creatorId())->where('type', '!=', 'client')->get()->pluck('name', 'id');

                // Pipelines
                $pipelines = Pipeline::where('created_by', '=', $usr->creatorId())->get()->pluck('name', 'id');

                return view('form_builder.form_field', compact('form', 'types', 'formField', 'users', 'pipelines'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // Store convert into lead modal
    public function bindStore(Request $request, $id)
    {

        $usr = Auth::user();
        if($usr->type == 'company')
        {
            $form                 = FormBuilder::find($id);
            $form->is_lead_active = $request->is_lead_active;
            $form->save();

            if($form->created_by == $usr->creatorId())
            {
                if($form->is_lead_active == 1)
                {
                    $validator = \Validator::make(
                        $request->all(), [
                                           'subject_id' => 'required',
                                           'name_id' => 'required',
                                           'email_id' => 'required',
                                           'user_id' => 'required',
                                           'pipeline_id' => 'required',
                                       ]
                    );

                    if($validator->fails())
                    {
                        $messages = $validator->getMessageBag();

                        // if validation failed then make status 0
                        $form->is_lead_active = 0;
                        $form->save();

                        return redirect()->back()->with('error', $messages->first());
                    }

                    if(!empty($request->form_response_id))
                    {
                        // if record already exists then update it.
                        $field_bind = FormFieldResponse::find($request->form_response_id);
                        $field_bind->update(
                            [
                                'subject_id' => $request->subject_id,
                                'name_id' => $request->name_id,
                                'email_id' => $request->email_id,
                                'user_id' => $request->user_id,
                                'pipeline_id' => $request->pipeline_id,
                            ]
                        );
                    }
                    else
                    {
                        // Create Field Binding record on form_field_responses tbl
                        FormFieldResponse::create(
                            [
                                'form_id' => $request->form_id,
                                'subject_id' => $request->subject_id,
                                'name_id' => $request->name_id,
                                'email_id' => $request->email_id,
                                'user_id' => $request->user_id,
                                'pipeline_id' => $request->pipeline_id,
                            ]
                        );
                    }
                }

                return redirect()->back()->with('success', __('Setting saved successfully!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
