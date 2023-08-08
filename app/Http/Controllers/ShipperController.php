<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('frontend.shipper.index')->with('orders',$orders);
    }
    public function show($id)
    {
        $order=Order::find($id);
        return view('frontend.shipper.show')->with('order',$order);
    }
    public function edit($id)
    {
        $order=Order::find($id);
        return view('frontend.shipper.edit')->with('order',$order);
    }
    public function update(Request $request, $id)
    {
        $order=Order::find($id);
        $this->validate($request,[
            'status','payment_status'=>'required|in:new,process,delivered,cancel,paid,unpaid'
        ]);
        $data=$request->all();
        if($request->status=='delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error updating order');
        }
        return redirect()->route('shipper.index');
    }
}
