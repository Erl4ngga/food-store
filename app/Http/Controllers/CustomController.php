<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use Illuminate\Http\Request;

class CustomController extends Controller
{
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $custom=Custom::orderBy('id','DESC')->paginate(10);
        return view('backend.custom_footer.index')->with('custom',$custom);
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $custom=Custom::find($id);
        if(!$custom){
            request()->session()->flash('error','Custom not found');
        }
        return view('backend.custom_footer.edit')->with('custom',$custom);
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $custom=Custom::find($id);
        $this->validate($request,[
            'name'=>'nullable',
            'footer1'=>'string|required',
            'footer2'=>'string|required',
            'footer3'=>'string|required',
            'footer4'=>'string|required',
        ]);
        $data=$request->all();
       
        $status=$custom->fill($data)->save();
        if($status){
            request()->session()->flash('success','Custom successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('custom.index');
    }
}
