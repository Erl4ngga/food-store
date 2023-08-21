<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\User as ModelsUser;
use App\Models\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request,[
            'first_name'=>'string|required',
            'last_name'=>'string|required',
            'address1'=>'string|required',
            'address2'=>'string|nullable',
            'coupon'=>'nullable|numeric',
            'phone'=>'numeric|required',
            'post_code'=>'string|nullable',
            'email'=>'string|required',
            'notes'=>'string|nullable',
            'country'=>'string|nullable',
            'province'=>'string|nullable',
        ]);

        if(empty(Cart::where('user_id',auth()->user()->id)->where('order_id',null)->first())){
            request()->session()->flash('error','Empty Cart !');
            return back();
        }
        if(empty(Shipping::where('id', $request->shipping)->first())){
            request()->session()->flash('error','Please Fill in Shipping!');
            return back();
        }
        $order=new Order();
        $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        $order_data['user_id']=$request->user()->id;
        $order_data['shipping_id']=$request->shipping;
        $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        $money=User::where('id',$order_data['user_id'])->first();
        $order_data['sub_total']=Helper::totalCartPrice();
        $order_data['quantity']=Helper::cartCount();
        if(session('coupon')){
            $order_data['coupon']=session('coupon')['value'];
        }
        if($request->shipping){
            if(session('coupon')){
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
            }
        }
        else{
            if(session('coupon')){
                $order_data['total_amount']=Helper::totalCartPrice()-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice();
            }
        }
        $order_data['status']="new";
        if(request('payment_method')=='money'){
            $order_data['payment_method']='money';
            $order_data['payment_status']='paid';
        }
        elseif(request('payment_method')=='rekening'){
            $order_data['payment_method']='rekening';
            $order_data['payment_status']='paid';
        }
        else{
            $order_data['payment_method']='cod';
            $order_data['payment_status']='Unpaid';
        }
        $order->fill($order_data);
        if(request('payment_method')=='money' && $money->money< $order->total_amount){
            request()->session()->flash('error','Top Up Your Balance');
            return back();
            }
            
        if(request('payment_method')=='money'){
            $money->update([
                'money' => $money->money - $order->total_amount, 
            ]);

        }
        $status=$order->save();
        $carted = Cart::where('user_id', auth()->user()->id)
        ->where('order_id', null)
        ->get();
    
        foreach ($carted as $cart) {
            $product = Product::find($cart->product_id);
            $current_stock = $product->stock;
            $current_sold = $product->sold;
            $new_stock = $current_stock - $cart->quantity;
            $new_sold = $current_sold + $cart->quantity;
    
            $product->stock = $new_stock;
            $product->sold = $new_sold;
            $product->save();
        }
    
        if($order)
        $users=User::where('role','admin')->first();
        $details=[
            'title'=>'New order created',
           'actionURL'=>route('order.show',$order->id),
            'fas'=>'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        // dd($users);        
        request()->session()->flash('success',' You Successfully Booked');
        return redirect()->route('index');
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('backend.order.index')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('backend.order.edit')->with('order',$order);
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
        $order=Order::find($id);
        $this->validate($request,[
            'status','payment_status'=>'required|in:new,process,delivered,cancel,paid,unpaid'
        ]);
        $data=$request->all();
        // return $request->status;
        if($request->status=='delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
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
        return redirect()->route('order.index');
    }
    public function pdf(Request $request){
        $order=Order::getAllOrder($request->id);
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        $pdf=PDF::loadview('backend.order.pdf',compact('order'));
        return $pdf->download($file_name);
    }
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('payment_status','paid')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                $m=intval($month);
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
    public function incomeTransactionChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        $items=Transaction::whereYear('created_at',$year)->where('status','success')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->sum('money');
                $m=intval($month);
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
    public function destroy($id)
    {
        $order=Order::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Orders cannot be deleted');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','Order could not be found');
            return redirect()->back();
        }
    }
    public function orderTrack(Request $request) {
        // Memeriksa apakah pengguna sudah login
        if (auth()->check()) {
            // Jika pengguna sudah login, lakukan query untuk mencari pesanan
            $orders = Order::where('user_id', auth()->user()->id)
                           ->where('order_number', $request->order_number)
                           ->get();
            
            // Kirim data pesanan ke view
            return view('frontend.pages.order-track')->with('orders', $orders);
        } else {
            // Jika pengguna belum login, Anda dapat memberikan pesan atau mengarahkan pengguna ke halaman login
            // Misalnya, menggunakan redirect ke halaman login
            return redirect()->route('login')->with('error', 'Anda harus login untuk melacak pesanan.');
        }
    }
    

    public function productTrackOrder(Request $request){
        // return $request->all();
        $order=Order::where('user_id',auth()->user()->id)->where('order_number',$request->order_number)->first();
        if($order){
            if($order->status=="new"){
            request()->session()->flash('success','Your order has been placed. Please wait.');
            return redirect()->route('order.track', ['order_number' => $request->order_number]);
            }
            elseif($order->status=="process"){
                request()->session()->flash('success','Your order is being processed, please wait.');
                return redirect()->route('order.track', ['order_number' => $request->order_number]);
    
            }
            elseif($order->status=="delivered"){
                request()->session()->flash('success','Your order is shipped.');
                return redirect()->route('order.track', ['order_number' => $request->order_number]);
    
            }
            elseif($order->status=="arrived"){
                request()->session()->flash('success','Your order has arrived');
                return redirect()->route('order.track', ['order_number' => $request->order_number]);
    
            }
            
            else{
                request()->session()->flash('error','Your order canceled. please try again');
                return redirect()->route('order.track', ['order_number' => $request->order_number]);
            }
        }
        else{
            request()->session()->flash('error','Invalid order numer please try again');
            return back();
        }
    }
}
