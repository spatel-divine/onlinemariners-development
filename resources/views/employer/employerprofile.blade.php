@extends('layouts.app_afterLogin')

@section('content')
<?php 
use Illuminate\Support\Facades\Input;
	// echo '<pre>';
	// // print_r($states);
	// print_r($countries);
	// exit;
?>
<!-- post a job -->
<style type="text/css">
    .control-fileupload:before
    {
        display: none !important;
    }
 
 </style>
<section class="dashboard-wrap">
				<div class="container-fluid">
					<div class="row fartonav">					
						<!-- Sidebar Wrap -->
						<div class="col-lg-3 col-md-4">
							<div class="side-dashboard">
								<div class="dashboard-avatar">
									<div class="dashboard-avatar-thumb">
									<?php 
	                                    $filename = $empImg[0]->pic_path;
	                                    $url = url('/public/empProfile/'.$filename); 
	                                    if($filename == 'emp-default.png' || $filename == ''){
	                                        $url = url('/public/assets/img/emp-default.png');     
	                                    }else{
	                                        $url = url('/public/empProfile/'.$filename); 
	                                    }
                                	?>
                                	@if(isset($empImg))
                            		<img src="{{ $url }}" class="img-avater" alt="emp-pic" />
                                	@else
                                    <img src="public/empProfile/emp-default.png" class="img-avater" alt="employer-profile-image" />
                                	@endif
									</div>
									<form class="post-form"  method="POST" action="{{ route('employer.store') }}" enctype="multipart/form-data">
									@csrf
									<div class="col-md-12 col-sm-12">
		                                <div class="form-group">
		                                    <span class="control-fileupload">
		                                    <label for="file">Update Profile Image</label>
		                                    <input type="file" name="pic_path" id="pic_path">
		                                    </span>
		                                    <span class="sizenote">Max Image Size : 2MB</span>
		                                </div>
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
			                                <a href="{{ route('postjob.listing') }}"><i class="ti-user"></i>Post Job Listing and Update</a>
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
								<div class="alert alert-success alert-dismissable fade in" style="padding: 2% 0">
			                        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close" style="position: relative;top: -2px;right: 15px;color: inherit;">&times;</a> -->
			                        <p style="padding-left: 18px;    text-align: center; text-transform: uppercase;">KINDLY CHECK OUR <a href="http://onlinemariners.com/knowledgeBase" target="_blank">KNOWLEDGE BASE</a> PAGE TO KNOW HOW TO POST A JOB FOR A CANDIDATE AND OTHER OPERATIONS. <br> FOR OTHER QUERIES CONTACT ONLINE MARINERS CHAT SUPPORT.</p>
			                    </div><!-- Unread message flash -->
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
			                    
		                        <!-- Flash Msg on success-->
		                        @if( session('success') )
                                    <div class="msg alert alert-success alert-dismissable fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <b>Success ! </b>{{ session('success') }}
                                    </div>
                                @endif
		                        @if( session('error') )
		                            <div class="msg alert alert-danger alert-dismissable fade in">
		                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                                <b>Error ! </b>{{ session('error') }}
		                            </div>
		                        @endif
		                       @if(isset($empImg[0]->profile_status) && ($empImg[0]->profile_status == 0))
			                        <div class="alert alert-danger alert-dismissable fade in">
			                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			                            <b>Alert ! </b>{{ 'Active account by clicking on "Create OR Update profile" menu -> Change Message -> Activate Account For Post a Job By Activating and Account For that In Menu Click on Create or Update Profile.'  }}
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
										<h4><i class="ti-ruler-pencil"></i>Create or Update Profile</h4>
									</div>
									
									<div class="dashboard-caption-wrap">
										
											@if($employerData->company_name == '')
											<!--Company-name email -->
											<div class="row">
												<div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Company Name*:</label>
														<input type="text" name="company_name" class="form-control" placeholder="Abc PVT LTD" value="{{ old('company_name') }}" required>
													</div>	
												</div>
												<div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Email *:</label>
														<?php $email = Session::get('employerEmail');?>
														<input type="email" name="email" class="form-control" placeholder="" value="<?php echo (isset($email)) ?  trim($email) : ''; ?>" disabled>
													</div>	
												</div>
											</div>																		
											
											<!--contactperson mobile -->
											<div class="row">
												<!-- <div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Contact person Name*:</label>
														<input type="text" name="contact_person" class="form-control" placeholder="Contact person" value="{{-- old('contact_person') --}}" required>
													</div>	
												</div> -->
												<div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Contact Number*:</label>
														<input type="number" name="mobile_number" class="form-control" placeholder="Mobile Number" value="{{ old('mobile_number') }}">
													</div>	
												</div>
												<div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Landline Number:</label>
														<input type="number" name="landline_number" class="form-control" placeholder="Landline Number" value="{{ old('landline_number') }}" required>
													</div>	
												</div>
											</div>																	
											
											<!-- Lat Long -->
											<div class="row">
												<div class="col-lg-6 col-md-6 col-sm-6">
													<div class="form-group">
														<input type="hidden" id="lat" name="lat" class="form-control" value='' disabled>
													</div>	
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6">
													<div class="form-group">
														<input type="hidden" id="long" name="long" class="form-control" value='' disabled>
													</div>	
												</div>
											</div>
											
											<div class="row">												
												<div class="col-lg-12 col-md-12 col-sm-6">
													<label>Company Logo*:</label>
												</div>
												<div class="col-md-12 col-sm-6">
			                                		<div class="form-group">
			                                    		<span class="control-fileupload">
			                                    		<label for="file">Company Logo*</label>
			                                    		<input type="file" name="company_logo" id="company_logo">
			                                    		</span>
			                                		</div>
		                                		</div>
			                            	</div>
			                            	<!-- Address -->
											<div class="row">
												<div class="col-sm-12">
													<label>Address*</label>
												</div>
												<div class="col-sm-12">
													<input type="text" name="street1" class="form-control" placeholder="Enter Street 1" value="{{ old('street1') }}" autocomplete="off" required>
												</div>
												<div class="col-sm-12">
													<input type="text"  name="street2" class="form-control" placeholder="Enter Street 2" value="{{ old('street2') }}" autocomplete="off">
												</div>
											</div>

											<!-- Country -->
											<div class="row">
												<div class="col-sm-6 form-group">
													<div class="">
													  <label for="country">Country*</label>
													  <select name='country' class="form-control" id="country" required>
													  	<option> Select Country</option>
													  	{{-- (Input::old("country") == $country ? "selected":"") --}}
													    @foreach($countries as $country)
													    <option value="{{ $country->id }}" >{{ $country->name }}</option>
													    @endforeach
													  </select>
													</div>
												</div>
											</div>

											<!-- State -->
											<div class="row">
												<div class="col-sm-6 form-group">
													<div class="">
													  <label for="State">State*</label>
													  <select name='state' class="form-control" id="state" required>
													  	<option> Select State</option>
													  	{{-- (Input::old("state") == $state ? "selected":"") --}}
													    @foreach($states as $state)
													    <option value="{{ $state->id }}" >{{ $state->name }}</option>
													    @endforeach
													  </select>
													</div>
												</div>
												<div class="col-sm-6 form-group">
													
												</div>
											</div>

											<!-- City -->
											<div class="row">
												<div class="col-sm-6 form-group">
													<label for="sel1">City*</label>
													<!-- <input type="text" name="city" id="city"  class="form-control" placeholder="Enter City" value="{{-- old('city') --}}" autocomplete="off" required> -->
													<select name="city" class="form-control" id="city" required>
								                      <option value="">Select City</option>
								                    </select>
												</div>
												<div class="col-sm-6"></div>
											</div>
											
											
										<!-- <div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12">
													<div class="form-group">
														<label>Address*</label>
														<input type="text" id="my-address" name="address" class="form-control" placeholder="Ex. 502, Sector 20 C, Mohali India" value="" required>
													</div>	
												</div>

												<div class="col-lg-4 col-md-6 col-sm-12">
													<div class="form-group">
														<label>City</label>
														<input type="hidden" id="city" name="city" class="form-control" placeholder="City">
													</div>	
												</div>
												
												<div class="col-lg-4 col-md-6 col-sm-12">
													<div class="form-group">
														<label>State</label>
														<input type="hidden" id="state" name="state" class="form-control" placeholder="State">
													</div>	
												</div>
												
												<div class="col-lg-4 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Country</label>
														<input type="hidden" id="country" name="country" class="form-control" placeholder="Country">
													</div>	
												</div>
											
											</div> -->

											<!-- Map -->
											<!-- <div class="row" style="display: none;">				
												<div class="col-lg-12 col-md-12 col-sm-12" >
													<div class="form-group">
														<div id="map" style="width: 1070px; height:400px;"></div>
													</div>
												</div>
											</div> -->
											<!-- Submit  -->
											<div class="row mrg-top-30">
												<div class="col-md-12 col-sm-12">
													<div class="form-group text-center">
														<button type="submit" class="btn-savepreview"><i class="ti-angle-double-right"></i>Activate</button>
													</div>	
												</div>
											</div>
											@endif<!-- end of if create-->

											<!--********* If update form then below code ****** -->

											@if($employerData->company_name)
											<input type="hidden" name="edit_empprofile" value="edit_empprofile">
											<!--Company-name email -->
											<div class="row">
												<div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Company Name*:</label>
														<input type="text" name="company_name" class="form-control" placeholder="Abc PVT LTD" value="{{ $employerData->company_name }}" required>
													</div>	
												</div>
												<div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Email *:</label>
														<?php $email = Session::get('employerEmail');?>
														<input type="email" name="email" class="form-control" placeholder="" value="<?php echo (isset($email)) ?  trim($email) : ''; ?>" disabled>
													</div>	
												</div>
											</div>																		
											
											<!--contactperson mobile -->
											<div class="row">
												<!-- <div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Contact person Name*:</label>
														<input type="text" name="contact_person" class="form-control" placeholder="Contact person" value="{{ $employerData->contact_person }}" required>
													</div>	
												</div> -->
												<div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Contact Number (Mobile):</label>
														<input type="number" name="mobile_number" class="form-control" placeholder="Mobile Number" value="{{ $employerData->mobile_number }}">
													</div>	
												</div>
												<div class="col-lg-6 col-md-6 col-sm-12">
													<div class="form-group">
														<label>Contact Number (Landline) *: </label>
														<input type="number" name="landline_number" class="form-control" placeholder="Landline Number" value="{{ $employerData->landline_number }}" required>
													</div>	
												</div>
											</div>																	
											
											<!-- Lat Long -->
											<div class="row">
												<div class="col-lg-6 col-md-6 col-sm-6">
													<div class="form-group">
														<input type="hidden" id="lat" name="lat" class="form-control" value='' disabled>
													</div>	
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6">
													<div class="form-group">
														<input type="hidden" id="long" name="long" class="form-control" value='' disabled>
													</div>	
												</div>
											</div>
											
											<div class="row">												
												<div class="col-lg-12 col-md-12 col-sm-6">
													<label>Company Logo*:</label>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6">
			                                		<div class="form-group">
			                                    		<span class="control-fileupload">
			                                    		<label for="file">Company Logo*</label>
			                                    		<input type="file" name="company_logo" id="company_logo" value="{{$employerData->company_logo}}">
			                                    		</span>
			                                		</div>

		                                		</div>
		                                		<?php
		                                			$file = $employerData->company_logo;
		                                			$url = url('public/companyLogo/'.$file);
		                                		?>
		                                		<div class="col-lg-6 col-md-6 col-sm-6">
		                                			<div class="form-group">
		                                				<label for="file">Past Logo</label>
		                                			</div>
		                                			@if(isset($file))
                            							<img src="{{ $url }}" class="company logo" alt="company-logo" width="150" height="150" />
                                					@endif
		                                		</div>
			                            	</div>

											<!-- Address -->
											<div class="row">
												<div class="col-sm-12">
													<label>Address*</label>
												</div>
												<div class="col-sm-12">
													<input type="text" name="street1" class="form-control" placeholder="Enter Street 1" value="{{  $employerData->street1 }}" required>
												</div>
												<div class="col-sm-12">
													<input type="text" name="street2" class="form-control" placeholder="Enter Street 2" value="{{  $employerData->street2 }}">
												</div>
											</div>
											
											<!-- Country -->
											<div class="row">
												<div class="col-sm-6 form-group">
													<div class="">
													  <label for="country">Country*</label>
													  <select name='country' class="form-control" id="countryUpdate" required>
													  	<option> Select Country</option>
													    @foreach($countries as $country)
													    <option value="{{ $country->id }}" {{ ($employerData->country == $country->id ? "selected":"") }}>{{ $country->name }}</option>
													    @endforeach
													  </select>
													</div>
												</div>
											</div>
											<script type="text/javascript">
											$('#countryUpdate').change(function(){
										        var cid = $(this).val();
										     
										        if(cid){
										        	$("#StateUpdate").empty();
											        $("#CityUpdate").empty();
											        $("#StateUpdate").append('<option>Select State</option>');
											        $("#CityUpdate").append('<option>Select City</option>');

											        $.ajax({
											        	headers: {
										                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										                },
											           type:"get",
											           data : {cid:cid},
											           url:"{{ route('states_m') }}", 
											           success:function(res)
											           {       
											                if(res)
											                {
											                    
											                    
											                    $.each(res,function(key,value){
											                        $("#StateUpdate").append('<option value="'+key+'">'+value+'</option>');
											                    });
											                }
											           }

											        });
										        }
										    });
											</script>

											<!-- State -->
											<div class="row">
												<div class="col-sm-6 form-group">
													<div class="">
													  <label for="State">State*</label>
													  <select name='state' class="form-control" id="StateUpdate" required>
													  	<option> Select State</option>
													    @foreach($states as $state)
													    <option value="{{ $state->id }}" {{ ($employerData->state == $state->id ? "selected":"") }}>{{ $state->name }}</option>
													    @endforeach
													  </select>
													</div>
												</div>
												<div class="col-sm-6 form-group">
													
												</div>
											</div>

											<script type="text/javascript">
											$('#StateUpdate').change(function(){
										        var cid = $(this).val();
										     
										        if(cid){
										        	$("#CityUpdate").empty();
										        	$("#CityUpdate").append('<option>Select City</option>');
											        $.ajax({
											        	headers: {
										                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										                },
											           type:"get",
											           data : {cid:cid},
											           url:"{{ route('cities_m') }}",  
											           success:function(res)
											           {       
											                if(res)
											                {   
											                    $.each(res,function(key,value){
											                        $("#CityUpdate").append('<option value="'+key+'">'+value+'</option>');
											                    });
											                }
											           }

											        });
										        }
										    });

										    loadCities();


										    function loadCities(){
										    	var stateId = "{{($employerData->state) ? $employerData->state : '' }}";
										    	var cityId = "{{($employerData->city) ? $employerData->city : '' }}";
										     
										        if(stateId){
										        	$("#CityUpdate").empty();
										        	$("#CityUpdate").append('<option>Select City</option>');
											        $.ajax({
											        	headers: {
										                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										                },
											           type:"get",
											           data : {cid:stateId},
											           url:"{{ route('cities_m') }}",  
											           success:function(res)
											           {       
											                if(res)
											                {   
											                    $.each(res,function(key,value){

											                    	if(cityId==key){
											                    		$("#CityUpdate").append('<option value="'+key+'" selected>'+value+'</option>');
											                    	} else{
											                    		$("#CityUpdate").append('<option value="'+key+'">'+value+'</option>');
											                    	}
											                    
											                    });
											                }
											           }

											        });
										        }
										    }
											</script>

											<!-- City -->
											<div class="row">
												<div class="col-sm-6 form-group">
													<label for="sel1">City*</label>
													<!-- <input type="text" name="city" id="city"  class="form-control" placeholder="Enter City" value="{{-- old('city') --}}" autocomplete="off" required> -->
													<select name="city" class="form-control" id="CityUpdate" required>
														<option value="">Select City</option>
													</select>
												</div>
												<div class="col-sm-6"></div>
											</div>
											<!-- Map -->
											<!-- <div class="row" style="display: none;">
												<div class="col-lg-12 col-md-12 col-sm-12" >
													<div class="form-group">
														<div id="map" style="width: 1070px; height:400px;"></div>
													</div>	
												</div>
											</div> -->															
											<!-- Submit  -->
											<div class="row mrg-top-30">
												<div class="col-md-12 col-sm-12">
													<div class="form-group text-center">
														<button type="submit" class="btn-savepreview"><i class="ti-angle-double-right"></i>Update</button>
													</div>	
												</div>
											</div>
											@endif
											
										</form>
									</div>
									
								</div>
							</div>
						</div>
					
					</div>
				</div>
			</section>
@endsection
@section('datepicker')
<script>
    $('#app_deadline').dateDropper();  
   
    //company logo
    $(function() {
      $('input[type=file]').change(function(){
        var t = $(this).val();
        var labelText = 'File : ' + t.substr(12, t.length);
        $(this).prev('label').text(labelText);
      })
    });

    /* Country state city selection */
    $('#country').change(function(){
      var countryID = $(this).val();  
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if(countryID){
        $.ajax({
          type:"POST",
          url:"{{ route('getStateList') }}",
          data:{ countryID: countryID },
          success:function(data){ 
          	$("#state").html(data);
          	return false;
          }
        });
      }else{
        $("#state").empty();
        $("#city").empty();
      }   
    });
    /* based on state select city option*/
    $('#state').change(function(){
      var stateID = $(this).val();  
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if(stateID){
        $.ajax({
          type:"POST",
          url:"{{ route('getCityList') }}",
          data:{ stateID: stateID },
          success:function(data){ 
          	// alert(data);
          	$("#city").html(data); 
          	return false;           
          }
        });
      }else{
        // $("#state").empty();
        $("#city").empty();
      }   
    });



</script>

@endsection