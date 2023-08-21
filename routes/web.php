<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('index');
Route::get('user/login', [App\Http\Controllers\FrontendController::class, 'login'])->name('user.login');
Route::get('user/register', [App\Http\Controllers\FrontendController::class, 'register'])->name('user.register');
//socialite
Route::get('login/{provider}/', [App\Http\Controllers\FrontendController::class, 'redirect'])->name('login.redirect');
Route::get('login/{provider}/callback/', [App\Http\Controllers\FrontendController::class, 'Callback'])->name('login.callback');
//product
Route::get('product-detail/{slug?}',[App\Http\Controllers\FrontendController::class,'productdetail'])->name('product-detail')->middleware('auth');
Route::post('product-search/index', [App\Http\Controllers\FrontendController::class, 'productsearch'])->name('product.search');
Route::get('product-search/index', [App\Http\Controllers\FrontendController::class, 'productsearch'])->name('product-search');
Route::get('product-list', [App\Http\Controllers\FrontendController::class, 'productsearch'])->name('product-list')->middleware('auth');
Route::get('product-cat/{slug}', [App\Http\Controllers\FrontendController::class, 'productcat'])->name('product-cat');
Route::get('/product-brand/{slug}', [App\Http\Controllers\FrontendController::class, 'productBrand'])->name('product-brand');
Route::match(['get','post'],'/filter' ,[App\Http\Controllers\FrontendController::class, 'productFilter'])->name('shop.filter');
Route::match(['get', 'post'], 'botman', [App\Http\Controllers\BotManController::class, 'handle']);
Route::post('/subscribe', [App\Http\Controllers\FrontendController::class, 'subscribe'])->name('subscribe');
Route::get('short-by', [App\Http\Controllers\FrontendController::class, 'shortby'])->name('sort-by');
Route::get('gallery', [App\Http\Controllers\FrontendController::class, 'gallery'])->name('gallery');
// Order Track
Route::get('/product/track',[App\Http\Controllers\OrderController::class,'orderTrack'])->name('order.track');
Route::post('product/track/order',[App\Http\Controllers\OrderController::class,'productTrackOrder'])->name('product.track.order');
//cart
Route::get('add-to-cart/{slug}',[App\Http\Controllers\CartController::class,'addToCart'])->name('add-to-cart')->middleware('auth');
Route::post('/add-to-cart',[App\Http\Controllers\CartController::class,'singleAddToCart'])->name('single-add-to-cart');
Route::get('/cart', function () {
     return view('frontend.pages.cart');
})->middleware(['auth'])->name('cart');
Route::post('/cart-update',[App\Http\Controllers\CartController::class,'cartupdate'])->name('cart.update');
Route::get('cart-delate/{id}',[App\Http\Controllers\CartController::class,'cartDelete'])->name('cart-delete');
Route::post('cart/order',[App\Http\Controllers\OrderController::class,'store'])->name('cart.order');
Route::get('order/pdf/{id}',[App\Http\Controllers\OrderController::class,'pdf'])->name('order.pdf');
Route::get('/income',[App\Http\Controllers\OrderController::class,'incomeChart'])->name('product.order.income');
Route::get('/income-transaction',[App\Http\Controllers\OrderController::class,'incomeTransactionChart'])->name('product.transaction.income');
//wishlist
Route::get('/wishlist', function () {
    return view('frontend.pages.wishlist');
})->middleware(['auth'])->name('wishlist');
Route::get('wishlist/{slug}',[App\Http\Controllers\WishlistController::class,'wishlist'])->name('add-to-wishlist');
Route::get('wishlist-delete/{id}',[App\Http\Controllers\WishlistController::class,'wishlistDelete'])->name('wishlist-delete');

//compare
Route::get('/compare', function () {
    return view('frontend.pages.compare');
})->middleware(['auth'])->name('compare');
Route::get('compare/{slug}',[App\Http\Controllers\CompareController::class,'compare'])->name('add-to-compare');
Route::get('compare-delete/{id}',[App\Http\Controllers\CompareController::class,'compareDelete'])->name('compare-delete');
//
Route::post('coupon',[App\Http\Controllers\CouponController::class,'couponStore'])->name('coupon-store');
Route::post('product/{slug}/review',[App\Http\Controllers\ProductReviewController::class,'store'])->name('review.store');

