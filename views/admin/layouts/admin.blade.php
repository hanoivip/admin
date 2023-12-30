
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/css/ionicons.min.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/css/jquery-jvectormap.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE/css/_all-skins.min.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="access-token" content="{{ current_user_device_token() }}">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="{{ route('user-find') }}" class="logo"><span class="logo-mini"><b>Admin</b></span><span class="logo-lg"><b>Admin</b></span></a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <ul class="dropdown-menu">
              <li class="dropdown user user-menu">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{ asset('img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                  	<span class="hidden-xs">
                  	@if (Auth::check())
                  		{{ Auth::user()->getAuthIdentifierName() }}(ID:{{ Auth::user()->getAuthIdentifier() }})
		            @endif 
		        	</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="javascript:void(0);" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{route('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
          <li>
            <a href="javascript:void(0);" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          	<p>
	          	@if (Auth::check())
	          		{{ Auth::user()->getAuthIdentifierName() }}(ID:{{ Auth::user()->getAuthIdentifier() }})
	            @endif
		    </p>
          <a href="javascript:void(0);"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Admin Menu</li>
        
        <li class="active">
          <a href="{{ route('user-find') }}">
            <i class="fa fa-table"></i> <span>Manage Users</span>
          </a>
        </li>
        <li>
          <a href="{{ route('server-info') }}">
            <i class="fa fa-laptop"></i> <span>Manage Servers</span>
          </a>
        </li>
        @if (Route::has('ecmin.policy'))
    	<li>
          <a href="{{ route('ecmin.policy') }}">
            <i class="fa fa-laptop"></i> <span>Manage Saleoff</span>
          </a>
        </li>
        @endif
        @if (Route::has('ecmin.income'))
    	<li>
          <a href="{{ route('ecmin.income') }}">
            <i class="fa fa-laptop"></i> <span>Revenue</span>
          </a>
        </li>
        @endif
        @if (Route::has('ecmin.stats'))
    	<li>
          <a href="{{ route('ecmin.stats') }}">
            <i class="fa fa-laptop"></i> <span>Statistics</span>
          </a>
        </li>
        @endif
        @if (Route::has('gift.package.list'))
        <li class=" treeview menu-open">
          <a href="javascript:void(0);">
            <i class="fa fa-dashboard"></i> <span>Manage Giftcodes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('gift.package.list') }}"><i class="fa fa-circle-o"></i>Gift Templates</a></li>
            <li><a href="{{ route('gift.batch-generate.ui') }}"><i class="fa fa-circle-o"></i>Gift</a></li>
          </ul>
        </li>
        @endif
        @if (Route::has('ecmin.messages'))
    	<li>
          <a href="{{ route('ecmin.messages') }}">
            <i class="fa fa-laptop"></i> <span>User Messages</span>
          </a>
        </li>
        @endif
        <!-- 
        @if (Route::has('ecmin.newrecharge'))
    	<li>
          <a href="{{ route('ecmin.newrecharge') }}">
            <i class="fa fa-laptop"></i> <span>Quản lý nạp - newrecharge</span>
          </a>
        </li>
        @endif
        @if (Route::has('ecmin.webtopup'))
    	<li>
          <a href="{{ route('ecmin.webtopup') }}">
            <i class="fa fa-laptop"></i> <span>Quản lý nạp - webtopup</span>
          </a>
        </li>
        @endif
        -->
        <li>
          <a href="{{ route('ecmin.mods') }}">
            <i class="fa fa-laptop"></i> <span>Manage Mods</span>
          </a>
        </li>
        @if (Route::has('ecmin.tsr'))
    	<li>
          <a href="{{ route('ecmin.tsr') }}">
            <i class="fa fa-laptop"></i> <span>Thesieure.com</span>
          </a>
        </li>
        @endif
        @if (Route::has('ecmin.broadcast'))
    	<li>
          <a href="{{ route('ecmin.broadcast') }}">
            <i class="fa fa-laptop"></i> <span>Broadcast System Message</span>
          </a>
        </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	@if(!empty($message))
        <div class="alert alert-success alert-dismissible">
        {{ $message }}
        </div>
    @endif
    
    @if(!empty($error_message))
        <div class="alert alert-danger alert-dismissible">
        {{ $error_message }}
        </div>
    @endif
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>
              <div class="menu-info">
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>
              <div class="menu-info">

              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->

      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('AdminLTE/js/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('AdminLTE/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('AdminLTE/js/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/js/adminlte.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('AdminLTE/js/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap  -->
<script src="{{ asset('AdminLTE/js/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('AdminLTE/js/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('AdminLTE/js/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('AdminLTE/js/Chart.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('AdminLTE/js/dashboard2.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE/js/demo.js') }}"></script>

<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
@stack('scripts')
	
</body>
</html>
