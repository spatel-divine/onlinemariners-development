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
	.mobile-logout
	{
	display:none !important;
	}
	@media only screen and (min-width:320px) and (max-width:768px)
	{
	.mobile-logout
	{
	display:block !important;
	}
	}

	  .b-anchor {
    font-weight: bold !important;
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
		
		<div class="collapse navbar-collapse" id="navbar-menu" style="padding-top:15px">
			<ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
				<li class="">
					@if(($candEmail == '') && ($empEmail == ''))
						<a class="b-anchor" href="{{ route('homepage') }}" >Home</a>
					@elseif( (isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)) || isset($empEmail))
						<a class="b-anchor" href="{{ route('homepage') }}" >Home</a>
					@else
						<a class="b-anchor" href="" >Home</a>
					@endif
			
				</li>
				<li class="dropdown">
					<a href="" class="dropdown-toggle b-anchor" data-toggle="dropdown">Jobs</a>
					<ul class="dropdown-menu animated fadeOutUp">
						@if(($candEmail == '') && ($empEmail == ''))
			        		<li><a class="b-anchor" href="{{ route('joblist.companywise') }}">Browse Job By Company</a></li>
							<li><a class="b-anchor" href="{{ route('joblist.browse') }}">Browse Job</a></li>
						@elseif((isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)) || isset($empEmail))
							<li><a class="b-anchor" href="{{ route('joblist.companywise') }}">Browse Job By Company</a></li>
							<li><a class="b-anchor" href="{{ route('joblist.browse') }}">Browse Job</a></li>
						@else
							<li><a class="b-anchor" href="">Browse Job By Company</a></li>
							<li><a class="b-anchor" href="">Browse Job</a></li>
						@endif
					</ul>
				</li>
				
				@if(isset($employer) && ($employer !== ''))
					<li class="">
						<a class="b-anchor" href="{{ route('cand.gridlist')}}">Candidate</a>
					</li>
				@endif
				@if(($candEmail == '') && ($empEmail == ''))
					<li class="">
						<a class="b-anchor" href="{{ route('aboutus') }}" >About Us</a>
					</li>
					<li class="">
						<a class="b-anchor" href="{{ route('contactus.load') }}" >Contact Us</a>
					</li>
				@elseif(((isset($candEmail) && ($candidateData[0]->docs_uploaded == 1))) || isset($empEmail))
					<li class="">
						<a class="b-anchor" href="{{ route('aboutus') }}" >About Us</a>
					</li>
					<li class="">
						<a class="b-anchor" href="{{ route('contactus.load') }}" >Contact Us</a>
					</li>
				@else 
					<li class="">
						<a class="b-anchor" href="" >About Us</a>
					</li>
					<li class="">
						<a class="b-anchor" href="" >Contact Us</a>
					</li>				
				@endif

				@if(!isset($candidate) && !isset($employer))
	                <li>
						<a class="b-anchor" href="{{ route('signup') }}">SignUp</a>
					</li>
				@endif
				<li class="dropdown">
				@if(isset($candidate) && ($candidate !== ''))

				@if($candidateData[0]->docs_uploaded == 1)
						          <a class="dropdown-item   mobile-logout b-anchor" href="{{ route('cand.profile') }}">
						          	<i class="ti-home"></i> Profile
						          </a>
						          @endif

					<a class="dropdown-item b-anchor  mobile-logout" href="{{ route('logoutUser') }}" onclick="event.preventDefault();
							document.getElementById('logout-form-user').submit();">
							<i class="fa fa-sign-in"></i> Sign Out</a>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
    					<ul class="navbar-nav mr-auto" style="list-style-type: none;padding-top: 3%;">
							<li class="nav-item dropdown">
						        <a class="nav-link dropdown-toggle b-anchor" href="{{ route('cand.profile') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						          <span style='color:green;text-transform: capitalize;'>Welcome {{ mb_strimwidth($candidate.',' ,0,20,'...') }}</span>
						        </a>
						        <span class="caret"></span>
						        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					        		
						          @if($candidateData[0]->docs_uploaded == 1)
						          <a class="dropdown-item b-anchor" href="{{ route('cand.profile') }}">
						          	<i class="ti-home"></i> Profile
						          </a>
						          @endif
						         
						          <?php 
						          	
						          	if(isset($candEmail) && ((isset($candEmail) && ($candidateData[0]->docs_uploaded == 1)))){
						          		$chatData = DB::select("SELECT *  FROM users where email="."'".$candEmail."'");
						          		$candidateUser = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");
						          		
						          		if(!empty($candidateUser) && ($candidateUser[0]->email_verified_at == '1') && ($candidateUser[0]->candidate_status == '1')){
						          ?>
					          		<a class="dropdown-item b-anchor" href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatData[0]->id }}">
						          		<i class="ti-headphone-alt"></i> Chat Room
						          	</a>
						          <?php 
						          		}
						      		} 
					      		?>

						          <a class="dropdown-item b-anchor" href="{{ route('logoutUser') }}" onclick="event.preventDefault();
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
					
					@endif
					
					@if(isset($empEmail) && ($empEmail !== ''))	

						<a class="dropdown-item b-anchor  mobile-logout" href="{{ route('employer.profile') }}">
							          	<i class="ti-home"></i> Profile
							          </a>

					<a class="dropdown-item mobile-logout b-anchor" href="{{ route('logoutUser') }}" onclick="event.preventDefault();
						document.getElementById('logout-form-emp').submit();">
						<i class="fa fa-sign-in"></i> Sign Out</a>					
						
						 <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    					<ul class="navbar-nav mr-auto" style="list-style-type: none;padding-top: 3%;">
								<li class="nav-item dropdown">
							        <a class="nav-link dropdown-toggle b-anchor" href="{{ route('employer.profile') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							          <span style='color:green;text-transform: capitalize;'>Welcome {{ mb_strimwidth($employer ,0,20,'...')}}</span>
							        </a>
							        <span class="caret"></span>
							        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
							          
							          <a class="dropdown-item b-anchor" href="{{ route('employer.profile') }}">
							          	<i class="ti-home"></i> Profile
							          </a>
							          
							          <?php

							          if(isset($empEmail)){
							          	$chatUserData = DB::select("SELECT *  FROM users where email="."'".$empEmail."'");
							          	$empUser = DB::select("SELECT *  FROM employer where email="."'".$empEmail."'");
							          

							          if(isset($chatUserData[0]) && ($empUser[0]->email_varified == '1') && ($empUser[0]->profile_status == '1')){
						 
							          ?>
							          	<a href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatUserData[0]->id }}"  class="signin b-anchor">
								          	<i class="ti-headphone-alt"></i> Chat Room
								        </a>
								    <?php 
											}
										} 
									?>
							          	@if(isset($empImg[0]->profile_status) && ($empImg[0]->profile_status ==1))
								          <a href="{{ route('postjob.index') }}"  class="signin b-anchor">
								          	<i class="ti-ruler-pencil"></i> Post Job
								          </a>
							          	@endif

							          	<a class="dropdown-item b-anchor" href="{{ route('logoutUser') }}" onclick="event.preventDefault();
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
				</li>
				@if(!isset($candidate) && !isset($employer)) 
	                <li>
						<a class="b-anchor" href="{{ route('signin.index') }}">Sign In Now</a>
						<!-- data-target="#signup" -->
					</li>
				@endif
			</ul>
				<ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
				
				
				
			</ul>
			
		</div><!-- /.navbar-collapse -->
	</div>   
	</nav>
