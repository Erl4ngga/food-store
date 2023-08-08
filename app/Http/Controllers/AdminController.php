<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
      /**
     * User Diagram information.
     */
    public function index()
    {
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(24))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
        return view('backend.index')->with('users', json_encode($array));
    }
    public function profile(){
      $profile=Auth()->user();
      return view('backend.users.profile')->with('profile',$profile);
  }
  public function profileUpdate(Request $request,$id){
    $user=User::findOrFail($id);
    $data=$request->all();
    $status=$user->fill($data)->save();
    if($status){
        request()->session()->flash('success','Successfully updated your profile');
    }
    else{
        request()->session()->flash('error','Please try again!');
    }
    return redirect()->back();
  }
  public function settings(){
    $data=Settings::first();
    return view('backend.setting')->with('data',$data);
  }
      /**
     * Update Setting information.
     */
  public function settingsUpdate(Request $request){
    $this->validate($request,[
        'short_des'=>'required|string',
        'description'=>'required|string',
        'photo'=>'required',
        'logo'=>'required',
        'address'=>'required|string',
        'email'=>'required|email',
        'phone'=>'required|string',
        'twitter'=>'string|nullable',
        'facebook'=>'string|nullable',
        'youtube'=>'string|nullable',
        'linkedin'=>'string|nullable',
    ]);
    $data=$request->all();
    $settings=Settings::first();
    $status=$settings->fill($data)->save();
    if($status){
        request()->session()->flash('success','Setting successfully updated');
    }
    else{
        request()->session()->flash('error','Please try again');
    }
    return redirect()->route('admin');
  }
}
