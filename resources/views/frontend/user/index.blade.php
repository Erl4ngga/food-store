<!doctype html>
<html class="no-js" lang="en">



<head>
    @php
        $settings=DB::table('settings')->get();
        $emailsettings=DB::table('email_setting')->get();
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    @foreach ($settings as $data)
    <title>{{$data->title}}</title>@endforeach
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/custom.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    
</head>

<body>
    @if(session('success'))
        <div class="alert alert-success alert-dismissable fade show text-center" id="success-alert">
            <button class="close" data-bs-dismiss="alert" aria-label="Close">×</button>
            {{session('success')}}
        </div>
        <script>
            setTimeout(function() {
                $('#success-alert').fadeOut('slow');
            }, 3000); // waktu dalam milidetik
        </script>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissable fade show text-center" id="error-alert">
            <button class="close" data-bs-dismiss="alert" aria-label="Close">×</button>
            {{session('error')}}
        </div>
        <script>
            setTimeout(function() {
                $('#error-alert').fadeOut('slow');
            }, 3000); // waktu dalam milidetik
        </script>
    @endif
    <!-- Start Main Top --> 
    <div class="main-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="custom-select-box">
                        <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
							<option>¥ JPY</option>
							<option>$ USD</option>
							<option>€ EUR</option>
						</select>
                    </div>
                    <div class="right-phone-box">
                        <p>Call US :<a href="#">@foreach($settings as $data) {{$data->phone}} @endforeach</a></p>
                    </div>
                    <div class="our-link">
                        <ul>
                            @if (Auth::check())
                                @if(Auth::user()->role=='user')
                                    <li><a  href="{{route('user')}}"><i class="fa fa-user s_color"></i> My Account</a></li>
                                @else
                                    <li><a  href="{{route('admin')}}"><i class="fa fa-user s_color"></i> My Account</a></li>
                                @endif
                            @endif
                            <li><a href="{{route('order.track')}}"><i class="fas fa-location-arrow"></i>Track Order</a></li>
                            <li><a href="{{route('contact')}}"><i class="fas fa-headset"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    @if (!Auth::check())
                        <div class="login-box">
                            <button type="button" class="btn hvr-hover" data-toggle="modal" data-target="#loginModal">login</button>
                        </div>
                    @endif
                    @php
                        $section=DB::table('section')->where('status','active')->paginate(6);
                    @endphp
                    <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                            <ul class="offer-box">
                                @if ($section)
                                @foreach ($section as $sections)
                                <li>
                                    <i class="fab fa-opencart"></i> {{$sections->name}}
                                </li>
                                @endforeach                                    
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Top -->

    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                    @foreach ($settings as $data) <a class="navbar-brand" href="index.html"><img src="{{$data->logo}}" class="logo" alt=""></a> @endforeach
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item active"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('about.us')}}">About Us</a></li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle " data-toggle="dropdown">SHOP &darr;</a>
                            <ul class="dropdown-menu">
								<li><a href="{{route('product-list')}}">Sidebar Shop</a></li>
                                <li><a href="{{route('cart')}}">Cart</a></li>
                                <li><a href="{{route('checkout')}}">Checkout</a></li>
                                @auth
                                @if(Auth::user()->role=='admin')
                                    <li><a href="{{route('admin')}}">Dashboard admin</a></li>
                                @elseif(Auth::user()->role=='user')
                                    <li><a href="{{route('user')}}">Dashboard user</a></li>
                                @else
                                    <li><a href="{{route('shipper.index')}}">Dashboard shipper</a></li>
                                @endif
                                @else
                                    <li><a href="{{route('register')}}">login &amp; register</a></li>
                                @endauth
                                <li><a href="{{route('wishlist')}}">Wishlist</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{route('gallery')}}">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Contact Us</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                        <li class="side-menu">
							<a href="#">
								<i class="fa fa-shopping-bag"></i>
								<span class="cart-item_count">{{Helper::cartCount()}}</span>
								<p>My Cart</p>
							</a>
						</li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>
            <!-- Start Side Menu -->
            @php 
                $total_prod=0;
                $total_amount=0;
            @endphp
            <div class="side">
                <a href="#" class="close-side"><i class="fa fa-times"></i></a>
                <li class="cart-box">
                    @php
                        $cartItems = Helper::getAllProductFromCart();
                        $currency = '';
                    @endphp
                    <ul class="cart-list">
                        @auth
                        @foreach (Helper::getAllProductFromCart() as $item)
                        <li>
                            @php
                                $photo=explode(',',$item->product['photo']);
                                $currency = $item->product->currency;
                            @endphp
                            <a href="{{route('product-detail',$item->product['slug'])}}" class="photo"><img src="{{$photo[0]}}" alt="{{$photo[0]}}" class="cart-thumb" /></a>
                            <h6><a href="{{route('product-detail',$item->product['slug'])}}">{{$item->product['title']}} </a></h6>
                            <p>{{$item->quantity}}x - <span class="price">{{ $currency }} {{number_format($item->price,2)}}</span></p>
                        </li>
                        @endforeach
                        <li class="total">
                            <a href="{{route('cart')}}" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                            <span class="float-right">{{ $currency }} {{number_format(Helper::totalCartPrice(),2)}}</span>
                        </li>
                        @endauth
                    </ul>
                </li>
            </div>
            <!-- End Side Menu -->
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <form method="POST" action="{{route('product.search')}}">
                @csrf
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search">
                    <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                </div>
            </form> 
        </div>
    </div>
    <!-- End Top Search -->
    <!-- Breadcrumb Area End Here -->
    <!-- my account wrapper start -->
    <div class="my-account-wrapper mt-no-text">
        <div class="container container-default-2 custom-area">
            <div class="row">
                <div class="col-lg-12 col-custom">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-custom">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                        Dashboard</a>
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                                    <a href="#download" data-bs-toggle="tab"><i class="fa fa-download"></i> Download</a>
                                    <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"> @foreach ($settings as $data)</i>{{$data->title}}</a>@endforeach
                                    {{--<a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i> address</a>--}}
                                    <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account Details</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
            
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8 col-custom">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Dashboard</h3>
                                            <div class="welcome">
                                                <p>Hello, <strong>{{$user->name}}</strong> (If Not <strong>{{$user->name}} </strong><a href="login-register.html" class="logout"> Logout</a>)</p>
                                            </div>
                                            <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order Number</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($orders)>0)
                                                            @foreach ($orders as $order)
                                                            <tr>
                                                            <td>{{$order->order_number}}</td>
                                                            <td> {{$order->created_at->format('d M, Y. D')}}</td>
                                                            @if($order->status=='new')
                                                                <td>{{$order->status}}</td>
                                                            @elseif($order->status=='process')
                                                                <td>{{$order->status}}</td>
                                                            @elseif($order->status=='delivered')
                                                                <td>{{$order->status}}</td>
                                                            @else 
                                                                <td>{{$order->status}}</td>
                                                            @endif
                                                            <td>{{$order->currency}}{{number_format($order->total_amount,2)}}</td>
                                                            <td><a href="{{route('user.order.show',$order->id)}}" class="btn gomart-button secondary-btn theme-color  rounded-0">View</a></td>
                                                            </tr>
                                                            @endforeach
                                                        @else
                                                            <h6 class="text-center">Tidak ada pesanan yang ditemukan!!! Silahkan pesan beberapa produk</h6>
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="download" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Downloads</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>order number</th>
                                                            <th>payment method</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($orders as $order)
                                                            <tr>
                                                                <td>{{$order->order_number}}</td>
                                                                <td>{{$order->payment_method}}</td>
                                                                <td>{{$order->created_at->format('d M, Y. D')}}</td>
                                                                <td>{{$order->payment_status}}</td>
                                                                <td><a href="{{route('order.pdf',$order->id)}}" class="btn gomart-button secondary-btn theme-color  rounded-0"><i class="fa fa-cloud-download mr-2"></i>Download File</a></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>E-Wallet</h3>
                                            <p class="saved-message">{{number_format($user->money),2}}</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Billing Address</h3>
                                            <address>
                                                <p><strong>Alex Aya</strong></p>
                                                <p>1234 Market ##, Suite 900 <br>
                                            Lorem Ipsum, ## 12345</p>
                                                <p>Mobile: (123) 123-456789</p>
                                            </address>
                                            <a href="#" class="btn gomart-button secondary-btn theme-color  rounded-0"><i class="fa fa-edit mr-2"></i>Edit Address</a>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            @foreach ($settings as $data)<h3>{{$data->title}} wallet</h3>@endforeach
                                            <div class="account-details-form">
                                                @if($plugins)
                                                    @foreach ($plugins as $plugin)
                                                <form method="POST" action="{{route('top-up')}}">
                                                    @csrf
                                                    <div class="row">
                                                    </div>
                                                    <div class="single-input-item mb-3">
                                                        <label for="display-name" class="required mb-1">Top Up</label>
                                                        <input name="quant[1]" step="1" type="number" id="display-name" placeholder="Top Up" />
                                                    </div>
                                                    @if (strpos($plugin->category, 'Paypal') !== false)                                                    
                                                    <div class="single-input-item mb-3">
                                                        <div class="checkout-form-list create-acc">
                                                            <input name="payment_method" id="cod" type="radio"  value="paypal">
                                                            <label for="cod">Paypal</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if (strpos($plugin->category, 'Midtrans') !== false)
                                                    <div class="single-input-item mb-3">
                                                        <div class="checkout-form-list create-acc">
                                                            <input name="payment_method" id="cbox" type="radio"  value="midtrans">
                                                            <label for="cbox">midtrans</label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if (strpos($plugin->category, 'Stripe') !== false)
                                                    <div class="single-input-item mb-3">
                                                        <div class="checkout-form-list create-acc">
                                                            <input name="payment_method" id="stripe" type="radio" value="stripe">
                                                            <label for="stripe">Stripe</label>
                                                        </div>
                                                    </div>
                                                    @endif                                                    
                                                    <div class="single-input-item single-item-button">
                                                        <button   class="btn flower-button secondary-btn theme-color  rounded-0">Save Changes</button>
                                                    </div>                                                   
                                                </form>
                                                @endforeach 
                                                @endif
                                                <div class="payment">
                                                    <a href="#"><img class="border" style="margin-top: 30px" src="/payment-icon.png" alt="Payment"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->
    @php
         $instagramfeed=DB::table('instagram_feed')->where('status','active')->paginate(10);
    @endphp
    <!-- Start Instagram Feed  -->
    @if($instagramfeed)
    <div class="instagram-box">
        <div class="main-instagram owl-carousel owl-theme">
            @foreach ($instagramfeed as $instagramcustom)
            <div class="item">
                <div class="ins-inner-box">
                    <img src="{{$instagramcustom->photo}}" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <!-- End Instagram Feed  -->


    <!-- Start Footer  -->
    @php
        $section2=DB::table('section2')->paginate(3);
    @endphp
    <footer>
        <div class="footer-main">
            <div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Business Time</h3>
                            @if ($section2)
							<ul class="list-time">
                                @foreach ($section2 as $sections2)
								<li>{{$sections2->name}}</li>
                                @endforeach
							</ul>
                            @endif
						</div>
					</div>
                    @foreach ($emailsettings as $emailsetting)
                    @if ($emailsetting->status == 'active')
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Newsletter</h3>
							<form action="{{route('subscribe')}}" method="post" class="newsletter-box">
                                @csrf
								<div class="form-group">
									<input class="" type="email" name="email" placeholder="Email Address*" />
									<i class="fa fa-envelope"></i>
								</div>
								<button class="btn hvr-hover" type="submit">Submit</button>
							</form>
						</div>
					</div>
                    @endif
                    @endforeach
					<div class="col-lg-4 col-md-12 col-sm-12"> 
						<div class="footer-top-box">
							<h3>Social Media</h3>
							<ul>
                                @foreach ($settings as $data)
                                    <li>
                                        @if ($data->facebook)
                                        <a href="{{$data->facebook}}"><i class="fab fa-facebook" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </li>
                                    <li>
                                        @if ($data->twitter)
                                        <a href="{{$data->twitter}}"><i class="fab fa-twitter" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </li>
                                    <li>
                                        @if ($data->linkedin)
                                        <a href="{{$data->linkedin}}"><i class="fab fa-linkedin" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </li>
                                    <li>
                                        @if ($data->youtube)
                                        <a href="{{$data->youtube}}"><i class="fab fa-youtube" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </li>
                                    <li>
                                        @if ($data->instagram)
                                        <a href="{{$data->instagram}}"><i class="fab fa-instagram" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
						</div>
					</div>
				</div>
				<hr>
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            @foreach ($settings as $data)
                            <h4>About {{$data->title}}</h4>@endforeach
                            <p>@foreach($settings as $data) {{$data->short_des}} @endforeach</p> 							
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link">
                            <h4>Information</h4>
                            <ul>
                                <li><a href="{{route('about.us')}}">About Us</a></li>
                                <li><a href="{{route('contact')}}">Contact Us</a></li>
                                <li><a href="{{route('about.us')}}">Carrer</a></li>
                                <li><a href="{{route('policy')}}">Terms &amp; Conditions</a></li>
                                <li><a href="{{route('policy')}}">Privacy Policy</a></li>
                                <li><a href="{{route('product-list')}}">Shop</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link-contact">
                            <h4>Contact Us</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>@foreach($settings as $data) {{$data->address}} @endforeach</p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="">@foreach($settings as $data) {{$data->phone}} @endforeach</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="">@foreach($settings as $data) {{$data->email}} @endforeach</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class="footer-copyright">
        @foreach ($settings as $data)
        <?php $currentYear = date('Y'); ?>
        <p class="footer-company">All Rights Reserved. &copy; {{ $currentYear }} <a href="#">{{ $data->title }}</a> Develop By :
            <a href="https://twitter.com/erlang_stack">Erlangga Rychlewski</a>
        </p>
        @endforeach
    
    </div>
    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

    
    <!-- ALL JS FILES -->
    <script src="{{asset('frontend/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('frontend/js/popper.min.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="..." defer></script>

    <!-- ALL PLUGINS -->
    <script src="{{asset('frontend/js/jquery.superslides.min.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap-select.js')}}"></script>
    <script src="{{asset('frontend/js/inewsticker.js')}}"></script>
    <script src="{{asset('frontend/js/bootsnav.js')}}"></script>
    <script src="{{asset('frontend/js/images-loded.min.js')}}"></script>
    <script src="{{asset('frontend/js/isotope.min.js')}}"></script>
    <script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/js/baguetteBox.min.js')}}"></script>
    <script src="{{asset('frontend/js/form-validator.min.js')}}"></script>
    <script src="{{asset('frontend/js/contact-form-script.js')}}"></script>
    <script src="{{asset('frontend/js/custom.js')}}"></script>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-title text-center">
                <h4>Login</h4>
              </div>
              <div class="d-flex flex-column text-center">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
            
                    <!-- Email Address -->
                    <div class="form-group">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
            
                    <!-- Password -->
                    <div class="form-group">
                        <x-input-label for="password" :value="__('Password')" />
            
                        <x-text-input id="password" class="form-control"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
            
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <x-primary-button class="btn hvr-hover">
                        {{ __('Log in') }}
                    </x-primary-button>
                </form>
                
                <div class="text-center text-muted delimiter">or use a social network</div>
                <div class="d-flex justify-content-center social-buttons">
                  <a  class="btn hvr-hover" href="{{ route('login.redirect', 'google') }}" data-toggle="tooltip" data-placement="top" title="google">
                    <i class="fab fa-google"></i>
                  </a>
                  <a class="btn hvr-hover" href="{{ route('login.redirect', 'facebook') }}" data-toggle="tooltip" data-placement="top" title="Facebook">
                    <i class="fab fa-facebook"></i>
                  </a>
                  <a class="btn hvr-hover" href="{{ route('login.redirect', 'twitter') }}" data-toggle="tooltip" data-placement="top" title="Twitter">
                    <i class="fab fa-twitter"></i>
                  </a>
                </di>
              </div>
            </div>
          </div>
            <div class="modal-footer d-flex justify-content-center">
              <div class="signup-section">Not a member yet? <a href="{{ route('register') }}" class="text-info"> Sign Up</a>.</div>
            </div>
        </div>
    </div>
    
    
       

</body>


</html>