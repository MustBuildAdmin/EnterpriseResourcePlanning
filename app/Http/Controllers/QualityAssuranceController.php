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

class QualityAssuranceController extends Controller
{


    public function concrete(){
        return view('qaqc.concrete');
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
