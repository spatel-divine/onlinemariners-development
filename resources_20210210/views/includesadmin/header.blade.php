<?php
  // echo '<pre>';
  // print_r($user);
  // exit;
  use App\User;
  // echo Session::get('userid');
  $user = User::where('name', '=', 'Super Admin')->first();
  // print_r($user->name);
  // exit;
?>
 <header class="main-header">
    <!-- Logo -->
    <a href="https://onlinemariners.com/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>M</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Online</b> Mariners</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
                  
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php
                $adminPic = url('/public/adminassets/dist/img/user2-160x160.jpg');
              ?>
              <img src="{{ $adminPic }}" class="user-image" alt="User Image">
              <span class="hidden-xs" style="text-transform: capitalize;">{{ isset($user->name) ? $user->name : ''  }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ $adminPic }}" class="img-circle" alt="User Image popup">
                <p>                
                  {{ isset($user->name) ? $user->name : ''  }}
                  <small>Member since <?php  echo date('M Y', strtotime($user->created_at)); ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>                
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
               <!--  <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="" style="text-align:center;">
                  <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">
                    Sign out
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="get" style="display: none;">
                        @csrf
                    </form>
                  </a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->          
        </ul>
      </div>
    </nav>
  </header>