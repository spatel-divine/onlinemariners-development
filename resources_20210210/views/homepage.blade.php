@extends('layouts.app_website')

@section('content')
<?php

// echo $path = url("public/assets/img/".$joblists->company_logo);
// echo $company_logo =  $joblists[0]->company_logo;
	// echo '<pre>';
	// print_r($candidates);
	// exit;
$employer = Session::get('employerEmail');

?>
<style type="text/css">
    span.process-img {
        width: 0px !important;
        display: initial !important;
        height: 80px;
        margin: 15px auto 0;
        position: relative;        
    }
    
    iframe[Attributes Style] {
        width: 450px,
        height: 350px,    
    }
    .iframesize{
        width:390px !important;
        height:320px !important;
        /*width: 420px,
        height: 280px,*/
    }
    h2{
      text-align:center;
      padding: 20px;
    }
    /* Slider */

    .slick-slide {
        margin: 0px 20px;
    }

    .slick-slide img {
        width: 100%;
    }

    .slick-slider
    {
        position: relative;
        display: block;
        box-sizing: border-box;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
                user-select: none;
        -webkit-touch-callout: none;
        -khtml-user-select: none;
        -ms-touch-action: pan-y;
            touch-action: pan-y;
        -webkit-tap-highlight-color: transparent;
    }

    .slick-list
    {
        position: relative;
        display: block;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }
    .slick-list:focus
    {
        outline: none;
    }
    .slick-list.dragging
    {
        cursor: pointer;
        cursor: hand;
    }

    .slick-slider .slick-track,
    .slick-slider .slick-list
    {
        -webkit-transform: translate3d(0, 0, 0);
           -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
             -o-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
    }

    .slick-track
    {
        position: relative;
        top: 0;
        left: 0;
        display: block;
    }
    .slick-track:before,
    .slick-track:after
    {
        display: table;
        content: '';
    }
    .slick-track:after
    {
        clear: both;
    }
    .slick-loading .slick-track
    {
        visibility: hidden;
    }

    .slick-slide
    {
        display: none;
        float: left;
        height: 100%;
        min-height: 1px;
    }
    [dir='rtl'] .slick-slide
    {
        float: right;
    }
    .slick-slide img
    {
        display: block;
    }
    .slick-slide.slick-loading img
    {
        display: none;
    }
    .slick-slide.dragging img
    {
        pointer-events: none;
    }
    .slick-initialized .slick-slide
    {
        display: block;
    }
    .slick-loading .slick-slide
    {
        visibility: hidden;
    }
    .slick-vertical .slick-slide
    {
        display: block;
        height: auto;
        border: 1px solid transparent;
    }
    .slick-arrow.slick-hidden {
        display: none;
    }
    .v-disc{
        text-transform: capitalize;
    }
    @media (min-width: 1281px){
        .iframesize {
            width:390px !important;
            height:320px !important;
        }        
    }

    @media (min-width: 320px) and (max-width: 480px) {
  
        .iframesize{
            width:350px !important;
            height:300px !important;
        }            
    }
</style>
<!--home page -->
<section>
            <div class="container">
            	<!-- Latest Job List-->
                <div class="row">
                    <div class="main-heading">
                        <!-- <p>200 New Jobs</p> -->
                        <!-- <h2>New & Random <span>Jobs</span></h2> -->
                        <h2>Featured Jobs</h2>
                    </div>
                </div>

                <div class="row extra-mrg">
					@if (count($joblists) > 0)
						<!-- Single New Job -->
						@foreach($joblists as $job)
	                    <div class="col-md-3 col-sm-6">
	                        <div class="job-instructor-layout">
								<!-- <span class="tg-themetag tg-featuretag">Premium</span> -->
								<?php $logo  = isset($job->company_logo) ? $job->company_logo : ''; ?>
								<div class="brows-job-type"><span class="freelanc"> {{ mb_strimwidth($job->company_name, 0, 25, "...") }} </span></div>
								<div class="job-instructor-thumb">
                                <!-- <div class="ur-thumb"> -->
									<a href="{{ route('postjob.details', $job->id) }}">
                                        <img src="{{ url('public/companyLogo/'.$logo) }}" class="img-fluid" alt="" width="150" height="150" />
                                    </a>
								</div>
								<div class="job-instructor-content">
									<!-- <h4 class="instructor-title">
                                        <a href="{{-- route('postjob.details', $job->id) --}}">{{-- mb_strimwidth($job->job_title, 0, 25, "...") --}}</a>
                                    </h4> -->
									<div class="instructor-skills">
										{{ 'Vessel  Type: '.mb_strimwidth($job->vassel_type, 0, 14, "...") }}
									</div>
								</div>
								<div class="job-instructor-footer">
									<div class="instructor-students">
										<h5 class="instructor-scount">{{-- 'Contract for '.$job->contract_duration.' Months' --}}</h5>
									</div>
									<div class="instructor-corses">
										<span class="c-counting">{{ date('d-m-Y', strtotime($job->app_deadline)) }}</span>
									</div>
								</div>
							</div>

	                    </div>                    
	                    @endforeach

	                    <!-- url('public/empProfile/'.$emp[0]->company_logo) -->
					@else
    					<div class="col-lg-12 col-md-12 col-sm-12">
    						<div style="margin: 5% 35%;font-size: 2rem;text-align: center;font-weight: 500;">
    							</h1>No latest Job Post available.</h1>
    						</div>
    					</div>
					@endif
					@if (count($joblists) > 0)
						<div class="row" >
							<div class="col-md-12 col-sm-12" style="padding-top: 5%;">
								<div class="text-center">
									<a href="{{ route('joblist.companywise') }}" class="btn btn-primary">View All</a>
								</div>
							</div>
						</div>
					@endif
									                                       		
                </div> 
                <!-- End Latest Job List-->               
            </div>
        </section>
