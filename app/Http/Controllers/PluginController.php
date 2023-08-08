<?php

namespace App\Http\Controllers;

use App\Models\Plugin;
use Illuminate\Http\Request;

class PluginController extends Controller
{
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plugin=Plugin::orderBy('id','DESC')->paginate(10);
        return view('backend.plugin.index')->with('plugin',$plugin);
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plugin=Plugin::findOrFail($id);
        $items=Plugin::where('id',$id)->get();
        if(!$plugin){
            request()->session()->flash('error','Plugin not found');
        }
        return view('backend.plugin.edit')->with('plugin',$plugin)->with('items',$items);
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
        $plugin=Plugin::findOrFail($id);
        $this->validate($request,[
            'name'=>'string|required',
            'category' => 'required|array',
            'category.*' => 'in:Facebook,Twitter,Google,Stripe,Paypal,Midtrans',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        $data['category'] = implode(',', $data['category']);
        $status=$plugin->fill($data)->save();
        if($status){
            request()->session()->flash('success','Plugin successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('plugin.index');
    }
}
