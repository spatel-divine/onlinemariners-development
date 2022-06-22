@extends('layouts.app_afterLogin')
<?php 
    // echo '<pre>';
    // print_r($ranksWithCount);
    // print_r($allPostJobLists);
    // exit;
	// $company_name = Request::segment(4);
	// $city = Request::segment(5);	
	$allCountries =  DB::select('SELECT countryname FROM country ORDER BY countryname ASC');
	// $companies =  DB::select('SELECT company_name FROM employer join postjob on employer.id = postjob.employer_id where profile_status = 1 and email_varified = 1 GROUP BY company_name ORDER By company_name ASC');
	$companies =  DB::select('SELECT DISTINCT  company_name FROM employer  where profile_status = 1  ORDER By company_name ASC');
	if(request()->company_name){
		$company_name = request()->company_name;	
	}else{
		$company_name = '';
	}
	if(request()->country_list){
		$country_list = request()->country_list;	
	}else{
		$country_list = '';
	}
	if(request()->rank_position){
		$search_rank  = request()->rank_position;	
	}else{
		$search_rank  = '';
	}
	if(request()->reset){
		if(($_GET['company_name'] != '')){
			$_GET['company_name'] = '';
		}
		if(($_GET['country_list'] != '')){
			$_GET['country_list'] = '';
		}
		if(($_GET['rank_position'] != '')){
			$_GET['rank_position'] = '';
		}
		
		$company_name = '';
		$country_list ='';
		$rank_position  = '';
	}
	// echo '<pre>';
	// print_r($companies);
	// exit;
?>
@php
	$candidateUser = Session::get('userName');
	$employerUser = Session::get('employerEmail');
@endphp
@section('content')
<style type="text/css">
	.newjob-list-layout h4 a{
		border-right: unset !important;
	}
	.colps-head.collapsed:before {
	    position: absolute;
	    right: 0;
	    top: 1px;
	    font-size: 19px;
	    color: #8892a9;
	    font-family: "themify";
	    content: "" !important;
	}
