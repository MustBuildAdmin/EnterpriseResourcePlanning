<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Utility;
use App\Models\User;
use App\Models\RFIPriority;
use App\Models\RFIRecord;
use App\Models\Drawing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RFIController extends Controller
{
    public function index(Request $request)
    {
        $projectid = Session::get('project_id');
        $rfi_records = RFIRecord::select('rfi_record.id as rfi_id',
        'rfi_record.submission_date as submitted_date', 'rfi_priority.priority_type as rfi_status',
        'users.id as user_id', 'users.name as responder_name')
        ->join('users', 'users.id', '=', 'rfi_record.responder_id')
        ->join('rfi_priority', 'rfi_priority.id', '=', 'rfi_record.rfi_priority')
        ->where('project_id', $projectid)->get();
        // dd($rfi_records);
        $rfi_priorities = RFIPriority::select('id', 'priority_type')
        ->get();
        
        return view('rfi.index', compact('projectid', 'rfi_records', 'rfi_priorities'));
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create product & service')) {
            dd($request->dependency_value);
            $projectid = Session::get('project_id');
            $rfi_record = new RFIRecord();
            $rfi_record->project_id = $projectid;
            $rfi_record->responding_party_type = $request->party_type;
            $rfi_record->responder_id = $request->responding_type;
            $rfi_record->rfi_dependency = $request->dependency_type;
            $rfi_record->rfi_dependency_values = $request->dependency_value;
            $rfi_record->time_impact = $request->time_impact;
            $rfi_record->cost_impact = $request->cost_impact;
            $rfi_record->submission_date = $request->submission_date;
            $rfi_record->rfi_priority = $request->rfi_priority;
            $rfi_record->description = $request->tinymce_mytextarea;
            $rfi_record->created_by = \Auth::user()->creatorId();
            $rfi_record->save();
            return redirect()->route('rfi.index')->with('success', __('RFI Record Added Successfully.'));
        } else {
            return redirect()->back()->with('error', __(DENIED));
        }
    }

    public function getRespondingParty(Request $request)
    {
        $responding_parties = User::where('type', $request->party_type)->get()->pluck('id', 'name')->toArray();
        return response()->json($responding_parties);
        
    }

    public function rfi_autocomplete(Request $request)
    {
        // $searchValue = $request['q'];
        // dd($type);
        dd("hi");
    }

    public function getDependencyDetails(Request $request)
    {
        // $searchValue = $request['q'];
        
        if($request->dependency_type == 'tasks'){
            $data = '';
            return response()->json($data);
        }
        elseif ($request->dependency_type == 'drawings')
        {
            $data = Drawing::get()->pluck('id', 'reference_number')->toArray();
            return response()->json($data);
        }
        
    }
}
