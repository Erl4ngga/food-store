<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\InstagramFeed;
use App\Models\ProductReview;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ProductReview::factory()->count(50)->create();
        $parentCategory = Category::whereNull('parent_id')->inRandomOrder()->first();
          \App\Models\Product::factory(4)->create();
          \App\Models\User::factory(1)->create();
          \App\Models\Brand::factory(1)->create();
          InstagramFeed::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'photo' => '/storage/photos/52/img-1.jpg',
            'email' => 'test@example.com',
            'password' => Hash::make('1111'),
           'role'=>'admin',
        ]);
        \App\Models\User::factory()->create([
           'name' => 'Shipper',
           'email' => 'shipper@example.com',
           'password' => Hash::make('1111'),
          'role'=>'shipper',
       ]);
       \App\Models\User::factory()->create([
           'name' => 'employee',
           'email' => 'employee@example.com',
           'password' => Hash::make('1111'),
          'role'=>'employee',
       ]);
       DB::table('settings')->insert([
        'title'=>'sun-mart',
        'description'=>"halo ke startup saya",
        'short_des'=>"Lorem the It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.",
        'photo'=> "/storage/photos/52/ins-bg.jpg",
        'logo'=>"/storage/photos/52/logo.png",
        'address'=>"NO. 342 - London Oxford Street, 012 United Kingdom",
        'email'=>"widoerlangga212@gmail.com",
        'phone'=>"+060 (800) 801-582",
    ]);
    DB::table('small_banner')->insert([
        'title'=>"BIRTHDAY & GIFTS",
        'smalltitle'=>"のための花",
        'slug'=>'BIRTHDAY & GIFTS',
        'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.',
        'photo'=>'images/add-img-02.jpg',
        'status'=>'active',
    ]);
    DB::table('small_banner')->insert([
        'title'=>"WEDDING DAY",
        'smalltitle'=>"のための花",
        'slug'=>'WEDDING DAY',
        'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.',
        'photo'=>'images/add-img-01.jpg',
        'status'=>'active',
    ]);
    DB::table('email_setting')->insert([
        'name'=>"mailchimp",
        'title'=>'READY TO GET STARTED',
        'email'=>'hello@example.com',
        'smalltitle'=>'Diam elitr est dolore at sanctus nonumy.',
        'photo'=>'/newsletter.gif',
        'status'=>'active',       
    ]);
    DB::table('banners')->insert([
        'title'=>"Welcome To
        Freshshop",
        'url'=>"https://www.youtube.com/",
        'slug'=>'Welcome To
        Freshshop',
        'description'=>'See how your users experience your website in realtime or view
        trends to see any changes in performance over time.',
        'photo'=>'/storage/photos/52/banner-01.jpg',
        'photo2'=>'/storage/photos/61/img1.png',
        'status'=>'active',
    ]);
    DB::table('banners')->insert([
        'title'=>"Welcome To
        Freshshop",
        'url'=>"https://www.youtube.com/",
        'slug'=>'Welcome To
        Freshsh',
        'description'=>'See how your users experience your website in realtime or view
        trends to see any changes in performance over time.',
        'photo'=>'/storage/photos/52/banner-02.jpg',
        'photo2'=>'/storage/photos/61/img1.png',
        'status'=>'active',
    ]);
    DB::table('section')->insert([
        'title'=>"Header1",
        'name'=>'20% off Entire Purchase Promo code: offT80',
        'status'=>'active',
    ]);
    DB::table('section')->insert([
        'title'=>"Header2",
        'name'=>'50% - 80% off on Vegetables',
        'status'=>'active',
    ]);
    DB::table('section')->insert([
        'title'=>"Header3",
        'name'=>'Off 10%! Shop Vegetables',
        'status'=>'active',
    ]);
    DB::table('section')->insert([
        'title'=>"Header4",
        'name'=>' Off 50%! Shop Now',
        'status'=>'active',
    ]);
    DB::table('section')->insert([
        'title'=>"Header5",
        'name'=>'Off 10%! Shop Vegetables',
        'status'=>'active',
    ]);
    DB::table('section')->insert([
        'title'=>"Header6",
        'name'=>'Off 50%! Shop Now ',
        'status'=>'active',
    ]);
    DB::table('section2')->insert([
        'title'=>"Footer1",
        'name'=>'Monday - Friday: 08.00am to 05.00pm',
    ]);
    DB::table('section2')->insert([
        'title'=>"Footer2",
        'name'=>'Saturday: 10.00am to 08.00pm',
    ]);
    DB::table('section2')->insert([
        'title'=>"Footer3",
        'name'=>'Saturday: 10.00am to 08.00pm',
    ]);
    DB::table('coupons')->insert([
        'code'=>'baru2023',
        'type'=>'fixed',
        'value'=>'300',
        'status'=>'active'
    ]);
    DB::table('plugin')->insert([
        'name'=>"Payment Gateway",
        'category'=>'Stripe,Paypal,Midtrans',
        'status'=>'active',
        'is_featured' => true,
    ]);
    
    }
}