</style>
<!-- Title Header Start -->
			<?php $url =  url('public/assets/img/online_mariners_bredcrump.jpg'); ?>
			<section class="inner-header-title" style="background-image:url({{ $url }});">
				<div class="container">
					<h1>Advance Search</h1>
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- Title Header End -->
			
			<section class="advance-search">
				<div class="container">
					<div class="row">
					
						<div class="col-md-4 col-sm-12">
							<div class="full-sidebar-wrap">
								
								<!-- <a href="javascript:void(0)" onclick="openNav()" class="btn btn-dark full-width mrg-bot-20 hidden-lg hidden-md hidden-xl"><i class="ti-filter mrg-r-5"></i>Filter Search</a> -->
								
								<!-- Job Alert -->
								<!-- <a href="javascript:void(0)" class="btn btn-info full-width mrg-bot-20" data-toggle="modal" data-target="#job-alert">Get Job Alert!</a> -->
								<!-- /Job Alert -->
								<!-- hidden-xs hidden-sm -->
								<div class="show-hide-sidebar">
								
									<!-- Search Job -->
									<div class="sidebar-widgets">
									
										<div class="ur-detail-wrap">
											<div class="ur-detail-wrap-header">
												<h4>Search Job Here</h4>
											</div>
											<div class="ur-detail-wrap-body">
												<form method="get" action="{{ route('homesidejobfilter') }}">
													@csrf
													<div class="form-group">
														<label>Company Name</label>
														<!-- <input type="text" name="company_name" class="form-control" placeholder="Company Name"> -->
														<select id="" name="company_name" class="form-control">
															<option value="">Select Company</option>
															@if(isset($companies))
															    @foreach ($companies as $company)
																	<option value="{{ $company->company_name }}" 
																		{{ ($company->company_name == $company_name) ? 'selected': '' }}>
																		{{ $company->company_name }}
																	</option>
																@endforeach
															@endif
														</select>
													</div>
													<div class="form-group">
														<label>Country Name</label>
														<!-- <input type="text" name="city" class="form-control" placeholder="Country Name"> -->
														<select id="" name="country_list" class="form-control">
															<option value="">Select Country</option>
															@if(isset($allCountries))
															    @foreach ($allCountries as $c)
																	<option value="{{ $c->countryname }}" 
																		{{ ($c->countryname == $country_list) ? 'selected' : ''  }}>
																		{{ $c->countryname }}
																	</option>
																@endforeach
															@endif
														</select>
													</div>
													<div class="form-group">
														<label>Rank Category</label>
														<select id="" name="rank_position" class="form-control">
															<option value="">Choose Rank Category</option>
															<option value="Captain / Master" {{ ($search_rank == 'Captain / Master') ? 'selected' : ''}}>Captain / Master</option>
															<option value="Chief Engineer" {{ ($search_rank == 'Chief Engineer') ? 'selected' : ''}}>Chief Engineer</option>
															<option value="Chief Officer" {{ ($search_rank == 'Chief Officer') ? 'selected' : ''}}>Chief Officer</option>
															<option value="2nd Engineer" {{ ($search_rank == '2nd Engineer') ? 'selected' : ''}}>2nd Engineer</option>
															<option value="2nd Officer" {{ ($search_rank == '2nd Officer') ? 'selected' : ''}}>2nd Officer</option>
															<option value="3rd Engineer" {{ ($search_rank == '3rd Engineer') ? 'selected' : ''}}>3rd Engineer</option>
															<option value="3rd Officer" {{ ($search_rank == '3rd Officer') ? 'selected' : ''}}>3rd Officer</option>
															<option value="4th Engineer" {{ ($search_rank == '4th Engineer') ? 'selected' : ''}} >4th Engineer</option>
															<option value="Electrical Officer" {{ ($search_rank == 'Electrical Officer') ? 'selected' : ''}}>Electrical Officer</option>
															<option value="Electrical Technical Officer" {{ ($search_rank == 'Electrical Technical Officer') ? 'selected' : ''}}>Electrical Technical Officer</option>
															<option value="Trainee Electrical Officer" {{ ($search_rank == 'Trainee Electrical Officer') ? 'selected' : ''}}>Trainee Electrical Officer</option>
															<option value="AB" {{ ($search_rank == 'AB') ? 'selected' : ''}}>AB</option>
															<option value="Oiler" {{ ($search_rank == 'Oiler') ? 'selected' : ''}}>Oiler</option>
															<option value="Deck Cadet" {{ ($search_rank == 'Deck Cadet') ? 'selected' : ''}}>Deck Cadet</option>
															<option value="Engine Cadet" {{ ($search_rank == 'Engine Cadet') ? 'selected' : ''}}>Engine Cadet</option>
															<option value="OS" {{ ($search_rank == 'OS') ? 'selected' : ''}}>OS</option>
															<option value="Wiper" {{ ($search_rank == 'Wiper') ? 'selected' : ''}}>Wiper</option>
															<option value="Trainee OS" {{ ($search_rank == 'Trainee OS') ? 'selected' : ''}}>Trainee OS</option>
															<option value="Trainee Wiper" {{ ($search_rank == 'Trainee Wiper') ? 'selected' : ''}}>Trainee Wiper</option>
															<option value="Deck Fitter" {{ ($search_rank == 'Deck Fitter') ? 'selected' : ''}}>Deck Fitter</option>
															<option value="Engine Fitter" {{ ($search_rank == 'Engine Fitter') ? 'selected' : ''}}>Engine Fitter</option>
															<option value="Bosun" {{ ($search_rank == 'Bosun') ? 'selected' : ''}}>Bosun</option>
															<option value="Pumpman" {{ ($search_rank == 'Pumpman') ? 'selected' : ''}}> Pumpman</option>
															<option value="Motorman" {{ ($search_rank == 'Motorman') ? 'selected' : ''}}>Motorman</option>
															<option value="Crane Operator" {{ ($search_rank == 'Crane Operator') ? 'selected' : ''}}>Crane Operator</option>
															<option value="Chief Cook" {{ ($search_rank == 'Chief Cook') ? 'selected' : ''}}>Chief Cook</option>
															<option value="Cook" {{ ($search_rank == 'Cook') ? 'selected' : ''}}>Cook</option>
															<option value="2nd Cook" {{ ($search_rank == '2nd Cook') ? 'selected' : ''}}>2nd Cook</option>
															<option value="Assistant Cook" {{ ($search_rank == 'Assistant Cook') ? 'selected' : ''}}>Assistant Cook</option>
															<option value="General Steward" {{ ($search_rank == 'General Steward') ? 'selected' : ''}}>General Steward</option>
															<option value="Trainee General Steward" {{ ($search_rank == 'Trainee General Steward') ? 'selected' : ''}}>Trainee General Steward</option>
														</select>
													</div>
													<input type="submit" class="btn btn-primary half-width" value="Find Jobs" style="width: 49%;" />
													<!-- <input type="submit" value="Reset" name="reset" class="btn btn-primary half-width" value="reset" style="width: 49%;"/> -->
													<?php
														$path = url('/job/browse/joblist');
													?>
													<a class="btn btn-primary half-width" href="{{ $path }}" style="width: 49%;" id="filterReset">Reset</a>
												</form>
											</div>
										</div>
										
									</div>
									<!-- /Search Job -->
								
									<!-- Top Designation -->
									<!-- <div class="sidebar-widgets"> -->
										<!-- <div class="ur-detail-wrap"> -->										
											<!-- <div class="ur-detail-wrap-header">
												<h4>Top Designation</h4>
											</div>
											<div class="ur-detail-wrap-body">
												<ul class="advanc e-list">-->
													<?php $i = 1;?>
													{{-- @foreach($ranksWithCount as $rank) --}}
													<!-- <li> -->
														<?php 
														// if($rank->rank_position == 'Captain / Master'){
														// 	$ranklist = 'Captain_Master';
														// }else{
														// 	$ranklist = $rank->rank_position;
														// }
														// $rlist = '?rank='.$ranklist;
														?>
														<!-- <a href="{{-- route('joblist.browse', $rlist) --}}"> -->
														<!-- <span class="custom-checkbox"> -->
															<!-- id="aw" -->
															<!-- <input type="checkbox" name="rank_filter" id="rank_{{-- $i --}}" value="{{-- $rank->rank_position --}}"> -->
														<!-- 	<label for="aw"></label>
														</span> -->
														{{-- $rank->rank_position --}}
													<!-- </a> -->
														<!-- <span class="pull-right">{{-- $rank->rankcount --}}</span> -->
													<!-- </li> -->
													{{--
													@php $i++ @endphp
													@endforeach
													--}}
													<!-- <li>
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
													</li> -->
												<!-- </ul>
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
								
									<!-- Job Type -->
									<!-- <div class="sidebar-widgets">
										<div class="ur-detail-wrap colps-wrap">
										
											<div class="ur-detail-wrap-header">
												<h4 class="colps-head collapsed" data-toggle="collapse" href="#jb-types" role="button" aria-expanded="false" aria-controls="jb-types">Job Type</h4>
											</div>
											<div class="collapse" id="jb-types">
												<div class="ur-detail-wrap-body">
													<ul class="advance-list">
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="1">
																<label for="1"></label>
															</span>
															Full Time
															<span class="pull-right">102</span>
														</li>
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="2">
																<label for="2"></label>
															</span>
															Part Time
															<span class="pull-right">78</span>
														</li>
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="3">
																<label for="3"></label>
															</span>
															Internship
															<span class="pull-right">12</span>
														</li>
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="4">
																<label for="4"></label>
															</span>
															Freelancer
															<span class="pull-right">85</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div> -->
									<!-- /Job Type -->
								
									<!-- Location -->
									<!-- <div class="sidebar-widgets">
										<div class="ur-detail-wrap colps-wrap"> -->
										
											<!-- <div class="ur-detail-wrap-header">
												<h4 class="colps-head collapsed" data-toggle="collapse" href="#jb-location" role="button" aria-expanded="false" aria-controls="jb-location">Popular Locations</h4>
											</div> -->
											<!-- <div class="collapse in" id="jb-location">
												<div class="ur-detail-wrap-body">
													<ul class="advance-list">
														
														{{-- @foreach($locationWisehPostjob as $location) --}}
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="1">
																<label for="1"></label>
															</span> 
															<?php //url(''); ;?>
															<a href="{{-- $rlist.'&city='.$location->city --}}">
																{{-- $location->city --}}
															</a>
															<span class="pull-right">{{-- $location->citycount --}}</span>
														</li>
														{{-- @endforeach --}}
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
								
									<!-- Compensation -->
									<!-- <div class="sidebar-widgets">
										<div class="ur-detail-wrap colps-wrap">
										
											<div class="ur-detail-wrap-header">
												<h4 class="colps-head collapsed" data-toggle="collapse" href="#jb-Compensation" role="button" aria-expanded="false" aria-controls="jb-Compensation">Compensation</h4>
											</div>
											<div class="collapse" id="jb-Compensation">
												<div class="ur-detail-wrap-body">
													<ul class="advance-list">
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="1">
																<label for="1"></label>
															</span>
															Under $10,000
															<span class="pull-right">102</span>
														</li>
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="2">
																<label for="2"></label>
															</span>
															$10,000 - $15,000
															<span class="pull-right">78</span>
														</li>
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="3">
																<label for="3"></label>
															</span>
															$15,000 - $20,000
															<span class="pull-right">12</span>
														</li>
														<li>
															<span class="custom-checkbox">
																<input type="checkbox" id="4">
																<label for="4"></label>
															</span>
															$20,000 - $30,000
															<span class="pull-right">85</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div> -->
									<!-- /Compensation -->
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
									<p>
										<strong>NOTE:  <span style="color: green; text-transform: none !important;">Only candidates or users who have already registered with Online Mariners will be able to apply for the job.</span>
										</strong>
									</p>
								</div>
								<div class="col-md-12">
									
									<!-- Dynamic Single New Job -->
									@foreach($allPostJobLists as $browsePostjob)
									
									<div class="newjob-list-layout" style="border-right: unset !important;">
										<div class="cll-wrap">
											<div class="cll-thumb">
												<a href="">
													<img src="assets/img/com-1.jpg" class="img-responsive img-circle" alt="" />
												</a>
											</div>
											<div class="cll-caption">
												<h4 style="text-transform: capitalize;">
													<a href="{{ route('postjob.details', $browsePostjob->id.'?requestpage=browsejoblist') }}">
														{{ mb_strimwidth($browsePostjob->company_name, 0, 35,'...') }}
													</a>	
												</h4>
												<ul>
													<li>
														<i class=" ti-briefcase cl-danger"></i>
														{{ mb_strimwidth($browsePostjob->rank_position, 0, 30, "...") }}
													</li>
													<li>
														<i class="ti-location-pin cl-success"></i>
														<?php
															$country = (isset($browsePostjob->country) && ($browsePostjob->country != '')) ? $browsePostjob->country : 'Not Updated Yet' ;
														?>
														{{ mb_strimwidth($country , 0,17,'...') }}
													</li>
												</ul>
											</div>
										</div>
										{{-- @if(isset($candidateUser)) --}}
										@if(!$employerUser)
										<div class="cll-right">
											<a href=" {{ route('cand.apply', 
											[$browsePostjob->id,$browsePostjob->postwage_id]) }}" class="btn theme-btn btn-shortlist"><i class="ti-arrow-right"></i>Apply</a>
										</div>
										@endif
										{{-- @endif --}}
									</div>
									@endforeach									
									@if(count($allPostJobLists) < 1)
									<div class="row" style="text-align: center;padding-top: 5%">
										<div class="col-sm-12">
											<h3 style="color:#03a84e;">Requested Data Not Found</h3>
										</div>
									</div>
									@endif
									<!-- Single New Job -->
									<!-- <div class="newjob-list-layout">
										<div class="cll-wrap">
											<div class="cll-thumb">
												<a href="job-detail-2.html"><img src="assets/img/com-1.jpg" class="img-responsive img-circle" alt="" /></a>
											</div>
											<div class="cll-caption">
												<h4><a href="job-detail-2.html">Product Designer</a><span class="jb-status full-time">Full Time</span></h4>
												<ul>
													<li><i class="ti-home cl-danger"></i>Trish Technologies</li>
													<li><i class="ti-credit-card cl-success"></i>$2000 - $3500 P.A </li>
												</ul>
											</div>
										</div>
										
										<div class="cll-right">
											<a href="job-detail-2.html" class="btn theme-btn btn-shortlist"><i class="ti-arrow-right"></i>Apply</a>
										</div>
									</div>
									
									
									<div class="newjob-list-layout">
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
									</div>
									
									
									<div class="newjob-list-layout">
										<div class="cll-wrap">
											<div class="cll-thumb">
												<a href="job-detail-2.html"><img src="assets/img/com-3.jpg" class="img-responsive img-circle" alt="" /></a>
											</div>
											<div class="cll-caption">
												<h4><a href="job-detail-2.html">Graphic Designer</a><span class="jb-status freelancer-time">Freelancer</span></h4>
												<ul>
													<li><i class="ti-home cl-danger"></i>Tincle Hub</li>
													<li><i class="ti-credit-card cl-success"></i>$1900 - $2500 P.A </li>
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
							
							@if(isset($allPostJobLists))
							<div class="row mrg-0">
								{!! $allPostJobLists->render() !!}
								<!-- <ul class="pagination">
									<li><a href="#"><i class="ti-arrow-left"></i></a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li> 
									<li><a href="#">4</a></li> 
									<li><a href="#"><i class="fa fa-ellipsis-h"></i></a></li> 
									<li><a href="#"><i class="ti-arrow-right"></i></a></li> 
								</ul> -->
							</div>
							@endif
						</div>
						
					</div>
				</div>
			</section>
@endsection

@section('datepicker')
<script>
	var favorite = [];
            
	
	$('input[id^="rank_"]').not('#checkbox_all').click(function () {
            // $('#checkbox_all').prop('checked', false);

   		alert($(this).val());  

   		$.each($("input[name='rank_filter']:checked"), function(){            
            favorite.push($(this).val());
        });

		// alert(  JSON.stringify(favorite) );
  //       alert("My favourite sports are: " + favorite.join(", "));

        $.ajaxSetup({
		    headers: {
		      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		//get unique data in array
        function onlyUnique(value, index, self) { 
		    return self.indexOf(value) === index;
		}

		// usage example:
		var rankSearchList = favorite;
		// var a = ['a', 1, 'a', 2, '1'];
		var rankSearchList = rankSearchList.filter( onlyUnique );

        // var rankSearchList = JSON.stringify(favorite);
        
		$.ajax({
		type:"POST",
		url: "{{ route('rank.filter') }}",
		data: {rankSearchList: rankSearchList},
		success: function(data){
				// var postwage_id = JSON.parse(data);
				// $('#postwage_id').val(postwage_id);	      
			}
		})
	
	});
</script>
@endsection