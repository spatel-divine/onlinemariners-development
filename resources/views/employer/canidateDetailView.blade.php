@extends('layouts.app_afterLogin')

@section('content')
<?php
$requestFromPage = app('request')->input('frompage');
$employer = Session::get('employerEmail');
// echo 'qs '.$_GET['frompage'];
// echo '<pre>';
// print_r($employer);
// exit;
?>
<style type="text/css">
	.activeStatus {
	    width: 12px;
	    height: 12px;
	    background: #1baf65;
	    border-radius: 20px;
	    position: absolute;
	    bottom: 21%;
    	left: -18px;
/* 	    left: 0; */
	    transition: border .10s;
	}
	.inactiveStatus {
	    width: 12px;
	    height: 12px;
	    background: red;
	    border-radius: 20px;
	    position: absolute;
	    bottom: 21%;
    	left: -18px;
/* 	    left: 0; */
	    transition: border .10s;
	}
	.up ul li, .detail-title{
		text-transform: capitalize;
	}
	.collapsible {
	  background-color: #eee;
	  color: #444;
	  cursor: pointer;
	  padding: 18px;
	  width: 100%;
	  border: none;
	  text-align: left;
	  outline: none;
	  font-size: 15px;
	}

	/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
	.active, .collapsible:hover {
	  background-color: #ccc;
	}

	.content {
	  padding: 0 18px;
	  display: none;
	  overflow: hidden;
	  background-color: #f1f1f1;
	}
	.float-right{float:right;}
	.td1{width: 70%;}
	.td2{width: 30%;}
</style>
<!-- Title Header Start -->
<section class="inner-header-title" style="background-image:url({{ url('public/assets/img/online_mariners_bredcrump.jpg') }}">
	<div class="container">
		<h1>Candidate Details</h1>
	</div>
</section>
<div class="clearfix"></div>
<!-- Title Header End -->
			
<!-- Candidate Detail Start -->
<section class="detail-desc">
	<div class="container">
	
		<div class="ur-detail-wrap top-lay">			
			<div class="ur-detail-box">				
				<div class="ur-thumb">
					<?php
					// var_dump(($candidate[0]->profile_path == '') || ($candidate[0]->profile_path == null));
						if(($candidate[0]->profile_path == '') || ($candidate[0]->profile_path == null)){?>
							<img src="{{ url('/public/assets/img/emp-default.png') }}" class="img-responsive" alt="company_logo" width="150" height="150" />
					<?php 
						}else{
							$filename = $candidate[0]->profile_path;
							$url = url('/public/profile/'.$filename); 												
                	?>
                		<img src="{{ $url }}" class="img-responsive" alt="company_logo" width="150" height="150" />		
					<?php } ?>
					
				</div>
				<div class="ur-caption">
					<h4 class="ur-title" style="text-transform: capitalize; padding-bottom: 2%">{{ $candidate[0]->name }}</h4>
					<p class="ur-location"><i class="ti-location-pin mrg-r-5"></i>{{ isset($candidate[0]->nationality) ? $candidate[0]->nationality : 'Not Updated Yet' }}</p>
					<p class="ur-location"><i class="ti-mobile mrg-r-5"></i>{{ isset($candidate[0]->phone_number) ? $candidate[0]->phone_number : 'Not Updated Yet' }}</p>
					<span class="ur-designation"><i class="ti-email mrg-r-5"></i>{{ isset($candidate[0]->email) ? $candidate[0]->email : ''  }}</span>
					
				</div>				
			</div>

			<div class="ur-detail-btn">
				<!-- Chat button -->
				<p>
					<!-- class="activeStatus"  class="inactiveStatus"-->
					<?php 
						if($employer){
							$chatUserData = DB::select("SELECT *  FROM users where email="."'".$employer."'");
							// echo "<pre>";
							// print_r($chatUserData);
							// exit;
							$id = $chatUserData[0]->id;	
						}else{
							$id = '';
						}
						$candidateID = $candidate[0]->candidate_chat_id;

						$chatPath = "http://chatingapp.onlinemariners.com/login?id=".$id."&&candidateid=".$candidate[0]->candidate_chat_id; 
						//$chatPath = "http://chatingapp.onlinemariners.com/conversations?id=".$candidate[0]->candidate_chat_id; 
					?>
					@if($candidate[0]->login_status == '1')					
					<!-- <a href="{{ $chatPath }}" style="margin-top: 1rem;" class="chatroom"> -->
					<a href="{{ route('chatrecAdd', ['id' => $id, 'candidateID' => $candidateID]) }}" style="margin-top: 1rem;" class="chatroom btn btn-success full-width">							
						<span class="activeStatus"></span>
						<b style="margin-left: 2.2rem;">Chat Room</b>
					</a>
					@else					
					<!-- <a href="{{ $chatPath }}" style="margin-top: 1rem;"> -->
					<a href="{{ route('chatrecAdd', ['id' => $id, 'candidateID' => $candidateID]) }}" style="margin-top: 1rem;" class="chatroom btn btn-success full-width">
						<span class="inactiveStatus"></span>
						<b style="margin-top: 10px;margin-left: 2.0rem;">Chat Room</b>
					</a>
					@endif
				</p>
				<!-- back button  -->
				@if($requestFromPage == 'candidatejobapplylist')				
				<a href="{{ route('lists.appliedjob') }}" class="btn btn-warning mrg-bot-10 full-width"><i class="ti-angle-left	 mrg-r-5"></i>Back</a>
				@elseif($requestFromPage == 'homepage')
				<a href="{{ route('homepage') }}" class="btn btn-warning mrg-bot-10 full-width"><i class="ti-angle-left	 mrg-r-5"></i>Back</a>
				@elseif($requestFromPage == 'candidategridlist')
				<a href="{{ route('cand.gridlist') }}" class="btn btn-warning mrg-bot-10 full-width"><i class="ti-angle-left	 mrg-r-5"></i>Back</a>				
				@endif
				<!-- Download Resume  -->
				<a href="{{ route('download.resume', $candidate[0]->id) }}" class="btn btn-info full-width"><i class="ti-download mrg-r-5"></i>Download Resume</a>
				
			</div>			
		</div>
	</div>
