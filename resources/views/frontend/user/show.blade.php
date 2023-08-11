<!doctype html>
<html class="no-js" lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @php
        $settings=DB::table('settings')->get();
    @endphp
     @foreach ($settings as $data)
    <title>{{$data->title}}</title>
    @endforeach
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" @foreach ($settings as $data) href="{{$data->logo}}"@endforeach>

    <!-- CSS
	============================================ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/vendor/bootstrap.min.css')}}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/vendor/font.awesome.min.css')}}">
    <!-- Linear Icons CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/vendor/linearicons.min.css')}}">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/swiper-bundle.min.css')}}">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/animate.min.css')}}">
    <!-- Jquery ui CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/jquery-ui.min.css')}}">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/nice-select.min.css')}}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/magnific-popup.css')}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

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


    <!-- Header Area Start Here -->
    <header class="main-header-area">
        <!-- Main Header Area Start -->
        <div class="main-header header-transparent header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-xl-2 col-md-6 col-6 col-custom">
                        <div class="header-logo d-flex align-items-center">
                            @php
                                $settings=DB::table('settings')->get();
                            @endphp
                            <a href="/">
                                @foreach ($settings as $data)
                                    <img class="img-full" src="{{$data->logo}}" alt="Header Logo">
                                @endforeach
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 d-none d-lg-flex justify-content-center col-custom">
                        <nav class="main-nav d-none d-lg-flex">
                            <ul class="nav">
                                <li>
                                    <a  href="/">
                                        <span class="menu-text"> Home</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="shop.html">
                                        <span class="menu-text">Shop</span>
                                        <i class="bi bi-arrow-down-short"></i>
                                    </a>
                                    <div class="mega-menu dropdown-hover">
                                        <div class="menu-colum">
                                            <ul>
                                                <li><span class="mega-menu-text">Shop</span></li>
                                                <li><a href="{{route('product-list')}}">Shop List</a></li>
                                            </ul>
                                        </div>
                                        <div class="menu-colum">
                                            <ul>
                                                <li><span class="mega-menu-text">Product</span></li>
                                                <li><a href="{{route('wishlist')}}">Wishlist Product</a></li>
                                                <li><a href="{{route('compare')}}">Compare Product</a></li>
                                            </ul>
                                        </div>
                                        <div class="menu-colum">
                                            <ul>
                                                <li><span class="mega-menu-text">Others</span></li>
                                                <li><a href="{{route('cart')}}">Cart Page</a></li>
                                                <li><a href="{{route('checkout')}}">Checkout Page</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="menu-text"> Pages</span>
                                        <i class="bi bi-arrow-down-short"></i>
                                    </a>
                                    <ul class="dropdown-submenu dropdown-hover">
                                        <li><a href="{{route('contact')}}">Contact</a></li>
                                        <li><a href="{{route('faq')}}">FAQ</a></li>
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
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{route('about.us')}}">
                                        <span class="menu-text"> About Us</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('contact')}}">
                                        <span class="menu-text">Contact Us</span><span class="newbar">New</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6 col-custom">
                        <div class="header-right-area main-nav">
                            <ul class="nav">
                                <li class="minicart-wrap">
                                    @php 
                                        $total_prod=0;
                                        $total_amount=0;
                                    @endphp
                                    <a href="#" class="minicart-btn toolbar-btn">
                                        <i class="bi bi-shop"></i>
                                        <span class="cart-item_count">{{Helper::cartCount()}}</span>
                                    </a>
                                    <div class="cart-item-wrapper dropdown-sidemenu dropdown-hover-2">
                                        @auth
                                        @php
                                        $cartItems = Helper::getAllProductFromCart();
                                        $currency = '';
                                        @endphp
                                        @foreach (Helper::getAllProductFromCart() as $item)
                                        <div class="single-cart-item">
                                            
                                            @php
                                                $photo=explode(',',$item->product['photo']);
                                                $currency = $item->product->currency;
                                            @endphp
                                            
                                            <div class="cart-img">
                                                <a href="{{route('cart')}}"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                            </div>
                                            <div class="cart-text">
                                                <h5 class="title"><a href="{{route('product-detail',$item->product['slug'])}}">{{$item->product['title']}}</a></h5>
                                                <div class="cart-text-btn">
                                                    <div class="cart-qty">
                                                        <span>{{$item->quantity}}×</span>
                                                        <span class="cart-price">{{ $currency }} {{number_format($item->price,2)}}</span>
                                                    </div>
                                                    <button type="button"><i class="ion-trash-b"></i></button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        @endforeach
                                        <div class="cart-price-total d-flex justify-content-between">
                                            <h5>Total :</h5>
                                            <h5>{{ $currency }} {{number_format(Helper::totalCartPrice(),2)}}</h5>
                                        </div>
                                        <div class="cart-links d-flex justify-content-between">
                                            <a class="btn product-cart button-icon flower-button dark-btn" href="{{route('cart')}}">View cart</a>
                                            <a class="btn flower-button secondary-btn rounded-0" href="{{route('checkout')}}">Checkout</a>
                                        </div>
                                        @endauth
                                    </div>
                                </li>
                                <li class="mini">
                                    @php 
                                        $total_prod=0;
                                        $total_amount=0;
                                    @endphp
                                    <a href="{{route('wishlist')}}" class="minicart-btn toolbar-btn">
                                        <i class="bi bi-bag-heart"></i>
                                        <span class="cart-item_count">{{Helper::wishlistCount()}}</span>
                                    </a>
                                </li>
                                <li class="sidemenu-wrap">
                                    <a href="#"><i class="bi bi-search"></i> </a>
                                    <ul class="dropdown-sidemenu dropdown-hover-2 dropdown-search">
                                        <li>
                                            <form method="POST" action="{{route('product.search')}}">
                                                @csrf
                                                <input name="search" id="search" placeholder="Search" type="search">
                                                <button type="submit"><i class="fa fa-search"></i></button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                <li class="account-menu-wrap d-none d-lg-flex">
                                    <a href="#" class="off-canvas-menu-btn">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </a>
                                </li>
                                <li class="mobile-menu-btn d-lg-none">
                                    <a class="off-canvas-btn" href="#">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Header Area End -->
        <!-- off-canvas menu start -->
        <aside class="off-canvas-wrapper" id="mobileMenu">
            <div class="off-canvas-overlay"></div>
            <div class="off-canvas-inner-content">
                <div class="btn-close-off-canvas">
                    <i class="fa fa-times"></i>
                </div>
                <div class="off-canvas-inner">
                    <div class="search-box-offcanvas">
                        <form>
                            @auth
                            <input  type="text" placeholder="{{number_format(Helper::moneyCount(),2)}}">
                                @else
                                <input  type="text" placeholder="0">
                            @endauth
                            <button class="search-btn" ><i class="fa fa-vcard"></i></button>
                        </form>
                    </div>
                    <!-- mobile menu start -->
                    <div class="mobile-navigation">
                        <!-- mobile menu navigation start -->
                        <nav>
                            <ul class="mobile-menu">
                                <li class="menu-item-has-children"><a href="#">Home</a>
                                    <ul class="dropdown">
                                        <li><a href="/">Home </a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children"><a href="#">Shop</a>
                                    <ul class="megamenu dropdown">
                                        <li class="mega-title has-children"><a href="#">Shop Layouts</a>
                                            <ul class="dropdown">
                                                <li><a href="{{route('product-list')}}">Shop List</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-title has-children"><a href="#">Product Details</a>
                                            <ul class="dropdown">
                                                <li><a href="{{route('wishlist')}}">Wishlist Product</a></li>
                                                <li><a href="{{route('compare')}}">Compare Product</a></li>
                                            </ul>
                                        </li>
                                        <li class="mega-title has-children"><a href="#">Others</a>
                                            <ul class="dropdown">
                                                <li><a href="{{route('compare')}}">Compare Page</a></li>
                                                <li><a href="{{route('cart')}}">Cart Page</a></li>
                                                <li><a href="{{route('checkout')}}">Checkout Page</a></li>
                                                <li><a href="{{route('wishlist')}}">Wish List Page</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children "><a href="#">Pages</a>
                                    <ul class="dropdown">
                                        <li><a href="{{route('faq')}}">FAQ</a></li>
                                        @auth
                                        @if(Auth::user()->role=='admin')
                                            <li><a href="{{route('admin')}}">Dashboard admin</a></li>
                                        @elseif(Auth::user()->role=='user')
                                            <li><a href="{{route('user')}}">Dashboard user</a></li>
                                        @else
                                            <li><a href="{{route('shipper.index')}}">Dashboard shipper</a></li>
                                        @endif
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    @else
                                    <li><a href="{{route('user.register')}}">login &amp; register</a></li>
                                   @endauth
                                    </ul>
                                </li>
                                <li><a href="{{route('about.us')}}">About Us</a></li>
                                <li><a href="{{route('contact')}}">Contact</a></li>
                            </ul>
                        </nav>
                        <!-- mobile menu navigation end -->
                    </div>
                    <!-- mobile menu end -->
                    <div class="offcanvas-widget-area">
                        <div class="switcher">
                            @auth
                            <div class="language">
                                <span class="switcher-title">Log Out: </span>
                                <div class="switcher-menu">
                                    <ul>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <li><a class="bi bi-person-fill-down":href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();"></a>
                                            </li>
                                        </form>
                                    </ul>
                                </div>
                            </div>
                            @endauth   
                            <div class="currency">
                                <span class="switcher-title">Track Order: </span>
                                <div class="switcher-menu">
                                    <ul><a href="{{route('order.track')}}"><i class="fa fa-truck"></i></a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="top-info-wrap text-left text-black">
                            <ul class="address-info">
                               
                                <li>
                                    <i class="fa fa-phone"></i>
                                    <a href="info%40yourdomain.html">@foreach($settings as $data) {{$data->phone}} @endforeach</a>
                                </li>
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <a href="info%40yourdomain.html">@foreach($settings as $data) {{$data->email}} @endforeach</a>
                                </li>
                            </ul>
                            <div class="widget-social">
                                @foreach ($settings as $data)
                                    @if ($data->facebook)
                                    <a class="facebook-color-bg" title="Facebook-f" href="https://www.facebook.com/{{$data->facebook}}"><i class="fa fa-facebook-f"></i></a>
                                    @endif
                                    @if ($data->twitter)
                                    <a class="twitter-color-bg" title="Twitter" href="https://twitter.com/{{$data->twitter}}"><i class="fa fa-twitter"></i></a>
                                    @endif
                                    @if ($data->linkedin)
                                    <a class="linkedin-color-bg" title="Linkedin" href="https://id.linkedin.com/{{$data->linkedin}}"><i class="fa fa-linkedin"></i></a>
                                    @endif
                                    @if ($data->youtube)
                                    <a class="youtube-color-bg" title="Youtube" href="https://www.youtube.com/{{$data->youtube}}"><i class="fa fa-youtube"></i></a>
                                    @endif
                                    @if ($data->instagram)
                                    <a class="vimeo-color-bg" title="Vimeo" href="https://www.instagram.com/{{$data->instagram}}"><i class="fa fa-instagram"></i></a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <!-- off-canvas menu end -->
        <!-- off-canvas menu start -->
        <aside class="off-canvas-menu-wrapper" id="sideMenu">
            <div class="off-canvas-overlay"></div>
            <div class="off-canvas-inner-content">
                <div class="off-canvas-inner">
                    <div class="btn-close-off-canvas">
                        <i class="fa fa-times"></i>
                    </div>
                    <!-- offcanvas widget area start -->
                    <div class="offcanvas-widget-area">
                        <ul class="menu-top-menu">
                            @if(Auth()->user())
                            <li><a href="{{route('about.us')}}" style="font-size: 20px;">Hi,{{Auth()->user()->name}}</a></li>
                            @else
                            @foreach($settings as $data)<li><a style="font-size: 20px;" href="{{route('about.us')}}">{{$data->title}}</a></li>@endforeach
                            @endif
                        </ul>
                        <p class="desc-content">@foreach($settings as $data) {{$data->short_des}} @endforeach</p>
                        <div class="switcher">
                            <div class="search-box-offcanvas">
                                <form>
                                    @auth
                                    <input  type="text" placeholder="{{number_format(Helper::moneyCount(),2)}}">
                                        @else
                                        <input  type="text" placeholder="0">
                                    @endauth
                                    <button class="search-btn" ><i class="fa fa-vcard"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="switcher">
                            @auth
                            <div class="language">
                                <span class="switcher-title">Log Out: </span>
                                <div class="switcher-menu">
                                    <ul>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <li><a class="bi bi-person-fill-down":href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();"></a>
                                            </li>
                                        </form>
                                    </ul>
                                </div>
                            </div>
                            @endauth   
                            <div class="currency">
                                <span class="switcher-title">Track Order: </span>
                                <div class="switcher-menu">
                                    <ul><a href="{{route('order.track')}}"><i class="fa fa-truck"></i></a>
                                    </ul>
                                </div>
                            </div>
                        </div>                  
                        <div class="top-info-wrap text-left text-black">
                            <ul class="address-info">
                                <li>
                                    <i class="fa fa-phone"></i>
                                    <a href="info%40yourdomain.html">@foreach($settings as $data) {{$data->phone}} @endforeach</a>
                                </li>
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <a href="info%40yourdomain.html">@foreach($settings as $data) {{$data->email}} @endforeach</a>
                                </li>
                            </ul>
                            <div class="widget-social">
                                @foreach ($settings as $data)
                                    @if ($data->facebook)
                                    <a class="facebook-color-bg" title="Facebook-f" href="https://www.facebook.com/{{$data->facebook}}"><i class="fa fa-facebook-f"></i></a>
                                    @endif
                                    @if ($data->twitter)
                                    <a class="twitter-color-bg" title="Twitter" href="https://twitter.com/{{$data->twitter}}"><i class="fa fa-twitter"></i></a>
                                    @endif
                                    @if ($data->linkedin)
                                    <a class="linkedin-color-bg" title="Linkedin" href="https://id.linkedin.com/{{$data->linkedin}}"><i class="fa fa-linkedin"></i></a>
                                    @endif
                                    @if ($data->youtube)
                                    <a class="youtube-color-bg" title="Youtube" href="https://www.youtube.com/{{$data->youtube}}"><i class="fa fa-youtube"></i></a>
                                    @endif
                                    @if ($data->instagram)
                                    <a class="vimeo-color-bg" title="Vimeo" href="https://www.instagram.com/{{$data->instagram}}"><i class="fa fa-instagram"></i></a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- offcanvas widget area end -->
                </div>
            </div>
        </aside>
        <!-- off-canvas menu end -->
    </header>
    <!-- Header Area End Here -->
    @foreach ($settings as $data)
    <div class="breadcrumbs-area position-relative" style="background-image: url({{$data->photo}})">
    @endforeach
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="breadcrumb-content position-relative section-content">
                        <h3 class="title-3">Checkout</h3>
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
          <div class="card-body">
            @if($order)
            <section class="confirmation_part section_padding">
              <div class="order_boxes">
                <div class="row">
                  <div class="col-lg-6 col-lx-4">
                    <div class="order-info">
                      <h4 class="text-center pb-4">ORDER INFORMATION</h4>
                      <table class="table">
                            <tr class="">
                                <td>Order Number</td>
                                <td> : {{$order->order_number}}</td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td> : {{$order->quantity}}</td>
                            </tr>
                            <tr>
                                <td>Order Status</td>
                                <td> : {{$order->status}}</td>
                            </tr>
                            <tr>
                              @php
                                  $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
                              @endphp
                                <td>Shipping</td>
                                <td> :{{ $currency }} {{$order->shipping->price}}</td>
                            </tr>
                            <tr>
                                <td>Total </td>
                                <td> : {{ $currency }} {{number_format($order->total_amount,2)}}</td>
                            </tr>
                            <tr>
                              <td>Payment methods</td>
                              <td> : @if($order->payment_method=='cod') Cash on Delivery  @elseif($order->payment_method=='rekening') rekening @else Go-market @endif</td>
                            </tr>
                            <tr>
                                <td>Payment Status</td>
                                <td> : {{$order->payment_status}}</td>
                            </tr>
                      </table>
                    </div>
                  </div>
        
                  <div class="col-lg-6 col-lx-4">
                    <div class="shipping-info">
                      <h4 class="text-center pb-4">INFORMATION</h4>
                      <table class="table">
                            <tr class="">
                                <td>Name</td>
                                <td> : {{$order->first_name}} {{$order->last_name}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td> : {{$order->email}}</td>
                            </tr>
                            <tr>
                                <td>Phone </td>
                                <td> : {{$order->phone}}</td>
                            </tr>
                            <tr>
                                <td>Address </td>
                                <td> : {{$order->address1}}, {{$order->address2}}</td>
                            </tr>
                            <tr>
                                <td>State / County </td>
                                <td> : {{$order->country}}</td>
                            </tr>
                            <tr>
                                <td>Postcode / Zip </td>
                                <td> : {{$order->post_code}}</td>
                            </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            @endif
        
          </div>
        </div>
    </div>
    <!--Footer Area Start-->
    <footer class="footer-area">
        <div class="footer-widget-area">
            <div class="container container-default custom-area">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-custom">
                        @php
							$settings=DB::table('settings')->get();
						@endphp
                        <div class="single-footer-widget m-0">
                            <div class="footer-logo">
                                <a href="/">
                                    @foreach ($settings as $data)
                                        <img class="img-full" src="{{$data->logo}}" alt="Header Logo">
                                    @endforeach
                                </a>
                            </div>
                            <div class="social-links">
                                @foreach ($settings as $data)
                                    <ul class="d-flex">
                                        <li>@if ($data->facebook)
                                                <a class="rounded-circle" href="https://www.facebook.com/{{$data->facebook}}" title="Facebook">
                                                    <i class="fa fa-facebook-f"></i>
                                                </a>
                                            @endif
                                        </li>
                                        <li>@if ($data->twitter)
                                                <a class="rounded-circle" href="https://twitter.com/{{$data->twitter}}" title="Twitter">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            @endif
                                        </li>
                                        <li>@if ($data->linkedin)
                                                <a class="rounded-circle" href="https://id.linkedin.com/{{$data->linkedin}}" title="Linkedin">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            @endif
                                        </li>
                                        <li>@if ($data->youtube)
                                                <a class="rounded-circle" href="https://www.youtube.com/{{$data->youtube}}" title="Youtube">
                                                    <i class="fa fa-youtube"></i>
                                                </a>
                                            @endif
                                        </li>
                                        <li>
                                            @if ($data->instagram)
                                                <a class="rounded-circle" href="https://www.instagram.com/{{$data->instagram}}" title="Vimeo">
                                                    <i class="fa fa-instagram"></i>
                                                </a>
                                            @endif
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-custom">
                        <div class="single-footer-widget">
                            <h2 class="widget-title">Information</h2>
                            <ul class="widget-list">
                                <li><a href="{{route('about.us')}}">Our Company</a></li>
                                <li><a  href="{{route('contact')}}">Contact Us</a></li>
                                <li><a href="{{route('faq')}}">FAQ</a></li>
                                <li><a href="{{route('about.us')}}">Careers</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-custom">
                        <div class="single-footer-widget">
                            <h2 class="widget-title">Quicklink</h2>
                            <ul class="widget-list">
                                <li><a href="{{route('about.us')}}">About</a></li>
                                <li><a href="{{route('product-list')}}">Shop</a></li>
                                <li><a href="{{route('cart')}}">Cart</a></li>
                                <li><a href="{{route('contact')}}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    @php
                        $customs=DB::table('custom')->get();
                    @endphp
                    <div class="col-12 col-sm-6 col-md-6 col-lg-2 col-custom">
                        @foreach ($customs as $custom)
                            @if ($custom->name == 'Support')
                        <div class="single-footer-widget">
                            <h2 class="widget-title">Support</h2>
                            <ul class="widget-list">
                                <li><a href="{{route('policy')}}">{{$custom->footer1}}</a></li>
                                <li><a href="{{route('policy')}}">{{$custom->footer2}}</a></li>
                                <li><a href="{{route('policy')}}">{{$custom->footer3}}</a></li>
                                <li><a href="{{route('policy')}}">{{$custom->footer4}}</a></li>
                            </ul>
                        </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-custom">
                        <div class="single-footer-widget">
                            <h2 class="widget-title">See Information</h2>
                            <div class="widget-body">
                                <address>@foreach($settings as $data) {{$data->address}} @endforeach<br>Phone: @foreach($settings as $data) {{$data->phone}} @endforeach<br>@foreach($settings as $data) {{$data->email}} @endforeach</address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright-area">
            <div class="container custom-area">
                <div class="row">
                    <div class="col-12 text-center col-custom">
                        <div class="copyright-content">
                            @foreach ($settings as $data)
                            <p id="copyright">
                                <script>
                                  const currentYear = new Date().getFullYear();
                                  document.getElementById("copyright").innerHTML =
                                    `Copyright © ${currentYear} <a href="#" title="{{$data->title}}">{{$data->title}}@endforeach</a> | Built with&nbsp;<strong>Erlangga Rychlewski</strong>&nbsp;by <a href="https://twitter.com/erlang_stack" title="https://twitter.com/erlang_stack">ErlanggTech</a>.`;
                                </script>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--Footer Area End-->

    <!-- JS
    ============================================ -->

    <!-- jQuery JS -->
    <script src="{{asset('frontend/assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
    <!-- jQuery Migrate JS -->
    <script src="{{asset('frontend/assets/js/vendor/jquery-migrate-3.3.2.min.js')}}"></script>
    <!-- Modernizer JS -->
    <script src="{{asset('frontend/assets/js/vendor/modernizr-3.7.1.min.js')}}"></script>
    <!-- Bootstrap JS -->
    <script src="{{asset('frontend/assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
    
    <!-- Swiper Slider JS -->
    <script src="{{asset('frontend/assets/js/plugins/swiper-bundle.min.js')}}"></script>
    <!-- nice select JS -->
    <script src="{{asset('frontend/assets/js/plugins/nice-select.min.js')}}"></script>
    <!-- Ajaxchimpt js -->
    <script src="{{asset('frontend/assets/js/plugins/jquery.ajaxchimp.min.js')}}"></script>
    <!-- Jquery Ui js -->
    <script src="{{asset('frontend/assets/js/plugins/jquery-ui.min.js')}}"></script>
    <!-- Jquery Countdown js -->
    <script src="{{asset('frontend/assets/js/plugins/jquery.countdown.min.js')}}"></script>
    <!-- jquery magnific popup js -->
    <script src="{{asset('frontend/assets/js/plugins/jquery.magnific-popup.min.js')}}"></script>
    
    <!-- Main JS -->
    <script src="{{asset('frontend/assets/js/main.js')}}"></script>


</body>



</html>