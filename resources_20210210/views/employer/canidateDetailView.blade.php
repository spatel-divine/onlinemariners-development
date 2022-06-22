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
					<h2 class="detail-title">Details</h2>
					<ul class="job-detail-des">
						<li>
							<span>Date of Birth(m-d-y) :
							</span>
							<?php 
								if($candidate[0]->dob){
									echo date('m-d-Y', strtotime($candidate[0]->dob));	
								}else{
									echo 'Not Updated Yet';
								}
								
							?>
						</li>
						<li><span>Applied For:</span> {{ isset($candidate[0]->applied_for) ? $candidate[0]->applied_for : 'Not Updated Yet'  }}</li>
						<li>
							<span>Experience:</span> 
							<?php
							if(isset($candidate[0]->experience_years) && isset($candidate[0]->experience_months)){
								echo $exp = $candidate[0]->experience_years.' Years'.$candidate[0]->experience_months.' Months';
							}else if(isset($candidate[0]->experience_years) && !isset($candidate[0]->experience_months)){
								echo $exp = $candidate[0]->experience_years.' Years';
							}else if(!isset($candidate[0]->experience_years) && isset($candidate[0]->experience_months)){
								echo  $exp = $candidate[0]->experience_months.' Months';
							}else{
								echo $exp = 'Not Updated Yet';
							}							
							?>							
						</li>
						<li>
							<span>Available From(m-d-y) :</span> 
							<?php 
								if($candidate[0]->availablefrom){
									echo date('m-d-Y', strtotime($candidate[0]->availablefrom));	
								}else{
									echo 'Not Updated Yet';
								}								
							?>
						</li>
						
						<li style="text-transform: capitalize;"><span>Have USA Visa C1D?</span> {{ isset($candidate[0]->usavisa_c1d) ? $candidate[0]->usavisa_c1d : 'Not Updated Yet' }}</li>
						<li><span>Competency Certificate: </span> {{ isset($candidate[0]->competency_certificate) ? $candidate[0]->competency_certificate : 'Not updated Yet'  }}</li>
						<li><span>Currently Served As: </span> {{ isset($candidate[0]->last_vassel_served) ? $candidate[0]->last_vassel_served : 'Not updated Yet' }}</li>
						<li>
							<span>Vessel Size(in DWT): </span> {{ isset($candidate[0]->vassel_dwt) ? $candidate[0]->vassel_dwt : 'Not updated Yet'  }}
						</li>
						<li>
							<span>Vessel Size(in GRT): </span> {{ isset($candidate[0]->vassel_grt) ? $candidate[0]->vassel_grt : 'Not updated Yet' }}
						</li>
					</ul>
				</div>
				<!-- Endorse Documents -->
				@if($endorse && (count($endorse) > 0))				
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title">Endorsement Documents</h2>
					<ul class="job-detail-des">
						<li><b>Document Name: Document Expiry Date</b></li>
						
						@if(!empty($endorse[0]->endors_dec_chemical_dt_status))
						<li>{{ $endorse[0]->endors_name_dec_chemical }} :<?php echo isset($endorse[0]->endors_dec_chemical_dt) ?  $endorse[0]->endors_dec_chemical_dt_status : 'Not Update Yet'  ?></li>
						@endif
						@if(!empty($endorse[0]->endors_dec_gas_dt_status))
						<li>{{ $endorse[0]->endors_name_dec_gas }} :<?php echo isset($endorse[0]->endors_dec_gas_dt_status) ? $endorse[0]->endors_dec_gas_dt_status : 'Not Update Yet' ?> </li>
						@endif
						@if(!empty($endorse[0]->endors_dec_others_dt_status))
						<li>{{ $endorse[0]->endors_name_dec_others }} :<?php echo isset($endorse[0]->endors_dec_others_dt) ? $endorse[0]->endors_dec_others_dt_status : 'Not Update Yet'  ?></li>
						@endif
						@if(!empty($endorse[0]->endors_dec_petroleum_dt_status))						
						<li>{{ $endorse[0]->endors_name_dec_petroleum }} :<?php echo isset($endorse[0]->endors_dec_petroleum_dt_status) ? $endorse[0]->endors_dec_petroleum_dt_status : 'Not Update Yet'  ?></li>
						@endif
						@if(isset($endorse[0]->endors_others_dt_status))
						<li>{{ $endorse[0]->endors_name_others	 }} :<?php echo isset($endorse[0]->endors_others_dt_status) ? $endorse[0]->endors_others_dt_status : 'Not Update Yet'  ?></li>
						@endif
					</ul>
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
					<h2 class="detail-title">Travel Documents</h2>
					<ul class="job-detail-des">
						<li><b>Document Name: Document Expiry Date</b></li>
						@if(!empty($travel[0]->passport_status))
						<li>{{ $travel[0]->passport }}: <?php echo isset($travel[0]->passport_status) ?  $travel[0]->passport_status : '-'  ?></li>
						@endif
						@if(!empty($travel[0]->Seamans_book_cdc_status))
						<li>{{ $travel[0]->Seamans_book_cdc }}: <?php echo isset($travel[0]->Seamans_book_cdc_status) ? $travel[0]->Seamans_book_cdc_status : '-' ?> </li>
						@endif
						@if(!empty($travel[0]->uk_work_permit_staus))
						<li>{{ $travel[0]->uk_work_permit }}: <?php echo isset($travel[0]->uk_work_permit_staus) ? $travel[0]->uk_work_permit_staus : '-'  ?></li>
						@endif
						@if(!empty($travel[0]->us_visa_status))
						<li>{{ $travel[0]->us_visa }}: <?php echo isset($travel[0]->us_visa_status) ? $travel[0]->us_visa_status : '-'  ?></li>
						@endif						
					</ul>
				</div>
				@endif
				
				<!-- Medical Documents -->
				<?php
					// var_dump($medical[0]);
					// echo "<pre>";
					// print_r($medical[0]);
					// exit;
				?>
				@if($medical && (count($medical) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title">medical Documents</h2>
					<ul class="job-detail-des">
						<li><b>Document Name: Document Expiry Date</b></li>
						@if(!empty($medical[0]->drug_alcohol_blood_test_status))
						<li>{{ $medical[0]->drug_alcohol_blood_test }}: <?php echo isset($medical[0]->drug_alcohol_blood_test_status) ?  $medical[0]->drug_alcohol_blood_test_status : '-'  ?></li>
						@endif
						@if(!empty($medical[0]->seafarers_medical_examination_status))
						<li>{{ $medical[0]->seafarers_medical_examination }}: <?php echo isset($medical[0]->seafarers_medical_examination_status) ? $medical[0]->seafarers_medical_examination_status : '-' ?> </li>
						@endif
						@if(!empty($medical[0]->ukooa_medical_fitness_status))
						<li>{{ $medical[0]->ukooa_medical_fitness }}: <?php echo isset($medical[0]->ukooa_medical_fitness_status) ? $medical[0]->ukooa_medical_fitness_status : '-'  ?></li>
						@endif						
						@if(!empty($medical[0]->yellow_fever_vaccination_status))
						<li>{{ $medical[0]->yellow_fever_vaccination	 }}: <?php echo isset($medical[0]->yellow_fever_vaccination_status) ? $medical[0]->yellow_fever_vaccination_status : '-'  ?></li>
						@endif						
					</ul>
				</div>
				@endif

				<!-- skill_traing Documents -->
				<?php
					// echo "<pre>";
					// print_r($skill_traing);
					// exit;
				?>
				@if($skill_traing && (count($skill_traing) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title">Skill Training Documents</h2>
					<ul class="job-detail-des">
						<li><b>Document Name: Document Expiry Date</b></li>
						@if(!empty($endorse[0]->arpa_status))
						<li>{{ $skill_traing[0]->arpa }}: <?php echo isset($skill_traing[0]->arpa_status) ?  $skill_traing[0]->arpa_status : '-'  ?></li>
						@endif
						@if(!empty($skill_traing[0]->behaviour_safety_process_status))
						<li>{{ $skill_traing[0]->behaviour_safety_process }}: <?php echo isset($skill_traing[0]->behaviour_safety_process_status) ? $skill_traing[0]->behaviour_safety_process_status : '-' ?> </li>
						@endif
						@if(!empty($skill_traing[0]->boatmaster_license_status))
						<li>{{ $skill_traing[0]->boatmaster_license }}: <?php echo isset($skill_traing[0]->boatmaster_license_status) ? $skill_traing[0]->boatmaster_license_status : '-'  ?></li>
						@endif
						@if(!empty($skill_traing[0]->bridge_team_management_status))
						<li>{{ $skill_traing[0]->bridge_team_management }}: <?php echo isset($skill_traing[0]->bridge_team_management_status) ? $skill_traing[0]->bridge_team_management_status : '-'  ?></li>
						@endif
						@if(!empty($skill_traing[0]->chemical_tankertraining_status))
						<li>{{ $skill_traing[0]->chemical_tankertraining }}: <?php echo isset($skill_traing[0]->chemical_tankertraining_status) ? $skill_traing[0]->chemical_tankertraining_status : '-'  ?></li>
						@endif
						@if(!empty($endorse[0]->cows_crudeoil_washing_status))
						<li>{{ $skill_traing[0]->cows_crudeoil_washing }}: <?php echo isset($skill_traing[0]->cows_crudeoil_washing_status) ?  $skill_traing[0]->cows_crudeoil_washing_status : '-'  ?></li>
						@endif
						@if(!empty($endorse[0]->crane_operator_certificate_status))
						<li>{{ $skill_traing[0]->crane_operator_certificate }}: <?php echo isset($skill_traing[0]->crane_operator_certificate_status) ?  $skill_traing[0]->crane_operator_certificate_status : '-'  ?></li>
						@endif
						@if(!empty($endorse[0]->dp_induction_status))
						<li>{{ $skill_traing[0]->dp_induction }}: <?php echo isset($skill_traing[0]->dp_induction_status) ?  $skill_traing[0]->dp_induction_status : '-'  ?></li>
						@endif
						@if(!empty($endorse[0]->dp_limited_status))
						<li>{{ $skill_traing[0]->dp_limited }}: <?php echo isset($skill_traing[0]->dp_limited_status) ?  $skill_traing[0]->dp_limited_status : '-'  ?></li>
						@endif
						@if(!empty($endorse[0]->dp_simulator_status))
						<li>{{ $skill_traing[0]->dp_simulator }}: <?php echo isset($skill_traing[0]->dp_simulator_status) ?  $skill_traing[0]->dp_simulator_status : '-'  ?></li>
						@endif
						
					</ul>
				</div>
				@endif

				<!-- personal Docs Documents -->
				@if($personal && (count($skill_traing) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title">Personal Documents</h2>
					<ul class="job-detail-des">
						<li><b>Document Name: Document Expiry Date</b></li>
						@if(!empty($personal[0]->driver_license_status))
						<li>{{ $personal[0]->driver_license }}: <?php echo isset($personal[0]->driver_license_status) ?  $personal[0]->driver_license_status : '-'  ?></li>
						@endif
						@if(!empty($personal[0]->photograph_status))
						<li>{{ $personal[0]->photograph }}: <?php echo isset($personal[0]->photograph_status) ? $personal[0]->photograph_status : '-' ?> </li>
						@endif
						@if(!empty($personal[0]->resume_status))
						<li>{{ $personal[0]->resume }}: <?php echo isset($personal[0]->resume_status) ? $personal[0]->resume_status : '-'  ?></li>
						@endif
						@if(!empty($personal[0]->personal_other_docs_status))
						<li>Personal Other: <?php echo isset($personal[0]->personal_other_docs_status) ? $personal[0]->personal_other_docs_status : '-'  ?></li>
						@endif
					</ul>
				</div>
				@endif

				<!-- COC Doc  -->
				@if($coc && (count($coc) > 1))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title">COC Documents</h2>
					<ul class="job-detail-des">
						<li><b>Document Name: Document Expiry Date</b></li>
						@if(!empty($coc[0]->officers_incharge_navigational_unlimited_status))
						<li>{{ $coc[0]->officers_incharge_navigational_unlimited }}: <?php echo isset($coc[0]->officers_incharge_navigational_unlimited_status) ?  $coc[0]->officers_incharge_navigational_unlimited_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->master_unlimited_status))
						<li>{{ $coc[0]->master_unlimited }}: <?php echo isset($coc[0]->master_unlimited_status) ? $coc[0]->master_unlimited_status : '-' ?> </li>
						@endif
						@if(!empty($coc[0]->chief_mate_unlimited_status))
						<li>{{ $coc[0]->chief_mate_unlimited }}: <?php echo isset($coc[0]->chief_mate_unlimited_status) ? $coc[0]->chief_mate_unlimited_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->masters_ships_lessthan_500gt_status))
						<li>{{ $coc[0]->masters_ships_lessthan_500gt }}: <?php echo isset($coc[0]->masters_ships_lessthan_500gt_status) ? $coc[0]->masters_ships_lessthan_500gt_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->rating_forming_part_navigational_watch_status))
						<li>{{ $coc[0]->rating_forming_part_navigational_watch }}: <?php echo isset($coc[0]->rating_forming_part_navigational_watch_status) ?  $coc[0]->rating_forming_part_navigational_watch_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->able_seafarer_deck_status))
						<li>{{ $coc[0]->able_seafarer_deck }}: <?php echo isset($coc[0]->able_seafarer_deck_status) ?  $coc[0]->able_seafarer_deck_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->officer_charge_engineering_watch_status))
						<li>{{ $coc[0]->officer_charge_engineering_watch }}: <?php echo isset($coc[0]->officer_charge_engineering_watch_status) ?  $coc[0]->officer_charge_engineering_watch_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->chief_engineer_officer_status))
						<li>{{ $coc[0]->chief_engineer_officer }}: <?php echo isset($coc[0]->chief_engineer_officer_status) ?  $coc[0]->chief_engineer_officer_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->second_engineer_officer_status))
						<li>{{ $coc[0]->second_engineer_officer }}: <?php echo isset($coc[0]->second_engineer_officer_status) ?  $coc[0]->second_engineer_officer_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->cef_second_eo_ships_750_3000_status))
						<li>{{ $coc[0]->cef_second_eo_ships_750_3000 }}: <?php echo isset($coc[0]->cef_second_eo_ships_750_3000_status) ?  $coc[0]->cef_second_eo_ships_750_3000_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->rating_formingpart_engineering_watch_status))
						<li>{{ $coc[0]->cef_second_eo_ships_750_3000 }}: <?php echo isset($coc[0]->rating_formingpart_engineering_watch_status) ?  $coc[0]->rating_formingpart_engineering_watch_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->able_seafarer_engine_status))
						<li>{{ $coc[0]->able_seafarer_engine }}: <?php echo isset($coc[0]->able_seafarer_engine_status) ?  $coc[0]->able_seafarer_engine_status : '-'  ?></li>
						@endif
						@if(!empty($coc[0]->electro_technical_officer_status	))
						<li>{{ $coc[0]->electro_technical_officer }}: <?php echo isset($coc[0]->electro_technical_officer_status	) ?  $coc[0]->electro_technical_officer_status	 : '-'  ?></li>
						@endif
					</ul>
				</div>
				@endif

				<!-- stcw Docs Documents -->
				@if($stcw && (count($stcw) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title">STCW Documents</h2>
					<ul class="job-detail-des">
						<li><b>Document Name: Document Expiry Date</b></li>
						@if(!empty($stcw[0]->basic_training_chemical_tc_operations_status))
						<li>{{ $stcw[0]->basic_training_chemical_tc_operations }}: <?php echo isset($stcw[0]->basic_training_chemical_tc_operations_status) ?  $stcw[0]->basic_training_chemical_tc_operations_status : ''  ?></li>
						@endif
						@if(!empty($stcw[0]->advanced_tc_operations))
						<li>{{ $stcw[0]->advanced_tc_operations }}: <?php echo isset($stcw[0]->advanced_tc_operations_status) ? $stcw[0]->advanced_tc_operations_status : '' ?> </li>
						@endif
						@if(!empty($stcw[0]->advanced_chemical_tc_operations_status))
						<li>{{ $stcw[0]->advanced_chemical_tc_operations }}: <?php echo isset($stcw[0]->advanced_chemical_tc_operations_status) ? $stcw[0]->advanced_chemical_tc_operations_status : ''  ?></li>
						@endif
						@if(!empty($stcw[0]->bt_liquified_gas_tc_status))
						<li>{{ $stcw[0]->bt_liquified_gas_tc }}: <?php echo isset($stcw[0]->bt_liquified_gas_tc_status) ? $stcw[0]->bt_liquified_gas_tc_status : '-'  ?></li>
						@endif
						@if(!empty($stcw[0]->at_for_liquified_gas_tc_status))
						<li>{{ $stcw[0]->at_for_liquified_gas_tc }}: <?php echo isset($stcw[0]->at_for_liquified_gas_tc_status) ? $stcw[0]->at_for_liquified_gas_tc_status : ''  ?></li>
						@endif
						@if(!empty($stcw[0]->crowd_mgt_training_status))
						<li>{{ $stcw[0]->crowd_mgt_training }}: <?php echo isset($stcw[0]->crowd_mgt_training_status) ? $stcw[0]->crowd_mgt_training_status : ''  ?></li>
						@endif
						@if(!empty($stcw[0]->safety_training_for_personnel_providing_ds))
						<li>{{ $stcw[0]->safety_training_for_personnel_providing_ds }}: <?php echo isset($stcw[0]->safety_training_for_personnel_providing_ds_status) ? $stcw[0]->safety_training_for_personnel_providing_ds_status : ''  ?></li>
						@endif

						@if(!empty($stcw[0]->crisis_mgt_human_behaviour_training_status))
						<li>{{ $stcw[0]->crisis_mgt_human_behaviour_training }}: <?php echo isset($stcw[0]->crisis_mgt_human_behaviour_training_status) ? $stcw[0]->crisis_mgt_human_behaviour_training_status : '' ?> </li>
						@endif
						@if(!empty($stcw[0]->passenger_cargo_hull_integrity_training_status))
						<li>{{ $stcw[0]->passenger_cargo_hull_integrity_training }}: <?php echo isset($stcw[0]->passenger_cargo_hull_integrity_training_status) ? $stcw[0]->passenger_cargo_hull_integrity_training_status : '' ?> </li>
						@endif
						@if(!empty($stcw[0]->basic_safety_tc_status))
						<li>{{ $stcw[0]->passenger_cargo_hull_integrity_training }}: <?php echo isset($stcw[0]->basic_safety_tc_status) ? $stcw[0]->basic_safety_tc_status : '-' ?> </li>
						@endif
					</ul>
				</div>
				@endif

				<!-- offshore Docs Documents -->
				@if($offshore && (count($offshore) > 0))
				<div class="row row-bottom mrg-0 up">
					<h2 class="detail-title">offshore Documents</h2>
					<ul class="job-detail-des">
						<li><b>Document Name: Document Expiry Date</b></li>
						@if(!empty($offshore[0]->agt0_status))
						<li>{{ $offshore[0]->agt0 }}: <?php echo isset($offshore[0]->agt0_dt) ?  $offshore[0]->agt0_status : '-'  ?></li>
						@endif
						@if(!empty($offshore[0]->agtl1_cbt_status))
						<li>{{ $offshore[0]->agtl1_cbt }}: <?php echo isset($offshore[0]->agtl1_cbt_status) ? $offshore[0]->agtl1_cbt_status : '-' ?> </li>
						@endif
						@if(!empty($offshore[0]->agt2_status))
						<li>{{ $offshore[0]->agt2 }}: <?php echo isset($offshore[0]->agt2_status) ? $offshore[0]->agt2_status : '-'  ?></li>
						@endif
						@if(!empty($offshore[0]->agt2_cbt_status))
						<li>{{ $offshore[0]->agt2_cbt }}: <?php echo isset($offshore[0]->agt2_cbt_status) ? $offshore[0]->agt2_cbt_status : '-'  ?></li>
						@endif
						@if(!empty($offshore[0]->agt3_cbt_status))
						<li>{{ $offshore[0]->agt3_cbt }}: <?php echo isset($offshore[0]->agt3_cbt_status) ? $offshore[0]->agt3_cbt_status : '-'  ?></li>
						@endif
						@if(!empty($offshore[0]->ama_errv_crew_advanced_medical_aid_status))
						<li>{{ $offshore[0]->ama_errv_crew_advanced_medical_aid }}: <?php echo isset($offshore[0]->ama_errv_crew_advanced_medical_aid_status) ? $offshore[0]->ama_errv_crew_advanced_medical_aid_status : '-'  ?></li>
						@endif
						@if(!empty($offshore[0]->boat_travel_safely_by_boat_status))
						<li>{{ $offshore[0]->boat_travel_safely_by_boat }}: <?php echo isset($offshore[0]->boat_travel_safely_by_boat_status) ? $offshore[0]->boat_travel_safely_by_boat_status : '-'  ?></li>
						@endif
						@if(!empty($offshore[0]->boer_basic_onshore_emergency_response_status))
						<li>{{ $offshore[0]->boer_basic_onshore_emergency_response }}: <?php echo isset($offshore[0]->boer_basic_onshore_emergency_response_status) ? $offshore[0]->boer_basic_onshore_emergency_response_status : '-'  ?></li>
						@endif
						@if(!empty($offshore[0]->bosiet_with_ca_ebs_status))
						<li>{{ $offshore[0]->bosiet_with_ca_ebs }}: <?php echo isset($offshore[0]->bosiet_with_ca_ebs_status) ? $offshore[0]->bosiet_with_ca_ebs_status : '-'  ?></li>
						@endif
						@if(!empty($offshore[0]->bosiet_status))
						<li>{{ $offshore[0]->bosiet }}: <?php echo isset($offshore[0]->bosiet_status) ? $offshore[0]->bosiet_status : '-'  ?></li>
						@endif
					</ul>
				</div>
				@endif
				
			</div>
		</div>
		<!-- End Job Description -->
		
		<!-- Start Sidebar -->
		<div class="col-md-4 col-sm-12">
			<!-- <div class="sidebar right-sidebar">
			
				<!-- Job Alert -->
				<!-- <a href="javascript:void(0)" class="btn btn-info full-width mrg-bot-20" data-toggle="modal" data-target="#job-alert">Get Job Alert!</a> -->
				
				
				<!-- <div class="side-widget">
					<h2 class="side-widget-title">Job Overview</h2>
					<div class="widget-text padd-0">
						<div class="ur-detail-wrap">
							<div class="ur-detail-wrap-body padd-top-20">
								<ul class="ove-detail-list">
								
									<li>
										<i class="ti-wallet"></i>
										<h5>Offerd Salary</h5>
										<span>£15,000 - £20,000</span>
									</li>
									
									<li>
										<i class="ti-user"></i>
										<h5>Gender</h5>
										<span>Male</span>
									</li>
									
									<li>
										<i class="ti-ink-pen"></i>
										<h5>Career Level</h5>
										<span>Excutive</span>
									</li>
									
									<li>
										<i class="ti-home"></i>
										<h5>Industry</h5>
										<span>Management</span>
									</li>
									
									<li>
										<i class="ti-shield"></i>
										<h5>Experience</h5>
										<span>5 Years</span>
									</li>
									
									<li>
										<i class="ti-book"></i>
										<h5>Qualification</h5>
										<span>Master Degree</span>
									</li>
									
								</ul>
							</div>
						</div>
					</div>
				</div>	 -->
				
				<!-- <div class="statistic-item flex-middle">
					<div class="icon text-theme">
						<i class="ti-time theme-cl"></i>
					</div>
					<span class="text"><span class="number">2 months</span> ago</span>
				</div>
				
				<div class="statistic-item flex-middle">
					<div class="icon text-theme">
						<i class="ti-zoom-in theme-cl"></i>
					</div>
					<span class="text"><span class="number">1742</span> Views</span>
				</div>
				
				<div class="statistic-item flex-middle">
					<div class="icon text-theme">
					  <i class="ti-write theme-cl"></i>
					</div>
					<span class="text"><span class="number">17</span> Applicants</span>
				</div>
				
				
				<div class="sidebar-widgets">
				
					<div class="ur-detail-wrap">
						<div class="ur-detail-wrap-header">
							<h4>Get In Touch</h4>
						</div>
						<div class="ur-detail-wrap-body">
							<form action="#">
								<div class="form-group">
									<label>Name</label>
									<input type="email" class="form-control">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control">
								</div>
								<div class="form-group">
									<label>Message</label>
									<textarea class="form-control"></textarea>
								</div>
								<button type="submit" class="btn btn-primary">Submit</button>
							</form>
						</div>
					</div>
					
				</div> -->
				<!-- /Say Hello -->
				
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