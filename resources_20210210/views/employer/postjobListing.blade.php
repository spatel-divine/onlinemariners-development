@extends('layouts.app_afterLogin')

@section('content')
<?php
	// echo "<pre>";
	// print_r($joblist);
	// // print_r($empImg[0]->pic_path);
	// exit;
?>
<!-- post a job -->
<style type="text/css">
	.table-bordered {
    	border: 1px solid #ddd;
	}
	input[type=search] {
		 border: 1px solid #ccc !important;
		 box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	}
	.table>thead>tr>th {
	    border: 1px solid #ddd;
	}

</style>
<section class="dashboard-wrap">
				<div class="container-fluid">
					<div class="row fartonav">
					
						<!-- Sidebar Wrap -->
						<div class="col-lg-3 col-md-4">
							<div class="side-dashboard">
								<div class="dashboard-avatar">
									<?php 
	                                    $filename = $empImg[0]->pic_path;
	                                    //$url = url('/public/empProfile/'.$filename); 
	                                    if($filename == 'emp-default.png' || $filename == ''){
                                        $url = url('/public/assets/img/emp-default.png');     
	                                    }else{
	                                        $url = url('/public/empProfile/'.$filename); 
	                                    }
                                	?>
									<div class="dashboard-avatar-thumb">
									@if(isset($empImg))
                                    <img src="{{ $url }}" class="img-avater" alt="emp-pic" />
                                	@else
                                    <img src="public/empProfile/emp-default.png" class="img-avater" alt="employer-profile-image" />
                                	@endif
									</div>
									
									<div class="dashboard-avatar-text">
										<h4>{{ Session::get('employerName') }}</h4>
									</div>
									
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
			                                <a href="{{ route('postjob.listing') }}"><i class="ti-user"></i>Post Job Listing And Update</a>
			                            </li>    
			                            <li class="<?php echo(request()->is('employer/application/listing')) ? 'active':'' ?>">
			                                <a href="{{ route('lists.appliedjob') }}"><i class="ti-user"></i>Candidate Job Applied List</a>
			                            </li>
			                            @endif
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
			                            <!--
			                            <li><a href=""><i class="ti-user"></i>Applications</a></li>
			                            <li><a href=""><i class="ti-wallet"></i>Packages</a></li>
			                            <li><a href=""><i class="ti-cup"></i>Choose Packages</a></li>
			                            <li><a href=""><i class="ti-flag-alt-2"></i>Viewed Resume</a></li>
			                            <li><a href=""><i class="ti-id-badge"></i>Edit Profile</a></li>
			                            <li><a href=""><i class="ti-power-off"></i>Logout</a></li>
			                            <!-- <li class="{{-- (request()->is('admin/cities')) ? 'active' : '' --}}">   -->
			                        </ul>
								</div>
							</div>
						</div>
						
						<!-- Content Wrap -->
						<div class="col-lg-9 col-md-8">
							<div class="dashboard-body">
								<!-- knowlwdgebase msg --->								
								<div class="alert alert-success alert-dismissable fade in" style="padding: 2% 0">
			                        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close" style="position: relative;top: -2px;right: 15px;color: inherit;">&times;</a> -->
			                        <p style="padding-left: 18px; text-transform: uppercase;">Kindly, Check our <a href="http://onlinemariners.com/knowledgeBase" target="_blank">Knowledgebase</a> page to know how to post a job for candidate and other operations.For other issue contact to support. </p>
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
		                        <!-- Flash Msg on success-->
		                        @if( session('error') )
		                            <div class="msg alert alert-danger alert-dismissable fade in">
		                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                                <b>Error ! </b>{{ session('error') }}
		                            </div>
		                        @endif
		                        @if( count($errors) > 0 )
		                            <div class="msg alert alert-danger alert-dismissable fade in">
		                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                                <ul>
		                                     @foreach ($errors->all() as $error)
		                                         <li style="text-transform: capitalize;">{{ $error }}</li>
		                                     @endforeach
		                                </ul>
		                            </div>
		                        @endif
								<div class="dashboard-caption">
									
									<div class="dashboard-caption-header">
										<h4><i class="ti-ruler-pencil"></i>Post Job Listing And Update</h4>
									</div>
									
									<div class="dashboard-caption-wrap">
										<!-- table table-striped table-bordered -->
									<table id="postjob_listing" class="display table table-striped table-bordered dataTable" style="width:100%">
								        <thead>
								            <tr>
								                <!-- <th>Job Title</th> -->
								                <th>Company Name</th>								               
								                <th>Mobile No</th>
								                <th>Vessel Type</th>
								                <th>Application Deadline</th>
								                <th>Action</th>
								                <th>Details</th>
								            </tr>
								        </thead>
								        <tbody>
								        	@foreach($joblist as $job)
								            <tr>								                
								                <td>{{ mb_strimwidth($job->company_name, 0, 20, "...") }}</td>
								                <td>{{ mb_strimwidth($job->mobile_number, 0, 20, "...") }}</td>
								                <td>{{ mb_strimwidth($job->vassel_type, 0, 20, "...") }}</td>
								                <td>{{ date('m-d-Y', strtotime($job->app_deadline)) }}</td>
								                <td>
								                	<form class="form-horizontal" method="get" action="{{ action('PostjobController@deleteJobs',['id' => $job->id , 'employer_id' => $job->employer_id]) }}">
                                                	<!-- , 'employer_id' => $job->employer_id] -->
	                                                <a href="{{ route('postjob.edit',$job->id)  }}" style="margin-right: 10px;" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
	                                                {{ csrf_field() }}
	                                                <input type="hidden" name="_method" value="DELETE">
	                                                <button type="submit" onclick="return confirm('Are You Sure ?');" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button>
	                                            </form>

								                </td>
								                <td>
								                	<div style="padding-top: 8%">
								                		<a href="{{ route('postjob.detailsview',$job->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></a>
							                		</div>
								                </td>
								            </tr>
								            @endforeach
							            </tbody>
							            <tfoot>
								            <tr>
								                <!-- <th>Job Title</th> -->
								                <th>Company Name</th>								               
								                <th>Mobile No</th>
								                <th>Vessel Type</th>
								                <th>Application Deadline</th>
								                <th>Action</th>
								                <th>Details</th>
								            </tr>
								        </tfoot>
						            </table>
								</div>
							</div>
						</div>
					
					</div>
				</div>
			</section>
@endsection
@section('datepicker')
<script>
	$(document).ready(function () {
	    $('#postjob_listing').DataTable();
    });


    $(".rank").change(function() {
        var multipleValues = $(".rank").val() || "";
        var result = "<label>Wages for Rank Position*: </label>";
        if (multipleValues != "") {
            var aVal = multipleValues.toString().split(",");
            $.each(aVal, function(i, value) {

                // result += "<div>";
                // result += "<input type='text' name='opval" + (parseInt(i) + 1) + "' value='" + "'"+value.trim()+"'" + "'>";
                // value = value.replace(' ','-');
                // value = value.replace('/','-');
                // result += "<input type='text' name='optext" + (parseInt(i) + 1) + "' value='" + $("#rank").find("option[value=" + value + "]").text().trim() + "'>";
                // result +="<div class='col-lg-6 col-md-6 col-sm-12'>" //(parseInt(i) + 1)
                result += "<input type='number' class='form-control' name='"+'wage[]' + "' placeholder='"+ 'Wages for '+value + "'value='' Required>";
                result += "</div>";
            });


        }
        //Set Result
        $("#wages").html(result);

    });
   
    
</script>

@endsection