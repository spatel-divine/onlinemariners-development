@extends('layouts.app_afterLogin')
 
@section('content')
<?php 
    // echo "<pre>";
    // print_r($job_count['job_count']);
    // exit;

    // echo "<pre>";
    // print_r($profileimg);
    // exit;

    // echo "After <pre>";
    // print_r($totalJobPosted);
    // exit;
?>
<style type="text/css">
        
</style>
<!-- General Detail Start -->
<section class="dashboard-wrap" class="fartonav">
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
                        <div class="dashboard-avatar-text" style="">
                            <h4 style="text-transform: capitalize;">{{ $user = Session::get('userName') }}</h4>
                        </div>
                        <div style="position: relative;bottom:35px;right: 30%;">
                            @if(isset($user))
                            <span class="activeStatus"></span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="dashboard-menu">
                        <ul>
                            @if( ($profileimg[0]->candidate_status == 1) )
                            <li class="active">
                                <a href="{{ route('cand.dashboard') }}"><i class="ti-dashboard"></i>Dashboard</a>
                            </li>
                            @endif

                            @if($profileimg[0]->candidate_status == 0)
                            <li><a href="{{ route('cand.profile') }}"><i class="ti-ruler-pencil"></i>Create Profile</a></li>
                            @endif

                            @if( ($profileimg[0]->candidate_status == 1) )
                            <li>
                                <a href="{{ route('cand.profile') }}"><i class="ti-briefcase"></i>Update Profile</a>
                            </li>
                                                       
                            <li>
                                <a href="{{ route('endorsment.docs') }}"><i class="ti-briefcase"></i>Documents</a>
                            </li>
                            @endif

                            @if( ($profileimg[0]->docs_uploaded == 1) )
                            <li>
                                <a href="{{ route('cand.applylist') }}"><i class="ti-briefcase"></i>Job Applications</a>
                            </li> 
                            <li>
                                <a href="{{ route('profileViewByEmployer') }}"><i class="ti-briefcase"></i>Profile Viewed By Employer</a>
                            </li>
                            <?php
                              $candEmail = Session::get('userEmail');
                              if(isset($candEmail)){
                                $chatUserData = DB::select("SELECT *  FROM users where email="."'".$candEmail."'");
                                $candidateUser = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");

                              if(isset($chatUserData[0]) && ($candidateUser[0]->email_verified_at == '1') && ($candidateUser[0]->candidate_status == '1')){
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
                                // $email = Crypt::encryptString($chatUserData[0]->email);
                                // $password = $chatUserData[0]->decrpted_password;
                                //'http://chatingapp.onlinemariners.com/login?email='.$email.'&&password='.$password 
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
                    @if(isset($activate))
                        <div class="msg alert alert-success alert-dismissable fade in" style="padding-bottom: 3%;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <b>Success ! </b>{{ isset($activate['activate']) }}
                        </div>
                    @endif
                    @if( session('success') )
                        <div class="msg alert alert-success alert-dismissable fade in" style="padding-bottom: 3%;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <b>Success ! </b>{{ session('success') }}
                        </div>
                    @endif

                    <!-- Flash Msg on success-->
                    @if( session('error'))
                        <div class="msg alert alert-danger alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <b>Error ! </b>{{ session('error') }}
                        </div>
                    @endif
                    @if( isset($profileimg[0]->candidate_status) && ($profileimg[0]->candidate_status == 0) )
                        <div class="alert alert-danger alert-dismissable fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <b>Error ! </b>{{ 'Activate your account by clicking on "Create" menu -> Change Message -> Activate Account For Post a Job By Activating and Account For that In Menu Click on Create or Update Profile.' }}
                        </div>
                    @endif
                    
                    <!-- Flash msg For document upload -->
                    @if( isset($profileimg[0]->docs_uploaded) && ($profileimg[0]->docs_uploaded == 0) )
                        <div class="alert alert-danger alert-dismissable fade in">
                            <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                            <b>Error ! </b>{{ 'Active account by completing next step is to click on "Documents" from menu And update your documents avaibility.' }}
                        </div>
                    @endif
                    <div class="dashboard-caption">
                        
                        <div class="dashboard-caption-header">
                            <h4><i class="ti-settings"></i>Dashboard</h4>
                        </div>
                        
                        <div class="dashboard-caption-wrap">
                        
                            <!-- Overview -->
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a style="color: white;" class="dashboard-stat widget-1" href="{{ url('/candidate/apply/list') }}">
                                        <!-- <div class=""> -->
                                            <div class="dashboard-stat-content">
                                                <h4>{{ $job_count['job_count'] }}</h4>      	
                                            	<span>Applied Jobs</span>                                            	
                                        	</div>
                                            <div class="dashboard-stat-icon"><i class="ti-location-pin"></i></div>
                                        <!-- </div>	 -->
                                    </a>
                                </div>
                                
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a style="color: white;" class="dashboard-stat widget-2" href="{{ url('/candidate/viewedProfile/list') }}">
                                        <!-- <div class="dashboard-stat widget-2"> -->
                                            <div class="dashboard-stat-content">
                                                <h4>{{ $profileViewCount }}</h4>            
                                            	<span>Profile Viewed</span>                                        	
                                            </div>
                                            <div class="dashboard-stat-icon"><i class="ti-layers"></i></div>
                                        <!-- </div> -->
                                    </a>
                                </div>
                                
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a style="color: white;" class="dashboard-stat widget-3" href="{{ url('/candidate/apply/list') }}">
                                        <!-- <div class="dashboard-stat widget-3"> -->
                                            <div class="dashboard-stat-content">
                                                <h4>{{ $shortlist_count }}</h4>                  
                                                <span>Shortlisted</span></div>             
                                            <div class="dashboard-stat-icon"><i class="ti-pie-chart"></i></div>
                                        <!-- </div> -->
                                    </a>
                                </div>
                                
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a class="dashboard-stat widget-4" style="color: white;" href="{{ url('/candidate/apply/list') }}"> 
                                        <!-- <div class="dashboard-stat widget-4"> -->
                                            <div class="dashboard-stat-content">
                                                <h4>{{ $interviewcall_count }}</h4>             
                                                <span>Called for Interview</span>
                                            </div>
                                            <div class="dashboard-stat-icon"><i class="ti-bookmark"></i></div>
                                        <!-- </div> -->
                                    </a>
                                </div>
                            </div>
                            <!-- old compnay list -->
                            <div style="text-align: center;margin:3% 0; ">
                                <h3 style="color: green;">Job Posted In Portal</h3>
                            </div>
                            <!-- Company Searrch Filter Start -->
                            <div class="row extra-mrg">
                                <div class="wrap-search-filter">
                                    <form name="job_searchfilter_form" action="{{ route('joblist.companyfilter') }}" method="get">
                                        @csrf
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" name="company_name" class="form-control" placeholder="Search By Company Name">
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <input type="text" name="Country" class="form-control" placeholder="Search By City Name">
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <select name="rank_position" class="form-control" >
                                                <!-- id="j-category" -->
                                                <option value="">Select Rank</option>
                                                <option value="Captain / Master">Captain / Master</option>
                                                <option value="Chief Engineer">Chief Engineer</option>
                                                <option value="Chief Officer">Chief Officer</option>
                                                <option value="2nd Engineer">2nd Engineer</option>
                                                <option value="2nd Officer" >2nd Officer</option>
                                                <option value="3rd Engineer">3rd Engineer</option>
                                                <option value="3rd Officer" >3rd Officer</option>
                                                <option value="4th Engineer">4th Engineer</option>
                                                <option value="Electrical Officer">Electrical Officer</option>
                                                <option value="Electrical Technical Officer">Electrical Technical Officer</option>
                                                <option value="Trainee Electrical Officer">Trainee Electrical Officer</option>
                                                <option value="AB">AB</option>
                                                <option value="Oiler">Oiler</option>
                                                <option value="Deck Cadet">Deck Cadet</option>
                                                <option value="Engine Cadet">Engine Cadet</option>
                                                <option value="OS">OS</option>
                                                <option value="Wiper">Wiper</option>
                                                <option value="Trainee OS">Trainee OS</option>
                                                <option value="Trainee Wiper">Trainee Wiper</option>
                                                <option value="Deck Fitter">Deck Fitter</option>
                                                <option value="Engine Fitter">Engine Fitter</option>
                                                <option value="Bosun">Bosun</option>
                                                <option value="Pumpman"> Pumpman</option>
                                                <option value="Motorman">Motorman</option>
                                                <option value="Crane Operator">Crane Operator</option>
                                                <option value="Chief Cook">Chief Cook</option>
                                                <option value="Cook">Cook</option>
                                                <option value="2nd Cook">2nd Cook</option>
                                                <option value="Assistant Cook">Assistant Cook</option>
                                                <option value="General Steward">General Steward</option>
                                                <option value="Trainee General Steward">Trainee General Steward</option>
                                            </select>

                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <button style="height: 35px;" type="submit" class="btn btn-primary full-width">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Company Searrch Filter End -->
                            
                            <!-- End of old company List -->                            
                            @foreach($allPostJobLists as $postjob)
                            <div class="item-click">
                                <a href="{{ route('joblist.browse', [$postjob->company_name]) }}">
                                <article>
                                    <div class="brows-company">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="item-fl-box">
                                                <div class="brows-company-pic">
                                                    <?php 
                                                        if(isset($postjob->company_logo)){                                            
                                                            $companyLogo = url('public/companyLogo/'.$postjob->company_logo);    
                                                        }else{
                                                            $companyLogo = url('public/assets/img/company_default_logo.png');    
                                                        }
                                                         ?>                                        
                                                    <img src="{{ $companyLogo }}" class="img-responsive" alt="companyLogo" width="100" height="100"/>
                                                </div>
                                                <div class="brows-company-name">
                                                    <?php // below r oute  ('joblist.browse', [$postjob->company_name,$postjob->city])?>
                                                    <h4>{{ mb_strimwidth($postjob->company_name, 0, 35, "...") }}</h4>

                                                    <span class="brows-company-tagline">{{ mb_strimwidth($postjob->rank_position, 0, 35,'...') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <div class="brows-company-location">
                                                <p><i class="fa fa-map-marker"></i> {{ mb_strimwidth($postjob->country, 0, 35,'...') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <div class="brows-company-position">                                
                                                <p>{{ $postjob->rankcount.' Opening' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </article>
                            </div>
                            @endforeach
                            <!-- No result found then below message display -->
                            @if(count($allPostJobLists) < 1)                
                                <div class="row" style="text-align: center;padding-top: 5%;">
                                    <div class="col-sm-12">
                                        <h3 style="color: #03a84e">Requested Data Not Found</h3>
                                    </div>
                                </div>
                            @endif

                            <!-- Paging for company list -->
                             @if(isset($allPostJobLists))
                                <div class="row" style="text-align: center;">                
                                    {!! $allPostJobLists->render() !!}               
                                </div>
                            @endif
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
    $('#candidate_jobpost_tbl').DataTable();
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