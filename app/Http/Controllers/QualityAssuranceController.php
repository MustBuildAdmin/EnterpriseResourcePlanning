<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Contract_attachment;
use App\Models\ContractComment;
use App\Models\ContractNotes;
use App\Models\ContractType;
use App\Models\Project;
use App\Models\User;
use App\Models\UserDefualtView;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Config;
use App\Models\ConcretePouring;
use File;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;


class QualityAssuranceController extends Controller
{


    public function concrete(){


        try {

            if(Session::has('project_id')==null){
                return redirect()->route('construction_main')->with('error', __('Project Session Expired.'));
            }

            if(\Auth::user()->can('manage concrete')){

                if(\Auth::user()->type != 'company'){
                    $userid = Auth::user()->creatorId();
                }
                else{
                    $userid = \Auth::user()->id;
                }

                $projectid = Session::get('project_id');

                $dairydata = ConcretePouring::where('user_id',$userid)->where('project_id',$projectid)->get();
    
        
                return view('qaqc.concrete.index',compact("projectid","dairydata"));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }
           

        } catch (Exception $e) {

            dd($e->getMessage());

        }
      
    }

    public function concrete_create(Request $request)
    {
        try {

            if(\Auth::user()->can('create concrete')){

                $project =  Session::get('project_id');

                $id = $request["id"];
        

                $projectname = Project::select("project_name")
                    ->where("id", $project)
                    ->first();

                return view("qaqc.concrete.create",compact("project", "id","projectname"));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function concrete_edit(Request $request)
    {
        try {

            if(\Auth::user()->can('edit concrete')){

                $project =  Session::get('project_id');

                $id = $request["id"];

                    if(\Auth::user()->type != 'company'){
                        $userid = Auth::user()->creatorId();
                    }
                    else{
                        $userid = \Auth::user()->id;
                    }
       

                if ($id != null) {
                    $getdairydata = ConcretePouring::where('project_id', $project)
                        ->where('user_id', $userid)
                        ->where('project_id',$project)
                        ->where('id', $id)
                        ->first();
                } else {
                    $getdairydata = null;
                }

                $projectname = Project::select("project_name")
                    ->where("id", $project)
                    ->first();

                return view("qaqc.concrete.edit",compact("project", "id", "getdairydata", "projectname"));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    

    public function save_concrete_pouring(Request $request)
    {
        try {
            unset($request["_token"]);

            if(\Auth::user()->type != 'company'){
                $userid = Auth::user()->creatorId();
            }
            else{
                $userid = \Auth::user()->id;
            }

            $data = [
                "month_year" => $request->month_year,
                "date_of_casting" => $request->date_of_casting,
                "element_of_casting" => $request->element_of_casting,
                "grade_of_concrete" => $request->grade_of_concrete,
                "theoretical" => $request->theoretical,
                "actual" => $request->actual,
                "testing_fall" => $request->testing_fall,
                "total_result" => $request->total_result.Config::get('constants.MEASUREMENT'),
                "days_testing_falls" => $request->days_testing_falls,
                "days_testing_result" => $request->days_testing_result.Config::get('constants.MEASUREMENT'),
                "remarks" => $request->remarks,
            ];

            $fileNameToStore1='';
            $url='';

            if (!empty($request->file_name)) {
                $filenameWithExt1 = $request->file("file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = Config::get('constants.CONCRETE_POURING');

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
            
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                
            }

            $alldata = [
                "file_name" => $fileNameToStore1,
                "file_path" => $url,
                "project_id" => Session::get('project_id'),
                "user_id" => $userid,
                "diary_data" => json_encode($data),
                "status" => 0,
            ];


            ConcretePouring::insert($alldata);

            ActivityController::activity_store(Auth::user()->id, Session::get('project_id'), "Added New ConcretePouring", $request->element_of_casting);

         
            return redirect()->back()->with("success",__("Concrete Pouring created successfully."));
           


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_concrete_pouring(Request $request)
    {
        try {
            
            unset($request["_token"]);

            if(\Auth::user()->type != 'company'){
                $userid = Auth::user()->creatorId();
            }
            else{
                $userid = \Auth::user()->id;
            }

            $data = [
                "month_year" => $request->month_year,
                "date_of_casting" => $request->date_of_casting,
                "element_of_casting" => $request->element_of_casting,
                "grade_of_concrete" => $request->grade_of_concrete,
                "theoretical" => $request->theoretical,
                "actual" => $request->actual,
                "testing_fall" => $request->testing_fall,
                "total_result" => $request->total_result.Config::get('constants.MEASUREMENT'),
                "days_testing_falls" => $request->days_testing_falls,
                "days_testing_result" => $request->days_testing_result.Config::get('constants.MEASUREMENT'),
                "remarks" => $request->remarks,
            ];

           
       
            if (!empty($request->file_name)) {
                $filenameWithExt1 = $request->file("file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = Config::get('constants.CONCRETE_POURING');

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
            
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                
            }else{
                $checkfilename=DB::table('dairy')->select('file_name','file_path')->where('id',$request->edit_id)
                                ->where('project_id',$request->project_id)->first();
                $fileNameToStore1=$checkfilename->file_name;
                $url=$checkfilename->file_path;
            }

            $alldata = [
                "file_name" => $fileNameToStore1,
                "file_path" => $url,
                "project_id" => Session::get('project_id'),
                "user_id" => $userid,
                "diary_data" => json_encode($data),
                "status" => 0,
            ];


            ConcretePouring::where('id',$request->edit_id)
                            ->where('project_id',Session::get('project_id'))
                            ->where('user_id', $user_id)
                            ->update($alldata);

            ActivityController::activity_store(Auth::user()->id, Session::get('project_id'), "Updated ConcretePouring", $request->element_of_casting);

            return redirect()->back()->with("success",__("diary updated successfully."));
           


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_concrete(Request $request)
    {
        try {

            if(\Auth::user()->can('delete concrete')){

                if(\Auth::user()->type != 'company'){
                    $userid = Auth::user()->creatorId();
                }
                else{
                    $userid = \Auth::user()->id;
                }

                $ConcretePouring = ConcretePouring::where('id', $request->id)->where('user_id',$user_id)->where('project_id',$request->project_id)->first();
                if($ConcretePouring != null){
                    ActivityController::activity_store(Auth::user()->id, Session::get('project_id'), "Deleted ConcretePouring", $ConcretePouring->element_of_casting);
                }

                ConcretePouring::where('id', $request->id)->where('user_id',$user_id)->where('project_id',$request->project_id)->delete();

                return redirect()->back()->with("success", "Concrete pouring record deleted successfully.");

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }
           
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function bricks(){
        return view('qaqc.bricks');
    }
    public function cement(){
        return view('qaqc.cement');
    }
    public function sand(){
        return view('qaqc.sand');
    }
    public function steel(){
        return view('qaqc.steel');
    }


}
