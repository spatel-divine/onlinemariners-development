<style type="text/css">
	.homelesscaret a.dropdown-toggle:after {
	    font-family: FontAwesome;
	    content: "" !important;
	    margin-left: 5px;
	    margin-top: 2px;
	}
	nav.navbar.bootsnav.navbar-fixed {
	    position: fixed;
	    display: block;
	    width: 100%;
	    z-index: 222;
	    padding-bottom: 15px !important;
	}
</style>
<nav class="navbar navbar-default navbar-fixed navbar-light white bootsnav on no-full">
	<?php 		
		$candidate = Session::get('userName'); 
		$employer = Session::get('employerName');
		$candEmail = Session::get('userEmail'); 
		$empEmail = Session::get('employerEmail');
		if($candEmail != ''){
			$candidateData = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");	
		}else{
			$candidateData = [];
		}
		
		// echo 'data<pre>';
  //     	print_r($candidateData[0]->docs_uploaded);
  //     	exit;
	?>	
	<div class="container">            
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
			<i class="fa fa-bars"></i>
		</button>
		<!-- Start Header Navigation -->
		<div class="navbar-header">
			@if(($candEmail == '') && ($empEmail == ''))
        	<a class="navbar-brand" href="{{ route('homepage') }}">
                <img src="{{ url('public/assets/img/logo.png') }}" class="logo logo-display" alt="">
                <img src="{{ url('public/assets/img/logo.png') }}" class="logo logo-scrolled" alt="">
            </a>
        	@elseif( (isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)) || isset($empEmail) )
            <a class="navbar-brand" href="{{ route('homepage') }}">
                <img src="{{ url('public/assets/img/logo.png') }}" class="logo logo-display" alt="">
                <img src="{{ url('public/assets/img/logo.png') }}" class="logo logo-scrolled" alt="">
            </a>
			@else
			<a class="navbar-brand" href="">
				<img src="{{ url('public/assets/img/logo.png') }}" class="logo logo-scrolled" alt="Site Logo">
			</a>
			@endif
			
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		
		<div class="collapse navbar-collapse" id="navbar-menu">
			<ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
				<li class="">
					@if(($candEmail == '') && ($empEmail == ''))
					<a href="{{ route('homepage') }}" >Home</a>
					@elseif( (isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)) || isset($empEmail))
					<a href="{{ route('homepage') }}" >Home</a>
					@else
					<a href="" >Home</a>
					@endif
					<!-- <ul class="dropdown-menu animated fadeOutUp" style="display: none; opacity: 1;">
						<li><a href="">Home Page 1</a></li>
						<li><a href="">Home Page 2</a></li>
						<li><a href="">Home Page 3</a></li>
						<li><a href="">Home Page 4</a></li>
						<li><a href="">Home Page 5</a></li>
						<li><a href="">Home Page 6</a></li>
						<li><a href="">Freelancing</a></li>
					</ul> -->
				</li>
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">Jobs</a>
					<ul class="dropdown-menu animated fadeOutUp">
						<!-- <li><a href="">Compnay wise search</a></li>
						<li><a href="">Job wise search</a></li> -->
						@if(($candEmail == '') && ($empEmail == ''))
			        	<li><a href="{{ route('joblist.companywise') }}">Browse Job By Company</a></li>
						<li><a href="{{ route('joblist.browse') }}">Browse Job</a></li>
						@elseif((isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)) || isset($empEmail))
						<li><a href="{{ route('joblist.companywise') }}">Browse Job By Company</a></li>
						<li><a href="{{ route('joblist.browse') }}">Browse Job</a></li>
						@else
						<li><a href="">Browse Job By Company</a></li>
						<li><a href="">Browse Job</a></li>
						@endif
					</ul>
				</li>
				<!-- <li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">Browse</a>
					<ul class="dropdown-menu animated fadeOutUp">
						<li><a href="">Compnay</a></li>								
						<li><a href="">Job</a></li>
					</ul>
				</li> -->
				<!-- <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Jobs</a>
					<ul class="dropdown-menu animated fadeOutUp" style="display: none; opacity: 1;">
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Job Listing</a>
							<ul class="dropdown-menu animated fadeOutUp">
								<li><a href="">Browse Jobs</a></li>
								<li><a href="">Browse Jobs With Sidebar</a></li>
								<li><a href="">Job In Grid</a></li>
								<li><a href="">Search Job</a></li>
								<li><a href="">Popular Jobs</a></li>
							</ul>
						</li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Job Detail</a>
							<ul class="dropdown-menu animated fadeOutUp">
								<li><a href="">Job Detail 1</a></li>
								<li><a href="">Job Detail 2</a></li>
								<li><a href="">Job Detail 3</a></li>
								<li><a href="">Advance Search Job</a></li>
								<li><a href="">Advance Search Job 2</a></li>
							</ul>
						</li>
						
						<li><a href="">Job With Map</a></li>
						<li><a href="">SignUp Page</a></li>
						<li><a href="">Dashboard</a></li>									
					</ul>
				</li> -->
				
				<!-- <li class="dropdown megamenu-fw"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Brows</a>
					<ul class="dropdown-menu megamenu-content animated fadeOutUp" role="menu" style="display: none; opacity: 1;">
						<li>
							<div class="row">
								<div class="col-menu col-md-3">
									<h6 class="title">Main Pages</h6>
									<div class="content">
										<ul class="menu-col">
											<li><a href="">New Login</a></li>
											<li><a href="">Sign In / Sign Up</a></li>
											<li><a href="">Search Job</a></li>
											<li><a href="">Accordion</a></li>
											<li><a href="">Tab Style</a></li>
											<li><a href="">Blog</a></li>
											<li><a href="">Pricing</a></li>
										</ul>
									</div>
								</div>
								<div class="col-menu col-md-3">
									<h6 class="title">For Candidate</h6>
									<div class="content">
										<ul class="menu-col">					
											<li><a href="">Browse Candidates</a></li>
											<li><a href="">Browse Candidate</a></li>
											<li><a href="">Top candidate</a></li>
											<li><a href="">Candidate Detail</a></li>
											<li><a href="">New Candidate Detail</a></li>
											<li><a href="">Browse Candidate Grid</a></li>
											<li><a href="">Browse Candidate With Map</a></li>
											<li><a href="">Browse Resume</a></li>
										</ul>
									</div>
								</div>
								<div class="col-menu col-md-3">
									<h6 class="title">For Employer</h6>
									<div class="content">
										<ul class="menu-col">											
											<li><a href="">Employer With Sidebar</a></li>
											<li><a href="">Browse Companies</a></li>
											<li><a href="">Company Detail</a></li>
											<li><a href="">Create Job</a></li>
											<li><a href="">Create Company</a></li>
											<li><a href="">Manage Company</a></li>
											<li><a href="">Manage Employee</a></li>
											<li><a href="">Employer Profile</a></li>
										</ul>
									</div>
								</div>    
								<div class="col-menu col-md-3">
									<h6 class="title">Extra Pages <span class="new-offer">New</span></h6>
									<div class="content">
										<ul class="menu-col">
											<li><a href="">Top Candidate detail</a></li>
											<li><a href="">Payment Methode</a></li>
											<li><a href="">New LogIn / SignUp</a></li>
											<li><a href="">Top candidate 2</a></li>
											<li><a href="">Premium Candidate</a></li>
											<li><a href="">Premium Candidate Detail</a></li>
											<li><a href="">Get in Touch</a></li>
										</ul>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</li> -->
				@if(isset($employer) && ($employer !== ''))
				<li class="">
					<a href="{{ route('cand.gridlist')}}">Candidate</a>
				</li>
				@endif
				@if(($candEmail == '') && ($empEmail == ''))
				<li class="">
					<a href="{{ route('aboutus') }}" >About Us</a>
				</li>
				<li class="">
					<a href="{{ route('contactus.load') }}" >Contact Us</a>
				</li>
				@elseif(((isset($candEmail) && ($candidateData[0]->docs_uploaded == 1))) || isset($empEmail))
				<li class="">
					<a href="{{ route('aboutus') }}" >About Us</a>
				</li>
				<li class="">
					<a href="{{ route('contactus.load') }}" >Contact Us</a>
				</li>
				@else 
				<li class="">
					<a href="" >About Us</a>
				</li>
				<li class="">
					<a href="" >Contact Us</a>
				</li>				
				@endif

				@if(!isset($candidate) && !isset($employer))
                <li>
					<a href="{{ route('signup') }}">SignUp</a>
				</li>
				@endif
				<li class="dropdown">
				@if(isset($candidate) && ($candidate !== ''))
					<!-- <li style="padding-top: 0.5rem;"> 
						
					</li>
					<li>  
						
					</li> -->
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
    					<ul class="navbar-nav mr-auto" style="list-style-type: none;padding-top: 3%;">
							<li class="nav-item dropdown">
						        <a class="nav-link dropdown-toggle" href="{{ route('cand.profile') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						          <span style='color:green;text-transform: capitalize;'>Welcome {{ mb_strimwidth($candidate.',' ,0,20,'...') }}</span>
						        </a>
						        <span class="caret"></span>
						        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					        		
						          @if($candidateData[0]->docs_uploaded == 1)
						          <a class="dropdown-item" href="{{ route('cand.profile') }}">
						          	<i class="ti-home"></i> Profile
						          </a>
						          @endif
						          <!-- <a class="dropdown-item" href="{{-- route('candi.chat') --}}">
						          	<i class="ti-headphone-alt"></i> Chat
						          </a> -->
						          <?php 
						          	
						          	if(isset($candEmail) && ((isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)))){
						          		$chatData = DB::select("SELECT *  FROM users where email="."'".$candEmail."'");
						          		$candidateUser = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");
						          		// echo "123<pre>";
						          		// print_r($chatData);
						          		// exit;
						          		if(!empty($candidateUser) && ($candidateUser[0]->email_verified_at == '1') && ($candidateUser[0]->candidate_status == '1')){
						          ?>
					          		<a class="dropdown-item" href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatData[0]->id }}">
						          		<i class="ti-headphone-alt"></i> Chat Room
						          	</a>
						          <?php 
						          		}
						      		} 
					      		?>

						          <a class="dropdown-item" href="{{ route('logoutUser') }}" onclick="event.preventDefault();
																document.getElementById('logout-form-user').submit();">
																<i class="fa fa-sign-in"></i> Sign Out</a>
									<form id="logout-form-user" action="{{ route('logoutUser') }}" method="POST" style="display: none;">
										@csrf
									</form>
						          <!-- <a class="dropdown-item" href="#"> -->
						          
								<!-- </a> -->
						          <div class="dropdown-divider"></div>
						          	
						        </div>
					      	</li>
				       	</ul>
					  </div>
					<!-- <div class="dropdown">
					    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
				    		<a class="dropdown-item" href="{{ route('cand.dashboard') }}">
								<span style='color:green;text-transform: capitalize;'>Welcome {{ $candidate.',' }}</span>
							</a>
					    <span class="caret"></span></button>
					    <ul class="dropdown-menu">
					      <li><a href="{{ route('homepage') }}">Home</a></li>
					      <li>
					      	<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
		                                                     document.getElementById('logout-form').submit();">
		                                                     <i class="fa fa-sign-in"></i>  Sign Out</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		                        @csrf
		                    	</form>
						    </a>
					      </li>
					    </ul>
				  	</div>
					 -->
					@endif
					
					@if(isset($empEmail) && ($empEmail !== ''))						
						<!-- <li style="padding-top: 0.5rem;">
							
						</li>
						<li>  
							
						</li> -->

						 <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    					<ul class="navbar-nav mr-auto" style="list-style-type: none;padding-top: 3%;">
								<li class="nav-item dropdown">
							        <a class="nav-link dropdown-toggle" href="{{ route('employer.profile') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							          <span style='color:green;text-transform: capitalize;'>Welcome {{ mb_strimwidth($empEmail.',' ,0,20,'...')}}</span>
							        </a>
							        <span class="caret"></span>
							        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
							          
							          <a class="dropdown-item" href="{{ route('employer.profile') }}">
							          	<i class="ti-home"></i> Profile
							          </a>
							          <!-- <a class="dropdown-item" href="{{-- route('empchat') --}}">
							          	<i class="ti-headphone-alt"></i> Chat
							          </a> -->
							          <?php
							          	
								        // if(isset($empImg[0]->employer_chat_id)){
							         //  		$id = $empImg[0]->employer_chat_id;
							          if(isset($empEmail)){
							          	$chatUserData = DB::select("SELECT *  FROM users where email="."'".$empEmail."'");
							          	$empUser = DB::select("SELECT *  FROM employer where email="."'".$empEmail."'");
							          

							          if(isset($chatUserData[0]) && ($empUser[0]->email_varified == '1') && ($empUser[0]->profile_status == '1')){
							          	// $email = Crypt::encryptString($chatUserData[0]->email);
							          	// $password = $chatUserData[0]->decrpted_password;
							          	//'http://chatingapp.onlinemariners.com/login?email='.$email.'&&password='.$password 
							          ?>
							          	<a href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatUserData[0]->id }}"  class="signin">
								          	<i class="ti-headphone-alt"></i> Chat Room
								        </a>
								    <?php 
											}
										} 
									?>
							          	@if(isset($empImg[0]->profile_status) && ($empImg[0]->profile_status ==1))
								          <a href="{{ route('postjob.index') }}"  class="signin">
								          	<i class="ti-ruler-pencil"></i> Post Job
								          </a>
							          	@endif
							          	<a class="dropdown-item" href="{{ route('logoutUser') }}" onclick="event.preventDefault();
																document.getElementById('logout-form-emp').submit();">
																<i class="fa fa-sign-in"></i> Sign Out</a>
									<form id="logout-form-emp" action="{{ route('logoutUser') }}" method="POST" style="display: none;">
										@csrf
									</form>
							          <!-- <a class="dropdown-item" href="#"> -->
							          	
									<!-- </a> -->
							          <div class="dropdown-divider"></div>
							          	
							        </div>
						      	</li>
					       	</ul>
						  </div>					
					@endif
				</li>
				@if(!isset($candidate) && !isset($employer)) 
	                <li>
						<a href="{{ route('signin.index') }}">Sign In Now</a>
						<!-- data-target="#signup" -->
					</li>
				@endif
			</ul>
				<ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
				
				
				
			</ul>
			
		</div><!-- /.navbar-collapse -->
	</div>   
	</nav>
	<!--
<a class="dropdown-item" href="{{-- route('logout') --}}" onclick="event.preventDefault();
																	document.getElementById('logout-form').submit();">
																	<i class="fa fa-sign-in"></i> Sign Out</a>
										<form id="logout-form" action="{{-- route('logout') --}}" method="POST" style="display: none;">
											@csrf
										</form>

	-->