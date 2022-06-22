@extends('layouts.app_afterLogin')
<?php 
    // echo '<pre>';
    // print_r($allPostJobLists);
    // exit;
	$url = "'".url('/public/assets/img/online_mariners_bredcrump.jpg')."'";
?>
@section('content')
<style type="text/css">
	.contact-form .btn-primary:hover, .contact-form .btn-primary:focus{
		max-width: 250px;
	    padding: 15px 25px !important;
	    height: auto;
	    margin: 15px auto;
	    display: block;
	    border: none;	    
	}
	.titlevideo{
		text-align: center;
	    font-size: 20px;
	    font-weight: bolder;
	    color: green;
	    font-family: serif;	
	}
	
	p
	{
		text-transform: inherit;
	}
</style>
<!-- Title Header Start -->
<section class="inner-header-title" style="background-image:url({{ $url }});">
	<div class="container">
		<h1>Knowledge Base</h1>
	</div>
</section>
<div class="clearfix"></div>
<!-- Title Header End -->

<!-- Contact Page Section Start -->
<section class="contact-page">
	<div class="container">
		<div class="row">
			<!-- frame size w = 360 h = 240 -->
			<div class="col-sm-4">				
				<iframe width="350" height="240" src="https://www.youtube.com/embed/HTiaUXbALlU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<p style="text-align: center;font-size: 20px;font-weight: bolder;color: green;font-family: serif;">Online Mariners Verification Process</p>
			</div>
			<div class="col-sm-4">
				<iframe width="350" height="240" src="https://www.youtube.com/embed/in3rY8FMafc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<p style="text-align: center;font-size: 20px;font-weight: bolder;color: green;font-family: serif;">Candidate Applying for the Job</p>
			</div>
			<div class="col-sm-4">
				<!-- <iframe width="360" height="240" src="https://www.youtube.com/embed/HTiaUXbALlU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
				<iframe width="350" height="240" src="https://www.youtube.com/embed/8yR0VHvWUWc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<p style="text-align: center;font-size: 20px;font-weight: bolder;color: green;font-family: serif;">Employer Registration</p>
			</div>
		</div>		
	</div>
</section>
<!-- End  Row1 -->

<!-- Row2 -->
<!-- <section class="contact-form">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<iframe width="360" height="240" src="https://www.youtube.com/embed/HTiaUXbALlU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<div class="col-sm-4">
				<iframe width="360" height="240" src="https://www.youtube.com/embed/HTiaUXbALlU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<div class="col-sm-4">
				<iframe width="360" height="240" src="https://www.youtube.com/embed/HTiaUXbALlU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section> -->
<!-- Contact form End -->
@endsection