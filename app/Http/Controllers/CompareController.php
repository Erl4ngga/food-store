<?php

namespace App\Http\Controllers;

use App\Models\Compare;
use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }
    public function compare(Request $request){
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Product');
            return back();
        }        
        $product = Product::where('slug', $request->slug)->first();
        if (empty($product)) {
            request()->session()->flash('error','Invalid Product');
            return back();
        }

        $already_wishlist = Compare::where('user_id', auth()->user()->id)->where('cart_id',null)->where('product_id', $product->id)->first();
        if($already_wishlist) {
            request()->session()->flash('error',' already placed in compare');
            return back();
        }else{
            
            $compare = new Compare;
            $compare->user_id = auth()->user()->id;
            $compare->product_id = $product->id;
            $compare->price = ($product->price-($product->price*$product->discount)/100);
            $compare->quantity = 1;
            $compare->amount=$compare->price*$compare->quantity;
            if ($compare->product->stock < $compare->quantity || $compare->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $compare->save();
        }
        request()->session()->flash('success','Product successfully added to Compare');
        return back();       
    }  
    
    public function compareDelete(Request $request){
        $compare = Compare::find($request->id);
        if ($compare) {
            $compare->delete();
            request()->session()->flash('success','Compare successfully removed');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }     
}
