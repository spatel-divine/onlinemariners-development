@extends('layouts.app_afterLogin')
<?php
	// echo '<pre>';
	// print_r($candidateList);
	// exit;
?>
@section('content')
<style type="text/css">
	.newjob-list-layout h4 a {
	    border-right: 0px solid #dbe6ef;
	    padding-right: 8px;
	}
</style>
<!-- Title Header Start -->
			<section class="inner-header-title" style="background-image:url({{url('/public/assets/img/online_mariners_bredcrump.jpg') }});">
				<div class="container">
					<h1>Candidate List</h1>
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- Title Header End -->
			<section class="advance-search">
				<div class="container">
					<div class="row">
						
						<div class="col-md-4 col-sm-12">
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
		                            <b>Alert ! </b>{{ 'Active account by clicking on "Create OR Update profile" menu.'  }}
		                        </div>
		                    @endif
							<div class="full-sidebar-wrap">								
								<!-- <a href="javascript:void(0)" onclick="openNav()" class="btn btn-dark full-width mrg-bot-20 hidden-lg hidden-md hidden-xl"><i class="ti-filter mrg-r-5"></i>Filter Search</a> -->
								
								<!-- Job Alert -->
								<!-- <a href="javascript:void(0)" class="btn btn-info full-width mrg-bot-20" data-toggle="modal" data-target="#job-alert">Get Job Alert!</a> -->
								<!-- /Job Alert -->
								
								<div class="show-hide-sidebar hidden-xs hidden-sm">
								
									<!-- Search Job -->
									<div class="sidebar-widgets">
									
										<div class="ur-detail-wrap">
											<div class="ur-detail-wrap-header">
												<h4>Search Candidate Here</h4>
											</div>
											<div class="ur-detail-wrap-body">
												<form method="get" action="{{ route('filterCanidate') }}">							@csrf
													<div class="form-group">
														<label>Choose Experience (in years)</label>
														<select id="choose-1" class="form-control" name="experience_years">
															<option>Choose Experience</option>
															@for($i=1;$i<51;$i++)
															<option value="{{ $i }}"> {{ $i }}</option>
															@endfor
														</select>
													</div>
													<div class="form-group">
														<label>Choose Rank</label>
														<select id="choose-category1" class="form-control" name="rank_position">
															<option>Choose Rank</option>
															<option value="Captain / Master">Captain / Master</option>
															<option value="Chief Engineer">Chief Engineer</option>
															<option value="Chief Officer">Chief Officer</option>
															<option value="2nd Engineer">2nd Engineer</option>
															<option value="2nd Officer">2nd Officer</option>
															<option value="3rd Engineer">3rd Engineer</option>
															<option value="3rd Officer">3rd Officer</option>
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
													<button type="submit" class="btn btn-primary full-width">Search Candidate</button>
												</form>
											</div>
										</div>
										
									</div>
									<!-- /Search Job -->
								
									<!-- Top Designation -->
									<!-- <div class="sidebar-widgets">
										<div class="ur-detail-wrap">
										
											<div class="ur-detail-wrap-header">
												<h4>Top Designation</h4>
											</div>
											<div class="ur-detail-wrap-body">
												<ul class="advance-list">
													<li>
														<span class="custom-checkbox">
															<input type="checkbox" id="aw">
															<label for="aw"></label>
														</span>
														Project Manager
														<span class="pull-right">102</span>
													</li>
													<li>
														<span class="custom-checkbox">
															<input type="checkbox" id="dd">
															<label for="dd"></label>
														</span>
														Business Executive
														<span class="pull-right">78</span>
													</li>
													<li>
														<span class="custom-checkbox">
															<input type="checkbox" id="er">
															<label for="er"></label>
														</span>
														Supervisor
														<span class="pull-right">12</span>
													</li>
													<li>
														<span class="custom-checkbox">
															<input type="checkbox" id="tr">
															<label for="tr"></label>
														</span>
														Team Leader
														<span class="pull-right">85</span>
													</li>
												</ul>
											</div>
										
										</div>
									</div> -->
									<!-- /Top Designation -->
								
									<!-- Experince -->
									<!-- <div class="sidebar-widgets">
										<div class="ur-detail-wrap">
										
											<div class="ur-detail-wrap-header">
												<h4>Experince</h4>
											</div>
											<div class="ur-detail-wrap-body">
												<ul class="advance-list">
													<li>
														<span class="custom-checkbox">
															<input type="checkbox" id="uy">
															<label for="uy"></label>
														</span>
														0 - 1 Year
														<span class="pull-right">102</span>
													</li>
													<li>
														<span class="custom-checkbox">
															<input type="checkbox" id="io">
															<label for="io"></label>
														</span>
														1 - 2 Year
														<span class="pull-right">78</span>
													</li>
													<li>
														<span class="custom-checkbox">
															<input type="checkbox" id="lo">
															<label for="lo"></label>
														</span>
														2 - 4 Year
														<span class="pull-right">12</span>
													</li>
													<li>
														<span class="custom-checkbox">
															<input type="checkbox" id="kj">
															<label for="kj"></label>
														</span>
														4 - 6 Year
														<span class="pull-right">85</span>
													</li>
												</ul>
											</div>
										
										</div>
									</div> -->
									<!-- /Experince -->
								
									
								
									<!-- Location -->
									<!-- <div class="sidebar-widgets">
										<div class="ur-detail-wrap colps-wrap">
										
											<div class="ur-detail-wrap-header">
												<h4 class="colps-head" data-toggle="collapse" href="#jb-location" role="button" aria-expanded="false" aria-controls="jb-location">Popular Locations</h4>
											</div>
											<div class="collapse in" id="jb-location">
												<div class="ur-detail-wrap-body">
													<ul class="advance-list">
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="1">
																<label for="1"></label>
															</span>
															Mohali
															<span class="pull-right">102</span>
														</li>
														
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="2">
																<label for="2"></label>
															</span>
															Chandigarh
															<span class="pull-right">78</span>
														</li>
														
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="3">
																<label for="3"></label>
															</span>
															Chennai
															<span class="pull-right">12</span>
														</li>
														
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="4">
																<label for="4"></label>
															</span>
															Delhi
															<span class="pull-right">85</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div> -->
									<!-- /Popular Locations -->
								
									
								</div>
								
							</div>
						</div>
					
						<div class="col-md-8 col-sm-12">
							
							<!--Filter -->							
							<!-- <div class="row">
								<div class="col-md-12">
									<div class="filter-wraps">
										
										<div class="filter-wraps-one">
											<i class="ti-search"></i>
											<ul>
												<li><a href="#">CSS3<i class="ti-close"></i></a></li>
												<li><a href="#">Wordpress<i class="ti-close"></i></a></li>
												<li><a href="#">Photoshop<i class="ti-close"></i></a></li>
											</ul>
										</div>
										<div class="filter-wraps-two">
											<h5><a href="#">RESET FILTERS</a></h5>
										</div>
										
									</div>
								</div>
							</div> -->
							<!--/.Filter -->
							
							<!--Browse Job -->							
							<div class="row">
								<div class="col-md-12">
									
									<!-- Single New Job -->
								@if(count($candidateList) > 0)
									@foreach($candidateList as $candidate)
									<div class="newjob-list-layout">
										<div class="cll-wrap">
											<div class="cll-thumb">
												<a href=""><img src="assets/img/com-1.jpg" class="img-responsive img-circle" alt="" /></a>
											</div>
											<div class="cll-caption">
												<h4 style="text-transform: capitalize;">
													<a href="{{ route('cand.details', $candidate->id.'?frompage=candidategridlist') }}">{{ $candidate->name }}</a>
													<span class="">
													<?php 
														if(($candidate->experience_years > 0) && ($candidate->experience_months > 0)){
															$exp = $candidate->experience_years.' Years '.$candidate->experience_months.' months';
														}else if(($candidate->experience_years > 0) && ($candidate->experience_months <1)){
															$exp = $candidate->experience_years.' Years ';
														}else if(($candidate->experience_years <1) && ($candidate->experience_months > 0)){
															$exp = $candidate->experience_months.' Months ';
														}else{
															$exp = 'No Experience';
														}													
													?>
													Experience: <label style=""> {{ $exp ? $exp : 'Not Avilable'  }} </label>
													</span>
												</h4>
												</h4>
												<ul>
													<li><i class="ti-email"></i> {{ isset($candidate->email) ? $candidate->email : 'Not Update Yet'}}</li>
													<li><i class="ti-briefcase"></i>{{ isset($candidate->applied_for) ? $candidate->applied_for : 'Not Available' }}</li>
													<li>
														<?php 
															$employer = Session::get('employerEmail');
															
															if($employer){
																$chatUserData = DB::select("SELECT *  FROM users where email="."'".$employer."'");
																// echo "<pre>";
																// print_r($chatUserData);
																// exit;
																$id = $chatUserData[0]->id;	
															}else{
																$id = '';
															}
															$candidateID = $candidate->candidate_chat_id;
															// print_r($candidateID);
															// exit;
															$chatPath = "http://chatingapp.onlinemariners.com/login?id=".$id."&&candidateid=".$candidateID;
														?>
														<a href="{{ route('chatrecAdd', ['id' => $id, 'candidateID' => $candidateID]) }}" class="chatroom ">
															<b style="margin-left: 2.2rem;">Click To Chat</b>
														</a>
													</li>
												</ul>
											</div>
										</div>
										
										<!-- <div class="cll-right">
											<a href="job-detail-2.html" class="btn theme-btn btn-shortlist"><i class="ti-arrow-right"></i>Apply</a>
										</div> -->
									</div>
									@endforeach
								@else
									<div class="row">
										<div class="col-sm-12" style="color:green; text-align: center;padding-top: 5%;">
											<h3>No Result Found</h3>
										</div>
									</div>
								@endif
									<!-- Single New Job -->
									<!-- <div class="newjob-list-layout">
										<div class="cll-wrap">
											<div class="cll-thumb">
												<a href="job-detail-2.html"><img src="assets/img/com-2.jpg" class="img-responsive img-circle" alt="" /></a>
											</div>
											<div class="cll-caption">
												<h4><a href="job-detail-2.html">Wordpress Expert</a><span class="jb-status part-time">Part Time</span></h4>
												<ul>
													<li><i class="ti-home cl-danger"></i>Disha Technologies</li>
													<li><i class="ti-credit-card cl-success"></i>$2500 - $4200 P.A </li>
												</ul>
											</div>
										</div>
										
										<div class="cll-right">
											<a href="job-detail-2.html" class="btn theme-btn btn-shortlist"><i class="ti-arrow-right"></i>Apply</a>
										</div>
									</div> -->

								</div>
							</div>
							<!--/.Browse Job-->
							
							
							@if(isset($candidateList))
							<div class="row mrg-0">
								{!! $candidateList->render() !!}								
							</div>
							@endif
							
						</div>
						
					</div>
				</div>
			</section>
			
@endsection



