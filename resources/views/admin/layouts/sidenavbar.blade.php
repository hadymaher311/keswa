<!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ (Auth::user()->image) ? Storage::disk('local')->url(Auth::user()->image) : asset('/admin_styles/images/avatar04.png') }}" class="img-circle" alt="User Image">
          
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>  
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu">
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
