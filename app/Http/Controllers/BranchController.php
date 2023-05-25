<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\LeaveType;
use App\Models\Document;
use App\Models\PayslipType;
use App\Models\AllowanceOption;
use App\Models\LoanOption;
use App\Models\DeductionOption;
use App\Models\GoalType;
use App\Models\TrainingType;
use App\Models\AwardType;
use App\Models\TerminationType;
use App\Models\JobCategory;
use App\Models\JobStage;
use App\Models\PerformanceType;
use App\Models\Competencies;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage branch'))
        {
            $branches = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('hrm.system_setup.branch.branch', compact('branches'));
            // return view('branch.index', compact('branches'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create branch'))
        {
            return view('hrm.system_setup.branch.branch_create');
            // return view('branch.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create branch'))
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

            $branch             = new Branch();
            $branch->name       = $request->name;
            $branch->created_by = \Auth::user()->creatorId();
            $branch->save();

            return redirect()->route('branch.index')->with('success', __('Branch  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Branch $branch)
    {
        return redirect()->route('branch.index');
    }

    public function edit(Branch $branch)
    {
        if(\Auth::user()->can('edit branch'))
        {
            if($branch->created_by == \Auth::user()->creatorId())
            {

                return view('branch.edit', compact('branch'));
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

    public function update(Request $request, Branch $branch)
    {
        if(\Auth::user()->can('edit branch'))
        {
            if($branch->created_by == \Auth::user()->creatorId())
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

                $branch->name = $request->name;
                $branch->save();

                return redirect()->route('branch.index')->with('success', __('Branch successfully updated.'));
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

    public function destroy(Branch $branch)
    {
        if(\Auth::user()->can('delete branch'))
        {
            if($branch->created_by == \Auth::user()->creatorId())
            {
                $branch->delete();

                return redirect()->route('branch.index')->with('success', __('Branch successfully deleted.'));
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

    public function getdepartment(Request $request)
    {

        if($request->branch_id == 0)
        {
            $departments = Department::get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $departments = Department::where('branch_id', $request->branch_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($departments);
    }

    public function getemployee(Request $request)
    {
        if(in_array('0', $request->department_id))
        {
            $employees = Employee::get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $employees = Employee::whereIn('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($employees);
    }

    public function checkDuplicateRS_HRM(Request $request){
        $form_name  = $request->form_name;
        $check_name = $request->get_name;
        $get_id     = $request->get_id;

        if($form_name == "Branch"){
            if($get_id == null){
                $get_check_val = Branch::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = Branch::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "Department"){
            if($get_id == null){
                $get_check_val = Department::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = Department::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "Designation"){
            if($get_id == null){
                $get_check_val = Designation::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = Designation::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "LeaveType"){
            if($get_id == null){
                $get_check_val = LeaveType::where('title',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = LeaveType::where('title',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "Document"){
            if($get_id == null){
                $get_check_val = Document::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = Document::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "PayslipType"){
            if($get_id == null){
                $get_check_val = PayslipType::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = PayslipType::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "AllowanceOption"){
            if($get_id == null){
                $get_check_val = AllowanceOption::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = AllowanceOption::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "LoanOption"){
            if($get_id == null){
                $get_check_val = LoanOption::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = LoanOption::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "DeductionOption"){
            if($get_id == null){
                $get_check_val = DeductionOption::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = DeductionOption::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "GoalType"){
            if($get_id == null){
                $get_check_val = GoalType::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = GoalType::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "TrainingType"){
            if($get_id == null){
                $get_check_val = TrainingType::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = TrainingType::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "AwardType"){
            if($get_id == null){
                $get_check_val = AwardType::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = AwardType::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "TerminationType"){
            if($get_id == null){
                $get_check_val = TerminationType::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = TerminationType::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "JobCategory"){
            if($get_id == null){
                $get_check_val = JobCategory::where('title',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = JobCategory::where('title',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "JobStage"){
            if($get_id == null){
                $get_check_val = JobStage::where('title',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = JobStage::where('title',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "PerformanceType"){
            if($get_id == null){
                $get_check_val = PerformanceType::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = PerformanceType::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "Competencies"){
            if($get_id == null){
                $get_check_val = Competencies::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = Competencies::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        elseif($form_name == "DocumentSetup"){
            if($get_id == null){
                $get_check_val = DucumentUpload::where('name',$check_name)->where('created_by',\Auth::user()->creatorId())->first();
            }
            else{
                $get_check_val = DucumentUpload::where('name',$check_name)->where('id','!=',$get_id)->where('created_by',\Auth::user()->creatorId())->first();
            }
        }
        else{
            $get_check_val = "Not Empty";
        }
        
        if($get_check_val == null){
            return 1; //Success
        }
        else{
            return 0; //Error
        }
    }
}
