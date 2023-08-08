<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
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

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'photo' => '/Erlangga.jpg',
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
        'photo'=> "/images/bg/1.jpg",
        'logo'=>"images/logo.png",
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
        'title'=>"2023 Flowered",
        'url'=>"https://www.youtube.com/",
        'slug'=>'2023 Flower Trend',
        'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.',
        'photo'=>'/storage/photos/61/img1.png',
        'photo2'=>'/storage/photos/61/img1.png',
        'status'=>'active',
    ]);
    }
}
