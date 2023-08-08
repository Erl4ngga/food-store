<?php


use App\Models\Cart;
use App\Models\Compare;
use App\Models\Shipping;
use App\Models\Wishlist;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class helper{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    } 
    public static function getAllProductFromCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::with('product')->where('user_id',$user_id)->where('order_id',null)->get();
        }
        else{
            return 0;
        }
    }
    public static function cartCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    public static function wishlistCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    public static function totalCartPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('amount');
        }
        else{
            return 0;
        }
    }
    public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
    }
    public static function getAllProductFromWishlist($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::with('product')->where('user_id',$user_id)->where('cart_id',null)->get();
        }
        else{
            return 0;
        }
    }
    public static function getAllProductFromCompare($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Compare::with('product')->where('user_id',$user_id)->where('cart_id',null)->get();
        }
        else{
            return 0;
        }
    }
    public static function moneyCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return User::where('id',$user_id)->sum('money');
         }
        else{
            return 0;
        }
    }
}

















?>