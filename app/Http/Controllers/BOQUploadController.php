<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BOQUploadController extends Controller
{
    public function extractData(Request $request)
    {
        // $uploadedFile = $request->file('boq_file');
        // $originalFilename = $uploadedFile->getClientOriginalName();
        // $fileSize = $uploadedFile->getSize();
        $path = $request->file('boq_file')->getRealPath();
        print($path);
        // $rows = Excel::import(, $path);
        // print($rows);
    }
}