@extends('layouts.app_afterLogin')
 
@section('content')
<?php
    // echo "<pre>";
    // print_r($profileimg);
    // exit;
?>
<!-- General Detail Start -->
<section class="dashboard-wrap">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Wrap -->
            <div class="col-lg-3 col-md-4">
                <div class="side-dashboard">
                    <div class="dashboard-avatar">                                            
                        <div class="dashboard-avatar-thumb">                                
                            <?php                                            
                                $name = $profileimg[0]->profile_path;
                                if($name == 'avatar-default.png'){
                                    $url = url('public/assets/img/avatar-default.png'); 
                                }else{
                                    $url = url('/public/profile/'.$name);
                                }  
                            ?>
                            @if(isset($name))
                            <img src="{{ $url }}" class="img-avater" alt="img-avater" />
                            @else
                            <img src="{{ url('public/assets/img/avatar-default.png') }}" class="img-avater" alt="img-avater1" />
                            @endif                                                           
                        </div>
                        <div class="dashboard-avatar-text">
                            <h4 style="text-transform: capitalize;">{{ Session::get('userName') }}</h4>
                        </div>                                                        
                    </div>
                    
                    <div class="dashboard-menu">
                        <ul>
                            <li><a href="{{ route('cand.dashboard') }}"><i class="ti-dashboard"></i>Dashboard</a></li>
                            @if($profileimg[0]->candidate_status == 0)
                            <li>
                                <a href="{{ route('cand.profile') }}"><i class="ti-ruler-pencil"></i>Create Profile</a>
                            </li>
                            @endif 
                            @if($profileimg[0]->candidate_status == 1)
                            <li>
                                <a href="{{ route('cand.edit') }}"><i class="ti-briefcase"></i>Update Profile</a>
                            </li>
                            <li>
                                <a href="{{ route('endorsment.docs') }}"><i class="ti-briefcase"></i>Documents</a>
                            </li>
                            <li>
                                <a href="{{ route('cand.applylist') }}"><i class="ti-briefcase"></i>Job Applications</a>
                            </li>
                            <li class="active">
                                <a href="{{ route('profileViewByEmployer') }}"><i class="ti-briefcase"></i>Profile Viewed by Employer</a>
                            </li>                             
                            @endif
                            <?php
                              $candEmail = Session::get('userEmail');
                              if(isset($candEmail)){
                                $chatUserData = DB::select("SELECT *  FROM users where email="."'".$candEmail."'");
                                $candidateUser = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");

                              if(isset($chatUserData[0]) && ($candidateUser[0]->email_verified_at == '1') && ($candidateUser[0]->candidate_status == '1')){                                
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
                        </ul>                        
                    </div>
                </div>
            </div>
            
            <!-- Content Wrap -->
            <div class="col-lg-9 col-md-8">
                <div class="dashboard-body">
                <!--KnowledgeBase permanent  -->
                @include('includes.candidateknowlwdgebase')
                <!-- Unread message flash -->
                @if($conversationUnreadCount > 0)
                    <div class="alert alert-success alert-dismissable fade in" style="padding-bottom: 3%;">
                        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                        <p style="padding-left: 18px;text-transform: uppercase;">
                        <?php
                          $candEmail = Session::get('userEmail');
                          if(isset($candEmail)){
                            $chatUserData = DB::select("SELECT *  FROM users where email="."'".$candEmail."'");
                            $candidateUser = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");

                          if(isset($chatUserData[0]) && ($candidateUser[0]->email_verified_at == '1') && ($candidateUser[0]->candidate_status == '1')){                            
                        ?>
                            {{ 'You have '.$conversationUnreadCount.' unread messages.'  }}
                                <a href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatUserData[0]->id }}" >
                                    <i class="ti-headphone-alt"></i> Click To Chat
                                </a>
                            
                        <?php 
                                }
                            } 
                        ?>
                            
                        </p>
                    </div>
                @endif
                <!-- end of Unread message flash -->
                <!-- Flash Msg on success-->
                @if( session('success') )
                    <div class="msg alert alert-success alert-dismissable fade in" style="padding-bottom: 3%;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <b>Success ! </b>{{ session('success') }}
                    </div>
                @endif
                <!-- Flash Msg on success-->
                @if( session('error') )
                    <div class="msg alert alert-danger alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <b>Error ! </b>{{ session('error') }}
                    </div>
                @endif
                <div class="dashboard-body">
                        
                    <div class="dashboard-caption">
                        
                        <div class="dashboard-caption-header">
                            <h4><i class="ti-settings"></i>Profile Viewed by Employer </h4>
                        </div>                        
                        <div class="dashboard-caption-wrap">
                            <div class="row">
                               
                                @if(isset($employerList))
                                <table id="candidate_job_listing" class="display table table-striped table-bordered dataTable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Employer Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employerList as $e)
                                        <?php
                                            // $postajobID = $postjobs[0]->id;
                                            // $jobdetails = url('/postajob/details/'.$postajobID.'?requestpage=browsejoblist');
                                        ?>
                                        <tr>
                                            <td>{{ $e->company_name }}</td>
                                            <td>{{ $e->name }}</td>
                                            <td>{{ $e->email }}</td>
                                            <td>{{ $e->mobile_number }}</td>
                                            <td>{{ $e->city }}</td>
                                            <td>{{ $e->country }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Employer Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>City</th>
                                            <th>Country</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
                </div><!-- End Dashboard body-->
            </div>
        
        </div>
    </div>
</section>
			<!-- General Detail End -->
@endsection
@section('datepicker')
<script>
	$(document).ready(function () {
	    $('#candidate_job_listing').DataTable();
    });
</script>

@endsection