Route::get('about-us', [App\Http\Controllers\FrontendController::class, 'aboutus'])->name('about.us');
Route::get('checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout')->middleware(['auth']);
//contact
Route::get('contact', [App\Http\Controllers\FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/message', [App\Http\Controllers\MessageController::class, 'store'])->name('contact.store');

Route::get('faq', [App\Http\Controllers\FrontendController::class, 'faq'])->name('faq');
Route::get('policy', [App\Http\Controllers\FrontendController::class, 'policy'])->name('policy');

Route::post('file', [App\Http\Controllers\FrontendController::class, 'uploadfile'])->name('upload.file');
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::group(['prefix'=>'/admin','middleware'=>['role:admin']],function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/file-manager',function(){
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    Route::resource('product', App\Http\Controllers\ProductController::class);
    Route::resource('category', App\Http\Controllers\CategoryController::class);
    Route::resource('brand', App\Http\Controllers\BrandController::class);
    Route::resource('banner', App\Http\Controllers\BannerController::class);
    Route::resource('small-banner', App\Http\Controllers\SmallBannerController::class);
    Route::resource('shipping', App\Http\Controllers\ShippingController::class);
    Route::resource('coupon', App\Http\Controllers\CouponController::class);
    Route::resource('order', App\Http\Controllers\OrderController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('carrer', App\Http\Controllers\CarrerController::class);
    Route::resource('faq', App\Http\Controllers\FaqController::class);
    Route::resource('plugin', App\Http\Controllers\PluginController::class);
    Route::resource('transaction', App\Http\Controllers\TransactionController::class);
    Route::resource('custom', App\Http\Controllers\CustomController::class);
    Route::resource('section', App\Http\Controllers\SectionController::class);
    Route::resource('section2', App\Http\Controllers\Section2Controller::class);
    Route::resource('section3', App\Http\Controllers\Section3Controller::class);
    Route::resource('emailsetting', App\Http\Controllers\EmailSettingController::class);
    //profile
    Route::get('/profile',[App\Http\Controllers\AdminController::class,'profile'])->name('admin-profile');
    Route::post('/profile/{id}',[App\Http\Controllers\AdminController::class,'profileUpdate'])->name('profile-update');
    //message
    Route::get('/message/five',[App\Http\Controllers\MessageController::class, 'messageFive'])->name('messages.five');
    Route::resource('/message', App\Http\Controllers\MessageController::class);
    //settings
    Route::get('settings',[App\Http\Controllers\AdminController::class,'settings'])->name('settings');
    Route::post('setting/update',[App\Http\Controllers\AdminController::class,'settingsUpdate'])->name('settings.update');
    //notification
    Route::get('/notification/{id}',[App\Http\Controllers\NotificationController::class,'show'])->name('admin.notification');
    Route::get('/notifications',[App\Http\Controllers\NotificationController::class,'index'])->name('all.notification');
    Route::delete('/notification/{id}',[App\Http\Controllers\NotificationController::class,'delete'])->name('notification.delete');
    Route::get('/recruitment',[App\Http\Controllers\RecruitmentController::class,'index'])->name('recruitment');
    Route::get('/recruitment/download/{id}',[App\Http\Controllers\RecruitmentController::class,'download'])->name('file.download');

});
//shipper
Route::group(['prefix'=>'/shipper','middleware'=>['role:shipper']],function(){
    Route::resource('/shipper', App\Http\Controllers\ShipperController::class);
});
//user
Route::group(['prefix'=>'/user','middleware'=>['role:user']],function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('user');
    Route::post('/paypal', [App\Http\Controllers\PaypalController::class, 'processTransaction'])->name('top-up');
    Route::get('/paypal/succes', [App\Http\Controllers\PaypalController::class, 'successTransaction'])->name('successTransaction');
    Route::get('/paypal/cancel', [App\Http\Controllers\PaypalController::class, 'cancelTransaction'])->name('cancelTransaction');
    Route::get('/stripe/cancel', [App\Http\Controllers\PaypalController::class, 'cancelTransactionStripe'])->name('cancelTransactionStripe');
    Route::get('/stripe/succes', [App\Http\Controllers\PaypalController::class, 'successTransactionStripe'])->name('successTransactionStripe');
    Route::get('/order/show/{id}', [App\Http\Controllers\HomeController::class, 'orderShow'])->name('user.order.show');
});

require __DIR__.'/auth.php';
