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
                            <li><a href="#"><i class="fa fa-user s_color"></i> My Account</a></li>
                            <li><a href="{{route('order.track')}}"><i class="fas fa-location-arrow"></i>Track Order</a></li>
                            <li><a href="{{route('contact')}}"><i class="fas fa-headset"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="login-box">
						<select id="basic" class="selectpicker show-tick form-control" data-placeholder="Sign In">
							<option>Register Here</option>
							<option>Sign In</option>
						</select>
					</div>
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
                                    <li><a href="{{route('user.register')}}">login &amp; register</a></li>
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
                    <h2>Contact Us</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Contact Us </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Contact Us  -->
    <div class="contact-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="contact-form-right">
                        <h2>GET IN TOUCH</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed odio justo, ultrices ac nisl sed, lobortis porta elit. Fusce in metus ac ex venenatis ultricies at cursus mauris.</p>
                        <form method="post" action="{{route('contact.store')}}" id="contactForm" accept-charset="UTF-8" class="contact-form" novalidate="novalidate">
                            @csrf
                            <div class="comment-box mt-5">
                                <h5 class="text-uppercase">Get in Touch</h5>
                                <div class="row mt-3">
                                    <div class="col-md-6 col-custom">
                                        <div class="input-item mb-4">
                                            <input class="border-0 rounded-0 w-100 input-area gray-bg " type="text" name="name" id="name" placeholder="Name" >
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-custom">
                                        <div class="input-item mb-4">
                                            <input class="border-0 rounded-0 w-100 input-area  gray-bg" type="email" name="email" type="email" id="email" placeholder="Email" >
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-custom">
                                        <div class="input-item mb-4">
                                            <input class="border-0 rounded-0 w-100 input-area  gray-bg" id="phone" name="phone" type="number" placeholder="Phone">
                                        </div>	
                                    </div>
                                    <div class="col-md-6 col-custom">
                                        <div class="input-item mb-4">
                                            <input class="border-0 rounded-0 w-100 input-area  gray-bg"  name="subject" type="text" id="subject" placeholder="Subject">
                                        </div>	
                                    </div>
                                    <div class="col-12 col-custom">
                                        <div class="input-item mb-4">
                                            <textarea cols="30" rows="5" class="border-0 rounded-0 w-100 custom-textarea input-area gray-bg"  name="message" id="message" placeholder="Message" ></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-custom mt-40">
                                        <button type="submit"  class="btn flower-button secondary-btn  rounded-0">Send A Message</button>
                                    </div>
                                    <p class="col-8 col-custom form-message mb-0"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-success">Thank you!</h2>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-success">Your order has been sent successfully</p>
                        </div>
                      </div>
                    </div>
                </div>
                
                <!-- Modals error -->
                <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-danger">Sorry!</h2>
                            <button type="button" class="close"  data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-danger">There is something wrong</p>
                        </div>
                      </div>
                    </div>
                </div>
				<div class="col-lg-4 col-sm-12">
                    <div class="contact-info-left">
                        <h2>CONTACT INFO</h2>
                        <p>@foreach($settings as $data) {{$data->short_des}} @endforeach</p>
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
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">@foreach($settings as $data) {{$data->phone}} @endforeach</a></p>
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
    <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{asset('frontend/js/custom.js')}}"></script>
</body>

</html>