<!-- ITF Jobs -->
<section>
    <div class="container">             
        <div class="row">
            <div class="main-heading">                        
                <h2>ITF Jobs</h2>
            </div>
        </div>

        <div class="row extra-mrg">
            @if (count($itfJobs) > 0)
                <!-- Single New Job -->
                @foreach($itfJobs as $job)
                <div class="col-md-3 col-sm-6">
                    <div class="job-instructor-layout">
                        <!-- <span class="tg-themetag tg-featuretag">Premium</span> -->
                        <?php $logo  = isset($job->company_logo) ? $job->company_logo : ''; ?>
                        <div class="brows-job-type"><span class="freelanc"> {{ mb_strimwidth($job->company_name, 0, 25, "...") }} </span></div>
                        <div class="job-instructor-thumb">
                        <!-- <div class="ur-thumb"> -->
                            <a href="{{ route('postjob.details', $job->id) }}">
                                <img src="{{ url('public/companyLogo/'.$logo) }}" class="img-fluid" alt="" width="150" height="150" />
                            </a>
                        </div>
                        <div class="job-instructor-content">
                            <h4 class="instructor-title">
                                <a href="{{ route('postjob.details', $job->id) }}">{{ mb_strimwidth($job->job_title, 0, 25, "...") }}</a></h4>
                            <div class="instructor-skills">
                                {{ 'Vessel  Type: '.mb_strimwidth($job->vassel_type, 0, 14, "...") }}
                            </div>
                        </div>
                        <div class="job-instructor-footer">
                            <div class="instructor-students">
                                <h5 class="instructor-scount">{{-- 'Contract for '.$job->contract_duration.' Months' --}}</h5>
                            </div>
                            <div class="instructor-corses">
                                <span class="c-counting">{{ date('d-m-Y', strtotime($job->app_deadline)) }}</span>
                            </div>
                        </div>
                    </div>

                </div>                    
                @endforeach

                <!-- url('public/empProfile/'.$emp[0]->company_logo) -->
            @else
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div style="margin: 5% 35%;font-size: 2rem;text-align: center;font-weight: 500;">
                        </h1>No latest ITF Job available.</h1>
                    </div>
                </div>
            @endif
            @if (count($itfJobs) > 0)
                <div class="row" >
                    <div class="col-md-12 col-sm-12" style="padding-top: 5%;">
                        <div class="text-center">
                            <a href="{{ route('joblist.companywise') }}" class="btn btn-primary">View All</a>
                        </div>
                    </div>
                </div>
            @endif
                                                                        
        </div> 
        <!-- End Latest Job List-->               
    </div>
