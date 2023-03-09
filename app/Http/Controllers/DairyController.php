<?php

namespace App\Http\Controllers;
use App\Models\Construction_project;
use App\Models\Project;
use App\Models\ConcretePouring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Utility;
use File;
class DairyController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($view = 'grid')
    {
        try {

  
            return view('dairy.index', compact('view'));

  
        } catch (Exception $e) {

  

            return $e->getMessage();

        }
       
        
    }

    public function filterDairyView(Request $request)
    {

        if(\Auth::user()->can('manage project'))
        {

          
            $usr           = Auth::user();
            if(\Auth::user()->type == 'client'){
              $user_projects = Project::where('client_id',\Auth::user()->id)->where('created_by',\Auth::user()->creatorId())->pluck('id','id')->toArray();;
            }else{
              $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
            }
            if($request->ajax() && $request->has('view') && $request->has('sort'))
            {
                $sort     = explode('-', $request->sort);
                $projects = Project::whereIn('id', array_keys($user_projects))->orderBy($sort[0], $sort[1]);

                if(!empty($request->keyword))
                {
                    $projects->where('project_name', 'LIKE', $request->keyword . '%')->orWhereRaw('FIND_IN_SET("' . $request->keyword . '",tags)');
                }
                if(!empty($request->status))
                {
                    $projects->whereIn('status', $request->status);
                }
                $projects   = $projects->get();
                $returnHTML = view('dairy.' . $request->view, compact('projects', 'user_projects'))->render();

                return response()->json(
                    [
                        'success' => true,
                        'html' => $returnHTML,
                    ]
                );
            }
        }
        else
        {
            return redirect()->route('dairy.concrete_pouring')->with('success', __('Designation  successfully created.'));
        }
    }


    public function show($view = 'grid',Request $request)
    {

           $project_id=$request->id;

           $dairy_data=ConcretePouring::where('project_id',$project_id)->get();
           
          

            return view('dairy.show',compact('project_id','dairy_data'));
    }

    public function dairy_create(Request $request)
    {
            $project=$request['project_id'];
            $id=$request['id'];

          
            if($id!=null){
            $get_dairy_data = ConcretePouring::where('project_id', $project)->where('id', $id)->first();
            }else{
            $get_dairy_data = null;
            }

            $dairy=ConcretePouring::where('project_id',$project)->first();
          
            return view('dairy.create',compact('project','id','get_dairy_data'));
            
    }

    public function concrete_pouring(Request $request)
    {
        try {

    
            unset($request['_token']);

            $data=array(
                "month_year"=>$request->month_year,
                "date_of_casting"=>$request->date_of_casting,
                "element_of_casting"=>$request->element_of_casting,
                "grade_of_concrete"=>$request->grade_of_concrete,
                "theoretical"=>$request->theoretical,
                "actual"=>$request->actual,
                "testing_fall"=>$request->testing_fall,
                "total_result"=>$request->total_result,
                "days_testing_falls"=>$request->days_testing_falls,
                "days_testing_result"=>$request->days_testing_result,
                "remarks"=>$request->remarks,
            );
          

            if(!empty($request->file_name))
            {           

                $filenameWithExt1 = $request->file('file_name')->getClientOriginalName();
                $filename1        = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
                $extension1       = $request->file('file_name')->getClientOriginalExtension();
                $fileNameToStore1 = $filename1 . '_' . time() . '.' . $extension1;

                $dir        = 'uploads/dairy';

                $image_path = $dir . $filenameWithExt1;
                if (\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $url = '';
                $path = Utility::upload_file($request,'file_name',$fileNameToStore1,$dir,[]);
                
                if($path['flag'] == 1){
                    $url = $path['url'];
                    $all_data=array(
                        "file_name"=>$fileNameToStore1,
                        "file_path"=>$url,
                        "project_id"=>$request->project_id,
                        "user_id"=>Auth::id(),
                        "diary_data"=>json_encode($data),
                        "status"=>0);
        
                    $where_condition = array(
                        "id"=>$request->edit_id,
                        'project_id'     =>$request->project_id,
                        'user_id'      =>Auth::id(),
                    );
                    ConcretePouring::updateOrInsert($where_condition, $all_data);
                    if($request->edit_id==""){
                        return redirect()->back()->with('success', __('dairy created successfully.'));
                    }else{
                        return redirect()->back()->with('success', __('dairy updated successfully.'));
                    }

                   
                }else{
                    return redirect()->back()->with('error', __($path['msg']));
                }
            }

       
          

        } catch (Exception $e) {

            return $e->getMessage();

        }

    }

    


    public function destroy(Request $request)
    {
        try {

            ConcretePouring::where('id',$request->id)->delete();
            return redirect()->back()->with(
                'success', 'Dairy successfully deleted.'
            );
          
          } catch (Exception $e) {
          
            
              return $e->getMessage();
          
          }

    }

}
