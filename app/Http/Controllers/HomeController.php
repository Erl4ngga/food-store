<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Order;
use App\Models\Plugin;
use App\Models\ProductReview;
use App\Models\PostComment;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



     
     public function index()
     {
         $user = Auth()->user();
         $orders = Order::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->paginate(10);
         $plugins=Plugin::where('status','active')->where('name','Payment Gateway')->get();
         $view = view('frontend.user.index')->with('user', $user)->with('orders', $orders)->with('plugins', $plugins);    
         $response = new Response($view);
         $cookie = Cookie::make('my_cookie', 'my_value', 60, '/', 'example.com', true, true, 'Strict');
         $response->withCookie($cookie);
     
         return $response;
     }

    public function profile(){
        $profile=Auth()->user();
        return view('user.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        $user=User::findOrFail($id);
        $user->fill([
            'secret' => Crypt::encryptString($request->secret),
        ])->save();
        $data=$request->all();
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
    }
    public function userOrderDelete($id)
    {
        $order=Order::find($id);
        if($order){
           if($order->status=="process" || $order->status=='delivered' || $order->status=='cancel'){
                return redirect()->back()->with('error','You cant delete this order right now');
           }
           else{
                $status=$order->delete();
                if($status){
                    request()->session()->flash('success','Successful Order deleted');
                }
                else{
                    request()->session()->flash('error','Orders cannot be deleted');
                }
                return redirect()->route('user.order.index');
           }
        }
        else{
            request()->session()->flash('error','Order could not be found');
            return redirect()->back();
        }
    }

    public function orderShow($id)
    {
        $order=Order::find($id);
        return view('frontend.user.show')->with('order',$order);
    }
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }

    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        return view('user.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewUpdate(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('success','Review successfully updated');
            }
            else{
                request()->session()->flash('error','Something is wrong,Repeat again!!');
            }
        }
        else{
            request()->session()->flash('error','Review not found!!');
        }

        return redirect()->route('user.productreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewDelete($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted review');
        }
        else{
            request()->session()->flash('error','Something went wrong! Try again');
        }
        return redirect()->route('user.productreview.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('success','Comment successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('user')->with('success','Password successfully changed');
    }
    
}
