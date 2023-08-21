<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        @media (max-width: 768px) {
            .select2-container {
                width: 100% !important; /* Menyesuaikan lebar 100% pada perangkat seluler */
            }
        }
        @media (max-width: 1071px) {
            .select2-container {
                width: 100% !important; /* Menyesuaikan lebar 100% pada perangkat seluler */
            }
        }
    </style>
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

    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Checkout</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Cart  -->
    <form class="cart-box-main" method="POST" action="{{route('cart.order')}}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="checkout-address">
                        <div class="title-left">
                            <h3>Billing address</h3>
                        </div>
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName">First name *</label>
                                    <input type="text" class="form-control" name="first_name"  placeholder="" value="" required>
                                    <div class="invalid-feedback"> Valid first name is required. </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName">Last name *</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="" value="" required>
                                    <div class="invalid-feedback"> Valid last name is required. </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="username">Number</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="username" placeholder="" name="phone" required>
                                    <div class="invalid-feedback" style="width: 100%;"> Your number is required. </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="">
                                <div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
                            </div>
                            <div class="mb-3">
                                <label for="address">Address *</label>
                                <input type="text" class="form-control" name="address1" placeholder="" required>
                                <div class="invalid-feedback"> Please enter your shipping address. </div>
                            </div>
                            <div class="mb-3">
                                <label for="address2">Address 2 *</label>
                                <input type="text" class="form-control" name="address2" placeholder=""> </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="zip">Country</label>
                                    <input type="text" class="form-control" name="country" placeholder="" required>
                                    <div class="invalid-feedback"> Country </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="zip">province</label>
                                    <input type="text" class="form-control" name="province" placeholder="" required>
                                    <div class="invalid-feedback">Province </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="zip">Postcode / Zip</label>
                                    <input type="text" class="form-control" name="post_code" placeholder="" required>
                                    <div class="invalid-feedback"> Postcode / Zip </div>
                                </div>
                            </div>
                            <hr class="mb-4">
                            <div class="title"> <span>Payment</span> </div>
                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="credit" name="payment_method" type="radio" value="cod" class="custom-control-input" checked required>
                                    <label class="custom-control-label"  for="credit">Cash on Delivery</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="debit" name="payment_method" type="radio" value="cod" class="custom-control-input" required>
                                    @foreach ($settings as $data)
                                    <label class="custom-control-label" for="debit">{{$data->title}}</label>
                                    @endforeach
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="shipping-method-box">
                                <div class="title-left">
                                    <h3>Shipping Method</h3>
                                </div>
                                <div class="mb-4">
                                    <div class="shipping country-select clearfix">
                                        <select class="wide w-100" required name="shipping" id="shipping-select">
                                            <option value="" selected disabled>Cek</option>
                                            @foreach(Helper::shipping() as $shipping)
                                                <option value="{{$shipping->id}}" data-price="{{$shipping->price}}">{{$shipping->type}}: {{ $currency }} {{number_format($shipping->price, 2)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="odr-box">
                                <div class="title-left">
                                    <h3>Shopping cart</h3>
                                </div>
                                <div class="rounded p-2 bg-light">
                                    @foreach(Helper::getAllProductFromCart() as $key=>$cart)
                                    <div class="media mb-2 border-bottom">
                                        <div class="media-body"> <a href="detail.html">  {{$cart->product['title']}}</a>
                                            <div class="small text-muted">Price: {{$cart->product['currency']}}{{number_format($cart['price'],2)}} <span class="mx-2">|</span> Qty: {{$cart->quantity}}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="order-box">
                                <div class="title-left">
                                    <h3>Your order</h3>
                                </div>
                                <div class="d-flex">
                                    <div class="font-weight-bold">Product</div>
                                    <div class="ml-auto font-weight-bold">Total</div>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex">
                                    <h4>Sub Total</h4>
                                    <div class="ml-auto font-weight-bold"> {{number_format(Helper::totalCartPrice(),2)}}</div>
                                </div>
                                @if(session('coupon'))
                                <hr class="my-1">
                                <div class="d-flex">
                                    <h4>Coupon Discount</h4>
                                    <div class="ml-auto font-weight-bold"> {{number_format(session('coupon')['value'],2)}}</div>
                                </div>
                                @endif
                                @php
                                    $total_amount=Helper::totalCartPrice();
                                    if(session('coupon')){
                                        $total_amount=$total_amount-session('coupon')['value'];
                                    }
                                @endphp
                                <div class="d-flex">
                                    <h4>Shipping Cost</h4>
                                    <div class="ml-auto font-weight-bold"> Free </div>
                                </div>
                                <hr>
                                @if(session('coupon'))
                                <div class="d-flex gr-total order_subtotal" id="order_total_price">
                                    <h5>Grand Total</h5>
                                    <div class="ml-auto h5"> {{ $currency }} {{number_format($total_amount,2)}}</div>
                                </div>
                                @else
                                <div class="d-flex gr-total order_subtotal" id="order_total_price">
                                    <h5>Grand Total</h5>
                                    <div class="ml-auto h5"> {{ $currency }} {{number_format($total_amount,2)}}</div>
                                </div>
                                @endif
                                <hr> </div>
                        </div>
                        <div class="col-12 d-flex shopping-box"> <button class="ml-auto btn hvr-hover" type="submit">Place Order</button> </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
    <!-- End Cart -->

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
    <script>
        $(document).ready(function() {
            $('#shipping-select').select2(); // Menggunakan plugin Select2 untuk fitur live search
        });
    </script>
    <script>
        $(document).ready(function(){
            let currency = "{{ $currency }}"; // mengambil kode mata uang dari variabel PHP
            $('.shipping select[name=shipping]').change(function(){
                let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
                let subtotal = parseFloat( $('.order_subtotal').data('price') ); 
                let coupon = parseFloat( $('.coupon_price').data('price') ) || 0; 
                let num = (subtotal + cost - coupon);
                let formattedNum = num.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                $('#order_total_price span').text(currency + formattedNum); // menambahkan kode mata uang ke hasil perhitungan
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</body>

</html>