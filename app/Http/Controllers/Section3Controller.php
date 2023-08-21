<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section3;
class Section3Controller extends Controller
{
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section=Section3::orderBy('id','DESC')->paginate(10);
        return view('backend.section3.index')->with('section',$section);
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section=Section3::find($id);
        if(!$section){
            request()->session()->flash('error','section not found');
        }
        return view('backend.section3.edit')->with('section',$section);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section=Section3::find($id);
        if($section){
            $status=$section->delete();
            if($status){
                request()->session()->flash('success','section successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('section3.index');
        }
        else{
            request()->session()->flash('error','Section not found');
            return redirect()->back();
        }
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $section=Section3::find($id);
        $this->validate($request,[
            'title'=>'string|required',
            'name'=>'string|required',
        ]);
        $data=$request->all();
       
        $status=$section->fill($data)->save();
        if($status){
            request()->session()->flash('success','section successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('section3.index');
    }
}
