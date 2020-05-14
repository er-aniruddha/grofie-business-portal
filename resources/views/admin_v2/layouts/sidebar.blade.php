<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="#">Admin Panel</a>
    </div>


    <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> {{Auth::user()->name}} <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                    </form> 
                </li>
            </ul>
        </li>
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
               
                <li>
                    <a href="{{ route ('admin.dashboard')}}" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('user.index')}}"><i class="fa fa-user fa-fw"></i> Users</a>   
                </li>
                <li>
                    <a href="{{ route('order.index')}}"><i class="fa fa-shopping-cart fa-fw"></i> Orders</a>   
                </li>             
                <li>
                    <a href="{{ route ('category.index')}}"><i class="fa fa-list fa-fw"></i> Category</a>
                </li>
                <li>
                    <a href="{{ route ('sub-category.index')}}"><i class="fa fa-list fa-fw"></i> Sub-Category</a>
                </li>
                <li>
                    <a href="{{ route ('brand.index')}}"><i class="fa fa-wrench fa-fw"></i> Brands</a>
                </li>         
                <li>
                    <a href="{{ route('product.index')}}"><i class="fa fa-wrench fa-fw"></i> Products</a>   
                </li> 
                <li>
                    <a href="{{ route('order.delivery.charges')}}"><i class="fa fa-money fa-fw"></i> Delivery Charges</a>   
                </li> 
                <li>
                    <a href="{{ route('store.index')}}"><i class="fa fa-institution fa-fw"></i> Store Locator</a>   
                </li> 
                <li>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i> Apps Home Page<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ route ('apps.home.page.new.product')}}">New Product</a>
                        </li>
                        <li>
                            <a href="{{ route ('apps.home.page.category')}}">New Category</a>
                        </li>                        
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="{{ route ('delivery.index')}}"><i class="fa fa-motorcycle fa-fw"></i> Delivery Associates</a>   
                </li> 
               
                <li>
                    <a href="{{ route ('admin.settings')}}"><i class="fa fa-gear"></i> Settings</a>   
                </li> 
            </ul>
        </div>
    </div>
</nav>