<div class="app-admin-wrap layout-sidebar-large clearfix">
        <div class="main-header">
        <div class="menu-toggle">
            <div></div>
                    <div></div>
            <div></div>
        </div>
        <div style="margin: auto"></div>
        <div class="header-part-right">
            <!-- Notificaiton -->
            <div class="dropdown">
                <div class="badge-top-container" role="button">
                    <span class="badge badge-primary"></span>
                    <a href="{{route('delivery.dashboard')}}">
                        <i class="i-Refresh text-muted header-icon"></i>
                    </a>
                    
                </div>
                <!-- Notification dropdown -->
                <!-- <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                    <div class="dropdown-item d-flex">
                        <div class="notification-icon">
                            <i class="i-Speach-Bubble-6 text-primary mr-1"></i>
                        </div>
                        <div class="notification-details flex-grow-1">
                            <p class="m-0 d-flex align-items-center">
                                <span>New message</span>
                                <span class="badge badge-pill badge-primary ml-1 mr-1"></span>
                                <span class="flex-grow-1"></span>
                                <span class="text-small text-muted ml-auto"></span>
                            </p>
                            <p class="text-small text-muted m-0">Coming Soon</p>
                        </div>
                    </div>
                </div> -->
            </div>
            <!-- Notificaiton End -->
    <!-- User avatar dropdown -->
    <div class="dropdown">
        <div  class="user col align-self-end">
            <img src="{{asset('public/delivery/assets//images/faces/1.jpg')}}" id="userDropdown" alt="N/A" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

          <!--   <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <div class="dropdown-header">
                    <i class="i-Lock-User mr-1"></i> Timothy Carlson
                </div>
                <a class="dropdown-item">Account settings</a>
                <a class="dropdown-item">Billing history</a>
                <a class="dropdown-item" href="sessions/signIn.html">Sign out</a>
            </div> -->
        </div>
    </div>
</div>
</div>
<!-- header top menu end -->
<div class="side-content-wrap">
<div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
    <ul class="navigation-left">
        <li class="nav-item" >
            <a class="nav-item-hold" href="{{route('delivery.dashboard')}}">
                <i class="nav-icon i-Bar-Chart"></i>
                <span class="nav-text">Dashboard</span>
                <div class="triangle"></div>
            </a>
        </li>        
        <li class="nav-item" >
            <a href="{{route('delivery.all')}}" class="all-delivery nav-item-hold">
                <i class="nav-icon i-Car text-success"></i>
                <span class="nav-text">All Delivery</span>
                <div class="triangle"></div>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-item-hold" href="{{ route('delivery.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon i-Unlock"></i>
                <span class="nav-text">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('delivery.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="triangle"></div>
        </li>
    </ul>
</div>


