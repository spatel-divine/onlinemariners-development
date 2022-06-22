<style type="text/css">	
	.homelesscaret a.dropdown-toggle:after {
	    font-family: FontAwesome;
	    content: "" !important;
	    margin-left: 5px;
	    margin-top: 2px;
	}
	.home-hearer{
		background-color: white !important;
		/*margin-top: 8%;*/
	}
	/*.navbar-right */
	#navbar-menu ul.nav > li > a{
		color: #657582 !important;
	}
	nav.navbar.bootsnav {    	
    	border-bottom: 1px solid #fff;
	}
	.banner.trans {
    	min-height: 680px;
    	margin-top: 5%;
	}
</style>
<nav class="navbar navbar-default navbar-fixed navbar-transparent white bootsnav home-hearer">
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
			?>
            <div class="container">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"><i class="fa fa-bars"></i></button>
                <div class="navbar-header">
                	<?php
                		// var_dump(($candEmail == '') && ($empEmail == ''));
                		// exit;
                	?>
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
                        <img src="{{ url('public/assets/img/logo.png') }}" class="logo logo-display" alt="">
                        <img src="{{ url('public/assets/img/logo.png') }}" class="logo logo-scrolled" alt="">
                    </a>
                    @endif
                    
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                    	@if(!isset($candidate) && !isset($employer))
                        <li>
							<a href="{{ route('signup') }}">SignUp</a>
						</li>
						@endif						
						@if(isset($candidate) && ($candidate !== ''))
							<!-- <li style="padding-top: 0.5rem;color:white;text-transform: capitalize;"> 
								<a href="{{ route('cand.dashboard') }}">
									<span style='text-transform: capitalize;'>Welcome {{ $candidate.',' }}</span>
								</a>
							<li>  
								
							</li> -->
							<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    					<ul class="navbar-nav mr-auto" style="list-style-type: none;padding-top: 5%;">
								<li class="nav-item dropdown">
							        <a class="nav-link dropdown-toggle" href="{{ route('cand.profile') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							          <span style='color:#657582;text-transform: capitalize;'>Welcome {{ mb_strimwidth($candidate.',' ,0,20, '...') }}</span>
							        </a>
							        <span style='color:#657582;' class="caret"></span>
							        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
							          
							          <a class="dropdown-item" href="{{ route('cand.profile') }}">
							          	<i class="ti-home"></i> Profile
							          </a>
							          <!-- <a class="dropdown-item" href="{{-- route('candi.chat') --}}">
							          	<i class="ti-headphone-alt"></i> Chat
							          </a> -->
							          <?php 
						          	
						          	if(isset($candEmail)){
						          		$chatData = DB::select("SELECT *  FROM users where email="."'".$candEmail."'");
						          		$candidateUser = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");
						          		// echo "<pre>";
						          		// print_r($chatData);exit;
						          		if($candidateUser && ($candidateUser[0]->email_verified_at == '1') && ($candidateUser[0]->candidate_status == '1')){
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
							          
							          <div class="dropdown-divider"></div>
							          	
							        </div>
						      	</li>
					       	</ul>
						  </div>
						@endif
						@if(isset($empEmail) && ($empEmail !== ''))						
							<!-- <li style="padding-top: 0.5rem;color:white;text-transform: capitalize;">
								<a href="{{ route('employer.dashboard') }}">									
									<span style='text-transform: capitalize;'>Welcome {{ $employer.',' }}</span>
								</a>
							</li>
							<li>  
								<a href="{{-- route('logout') --}}" onclick="event.preventDefault();
			                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-in"></i>Sign Out</a>
								<form id="logout-form" action="{{-- route('logout') --}}" method="POST" style="display: none;">
			                        @csrf
			                    </form>
							</li> -->
							<div class="collapse navbar-collapse" id="navbarSupportedContent">
		    					<ul class="navbar-nav mr-auto" style="list-style-type: none;padding-top: 5%;">
									<li class="nav-item dropdown">
								        <a class="nav-link dropdown-toggle" href="{{ route('employer.profile') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								          <span style='color:#657582;text-transform: capitalize;'>Welcome {{ mb_strimwidth($empEmail.',' ,0,20,'...') }}</span>
								        </a>
								        <span style='color:#657582;' class="caret"></span>
								        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
								          
								          <a class="dropdown-item" href="{{ route('employer.profile') }}">
								          	<i class="ti-home"></i> Profile
								          </a>
								          <!-- <a class="dropdown-item" href="{{-- route('empchat') --}}">
							          	<i class="ti-headphone-alt"></i> Chat
							          </a> -->
								          	<?php							          	
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

								          	<a class="dropdown-item" href="{{ route('logoutUser') }}" onclick="event.preventDefault();
																document.getElementById('logout-form-emp').submit();">
																<i class="fa fa-sign-in"></i> Sign Out</a>
											<form id="logout-form-emp" action="{{ route('logoutUser') }}" method="POST" style="display: none;">
												@csrf
											</form>										
								          <div class="dropdown-divider"></div>								          	
								        </div>
							      	</li>
						       	</ul>
							  </div>
						@endif
						@if(!isset($candidate) && !isset($employer)) 
	                        <li>
								<a href="{{ route('signin.index') }}">Sign In Now</a>
								<!-- data-target="#signup" -->
							</li>
						@endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="">                        	
                        	@if(($candEmail == '') && ($empEmail == ''))
                        		<a href="{{ route('homepage') }}" >Home</a>
							@elseif( (isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)) || isset($empEmail))
								<a href="{{ route('homepage') }}" >Home</a>
							@else
								<a href="" >Home</a>
							@endif
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
								
							</ul>
						</li> -->
						<!-- <li class="dropdown megamenu-fw"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse</a> -->

							<!-- <ul class="dropdown-menu megamenu-content" role="menu"> -->
								<!-- <li>
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
										</div>end col-3
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
								</li> -->
							<!-- </ul> -->
						<!-- </li> -->
						@if( (isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)) || isset($empEmail))
						<li class="">
							<a href="{{ route('cand.gridlist')}}" >Candidate</a>
						</li>
						@endif
						<li class="">
							<a href="{{ route('aboutus') }}" >About Us</a>
						</li>
						<li class="">
							<a href="{{ route('contactus.load') }}" >Contact Us</a>
						</li>
						@if(($candidate == '')) 
	                        <!-- <li class="left-br">
								<a href="{{ route('signin.index') }}">Sign In</a>								
							</li> -->
						@endif
						@if($employer == '')
							<!-- <li class="left-br">
								<a href="{{ route('signin.index') }}">Sign In</a>							
							</li> -->
						@endif
						@if($candidate == '')
                        <!-- <li>
							<a href="{{ route('signup') }}">SignUp</a>
						</li> -->
						@endif
						@if($employer == '')
						<!-- <li>
							<a href="{{ route('signup') }}">SignUp</a>
						</li> -->
						@endif
                    </ul>
                </div>
            </div>
        </nav>