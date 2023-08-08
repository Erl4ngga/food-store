<?php

namespace App\Http\Controllers;

use App\Models\EmailSetting;
use Illuminate\Http\Request;

class EmailSettingController extends Controller
{
      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailsetting=EmailSetting::orderBy('id','DESC')->paginate(10);
        return view('backend.emailsetting.index')->with('emailsetting',$emailsetting);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emailsetting=EmailSetting::findOrFail($id);
        return view('backend.emailsetting.edit')->with('emailsetting',$emailsetting);
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
        $emailsetting=EmailSetting::findOrFail($id);
        $this->validate($request,[
            'name'=>'string|required|max:50',
            'title'=>'string|required|max:50',
            'email'=>'string|required|max:50',
            'smalltitle'=>'string|nullable',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        $status=$emailsetting->fill($data)->save();
        if($status){
            request()->session()->flash('success','email successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating emailsetting');
        }
        return redirect()->route('emailsetting.index');
    }
}
