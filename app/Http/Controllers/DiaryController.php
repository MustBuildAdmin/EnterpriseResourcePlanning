<?php

namespace App\Http\Controllers;
use App\Models\Construction_project;
use App\Models\Project;
use App\Models\ConcretePouring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;
use App\Models\DairyList;
use App\Models\ConsultantDirection;
use App\Models\ConsultantsDirectionMulti;
use App\Models\RFIStatusSave;
use App\Models\RFIStatusSubSave;
use App\Models\ProjectSpecification;
use App\Models\ProcurementMaterial;
use App\Models\ProcurementMaterialSub;
use File;
use DB;
use Session;

class DiaryController extends Controller
{
    public function index($view = "grid")
    {
        try {

            return view("diary.index", compact("view"));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function filterDiaryView(Request $request)
    {
        if (\Auth::user()->can("manage project")) {
            $usr = Auth::user();
            if (\Auth::user()->type == "client") {
                $user_projects = Project::where("client_id", \Auth::user()->id)
                    ->where("created_by", \Auth::user()->creatorId())
                    ->pluck("id", "id")
                    ->toArray();
            } else {
                $user_projects = $usr
                    ->projects()
                    ->pluck("project_id", "project_id")
                    ->toArray();
            }
            if ($request->ajax() && $request->has("view") && $request->has("sort")) {
                $sort = explode("-", $request->sort);
                $projects = Project::whereIn("id",array_keys($user_projects))->orderBy($sort[0], $sort[1]);

                if (!empty($request->keyword)) {
                    $projects
                        ->where("project_name", "LIKE", $request->keyword . "%")
                        ->orWhereRaw(
                            'FIND_IN_SET("' . $request->keyword . '",tags)'
                        );
                }
                if (!empty($request->status)) {
                    $projects->whereIn("status", $request->status);
                }
                $projects = $projects->get();
                $returnHTML = view("diary." . $request->view,compact("projects", "user_projects"))->render();

                return response()->json([
                    "success" => true,
                    "html" => $returnHTML,
                ]);
            }
        } else {
            return redirect()->route("diary.concrete_pouring")->with("success", __("Designation  successfully created."));
        }
    }

    public function show($view = "grid", Request $request)
    {
        try {

            $project_id = $request->id;

            $dairy_data = ConcretePouring::where('user_id',Auth::id())->where('project_id',$project_id)->get();

            $dairy_list = DairyList::select("id", "diary_name")
                        ->where("status", "0")
                        ->get();

            return view("diary.show",compact("project_id", "dairy_list", "dairy_data"));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    
    
    public function show_consultant_direction(Request $request)
    {
        try {

            if(Session::has('project_id')==null){
                return redirect()->route('construction_main')->with('error', __('Project Session Expired.'));
            }

            if(\Auth::user()->can('manage directions')){

                $project_id = Session::get('project_id');

                $project_name = Project::select("project_name")
                ->where("id", $project_id)
                ->first();
    
                $dairy_data = ConsultantDirection::select(
                    "consultant_directions.id",
                    "consultant_directions.issued_by",
                    "consultant_directions.issued_date",
                    "consultant_directions.ad_ae_ref",
                    "consultant_directions.ad_ae_decs",
                    "consultant_directions.attach_file_name",
                    "consultants_direction_multi.initiator_reference",
                    "consultants_direction_multi.initiator_date")
                ->leftJoin(
                    "consultants_direction_multi","consultants_direction_multi.consultant_id","=","consultant_directions.id")
                ->where("consultant_directions.project_id", Session::get('project_id'))
                ->where('consultant_directions.user_id',Auth::id())
                ->orderBy('consultant_directions.id', 'DESC')
                ->groupBy('consultant_directions.id')
                ->get();
    
                return view("diary.consultant_direction.index",compact("project_id", "dairy_data","project_name"));

            }else{
                return redirect()->back()->with('error', __('Permission denied.'));
            }
           
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function add_consultant_direction(Request $request)
    {
        try {

            if(\Auth::user()->can('create directions')){

                $project = $request["project_id"];

                $project_name = Project::select("project_name")
                    ->where("id", $project)
                    ->first();
                
                return view("diary.consultant_direction.create",compact("project_name", "project"));

            }else{
                return redirect()->back()->with('error', __('Permission denied.'));
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit_consultant_direction(Request $request)
    {
        try {

            if(\Auth::user()->can('edit directions')){

                $project = $request["project_id"];

                $project_name = Project::select("project_name")
                    ->where("id", $project)
                    ->first();
    
                $consult_dir = ConsultantDirection::where('id', '=', $request->id)
                                                    ->where('project_id', Session::get('project_id'))
                                                    ->where('user_id', Auth::id())
                                                    ->first();
    
                $consult_dir_multi = ConsultantsDirectionMulti::where("consultant_id","=",$consult_dir->id)->get();
    
                $initiator_date=$consult_dir_multi[0]->initiator_date;
    
                return view("diary.consultant_direction.edit",compact("consult_dir","consult_dir_multi","project_name","project","initiator_date"));

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

    public function diary_display_table(Request $request)
    {
        try {
            if ($request->dairy_id == 1) {

                $project_id = $request->project_id;

                $dairy_data = ConcretePouring::where('user_id',Auth::id())->where('project_id',$request->project_id)->orderBy('id', 'DESC')->get();

                $returnHTML = view("diary.congret",compact("dairy_data", "project_id"))->render();

            } elseif ($request->dairy_id == 2) {

                $project_id = $request->project_id;

                $dairy_data = ConsultantDirection::select(
                    "consultant_directions.id",
                    "consultant_directions.issued_by",
                    "consultant_directions.issued_date",
                    "consultant_directions.ad_ae_ref",
                    "consultant_directions.ad_ae_decs",
                    "consultant_directions.attach_file_name",
                    "consultants_direction_multi.initiator_reference",
                    "consultants_direction_multi.initiator_date")
                ->leftJoin(
                    "consultants_direction_multi","consultants_direction_multi.consultant_id","=","consultant_directions.id")
                ->where("consultant_directions.project_id", $project_id)
                ->where('consultant_directions.user_id',Auth::id())
                ->orderBy('consultant_directions.id', 'DESC')
                ->groupBy('consultant_directions.id')
              
                ->get();

                $returnHTML = view("diary.show_consultant_direction",compact("project_id", "dairy_data"))->render();

            }else if($request->dairy_id == 10){
                $project_id = $request->project_id;
                $dairy_data = ProjectSpecification::where('user_id',Auth::id())->where('project_id',$request->project_id)->orderBy('id', 'DESC')->get();
                $returnHTML = view("diary.show_project_specification",compact("project_id","dairy_data"))->render();
            }else if($request->dairy_id == 12){
                $project_id = $request->project_id;
                $dairy_data = RFIStatusSave::where('user_id',Auth::id())->where('project_id',$request->project_id)->orderBy('rfi_status_save.id', 'DESC')->groupBy('rfi_status_save.id')->get();
                $returnHTML = view("diary.show_rfs",compact("project_id","dairy_data"))->render();
            }else if($request->dairy_id == 13){
                $project_id = $request->project_id;
                $dairy_data = DB::table('variation_scope')->where('user_id',Auth::id())->where('project_id',$request->project_id)->orderBy('id', 'DESC')->get();
                $returnHTML = view("diary.show_vo_change",compact("project_id","dairy_data"))->render();
            }
            else {
                $project_id = $request->project_id;
                $dairy_data = ConcretePouring::where('user_id',Auth::id())->where('project_id',$request->project_id)->orderBy('id', 'DESC')->get();
                $returnHTML = view("diary.show_consultant_direction",compact("dairy_data", "project_id"))->render();
            }
            return response()->json([
                "success" => true,
                "html" => $returnHTML,
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    
    public function delete_consultant_direction(Request $request)
    {
        try {

            if(\Auth::user()->can('delete directions')){

                ConsultantDirection::where('id', $request->id)->where('user_id',Auth::id())->where('project_id',$request->project_id)->delete();

                ConsultantsDirectionMulti::where('consultant_id',$request->id)->delete();

                return redirect()->back()->with("success", "Consultants directions record deleted successfully.");

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_consultant_direction(Request $request)
    {
        try {
            unset($request["_token"]);

            if (!empty($request->attach_file_name)) {
                $filenameWithExt1 = $request->file("attach_file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attach_file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/consultant_direction";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"attach_file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                  
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                $data = [
                    "user_id" => Auth::id(),
                    "project_id" => $request->project_id,
                    "issued_by" => $request->issued_by,
                    "issued_date" => $request->issued_date,
                    "ad_ae_ref" => $request->ad_ae_ref,
                    "ad_ae_decs" => $request->ad_ae_decs,
                    "attach_file_name" => $filenameWithExt1,
                    "file_path" =>$url,
                ];

                ConsultantDirection::insert($data);
                $id = DB::getPdo()->lastInsertId();

                $initiator_file_name = [];
                $initiator_file_folder = "diary/initiator";
                if ($request->hasfile("initiator_file_name")) {
                    foreach ($request->file("initiator_file_name")as $file) {
                        $name = $file->getClientOriginalName();
                        $file->move(public_path("files"), $name);
                        $initiator_file_name[] = $name;
                    }
                }

                $replier_file_name = [];
                $replier_file_folder = "diary/replier";
                if ($request->hasfile("replier_file_name")) {
                    foreach ($request->file("replier_file_name")as $file1) {
                        $name1 = $file1->getClientOriginalName();
                        $file1->move(public_path("files/1"), $name1);
                        $replier_file_name[] = $name1;
                    }
                }

                if (count($request->initiator_reference) > 0) {
                    foreach ($request->initiator_reference as $item => $v) {

                        if(isset($request->initiator_reference[$item])){
                            $set_initiator_reference=$request->initiator_reference[$item];
                        }else{
                            $set_initiator_reference=null;
                        }
        
                        if(isset($request->initiator_date[$item])){
                            $set_initiator_date=$request->initiator_date[$item];
                        }else{
                            $set_initiator_date=null;
                        }
        
                        if(isset($initiator_file_name[$item])){
                            $set_initiator_file_name=$initiator_file_name[$item];
                        }else{
                            $set_initiator_file_name=null;
                        }
        

        
                        if(isset($request->replier_status[$item])){
                            $set_replier_status=$request->replier_status[$item];
                        }else{
                            $set_replier_status=null;
                        }
        
                        if(isset($request->replier_remark[$item])){
                            $set_replier_remark=$request->replier_remark[$item];
                        }else{
                            $set_replier_remark=null;
                        }
        
                        if(isset($replier_file_name[$item])){
                            $set_replier_file_name=$replier_file_name[$item];
                        }else{
                            $set_replier_file_name=null;
                        }

                        $data2 = [
                            "consultant_id" => $id,
                            "initiator_reference" =>$set_initiator_reference,
                            "initiator_date" =>$set_initiator_date,
                            "initiator_file_name" =>$set_initiator_file_name,
                            // "replier_reference" =>$set_replier_reference,
                            // "replier_date" => $set_replier_date,
                            "replier_status" =>$set_replier_status,
                            "replier_remark" =>$set_replier_remark,
                            "replier_file_name" =>$set_replier_file_name,
                            
                        ];
                       
                        ConsultantsDirectionMulti::insert($data2);
                    }
                }

                return redirect()->back()->with("success", __("Consultants directions summary created successfully."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_consultant_direction(Request $request)
    {
        try {
          
            unset($request["_token"]);
          
            if (!empty($request->attach_file_name)) {
                $filenameWithExt1 = $request->file("attach_file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attach_file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/consultant_direction";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"attach_file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()
                        ->back()
                        ->with("error", __($path["msg"]));
                }
            }else{
                $check_attach_file=ConsultantDirection::select('attach_file_name','file_path')
                                                        ->where('id',$request->id)
                                                        ->where('user_id',Auth::id())
                                                        ->where('project_id',$request->project_id)
                                                        ->first();              
                                                                     
                $filenameWithExt1=$check_attach_file->attach_file_name;
                $url=$check_attach_file->file_path;
                         
            }
          
           
            $data = [
                "user_id" => Auth::id(),
                "project_id" => $request->project_id,
                "issued_by" => $request->issued_by,
                "issued_date" => $request->issued_date,
                "ad_ae_ref" => $request->ad_ae_ref,
                "ad_ae_decs" => $request->ad_ae_decs,
                "attach_file_name" => $filenameWithExt1,
                "file_path" => $url,
            ];

            ConsultantDirection::where('project_id',$request->project_id)
                                 ->where('user_id',Auth::id())
                                 ->where('id', $request->id)
                                 ->update($data);

            $in_id = DB::table('consultant_directions')
                ->where('id', '=', $request->id)
                ->where('user_id',Auth::id())
                ->where('project_id',$request->project_id)
                ->get('id');

            $invoice_id = trim($in_id, '[{"id:"}]');

            $initiator_file_name = [];

            if (!empty($request->initiator_file_name)) {
                if ($request->hasfile("initiator_file_name")) {
                    foreach ($request->file("initiator_file_name") as $file) {
                        $name = $file->getClientOriginalName();
                        $file->move(public_path("files"), $name);
                        // $initiator_file_name[] = $name;
                        array_push($initiator_file_name,$name);
                    }
                    $check_initiator_file=ConsultantsDirectionMulti::select('initiator_file_name')->where('consultant_id',$request->id)->get();
                    if(count($check_initiator_file)!=0){
                        foreach ($check_initiator_file as $file) {
                            array_push($initiator_file_name,$file->initiator_file_name);
                            
                        }
                    }
                   
                    }
            }else{
                    $check_initiator_file=ConsultantsDirectionMulti::select('initiator_file_name')->where('consultant_id',$request->id)->get();
                    if(count($check_initiator_file)!=0){
                        foreach ($check_initiator_file as $file) {
                            $initiator_file_name[] = $file->initiator_file_name;
                            
                        }
                    }
            }

            $replier_file_name = [];

            if (!empty($request->replier_file_name)) {
                if ($request->hasfile("replier_file_name")) {
                    foreach ($request->file("replier_file_name") as $file) {
                        $name = $file->getClientOriginalName();
                        $file->move(public_path("files/1"), $name);
                        // $initiator_file_name[] = $name;
                        array_push($replier_file_name,$name);
                    }
                    $check_replier_file=ConsultantsDirectionMulti::select('replier_file_name')->where('consultant_id',$request->id)->get();
                    if(count($check_replier_file)!=0){
                        foreach ($check_replier_file as $file) {
                            array_push($replier_file_name,$file->replier_file_name);
                            
                        }
                    }
                   
                    }
            }else{
                    $check_replier_file=ConsultantsDirectionMulti::select('replier_file_name')->where('consultant_id',$request->id)->get();
                    if(count($check_replier_file)!=0){
                        foreach ($check_replier_file as $file) {
                            $replier_file_name[] = $file->replier_file_name;
                            
                        }
                    }
            }

           
            $delete_invoice = ConsultantsDirectionMulti::where('consultant_id','=',$request->id)->delete();
     
            if (count($request->initiator_reference) >= 0) {
                foreach ($request->initiator_reference as $item => $v) {
                // dd($initiator_file_name[$item]);
               
                if(isset($request->initiator_reference[$item])){
                    $set_initiator_reference=$request->initiator_reference[$item];
                }else{
                    $set_initiator_reference=null;
                }

                if(isset($request->initiator_date[$item])){
                    $set_initiator_date=$request->initiator_date[$item];
                }else{
                    $set_initiator_date=null;
                }

                if(isset($initiator_file_name[$item])){
                    $set_initiator_file_name=$initiator_file_name[$item];
                }else{
                    $set_initiator_file_name=null;
                }


                if(isset($request->replier_status[$item])){
                    $set_replier_status=$request->replier_status[$item];
                }else{
                    $set_replier_status=null;
                }


                if(isset($request->replier_remark[$item])){
                    $set_replier_remark=$request->replier_remark[$item];
                }else{
                    $set_replier_remark=null;
                }

                if(isset($replier_file_name[$item])){
                    $set_replier_file_name=$replier_file_name[$item];
                }else{
                    $set_replier_file_name=null;
                }

                    $data2 = [
                        "consultant_id" => $invoice_id,
                        "initiator_reference" =>$set_initiator_reference,
                        "initiator_date" =>$set_initiator_date,
                        "initiator_file_name" =>$set_initiator_file_name,
                        // "replier_reference" =>$set_replier_reference,
                        // "replier_date" => $set_replier_date,
                        "replier_status" =>$set_replier_status,
                        "replier_remark" =>$set_replier_remark,
                        "replier_file_name" =>$set_replier_file_name,
                        
                    ];
                    
            
                    if ($request->increment < 0) {
                        ConsultantsDirectionMulti::insert($data2);
                       
                    } else {
                        ConsultantsDirectionMulti::insert($data2);
                       
                    }
                    // }
                }
            }
          
            return redirect()->back()->with("success", __("Consultants directions summary updated successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function rfi_show_info(){
        try {

            if(Session::has('project_id')==null){
                return redirect()->route('construction_main')->with('error', __('Project Session Expired.'));
            }

            if(\Auth::user()->can('manage RFI')){

                $project_id = Session::get('project_id');
                $dairy_data=RFIStatusSave::where('user_id',Auth::id())->where('project_id',Session::get('project_id'))->get();
                return view('diary.rfi.index',compact('project_id','dairy_data'));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        }
        catch (exception $e) {
            return $e->getMessage();
        }
    }

    public function rfi_info_status(Request $request){
        try {
            if(\Auth::user()->can('create RFI')){

                $project = Session::get('project_id');
                $project_name = Project::select('project_name')
                ->where('id', $project)
                ->first();
               
                
                return view('diary.rfi.create',compact('project','project_name'));


            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        }
        catch (exception $e) {
            return $e->getMessage();
        }
    }

    public function rfi_info_main_save(Request $request){
        try {

            

            $data=array("user_id"=>Auth::id(),
                        "project_id"=>Session::get('project_id'),
                        "contractor_name"=>$request->contractor_name,
                        "consulatant_data"=>json_encode($request->rfijson),
            );
          
            RFIStatusSave::insert($data);

            return redirect()->back()->with("success", __("RFI created successfully."));
          
          } catch (Exception $e) {
        
          
              return $e->getMessage();
          
          }
    }

    public function edit_rfi_info_status(Request $request){

        try {

            if(\Auth::user()->can('edit RFI')){

                $project_id = $request["project_id"];

                $project = Project::select('project_name')
                ->where("id", $project_id)
                ->first();
                
                $get_dairy=RFIStatusSave::where('project_id',$project_id)->where('user_id',Auth::id())->where('id',$request->id)->first();
                $contractor=RFIStatusSave::where('user_id', '=', Auth::id())->where('id',$request->id)->where('project_id', $project_id)->get()->pluck('consulatant_data');
                $contractor_name=json_decode($contractor);
                $get_sub_table=RFIStatusSubSave::where('project_id',$project_id)->where('user_id',Auth::id())->where('rfi_id',$request->id)->first();

                $get_content = RFIStatusSubSave::where("project_id",$project_id)->where('user_id',Auth::id())->where('rfi_id',$request->id)->get();
              
              
                // $rfs_dir_multi = RFIStatusSubSave::where('rfi_id','=',$get_dairy_data->id)->get();
        
                return view('diary.rfi.edit',compact('get_dairy','project','project_id','contractor_name','contractor','get_sub_table','get_content'));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {

            return $e->getMessage();

        }
        

    }

    public function update_rfi_info_status(Request $request){
        try {
           

            // "consulatant_data"=>json_encode($request->rfijson)

            

                if($request->select_the_consultants!=null){
                    $select_the_consultant_value = implode(',', $request->select_the_consultants);
                }else{
                    $select_the_consultant_value = Null;
                }

               

                // if (!empty($request->attachment_one)) {
                //     $filenameWithExt1 = $request->file("attachment_one")->getClientOriginalName();
                //     $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                //     $extension1 = $request->file("attachment_one")->getClientOriginalExtension();
                //     $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;
    
                //     $dir = "uploads/RFI";
    
                //     $image_path = $dir . $filenameWithExt1;
                //     if (\File::exists($image_path)) {
                //         \File::delete($image_path);
                //     }
                //     $url = "";
                //     $path = Utility::upload_file($request,"attachment_one",$fileNameToStore1,$dir,[]);
    
                //     if ($path["flag"] == 1) {
                //         $url = $path["url"];
                //     } else {
                //         return redirect()->back()->with("error", __($path["msg"]));
                //     }
                // }else{
                //     $check_attach_file=RFIStatusSave::select('attachment_one','attachment_one_path')
                //                          ->where('id',$request->edit_id)
                //                          ->where('user_id',Auth::id())
                //                          ->where('project_id',$request->project_id)
                //                          ->first();
                                                                         
                //     $filenameWithExt1=$check_attach_file->attachment_one;
                //     $url=$check_attach_file->attachment_one_path;
                             
                // }

                $save_rfi_one=array(

                    "user_id"=>Auth::id(),
                    "project_id"=>Session::get('project_id'),
                    "contractor_name"=>$request->contractor_name,
                    "consulatant_data"=>json_encode($request->data),
                    "reference_no"=>$request->reference_no,
                    "requested_date"=>$request->requested_date,
                    "required_date"=>$request->required_date,
                    "priority"=>$request->priority,
                    "cost_impact"=>$request->cost_impact,
                    "time_impact"=>$request->time_impact,
                    "description"=>$request->description,
                    "select_the_consultants"=>$select_the_consultant_value,
                    "attachment_one"=>"dflgdl.png",
                    "attachment_one_path"=>'ghgfh',
                    // "attachment_one"=>$fileNameToStore1,
                    // "attachment_one_path"=>$url,
                    // "date_of_replied_data"=>'',
                );


              

            RFIStatusSave::where('id',$request->edit_id)
            ->where('user_id',Auth::id())
            ->where('project_id',Session::get('project_id'))
            ->update($save_rfi_one);

            // $attachments_two = [];

            // if (!empty($request->attachments_two)) {
            //     if ($request->hasfile("attachments_two")) {
            //         foreach ($request->file("attachments_two") as $file) {
            //             $name = $file->getClientOriginalName();
            //             $file->move(public_path("uploads/RFI"), $name);
            //             // $initiator_file_name[] = $name;
            //             array_push($attachments_two,$name);
            //         }
            //         $check_replier_file=RFIStatusSubSave::select('attachments_two')->where('rfi_id',$request->id)->get();
            //         if(count($check_replier_file)!=0){
            //             foreach ($check_replier_file as $file) {
            //                 array_push($attachments_two,$file->attachments_two);
                            
            //             }
            //         }
                   
            //         }
            // }else{
            //         $check_replier_file=RFIStatusSubSave::select('attachments_two')->where('consultant_id',$request->id)->get();
            //         if(count($check_replier_file)!=0){
            //             foreach ($check_replier_file as $file) {
            //                 $replier_file_name[] = $file->attachments_two;
                            
            //             }
            //         }
            // }

               

                $in_id =  DB::table('dr_rfi_main_sub_save')
                ->where('id', '=', $request->edit_id)
                ->where('user_id',Auth::id())
                ->where('project_id',Session::get('project_id'))
                ->get('id');

                $invoice_id = trim($in_id, '[{"id:"}]');


        //   dd($request->name_of_consulatant);
                
        // if($request->name_of_consulatant!=null){
        //     $select_name_consultant = implode(',', $request->name_of_consulatant);
        // }else{
        //     $select_name_consultant = Null;
        // }

       
        // dd(array_unique($check_arra));
        // dd($setdata);

        $delete_invoice = RFIStatusSubSave::where('rfi_id','=',$request->edit_id)->delete();
       
        for($i=1; $i<=$request->multi_total_count;$i++) {
            $name_of_consulatant_var = 'name_of_consulatant'.$i;
            $replied_date_var        = 'replied_date'.$i;
            $status_var              = 'status'.$i;
            $remarks_var             = 'remarks'.$i;
            if(isset($request->$replied_date_var)){

                $name_of_consulatant_set   = $request->$name_of_consulatant_var;
                $replied_date_set          = $request->$replied_date_var;
                $status_set                = $request->$status_var;
                $remarks_set               = $request->$remarks_var;
    
                if($name_of_consulatant_set!=null){
                    $select_name_consultant = implode(',', $name_of_consulatant_set);
                }else{
                    $select_name_consultant = Null;
                }
    
                $multi_insert_array = array(
                    "user_id"            => Auth::id(),
                    "project_id"         => Session::get('project_id'),
                    "rfi_id"             => $invoice_id,
                    'name_of_consultant' => $select_name_consultant,
                    'replied_date'       => $replied_date_set,
                    'status'             => $status_set,
                    'remarks'            => $remarks_set
                );
    
                RFIStatusSubSave::insert($multi_insert_array);

            }
            
           
        }

//         if (count($request->replied_date) >= 0) {
//             foreach ($request->replied_date as $item => $v) {
       
//                 // dd($initiator_file_name[$item]);
             
              

//                 if($request->name_of_consulatant[$item]!=null){
//                     $select_the_consultant_value = $request->name_of_consulatant[$item];
//                 }else{
//                     $select_the_consultant_value = Null;
//                 }

//                 // if(isset($check_arra[$item])){
//                 //     $set_name_of_consultant=$check_arra[$item];
                  
//                 // }else{
//                 //     $set_name_of_consultant=null;
//                 // }

               



//                 if(isset($request->replied_date[$item])){
//                     $set_replied_date=$request->replied_date[$item];
//                 }else{
//                     $set_replied_date=null;
//                 }


//                 if(isset($request->status[$item])){
//                     $set_replier_status=$request->status[$item];
//                 }else{
//                     $set_replier_status=null;
//                 }


//                 if(isset($request->remarks[$item])){
//                     $set_remarks=$request->remarks[$item];
//                 }else{
//                     $set_remarks=null;
//                 }

//                 // if(isset($replier_file_name[$item])){
//                 //     $set_replier_file_name=$replier_file_name[$item];
//                 // }else{
//                 //     $set_replier_file_name=null;
//                 // }
// // dd($request->replied_date[$item]);
//                 $save_rfi_two=array(

//                     "user_id"=>Auth::id(),
//                     "project_id"=>Session::get('project_id'),
//                     "rfi_id"=>$invoice_id,
//                     "name_of_consultant"=>$select_the_consultant_value,
//                     "replied_date"=>$set_replied_date,
//                     "status"=>$set_replier_status,
//                     "remarks"=>$set_remarks,
//                     // // "attachments_two"=>"fdgdgd.png",
//                     // // "attachments_two_path"=>"folderfdgdgd.png",
//                     // "attachments_two"=>$replier_file_name,
//                     // "attachments_two_path"=>"kkkkk",
//                     // "date_of_replied_data"=>'',
//                 );
                    
            
//                     if ($request->increment < 0) {
//                         RFIStatusSubSave::insert($save_rfi_two);
                       
//                     } else {
//                         RFIStatusSubSave::insert($save_rfi_two);
                       
//                     }
//                     // }
//                 }
//             }

     

            return redirect()->back()->with("success", __("RFI updated successfully."));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function get_name_of_consultant(Request $request){
        try{

            $get_dairy=RFIStatusSave::where('project_id',Session::get('project_id'))->where('user_id',Auth::id())->where('id',$request->id)->first();
            $decode=json_decode($get_dairy->consulatant_data);
            $html='';

            foreach($decode as $conkey =>$con){
              
                $html.='<option value="'.$con.'" >'.$con.'</option>';
            }
          

            return $html;

        

        }catch (Exception $e) {

            return $e->getMessage();

        }
    }

    public function delete_rfi_status(Request $request){

        try{

            if(\Auth::user()->can('delete RFI')){
           
                RFIStatusSave::where("id", $request->id)->where("project_id",Session::get('project_id'))->where("user_id",Auth::id())->delete();

                RFIStatusSubSave::where("rfi_id", $request->id)->delete();

                return redirect()->back()->with("success", "RFI record deleted successfully.");

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        }catch (Exception $e) {

            return $e->getMessage();

        }
    }

    public function show_project_specification(Request $request){

        try {

            if(Session::has('project_id')==null){
                return redirect()->route('construction_main')->with('error', __('Project Session Expired.'));
            }

            if(\Auth::user()->can('manage project specification')){

                $project_id = Session::get('project_id');
                $dairy_data = ProjectSpecification::where('user_id',Auth::id())->where('project_id',$project_id)->orderBy('id', 'ASC')->get();
                return view('diary.project_specification.index',compact('project_id','dairy_data'));
        
            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }
          

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }



    public function add_project_specification(Request $request){

        try {


            if(\Auth::user()->can('create project specification')){

                $project_id = Session::get('project_id');

                $project_name = Project::select('project_name')
                ->where("id", $project_id)
                ->first();

                return view('diary.project_specification.create',compact('project_name','project_id'));
        
            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function save_project_specification(Request $request){

        try {

            
            $fileNameToStore1='';
            $url='';

            if (!empty($request->attachment_file_name)) {
                $filenameWithExt1 = $request->file("attachment_file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/project_direction_summary";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"attachment_file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
            
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                
            }

           
            $save_data = [
                "user_id" => Auth::id(),
                "project_id" =>$request->project_id,
                "reference_no" =>$request->reference_no,
                "description" =>$request->description,
                "location" =>$request->location,
                "drawing_reference" =>$request->drawing_reference,
                "remarks" =>$request->remarks,
                "attachment_file_name" =>$fileNameToStore1,
                
            ];

            ProjectSpecification::insert($save_data);

            return redirect()->back()->with("success", __("Project specification summary created Successfully."));

        }
        catch (Exception $e) {

            return $e->getMessage();

        }
    }

    public function edit_project_specification(Request $request){

        try {

            if(\Auth::user()->can('edit project specification')){

                $project_id = Session::get('project_id');

        
                $project_name = Project::select('project_name')
                ->where('id', $project_id)
                ->first();
                
                $data=ProjectSpecification::where('project_id',$project_id)
                                            ->where('id',$request->id)
                                            ->where('user_id',Auth::id())
                                            ->first();

                return view('diary.project_specification.edit',compact('data','project_name','project_id'));
        
            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    public function update_project_specification(Request $request){

        try {

            if (!empty($request->attachment_file_name)) {
                $filenameWithExt1 = $request->file("attachment_file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/project_direction_summary";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"attachment_file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
            }else{
                $check_attach_file=ProjectSpecification::select('attachment_file_name')
                                     ->where('id',$request->id)
                                     ->where('user_id',Auth::id())
                                     ->where('project_id',$request->project_id)
                                     ->first();
                                                                     
                $filenameWithExt1=$check_attach_file->attachment_file_name;
                         
            }
          
           
            $update_data = [
                "user_id" =>Auth::id(),
                "project_id" =>$request->project_id,
                "reference_no" =>$request->reference_no,
                "description" =>$request->description,
                "location" =>$request->location,
                "drawing_reference" =>$request->drawing_reference,
                "remarks" =>$request->remarks,
                "attachment_file_name" =>$filenameWithExt1,
                
            ];

            ProjectSpecification::where('id', $request->id)
                                  ->where('user_id',Auth::id())
                                  ->where('project_id',$request->project_id)
                                  ->update($update_data);

            return redirect()->back()->with("success", __("Project specification summary updated Successfully."));


        } catch (Exception $e) {

            return $e->getMessage();

        }

    }



    public function delete_project_specification(Request $request){

        try{

            if(\Auth::user()->can('delete project specification')){

                $project_id = Session::get('project_id');

                ProjectSpecification::where('id', $request->id)
                ->where('project_id',$request->project_id)
                ->where('user_id',Auth::id())
                ->delete();

                return redirect()->back()->with("success", "Project specification summary record deleted successfully.");
        
            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        }catch (Exception $e) {

            return $e->getMessage();

        }
    }

    public function variation_scope_change(Request $request)
    {
        try {

            if(Session::has('project_id')==null){
                return redirect()->route('construction_main')->with('error', __('Project Session Expired.'));
            }

            if(\Auth::user()->can('manage vochange')){

                $project_id = Session::get('project_id');
                $dairy_data = DB::table('variation_scope')->where('user_id',Auth::id())->where('project_id',Session::get('project_id'))->orderBy('id', 'DESC')->get();
                return view("diary.vo_sca_change_order.index",compact("project_id","dairy_data"));

            }else{
                return redirect()->back()->with('error', __('Permission denied.'));
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function add_variation_scope_change(Request $request)
    {
        try {
            if(\Auth::user()->can('create vochange')){

                $project = Session::get('project_id');
                $project_name = Project::select('project_name')
                ->where('id', $project)
                ->first();
            
                return view('diary.vo_sca_change_order.create',compact('project','project_name'));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit_variation_scope_change(Request $request)
    {
        try {

            if(\Auth::user()->can('edit vochange')){

                $project = Session::get('project_id');

                $id = $request["id"];
           
    
                if ($id != null) {
                    $get_dairy_data =  DB::table('variation_scope')->where('project_id', $project)
                        ->where('user_id', Auth::id())
                        ->where('project_id',$project)
                        ->where('id', $id)
                        ->first();
                }else{
                    $get_dairy_data = null;
                }
    
                $project_name = Project::select("project_name")
                    ->where("id", $project)
                    ->first();
    
              
    
                return view("diary.vo_sca_change_order.edit",compact("project", "id", "get_dairy_data", "project_name"));


            }else{

                return redirect()->back()->with('error', __('Permission denied.'));
            }
           

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_variation_scope_change(Request $request)
    {
        try {

         
           unset($request["_token"]);

            $data = [
                "issued_by" => $request->issued_by,
                "issued_date" => $request->issued_date,
                "sca_reference" => $request->sca_reference,
                "vo_reference" => $request->vo_reference,
                "reference" => $request->reference,
                "vo_date" => $request->vo_date,
                "claimed_omission_cost" => $request->claimed_omission_cost,
                "claimed_addition_cost" => $request->claimed_addition_cost,
                "claimed_net_amount" => $request->claimed_net_amount,
                "approved_omission_cost" => $request->approved_omission_cost,
                "approved_addition_cost" => $request->approved_addition_cost,
                "approved_net_cost" => $request->approved_net_cost,
                "impact_time" => $request->impact_time,
                "granted_eot" => $request->granted_eot,
                "remarks" => $request->remarks,
            ];

            $fileNameToStore1='';
            $url='';

            if (!empty($request->attachment_file)) {
                $filenameWithExt1 = $request->file("attachment_file")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_file")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/variation_scope";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"attachment_file",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
            
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                
            }

            $all_data = [
                "attachment_file" => $fileNameToStore1,
                "project_id" => Session::get('project_id'),
                "user_id" => Auth::id(),
                "data" => json_encode($data),
                "status" => 0,
            ];


            DB::table('variation_scope')->insert($all_data);

         
            return redirect()->back()->with("success",__("Vo/Change Order created successfully."));
           


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_variation_scope_change(Request $request)
    {
        try {

            unset($request["_token"]);

            $data = [
                "issued_by" => $request->issued_by,
                "issued_date" => $request->issued_date,
                "sca_reference" => $request->sca_reference,
                "vo_reference" => $request->vo_reference,
                "reference" => $request->reference,
                "vo_date" => $request->vo_date,
                "claimed_omission_cost" => $request->claimed_omission_cost,
                "claimed_addition_cost" => $request->claimed_addition_cost,
                "claimed_net_amount" => $request->claimed_net_amount,
                "approved_omission_cost" => $request->approved_omission_cost,
                "approved_addition_cost" => $request->approved_addition_cost,
                "approved_net_cost" => $request->approved_net_cost,
                "impact_time" => $request->impact_time,
                "granted_eot" => $request->granted_eot,
                "remarks" => $request->remarks,
            ];

            $fileNameToStore1='';
            $url='';

            if (!empty($request->attachment_file)) {
                $filenameWithExt1 = $request->file("attachment_file")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_file")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/variation_scope";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"attachment_file",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
            
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                
            }else{
                $check_file_name=DB::table('variation_scope')->select('attachment_file')->where('id',$request->id)->where('user_id',Auth::id())->where('project_id',Session::get('project_id'))->first();
                $fileNameToStore1=$check_file_name->attachment_file;
            }

            $all_data = [
                "attachment_file" => $fileNameToStore1,
                "project_id" => Session::get('project_id'),
                "user_id" => Auth::id(),
                "data" => json_encode($data),
                "status" => 0,
            ];


            DB::table('variation_scope')->where('id',$request->id)->where('project_id',Session::get('project_id'))->where('user_id',Auth::id())->update($all_data);

         
            return redirect()->back()->with("success",__("Vo/Change Order created successfully."));

        } catch (Exception $e) {

            return $e->getMessage();

        }
    }
    
    public function delete_variation_scope_change(Request $request)
    {
        try {
            if(\Auth::user()->can('delete vochange')){

                DB::table('variation_scope')->where('id',$request->id)->where('project_id',Session::get('project_id'))->where('user_id',Auth::id())->delete();
            
                return redirect()->back()->with("success", "Project specification summary record deleted successfully.");

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function drawing_list(Request $request)
    {
        try {
              
            return view("diary.drawings_list.index");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    public function daily_reportscreate(Request $request)
    {
        try {

            return view("diary.daily_reports.create");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function daily_reportsedit(Request $request)
    {
        try {

            return view("diary.daily_reports.edit");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    

    public function daily_reports(Request $request)
    {
        try {

            return view("diary.daily_reports.index");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function procurement_material(){
       
        try {
            if(\Auth::user()->can('manage procurement material')){

                $project_id = Session::get('project_id');
                $project_name = Project::select('project_name')
                ->where('id', $project_id)
                ->first();


                $dairy_data = ProcurementMaterial::get();

                
            
                return view('diary.procurement_material.index',compact('project_id','project_name','dairy_data'));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function add_procurement_material(){
       
        try {
            if(\Auth::user()->can('create procurement material')){

                $project_id = Session::get('project_id');
                $project_name = Project::select('project_name')
                ->where('id', $project_id)
                ->first();
            
                return view('diary.procurement_material.create',compact('project_id','project_name'));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function save_procurement_material(Request $request){
       
        try {
    
        $fileNameToStore='';
        $url='';

        if (!empty($request->filename)) {
            $filenameWithExt = $request->file("filename")->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file("filename")->getClientOriginalExtension();
            $fileNameToStore =$filename. "_" . time() . "." . $extension;

            $dir = "uploads/procurement_material";

            $image_path = $dir . $filenameWithExt;

            if (\File::exists($image_path)) {
                \File::delete($image_path);
            }
            $url = "";
            $path = Utility::upload_file($request,"filename",$fileNameToStore,$dir,[]);

            if ($path["flag"] == 1) {
                $url = $path["url"];
        
            } else {
                return redirect()->back()->with("error", __($path["msg"]));
            }
            
          
            $data = [
                "project_id" => Session::get('project_id'),
                "user_id" => Auth::id(),
                "description" => $request->description,
                "ram_ref_no" => $request->ram_ref_no,
                "location" => $request->location,
                "supplier_name" => $request->supplier_name,
                "contact_person" => $request->contact_person,
                "mobile_hp_no" => $request->mobile_hp_no,
                "tel" => $request->tel,
                "fax" => $request->fax,
                "email" => $request->email,
                "lead_time" => $request->lead_time,
                "target_delivery_date" => $request->target_delivery_date,
                "target_approval_date" => $request->target_approval_date,
                "status" => $request->status,
                "remarks" => $request->remarks,
                "filename" => $filename,
                "file_location" => $url,
            ];
            
            ProcurementMaterial::insert($data);
            $id = DB::getPdo()->lastInsertId(); 

        
            if (count($request->submission_date) > 0) {
                foreach ($request->submission_date as $item => $v) {
                    $data2 = [
                        "procurement_id" => $id,
                        "project_id" => Session::get('project_id'),
                        "user_id" => Auth::id(),
                        "submission_date" =>$request->submission_date[$item],
                        "actual_reply_date" =>$request->actual_reply_date[$item],
    
                    ];
                    ProcurementMaterialSub::insert($data2);
                }
            }
            return redirect()->back()->with("success", "Procurement Material created successfully.");
            
        }


        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function edit_procurement_material(Request $request){
       
        try {

            if(\Auth::user()->can('edit procurement material')){

                $project_id = $request["project_id"];

                $project_name = Project::select('project_name')
                ->where("id", $project_id)
                ->first();
                
                $data=ProcurementMaterial::where('project_id',$project_id)->where('user_id',Auth::id())->where('id',$request->id)->first();

                $pro_material_mutli = ProcurementMaterialSub::where('procurement_id','=',$data->id)->get();
        
                return view('diary.procurement_material.edit',compact('data','project_name','project_id','pro_material_mutli'));

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function update_procurement_material(Request $request){
       
        try {
           

            $fileNameToStore1='';
            $url='';

            if (!empty($request->filename)) {
                $filenameWithExt1 = $request->file("filename")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("filename")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/procurement_material";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"filename",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {

                    $url = $path["url"];
            
                } else {
        
                    return redirect()->back()->with("error", __($path["msg"]));
                }
                
            }else{
                $check_attach_file=ProcurementMaterial::select('filename','file_location')->where('id',$request->id)
                                                  ->where('project_id',Session::get('project_id'))->first();
                                                                     
                $fileNameToStore1=$check_attach_file->filename;
                $url=$check_attach_file->file_location;    
            }

            $data = [
                "project_id" => Session::get('project_id'),
                "user_id" => Auth::id(),
                "description" => $request->description,
                "ram_ref_no" => $request->ram_ref_no,
                "location" => $request->location,
                "supplier_name" => $request->supplier_name,
                "contact_person" => $request->contact_person,
                "mobile_hp_no" => $request->mobile_hp_no,
                "tel" => $request->tel,
                "fax" => $request->fax,
                "email" => $request->email,
                "lead_time" => $request->lead_time,
                "target_delivery_date" => $request->target_delivery_date,
                "target_approval_date" => $request->target_approval_date,
                "status" => $request->status,
                "remarks" => $request->remarks,
                "filename" => $fileNameToStore1,
                "file_location" => $url,
            ];
            
          

            ProcurementMaterial::where('id',$request->id)
                ->where('user_id',Auth::id())
                ->where('project_id',Session::get('project_id'))
                ->update($data);

            $in_id = ProcurementMaterial::where('user_id',Auth::id())
                                                ->where('project_id',Session::get('project_id'))
                                                ->where('id', '=', $request->id)
                                                ->get('id');

            $invoice_id = trim($in_id, '[{"id:"}]');

            $delete_invoice = ProcurementMaterialSub::where('procurement_id','=',$request->id)->delete();

                if(isset($request->submission_date)){

                
                    if (count($request->submission_date) > 0) {

                        foreach ($request->submission_date as $item => $v) {
                       
                    
                            if(isset($request->submission_date[$item])){
                                $set_submit_date=$request->submission_date[$item];
                            }else{
                                $set_submit_date=null;
                            }

                            if(isset($request->actual_reply_date[$item])){
                                $set_return_date=$request->actual_reply_date[$item];
                            }else{
                                $set_return_date=null;
                            }

                            $data2 = [
                                "procurement_id" => $invoice_id,
                                "project_id" => Session::get('project_id'),
                                "user_id" => Auth::id(),
                                "submission_date" =>$request->submission_date[$item],
                                "actual_reply_date" =>$request->actual_reply_date[$item],
            
                            ];
                            
                            
                        
                    
                            if ($request->increment < 0) {
                                ProcurementMaterialSub::insert($data2);
                            
                            } else {
                                ProcurementMaterialSub::insert($data2);
                            
                            }
                            
                        }
                    }

                }

            return redirect()->back()->with("success", __("Procurement Material updated successfully."));

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }


    public function delete_procurement_material(Request $request){
       
        try {

            if(\Auth::user()->can('delete procurement material')){
           
                ProcurementMaterial::where("id", $request->id)->where("project_id",Session::get('project_id'))->where("user_id",Auth::id())->delete();

                ProcurementMaterialSub::where("procurement_id", $request->id)->where("project_id",Session::get('project_id'))->where("user_id",Auth::id())->delete();

                return redirect()->back()->with("success", "Procurement Material deleted successfully.");

            }else{

                return redirect()->back()->with('error', __('Permission denied.'));

            }

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }


    public function ConstructionDrawingsedit(Request $request)
    {
        try {
              
            return view("diary.Construction_DrawingsList.edit");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConstructionDrawingscreate(Request $request)
    {
        try {
              
            return view("diary.Construction_DrawingsList.create");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function shopdrawing_listedit(Request $request)
    {
        try {
              
            return view("diary.shop_drawings.edit");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    public function shopdrawing_listcreate(Request $request)
    {
        try {
              
            return view("diary.shop_drawings.create");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    public function check_duplicate_diary_email(Request $request){
    
        try {

            $form_name  = $request->form_name;
            $check_name = $request->get_name;
            $get_id     = $request->get_id;
       
            if($form_name == "procurement_material"){
                if($get_id == null){
                    $get_check_val = ProcurementMaterial::where('email',$check_name)->first();
                }
                else{
                    $get_check_val = ProcurementMaterial::where('email',$check_name)->where('id','!=',$get_id)->first();
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
           
          } catch (Exception $e) {
    
              return $e->getMessage();
    
          }
        
       
    }
    
}
