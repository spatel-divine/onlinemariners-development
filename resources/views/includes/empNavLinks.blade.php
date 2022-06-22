
<ul>
    <li class="<?php echo(request()->is('employer/dashboard')) ? 'active':'' ?>">
    	<a href="{{ route('employer.dashboard') }}"><i class="ti-dashboard"></i>Dashboard</a>
    </li>
    <li class="<?php echo(request()->is('employer/profile')) ? 'active':'' ?>">
    	<a href="{{ route('employer.profile') }}"><i class="ti-briefcase"></i>Create or Update Profile</a>
    </li>
    <li class="<?php echo(request()->is('employer/postajob')) ? 'active':'' ?>">
    	<a href="{{ route('postjob.index') }}"><i class="ti-ruler-pencil"></i>Post New Job</a>
    </li>
    <li class="<?php echo(request()->is('employer/postajob/listing')) ? 'active':'' ?>">
    	<a href="{{ route('postjob.listing') }}"><i class="ti-user"></i>Post Job Listing and Update</a>
    </li>    
    <li class="<?php echo(request()->is('employer/application/listing')) ? 'active':'' ?>">
        <a href="{{ route('lists.appliedjob') }}"><i class="ti-user"></i>Candidate Job Applied List</a>
    </li>
</ul>