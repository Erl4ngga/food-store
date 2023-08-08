<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq=Faq::orderBy('id','DESC')->paginate(10);
        return view('backend.faq.index')->with('faq',$faq);
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq=Faq::find($id);
        if(!$faq){
            request()->session()->flash('error','faq not found');
        }
        return view('backend.faq.edit')->with('faq',$faq);
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.faq.create');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq=Faq::find($id);
        if($faq){
            $status=$faq->delete();
            if($status){
                request()->session()->flash('success','Faq successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('faq.index');
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
        $status=Faq::create($data);
        if($status){
            request()->session()->flash('success','faq successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('faq.index');
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
        $faq=Faq::find($id);
        $this->validate($request,[
            'question'=>'string|required',
            'answer'=>'string|required',
        ]);
        $data=$request->all();
       
        $status=$faq->fill($data)->save();
        if($status){
            request()->session()->flash('success','faq successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('faq.index');
    }
}
