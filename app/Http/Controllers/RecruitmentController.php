<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Recruitment;
use Illuminate\Http\Response;

class RecruitmentController extends Controller
{
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recruitment=Recruitment::orderBy('id','DESC')->paginate(10);
        return view('backend.recruitment')->with('recruitment',$recruitment);
    }
    public function download($id)
    {
        $recruitment = Recruitment::find($id);
    
        if ($recruitment) {
            $filePath = storage_path('app/public/' . $recruitment->folder_name);
    
            if (file_exists($filePath)) {
                return response()->download($filePath);
            }
        }
    
        abort(404);
    }
    
    
}
