@extends('layouts.app_afterLogin')
@section('content')
<?php  
	$url = "'".url('/public/assets/img/online_mariners_bredcrump.jpg')."'";
?>
<style type="text/css">
	.section-heading {
	    font-weight: 500;
	    letter-spacing: 1px;
	    text-transform: uppercase;
	    font-size: 22px;
	    margin-bottom: 0px;
	    line-height: unset;
	}
	.text-center {
	    text-align: center!important;
	}
	.line {
	    width: 8%;
	    margin: 0 auto;
	    height: 2px;
	    background-color: #000;
	    margin-top: 10px;
	    margin-bottom: 20px;
	}
	p,ul>li{
		font-family: 'Lato', sans-serif;
		font-size: 17px;
	}
	span{
		font-size: 18px;
	}
</style>
	<!-- Title Header Start -->
	<section class="inner-header-title" style="background-image:url({{ $url }});">
		<div class="container">
			<h1>Privacy Policy</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Title Header End -->

	<!-- Employee list start -->
	<section class="manage-employee gray" style="padding-top: 2%;">
		<div class="container">							
			<div class="row">
				<div class="col-sm-12" style="margin-bottom: 2%">
					<h2 class="text-center section-heading">Privacy Policy</h2>
					<div class="line"></div>
				</div>
				<div class="col-sm-12">
					<span>Online Mariners is solely about browsing for jobs. To protect your data and information is our top priority and trust is an important factor. Online Mariners takes your privacy in serious consideration. Our main aim is to collect your personal information for better functioning and to provide you with proficient experience. This permits us to give you all the services and meet all your requirements. It also enables us to make our service more customisable and easy to use.</span>					
				</div>
				
				<div class="col-sm-12">
				<br>
					<span>We maintain a healthy record of our members and also don't reveal any information like email address or contact number nor do we sell it or make it accessible to anyone else.</span>
					<ul style="margin-top: 2%;margin-bottom: 2%;">
					  <li><b>How can one change their information?</b><Br>Once you become a member of Online Mariners as a candidate or as an employer, your personal information is stored in the profile section of the site. You may access or change your information at any time and it will always be secured.</li>
					  <br><br>
					  <li><b>How Online Mariners keeps our information safe and secure?</b><br>We are focused on ensuring the security of your own data. We utilize an assortment of security innovations and strategies to help shield your data from unapproved access. For instance, we store the individual data you furnish on pc frameworks with restricted admittance, which are situated in controlled offices. At the point when we communicate exceptionally private data over the internet, we ensure it using encryption,for example, the secure socket layer (ssl) convention.</li>
					  
					</ul>
				</div>
				<div class="col-sm-12">
					<span>We may sometimes refresh this privacy policy for material changes to this security articulation. We urge you to occasionally review this security proclamation to remain informed about how we are ensuring the individual data we gather. Your proceeding with utilization of the administration establishes your consent to this security proclamation and any updates.</span>

					<span>Online Mariners takes their privacy policy very seriously. For any further questions or information, kindly contact us.</span>
				</div>

			</div>			
		</div>
	</section>
	<!-- Employee List End -->
@endsection