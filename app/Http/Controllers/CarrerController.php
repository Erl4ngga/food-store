<?php

namespace App\Http\Controllers;

use App\Models\Carrer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarrerController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrer=Carrer::orderBy('id','DESC')->paginate(10);
        return view('backend.carrer.index')->with('carrer',$carrer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.carrer.create');
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
            'title'=>'string|required',
        ]);
        $data=$request->all();
        // return $data;
        $status=Carrer::create($data);
        if($status){
            request()->session()->flash('success','carrer successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('carrer.index');
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
        $carrer=Carrer::find($id);
        if(!$carrer){
            request()->session()->flash('error','carrer not found');
        }
        return view('backend.carrer.edit')->with('carrer',$carrer);
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
        $carrer=Carrer::find($id);
        $this->validate($request,[
            'title'=>'string|required',
        ]);
        $data=$request->all();
       
        $status=$carrer->fill($data)->save();
        if($status){
            request()->session()->flash('success','carrer successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('carrer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrer=Carrer::find($id);
        if($carrer){
            $status=$carrer->delete();
            if($status){
                request()->session()->flash('success','carrer successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('carrer.index');
        }
        else{
            request()->session()->flash('error','carrer not found');
            return redirect()->back();
        }
    }
}