</section>
<!-- End of ITF Jobs -->
        <div class="clearfix"></div>
        <?php $videobgurl = url('public/assets/img/video-img-homepage.jpg'); ?>
        <!-- <section class="video-sec dark" id="video" style="background-image:url({{ $videobgurl }});">
            <div class="container">
                <div class="row">
                    <div class="main-heading">
                        <p>Best For Your Projects</p>
                        <h2>Watch Our <span>video</span></h2></div>
                </div>
                <div class="video-part"><a href="#" data-toggle="modal" data-target="#my-video" class="video-btn"><i class="fa fa-play"></i></a></div>
            </div>
        </section> -->
        <div class="clearfix"></div>
        <section class="how-it-works" style="background: #e2e2e2">
            <div class="container">
                <div class="row" data-aos="fade-up">
                    <div class="col-md-12">
                        <div class="main-heading">
                            <p>Working Process</p>
                            <h2>How It <span>Works</span></h2></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="working-process">
                            <span class="process-img" style="width: 0px !important;display: initial !important;">
                                <!-- <img src="public/assets/img/step-1.png" class="img-responsive" alt=""/><span class="process-num">01</span> -->
                            <!-- <video id="myMovie" width="300" height="300" poster="video.png"  >
                                <source src="https://drive.google.com/file/d/1XhaPGJ5HiUN8kkV3--3g8p7xxMqsMHJ-/view">
                            </video> -->
                            <iframe class="iframesize" src="https://www.youtube.com/embed/HTiaUXbALlU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                        </span>
                            <h4>Create An Account</h4>
                            <span>A user can create an account as a candidate or employer based on users requirement. In order to understand the process, watch the above video.</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="working-process">
                            <span class="process-img" style="width: 0px !important;display: initial !important;">
                                <!-- <img src="public/assets/img/step-2.png" class="img-responsive" alt=""/><span class="process-num">02 -->                            
                                <iframe class="iframesize"  src="https://www.youtube.com/embed/in3rY8FMafc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </span>

                        </span>
                            <h4>Search Jobs</h4>
                            <span>Online Mariners offers marine jobs such as Captain, Engineer, Oiler Etc. The video demonstrates how candidates can find and apply for the marine jobs.</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="working-process">
                            <span class="process-img">
                                <!-- <img src="public/assets/img/step-3.png" class="img-responsive" alt=""/><span class="process-num">03 -->
                                <iframe  class="iframesize"  src="https://www.youtube.com/embed/HTiaUXbALlU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </span>                            
                        </span>
                            <h4>Chat Room</h4>
                            <span>Online Mariners offers a chat room where candidates can chat and share documents via message and vice a versa.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		
        <div class="clearfix"></div>
        <section class="testimonial" id="testimonial">
            <div class="container">
                <div class="row">
                    <div class="main-heading">
                        <p>What Our Clients Say</p>
                        <h2>Our Success <span>Stories</span></h2></div>
                </div>
                <div class="row">
                    <div id="client-testimonial-slider" class="owl-carousel">
                        <div class="client-testimonial">
                            <div class="pic"><img src="public/assets/img/testimonials1.png" alt="Client 1"></div>
                            <p class="client-description">I got my job through this portal in a decent organisation and have a very friendly atmosphere to work .</p>
                            <h3 class="client-testimonial-title">Lacky Mole</h3>
                            <ul class="client-testimonial-rating">
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                            </ul>
                        </div>
                        <div class="client-testimonial">
                            <div class="pic"><img src="public/assets/img/testimonials2.png" alt="Client 2"></div>
                            <p class="client-description">Chat support and back-end service is good. It was easy to communicate and to get in touch.</p>
                            <h3 class="client-testimonial-title">Karan Wessi</h3>
                            <ul class="client-testimonial-rating">
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                            </ul>
                        </div>
                        <div class="client-testimonial">
                            <div class="pic"><img src="public/assets/img/testimonials3.png" alt="Client 3"></div>
                            <p class="client-description">This portal is very user friendly and has good filters to find jobs.<span style="color:white">This portal is very user friendly and has good filters to find jobs.</span></p>
                            <h3 class="client-testimonial-title">Roul Pinchai</h3>
                            <ul class="client-testimonial-rating">
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                            </ul>
                        </div>
                        <div class="client-testimonial">
                            <div class="pic"><img src="public/assets/img/testimonials4.png" alt="Client 4"></div>
                            <p class="client-description">Overall good experience with this portal.<span style="color:white">This portal is very user friendly and has good filters to find jobs.</span></p>
                            <h3 class="client-testimonial-title">Adam Jinna</h3>
                            <ul class="client-testimonial-rating">
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                                <li class="fa fa-star"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- Pricing -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<div class="container">
    <h2 style="color: #03a84e; font-family: "Poppins", sans-serif;">Companies</h2>    
    <section class="customer-logos slider">
      <div class="slide"><img src="public/assets/img/clogo1.jpg"></div>
      <div class="slide"><img src="public/assets/img/clogo2.jpg"></div>
      <div class="slide"><img src="public/assets/img/clogo3.jpg"></div>
      <div class="slide"><img src="public/assets/img/clogo4.jpg"></div>
      <div class="slide"><img src="public/assets/img/clogo5.jpg"></div>
      <div class="slide"><img src="public/assets/img/clogo6.jpg"></div>
      <div class="slide"><img src="public/assets/img/clogo7.jpg"></div>
      <div class="slide"><img src="public/assets/img/clogo8.jpg"></div>
      <!-- <div class="slide"><img src="https://image.freepik.com/free-vector/retro-label-on-rustic-background_82147503374.jpg"></div> -->
    </section>    
</div>
			
			
@endsection
