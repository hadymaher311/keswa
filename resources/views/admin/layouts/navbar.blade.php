<style>
  .main-header .sidebar-toggle:before {
    content: ''
  }
</style>
<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><i class="fa fa-user-md fa-lg"></i></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><i class="fa fa-user-md fa-lg"></i></b> {{ config('app.name') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <i class="fa fa-bars"></i>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- Notifications Menu -->
            <li class="dropdown notifications-menu">
              <!-- Menu toggle button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="far fa-bell"></i>
                @if ( count(Auth::user()->unreadNotifications->where('type','App\Notifications\MaterialsNotifications')) )
                <span class="label label-warning">{{ count(Auth::user()->unreadNotifications) }}</span>
                @endif
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have {{ count(Auth::user()->unreadNotifications) }} new notifications</li>
                <li>
                  <!-- Inner Menu: contains the notifications -->

                  <ul class="menu">
                    <?php $notifications = Auth::user()->notifications->where('type','App\Notifications\MaterialsNotifications'); ?>
                    <?php ?>
                    @foreach ($notifications as $notification)
                    <li ><!-- start notification -->
                      <a href="{{route('admin.notification.mark',$notification->id)}}">
                        @if ($notification->read_at)
                          <i class="fa fa-medkit"></i> {{$notification->data['content']}}
                        @else
                          <b><i class="fa fa-medkit"></i> {{$notification->data['content']}}</b>
                        @endif
                        
                      </a>
                    </li>
                    @endforeach
                    <!-- end notification -->
                  </ul>
                </li>
                <li class="footer"><a href="{{route('admin.notification.view')}}">View all</a></li>
              </ul>
            </li>


          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ (Auth::user()->image) ? Storage::disk('local')->url(Auth::user()->image) : asset('/admin_styles/images/user4-128x128.jpg') }}" class="user-image" alt="User Image">
              
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
              
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ (Auth::user()->image) ? Storage::disk('local')->url(Auth::user()->image) : asset('/admin_styles/images/user4-128x128.jpg') }}" class="img-circle" alt="User Image">
                
                <p>
                  {{ Auth::user()->name }}
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('admin.logout') }}"  class="btn btn-default btn-flat"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                      Logout
                  </a>
                  <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
