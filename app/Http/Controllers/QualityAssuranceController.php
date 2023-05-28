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
use App\Models\ConcretePouring;
use File;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;


class QualityAssuranceController extends Controller
{


    public function concrete(){

        try {

            $project_id = Session::get('project_id');

            $dairy_data = ConcretePouring::where('user_id',Auth::id())->where('project_id',$project_id)->get();

    
            return view('qaqc.concrete.index',compact("project_id","dairy_data"));

        } catch (Exception $e) {

            return $e->getMessage();

        }
      
    }

    public function concrete_create(Request $request)
    {
        try {

            $project =  Session::get('project_id');

            $id = $request["id"];
       

            $project_name = Project::select("project_name")
                ->where("id", $project)
                ->first();

          

            
            return view("qaqc.concrete.create",compact("project", "id","project_name"));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function concrete_edit(Request $request)
    {
        try {

            $project =  Session::get('project_id');

            $id = $request["id"];
       

            if ($id != null) {
                $get_dairy_data = ConcretePouring::where('project_id', $project)
                    ->where('user_id', Auth::id())
                    ->where('project_id',$project)
                    ->where('id', $id)
                    ->first();
            } else {
                $get_dairy_data = null;
            }

            $project_name = Project::select("project_name")
                ->where("id", $project)
                ->first();

          
                return view("qaqc.concrete.edit",compact("project", "id", "get_dairy_data", "project_name"));
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    

    public function save_concrete_pouring(Request $request)
    {
        try {
            unset($request["_token"]);

            $data = [
                "month_year" => $request->month_year,
                "date_of_casting" => $request->date_of_casting,
                "element_of_casting" => $request->element_of_casting,
                "grade_of_concrete" => $request->grade_of_concrete,
                "theoretical" => $request->theoretical,
                "actual" => $request->actual,
                "testing_fall" => $request->testing_fall,
                "total_result" => $request->total_result,
                "days_testing_falls" => $request->days_testing_falls,
                "days_testing_result" => $request->days_testing_result,
                "remarks" => $request->remarks,
            ];

            $fileNameToStore1='';
            $url='';

            if (!empty($request->file_name)) {
                $filenameWithExt1 = $request->file("file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/concrete_pouring";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
            
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                
            }

            $all_data = [
                "file_name" => $fileNameToStore1,
                "file_path" => $url,
                "project_id" => Session::get('project_id'),
                "user_id" => Auth::id(),
                "diary_data" => json_encode($data),
                "status" => 0,
            ];


            ConcretePouring::insert($all_data);

         
            return redirect()->back()->with("success",__("Concrete Pouring created successfully."));
           


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_concrete_pouring(Request $request)
    {
        try {
            
            unset($request["_token"]);

            $data = [
                "month_year" => $request->month_year,
                "date_of_casting" => $request->date_of_casting,
                "element_of_casting" => $request->element_of_casting,
                "grade_of_concrete" => $request->grade_of_concrete,
                "theoretical" => $request->theoretical,
                "actual" => $request->actual,
                "testing_fall" => $request->testing_fall,
                "total_result" => $request->total_result,
                "days_testing_falls" => $request->days_testing_falls,
                "days_testing_result" => $request->days_testing_result,
                "remarks" => $request->remarks,
            ];

           
        
            if (!empty($request->file_name)) {
                $filenameWithExt1 = $request->file("file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/concrete_pouring";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
            
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                
            }else{
                $check_file_name=DB::table('dairy')->select('file_name','file_path')->where('id',$request->edit_id)->where('project_id',$request->project_id)->first();
                $fileNameToStore1=$check_file_name->file_name;
                $url=$check_file_name->file_path;
            }

            $all_data = [
                "file_name" => $fileNameToStore1,
                "file_path" => $url,
                "project_id" => Session::get('project_id'),
                "user_id" => Auth::id(),
                "diary_data" => json_encode($data),
                "status" => 0,
            ];


            ConcretePouring::where('id',$request->edit_id)
                            ->where('project_id',Session::get('project_id'))
                            ->where('user_id', Auth::id())
                            ->update($all_data);

            return redirect()->back()->with("success",__("diary updated successfully."));
           


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_concrete(Request $request)
    {
        try {

            ConcretePouring::where('id', $request->id)->where('user_id',Auth::id())->where('project_id',$request->project_id)->delete();

            return redirect()->back()->with("success", "Concrete pouring record deleted successfully.");

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
