        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark sidebar-image accordion" id="accordionSidebar">
            @php
                $settings=DB::table('settings')->get();
            @endphp
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
                @foreach ($settings as $data)
                <img class="img-full " style="padding:15px" src="{{$data->logo}}" alt="Header Logo">
                @endforeach
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-atlas"></i>
                    <span>Brand</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"  href="{{route('brand.create')}}">create brand</a>
                        <a class="collapse-item" href="{{route('brand.index')}}">Brand</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-image"></i>
                  <span>Banners</span>
                </a>
                <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Banner Options:</h6>
                    <a class="collapse-item" href="{{route('banner.index')}}">Banners</a>
                    <a class="collapse-item" href="{{route('banner.create')}}">Add Banners</a>
                  </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-images"></i>
                  <span>Small Banners</span>
                </a>
                <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Banner Options:</h6>
                    <a class="collapse-item" href="{{route('small-banner.index')}}">Small Banners</a>
                    <a class="collapse-item" href="{{route('small-banner.create')}}">Add Small Banners</a>
                  </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fab fa-audible"></i>
                    <span>Product</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{route('product.create')}}">Add Product</a>
                        <a class="collapse-item" href="{{route('product.index')}}">View Product</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Category</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item"href="{{route('category.create')}}">Add Category</a>
                        <a class="collapse-item" href="{{route('category.index')}}">View Category</a>

                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse" aria-expanded="true" aria-controls="shippingCollapse">
                  <i class="fas fa-truck"></i>
                  <span>Shipping</span>
                </a>
                <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Shipping Options:</h6>
                    <a class="collapse-item" href="{{route('shipping.index')}}">Shipping</a>
                    <a class="collapse-item" href="{{route('shipping.create')}}">Add Shipping</a>
                  </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#section" aria-expanded="true" aria-controls="shippingCollapse">
                    <i class="fa fa-header" style="font-size:17px"></i>
                  <span>Section</span>
                </a>
                <div id="section" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Section Options:</h6>
                    <a class="collapse-item" href="{{route('section.index')}}">Section Title 1</a>
                    <a class="collapse-item" href="{{route('section2.index')}}">Section Small Title 2</a>
                  </div>
                </div>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                     Addons
                </div>
            
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('order.index')}}">
                    <i class="fas fa-hammer fa-chart-area"></i>
                    <span>Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('transaction.index')}}">
                    <i class="fa fa-credit-card"></i>
                    <span>Transaction</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('coupon.index')}}">
                    <i class="fa fa-percent"></i>
                    <span>Coupon</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('users.index')}}">
                    <i class="fas fa-users"></i>
                    <span>Users</span></a>
            </li>
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('carrer.index')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Carrer</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('faq.index')}}">
                    <i class="fas fa-align-left"></i>
                    <span>FAQ</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('plugin.index')}}">
                    <i class="fa fa-gear fa-spin"></i>
                    <span>Plugin</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('recruitment')}}">
                    <i class='fas fa-briefcase'></i>
                    <span>Recruitment</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('custom.index')}}">
                    <i class="material-icons">&#xe242;</i>
                    <span>Custom Footer</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('emailsetting.index')}}">
                    <i class="fa fa-envelope" ></i>
                    <span>Email Setting</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->


        </ul>
        <!-- End of Sidebar -->