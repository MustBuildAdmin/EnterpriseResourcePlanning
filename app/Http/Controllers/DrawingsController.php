<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\Drawing;
use App\Models\DrawingTypes;
use App\Models\UploadDrawingsToTypes;
use Illuminate\Http\Request;
use App\Models\Utility;

class DrawingsController extends Controller
{

    const DENIED = 'Permission denied.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $drawings = Drawing::select('reference_number', 'drawing_type', 'created_by',
        'drawings.created_at as created_on', 'drawings.updated_at as updated_on',
        'drawing_types.drawing_types','drawing_types.id as drawing_type_id')
            ->join('drawing_types', 'drawing_types.id' ,'=', 'drawings.drawing_type');
        
        if ($request->drawing_type)
        {
            $drawings = $drawings->where('drawings.drawing_type', '=', $request->drawing_type);
        }elseif($request->ref_id){
            $ref_id = explode(",", $request->ref_id);
            $drawings = $drawings->whereIn('drawings.id', $ref_id);
        }elseif ($request->start_date && $request->end_date) {
            $drawings = $drawings->whereDate('drawings.created_at', '>=', $request->start_date)
            ->whereDate('drawings.created_at', '<=', $request->end_date);
        }
        $drawings = $drawings->where('drawings.created_by', \Auth::user()->creatorId())->get();
        $drawingTypes = DrawingTypes::get();

        return view('drawings.index', compact('drawings', 'drawingTypes'));
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create product & service')) {
            $drawing = new Drawing();
            $drawing->reference_number = $request->reference_number;
            $drawing->drawing_type = $request->input('drawing_type');
            $drawing->created_by = \Auth::user()->creatorId();
            $drawing->save();
            return redirect()->route('drawings.index')->with('success', __('Drawing Space Created Successfully.'));
        } else {
            return redirect()->back()->with('error', __(DENIED));
        }
        
    }

    public function addReference($drawing_type, $ref_number)
    {
        $uploadedDrawings = UploadDrawingsToTypes::select('upload_drawings_to_types.id',
        'drawing_type', 'revisions', 'status', 'file_name', 'drawing_path', 'upload_drawings_to_types.created_at',
        'upload_drawings_to_types.created_by', 'users.name as creator')
        ->join('users', 'users.id', '=', 'upload_drawings_to_types.created_by')
        ->where('drawing_type', $drawing_type)
        ->orderBy('upload_drawings_to_types.revisions', 'DESC')->get();
        return view('drawings.add_drawings',compact('uploadedDrawings', 'drawing_type', 'ref_number'));
    }

    public function addDrawings(Request $request, $drawing_type_id, $reference_number)
    {
        if (\Auth::user()->can('create product & service')) {
            $latest_upload = UploadDrawingsToTypes::where('drawing_type', $drawing_type_id)
            ->latest('created_at')
            ->first();
            if($latest_upload != null) {
                $latest_drawing = UploadDrawingsToTypes::find($latest_upload->id);
                $latest_drawing->status = 'Inactive';
                $latest_drawing->save();
            }
            $uploadDrawing = new UploadDrawingsToTypes();
            $uploadDrawing->drawing_type = $drawing_type_id;
            $uploadDrawing->revisions = $latest_upload == null ? 0 : $latest_upload->revisions+1;
            $uploadDrawing->status = 'Active';
            if (! empty($request->file('drawing_file'))) {

                $fileName = time().'_'.$request->file('drawing_file')->getClientOriginalName();
                $dir = 'app/public/uploads/project_drawings';
                $path = Utility::upload_file($request, 'drawing_file', $fileName, $dir, []);
                if ($path['flag'] == 0) {
                    return redirect()->back()->with('error', __($path['msg']));
                }
                $uploadDrawing->file_name = $request->file('drawing_file')->getClientOriginalName();
                $uploadDrawing->drawing_path = $dir.'/'.$fileName;
                
            }
            $uploadDrawing->created_by = \Auth::user()->creatorId();
            $uploadDrawing->save();
            return redirect()->route('drawing.reference.add', [$drawing_type_id, $reference_number])
            ->with('success', __('Drawings Uploaded Successfully.'));
        } else {
            return redirect()->back()->with('error', __(DENIED));
        }
    }

    public function drawingDestroy($id, $drawing_type, $reference_number, $creator)
    {
        if ($creator == \Auth::user()->creatorId()) {
            $drawing = UploadDrawingsToTypes::find($id);
            $drawing->delete();

            return redirect()->route('drawing.reference.add', [$drawing_type, $reference_number])
            ->with('success', __('Drawing successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __(DENIED));
        }
    }

    public function drawing_autocomplete(Request $request){
        $searchValue = $request['q'];
        if($request->filled('q')){
            $drawings = Drawing::where('reference_number','LIKE',"%{$searchValue}%")->get();
        }

        $drawingData = array();
        if(count($drawings) > 0){
            foreach($drawings as $draw){
                $setdraw = [
                    'id' => $draw->id,
                    'text' => $draw->reference_number
                ];
                $drawingData[] = $setdraw;
            }
        }
        echo json_encode($drawingData);
    }
}
