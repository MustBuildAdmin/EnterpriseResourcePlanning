<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;
use App\Models\ConsultantDirection;
use App\Models\ConsultantsDirectionMulti;
use App\Models\RFIStatusSave;
use App\Models\RFIStatusSubSave;
use App\Models\ProjectSpecification;
use App\Models\ProcurementMaterial;
use App\Models\ProcurementMaterialSub;
use App\Models\SiteReport;
use App\Models\SiteReportSub;
use App\Models\Vochange;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Exception;
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

    public function show_consultant_direction(Request $request)
    {
        try {
            if (Session::has("project_id") == null) {
                return redirect()
                    ->route("construction_main")
                    ->with("error", __("Project Session Expired."));
            }

            if (\Auth::user()->can("manage directions")) {
                $projectid = Session::get("project_id");

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                $dairydata = ConsultantDirection::select(
                    "consultant_directions.id",
                    "consultant_directions.issued_by",
                    "consultant_directions.issued_date",
                    "consultant_directions.ad_ae_ref",
                    "consultant_directions.ad_ae_decs",
                    "consultant_directions.attach_file_name",
                    "consultants_direction_multi.initiator_reference",
                    "consultants_direction_multi.initiator_date"
                )
                    ->leftJoin(
                        "consultants_direction_multi",
                        "consultants_direction_multi.consultant_id","=",
                        "consultant_directions.id"
                    )
                    ->where(
                        "consultant_directions.project_id",
                         Session::get("project_id")
                    )
                    ->where("consultant_directions.user_id", $userid)
                    ->orderBy("consultant_directions.id", "ASC")
                    ->groupBy("consultant_directions.id")
                    ->get();

                return view("diary.consultant_direction.index",compact("projectid", "dairydata", "projectname")
                );
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function add_consultant_direction(Request $request)
    {
        try {
            if (\Auth::user()->can("create directions")) {
                $project = Session::get("project_id");

                $projectname = Project::select("project_name")
                    ->where("id", $project)
                    ->first();

                return view("diary.consultant_direction.create",
                    compact("projectname", "project")
                );
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_consultant_direction(Request $request)
    {
        try {
            unset($request["_token"]);

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            if (!empty($request->attach_file_name)) {
                $filenameWithExt1 = $request->file("attach_file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attach_file_name")->getClientOriginalExtension();
                $fileNameToStore1 =
                $filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/consultant_direction";

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
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
                $data = [
                    "user_id" => $userid,
                    "project_id" => $request->project_id,
                    "issued_by" => $request->issued_by,
                    "issued_date" => $request->issued_date,
                    "ad_ae_ref" => $request->ad_ae_ref,
                    "ad_ae_decs" => $request->ad_ae_decs,
                    "attach_file_name" => $filenameWithExt1,
                    "file_path" => $url,
                ];

                ConsultantDirection::insert($data);
                $id = DB::connection()->getPdo()->lastInsertId();

                $initiatorfilename = [];
                $initiatorfilefolder = "diary/initiator";
                if ($request->hasfile("initiator_file_name")) {
                    foreach ($request->file("initiator_file_name") as $file) {
                        $name = $file->getClientOriginalName();
                        $file->move(public_path("files"), $name);
                        $initiatorfilename[] = $name;
                    }
                }


                if (count($request->initiator_reference) > 0) {
                    foreach ($request->initiator_reference as $item => $v) {
                        if (isset($request->initiator_reference[$item])) {
                            $setinitiatorreference =$request->initiator_reference[$item];
                        } else {
                            $setinitiatorreference = null;
                        }

                        if (isset($request->initiator_date[$item])) {
                            $setinitiatordate =$request->initiator_date[$item];
                        } else {
                            $setinitiatordate = null;
                        }

                        if (isset($initiatorfilename[$item])) {
                            $setinitiatorfilename =$initiatorfilename[$item];
                        } else {
                            $setinitiatorfilename = null;
                        }

                        if (isset($request->replier_status[$item])) {
                            $setreplierstatus =$request->replier_status[$item];
                        } else {
                            $setreplierstatus = null;
                        }

                        if (isset($request->replier_remark[$item])) {
                            $setreplierremark =$request->replier_remark[$item];
                        } else {
                            $setreplierremark = null;
                        }


                        $data2 = [
                            "consultant_id" => $id,
                            "initiator_reference" => $setinitiatorreference,
                            "initiator_date" => $setinitiatordate,
                            "initiator_file_name" => $setinitiatorfilename,
                            "replier_status" => $setreplierstatus,
                            "replier_remark" => $setreplierremark,
                        ];

                        ConsultantsDirectionMulti::insert($data2);
                    }
                }

                return redirect()->back()->with("success",__("Consultants directions summary created successfully.")
                    );
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_consultant_direction(Request $request)
    {
        try {
            unset($request["_token"]);

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            if (!empty($request->attach_file_name)) {
                $filenameWithExt1 = $request->file("attach_file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attach_file_name")->getClientOriginalExtension();
                $fileNameToStore1 =
                $filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/consultant_direction";

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"attach_file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
            } else {
                $checkattachfile = ConsultantDirection::select("attach_file_name","file_path")
                                    ->where("id", $request->id)
                                    ->where("user_id", $userid)
                                    ->where("project_id", Session::get("project_id"))
                                    ->first();

                $filenameWithExt1 = $checkattachfile->attach_file_name;
                $url = $checkattachfile->file_path;
            }

            $data = [
                "user_id" => $userid,
                "project_id" => $request->project_id,
                "issued_by" => $request->issued_by,
                "issued_date" => $request->issued_date,
                "ad_ae_ref" => $request->ad_ae_ref,
                "ad_ae_decs" => $request->ad_ae_decs,
                "attach_file_name" => $filenameWithExt1,
                "file_path" => $url,
            ];

            ConsultantDirection::where("project_id", Session::get("project_id"))
                ->where("user_id", $userid)
                ->where("id", $request->id)
                ->update($data);

            $inid = DB::table("consultant_directions")
                ->where("id", "=", $request->id)
                ->where("user_id", $userid)
                ->where("project_id", Session::get("project_id"))
                ->get("id");

            $invoiceid = trim($inid, '[{"id:"}]');

            $initiatorfilename = [];

            if (!empty($request->initiator_file_name)) {
                if ($request->hasfile("initiator_file_name")) {
                    foreach ($request->file("initiator_file_name") as $file) {
                        $name = $file->getClientOriginalName();
                        $file->move(public_path("files"), $name);
                        array_push($initiator_file_name, $name);
                    }
                    $checkinitiatorfile = ConsultantsDirectionMulti::select("initiator_file_name")
                        ->where("consultant_id", $request->id)
                        ->get();
                    if (count($checkinitiatorfile) != 0) {
                        foreach ($checkinitiatorfile as $file) {
                            array_push(
                                $initiatorfilename,
                                $file->initiator_file_name
                            );
                        }
                    }
                }
            } else {
                $checkinitiatorfile = ConsultantsDirectionMulti::select("initiator_file_name")
                    ->where("consultant_id", $request->id)
                    ->get();
                if (count($checkinitiatorfile) != 0) {
                    foreach ($checkinitiatorfile as $file) {
                        $initiator_file_name[] = $file->initiator_file_name;
                    }
                }
            }

           
            ConsultantsDirectionMulti::where("consultant_id","=",$request->id)->delete();

            if (count($request->initiator_reference) >= 0) {
                foreach ($request->initiator_reference as $item => $v) {
                   
                    if (isset($request->initiator_reference[$item])) {
                        $setinitiatorreference =
                            $request->initiator_reference[$item];
                    } else {
                        $setinitiatorreference = null;
                    }

                    if (isset($request->initiator_date[$item])) {
                        $setinitiatordate = $request->initiator_date[$item];
                    } else {
                        $setinitiatordate = null;
                    }

                    if (isset($initiator_file_name[$item])) {
                        $setinitiatorfilename = $initiator_file_name[$item];
                    } else {
                        $setinitiatorfilename = null;
                    }

                    if (isset($request->replier_status[$item])) {
                        $setreplierstatus = $request->replier_status[$item];
                    } else {
                        $setreplierstatus = null;
                    }

                    if (isset($request->replier_remark[$item])) {
                        $setreplierremark = $request->replier_remark[$item];
                    } else {
                        $setreplierremark = null;
                    }


                    $data2 = [
                        "consultant_id" => $invoiceid,
                        "initiator_reference" => $setinitiatorreference,
                        "initiator_date" => $setinitiatordate,
                        "initiator_file_name" => $setinitiatorfilename,
                        "replier_status" => $setreplierstatus,
                        "replier_remark" => $setreplierremark,
                    ];

                   
                    ConsultantsDirectionMulti::insert($data2);
                    
                    
                }
            }

            return redirect()->back()->with("success",__("Consultants directions summary updated successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    public function edit_consultant_direction(Request $request)
    {
        try {
            if (\Auth::user()->can("edit directions")) {
                $project = Session::get("project_id");

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $projectname = Project::select("project_name")
                    ->where("id", $project)
                    ->first();

                $consultdir = ConsultantDirection::where("id","=",$request->id)
                    ->where("project_id", Session::get("project_id"))
                    ->where("user_id", $userid)
                    ->first();

                $consultdirmulti = ConsultantsDirectionMulti::where("consultant_id","=",$consultdir->id)->get();

                $initiatordate = $consultdirmulti[0]->initiator_date;

                return view("diary.consultant_direction.edit",compact("consultdir","consultdirmulti",
                       "projectname","project","initiatordate"
                )
                );
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_consultant_direction(Request $request)
    {
        try {
            if (\Auth::user()->can("delete directions")) {
                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                ConsultantDirection::where("id", $request->id)
                    ->where("user_id", $userid)
                    ->where("project_id", Session::get("project_id"))
                    ->delete();

                ConsultantsDirectionMulti::where("consultant_id",$request->id)->delete();

                return redirect()->back()->with("success","Consultants directions record deleted successfully.");
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

   
    
    public function rfi_show_info()
    {
        try {
            if (Session::has("project_id") == null) {
                return redirect()
                    ->route("construction_main")
                    ->with("error", __("Project Session Expired."));
            }

            if (\Auth::user()->can("manage RFI")) {
                $projectid = Session::get("project_id");

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $dairydata = RFIStatusSave::where("user_id", $userid)
                    ->where("project_id", Session::get("project_id"))
                    ->orderBy("id", "asc")
                    ->get();

                return view("diary.rfi.index",compact("projectid", "dairydata"));
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission denied."));
            }
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    public function rfi_info_status(Request $request)
    {
        try {
            if (\Auth::user()->can("create RFI")) {
                $project = Session::get("project_id");
                $projectname = Project::select("project_name")
                    ->where("id", $project)
                    ->first();

                return view("diary.rfi.create",compact("project", "projectname"));
            } else {
                return redirect()
                    ->back()
                    ->with("error", __("Permission denied."));
            }
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    public function rfi_info_main_save(Request $request)
    {
        try {
            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            $data = [
                "user_id" => $userid,
                "project_id" => Session::get("project_id"),
                "contractor_name" => $request->contractor_name,
                "consulatant_data" => json_encode($request->rfijson),
            ];

            RFIStatusSave::insert($data);

            return redirect()->back()->with("success", __("RFI created successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit_rfi_info_status(Request $request)
    {
        try {
            if (\Auth::user()->can("edit RFI")) {
                $projectid = Session::get("project_id");

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $project = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                $getdairy = RFIStatusSave::where("project_id", $projectid)
                    ->where("user_id", $userid)
                    ->where("id", $request->id)
                    ->first();
                $contractor = RFIStatusSave::where("user_id", "=", $userid)
                    ->where("id", $request->id)
                    ->where("project_id", $projectid)
                    ->first();

                if ($contractor != null) {
                    $contractorname = json_decode($contractor);
                } else {
                    $contractorname = [];
                }

                $getsubtable = RFIStatusSubSave::where("project_id",$projectid)
                    ->where("user_id", $userid)
                    ->where("rfi_id", $request->id)
                    ->first();

                $getcontent = RFIStatusSubSave::where("project_id",$projectid)
                    ->where("user_id", $userid)
                    ->where("rfi_id", $request->id)
                    ->orderBy("id", "ASC")
                    ->get();

                return view("diary.rfi.edit",compact("getdairy","project","projectid","contractorname",
                                                    "contractor","getsubtable","getcontent")
                );
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_rfi_info_status(Request $request)
    {
        try {
            if ($request->select_the_consultants != null) {
                $selecttheconsultantvalue = implode(",",array_filter($request->select_the_consultants));
            } else {
                $selecttheconsultantvalue = null;
            }

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            if (!empty($request->attachment_one)) {
                $filenameWithExt1 = $request->file("attachment_one")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_one")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/RFI";

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"attachment_one",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
            } else {
                $checkattachfile = RFIStatusSave::select("attachment_one","attachment_one_path")
                    ->where("id", $request->id)
                    ->where("user_id", $userid)
                    ->where("project_id", $request->project_id)
                    ->first();

                $filenameWithExt1 = $checkattachfile->attachment_one ?? "";
                $url = $checkattachfile->attachment_one_path ?? "";
            }

            $saverfione = [
                "user_id" => $userid,
                "project_id" => Session::get("project_id"),
                "contractor_name" => $request->contractor_name,
                "consulatant_data" => json_encode($request->data),
                "reference_no" => $request->reference_no,
                "requested_date" => $request->requested_date,
                "required_date" => $request->required_date,
                "priority" => $request->priority,
                "cost_impact" => $request->cost_impact,
                "time_impact" => $request->time_impact,
                "description" => $request->description,
                "select_the_consultants" => $selecttheconsultantvalue,
                "attachment_one" => $filenameWithExt1,
                "attachment_one_path" => $url,
            ];

            RFIStatusSave::where("id", $request->edit_id)
                ->where("user_id", $userid)
                ->where("project_id", Session::get("project_id"))
                ->update($saverfione);

            $inid = DB::table("dr_rfi_main_sub_save")
                ->where("id", "=", $request->edit_id)
                ->where("user_id", $userid)
                ->where("project_id", Session::get("project_id"))
                ->get("id");

            $lastid = trim($inid, '[{"id:"}]');

            RFIStatusSubSave::where("rfi_id","=",$request->edit_id)
                ->where("user_id", $userid)
                ->where("project_id", Session::get("project_id"))
                ->delete();

            for ($i = 1; $i <= $request->multi_total_count; $i++) {
                $nameofconsulatantvar = "name_of_consulatant" . $i;
                $replieddatevar = "replied_date" . $i;
                $statusvar = "status" . $i;
                $remarksvar = "remarks" . $i;
                $filevar = "attachments_two" . $i;

                if (isset($request->$replieddatevar)) {
                    $nameofconsulatantset =$request->$nameofconsulatantvar;
                    $replieddateset = $request->$replieddatevar;
                    $statusset = $request->$statusvar;
                    $remarksset = $request->$remarksvar;
                    $fileset = $request->$filevar;

                    if ($nameofconsulatantset != null) {
                        $selectnameconsultant = implode(",",array_filter($nameofconsulatantset));
                    } else {
                        $selectnameconsultant = null;
                    }

                    if (!empty($fileset)) {
                        $filenameWithExt = $request->file($filevar)->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
                        $extension = $request->file($filevar)->getClientOriginalExtension();
                        $fileNameToStore =
                        $filename . "_" . time() . "." . $extension;

                        $dir = "uploads/RFI";

                        $imagepath = $dir . $filenameWithExt;
                        if (\File::exists($imagepath)) {
                            \File::delete($imagepath);
                        }
                        $url1 = "";
                        $path1 = Utility::upload_file($request,$filevar,$fileNameToStore,$dir,[]);

                        if ($path1["flag"] == 1) {
                            $url1 = $path1["url"];
                        } else {
                            return redirect()->back()->with("error", __($path1["msg"]));
                        }
                    } else {
                        $checkattachfile = RFIStatusSubSave::select("attachments_two","attachments_two_path")
                            ->where("id", $request->edit_id)
                            ->where("user_id", $userid)
                            ->where("project_id", $request->project_id)
                            ->first();

                        $filenameWithExt =$checkattachfile->attachments_two ?? "";
                        $url1 = $checkattachfile->attachments_two_path ?? "";
                    }

                    $multiinsertarray = [
                        "user_id" => $userid,
                        "project_id" => Session::get("project_id"),
                        "rfi_id" => $lastid,
                        "multi_total_count" => $request->multi_total_count,
                        "name_of_consultant" => $selectnameconsultant,
                        "replied_date" => $replieddateset,
                        "status" => $statusset,
                        "remarks" => $remarksset,
                        "attachments_two" => $filenameWithExt,
                        "attachments_two_path" => $url1,
                    ];

                    RFIStatusSubSave::insert($multiinsertarray);
                }
            }

            return redirect()->back()->with("success", __("RFI updated successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_name_of_consultant(Request $request)
    {
        try {
            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            $getdairy = RFIStatusSave::where(
                "project_id",
                Session::get("project_id")
            )
                ->where("user_id", $userid)
                ->where("id", $request->id)
                ->first();
            $decode = json_decode($getdairy->consulatant_data);
            $html = "";

            foreach ($decode as $conkey => $con) {
                $html .= '<option value="' . $con . '" >' . $con . "</option>";
            }

            return $html;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_rfi_status(Request $request)
    {
        try {
            if (\Auth::user()->can("delete RFI")) {
                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                RFIStatusSave::where("id", $request->id)
                    ->where("project_id", Session::get("project_id"))
                    ->where("user_id", $userid)
                    ->delete();

                RFIStatusSubSave::where("rfi_id", $request->id)->delete();

                return redirect()->back()->with("success", "RFI record deleted successfully.");
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function show_project_specification(Request $request)
    {
        try {
            if (Session::has("project_id") == null) {
                return redirect()
                    ->route("construction_main")
                    ->with("error", __("Project Session Expired."));
            }

            if (\Auth::user()->can("manage project specification")) {
                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $projectid = Session::get("project_id");
                $dairydata = ProjectSpecification::where("user_id", $userid)
                    ->where("project_id", $projectid)
                    ->orderBy("id", "ASC")
                    ->get();
                return view("diary.project_specification.index",compact("projectid", "dairydata"));
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function add_project_specification(Request $request)
    {
        try {
            if (\Auth::user()->can("create project specification")) {
                $projectid = Session::get("project_id");

                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                return view("diary.project_specification.create",compact("projectname", "projectid"));
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_project_specification(Request $request)
    {
        try {
            $fileNameToStore1 = "";
           

            if (!empty($request->attachment_file_name)) {
                $filenameWithExt1 = $request->file("attachment_file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/project_direction_summary";

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"attachment_file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
            }

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            $savedata = [
                "user_id" => $userid,
                "project_id" => $request->project_id,
                "reference_no" => $request->reference_no,
                "description" => $request->description,
                "location" => $request->location,
                "drawing_reference" => $request->drawing_reference,
                "remarks" => $request->remarks,
                "attachment_file_name" => $fileNameToStore1,
            ];

            ProjectSpecification::insert($savedata);

            return redirect()->back()->with("success",__("Project specification summary created Successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit_project_specification(Request $request)
    {
        try {
            if (\Auth::user()->can("edit project specification")) {
                $projectid = Session::get("project_id");

                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $data = ProjectSpecification::where("project_id", $projectid)
                    ->where("id", $request->id)
                    ->where("user_id", $userid)
                    ->first();

                return view("diary.project_specification.edit",compact("data", "projectname", "projectid"));
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_project_specification(Request $request)
    {
        try {

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            if (!empty($request->attachment_file_name)) {
                $filenameWithExt1 = $request->file("attachment_file_name")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_file_name")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/project_direction_summary";

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }

                $path = Utility::upload_file($request,"attachment_file_name",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
            } else {
              
                $checkattachfile = ProjectSpecification::select("attachment_file_name")
                    ->where("id", $request->id)
                    ->where("user_id", $userid)
                    ->where("project_id", Session::get("project_id"))
                    ->first();

                $filenameWithExt1 = $checkattachfile->attachment_file_name;
            }
          

            $updatedata = [
                "user_id" => $userid,
                "project_id" =>Session::get("project_id"),
                "reference_no" => $request->reference_no,
                "description" => $request->description,
                "location" => $request->location,
                "drawing_reference" => $request->drawing_reference,
                "remarks" => $request->remarks,
                "attachment_file_name" => $filenameWithExt1,
            ];

            ProjectSpecification::where("id", $request->id)
                ->where("user_id", $userid)
                ->where("project_id", Session::get("project_id"))
                ->update($updatedata);

            return redirect()->back()->with("success",__("Project specification summary updated Successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_project_specification(Request $request)
    {
        try {
            if (\Auth::user()->can("delete project specification")) {
                $projectid = Session::get("project_id");

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                ProjectSpecification::where("id", $request->id)
                    ->where("project_id", $projectid)
                    ->where("user_id", $userid)
                    ->delete();

                return redirect()->back()->with("success","Project specification summary record deleted successfully.");
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function variation_scope_change(Request $request)
    {
        try {
            if (Session::has("project_id") == null) {
                return redirect()->route("construction_main")->with("error", __("Project Session Expired."));
            }

            if (\Auth::user()->can("manage vochange")) {
                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $projectid = Session::get("project_id");

                $dairydata = DB::table("variation_scope")
                    ->where("user_id", $userid)
                    ->where("project_id", Session::get("project_id"))
                    ->orderBy("id", "ASC")
                    ->get();

                return view("diary.vo_sca_change_order.index",compact("projectid", "dairydata"));
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function add_variation_scope_change(Request $request)
    {
        try {
            if (\Auth::user()->can("create vochange")) {
                $project = Session::get("project_id");
                $projectname = Project::select("project_name")
                    ->where("id", $project)
                    ->first();

                return view("diary.vo_sca_change_order.create",compact("project", "projectname"));
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit_variation_scope_change(Request $request)
    {
        try {
            if (\Auth::user()->can("edit vochange")) {
                $project = Session::get("project_id");

                $id = $request["id"];

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                if ($id != null) {
                    $getdairydata = DB::table("variation_scope")
                        ->where("project_id", $project)
                        ->where("user_id", $userid)
                        ->where("project_id", $project)
                        ->where("id", $id)
                        ->first();
                } else {
                    $getdairydata = null;
                }

                $projectname = Project::select("project_name")
                    ->where("id", $project)
                    ->first();

                return view("diary.vo_sca_change_order.edit",compact("project", "id", "getdairydata", "projectname")
                );
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_variation_scope_change(Request $request)
    {
        try {
            unset($request["_token"]);

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

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

            $fileNameToStore1 = "";
          

            if (!empty($request->attachment_file)) {
                $filenameWithExt1 = $request->file("attachment_file")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_file")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/variation_scope";

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"attachment_file",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
            }

            $alldata = [
                "attachment_file" => $fileNameToStore1,
                "project_id" => Session::get("project_id"),
                "user_id" => $userid,
                "data" => json_encode($data),
                "status" => 0,
            ];

            DB::table("variation_scope")->insert($alldata);

            return redirect()->back()->with("success", __("Vo/Change Order created successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_variation_scope_change(Request $request)
    {
        try {
            unset($request["_token"]);

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

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

            $fileNameToStore1 = "";
         

            if (!empty($request->attachment_file)) {
                $filenameWithExt1 = $request->file("attachment_file")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("attachment_file")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/variation_scope";

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"attachment_file",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
            } else {
                $checkfilename = DB::table("variation_scope")
                    ->select("attachment_file")
                    ->where("id", $request->id)
                    ->where("user_id", $userid)
                    ->where("project_id", Session::get("project_id"))
                    ->first();
                $fileNameToStore1 = $checkfilename->attachment_file;
            }

            $alldata = [
                "attachment_file" => $fileNameToStore1,
                "project_id" => Session::get("project_id"),
                "user_id" => $userid,
                "data" => json_encode($data),
                "status" => 0,
            ];

            DB::table("variation_scope")
                ->where("id", $request->id)
                ->where("project_id", Session::get("project_id"))
                ->where("user_id", $userid)
                ->update($alldata);

            return redirect()->back()->with("success", __("Vo/Change Order created successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_variation_scope_change(Request $request)
    {
        try {
            if (\Auth::user()->can("delete vochange")) {
                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                DB::table("variation_scope")
                    ->where("id", $request->id)
                    ->where("project_id", Session::get("project_id"))
                    ->where("user_id", $userid)
                    ->delete();

                return redirect()->back()->with("success","Project specification summary record deleted successfully.");
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function drawing_list(Request $request)
    {
        try {
            $projectid = Session::get("project_id");
            return view("diary.drawings_list.index", compact("projectid"));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function daily_reportscreate(Request $request)
    {
        try {
            if (Session::has("project_id") == null) {
                return redirect()->route("construction_main")->with("error", __("Project Session Expired."));
            }

            if (\Auth::user()->can("create site reports")) {
                $projectid = Session::get("project_id");

                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                return view("diary.daily_reports.create",compact("projectname"));
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function daily_reportsedit(Request $request)
    {
        try {
            if (Session::has("project_id") == null) {
                return redirect()->route("construction_main")->with("error", __("Project Session Expired."));
            }

            if (\Auth::user()->can("edit site reports")) {
                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $projectid = Session::get("project_id");

                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                $decodeid = Crypt::decryptString($request->id);
                $editid = trim($decodeid, '[{"id:;"}]');

                $data = SiteReport::select(
                    "dr_site_reports.*",
                        \DB::raw(
                            "group_concat(file.file_name) as file_name,group_concat(file.id) as file_id"
                        )
                    )
                    ->leftjoin(
                        "dr_site_multi_files as file",
                        \DB::raw(
                            "FIND_IN_SET(file.id,dr_site_reports.file_id)"
                        ),
                        ">",
                        \DB::raw("'0'")
                    )
                    ->where("dr_site_reports.id", $editid)
                    ->where(
                        "dr_site_reports.project_id",
                        Session::get("project_id")
                    )
                    ->where("dr_site_reports.user_id", $userid)
                    ->groupBy("dr_site_reports.id")
                    ->first();

                $datasub = SiteReportSub::where("site_id", "=", $editid)
                    ->where("project_id", Session::get("project_id"))
                    ->where("user_id", $userid)
                    ->where("type", "contractors_personnel")
                    ->get();

                $datasub1 = SiteReportSub::where("site_id", "=", $editid)
                    ->where("project_id", Session::get("project_id"))
                    ->where("user_id", $userid)
                    ->where("type", "sub_contractors")
                    ->get();

                $datasub2 = SiteReportSub::where("site_id", "=", $editid)
                    ->where("project_id", Session::get("project_id"))
                    ->where("user_id", $userid)
                    ->where("type", "major_equipment_on_project")
                    ->get();

                return view("diary.daily_reports.edit",
                    compact(
                        "projectid",
                        "data",
                        "datasub",
                        "datasub1",
                        "datasub2",
                        "projectname"
                    )
                );
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function daily_reports(Request $request)
    {
        try {
            if (Session::has("project_id") == null) {
                return redirect()
                    ->route("construction_main")
                    ->with("error", __("Project Session Expired."));
            }

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }
            $projectid = Session::get("project_id");

            $data = SiteReport::where("project_id", Session::get("project_id"))
                ->where("user_id", $userid)
                ->get();

            return view("diary.daily_reports.index",compact("data", "projectid"));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function procurement_material()
    {
        try {
            if (Session::has("project_id") == null) {
                return redirect()
                    ->route("construction_main")
                    ->with("error", __("Project Session Expired."));
            }

            if (\Auth::user()->can("manage procurement material")) {
                $projectid = Session::get("project_id");
                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $dairydata = ProcurementMaterial::where("project_id",$projectid)
                            ->where("user_id", $userid)
                            ->get();

                return view("diary.procurement_material.index",compact("projectid", "projectname", "dairydata"));

            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function add_procurement_material()
    {
        try {
            if (\Auth::user()->can("create procurement material")) {
                $projectid = Session::get("project_id");
                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                return view("diary.procurement_material.create",compact("projectid", "projectname"));
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_procurement_material(Request $request)
    {
        try {
            $fileNameToStore = "";
        

            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            if (!empty($request->filename)) {
                $filenameWithExt = $request->file("filename")->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file("filename")->getClientOriginalExtension();
                $fileNameToStore = $filename . "_" . time() . "." . $extension;

                $dir = "uploads/procurement_material";

                $imagepath = $dir . $filenameWithExt;

                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"filename",$fileNameToStore,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }

                $data = [
                    "project_id" => Session::get("project_id"),
                    "user_id" => $userid,
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
                $id = DB::connection()->getPdo()->lastInsertId();

                if (count($request->submission_date) > 0) {
                    foreach ($request->submission_date as $item => $v) {
                        $data2 = [
                            "procurement_id" => $id,
                            "project_id" => Session::get("project_id"),
                            "user_id" => $userid,
                            "submission_date" =>$request->submission_date[$item],
                            "actual_reply_date" =>$request->actual_reply_date[$item],
                            "no_of_submission" =>$request->no_of_submission[$item],
                        ];
                        ProcurementMaterialSub::insert($data2);
                    }
                }
                return redirect()->back()->with("success","Procurement Material created successfully.");
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit_procurement_material(Request $request)
    {
        try {
            if (\Auth::user()->can("edit procurement material")) {
                $projectid = Session::get("project_id");

                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                $data = ProcurementMaterial::where("project_id", $projectid)
                    ->where("user_id", $userid)
                    ->where("id", $request->id)
                    ->first();

                $promaterialmutli = ProcurementMaterialSub::where("procurement_id","=",$data->id)->get();

                return view("diary.procurement_material.edit",
                    compact(
                        "data",
                        "projectname",
                        "projectid",
                        "promaterialmutli"
                    )
                );
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_procurement_material(Request $request)
    {
        try {
            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            $fileNameToStore1 = "";

            if (!empty($request->filename)) {
                $filenameWithExt1 = $request->file("filename")->getClientOriginalName();
                $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1 = $request->file("filename")->getClientOriginalExtension();
                $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;

                $dir = "uploads/procurement_material";

                $imagepath = $dir . $filenameWithExt1;
                if (\File::exists($imagepath)) {
                    \File::delete($imagepath);
                }
                $url = "";
                $path = Utility::upload_file($request,"filename",$fileNameToStore1,$dir,[]);

                if ($path["flag"] == 1) {
                    $url = $path["url"];
                } else {
                    return redirect()->back()->with("error", __($path["msg"]));
                }
            } else {
                $checkattachfile = ProcurementMaterial::select("filename","file_location")
                    ->where("id", $request->id)
                    ->where("user_id", $userid)
                    ->where("project_id", Session::get("project_id"))
                    ->first();

                $fileNameToStore1 = $checkattachfile->filename;
                $url = $checkattachfile->file_location;
            }

            $data = [
                "project_id" => Session::get("project_id"),
                "user_id" => $userid,
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

            ProcurementMaterial::where("id", $request->id)
                ->where("user_id", $userid)
                ->where("project_id", Session::get("project_id"))
                ->update($data);

            $inid = ProcurementMaterial::where("user_id", $userid)
                ->where("project_id", Session::get("project_id"))
                ->where("id", "=", $request->id)
                ->get("id");

            $invoice = trim($inid, '[{"id:"}]');

            ProcurementMaterialSub::where("procurement_id","=",$request->id)->delete();

            if (isset($request->submission_date)) {
                if (count($request->submission_date) > 0) {
                    foreach ($request->submission_date as $item => $v) {
                        if (isset($request->submission_date[$item])) {
                            $setsubmitdate = $request->submission_date[$item];
                        } else {
                            $setsubmitdate = null;
                        }

                        if (isset($request->actual_reply_date[$item])) {
                            $setreturndate =$request->actual_reply_date[$item];
                        } else {
                            $setreturndate = null;
                        }

                        $data2 = [
                            "procurement_id" => $invoice,
                            "project_id" => Session::get("project_id"),
                            "user_id" => $userid,
                            "submission_date" =>$setsubmitdate,
                            "actual_reply_date" =>$setreturndate,
                            "no_of_submission" =>$request->no_of_submission[$item],
                        ];

                        
                        ProcurementMaterialSub::insert($data2);
                        
                    }
                }
            }

            return redirect()->back()->with("success",__("Procurement Material updated successfully."));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_procurement_material(Request $request)
    {
        try {
            if (\Auth::user()->can("delete procurement material")) {
                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                ProcurementMaterial::where("id", $request->id)
                    ->where("project_id", Session::get("project_id"))
                    ->where("user_id", $userid)
                    ->delete();

                ProcurementMaterialSub::where("procurement_id", $request->id)
                    ->where("project_id", Session::get("project_id"))
                    ->where("user_id", $userid)
                    ->delete();

                return redirect()->back()->with("success","Procurement Material deleted successfully.");
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
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

    public function check_duplicate_diary_email(Request $request)
    {
        try {
            $formname = $request->form_name;
            $checkname = $request->get_name;
            $getid = $request->get_id;

            if ($formname == "procurement_material") {
                if ($getid == null) {
                    $getcheckval = ProcurementMaterial::where("email",$checkname)->first();
                } else {
                    $getcheckval = ProcurementMaterial::where("email",$checkname)
                        ->where("id", "!=", $getid)
                        ->first();
                }
            } else {
                $getcheckval = "Not Empty";
            }

            if ($getcheckval == null) {
                return 1; //Success
            } else {
                return 0; //Error
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_site_reports(Request $request)
    {
        try {
            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            if ($request->weather != null) {
                $selectweather = implode(",", array_filter($request->weather));
            } else {
                $selectweather = null;
            }

            if ($request->site_conditions != null) {
                $selectsiteconditions = implode(",",array_filter($request->site_conditions));
            } else {
                $selectsiteconditions = null;
            }

            $fileidarray = [];
            if ($request->attachements != null) {
                foreach ($request->attachements as $file_req) {
                    $filenameWithExt1 = $file_req->getClientOriginalName();
                    $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                    $extension1 = $file_req->getClientOriginalExtension();
                    $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;
                    $dir = "uploads/site_reports/";
                    $imagepath = $dir . $filenameWithExt1;

                    if (\File::exists($imagepath)) {
                        \File::delete($imagepath);
                    }

                    $path = Utility::multi_upload_file($file_req,"file_req",$fileNameToStore1,$dir,[]);

                    if ($path["flag"] == 1) {
                        $url = $path["url"];

                        $fileinsert = [
                            "file_name" => $fileNameToStore1,
                            "file_location" => $url,
                        ];

                        $fileinsertid = DB::table("dr_site_multi_files")->insertGetId($fileinsert);
                        $fileidarray[] = $fileinsertid;
                    } else {
                        return redirect()->back()->with("error", __($path["msg"]));
                    }
                }
                $implodefileid =count($fileidarray)!= 0 ? implode(",", $fileidarray): 0;
            } else {
                $implodefileid = 0;
            }

            $data = [
                "project_id" => Session::get("project_id"),
                "user_id" => $userid,
                "contractor_name" => $request->contractor_name,
                "con_date" => $request->con_date,
                "con_day" => $request->con_day,
                "weather" => $selectweather,
                "site_conditions" => $selectsiteconditions,
                "temperature" => $request->temperature,
                "min_input" => $request->min_input,
                "total_in_power_one" => $request->total_in_power_one,
                "total_di_power_one" => $request->total_di_power_one,
                "total_con_power_one" => $request->total_con_power_one,
                "total_in_power_two" => $request->total_in_power_two,
                "total_di_power_two" => $request->total_di_power_two,
                "total_con_power_two" => $request->total_con_power_two,
                "degree" => $request->degree,
                "remarks" => $request->remarks,
                "prepared_by" => $request->prepared_by,
                "title" => $request->title,
                "file_id" => $implodefileid,
            ];

            SiteReport::insert($data);

            $id =  DB::connection()->getPdo()->lastInsertId();

            if (isset($request->first_position)) {
                if (count($request->first_position) > 0) {
                    foreach ($request->first_position as $item => $v) {
                        if (isset($request->first_position[$item])) {
                            $setfirstposition =$request->first_position[$item];
                        } else {
                            $setfirstposition = null;
                        }

                        if (isset($request->first_person[$item])) {
                            $setfirstperson = $request->first_person[$item];
                        } else {
                            $setfirstperson = null;
                        }

                        if (isset($request->first_option[$item])) {
                            $setfirstoption = $request->first_option[$item];
                        } else {
                            $setfirstoption = null;
                        }

                        $datafirst = [
                            "site_id" => $id,
                            "type" => "contractors_personnel",
                            "project_id" => Session::get("project_id"),
                            "user_id" => $userid,
                            "position_name" => $setfirstposition,
                            "no_of_persons" => $setfirstperson,
                            "option_method" => $setfirstoption,
                        ];

                        SiteReportSub::insert($datafirst);
                    }
                }
            }

            if (isset($request->second_position)) {
                if (count($request->second_position) > 0) {
                    foreach ($request->second_position as $item => $v) {
                        if (isset($request->second_position[$item])) {
                            $setsecondposition =$request->second_position[$item];
                        } else {
                            $setsecondposition = null;
                        }

                        if (isset($request->second_person[$item])) {
                            $setsecondperson = $request->second_person[$item];
                        } else {
                            $setsecondperson = null;
                        }

                        if (isset($request->second_option[$item])) {
                            $setsecondoption = $request->second_option[$item];
                        } else {
                            $setsecondoption = null;
                        }

                        $datasecond = [
                            "site_id" => $id,
                            "type" => "sub_contractors",
                            "project_id" => Session::get("project_id"),
                            "user_id" => $userid,
                            "position_name" => $setsecondposition,
                            "no_of_persons" => $setsecondperson,
                            "option_method" => $setsecondoption,
                        ];

                        SiteReportSub::insert($datasecond);
                    }
                }
            }

            if (isset($request->third_position)) {
                if (count($request->third_position) > 0) {
                    foreach ($request->third_position as $item => $v) {
                        if (isset($request->third_position[$item])) {
                            $setthirdposition =$request->third_position[$item];
                        } else {
                            $setthirdposition = null;
                        }

                        if (isset($request->third_person[$item])) {
                            $setthirdperson = $request->third_person[$item];
                        } else {
                            $setthirdperson = null;
                        }

                        if (isset($request->hours[$item])) {
                            $sethours = $request->hours[$item];
                        } else {
                            $sethours = null;
                        }

                        if (isset($request->total_hours[$item])) {
                            $settotalhours = $request->total_hours[$item];
                        } else {
                            $settotalhours = null;
                        }

                        $datathird = [
                            "site_id" => $id,
                            "type" => "major_equipment_on_project",
                            "project_id" => Session::get("project_id"),
                            "user_id" => $userid,
                            "position_name" => $setthirdposition,
                            "no_of_persons" => $setthirdperson,
                            "hours" => $sethours,
                            "total_hours" => $settotalhours,
                        ];

                        SiteReportSub::insert($datathird);
                    }
                }
            }

            return redirect()->route("daily_reports")->with("success", "Site report created successfully.");

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function update_site_reports(Request $request)
    {
        try {
            if (\Auth::user()->type != "company") {
                $userid = Auth::user()->creatorId();
            } else {
                $userid = \Auth::user()->id;
            }

            if ($request->weather != null) {
                $selectweather = implode(",", array_filter($request->weather));
            } else {
                $selectweather = null;
            }

            if ($request->site_conditions != null) {
                $selectsiteconditions = implode(",",array_filter($request->site_conditions));
            } else {
                $selectsiteconditions = null;
            }

            $fileidarray = [];
            if ($request->attachements != null) {
                foreach ($request->attachements as $file_req) {
                    $filenameWithExt1 = $file_req->getClientOriginalName();
                    $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                    $extension1 = $file_req->getClientOriginalExtension();
                    $fileNameToStore1 =$filename1 . "_" . time() . "." . $extension1;
                    $dir = "uploads/site_reports/";
                    $imagepath = $dir . $filenameWithExt1;

                    if (\File::exists($imagepath)) {
                        \File::delete($imagepath);
                    }

                    $path = Utility::multi_upload_file($file_req,"file_req",$fileNameToStore1,$dir,[]);

                    if ($path["flag"] == 1) {
                        $url = $path["url"];

                        $fileinsert = [
                            "file_name" => $fileNameToStore1,
                            "file_location" => $url,
                        ];
                        $fileinsertid = DB::table("dr_site_multi_files")->insertGetId($fileinsert);
                        $fileidarray[] = $fileinsertid;
                    } else {
                        return redirect()->back()->with("error", __($path["msg"]));
                    }
                }

                $implodefileid =count($fileidarray) != 0 ? implode(",", $fileidarray): 0;
                if ($request->existing_file_id != "") {
                    $implodefileid =$request->existing_file_id . "," . $implodefileid;
                }
            } else {
                $getfileid = SiteReport::where("id", $request->edit_id)
                    ->where("user_id", $userid)
                    ->where("project_id", Session::get("project_id"))
                    ->first();
                if ($getfileid != null) {
                    $implodefileid = $getfileid->file_id;
                } else {
                    $implodefileid = 0;
                }
            }

            $data = [
                "project_id" => Session::get("project_id"),
                "user_id" => $userid,
                "contractor_name" => $request->contractor_name,
                "con_date" => $request->con_date,
                "con_day" => $request->con_day,
                "weather" => $selectweather,
                "site_conditions" => $selectsiteconditions,
                "temperature" => $request->temperature,
                "min_input" => $request->min_input,
                "total_in_power_one" => $request->total_in_power_one,
                "total_di_power_one" => $request->total_di_power_one,
                "total_con_power_one" => $request->total_con_power_one,
                "total_in_power_two" => $request->total_in_power_two,
                "total_di_power_two" => $request->total_di_power_two,
                "total_con_power_two" => $request->total_con_power_two,
                "degree" => $request->degree,
                "remarks" => $request->remarks,
                "prepared_by" => $request->prepared_by,
                "title" => $request->title,
                "file_id" => $implodefileid,
            ];

            SiteReport::where("id", $request->edit_id)
                ->where("project_id", Session::get("project_id"))
                ->where("user_id", $userid)
                ->update($data);

            $inid = SiteReport::where("user_id", $userid)
                ->where("project_id", Session::get("project_id"))
                ->where("id", "=", $request->edit_id)
                ->get("id");

            $invoiceid = trim($inid, '[{"id:"}]');

            SiteReportSub::where("site_id","=",$request->edit_id)->delete();

            if (isset($request->first_position)) {
                if (count($request->first_position) > 0) {
                    foreach ($request->first_position as $item => $v) {
                        if (isset($request->first_position[$item])) {
                            $setfirstposition =$request->first_position[$item];
                        } else {
                            $setfirstposition = null;
                        }

                        if (isset($request->first_person[$item])) {
                            $setfirstperson = $request->first_person[$item];
                        } else {
                            $setfirstperson = null;
                        }

                        if (isset($request->first_option[$item])) {
                            $setfirstoption = $request->first_option[$item];
                        } else {
                            $setfirstoption = null;
                        }

                        $data2 = [
                            "site_id" => $invoiceid,
                            "type" => "contractors_personnel",
                            "project_id" => Session::get("project_id"),
                            "user_id" => $userid,
                            "position_name" => $setfirstposition,
                            "no_of_persons" => $setfirstperson,
                            "option_method" => $setfirstoption,
                        ];

                      
                            SiteReportSub::insert($data2);
                        
                    }
                }
            }

            if (isset($request->second_position)) {
                if (count($request->second_position) > 0) {
                    foreach ($request->second_position as $item => $v) {
                        if (isset($request->second_position[$item])) {
                            $setsecondposition =$request->second_position[$item];
                        } else {
                            $setsecondposition = null;
                        }

                        if (isset($request->second_person[$item])) {
                            $setsecondperson = $request->second_person[$item];
                        } else {
                            $setsecondperson = null;
                        }

                        if (isset($request->second_option[$item])) {
                            $setsecondoption = $request->second_option[$item];
                        } else {
                            $setsecondoption = null;
                        }

                        $datasecond = [
                            "site_id" => $invoiceid,
                            "type" => "sub_contractors",
                            "project_id" => Session::get("project_id"),
                            "user_id" => $userid,
                            "position_name" => $setsecondposition,
                            "no_of_persons" => $setsecondperson,
                            "option_method" => $setsecondoption,
                        ];

                        SiteReportSub::insert($datasecond);
                    }
                }
            }

            if (isset($request->third_position)) {
                if (count($request->third_position) > 0) {
                    foreach ($request->third_position as $item => $v) {
                        if (isset($request->third_position[$item])) {
                            $setthirdposition =$request->third_position[$item];
                        } else {
                            $setthirdposition = null;
                        }

                        if (isset($request->third_person[$item])) {
                            $setthirdperson = $request->third_person[$item];
                        } else {
                            $setthirdperson = null;
                        }

                        if (isset($request->hours[$item])) {
                            $sethours = $request->hours[$item];
                        } else {
                            $sethours = null;
                        }

                        if (isset($request->total_hours[$item])) {
                            $settotalhours = $request->total_hours[$item];
                        } else {
                            $settotalhours = null;
                        }

                        $datathird = [
                            "site_id" => $invoiceid,
                            "type" => "major_equipment_on_project",
                            "project_id" => Session::get("project_id"),
                            "user_id" => $userid,
                            "position_name" => $setthirdposition,
                            "no_of_persons" => $setthirdperson,
                            "hours" => $sethours,
                            "total_hours" => $settotalhours,
                        ];

                        SiteReportSub::insert($datathird);
                    }
                }
            }

            return redirect()->route("daily_reports")->with("success", "Site report created successfully.");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function diary_download_file(Request $request)
    {
        $id = $request->id;
     
        $documentPath = Utility::get_file("uploads/project_direction_summary");

        $ducumentUpload = ProjectSpecification::find($id);
        if ($ducumentUpload != null) {
            $filepath =$documentPath . "/" . $ducumentUpload->attachment_file_name;
            $filename = $ducumentUpload->attachment_file_name;

            return \Response::download($filepath, $filename, [
                "Content-Length: " . $filepath,
            ]);
        } else {
            return redirect()->back()->with("error", __("File is not exist."));
        }
    }

    public function vo_change_download_file(Request $request)
    {
        $id = $request->id;
      

        $documentPath = Utility::get_file("uploads/variation_scope");

        $ducumentUpload = Vochange::find($id);
        if ($ducumentUpload != null) {
            $filepath = $documentPath . "/" . $ducumentUpload->attachment_file;

            $filename = $ducumentUpload->attachment_file;

            return \Response::download($filepath, $filename, [
                "Content-Length: " . $filepath,
            ]);
          
        } else {
            return redirect()
                ->back()
                ->with("error", __("File is not exist."));
        }
    }

    public function delete_site_reports(Request $request)
    {
        try {
            if (\Auth::user()->can("delete site reports")) {
                if (\Auth::user()->type != "company") {
                    $userid = Auth::user()->creatorId();
                } else {
                    $userid = \Auth::user()->id;
                }

                SiteReport::where("id", $request->id)
                    ->where("user_id", $userid)
                    ->where("project_id", $request->project_id)
                    ->delete();

                SiteReportSub::where("site_id", $request->id)->delete();

                return redirect()->back()->with("success","Site Report record deleted successfully.");
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function drawing_selection_list(Request $request)
    {
        try {
            if ($request->dairy_id == 1) {
                $projectid = Session::get("project_id");

                $dairydata = "";

                $returnHTML = view(
                    "diary.drawings_list.shop_drawing_list.index",
                    compact("dairydata", "projectid")
                )->render();
            } elseif ($request->dairy_id == 2) {
                $projectid = Session::get("project_id");
                $dairydata = "";
                $returnHTML = view("diary.drawings_list.contractor_drawings_list.index",
                    compact("dairydata", "projectid")
                )->render();
            } elseif ($request->dairy_id == 3) {
                $projectid = Session::get("project_id");
                $dairydata = "";
                $returnHTML = view("diary.drawings_list.consultant_drawings_list.index",
                    compact("dairydata", "projectid")
                )->render();
            } elseif ($request->dairy_id == 4) {
                $projectid = Session::get("project_id");
                $dairydata = "";
                $returnHTML = view("diary.drawings_list.tender_drawings_list.index",
                    compact("dairydata", "projectid")
                )->render();
            } else {
                $projectid = Session::get("project_id");
                $dairydata = "";
                $returnHTML = view("diary.drawings_list.shop_drawing_list.index",
                    compact("dairydata", "projectid")
                )->render();
            }
            return response()->json([
                "success" => true,
                "html" => $returnHTML,
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create_shop_drawing_list(Request $request)
    {
        try {
            if (\Auth::user()->can("create directions")) {
                $projectid = Session::get("project_id");

                $projectname = Project::select("project_name")
                    ->where("id", $projectid)
                    ->first();

                return view("diary.drawings_list.shop_drawing_list.create",
                    compact("projectname", "projectid")
                );
            } else {
                return redirect()->back()->with("error", __("Permission denied."));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
