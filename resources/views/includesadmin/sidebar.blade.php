<?php
  use App\User;  
  $user = User::where('name', '=', 'Super Admin')->first();
  $adminPic = url('/public/adminassets/dist/img/user2-160x160.jpg');              
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ $adminPic }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ $user->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <!-- Dashboard treeview-->
        <li class="<?php echo(request()->is('admin/dashboard')) ? ' active':'' ?>">
          <a href="{{ route('admin.dashboard') }}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span> 
            <!-- <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span> -->
          </a>          
        </li>

        <!-- Employer -->
         <li class="treeview <?php echo(request()->is('admin/employer/listing') || request()->is('admin/employee/load/form')) ? ' active':'' ?>">
          <a href="#">
            <i class="fa fa-users"></i> <span>Employer</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('employer.lists') }}"><i class="fa fa-circle-o"></i>Employer Listing</a></li>
            <li><a href="{{ route('emploadform') }}"><i class="fa fa-circle-o"></i> Add Employer</a></li>
          </ul>
        </li>

        <!-- Candidates -->
         <li class="treeview <?php echo(request()->is('admin/candidate/listing') || request()->is('admin/candidate/load/form')) ? ' active':'' ?>">
          <a href="#">
            <i class="fa fa-users"></i> <span>Candidates</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('candidate.listing') }}"><i class="fa fa-circle-o"></i>Candidate Listing</a></li>
            <li><a href="{{ route('candiform') }}"><i class="fa fa-circle-o"></i> Add Candidate </a></li>
          </ul>
        </li>

        <!-- Post Job -->
         <li class="treeview <?php echo(request()->is('admin/postjob/listing') || request()->is('admin/postjob/form')) ? ' active':'' ?>">
          <a href="#">
            <i class="fa fa-briefcase"></i> <span>Post Job</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('postjobs.lists') }}"><i class="fa fa-circle-o"></i> Postjob Listing</a></li>
            <li><a href="{{ route('addPostjob') }}"><i class="fa fa-circle-o"></i> Add Postjob </a></li>
          </ul>
        </li>

        <!-- Apply Job -->
         <li class="<?php echo(request()->is('admin/jobapply/listing')) ? ' active':'' ?>">
          <a href="{{ route('jobapply.listing') }}">
            <i class="fa fa-briefcase"></i> <span>Applied Jobs</span>            
          </a>          
        </li>

        <li class="<?php echo(request()->is('admin/enquiries')) ? ' active':'' ?>">
          <a href="{{ route('enquiries') }}">
            <i class="fa fa-briefcase"></i> <span>Enquiries</span>            
          </a>          
        </li>
        <!-- Document Job -->
         <!--<li class="treeview <?php //echo(request()->is('admin/documents/listing') || request()->is('admin/documents/loadform')) ? ' active':'' ?>">
          <a href="#">
            <i class="fa fa-briefcase"></i> <span>New Documents</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li><a href="{{ route('admin.doclisting') }}"><i class="fa fa-circle-o"></i> Listing</a></li> 
            <li><a href="{{ route('admin.loadDocForm') }}"><i class="fa fa-circle-o"></i> Add </a></li>
          </ul>
        </li>-->
        <!-- other -->
        <!-- <li class="treeview">
          <a href="javascript:void(0);">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="javascript:void(0);"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li> -->        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>