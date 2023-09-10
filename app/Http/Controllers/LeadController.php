<?php

namespace App\Http\Controllers;

use App\Mail\SendLeadEmail;
use App\Models\ClientDeal;
use App\Models\Deal;
use App\Models\DealCall;
use App\Models\DealDiscussion;
use App\Models\DealEmail;
use App\Models\DealFile;
use App\Models\Label;
use App\Models\Lead;
use App\Models\LeadActivityLog;
use App\Models\LeadCall;
use App\Models\LeadDiscussion;
use App\Models\LeadEmail;
use App\Models\LeadFile;
use App\Models\LeadStage;
use App\Models\Pipeline;
use App\Models\ProductService;
use App\Models\Source;
use App\Models\Stage;
use App\Models\User;
use App\Models\UserDeal;
use App\Models\UserLead;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage lead')) {
            if (\Auth::user()->default_pipeline) {
                $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->where('id', '=', \Auth::user()->default_pipeline)->first();
                if (! $pipeline) {
                    $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->first();
                }
            } else {
                $pipeline = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->first();
            }

            $pipelines = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('crm.leads.leads', compact('pipelines', 'pipeline'));
            // return view('leads.index', compact('pipelines', 'pipeline'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function lead_list()
    {
        $usr = \Auth::user();

        if ($usr->can('manage lead')) {
            if ($usr->default_pipeline) {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->where('id', '=', $usr->default_pipeline)->first();
                if (! $pipeline) {
                    $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
                }
            } else {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
            }

            $pipelines = Pipeline::where('created_by', '=', $usr->creatorId())->get()->pluck('name', 'id');
            $leads = Lead::select('leads.*')->join('user_leads', 'user_leads.lead_id', '=', 'leads.id')->where('user_leads.user_id', '=', $usr->id)->where('leads.pipeline_id', '=', $pipeline->id)->orderBy('leads.order')->get();

            return view('crm.leads.leads_list', compact('pipelines', 'pipeline', 'leads'));
            // return view('leads.list', compact('pipelines', 'pipeline', 'leads'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (\Auth::user()->can('create lead')) {
            $users = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->where('type', '!=', 'company')->where('id', '!=', \Auth::user()->id)->get()->pluck('name', 'id');
            $users->prepend(__('Select User'), '');

            return view('leads.create', compact('users'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $usr = \Auth::user();
        if ($usr->can('create lead')) {
            $validator = \Validator::make(
                $request->all(), [
                    'subject' => 'required',
                    'name' => 'required',
                    'email' => 'required|unique:leads,email',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            // Default Field Value
            if ($usr->default_pipeline) {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->where('id', '=', $usr->default_pipeline)->first();
                if (! $pipeline) {
                    $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
                }
            } else {
                $pipeline = Pipeline::where('created_by', '=', $usr->creatorId())->first();
            }

            $stage = LeadStage::where('pipeline_id', '=', $pipeline->id)->first();
            // End Default Field Value

            if (empty($stage)) {
                return redirect()->back()->with('error', __('Please Create Stage for This Pipeline.'));
            } else {
                $lead = new Lead();
                $lead->name = $request->name;
                $lead->email = $request->email;
                $lead->phone = $request->phone;
                $lead->subject = $request->subject;
                $lead->user_id = $request->user_id;
                $lead->pipeline_id = $pipeline->id;
                $lead->stage_id = $stage->id;
                $lead->created_by = $usr->creatorId();
                $lead->date = date('Y-m-d');
                $lead->save();

                if ($request->user_id != \Auth::user()->id) {
                    $usrLeads = [
                        $usr->id,
                        $request->user_id,
                    ];
                } else {
                    $usrLeads = [
                        $request->user_id,
                    ];
                }

                foreach ($usrLeads as $usrLead) {
                    UserLead::create(
                        [
                            'user_id' => $usrLead,
                            'lead_id' => $lead->id,
                        ]
                    );
                }

                $leadArr = [
                    'lead_id' => $lead->id,
                    'name' => $lead->name,
                    'updated_by' => $usr->id,
                ];
                $lArr = [
                    'lead_name' => $lead->name,
                    'lead_email' => $lead->email,
                    'lead_pipeline' => $pipeline->name,
                    'lead_stage' => $stage->name,
                ];

                $usrEmail = User::find($request->user_id);

                $lArr = [
                    'lead_name' => $lead->name,
                    'lead_email' => $lead->email,
                    'lead_pipeline' => $pipeline->name,
                    'lead_stage' => $stage->name,
                ];

                // Send Email
                $setings = Utility::settings();
                if ($setings['lead_assign'] == 1) {

                    $usrEmail = User::find($request->user_id);
                    $leadAssignArr = [
                        'lead_name' => $lead->name,
                        'lead_email' => $lead->email,
                        'lead_subject' => $lead->subject,
                        'lead_pipeline' => $pipeline->name,
                        'lead_stage' => $stage->name,

                    ];

                    $resp = Utility::sendEmailTemplate('lead_assign', [$usrEmail->id => $usrEmail->email], $leadAssignArr);

                    return redirect()->back()->with('success', __('Lead successfully created!').(($resp['is_success'] == false && ! empty($resp['error'])) ? '<br> <span class="text-danger">'.$resp['error'].'</span>' : ''));

                }

                //Slack Notification
                $setting = Utility::settings(\Auth::user()->creatorId());
                if (isset($setting['lead_notification']) && $setting['lead_notification'] == 1) {
                    $msg = __('New Lead created by').' '.\Auth::user()->name.'.';
                    Utility::send_slack_msg($msg);
                }

                //Telegram Notification
                $setting = Utility::settings(\Auth::user()->creatorId());
                if (isset($setting['telegram_lead_notification']) && $setting['telegram_lead_notification'] == 1) {
                    $msg = __('New Lead created by').' '.\Auth::user()->name.'.';
                    Utility::send_telegram_msg($msg);
                }

                return redirect()->back()->with('success', __('Lead successfully created!'));

            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        if ($lead->is_active) {
            $calenderTasks = [];
            $deal = Deal::where('id', '=', $lead->is_converted)->first();
            $stageCnt = LeadStage::where('pipeline_id', '=', $lead->pipeline_id)->where('created_by', '=', $lead->created_by)->get();
            $i = 0;
            foreach ($stageCnt as $stage) {
                $i++;
                if ($stage->id == $lead->stage_id) {
                    break;
                }
            }
            $precentage = number_format(($i * 100) / count($stageCnt));

            return view('crm.leads.leads_show', compact('lead', 'calenderTasks', 'deal', 'precentage'));
            // return view('leads.show', compact('lead', 'calenderTasks', 'deal', 'precentage'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
    {
        if (\Auth::user()->can('edit lead')) {
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $pipelines = Pipeline::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $pipelines->prepend(__('Select Pipeline'), '');
                $sources = Source::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $products = ProductService::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $users = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->where('type', '!=', 'company')->where('id', '!=', \Auth::user()->id)->get()->pluck('name', 'id');
                $lead->sources = explode(',', $lead->sources);
                $lead->products = explode(',', $lead->products);

                return view('leads.edit', compact('lead', 'pipelines', 'sources', 'products', 'users'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lead $lead)
    {
        if (\Auth::user()->can('edit lead')) {
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(), [
                        'subject' => 'required',
                        'name' => 'required',
                        'email' => 'required|unique:leads,email,'.$lead->id,
                        'pipeline_id' => 'required',
                        'user_id' => 'required',
                        'stage_id' => 'required',
                        'sources' => 'required',
                        'products' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $lead->name = $request->name;
                $lead->email = $request->email;
                $lead->phone = $request->phone;
                $lead->subject = $request->subject;
                $lead->user_id = $request->user_id;
                $lead->pipeline_id = $request->pipeline_id;
                $lead->stage_id = $request->stage_id;
                $lead->sources = implode(',', array_filter($request->sources));
                $lead->products = implode(',', array_filter($request->products));
                $lead->notes = $request->notes;
                $lead->save();

                return redirect()->back()->with('success', __('Lead successfully updated!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        if (\Auth::user()->can('delete lead')) {
            if ($lead->created_by == \Auth::user()->creatorId()) {
                LeadDiscussion::where('lead_id', '=', $lead->id)->delete();
                LeadFile::where('lead_id', '=', $lead->id)->delete();
                UserLead::where('lead_id', '=', $lead->id)->delete();
                LeadActivityLog::where('lead_id', '=', $lead->id)->delete();
                $lead->delete();

                return redirect()->back()->with('success', __('Lead successfully deleted!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function json(Request $request)
    {
        $lead_stages = new LeadStage();
        if ($request->pipeline_id && ! empty($request->pipeline_id)) {

            $lead_stages = $lead_stages->where('pipeline_id', '=', $request->pipeline_id);
            $lead_stages = $lead_stages->get()->pluck('name', 'id');
        } else {
            $lead_stages = [];
        }

        return response()->json($lead_stages);
    }

    public function fileUpload($id, Request $request)
    {

        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                //                $request->validate(['file' => 'required|mimes:png,jpeg,jpg,pdf,doc,txt,application/octet-stream,audio/mpeg,mpga,mp3,wav|max:20480000']);
                $file_name = $request->file->getClientOriginalName();
                $file_path = $request->lead_id.'_'.md5(time()).'_'.$request->file->getClientOriginalName();
                $request->file->storeAs('lead_files', $file_path);
                $file = LeadFile::create(
                    [
                        'lead_id' => $request->lead_id,
                        'file_name' => $file_name,
                        'file_path' => $file_path,
                    ]
                );
                $return = [];
                $return['is_success'] = true;
                $return['download'] = route(
                    'leads.file.download', [
                        $lead->id,
                        $file->id,
                    ]
                );
                $return['delete'] = route(
                    'leads.file.delete', [
                        $lead->id,
                        $file->id,
                    ]
                );
                LeadActivityLog::create(
                    [
                        'user_id' => \Auth::user()->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Upload File',
                        'remark' => json_encode(['file_name' => $file_name]),
                    ]
                );

                return response()->json($return);
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ], 401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ], 401
            );
        }
    }

    public function fileDownload($id, $file_id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $file = LeadFile::find($file_id);
                if ($file) {
                    $file_path = storage_path('lead_files/'.$file->file_path);
                    $filename = $file->file_name;

                    return \Response::download(
                        $file_path, $filename, [
                            'Content-Length: '.filesize($file_path),
                        ]
                    );
                } else {
                    return redirect()->back()->with('error', __('File is not exist.'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function fileDelete($id, $file_id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $file = LeadFile::find($file_id);
                if ($file) {
                    $path = storage_path('lead_files/'.$file->file_path);
                    if (file_exists($path)) {
                        \File::delete($path);
                    }
                    $file->delete();

                    return response()->json(['is_success' => true], 200);
                } else {
                    return response()->json(
                        [
                            'is_success' => false,
                            'error' => __('File is not exist.'),
                        ], 200
                    );
                }
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ], 401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ], 401
            );
        }
    }

    public function noteStore($id, Request $request)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $lead->notes = $request->notes;
                $lead->save();

                return response()->json(
                    [
                        'is_success' => true,
                        'success' => __('Note successfully saved!'),
                    ], 200
                );
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ], 401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ], 401
            );
        }
    }

    public function labels($id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $labels = Label::where('pipeline_id', '=', $lead->pipeline_id)->where('created_by', \Auth::user()->creatorId())->get();
                $selected = $lead->labels();
                if ($selected) {
                    $selected = $selected->pluck('name', 'id')->toArray();
                } else {
                    $selected = [];
                }

                return view('leads.labels', compact('lead', 'labels', 'selected'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function labelStore($id, Request $request)
    {
        if (\Auth::user()->can('edit lead')) {
            $leads = Lead::find($id);
            if ($leads->created_by == \Auth::user()->creatorId()) {
                if ($request->labels) {
                    $leads->labels = implode(',', $request->labels);
                } else {
                    $leads->labels = $request->labels;
                }
                $leads->save();

                return redirect()->back()->with('success', __('Labels successfully updated!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function userEdit($id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);

            if ($lead->created_by == \Auth::user()->creatorId()) {
                $users = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'client')->where('type', '!=', 'company')->whereNOTIn(
                    'id', function ($q) use ($lead) {
                        $q->select('user_id')->from('user_leads')->where('lead_id', '=', $lead->id);
                    }
                )->get();

                $users = $users->pluck('name', 'id');

                return view('leads.users', compact('lead', 'users'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function userUpdate($id, Request $request)
    {
        if (\Auth::user()->can('edit lead')) {
            $usr = \Auth::user();
            $lead = Lead::find($id);

            if ($lead->created_by == $usr->creatorId()) {
                if (! empty($request->users)) {
                    $users = array_filter($request->users);
                    $leadArr = [
                        'lead_id' => $lead->id,
                        'name' => $lead->name,
                        'updated_by' => $usr->id,
                    ];

                    foreach ($users as $user) {
                        UserLead::create(
                            [
                                'lead_id' => $lead->id,
                                'user_id' => $user,
                            ]
                        );
                    }
                }

                if (! empty($users) && ! empty($request->users)) {
                    return redirect()->back()->with('success', __('Users successfully updated!'));
                } else {
                    return redirect()->back()->with('error', __('Please Select Valid User!'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function userDestroy($id, $user_id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                UserLead::where('lead_id', '=', $lead->id)->where('user_id', '=', $user_id)->delete();

                return redirect()->back()->with('success', __('User successfully deleted!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function productEdit($id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $products = ProductService::where('created_by', '=', \Auth::user()->creatorId())->whereNOTIn('id', explode(',', $lead->products))->get()->pluck('name', 'id');

                return view('leads.products', compact('lead', 'products'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function productUpdate($id, Request $request)
    {
        if (\Auth::user()->can('edit lead')) {
            $usr = \Auth::user();
            $lead = Lead::find($id);
            $lead_users = $lead->users->pluck('id')->toArray();

            if ($lead->created_by == \Auth::user()->creatorId()) {
                if (! empty($request->products)) {
                    $products = array_filter($request->products);
                    $old_products = explode(',', $lead->products);
                    $lead->products = implode(',', array_merge($old_products, $products));
                    $lead->save();

                    $objProduct = ProductService::whereIN('id', $products)->get()->pluck('name', 'id')->toArray();

                    LeadActivityLog::create(
                        [
                            'user_id' => $usr->id,
                            'lead_id' => $lead->id,
                            'log_type' => 'Add Product',
                            'remark' => json_encode(['title' => implode(',', $objProduct)]),
                        ]
                    );

                    $productArr = [
                        'lead_id' => $lead->id,
                        'name' => $lead->name,
                        'updated_by' => $usr->id,
                    ];

                }

                if (! empty($products) && ! empty($request->products)) {
                    return redirect()->back()->with('success', __('Products successfully updated!'))->with('status', 'products');
                } else {
                    return redirect()->back()->with('error', __('Please Select Valid Product!'))->with('status', 'general');
                }
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'products');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'products');
        }
    }

    public function productDestroy($id, $product_id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $products = explode(',', $lead->products);
                foreach ($products as $key => $product) {
                    if ($product_id == $product) {
                        unset($products[$key]);
                    }
                }
                $lead->products = implode(',', $products);
                $lead->save();

                return redirect()->back()->with('success', __('Products successfully deleted!'))->with('status', 'products');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'products');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'products');
        }
    }

    public function sourceEdit($id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $sources = Source::where('created_by', '=', \Auth::user()->creatorId())->get();

                $selected = $lead->sources();
                if ($selected) {
                    $selected = $selected->pluck('name', 'id')->toArray();
                }

                return view('leads.sources', compact('lead', 'sources', 'selected'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function sourceUpdate($id, Request $request)
    {
        if (\Auth::user()->can('edit lead')) {
            $usr = \Auth::user();
            $lead = Lead::find($id);
            $lead_users = $lead->users->pluck('id')->toArray();

            if ($lead->created_by == \Auth::user()->creatorId()) {
                if (! empty($request->sources) && count($request->sources) > 0) {
                    $lead->sources = implode(',', $request->sources);
                } else {
                    $lead->sources = '';
                }

                $lead->save();

                LeadActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Update Sources',
                        'remark' => json_encode(['title' => 'Update Sources']),
                    ]
                );

                $leadArr = [
                    'lead_id' => $lead->id,
                    'name' => $lead->name,
                    'updated_by' => $usr->id,
                ];

                return redirect()->back()->with('success', __('Sources successfully updated!'))->with('status', 'sources');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'sources');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'sources');
        }
    }

    public function sourceDestroy($id, $source_id)
    {
        if (\Auth::user()->can('edit lead')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $sources = explode(',', $lead->sources);
                foreach ($sources as $key => $source) {
                    if ($source_id == $source) {
                        unset($sources[$key]);
                    }
                }
                $lead->sources = implode(',', $sources);
                $lead->save();

                return redirect()->back()->with('success', __('Sources successfully deleted!'))->with('status', 'sources');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'sources');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'sources');
        }
    }

    public function discussionCreate($id)
    {
        $lead = Lead::find($id);
        if ($lead->created_by == \Auth::user()->creatorId()) {
            return view('leads.discussions', compact('lead'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function discussionStore($id, Request $request)
    {
        $usr = \Auth::user();
        $lead = Lead::find($id);
        $lead_users = $lead->users->pluck('id')->toArray();

        if ($lead->created_by == $usr->creatorId()) {
            $discussion = new LeadDiscussion();
            $discussion->comment = $request->comment;
            $discussion->lead_id = $lead->id;
            $discussion->created_by = $usr->id;
            $discussion->save();

            $leadArr = [
                'lead_id' => $lead->id,
                'name' => $lead->name,
                'updated_by' => $usr->id,
            ];

            return redirect()->back()->with('success', __('Message successfully added!'))->with('status', 'discussion');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'discussion');
        }
    }

    public function order(Request $request)
    {
        if (\Auth::user()->can('move lead')) {
            $usr = \Auth::user();
            $post = $request->all();
            $lead = Lead::find($post['lead_id']);
            $lead_users = $lead->users->pluck('email', 'id')->toArray();

            if ($lead->stage_id != $post['stage_id']) {
                $newStage = LeadStage::find($post['stage_id']);

                LeadActivityLog::create(
                    [
                        'user_id' => \Auth::user()->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'Move',
                        'remark' => json_encode(
                            [
                                'title' => $lead->name,
                                'old_status' => $lead->stage->name,
                                'new_status' => $newStage->name,
                            ]
                        ),
                    ]
                );

                $leadArr = [
                    'lead_id' => $lead->id,
                    'name' => $lead->name,
                    'updated_by' => $usr->id,
                    'old_status' => $lead->stage->name,
                    'new_status' => $newStage->name,
                ];

                $lArr = [
                    'lead_name' => $lead->name,
                    'lead_email' => $lead->email,
                    'lead_pipeline' => $lead->pipeline->name,
                    'lead_stage' => $lead->stage->name,
                    'lead_old_stage' => $lead->stage->name,
                    'lead_new_stage' => $newStage->name,
                ];

                // Send Email
                Utility::sendEmailTemplate('Move Lead', $lead_users, $lArr);
            }

            foreach ($post['order'] as $key => $item) {
                $lead = Lead::find($item);
                $lead->order = $key;
                $lead->stage_id = $post['stage_id'];
                $lead->save();
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function showConvertToDeal($id)
    {

        $lead = Lead::findOrFail($id);
        $exist_client = User::where('type', '=', 'client')->where('email', '=', $lead->email)->where('created_by', '=', \Auth::user()->creatorId())->first();
        $clients = User::where('type', '=', 'client')->where('created_by', '=', \Auth::user()->creatorId())->get();

        return view('leads.convert', compact('lead', 'exist_client', 'clients'));
    }

    public function convertToDeal($id, Request $request)
    {

        $lead = Lead::findOrFail($id);
        $usr = \Auth::user();

        if ($request->client_check == 'exist') {
            $validator = \Validator::make(
                $request->all(), [
                    'clients' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $client = User::where('type', '=', 'client')->where('email', '=', $request->clients)->where('created_by', '=', $usr->creatorId())->first();

            if (empty($client)) {
                return redirect()->back()->with('error', 'Client is not available now.');
            }
        } else {
            $validator = \Validator::make(
                $request->all(), [
                    'client_name' => 'required',
                    'client_email' => 'required|email|unique:users,email',
                    'client_password' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $role = Role::findByName('client');
            $client = User::create(
                [
                    'name' => $request->client_name,
                    'email' => $request->client_email,
                    'password' => \Hash::make($request->client_password),
                    'type' => 'client',
                    'lang' => 'en',
                    'created_by' => $usr->creatorId(),
                ]
            );
            $client->assignRole($role);

            $cArr = [
                'email' => $request->client_email,
                'password' => $request->client_password,
            ];

            // Send Email to client if they are new created.
            Utility::sendEmailTemplate('New User', [$client->id => $client->email], $cArr);
        }

        // Create Deal
        $stage = Stage::where('pipeline_id', '=', $lead->pipeline_id)->first();
        if (empty($stage)) {
            return redirect()->back()->with('error', __('Please Create Stage for This Pipeline.'));
        }

        $deal = new Deal();
        $deal->name = $request->name;
        $deal->price = empty($request->price) ? 0 : $request->price;
        $deal->pipeline_id = $lead->pipeline_id;
        $deal->stage_id = $stage->id;
        $deal->sources = in_array('sources', $request->is_transfer) ? $lead->sources : '';
        $deal->products = in_array('products', $request->is_transfer) ? $lead->products : '';
        $deal->notes = in_array('notes', $request->is_transfer) ? $lead->notes : '';
        $deal->labels = $lead->labels;
        $deal->status = 'Active';
        $deal->created_by = $lead->created_by;
        $deal->save();
        // end create deal

        // Make entry in ClientDeal Table
        ClientDeal::create(
            [
                'deal_id' => $deal->id,
                'client_id' => $client->id,
            ]
        );
        // end

        $dealArr = [
            'deal_id' => $deal->id,
            'name' => $deal->name,
            'updated_by' => $usr->id,
        ];
        // Send Notification

        // Send Mail
        $pipeline = Pipeline::find($lead->pipeline_id);
        $dArr = [
            'deal_name' => $deal->name,
            'deal_pipeline' => $pipeline->name,
            'deal_stage' => $stage->name,
            'deal_status' => $deal->status,
            'deal_price' => $usr->priceFormat($deal->price),
        ];
        Utility::sendEmailTemplate('Assign Deal', [$client->id => $client->email], $dArr);

        // Make Entry in UserDeal Table
        $leadUsers = UserLead::where('lead_id', '=', $lead->id)->get();
        foreach ($leadUsers as $leadUser) {
            UserDeal::create(
                [
                    'user_id' => $leadUser->user_id,
                    'deal_id' => $deal->id,
                ]
            );
        }
        // end

        //Transfer Lead Discussion to Deal
        if (in_array('discussion', $request->is_transfer)) {
            $discussions = LeadDiscussion::where('lead_id', '=', $lead->id)->where('created_by', '=', $usr->creatorId())->get();
            if (! empty($discussions)) {
                foreach ($discussions as $discussion) {
                    DealDiscussion::create(
                        [
                            'deal_id' => $deal->id,
                            'comment' => $discussion->comment,
                            'created_by' => $discussion->created_by,
                        ]
                    );
                }
            }
        }
        // end Transfer Discussion

        // Transfer Lead Files to Deal
        if (in_array('files', $request->is_transfer)) {
            $files = LeadFile::where('lead_id', '=', $lead->id)->get();
            if (! empty($files)) {
                foreach ($files as $file) {
                    $location = base_path().'/storage/lead_files/'.$file->file_path;
                    $new_location = base_path().'/storage/deal_files/'.$file->file_path;
                    $copied = copy($location, $new_location);

                    if ($copied) {
                        DealFile::create(
                            [
                                'deal_id' => $deal->id,
                                'file_name' => $file->file_name,
                                'file_path' => $file->file_path,
                            ]
                        );
                    }
                }
            }
        }
        // end Transfer Files

        // Transfer Lead Calls to Deal
        if (in_array('calls', $request->is_transfer)) {
            $calls = LeadCall::where('lead_id', '=', $lead->id)->get();
            if (! empty($calls)) {
                foreach ($calls as $call) {
                    DealCall::create(
                        [
                            'deal_id' => $deal->id,
                            'subject' => $call->subject,
                            'call_type' => $call->call_type,
                            'duration' => $call->duration,
                            'user_id' => $call->user_id,
                            'description' => $call->description,
                            'call_result' => $call->call_result,
                        ]
                    );
                }
            }
        }
        //end

        // Transfer Lead Emails to Deal
        if (in_array('emails', $request->is_transfer)) {
            $emails = LeadEmail::where('lead_id', '=', $lead->id)->get();
            if (! empty($emails)) {
                foreach ($emails as $email) {
                    DealEmail::create(
                        [
                            'deal_id' => $deal->id,
                            'to' => $email->to,
                            'subject' => $email->subject,
                            'description' => $email->description,
                        ]
                    );
                }
            }
        }

        // Update is_converted field as deal_id
        $lead->is_converted = $deal->id;
        $lead->save();

        //Slack Notification
        $setting = Utility::settings(\Auth::user()->creatorId());
        $leadUsers = Lead::where('id', '=', $lead->id)->first();
        if (isset($setting['leadtodeal_notification']) && $setting['leadtodeal_notification'] == 1) {
            $msg = __('Deal converted through lead').''.$leadUsers->name.'.';
            Utility::send_slack_msg($msg);
        }

        //Telegram Notification
        $setting = Utility::settings(\Auth::user()->creatorId());
        $leadUsers = Lead::where('id', '=', $lead->id)->first();
        if (isset($setting['telegram_leadtodeal_notification']) && $setting['telegram_leadtodeal_notification'] == 1) {
            $msg = __('Deal converted through lead').''.$leadUsers->name.'.';
            Utility::send_telegram_msg($msg);
        }

        return redirect()->back()->with('success', __('Lead successfully converted'));
    }

    // Lead Calls
    public function callCreate($id)
    {
        if (\Auth::user()->can('create lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $users = UserLead::where('lead_id', '=', $lead->id)->get();

                return view('leads.calls', compact('lead', 'users'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ], 401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ], 401
            );
        }
    }

    public function callStore($id, Request $request)
    {
        if (\Auth::user()->can('create lead call')) {
            $usr = \Auth::user();
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(), [
                        'subject' => 'required',
                        'call_type' => 'required',
                        'user_id' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $leadCall = LeadCall::create(
                    [
                        'lead_id' => $lead->id,
                        'subject' => $request->subject,
                        'call_type' => $request->call_type,
                        'duration' => $request->duration,
                        'user_id' => $request->user_id,
                        'description' => $request->description,
                        'call_result' => $request->call_result,
                    ]
                );

                LeadActivityLog::create(
                    [
                        'user_id' => $usr->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'create lead call',
                        'remark' => json_encode(['title' => 'Create new Lead Call']),
                    ]
                );

                $leadArr = [
                    'lead_id' => $lead->id,
                    'name' => $lead->name,
                    'updated_by' => $usr->id,
                ];

                return redirect()->back()->with('success', __('Call successfully created!'))->with('status', 'calls');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
        }
    }

    public function callEdit($id, $call_id)
    {
        if (\Auth::user()->can('edit lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $call = LeadCall::find($call_id);
                $users = UserLead::where('lead_id', '=', $lead->id)->get();

                return view('leads.calls', compact('call', 'lead', 'users'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ], 401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ], 401
            );
        }
    }

    public function callUpdate($id, $call_id, Request $request)
    {
        if (\Auth::user()->can('edit lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(), [
                        'subject' => 'required',
                        'call_type' => 'required',
                        'user_id' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $call = LeadCall::find($call_id);

                $call->update(
                    [
                        'subject' => $request->subject,
                        'call_type' => $request->call_type,
                        'duration' => $request->duration,
                        'user_id' => $request->user_id,
                        'description' => $request->description,
                        'call_result' => $request->call_result,
                    ]
                );

                return redirect()->back()->with('success', __('Call successfully updated!'))->with('status', 'calls');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'tasks');
        }
    }

    public function callDestroy($id, $call_id)
    {
        if (\Auth::user()->can('delete lead call')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                $task = LeadCall::find($call_id);
                $task->delete();

                return redirect()->back()->with('success', __('Call successfully deleted!'))->with('status', 'calls');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'calls');
        }
    }

    // Lead email
    public function emailCreate($id)
    {
        if (\Auth::user()->can('create lead email')) {
            $lead = Lead::find($id);
            if ($lead->created_by == \Auth::user()->creatorId()) {
                return view('leads.emails', compact('lead'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('Permission Denied.'),
                    ], 401
                );
            }
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ], 401
            );
        }
    }

    public function emailStore($id, Request $request)
    {

        if (\Auth::user()->can('create lead email')) {
            $lead = Lead::find($id);

            if ($lead->created_by == \Auth::user()->creatorId()) {
                $settings = Utility::settings();
                $validator = \Validator::make(
                    $request->all(), [
                        'to' => 'required|email',
                        'subject' => 'required',
                        'description' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $leadEmail = LeadEmail::create(
                    [
                        'lead_id' => $lead->id,
                        'to' => $request->to,
                        'subject' => $request->subject,
                        'description' => $request->description,
                    ]
                );

                $leadEmail =
                    [
                        'lead_name' => $lead->name,
                        'to' => $request->to,
                        'subject' => $request->subject,
                        'description' => $request->description,
                    ];

                try {
                    Mail::to($request->to)->send(new SendLeadEmail($leadEmail, $settings));
                } catch (\Exception $e) {

                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }
//

                LeadActivityLog::create(
                    [
                        'user_id' => \Auth::user()->id,
                        'lead_id' => $lead->id,
                        'log_type' => 'create lead email',
                        'remark' => json_encode(['title' => 'Create new Deal Email']),
                    ]
                );

                return redirect()->back()->with('success', __('Email successfully created!').((isset($smtp_error)) ? '<br> <span class="text-danger">'.$smtp_error.'</span>' : ''))->with('status', 'emails');
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'emails');
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'))->with('status', 'emails');
        }
    }
}
