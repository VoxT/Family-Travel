<div class="left_col col-md-3">
	<div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
          <a href="{{url('admin')}}" class="site_title"><i class="fa fa-paw"></i> <span>Gentellela Alela!</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
          <div class="profile_pic">
          </div>
          <div class="profile_info" style="text-align: center;">
            <span>Welcome,</span>
            <h2>{{ Auth::user()->full_name }}</h2>
          </div>
        </div>
        <!-- /menu profile quick info -->

        <br>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section active">
            <h3>Menu</h3>
            <ul class="nav child_menu" style="display: inherit;">
              <li><a href="{{url('admin/users')}}">Người dùng</a></li>
              <li><a href="{{url('admin/flights')}}">Danh sách chuyến bay</a></li>
              <li><a href="{{url('admin/hotels')}}">Danh sách khách sạn</a></li>
              <li><a href="{{url('admin/cars')}}">Danh sách thuê xe</a></li>
              <li><a href="{{url('admin/places')}}">Danh sách địa điểm</a></li>
              <li><a href="{{url('admin/payments')}}">Thanh toán</a></li>
            </ul>
          </div>

        </div>
        <!-- /sidebar menu -->
      </div>
</div>
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span>{{ Auth::user()->full_name }}</span>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>