</section>

<?php
// echo "<pre>";
// print_r($skill_traing);
// print_r($wages);
// print_r($emp);
// exit;

?>
<!-- Job full detail Start -->
<section class="full-detail-description full-detail">
	<div class="container">
		<div class="col-md-12 col-sm-12">
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
		<!-- Job Description -->
		<div class="col-md-12 col-sm-12">
			<div class="full-card">				
				<div class="row row-bottom mrg-0">
					<h2 class="detail-title collapsible" aria-expanded='true' data-toggle="collapse" data-target="#Details_tab">Details</h2>
					<div id="Details_tab" class="collapse in">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
							<tr>
								<th class="td1">Date of Birth(MM-DD-YY)</th>
								<td class="td2"><?php 
									if($candidate[0]->dob){
										echo date('m-d-Y', strtotime($candidate[0]->dob));	
									}else{
										echo 'Not Updated Yet';
									}
									
								?></td>
							</tr>

							<tr>
								<th>Applied For</th>
								<td>{{ isset($candidate[0]->applied_for) ? $candidate[0]->applied_for : 'Not Updated Yet'  }}</td>
							</tr>

							<tr>
								<th>Experience</th>
								<td><?php
								if(isset($candidate[0]->experience_years) && isset($candidate[0]->experience_months)){
									echo $exp = $candidate[0]->experience_years.' Years'.$candidate[0]->experience_months.' Months';
								}else if(isset($candidate[0]->experience_years) && !isset($candidate[0]->experience_months)){
									echo $exp = $candidate[0]->experience_years.' Years';
								}else if(!isset($candidate[0]->experience_years) && isset($candidate[0]->experience_months)){
									echo  $exp = $candidate[0]->experience_months.' Months';
								}else{
									echo $exp = 'Not Updated Yet';
								}							
								?></td>
							</tr>

							<tr>
								<th>Available From(MM-DD-YY)</th>
								<td><?php 
									if($candidate[0]->availablefrom){
										echo date('m-d-Y', strtotime($candidate[0]->availablefrom));	
									}else{
										echo 'Not Updated Yet';
									}								
								?></td>
							</tr>

							<tr>
								<th>Have USA Visa C1D?</th>
								<td>{{ isset($candidate[0]->usavisa_c1d) ? $candidate[0]->usavisa_c1d : 'Not Updated Yet' }}</td>
							</tr>

							<tr>
								<th>Competency Certificate</th>
								<td>{{ isset($candidate[0]->competency_certificate) ? $candidate[0]->competency_certificate : 'Not updated Yet'  }}</td>
							</tr>

							<tr>
								<th>Last vessel served</th>
								<td>{{ isset($candidate[0]->last_vassel_served) ? $candidate[0]->last_vassel_served : 'Not updated Yet' }}</td>
							</tr>

							<tr>
								<th>Vessel Size(in DWT)</th>
								<td>{{ isset($candidate[0]->vassel_dwt) ? $candidate[0]->vassel_dwt : 'Not updated Yet'  }}</td>
							</tr>

							<tr>
								<th>Vessel Size(in GRT)</th>
								<td>{{ isset($candidate[0]->vassel_grt) ? $candidate[0]->vassel_grt : 'Not updated Yet' }}</td>
							</tr>
						</table>	
					</div>				
				</div>
				<!-- Endorse Documents -->
				@if($endorse && (count($endorse) > 0))	
					
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#endorsement_tab"><span>Endorsement Documents</span><span class="float-right">View More</span></h2>
					<div id="endorsement_tab" class="collapse">
						<table style="width:100%;border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
							<tr>
								<th class="td1">Document Name</th>
								<th class="td2">Document Validity</th>
							</tr>
							@if(!empty($endorse[0]->endors_dec_chemical_dt_status))
							<?php $is_endorsement = 1;?>	
							<tr>
								<td>{{ $endorse[0]->endors_name_dec_chemical }}</td>
								<td><?php echo isset($endorse[0]->endors_dec_chemical_dt_status) ?  $endorse[0]->endors_dec_chemical_dt_status : 'Not Update Yet'?></td>
							</tr>
							@endif

							@if(!empty($endorse[0]->endors_dec_gas_dt_status))
							<?php $is_endorsement = 1;?>
							<tr>
								<td>{{ $endorse[0]->endors_name_dec_gas }}</td>
								<td><?php echo isset($endorse[0]->endors_dec_gas_dt_status) ? $endorse[0]->endors_dec_gas_dt_status : 'Not Update Yet' ?></td>
							</tr>
							@endif

							@if(!empty($endorse[0]->endors_dec_others_dt_status))
							<?php $is_endorsement = 1;?>
							<tr>
								<td>{{ $endorse[0]->endors_name_dec_others }}</td>
								<td><?php echo isset($endorse[0]->endors_dec_others_dt_status) ? $endorse[0]->endors_dec_others_dt_status : 'Not Update Yet'  ?></td>
							</tr>
							@endif

							@if(!empty($endorse[0]->endors_dec_petroleum_dt_status))
							<?php $is_endorsement = 1;?>	
							<tr>
								<td>{{ $endorse[0]->endors_name_dec_petroleum }}</td>
								<td><?php echo isset($endorse[0]->endors_dec_petroleum_dt_status) ? $endorse[0]->endors_dec_petroleum_dt_status : 'Not Update Yet'  ?></td>
							</tr>
							@endif

							@if(isset($endorse[0]->endors_others_dt_status))	
							<?php $is_endorsement = 1;?>
							<tr>
								<td>{{ $endorse[0]->endors_name_others	 }}</td>
								<td><?php echo isset($endorse[0]->endors_others_dt_status) ? $endorse[0]->endors_others_dt_status : 'Not Update Yet'  ?></td>
							</tr>
							@endif

							@if($is_endorsement==0)
							<tr>
								<td style="text-align: center;" colspan="2">Not Available</td>
							</tr>
							@endif
						</table>
					</div>					
				</div>
				@endif
				<!-- Travel Documents -->
				<?php
					// echo "<pre>";
					// print_r($travel);
					// exit;
				?>
				@if($travel && (count($travel) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#travel_tab"><span>Travel Documents</span><span class="float-right">View More</span></h2>
					<div id="travel_tab" class="collapse">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
						<tr>
							<th class="td1">Document Name</th>
							<th class="td2">Document Validity</th>
						</tr>

						@if(!empty($travel[0]->passport_status))	
						<?php $is_travel = 1;?>
						<tr>
							<td>{{ $travel[0]->passport }}</td>
							<td><?php echo isset($travel[0]->passport_status) ?  $travel[0]->passport_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($travel[0]->Seamans_book_cdc_status))	
						<?php $is_travel = 1;?>
						<tr>
							<td>{{ $travel[0]->Seamans_book_cdc }}</td>
							<td><?php echo isset($travel[0]->Seamans_book_cdc_status) ? $travel[0]->Seamans_book_cdc_status : '-' ?></td>
						</tr>
						@endif

						@if(!empty($travel[0]->uk_work_permit_staus))	
						<?php $is_travel = 1;?>
						<tr>
							<td>{{ $travel[0]->uk_work_permit }}</td>
							<td><?php echo isset($travel[0]->uk_work_permit_staus) ? $travel[0]->uk_work_permit_staus : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($travel[0]->us_visa_status))	
						<?php $is_travel = 1;?>
						<tr>
							<td>{{ $travel[0]->us_visa }}</td>
							<td><?php echo isset($travel[0]->us_visa_status) ? $travel[0]->us_visa_status : '-'  ?></td>
						</tr>
						@endif

						@if($is_travel==0)
						<tr>
							<td style="text-align: center;" colspan="2">Not Available</td>
						</tr>
						@endif

						</table>
					</div>
				</div>
				@endif

				@if($medical && (count($medical) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#medical_tab"><span>Medical Documents</span><span class="float-right">View More</span></h2>
					<div id="medical_tab" class="collapse">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
						<tr>
							<th class="td1">Document Name</th>
							<th class="td2">Document Validity</th>
						</tr>

						@if(!empty($medical[0]->drug_alcohol_blood_test_status))	
						<?php $is_medical = 1;?>
						<tr>
							<td>{{ $medical[0]->drug_alcohol_blood_test }}</td>
							<td><?php echo isset($medical[0]->drug_alcohol_blood_test_status) ?  $medical[0]->drug_alcohol_blood_test_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($medical[0]->seafarers_medical_examination_status))	
						<?php $is_medical = 1;?>
						<tr>
							<td>{{ $medical[0]->seafarers_medical_examination }}</td>
							<td><?php echo isset($medical[0]->seafarers_medical_examination_status) ? $medical[0]->seafarers_medical_examination_status : '-' ?></td>
						</tr>
						@endif


						@if(!empty($medical[0]->ukooa_medical_fitness_status))	
						<?php $is_medical = 1;?>
						<tr>
							<td>{{ $medical[0]->ukooa_medical_fitness }}</td>
							<td><?php echo isset($medical[0]->ukooa_medical_fitness_status) ? $medical[0]->ukooa_medical_fitness_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($medical[0]->yellow_fever_vaccination_status))	
						<?php $is_medical = 1;?>
						<tr>
							<td>{{ $medical[0]->yellow_fever_vaccination	 }}</td>
							<td><?php echo isset($medical[0]->yellow_fever_vaccination_status) ? $medical[0]->yellow_fever_vaccination_status : '-'  ?></td>
						</tr>
						@endif

						@if($is_medical==0)
						<tr>
							<td style="text-align: center;" colspan="2">Not Available</td>
						</tr>
						@endif
						</table>
					</div>
				</div>
				@endif

				<!-- skill_traing Documents -->
				<?php
					// echo "<pre>";
					// print_r($skill_traing);
					// exit;
				?>
				<?php /*
				@if($skill_traing && (count($skill_traing) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#Skill_tab"><span>Skills and Training Certificates</span><span class="float-right">View More</span></h2>
					<div id="Skill_tab" class="collapse">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
						<tr>
							<th class="td1">Document Name</th>
							<th class="td2">Document Validity</th>
						</tr>
						@if(!empty($skill_traing[0]->arpa_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->arpa }}</td>
							<td><?php echo isset($skill_traing[0]->arpa_status) ?  $skill_traing[0]->arpa_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->behaviour_safety_process_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->behaviour_safety_process }}</td>
							<td><?php echo isset($skill_traing[0]->behaviour_safety_process_status) ? $skill_traing[0]->behaviour_safety_process_status : '-' ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->boatmaster_license_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->boatmaster_license }}</td>
							<td><?php echo isset($skill_traing[0]->boatmaster_license_status) ? $skill_traing[0]->boatmaster_license_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->bridge_team_management_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->bridge_team_management }}</td>
							<td><?php echo isset($skill_traing[0]->bridge_team_management_status) ? $skill_traing[0]->bridge_team_management_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->chemical_tankertraining_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->chemical_tankertraining }}</td>
							<td><?php echo isset($skill_traing[0]->chemical_tankertraining_status) ? $skill_traing[0]->chemical_tankertraining_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->cows_crudeoil_washing_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->cows_crudeoil_washing }}</td>
							<td><?php echo isset($skill_traing[0]->cows_crudeoil_washing_status) ?  $skill_traing[0]->cows_crudeoil_washing_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->crane_operator_certificate_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->crane_operator_certificate }}</td>
							<td><?php echo isset($skill_traing[0]->crane_operator_certificate_status) ?  $skill_traing[0]->crane_operator_certificate_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->dp_induction_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->dp_induction }}</td>
							<td><?php echo isset($skill_traing[0]->dp_induction_status) ?  $skill_traing[0]->dp_induction_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->dp_limited_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->dp_limited }}</td>
							<td><?php echo isset($skill_traing[0]->dp_limited_status) ?  $skill_traing[0]->dp_limited_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($skill_traing[0]->dp_simulator_status))
						<?php $is_skill_traing = 1;?>
						<tr>
							<td>{{ $skill_traing[0]->dp_simulator }}</td>
							<td><?php echo isset($skill_traing[0]->dp_simulator_status) ?  $skill_traing[0]->dp_simulator_status : '-'  ?></td>
						</tr>
						@endif

						@if($is_skill_traing==0)
						<tr>
							<td style="text-align: center;" colspan="2">Not Available</td>
						</tr>
						@endif
						</table>
					</div>
				</div>
				@endif

				*/?>

				<!-- personal Docs Documents -->
				@if($personal && (count($personal) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#Personal_tab"><span>Personal Documents</span><span class="float-right">View More</span></h2>
					<div id="Personal_tab" class="collapse">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
						<tr>
							<th class="td1">Document Name</th>
							<th class="td2">Document Validity</th>
						</tr>


						@if(!empty($personal[0]->driver_license_status))
						<?php $is_personal = 1;?>
						<tr>
							<td>{{ $personal[0]->driver_license }}</td>
							<td><?php echo isset($personal[0]->driver_license_status) ?  $personal[0]->driver_license_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($personal[0]->photograph_status))
						<?php $is_personal = 1;?>
						<tr>
							<td>{{ $personal[0]->photograph }}</td>
							<td><?php echo isset($personal[0]->photograph_status) ? $personal[0]->photograph_status : '-' ?></td>
						</tr>
						@endif


						@if(!empty($personal[0]->resume_status))
						<?php $is_personal = 1;?>
						<tr>
							<td>{{ $personal[0]->resume }}</td>
							<td><?php echo isset($personal[0]->resume_status) ? $personal[0]->resume_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($personal[0]->personal_other_docs_status))
						<?php $is_personal = 1;?>
						<tr>
							<td>Personal Other</td>
							<td><?php echo isset($personal[0]->personal_other_docs_status) ? $personal[0]->personal_other_docs_status : '-'  ?></td>
						</tr>
						@endif

						@if($is_personal==0)
						<tr>
							<td style="text-align: center;" colspan="2">Not Available</td>
						</tr>
						@endif
						</table>
					</div>
				</div>
				@endif

				<!-- COC Doc  -->
				@if($coc && (count($coc) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#COC_tab"><span>COC Documents</span><span class="float-right">View More</span></h2>
					<div id="COC_tab" class="collapse">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
						<tr>
							<th class="td1">Document Name</th>
							<th class="td2">Document Validity</th>
						</tr>
						@if(!empty($coc[0]->master_unlimited_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->master_unlimited }}</td>
							<td><?php echo isset($coc[0]->master_unlimited_status) ? $coc[0]->master_unlimited_status : '-' ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->chief_mate_unlimited_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->chief_mate_unlimited }}</td>
							<td><?php echo isset($coc[0]->chief_mate_unlimited_status) ? $coc[0]->chief_mate_unlimited_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->officers_incharge_navigational_unlimited_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->officers_incharge_navigational_unlimited }}</td>
							<td><?php echo isset($coc[0]->officers_incharge_navigational_unlimited_status) ?  $coc[0]->officers_incharge_navigational_unlimited_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->rating_forming_part_navigational_watch_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->rating_forming_part_navigational_watch }}</td>
							<td><?php echo isset($coc[0]->rating_forming_part_navigational_watch_status) ?  $coc[0]->rating_forming_part_navigational_watch_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->able_seafarer_deck_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->able_seafarer_deck }}</td>
							<td><?php echo isset($coc[0]->able_seafarer_deck_status) ?  $coc[0]->able_seafarer_deck_status : '-'  ?></td>
						</tr>
						@endif
						

						@if(!empty($coc[0]->masters_ships_lessthan_500gt_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->masters_ships_lessthan_500gt }}</td>
							<td><?php echo isset($coc[0]->masters_ships_lessthan_500gt_status) ? $coc[0]->masters_ships_lessthan_500gt_status : '-'  ?></td>
						</tr>
						@endif
						
						@if(!empty($coc[0]->officers_charge_navigational_less_500_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->officers_charge_navigational_less_500 }}</td>
							<td><?php echo isset($coc[0]->officers_charge_navigational_less_500_status) ?  $coc[0]->officers_charge_navigational_less_500_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->chief_engineer_officer_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->chief_engineer_officer }}</td>
							<td><?php echo isset($coc[0]->chief_engineer_officer_status) ?  $coc[0]->chief_engineer_officer_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->second_engineer_officer_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->second_engineer_officer }}</td>
							<td><?php echo isset($coc[0]->second_engineer_officer_status) ?  $coc[0]->second_engineer_officer_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->officer_charge_engineering_watch_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->officer_charge_engineering_watch }}</td>
							<td><?php echo isset($coc[0]->officer_charge_engineering_watch_status) ?  $coc[0]->officer_charge_engineering_watch_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->rating_formingpart_engineering_watch_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->rating_formingpart_engineering_watch }}</td>
							<td><?php echo isset($coc[0]->rating_formingpart_engineering_watch_status) ?  $coc[0]->rating_formingpart_engineering_watch_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->able_seafarer_engine_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->able_seafarer_engine }}</td>
							<td><?php echo isset($coc[0]->able_seafarer_engine_status) ?  $coc[0]->able_seafarer_engine_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->cef_second_eo_ships_750_3000_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->cef_second_eo_ships_750_3000 }}</td>
							<td><?php echo isset($coc[0]->cef_second_eo_ships_750_3000_status) ?  $coc[0]->cef_second_eo_ships_750_3000_status : '-'  ?></td>
						</tr>
						@endif
						
						@if(!empty($coc[0]->electro_technical_officer_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->electro_technical_officer }}</td>
							<td><?php echo isset($coc[0]->electro_technical_officer_status) ?  $coc[0]->electro_technical_officer_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->cook_coc_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->cook_coc }}</td>
							<td><?php echo isset($coc[0]->cook_coc_status) ?  $coc[0]->cook_coc_status : '-'  ?></td>
						</tr>
						@endif

						@if(!empty($coc[0]->gmdss_radio_operator_status))
						<?php $is_coc = 1;?>
						<tr>
							<td>{{ $coc[0]->gmdss_radio_operator }}</td>
							<td><?php echo isset($coc[0]->gmdss_radio_operator_status) ?  $coc[0]->gmdss_radio_operator_status : '-'  ?></td>
						</tr>
						@endif
						

						@if($is_coc==0)
						<tr>
							<td style="text-align: center;" colspan="2">Not Available</td>
						</tr>
						@endif

						</table>
					</div>
				</div>
				@endif

				<!-- stcw Docs Documents -->

				@if($stcw && (count($stcw) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#STCW_tab"><span>STCW Documents</span><span class="float-right">View More</span></h2>
					<div id="STCW_tab" class="collapse">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
							<tr>
								<th class="td1">Document Name</th>
								<th class="td2">Document Validity</th>
							</tr>


							@if(!empty($stcw[0]->basic_training_chemical_tc_operations_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->basic_training_chemical_tc_operations }}</td>
								<td><?php echo isset($stcw[0]->basic_training_chemical_tc_operations_status) ?  $stcw[0]->basic_training_chemical_tc_operations_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->advanced_tc_operations_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->advanced_tc_operations }}</td>
								<td><?php echo isset($stcw[0]->advanced_tc_operations_status) ?  $stcw[0]->advanced_tc_operations_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->advanced_chemical_tc_operations_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->advanced_chemical_tc_operations }}</td>
								<td><?php echo isset($stcw[0]->advanced_chemical_tc_operations_status) ?  $stcw[0]->advanced_chemical_tc_operations_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->bt_liquified_gas_tc_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->bt_liquified_gas_tc }}</td>
								<td><?php echo isset($stcw[0]->bt_liquified_gas_tc_status) ?  $stcw[0]->bt_liquified_gas_tc_status : '-'  ?></td>
							</tr>
							@endif
							
							@if(!empty($stcw[0]->at_for_liquified_gas_tc_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->at_for_liquified_gas_tc }}</td>
								<td><?php echo isset($stcw[0]->at_for_liquified_gas_tc_status) ?  $stcw[0]->at_for_liquified_gas_tc_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->pst_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->pst }}</td>
								<td><?php echo isset($stcw[0]->pst_status) ?  $stcw[0]->pst_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->fpff_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->fpff }}</td>
								<td><?php echo isset($stcw[0]->fpff_status) ?  $stcw[0]->fpff_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->efa_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->efa }}</td>
								<td><?php echo isset($stcw[0]->efa_status) ?  $stcw[0]->efa_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->pssr_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->pssr }}</td>
								<td><?php echo isset($stcw[0]->pssr_status) ?  $stcw[0]->pssr_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->pscrb_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->pscrb }}</td>
								<td><?php echo isset($stcw[0]->pscrb_status) ?  $stcw[0]->pscrb_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->aff_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->aff }}</td>
								<td><?php echo isset($stcw[0]->aff_status) ?  $stcw[0]->aff_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->mfa_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->mfa }}</td>
								<td><?php echo isset($stcw[0]->mfa_status) ?  $stcw[0]->mfa_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->proficiency_in_medical_care_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->proficiency_in_medical_care }}</td>
								<td><?php echo isset($stcw[0]->proficiency_in_medical_care_status) ?  $stcw[0]->proficiency_in_medical_care_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->ship_security_officer_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->ship_security_officer }}</td>
								<td><?php echo isset($stcw[0]->ship_security_officer_status) ?  $stcw[0]->ship_security_officer_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($stcw[0]->designated_security_duties_status))
							<?php $is_stcw = 1;?>
							<tr>
								<td>{{ $stcw[0]->designated_security_duties }}</td>
								<td><?php echo isset($stcw[0]->designated_security_duties_status) ?  $stcw[0]->designated_security_duties_status : '-'  ?></td>
							</tr>
							@endif
							

							@if($is_stcw==0)
							<tr>
								<td style="text-align: center;" colspan="2">Not Available</td>
							</tr>
							@endif
						</table>
					</div>
				</div>
				@endif

				<!-- offshore Docs Documents -->
				<?php /*
				@if($offshore && (count($offshore) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#offshore_tab"><span>Offshore Documents</span><span class="float-right">View More</span></h2>
					<div class="collapse" id="offshore_tab">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
							<tr>
								<th class="td1">Document Name</th>
								<th class="td2">Document Validity</th>
							</tr>


							@if(!empty($offshore[0]->agt0_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->agt0 }}</td>
								<td><?php echo isset($offshore[0]->agt0_status) ?  $offshore[0]->agt0_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($offshore[0]->agtl1_cbt_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->agtl1_cbt }}</td>
								<td><?php echo isset($offshore[0]->agtl1_cbt_status) ?  $offshore[0]->agtl1_cbt_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($offshore[0]->agt2_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->agt2 }}</td>
								<td><?php echo isset($offshore[0]->agt2_status) ?  $offshore[0]->agt2_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($offshore[0]->agt2_cbt_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->agt2_cbt }}</td>
								<td><?php echo isset($offshore[0]->agt2_cbt_status) ?  $offshore[0]->agt2_cbt_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($offshore[0]->agt3_cbt_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->agt3_cbt }}</td>
								<td><?php echo isset($offshore[0]->agt3_cbt_status) ?  $offshore[0]->agt3_cbt_status : '-'  ?></td>
							</tr>
							@endif
							
							@if(!empty($offshore[0]->ama_errv_crew_advanced_medical_aid_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->ama_errv_crew_advanced_medical_aid }}</td>
								<td><?php echo isset($offshore[0]->ama_errv_crew_advanced_medical_aid_status) ?  $offshore[0]->ama_errv_crew_advanced_medical_aid_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($offshore[0]->boat_travel_safely_by_boat_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->boat_travel_safely_by_boat }}</td>
								<td><?php echo isset($offshore[0]->boat_travel_safely_by_boat_status) ?  $offshore[0]->boat_travel_safely_by_boat_status : '-'  ?></td>
							</tr>
							@endif

							@if(!empty($offshore[0]->boer_basic_onshore_emergency_response_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->boer_basic_onshore_emergency_response }}</td>
								<td><?php echo isset($offshore[0]->boer_basic_onshore_emergency_response_status) ?  $offshore[0]->boer_basic_onshore_emergency_response_status : '-'  ?></td>
							</tr>
							@endif
					
							@if(!empty($offshore[0]->bosiet_with_ca_ebs_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->bosiet_with_ca_ebs }}</td>
								<td><?php echo isset($offshore[0]->bosiet_with_ca_ebs_status) ?  $offshore[0]->bosiet_with_ca_ebs_status : '-'  ?></td>
							</tr>
							@endif
					
							@if(!empty($offshore[0]->bosiet_status))
							<?php $is_offshore = 1;?>
							<tr>
								<td>{{ $offshore[0]->bosiet }}</td>
								<td><?php echo isset($offshore[0]->bosiet_status) ?  $offshore[0]->bosiet_status : '-'  ?></td>
							</tr>
							@endif
							
							@if($is_offshore==0)
							<tr>
								<td style="text-align: center;" colspan="2">Not Available</td>
							</tr>
							@endif
					
						</table>
					</div>
				</div>
				@endif
				*/?>
			
				@if(!empty($others) && (count($others) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title collapsible" data-toggle="collapse" data-target="#others_tab"><span>Other Documents</span><span class="float-right">View More</span></h2>
					<div id="others_tab" class="collapse">
						<table style="border-color: beige;color: #667488;" class="table" border="1" cellpadding="5" cellspacing="5">
							<tr>
								<th class="td1">Document Name</th>
								<th class="td2">Document Validity</th>
							</tr>


							@if(!empty($others))
							<?php $is_other = 1;?>

								@foreach($others as $other)
								<tr>
									<td>{{ $other->doc_name }}</td>
									<td><?php echo isset($other->doc_name_status) ?  $other->doc_name_status : '-'  ?></td>
								</tr>
								@endforeach
							@endif

							@if($is_other==0)
							<tr>
								<td style="text-align: center;" colspan="2">Not Available</td>
							</tr>
							@endif
						</table>
					</div>
				</div>
				@endif
			</div>
		</div>
		<!-- End Job Description -->
		
		<!-- Start Sidebar -->
		<div class="col-md-4 col-sm-12">
			
				
			</div> 
		</div>
		<!-- End Sidebar -->
	</div>
</section>
<!-- Job full detail End -->


@endsection
@section('datepicker')
<script>
	$(document).ready(function () {
	    $('#postjob_listing').DataTable();
    });


    $(".rank").change(function() {
        var multipleValues = $(".rank").val() || "";
        var result = "<label>Wages for Rank Position*: </label>";
        if (multipleValues != "") {
            var aVal = multipleValues.toString().split(",");
            $.each(aVal, function(i, value) {

                // result += "<div>";
                // result += "<input type='text' name='opval" + (parseInt(i) + 1) + "' value='" + "'"+value.trim()+"'" + "'>";
                // value = value.replace(' ','-');
                // value = value.replace('/','-');
                // result += "<input type='text' name='optext" + (parseInt(i) + 1) + "' value='" + $("#rank").find("option[value=" + value + "]").text().trim() + "'>";
                // result +="<div class='col-lg-6 col-md-6 col-sm-12'>" //(parseInt(i) + 1)
                result += "<input type='number' class='form-control' name='"+'wage[]' + "' placeholder='"+ 'Wages for '+value + "'value='' Required>";
                result += "</div>";
            });
        }
        //Set Result
        $("#wages").html(result);

    });
   /*
	$(".chatroom").click(function(){
	  	$.ajaxSetup({
	    	headers: {
	    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    	}
    	});
    	//alert($('meta[name="csrf-token"]').attr('content'));

		var empid = '<?php //echo $empid; ?>';
		var candidateID = '<?php //echo $candidateID; ?>';
		alert(empid+' '+candidateID)
        $.ajax({
            type: "get",
            dataType: "json",
            url: "{{ route('chatrecAdd') }}",
            data: {'empid': empid, 'candidateID' : candidateID}, //, 'candidateid' : candidateid},
            success: function(data){
            	alert('success')
            	/*
            	var result = JSON.parse(JSON.stringify(data));
            	
            	var email = $('#email').val(result.email);
            	var pwd = $('#password').val(result.decrpted_password);
            	// alert(email+ ' '+pwd);
            	// return false;
            	if(email !== null && email !== '' && pwd !== null && pwd !== '') {
						$( "#loginForm" ).submit();                	
				}
            	return false;   				
            	*/
            },
        	error: function(err) {
            	console.log(err);
            }
        });
	});
	*/
    	
    
</script>

@endsection