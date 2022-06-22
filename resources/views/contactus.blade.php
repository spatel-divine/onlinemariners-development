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
</style>
<!-- Title Header Start -->
<section class="inner-header-title" style="background-image:url({{ $url }});">
	<div class="container">
		<h1>Contact Us</h1>
	</div>
</section>
<div class="clearfix"></div>
<!-- Title Header End -->

<!-- Contact Page Section Start -->
<section class="contact-page">
	<div class="container">
	<h2>Drop A Mail</h2>
	
		<!-- <div class="col-md-4 col-sm-4">
			<div class="contact-box">
				<i class="fa fa-map-marker"></i>
				<p>
					509, 5th Floor, Signature-1,<br/>
					Above Parsoli Motors,<br/>
					Prahladnagar, S G Highway,<br/>
					Ahmedabad–380051, Gujarat, India.
				</p>
			</div>
		</div> -->
		
		<div class="col-md-6 col-sm-6">
			<div class="contact-box">
				<i class="fa fa-envelope"></i>
				<p>Info@Westlineshipping.In</p>
			</div>
		</div>
		
		<div class="col-md-6 col-sm-6">
			<div class="contact-box">
				<i class="fa fa-phone"></i>
				<p>+91 99040 34567</p>
			</div>
		</div>
		
	</div>
</section>
<!-- contact section End -->

<!-- contact form -->
<section class="contact-form">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
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
			</div>
		</div>
		<h2>Drop A Mail</h2>
		<form name="contact_us" action="{{ route('inquirysave') }}" method="post">
			@csrf
			<div class="col-md-6 col-sm-6">
				<input type="text" name="name" class="form-control" placeholder="Your Name" required>
			</div>
			
			<div class="col-md-6 col-sm-6">
				<input type="email" name="email" class="form-control" placeholder="Your Email" required>
			</div>
			
			<div class="col-md-6 col-sm-6">
				<input type="number" name="phone_number" class="form-control" placeholder="Phone Number" required>
			</div>
			
			<div class="col-md-6 col-sm-6">
				<input type="text" name="subject" class="form-control" placeholder="Subject" required> 
			</div>
			
			<div class="col-md-12 col-sm-12">
				<textarea class="form-control" name="message" placeholder="Message" required></textarea>
			</div>
			
			<div class="col-md-12 col-sm-12">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</section>
<!-- Contact form End -->
@endsection