<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section=Section::orderBy('id','DESC')->paginate(10);
        return view('backend.section.index')->with('section',$section);
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section=Section::find($id);
        if(!$section){
            request()->session()->flash('error','section not found');
        }
        return view('backend.section.edit')->with('section',$section);
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.section.create');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section=Section::find($id);
        if($section){
            $status=$section->delete();
            if($status){
                request()->session()->flash('success','section successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('section.index');
        }
        else{
            request()->session()->flash('error','Faq not found');
            return redirect()->back();
        }
    }
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'question'=>'string|required',
            'answer'=>'string|required',
        ]);
        $data=$request->all();
        // return $data;
        $status=Section::create($data);
        if($status){
            request()->session()->flash('success','faq successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('section.index');
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
        $section=Section::find($id);
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
        return redirect()->route('section.index');
    }
}
