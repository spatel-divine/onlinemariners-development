@extends('layouts.app_afterLogin')
@section('content')
<?php  
	$url = "'".url('/public/assets/img/online_mariners_bredcrump.jpg')."'";
?>
<style type="text/css">
	.employee-caption {
	    text-align: center;
	    padding: 1em 0.8em;
	    min-height: 290px;
	}
</style>
	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url({{ $url }});">
		<div class="container">
			<h1>Testimonials</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Employee list start -->
	<section class="manage-employee gray">
		<div class="container">
			<!-- search filter -->
			<!-- <div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="search-filter">
					
						<div class="col-md-4 col-sm-5">
							<div class="filter-form">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search…">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default">Go</button>
									</span>
								</div>
							</div>
						</div>
							
						<div class="col-md-8 col-sm-7">
							<div class="short-by pull-right">
								Short By
								<div class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <i class="fa fa-angle-down" aria-hidden="true"></i></a>
								<ul class="dropdown-menu">
									<li><a href="#">Short By Date</a></li>
									<li><a href="#">Short By Views</a></li>
									<li><a href="#">Short By Popular</a></li>
								</ul>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div> -->
			<!-- search filter End -->
			
			<!-- Manage Employee -->
			<div class="row">
				<!-- 1 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">
						<!-- <a href="#" class="mail-form"><i class="fa fa-envelope"></i></a> -->
						<!-- <div class="pull-right">
							<div class="btn-group action-btn">
								<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="#">Favourite</a>
									</li>
									<li><a href="#">Edit</a>
									</li>
									<li><a href="#">Delete</a>
									</li>
								</ul>
							</div>
						</div> -->
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials5.png') }}" class="img-responsive" alt="" />
							</div>							
							<h4>Anna Hoysted</h4>
							<p>I got my job through this portal in a decent organisation and have a very friendly atmosphere to work .</p>
							<!-- <span class="designation">Web Designer</span> -->
							<!--
							<span class="designation">Web Designer</span>
							 <ul class="employee-social">
								<li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-instagram"></i></a></li>
							</ul> -->
						</div>
					</div>
				</div>
				<!-- 2 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">
						<!-- <a href="#" class="mail-form"><i class="fa fa-envelope"></i></a>
						<div class="pull-right">
							<div class="btn-group action-btn">
								<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="#">Favourite</a>
									</li>
									<li><a href="#">Edit</a>
									</li>
									<li><a href="#">Delete</a>
									</li>
								</ul>
							</div>
						</div> -->
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials3.png') }}" class="img-responsive" alt="" />
							</div>
							<h4>Jesse Leslie</h4>
							<p>Website is easy to use and very helpful.</p>
							<!-- <span class="designation">App Designer</span> -->
							<!-- <ul class="employee-social">
								<li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-instagram"></i></a></li>
							</ul> -->
						</div>
					</div>
				</div>
				<!-- 3 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">
						<!-- <a href="#" class="mail-form"><i class="fa fa-envelope"></i></a>
						<div class="pull-right">
							<div class="btn-group action-btn">
								<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="#">Favourite</a>
									</li>
									<li><a href="#">Edit</a>
									</li>
									<li><a href="#">Delete</a>
									</li>
								</ul>
							</div>
						</div> -->
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials7.png') }}" class="img-responsive" alt="" />
							</div>
							<h4>Zane Joyner</h4>
							<p>Excellent service all the way from beginning to end.</p>
							<!-- <span class="designation">IOS Developer</span> -->
							<!-- <ul class="employee-social">
								<li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-instagram"></i></a></li>
							</ul> -->
						</div>
					</div>
				</div>
				<!-- 4 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">
						<!-- <a href="#" class="mail-form"><i class="fa fa-envelope"></i></a>
						<div class="pull-right">
							<div class="btn-group action-btn">
								<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="#">Favourite</a>
									</li>
									<li><a href="#">Edit</a>
									</li>
									<li><a href="#">Delete</a>
									</li>
								</ul>
							</div>
						</div> -->
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials8.png') }}" class="img-responsive" alt="" />
							</div>
							<h4>Finn Osman</h4>
							<p>Online Mariner is good at pinpointing the jobs that were a good match for me. I'm very grateful.</p>
							<!-- <span class="designation">UI/UX Designer</span> -->
							<!-- <ul class="employee-social">
								<li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-instagram"></i></a></li>
							</ul> -->
						</div>
					</div>
				</div>
				<!-- 5 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">
						<!-- <a href="#" class="mail-form"><i class="fa fa-envelope"></i></a> -->
						<!-- <div class="pull-right">
							<div class="btn-group action-btn">
								<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<li><a href="#">Favourite</a>
									</li>
									<li><a href="#">Edit</a>
									</li>
									<li><a href="#">Delete</a>
									</li>
								</ul>
							</div>
						</div> -->
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials9.png') }}" class="img-responsive" alt="" />
							</div>
							<h4>Taylah Axon</h4>
							<p>Thank you for having a wide variety of posts available for the job.</p>
							<!-- <span class="designation">PHP Developer</span> -->							
							<!-- <ul class="employee-social">
								<li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" title=""><i class="fa fa-instagram"></i></a></li>
							</ul> -->
						</div>
					</div>
				</div>
				<!-- 6 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">
						
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials10.png') }}" class="img-responsive" alt="" />
							</div>
							<h4>Daniel Decose</h4>
							<p>Online mariner chat support made communication easy.</p>
							<!-- <span class="designation">Web Designer</span> -->
							
						</div>
					</div>
				</div>
				<!-- 7 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">						
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials11.png') }}" class="img-responsive" alt="" />
							</div>
							<h4>Charlotte Griffiths</h4>
							<p>Excellent experience with the online mariner job portal for finding a suitable job which I needed according to my expectations.</p>
							<!-- <span class="designation">SEO Expert</span>							 -->
						</div>
					</div>
				</div>
				<!-- 8 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">						
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials12.png') }}" class="img-responsive" alt="" />
							</div>
							<h4>Charlotte Penfold</h4>
							<p>IBest help for utilizing Online mariners for finding a new line of work.</p>
							<!-- <span class="designation">Java Developer</span>							 -->
						</div>
					</div>
				</div>
				<!-- 9 -->
				<div class="col-md-4 col-sm-6">
					<div class="jn-employee">						
						<div class="employee-caption">
							<div class="employee-caption-pic">
								<img src="{{ url('/public/assets/img/testimonials1.png') }}" class="img-responsive" alt="" />
							</div>
							<h4>Daniel Dax</h4>
							<p>Thank you online mariners for Best experience.</p>
							<!-- <span class="designation">Web Designer</span>							 -->
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="row">
				<ul class="pagination">
					<li><a href="#">&laquo;</a></li>
					<li class="active"><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li> 
					<li><a href="#">4</a></li> 
					<li><a href="#"><i class="fa fa-ellipsis-h"></i></a></li> 
					<li><a href="#">&raquo;</a></li> 
				</ul>
			</div> -->
		</div>
	</section>
	<!-- Employee List End -->
@endsection