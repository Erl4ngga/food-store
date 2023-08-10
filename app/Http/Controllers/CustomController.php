<?php

namespace App\Http\Controllers;

use App\Models\InstagramFeed;
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
        $custom=InstagramFeed::orderBy('id','DESC')->paginate(10);
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
        $custom=InstagramFeed::find($id);
        if(!$custom){
            request()->session()->flash('error','InstagramFeed not found');
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
        $custom=InstagramFeed::find($id);
        $this->validate($request,[
            'name'=>'nullable',
            'instagram'=>'string|required',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
       
        $status=$custom->fill($data)->save();
        if($status){
            request()->session()->flash('success','InstagramFeed successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('custom.index');
    }
            /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'nullable',
            'instagram'=>'string|required',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        // return $data;
        $status=InstagramFeed::create($data);
        if($status){
            request()->session()->flash('success','InstagramFeed successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('custom.index');
    }
         /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.custom_footer.create');
    }
}
