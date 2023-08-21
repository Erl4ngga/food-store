<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Auth\Events\Registered;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Carrer;
use App\Models\Custom;
use App\Models\Faq;
use App\Models\Plugin;
use App\Models\ProductReview;
use App\Models\SmallBanner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Session;
use Socialite;
use Spatie\Newsletter\Facades\Newsletter;
use Carbon\Carbon;
use App\Models\Recruitment;
use App\Models\Section3;

class FrontendController extends Controller
{
        /**
     * display resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminusers = User::where(function ($query) {$query->where('role', 'admin')->orWhere('role', 'shipper');})->orderBy('id', 'ASC')->paginate(4);        
        $users=ProductReview::where('status','active')->orderBy('id','ASC')->paginate(5);
        $banner=Banner::where('status','active')->orderBy('id','ASC')->limit(6)->get();
        $smallerbanner=SmallBanner::where('status','active')->orderBy('id','ASC')->limit(2)->get();
        $categories=Category::where('status','active')->limit(3)->get();   
        $featured=Product::where('status','active')->where('is_featured',1)->where('stock', '>', 0)->orderBy('sold','DESC')->limit(6)->get();
        $discount=Product::where('status','active')->where('is_featured',1)->orderBy('discount','DESC')->limit(9)->get();
        $productorder=Product::orderBy('sold','DESC')->limit(5)->get();
        $countdown=Product::where('status','active')->orderBy('countdown_date','DESC')->limit(10)->get();
        return view('frontend.index')->with('featured',$featured)->with('categories',$categories)->with('banner',$banner)->with('users',$users)->with('countdown',$countdown)->with('productorder',$productorder)->with('discount',$discount)->with('smallerbanner',$smallerbanner)->with('adminusers',$adminusers);
    }
        /**
     * view login resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $plugins=Plugin::where('status','active')->where('name','social media')->get();
        return view('frontend.pages.login')->with('plugins',$plugins);
    }
    /**
     *view register resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $plugins=Plugin::where('status','active')->where('name','Social Media')->get();
        return view('frontend.pages.register')->with('plugins',$plugins);
    }
        /**
     *login social media resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect($provider)
    {
     return Socialite::driver($provider)->redirect();
    }
        /**
     *register social media resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function Callback($provider)
    {
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $users      =   User::where(['provider_id' => $userSocial->getId()])->first();
        if($users){
            Auth::login($users);
            return redirect('/')->with('success','You have logged in from '.$provider);
        }else{
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'image'         => $userSocial->getAvatar(),
                'password'      => bcrypt(1111),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]);
            //dd($user);
            event(new Registered($user));
            Auth::login($user);
         return redirect('/')->with('success','You have logged in from ' .$provider);
        }
    }
        /**
     *register social media resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function productlist()
    {
        return view('frontend.pages.product-list');
    }
    public function aboutus()
    {
        $adminusers=User::where('role','admin')->orderBy('id','ASC')->paginate(4);
        $carrers=Carrer::orderBy('id','DESC')->limit(1)->get();
        $Sections3=Section3::orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.about-us')->with('adminusers',$adminusers)->with('Sections3',$Sections3)->with('carrers',$carrers);
    }
    public function contact()
    {
        return view('frontend.pages.contact');
    }
    public function faq()
    {
        $Faqs=Faq::orderBy('id','DESC')->paginate('10');
        return view('frontend.pages.faq')->with('Faqs',$Faqs);
    }
    public function policy()
    {
        $Faqs=Faq::orderBy('id','DESC')->paginate('10');
        return view('frontend.pages.faq')->with('Faqs',$Faqs);
    }
    public function productdetail($slug)
    {
        $product_detail = Product::getProductBySlug($slug);
    
        if (empty($product_detail)) {
            abort(404); // this will show default 404 page to user
        }
    
        $brand = Brand::where('id', $product_detail->brand_id)->first();    
    
        // calculate the time remaining until the countdown date and time
        $countdown_datetime = Carbon::parse($product_detail->countdown_date.' '.$product_detail->countdown_time);
        $now = Carbon::now();
        $countdown = $countdown_datetime->diff($now);
        $product_detail->countdown = $countdown;
    
        return view('frontend.pages.product_detail')->with('product_detail', $product_detail)->with('brand', $brand) ->with('rgb', $product_detail->rgb);
    }
    
    public function productSearch(Request $request){
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $products=Product::orwhere('title','like','%'.$request->search.'%')
                    ->orwhere('slug','like','%'.$request->search.'%')
                    ->orwhere('description','like','%'.$request->search.'%')
                    ->orwhere('summary','like','%'.$request->search.'%')
                    ->orwhere('price','like','%'.$request->search.'%')
                    ->orderBy('id','DESC')
                    ->paginate('50');
        return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products);
    }
    public function productBrand(Request $request){
        $products=Brand::getProductByBrand($request->slug);
        if (empty($products)) {
            abort(404); // this will show default 404 page to user

        }
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        if(request()->is('e-shop.loc/product-grids')){
            return view('frontend.pages.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
        }
        else{
            return view('frontend.pages.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
        }

    }
    public function productFilter(Request $request){
        $data= $request->all();
        // return $data;
        $showURL="";
        if(!empty($data['show'])){
            $showURL .='&show='.$data['show'];
        }

        $sortByURL='';
        if(!empty($data['sortBy'])){
            $sortByURL .='&sortBy='.$data['sortBy'];
        }

        $catURL="";
        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if(empty($catURL)){
                    $catURL .='&category='.$category;
                }
                else{
                    $catURL .=','.$category;
                }
            }
        }

        $brandURL="";
        if(!empty($data['brand'])){
            foreach($data['brand'] as $brand){
                if(empty($brandURL)){
                    $brandURL .='&brand='.$brand;
                }
                else{
                    $brandURL .=','.$brand;
                }
            }
        }
        // return $brandURL;

        $priceRangeURL="";
        if(!empty($data['price_range'])){
            $priceRangeURL .='&price='.$data['price_range'];
        }
        if(request()->is('e-shop.loc/product-grids')){
            return redirect()->route('product-list',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
        }
        else{
            return redirect()->route('product-list',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
        }
    }
    
    public function subscribe(Request $request)
    {
        $this->validate($request,[
            'email'=>'string|required',
        ]);
        $email=$request->all();
        if (!Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribePending($request->email);
            if (Newsletter::lastActionSucceeded()) {
                return redirect('home')->with('success', 'Subscribed! Please check your email.');
            } else {
                return back()->with('error', 'Something went wrong! Please try again.');
            }
        } else {
            return back()->with('error', 'Already subscribed.');
        }
    }
    public function uploadfile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlxs,xlx,docx,doc,csv,txt,png,gif,jpg,jpeg|max:2048',
        ]);
 
        $fileName = $request->file->getClientOriginalName();
        $filePath = 'uploads/' . $fileName;
 
        $path = $request->file->storePubliclyAs('public', $filePath);
        $path = Storage::disk('public')->put($filePath, file_get_contents($request->file));
        $path = Storage::disk('public')->url($path);
        $recruitment = new Recruitment();
        $recruitment->folder_name = $filePath;
        $recruitment->save();
 
        // Perform the database operation here
 
        return back()
            ->with('success','File has been successfully uploaded.');
    }
    public function productCat(Request $request){
        $products=Category::getProductByCat($request->slug);
        if (empty($products)) {
            abort(404); // this will show default 404 page to user

        }
        // return $request->slug;
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();

        if(request()->is('e-shop.loc/product-grids')){
            return view('frontend.pages.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
        }
        else{
            return view('frontend.pages.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
        }

    }
    public function shortby(Request $request)
    {
        $products = Product::query();
    
        switch ($request->input('sort_by')) {
            case '1':
                $products->orderBy('name', 'asc');
            break;
            case '2':
                $products->orderBy('popularity', 'desc');
            break;
        case '3':
            $products->orderBy('created_at', 'desc');
            break;
        case '4':
            $products->orderBy('price', 'asc');
            break;
        case '5':
            $products->orderBy('price', 'desc');
            break;
        case '6':
            $products->orderBy('name', 'desc');
            break;
        default:
            $products->orderBy('name', 'asc');
            break;
        }
    
        $products = $products->paginate(10);

     return view('frontend.pages.product-grids', compact('products'));
    }
    public function gallery()
    {
        $galleryproduct=Product::where('status','active')->where('stock', '>', 0)->limit(50)->get();
        return view('frontend.pages.gallery')->with('galleryproduct',$galleryproduct);
    }

}
