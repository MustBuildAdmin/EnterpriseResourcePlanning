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
use File;
use DB;

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

            $dairy_data = ConcretePouring::where("project_id",$project_id)->get();

            $dairy_list = DairyList::select("id", "diary_name")
                        ->where("status", "0")
                        ->get();

            return view("diary.show",compact("project_id", "dairy_list", "dairy_data"));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function diary_create(Request $request)
    {
        try {

            $project = $request["project_id"];

            $id = $request["id"];
       

            $project_name = Project::select("project_name")
                ->where("id", $project)
                ->first();

          

            return view("diary.create",compact("project", "id","project_name"));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function dairy_update(Request $request)
    {
        try {

            $project = $request["project_id"];

            $id = $request["id"];
       

            if ($id != null) {
                $get_dairy_data = ConcretePouring::where("project_id", $project)
                    ->where("id", $id)
                    ->first();
            } else {
                $get_dairy_data = null;
            }

            $project_name = Project::select("project_name")
                ->where("id", $project)
                ->first();

          

            return view("diary.edit",compact("project", "id", "get_dairy_data", "project_name"));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function show_consultant_direction(Request $request)
    {
        try {

            $project = $request["project_id"];

            $project_name = Project::select("project_name")
                ->where("id", $project)
                ->first();

            return view("diary.consultant_direction",compact("project_name", "project"));

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function edit_consultant_direction(Request $request)
    {
        try {

            $project = $request["project_id"];

            $project_name = Project::select("project_name")
                ->where("id", $project)
                ->first();

            $consult_dir = ConsultantDirection::where("id", "=", $request->id)
                ->where("project_id", $request->project_id)
                ->first();

            $consult_dir_multi = ConsultantsDirectionMulti::where("consultant_id","=",$consult_dir->id)->get();

            $replier_date=$consult_dir_multi[0]->replier_date;

            return view("diary.edit_consultant_direction",compact("consult_dir","consult_dir_multi","project_name","project","replier_date"));

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
                "project_id" => $request->project_id,
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
                "project_id" => $request->project_id,
                "user_id" => Auth::id(),
                "diary_data" => json_encode($data),
                "status" => 0,
            ];


            ConcretePouring::where('id',$request->edit_id)
                            ->where('project_id',$request->project_id)
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

                $dairy_data = ConcretePouring::where("project_id",$request->project_id)->get();

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
                ->where("project_id", $project_id)
                ->get();

                $returnHTML = view("diary.show_consultant_direction",compact("project_id", "dairy_data"))->render();

            } else {
                $project_id = $request->project_id;
                $dairy_data = ConcretePouring::where("project_id",$request->project_id)->get();
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

    public function destroy(Request $request)
    {
        try {

            ConcretePouring::where("id", $request->id)->delete();

            return redirect()->back()->with("success", "Concrete pouring record deleted successfully.");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_concrete(Request $request)
    {
        try {

            ConsultantDirection::where("id", $request->id)->delete();

            ConsultantsDirectionMulti::where("consultant_id",$request->id)->delete();

            return redirect()->back()->with("success", "Consultants directions record deleted successfully.");

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
                    $data = [
                        "project_id" => $request->project_id,
                        "issued_by" => $request->issued_by,
                        "issued_date" => $request->issued_date,
                        "ad_ae_ref" => $request->ad_ae_ref,
                        "ad_ae_decs" => $request->ad_ae_decs,
                        "attach_file_name" => $filenameWithExt1,
                        "file_path" => "",
                    ];

                    ConsultantDirection::insert($data);
                    $id = DB::getPdo()->lastInsertId();

                    $initiator_file_name = [];
                    $initiator_file_folder = "diary/initiator";
                    if ($request->hasfile("initiator_file_name")) {
                        foreach (
                            $request->file("initiator_file_name")
                            as $file
                        ) {
                            $name = $file->getClientOriginalName();
                            $file->move(public_path("files"), $name);
                            $initiator_file_name[] = $name;
                        }
                    }

                    $replier_file_name = [];
                    $replier_file_folder = "diary/replier";
                    if ($request->hasfile("replier_file_name")) {
                        foreach (
                            $request->file("replier_file_name")
                            as $file1
                        ) {
                            $name1 = $file1->getClientOriginalName();
                            $file1->move(public_path("files/1"), $name1);
                            $replier_file_name[] = $name1;
                        }
                    }

                    if (count($request->initiator_reference) > 0) {
                        foreach ($request->initiator_reference as $item => $v) {
                            $data2 = [
                                "consultant_id" => $id,
                                "initiator_reference" =>$request->initiator_reference[$item],
                                "initiator_date" =>$request->initiator_date[$item],
                                "initiator_file_name" =>$initiator_file_name[$item],
                                "replier_reference" =>$request->replier_reference[$item],
                                "replier_date" => $request->replier_date[$item],
                                "replier_status" =>$request->replier_status[$item],
                                "replier_remark" =>$request->replier_remark[$item],
                                "replier_file_name" =>$replier_file_name[$item],
                            ];
                            ConsultantsDirectionMulti::insert($data2);
                        }
                    }

                    return redirect()->back()->with("success", __("dairy created successfully."));
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
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
                $filenameWithExt1 = $request
                    ->file("attach_file_name")
                    ->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request
                    ->file("attach_file_name")
                    ->getClientOriginalExtension();
                $fileNameToStore1 =
                    $filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/consultant_direction";

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = "";
                $path = Utility::upload_file($request,"attach_file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                    $data = [
                        "project_id" => $request->project_id,
                        "issued_by" => $request->issued_by,
                        "issued_date" => $request->issued_date,
                        "ad_ae_ref" => $request->ad_ae_ref,
                        "ad_ae_decs" => $request->ad_ae_decs,
                        "attach_file_name" => $filenameWithExt1,
                        "file_path" => "",
                    ];

                    ConsultantDirection::where("id", $request->id)->update($data);

                    $in_id = DB::table("consultant_directions")
                        ->where("id", "=", $request->id)
                        ->get("id");

                    $invoice_id = trim($in_id, '[{"id:"}]');

                    $initiator_file_name = [];
                    $initiator_file_folder = "diary/initiator";
                    if ($request->hasfile("initiator_file_name")) {
                        foreach ($request->file("initiator_file_name") as $file) {
                            $name = $file->getClientOriginalName();
                            $file->move(public_path("files"), $name);
                            $initiator_file_name[] = $name;
                        }
                    }

                    $replier_file_name = [];
                    $replier_file_folder = "diary/replier";
                    if ($request->hasfile("replier_file_name")) {
                        foreach ($request->file("replier_file_name") as $file1) {
                            $name1 = $file1->getClientOriginalName();
                            $file1->move(public_path("files/1"), $name1);
                            $replier_file_name[] = $name1;
                        }
                    }

                    $delete_invoice = ConsultantsDirectionMulti::where("consultant_id","=",$request->id)->delete();

                    if (count($request->initiator_reference) > 0) {
                        foreach ($request->initiator_reference as $item => $v) {
                            $data2 = [
                                "consultant_id" => $invoice_id,
                                "initiator_reference" =>$request->initiator_reference[$item],
                                "initiator_date" =>$request->initiator_date[$item],
                                "initiator_file_name" =>$initiator_file_name[$item],
                                "replier_reference" =>$request->replier_reference[$item],
                                "replier_date" => $request->replier_date[$item],
                                "replier_status" =>$request->replier_status[$item],
                                "replier_remark" =>$request->replier_remark[$item],
                                "replier_file_name" =>$replier_file_name[$item],
                                
                            ];
                            if ($request->increment < 0) {
                                ConsultantsDirectionMulti::insert($data2);
                            } else {
                                ConsultantsDirectionMulti::insert($data2);
                            }
                            // }
                        }
                    }

                    return redirect()
                        ->back()
                        ->with("success", __("diary created successfully."));
                } else {
                    return redirect()
                        ->back()
                        ->with("error", __($path["msg"]));
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
