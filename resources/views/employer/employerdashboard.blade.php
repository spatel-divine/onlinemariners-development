@extends('layouts.app_afterLogin')
 
@section('content')
<?php
// print_r($conversationUnreadCount);
// exit;
    // echo '<pre>'; 
    // // echo ($postJobByEmp[0]->job_title.'<br>');
    // print_r($ActivePostedCount);
    // exit;
// var_dump($empImg[0]->profile_status == 1);
// exit;
?>
<!-- General Detail Start -->
<style type="text/css">
    .control-fileupload:before
    {
        display: none !important;
    }
 
 </style>
<section class="dashboard-wrap" >
    <div class="container-fluid">
        <div class="row fartonav">
            <!-- Sidebar Wrap -->
            <div class="col-lg-3 col-md-4">
                <div class="side-dashboard">
                    <div class="dashboard-avatar">
                        <form class="emp-img-form"  method="POST" action="{{ route('employer.image') }}" enctype="multipart/form-data">
                            @csrf      
                            <div class="dashboard-avatar-thumb">
                                <?php                                    
                                    $filename = $empImg[0]->pic_path;
                                    if($filename == 'emp-default.png' || $filename == ''){
                                        $url = url('/public/assets/img/emp-default.png');     
                                    }else{
                                        $url = url('/public/empProfile/'.$filename); 
                                    }
                                    
                                ?>
                                @if(isset($empImg))
                                    <img src="{{ $url }}" class="img-avater" alt="emp-pic" />
                                @else
                                    <img src="public/assets/img/emp_default.png" class="img-avater" alt="employer-profile-image" />
                                @endif
                                
                            </div>
                            <div class="dashboard-avatar-text">
                                <h4>{{ $user = Session::get('employerName') }}</h4>
                            </div>
                            <div style="position: relative;bottom:35px;right: 30%;">
                                @if(isset($user))
                                <span class="activeStatus"></span>                            
                                @endif
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <span class="control-fileupload">
                                    <label for="file">Update Profile Image</label>
                                    <input type="file" name="pic_path" id="pic_path">
                                    </span>
                                    <span class="sizenote">Max Image Size : 2MB</span>
                                </div>
                            </div>
                            <input type="submit" name="submit" value="Update"> 
                        </form>
                            
                    </div>
                    
                    <div class="dashboard-menu">
                        <!-- include from includes layouts-->
                        <ul>
                            <li class="<?php echo(request()->is('employer/dashboard')) ? 'active':'' ?>">
                                <a href="{{ route('employer.dashboard') }}"><i class="ti-dashboard"></i>Dashboard</a>
                            </li>
                            <li class="<?php echo(request()->is('employer/profile')) ? 'active':'' ?>">
                                <a href="{{ route('employer.profile') }}"><i class="ti-briefcase"></i>Create or Update Profile</a>
                            </li>
                            <!-- <li class="<?php //echo(request()->is('employer/edit')) ? 'active':'' ?>">
                                <a href="{{-- route('employer.edit') --}}"><i class="ti-briefcase"></i>Update Profile</a>
                            </li> -->
                            @if(isset($empImg[0]->profile_status) && ($empImg[0]->profile_status == 1))
                            <li class="<?php echo(request()->is('employer/postajob')) ? 'active':'' ?>">
                                <a href="{{ route('postjob.index') }}"><i class="ti-ruler-pencil"></i>Post New Job</a>
                            </li>
                            <li class="<?php echo(request()->is('employer/postajob/listing')) ? 'active':'' ?>">
                                <a href="{{ route('postjob.listing') }}"><i class="ti-user"></i>Post Job Listing and Update</a>
                            </li>    
                            <li class="<?php echo(request()->is('employer/application/listing')) ? 'active':'' ?>">
                                <a href="{{ route('lists.appliedjob') }}"><i class="ti-user"></i>Candidate Job Applied List</a>
                            </li>
                            
                            <?php

                              $empEmail = Session::get('employerEmail');                                    
                              if(isset($empEmail)){
                                $chatUserData = DB::select("SELECT *  FROM users where email="."'".$empEmail."'");
                                $empUser = DB::select("SELECT *  FROM employer where email="."'".$empEmail."'");

                              if(isset($chatUserData[0]) && ($empUser[0]->email_varified == '1') && ($empUser[0]->profile_status == '1')){
                                // $email = Crypt::encryptString($chatUserData[0]->email);
                                // $password = $chatUserData[0]->decrpted_password;
                                //'http://chatingapp.onlinemariners.com/login?email='.$email.'&&password='.$password 
                              ?>
                                <li class="<?php echo(request()->is('/conversations')) ? 'active':'' ?>">
                                    <a href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatUserData[0]->id }}" >
                                        <i class="ti-headphone-alt"></i> Chat Here
                                    </a>
                                </li>
                            <?php 
                                    }
                                } 
                            ?>
                            @endif                            
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Content Wrap -->
            <div class="col-lg-9 col-md-8">
                <div class="dashboard-body">
                    <!-- Flash Msg on success-->
                    <div class="alert alert-success alert-dismissable fade in" style="padding: 2% 0">
                        <!-- <p style="padding-left: 18px; text-transform: uppercase;">Kindly, Check our <a href="http://onlinemariners.com/knowledgeBase" target="_blank">Knowledgebase</a> page to know how to post a job for candidate and other operations.For other issue contact to support. </p> -->
                        <p style="padding-left: 18px; text-align: center;text-transform: uppercase;">KINDLY CHECK OUR <a href="http://onlinemariners.com/knowledgeBase" target="_blank">KNOWLEDGE BASE</a> PAGE TO KNOW HOW TO POST A JOB FOR A CANDIDATE AND OTHER OPERATIONS. <br> FOR OTHER QUERIES CONTACT ONLINE MARINERS CHAT SUPPORT.</p>
                    </div>
                    <!-- Unread message flash -->
                    @if($conversationUnreadCount > 0)
                        <div class="alert alert-success alert-dismissable fade in" style="padding-bottom: 3%;">
                            <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                            <p style="padding-left: 18px;text-transform: uppercase;">
                            <?php

                              $empEmail = Session::get('employerEmail');                                    
                              if(isset($empEmail)){
                                $chatUserData = DB::select("SELECT *  FROM users where email="."'".$empEmail."'");
                                $empUser = DB::select("SELECT *  FROM employer where email="."'".$empEmail."'");

                              if(isset($chatUserData[0]) && ($empUser[0]->email_varified == '1') && ($empUser[0]->profile_status == '1')){
                                // $email = Crypt::encryptString($chatUserData[0]->email);
                                // $password = $chatUserData[0]->decrpted_password;
                                //'http://chatingapp.onlinemariners.com/login?email='.$email.'&&password='.$password 
                              ?>
                                
                                {{ 'You have '.$conversationUnreadCount.' unread messages.'  }}
                                <a href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatUserData[0]->id }}" >
                                    <i class="ti-headphone-alt"></i> Click TO Chat
                                </a>
                            <?php 
                                    }
                                } 
                            ?>                            
                        </div>
                    @endif
                    <!-- end of Unread message flash -->
                    @if( session('success') )
                        <div class="msg alert alert-success alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <b>Success ! </b>{{ session('success') }}
                        </div>
                    @endif

                    
                    @if(isset($empImg[0]->profile_status) && ($empImg[0]->profile_status == 0))
                        <div class="alert alert-danger alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <b>Alert ! </b>{{ 'Active account by clicking on "Create OR Update profile" menu -> Change Message -> Activate Account For Post a Job By Activating and Account For that In Menu Click on Create or Update Profile.'  }}
                        </div>
                    @endif
                    <div class="dashboard-caption">
                                
                        <div class="dashboard-caption-header">
                            <h4><i class="ti-settings"></i>Dashboard</h4>
                        </div>
                        <?php
                    // echo 'rrr<pre>';
                    //     print_r($empImg);
                    //     var_dump($empImg[0]->profile_status == 0)
                    ?>
                        <div class="dashboard-caption-wrap">
                        
                            <!-- Overview -->
                            <div class="row">
                                <!-- Box 1 -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a style="color: white;" href="{{ url('/employer/postajob/listing') }}">
                                        <div class="dashboard-stat widget-1">
                                            <div class="dashboard-stat-content">
                                                <h4>{{ $ActivePostedCount }}</h4>
                                            	<span>Active Post Jobs</span>                                            
                                            </div>
                                            <div class="dashboard-stat-icon"><i class="ti-location-pin"></i></div>
                                        </div>
                                    </a>
                                </div>
                                <!-- Box 2 -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a style="color: white;" href="{{ url('/employer/application/listing') }}">
                                        <div class="dashboard-stat widget-2">
                                            <div class="dashboard-stat-content">
                                                <h4>{{ $ShotlistedCandidateCount }}</h4>    	
                                            	<span>Shortlisted Candidates</span>    
                                            </div>
                                            <div class="dashboard-stat-icon"><i class="ti-layers"></i></div>
                                        </div>
                                    </a>
                                </div>
                                <!-- Box 3 -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a style="color: white;" href="{{ url('/All/candidate/Gridlist/') }}">
                                        <div class="dashboard-stat widget-4">
                                            <div class="dashboard-stat-content">
                                                <h4>{{ $activedCandidateCount}}</h4>        	
                                            	<span>Active Candidates</span>
                                            </div>
                                            <div class="dashboard-stat-icon"><i class="ti-bookmark"></i></div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Box 4 -->
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a style="color: white;" href="{{ url('/employer/postajob/listing') }}">
                                        <div class="dashboard-stat widget-3">
                                            <div class="dashboard-stat-content">
                                                <h4>{{ $jobpostCount }}</h4>
                                                <span>Total Jobs Posted</span>
                                            </div>
                                            <div class="dashboard-stat-icon"><i class="ti-pie-chart"></i></div>
                                        </div>
                                    </a>
                                </div>
                                
                            </div>
                            

                            <!--  List -->
                            <div class="row" style="text-align: center; padding-top: 2%;">
                                <div class="col-sm-12">
                                    <h3 style="color: green;">Job Post List</h3>
                                </div>
                            </div>
                            <table id="employer_active_jobpost_tbl" class="display table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>                                        
                                        <th>Employer</th>
                                        <th>Company Name</th>
                                        <th>Vessel Type</th>
                                        <th>Application Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($postJobByEmp as $job)
                                        <tr>                                            
                                            <td>{{ $job->employer_name }}</td>
                                            <td>{{ $job->company_name }}</td>
                                            <td>{{ $job->vassel_type }}</td>
                                            <td>{{ date('m/d/Y',strtotime($job->app_deadline)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>                                        
                                        <th>Employer</th>
                                        <th>Company Name</th>
                                        <th>Vessel Type</th>
                                        <th>Application Deadline</th>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>                        
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</section>
			<!-- General Detail End -->
@endsection
@section('datepicker')
<script>
    $('#candidate-dob').dateDropper();
    $('#availablefrom').dateDropper();
    $('#expirejob').dateDropper();
    $('#employer_active_jobpost_tbl').DataTable();

    //resume upload 
    $(function() {
      $('input[type=file]').change(function(){
        var t = $(this).val();
        var labelText = 'File : ' + t.substr(12, t.length);
        $(this).prev('label').text(labelText);
      })
    });
</script>

@endsection