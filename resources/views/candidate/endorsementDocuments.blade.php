@extends('layouts.app_afterLogin')
 
@section('content')
<?php
    
    $return_tab = Session::get('return_tab');
    if($return_tab == '' || empty($return_tab)){
        Session::forget('return_tab');
    }
    
    if(!empty($endors)){
        $endorsDocStatus = $endors[0]->endorse_filled_docs;
    }else{
        $endorsDocStatus = 0;
    }

    if(!empty($travel)){
        $travelDocStatus = $travel[0]->travel_filled_docs;
    }else{
        $travelDocStatus = 'travelNo';
    }

    if(!empty($medical)){
        $medicalDocStatus = $medical[0]->medical_filled_docs;
    }else{
        $medicalDocStatus = 'medicalNo';
    }

    if(!empty($skill)){
        $skillDocStatus  = $skill[0]->skill_filled_docs;
    }else{
        $skillDocStatus  = 'skillNo';
    }

    if(!empty($personal)){
        $personalDocStatus = $personal[0]->personal_filled_docs;
    }else{
        $personalDocStatus = 'personalNo';
    }

    if(!empty($coc)){
        $cocDocStatus = $coc[0]->coc_filled_docs;
    }else{
        $cocDocStatus = 'cocNo';
    }

    if(!empty($stcw)){
        $stcwDocStatus = $stcw[0]->stcw_filled_docs;
    }else{
        $stcwDocStatus = 'stcwNo';
    }

    if(!empty($offshore)){
        $offshoreDocStatus = $offshore[0]->offshore_filled_docs;
    }else{
        $offshoreDocStatus = 'offshoreNo';
    }
?>
<style type="text/css">
    .old_tab{
        background: #e7ecea !important;
        color: black !important;
    }
    .nav-tabs-custom>.nav-tabs>li:first-of-type {
        margin-left: 0;
    }
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: green;
    }
    .nav-tabs-custom>.nav-tabs>li {
        border-top: 3px solid transparent;
        margin-bottom: -2px;
        margin-right: 5px;
    }
    .nav-tabs-custom>.nav-tabs>li {
        border-top: 3px solid transparent;
        margin-bottom: -2px;
        margin-right: 5px;
    }
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
        color: #555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    .mand{
        color:red;
        font-weight: bold;
        font-size: 1.2em;
    }
    #endorse_table_wrapper .dataTables_length,#endorse_table_wrapper .dataTables_filter, #endorse_table_wrapper .dataTables_info,
    #endorse_table_wrapper .paging_simple_numbers {
        display: none;
    }
    #endorse_table_wrapper thead .sorting_asc , #endorse_table_wrapper .sorting{
        background-image: url('') !important;
    }
       
    #traveldoc_table_wrapper .dataTables_length, #traveldoc_table_filter, #traveldoc_table_info, #traveldoc_table_paginate{
        display: none;
    }
    #traveldoc_table_wrapper thead .sorting_asc , #traveldoc_table_wrapper .sorting{
        background-image: url('') !important;
    }
    #medicaldoc_table_wrapper .dataTables_length, #medicaldoc_table_filter, #medicaldoc_table_info, #medicaldoc_table_paginate{
        display: none;
    }
    #medicaldoc_table_wrapper thead .sorting_asc , #medicaldoc_table_wrapper .sorting{
        background-image: url('') !important;
    }
    #skill_trainingdoc_table_wrapper .dataTables_length, #skill_trainingdoc_table_filter, #skill_trainingdoc_table_info, #skill_trainingdoc_table_paginate{
        display: none;
    }
    
    #personaldoc_table_length, #personaldoc_table_filter, #personaldoc_table_info ,#personaldoc_table_filter{
        display: none;   
    }
</style>
<!-- General Detail Start -->
<section class="dashboard-wrap">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Wrap -->
            <div class="col-lg-3 col-md-4">
                <div class="side-dashboard">
                    <div class="dashboard-avatar">                                            
                        <div class="dashboard-avatar-thumb">                                
                            <?php     
                                // echo '<pre>';
                                // print_r($endors);
                                // exit;
                                foreach ($endors as $endors) {
                                    
                                }

                                $name = $profileimg[0]->profile_path;
                                $candidate_id = $profileimg[0]->id;
                                if($name == 'avatar-default.png'){
                                    $url = url('public/assets/img/avatar-default.png'); 
                                }else{
                                    $url = url('/public/profile/'.$name);
                                }  
                            ?>
                            @if(isset($name))
                            <img src="{{ $url }}" class="img-avater" alt="img-avater" />
                            @else
                            <img src="{{ url('public/assets/img/avatar-default.png') }}" class="img-avater" alt="img-avater1" />
                            @endif                                                           
                        </div>
                        <div class="dashboard-avatar-text">
                            <h4 style="text-transform: capitalize;">{{ Session::get('userName') }}</h4>
                        </div>                                                        
                    </div>
                    
                     <div class="dashboard-menu">
                        <ul>
                            @if(($profileimg[0]->candidate_status == 1) && ($profileimg[0]->docs_uploaded == 1) )
                            <li>
                                <a href="{{ route('cand.dashboard') }}"><i class="ti-dashboard"></i>Dashboard</a>
                            </li>
                            @endif 
                                                   
                            @if( ($profileimg[0]->candidate_status == 0))
                            <li>
                                <a href="{{ route('cand.profile') }}"><i class="ti-ruler-pencil"></i>Create Profile</a>
                            </li>
                            @endif
                            @if( ($profileimg[0]->candidate_status == 1) && ($profileimg[0]->docs_uploaded == 1) )
                                <li>
                                    <a href="{{ route('cand.edit') }}"><i class="ti-briefcase"></i>Update Profile</a>
                                </li>
                            @endif
                            @if(($profileimg[0]->candidate_status == 0) || ($profileimg[0]->docs_uploaded == 0))
                            <li class="active">
                                <a href="{{ route('endorsment.docs') }}"><i class="ti-briefcase"></i>Documents</a>
                            </li>
                            @endif
                            @if(($profileimg[0]->docs_uploaded == 1) )
                            <li class="active">
                                <a href="{{ route('endorsment.docs') }}"><i class="ti-briefcase"></i>Documents</a>
                            </li>
                            <li>
                                <a href="{{ route('cand.applylist') }}"><i class="ti-briefcase"></i>Job Applications</a>
                            </li>
                            <li>
                                <a href="{{ route('profileViewByEmployer') }}"><i class="ti-briefcase"></i>Profile Viewed BY Employer</a>
                            </li>
                            @endif
                             @if( ($profileimg[0]->candidate_status == 1) && ($profileimg[0]->docs_uploaded == 1) )
                            <?php
                              $candEmail = Session::get('userEmail');
                              if(isset($candEmail)){
                                $chatUserData = DB::select("SELECT *  FROM users where email="."'".$candEmail."'");
                                $candidateUser = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");

                              if(isset($chatUserData[0]) && ($candidateUser[0]->email_verified_at == '1') && ($candidateUser[0]->candidate_status == '1')){
                              ?>
                                <li class="<?php echo(request()->is('/conversations')) ? 'active':'' ?>">
                                    <a href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatUserData[0]->id }}" >
                                        <i class="ti-headphone-alt"></i> Chat Here
                                    </a>
                                </li>
                            <?php 
                                    }
                                } 
                            ?>
                            @endif
                        </ul>
                        
                    </div>
                </div>
            </div>
            
            <!-- Content Wrap -->
            <div class="col-lg-9 col-md-8">
                <div class="dashboard-body">
                <!--KnowledgeBase permanent  -->
                @include('includes.candidateknowlwdgebase')
                <!-- Unread message flash -->
                @if($conversationUnreadCount > 0)
                    <div class="alert alert-success alert-dismissable fade in" style="padding-bottom: 3%;">
                        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                        <p style="padding-left: 18px;text-transform: uppercase;">
                        <?php
                          $candEmail = Session::get('userEmail');
                          if(isset($candEmail)){
                            $chatUserData = DB::select("SELECT *  FROM users where email="."'".$candEmail."'");
                            $candidateUser = DB::select("SELECT *  FROM candidates where email="."'".$candEmail."'");

                          if(isset($chatUserData[0]) && ($candidateUser[0]->email_verified_at == '1') && ($candidateUser[0]->candidate_status == '1')){
                            // $email = Crypt::encryptString($chatUserData[0]->email);
                            // $password = $chatUserData[0]->decrpted_password;
                            //'http://chatingapp.onlinemariners.com/login?email='.$email.'&&password='.$password 
                        ?>
                            {{ 'You have '.$conversationUnreadCount.' unread meassages.'  }}
                                <a href="{{ 'http://chatingapp.onlinemariners.com/login?id='.$chatUserData[0]->id }}" >
                                    <i class="ti-headphone-alt"></i> Click To Chat
                                </a>
                            
                        <?php 
                                }
                            } 
                        ?>
                            
                        </p>
                    </div>
                @endif
                <!-- end of Unread message flash -->
                <!-- Flash Msg on success-->
                <?php 
                    $return_tab = Session::get('return_tab'); 
                 ?>
                 <input type="hidden" value="{{ $return_tab }}" id="return_tab">
                
                <!-- Flash msg For document upload -->
                @if( isset($profileimg[0]->docs_uploaded) && ($profileimg[0]->docs_uploaded == 0) )
                    <div class="alert alert-danger alert-dismissable fade in">
                        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                        <b>Error ! </b>{{ 'Active account by completing next step is to click on "Documents" from menu And update your documents avaibility.' }}
                    </div>
                @endif
               <div class="dashboard-body">
                    <div class="dashboard-caption">
                        
                        <div class="dashboard-caption-header">
                            <h4><i class="ti-briefcase"></i>Documents</h4>
                        </div>
                        
                        <div class="dashboard-caption-wrap">                            
                            <!-- Custom Tabs -->
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <!--1 Endorsements -->        
                                <div class="panel panel-default" id="endorsements_tab1">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" {{($return_tab && $return_tab=="endorse_tab") ? ' style="background-color:#03a84e;color:white"' : ''}} class='{{($return_tab && $return_tab=="endorse_tab") ? '' : 'collapsed'}}'>
                                                Endorsements
                                            </a>
                                        </h4>
                                    </div>
                                    
                                    <div id="collapseOne" class="panel-collapse {{($return_tab && $return_tab=='endorse_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingOne">

                                        @if( session('success') && $return_tab == 'endorse_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>{{ session('success') }}
                                            </div>
                                        @endif
                                        <!-- Flash Msg on success-->
                                        @if( session('error')  && $return_tab == 'endorse_tab')
                                            <div class="msg alert alert-danger alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Error ! </b>{{ session('error') }}
                                            </div>
                                        @endif

                                        <div class="panel-body">
                                            <form name="endorse_form" method='POST' action="{{ route('endorsment.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="endorse_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Doc No</th>
                                                        <th style="width: 50%">Doc Name</th>
                                                        <th style="width: 20%">Do you have it?</th>
                                                        <th style="width: 20%">Is Document valid?</th>            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            (Dangerous Cargo Endorsement) DCE - Chemical
                                                            <input type="hidden" name="endors_name_dec_chemical" value="DCE - Chemical">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',1, 1)" type="radio" name="is_endors_name_dec_chemical" class="rb_end_chemical_yes" value="1" {{(isset($endors->is_endors_name_dec_chemical) && ($endors->is_endors_name_dec_chemical == '1') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',1, 0)" type="radio" name="is_endors_name_dec_chemical"  class="rb_end_chemical_no" value="0" {{(isset($endors->is_endors_name_dec_chemical) && ($endors->is_endors_name_dec_chemical == '0') ) ? 'checked': ''}}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>    
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_endors_name_dec_chemical_disabled}}  type="radio" name="endors_dec_chemical_dt_status" class="rb_end_chemical_yes end_1" value="yes" {{ (isset($endors->endors_dec_chemical_dt_status) && ($endors->endors_dec_chemical_dt_status == 'yes') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_endors_name_dec_chemical_disabled}} type="radio" name="endors_dec_chemical_dt_status"  class="rb_end_chemical_no end_1" value="no"  {{ (isset($endors->endors_dec_chemical_dt_status) && ($endors->endors_dec_chemical_dt_status == 'no') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td> 

                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            (Dangerous Cargo Endorsement) DCE - Gas
                                                            <input type="hidden" name="endors_name_dec_gas" value="DCE - Gas">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',2, 1)" type="radio" name="is_endors_name_dec_gas" class="rb_end_dec_yes"  value="1" {{(isset($endors->is_endors_name_dec_gas) && ($endors->is_endors_name_dec_gas == '1') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',2, 0)" type="radio" name="is_endors_name_dec_gas" class="rb_end_dec_no" class="rbhaveit" value="0" {{(isset($endors->is_endors_name_dec_gas) && ($endors->is_endors_name_dec_gas == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>                                                           
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_endors_name_dec_gas_disabled}} type="radio" name="endors_dec_gas_dt_status" class="rb_end_chemical_yes end_2" value="yes" {{ (isset($endors->endors_dec_gas_dt_status) && ($endors->endors_dec_gas_dt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_endors_name_dec_gas_disabled}} type="radio" name="endors_dec_gas_dt_status"  class="rb_end_chemical_no end_2" value="no" {{ (isset($endors->endors_dec_gas_dt_status) && ($endors->endors_dec_gas_dt_status == 'no') ) ? 'checked': ''  }}> No </label>
                                                            </div> 
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            (Dangerous Cargo Endorsement) DCE - Others
                                                            <input type="hidden" name="endors_name_dec_others" value="DCE - Others">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',3, 1)" type="radio" name="is_endors_name_dec_others"  class="rb_end_deco_yes" value="1" {{(isset($endors->is_endors_name_dec_others) && ($endors->is_endors_name_dec_others == '1') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',3, 0)" type="radio" name="is_endors_name_dec_others"  class="rb_end_deco_no" value="0"  {{(isset($endors->is_endors_name_dec_others) && ($endors->is_endors_name_dec_others == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>                                                            
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_endors_name_dec_others_disabled}} type="radio" name="endors_dec_others_dt_status"  class="rb_end_deco_yes end_3" value="yes" {{ (isset($endors->endors_dec_others_dt_status) && ($endors->endors_dec_others_dt_status == 'yes') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_endors_name_dec_others_disabled}} type="radio" name="endors_dec_others_dt_status"  class="rb_end_deco_no end_3" value="no" {{ (isset($endors->endors_dec_others_dt_status) && ($endors->endors_dec_others_dt_status == 'no') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>(Dangerous Cargo Endorsement) DCE - Petroleum 
                                                            <input type="hidden" name="endors_name_dec_petroleum" value="DCE - Petroleum">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',4, 1)" type="radio" name="is_endors_name_dec_petroleum"  class="rb_edpt_yes" value="1" {{(isset($endors->is_endors_name_dec_petroleum) && ($endors->is_endors_name_dec_petroleum == '1') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',4, 0)" type="radio" name="is_endors_name_dec_petroleum" class="rb_edpt_no" value="0" {{(isset($endors->is_endors_name_dec_petroleum) && ($endors->is_endors_name_dec_petroleum == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_endors_name_dec_petroleum_disabled}} type="radio" name="endors_dec_petroleum_dt_status"  class="rb_end_deco_yes end_4" value="yes" {{ (isset($endors->endors_dec_petroleum_dt_status) && ($endors->endors_dec_petroleum_dt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_endors_name_dec_petroleum_disabled}} type="radio" name="endors_dec_petroleum_dt_status"  class="rb_end_deco_no end_4" value="no" {{ (isset($endors->endors_dec_petroleum_dt_status) && ($endors->endors_dec_petroleum_dt_status == 'no')) ? 'checked': '' }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php /*
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Others
                                                            <input type="hidden" name="endors_name_others" value="Others">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',5, 1)" type="radio" name="is_endors_name_others"  class="rb_edpt_yes" value="1" {{(isset($endors->is_endors_name_others) && ($endors->is_endors_name_others == '1') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('end',5, 0)" type="radio" name="is_endors_name_others" class="rb_edpt_no" value="0" {{(isset($endors->is_endors_name_others) && ($endors->is_endors_name_others == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_endors_name_others_disabled}} type="radio" name="endors_others_dt_status"  class="rb_end_deco_yes end_5" value="yes" {{ (isset($endors->endors_others_dt_status) && ($endors->endors_others_dt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_endors_name_others_disabled}} type="radio" name="endors_others_dt_status"  class="rb_end_deco_no end_5" value="no" {{ (isset($endors->endors_others_dt_status) && ($endors->endors_others_dt_status == 'no')) ? 'checked': '' }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>*/?>
                                                </tbody>
                                            </table>
                                            <button type="submit" id="endorsement_submit" class="btn btn-success btn-primary small-btn">Next</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2-->
                                <div class="panel panel-default" id="travel_tab2">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" {{($return_tab && $return_tab=="travel_tab") ? ' style="background-color:#03a84e;color:white"' : ''}} class='{{($return_tab && $return_tab=="travel_tab") ? '' : 'collapsed'}}'>
                                                Travel Document
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse  {{($return_tab && $return_tab=='travel_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingTwo">
                                        @if( session('success') && $return_tab == 'travel_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>{{ session('success') }}
                                            </div>
                                        @endif
                                        <!-- Flash Msg on success-->
                                        @if( session('error')  && $return_tab == 'travel_tab')
                                            <div class="msg alert alert-danger alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Error ! </b>{{ session('error') }}
                                            </div>
                                        @endif

                                        <div class="panel-body">
                                            <form name="endorse_form" method='POST' action="{{ route('traveldoc.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="traveldoc_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Doc No</th>
                                                        <th style="width: 50%">Doc Name</th>
                                                        <th style="width: 20%">Do you have it?</th>
                                                        <th style="width: 20%">Is Document valid?</th>            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            Passport
                                                            <input type="hidden" name="passport" value="Passport">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('td',1, 1)" type="radio" name="is_passport"  class="rb_passport_yes" value="1" {{(isset($travel[0]->is_passport) && ($travel[0]->is_passport == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('td',1, 0)" type="radio" name="is_passport"  value="0" class="rb_passport_no" {{(isset($travel[0]->is_passport) && ($travel[0]->is_passport == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>                                                            
                                                           <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_passport_disabled}} type="radio" name="passport_status"   class="rb_end_deco_yes td_1" value="yes" {{ ( isset($travel[0]->passport_status) && ($travel[0]->passport_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_passport_disabled}} type="radio" name="passport_status"  class="rb_end_deco_no td_1" value="no" {{ ( isset($travel[0]->passport_status) && ($travel[0]->passport_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                            
                                                        </td>                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            Seaman's Book/CDC (Continuous Discharge Certificate)
                                                            <input type="hidden" name="Seamans_book_cdc" value="Seaman's Book/CDC">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('td',2, 1)" type="radio" name="is_Seamans_book_cdc"  class="rb_semanbook_yes" value="1" {{(isset($travel[0]->is_Seamans_book_cdc) && ($travel[0]->is_Seamans_book_cdc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('td',2, 0)" type="radio" name="is_Seamans_book_cdc"  class="rb_semanbook_no" value="0" {{(isset($travel[0]->is_Seamans_book_cdc) && ($travel[0]->is_Seamans_book_cdc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_Seamans_book_cdc_disabled}} type="radio" name="Seamans_book_cdc_status"  class="rb_end_deco_yes td_2" value="yes" {{ ( isset($travel[0]->Seamans_book_cdc_status) && ($travel[0]->Seamans_book_cdc_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_Seamans_book_cdc_disabled}} type="radio" name="Seamans_book_cdc_status"  class="rb_end_deco_no td_2" value="no" {{ ( isset($travel[0]->Seamans_book_cdc_status) && ($travel[0]->Seamans_book_cdc_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                            
                                                        </td>
                                                    </tr>
                                                   <?php /*<tr>
                                                        <td>3</td>
                                                        <td>
                                                            UK Work Permit
                                                            <input type="hidden" name="uk_work_permit" value="UK Work Permit">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('td',3, 1)" type="radio" name="is_uk_work_permit" class="rb_ukpermit_yes"  value="1" {{(isset($travel[0]->is_uk_work_permit) && ($travel[0]->is_uk_work_permit == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('td',3, 0)" type="radio" name="is_uk_work_permit"  class="rb_ukpermit_no" value="0" {{(isset($travel[0]->is_uk_work_permit) && ($travel[0]->is_uk_work_permit == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_uk_work_permit_disabled}} type="radio" name="uk_work_permit_staus"  class="rb_end_deco_yes td_3" value="yes" {{ ( isset($travel[0]->uk_work_permit_staus) && ($travel[0]->uk_work_permit_staus == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_uk_work_permit_disabled}} type="radio" name="uk_work_permit_staus"  class="rb_end_deco_no td_3" value="no" {{ ( isset($travel[0]->uk_work_permit_staus) && ($travel[0]->uk_work_permit_staus == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                            
                                                        </td>
                                                    </tr>*/?>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            US Visa
                                                            <input type="hidden" name="us_visa" value="US Visa">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('td',4, 1)" type="radio" name="is_uk_visa" class="rb_usvisa_yes" value="1" {{(isset($travel[0]->is_uk_visa) && ($travel[0]->is_uk_visa == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('td',4, 0)" type="radio" name="is_uk_visa"  class="rb_usvisa_no" value="0" {{(isset($travel[0]->is_uk_visa) && ($travel[0]->is_uk_visa == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_uk_visa_disabled}} type="radio" name="us_visa_status"  class="rb_end_deco_yes td_4" value="yes" {{ ( isset($travel[0]->us_visa_status) && ($travel[0]->us_visa_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_uk_visa_disabled}} type="radio" name="us_visa_status"  class="rb_end_deco_no td_4" value="no" {{ ( isset($travel[0]->us_visa_status) && ($travel[0]->us_visa_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>  
                                                    <?php /*<tr>
                                                        <td>5</td>
                                                        <td>
                                                            Others
                                                            <input type="hidden" name="travel_others" value="Others">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('td',5, 1)" type="radio" name="is_travel_others" class="rb_usvisa_yes" value="1" {{(isset($travel[0]->is_travel_others) && ($travel[0]->is_travel_others == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('td',5, 0)" type="radio" name="is_travel_others"  class="rb_usvisa_no" value="0" {{(isset($travel[0]->is_travel_others) && ($travel[0]->is_travel_others == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_travel_others_disabled}} type="radio" name="travel_others_dt_status"  class="rb_end_deco_yes td_4" value="yes" {{ ( isset($travel[0]->travel_others_dt_status) && ($travel[0]->travel_others_dt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_travel_others_disabled}} type="radio" name="travel_others_dt_status"  class="rb_end_deco_no td_4" value="no" {{ ( isset($travel[0]->travel_others_dt_status) && ($travel[0]->travel_others_dt_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr> */?>

                                                </tbody>
                                            </table>
                                            <button type="submit" id="travel_submit" class="btn btn-success btn-primary small-btn">Next</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3 -->
                                <div class="panel panel-default" id="medical_tab3">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a  role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"   {{($return_tab && $return_tab=="medical_tab") ? ' style="background-color:#03a84e;color:white"' : ''}} class='{{($return_tab && $return_tab=="medical_tab") ? '' : 'collapsed'}}'>
                                                Medical Document
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse  {{($return_tab && $return_tab=='medical_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingThree">
                                        @if( session('success') && $return_tab == 'medical_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>{{ session('success') }}
                                            </div>
                                        @endif
                                        <!-- Flash Msg on success-->
                                        @if( session('error')  && $return_tab == 'medical_tab')
                                            <div class="msg alert alert-danger alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Error ! </b>{{ session('error') }}
                                            </div>
                                        @endif

                                        <div class="panel-body">
                                            <form name="medical_doc_form" method='POST' action="{{ route('medicaldoc.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="medicaldoc_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Doc No</th>
                                                        <th style="width: 50%">Doc Name</th>
                                                        <th style="width: 20%">Do you have it?</th>
                                                        <th style="width: 20%">Is Document valid?</th>            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            Drug and Alcohol Test / Blood Test
                                                            <input type="hidden" name="drug_alcohol_blood_test" value="Drug and Alcohol Test / Blood Test">
                                                        </td>
                                                        <td id="doc_have_1">
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input type="radio" onclick="updateValidTable('md',1, 1)" name="is_drug_alcohol_blood_test"  class="rb_drugtest_yes" value="1" {{(isset($medical[0]->is_drug_alcohol_blood_test) && ($medical[0]->is_drug_alcohol_blood_test == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',1, 0)" type="radio" name="is_drug_alcohol_blood_test"  class="rb_drugtest_no" value="0" {{(isset($medical[0]->is_drug_alcohol_blood_test) && ($medical[0]->is_drug_alcohol_blood_test == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td id="doc_valid_1" >
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_drug_alcohol_blood_test_disabled}} type="radio" name="drug_alcohol_blood_test_status"  class="rb_end_deco_yes md_1" value="yes" {{ ( isset($medical[0]->drug_alcohol_blood_test_status) && ($medical[0]->drug_alcohol_blood_test_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_drug_alcohol_blood_test_disabled}} type="radio" name="drug_alcohol_blood_test_status"  class="rb_end_deco_no md_1" value="no" {{ ( isset($medical[0]->drug_alcohol_blood_test_status) && ($medical[0]->drug_alcohol_blood_test_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                             
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            Seafarer's Medical Examination
                                                            <input type="hidden" name="seafarers_medical_examination" value="Seafarer's Medical Examination">
                                                        </td>
                                                        <td id="doc_have_2">
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',2, 1)" type="radio" name="is_seafarers_medical_examination"  class="rb_seadrer_yes" value="1" {{(isset($medical[0]->is_seafarers_medical_examination) && ($medical[0]->is_seafarers_medical_examination == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',2, 0)" type="radio" name="is_seafarers_medical_examination" class="rb_seadrer_no" value="0" {{(isset($medical[0]->is_seafarers_medical_examination) && ($medical[0]->is_seafarers_medical_examination == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td id="doc_valid_2">
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_seafarers_medical_examination_disabled}} type="radio" name="seafarers_medical_examination_status"  class="rb_end_deco_yes md_2" value="yes" {{ ( isset($medical[0]->seafarers_medical_examination_status) && ($medical[0]->seafarers_medical_examination_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_seafarers_medical_examination_disabled}} type="radio" name="seafarers_medical_examination_status"  class="rb_end_deco_no md_2" value="no" {{ ( isset($medical[0]->seafarers_medical_examination_status) && ($medical[0]->seafarers_medical_examination_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                   <?php /* <tr>
                                                        <td>3</td>
                                                        <td>
                                                            UKOOA - Medical Fitness
                                                            <input type="hidden" name="ukooa_medical_fitness" value="UKOOA - Medical Fitness">
                                                        </td>
                                                        <td id="doc_have_3">
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',3, 1)" type="radio" name="is_ukooa_medical_fitness"  class="rb_ukooa_yes" value="1" {{(isset($medical[0]->is_ukooa_medical_fitness) && ($medical[0]->is_ukooa_medical_fitness == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',3, 0)" type="radio" name="is_ukooa_medical_fitness"  class="rb_ukooa_no" value="0" {{(isset($medical[0]->is_ukooa_medical_fitness) && ($medical[0]->is_ukooa_medical_fitness == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td id="doc_valid_3">
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_ukooa_medical_fitness_disabled}} type="radio" name="ukooa_medical_fitness_status"  class="rb_end_deco_yes md_3" value="yes" {{ ( isset($medical[0]->ukooa_medical_fitness_status) && ($medical[0]->ukooa_medical_fitness_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_ukooa_medical_fitness_disabled}} type="radio" name="ukooa_medical_fitness_status"  class="rb_end_deco_no md_3" value="no" {{ ( isset($medical[0]->ukooa_medical_fitness_status) && ($medical[0]->ukooa_medical_fitness_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    */?>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            Yellow Fever Vaccination
                                                            <input type="hidden" name="yellow_fever_vaccination" value="Yellow Fever Vaccination">
                                                        </td>
                                                        <td id="doc_have_4">
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',4, 1)" type="radio" name="is_yellow_fever_vaccination" class="rb_yfever_yes" value="1" {{(isset($medical[0]->is_yellow_fever_vaccination) && ($medical[0]->is_yellow_fever_vaccination == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',4,0)" type="radio" name="is_yellow_fever_vaccination"  class="rb_yfever_no" value="0" {{(isset($medical[0]->is_yellow_fever_vaccination) && ($medical[0]->is_yellow_fever_vaccination == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td id="doc_valid_4">                                                           
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_yellow_fever_vaccination_disabled}} type="radio" name="yellow_fever_vaccination_status"  class="rb_end_deco_yes md_4" value="yes" {{ ( isset($medical[0]->yellow_fever_vaccination_status) && ($medical[0]->yellow_fever_vaccination_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_yellow_fever_vaccination_disabled}} type="radio" name="yellow_fever_vaccination_status"  class="rb_end_deco_no md_4" value="no" {{ ( isset($medical[0]->yellow_fever_vaccination_status) && ($medical[0]->yellow_fever_vaccination_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php /*
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Others
                                                            <input type="hidden" name="medical_others" value="Others">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',5, 1)" type="radio" name="is_medical_others"  class="rb_edpt_yes" value="1" {{(isset($medical[0]->is_medical_others) && ($medical[0]->is_medical_others == '1') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('md',5, 0)" type="radio" name="is_medical_others" class="rb_edpt_no" value="0" {{(isset($medical[0]->is_medical_others) && ($medical[0]->is_medical_others == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_medical_others_disabled}} type="radio" name="medical_others_dt_status"  class="rb_end_deco_yes md_5" value="yes" {{ (isset($medical[0]->medical_others_dt_status) && ($medical[0]->medical_others_dt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input {{$is_medical_others_disabled}} type="radio" name="medical_others_dt_status"  class="rb_end_deco_no md_5" value="no" {{ (isset($medical[0]->medical_others_dt_status) && ($medical[0]->medical_others_dt_status == 'no')) ? 'checked': '' }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>*/?>
                                                </tbody>
                                            </table>
                                            <button type="submit" id="medical_submit" class="btn btn-success btn-primary small-btn">Next</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>

                                
                                <!-- 4 -->
                                <?php /*
                                <div class="panel panel-default" id="satc_tab4">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour"   {{($return_tab && $return_tab=="skill_tab") ? ' style="background-color:#03a84e;color:white"' : ''}}  class='{{($return_tab && $return_tab=="skill_tab") ? '' : 'collapsed'}}'>    
                                                Skills And Training Certificates
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapseFour" class="panel-collapse  {{($return_tab && $return_tab=='skill_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingFour">
                                        @if( session('success') && $return_tab == 'skill_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>{{ session('success') }}
                                            </div>
                                        @endif
                                        <!-- Flash Msg on success-->
                                        @if( session('error')  && $return_tab == 'skill_tab')
                                            <div class="msg alert alert-danger alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Error ! </b>{{ session('error') }}
                                            </div>
                                        @endif

                                        <div class="panel-body">
                                            <form name="skill_trainging_doc_form" method='POST' action="{{ route('skilldoc.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="skill_trainingdoc_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Doc No</th>
                                                        <th>Doc Name</th>
                                                        <th>Do you have it?</th>
                                                        <th>Is Document valid?</th>                                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            ARPA
                                                            <input type="hidden" name="arpa" value="ARPA">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">

                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',1, 1)" type="radio" name="is_arpa" class="rb_arpa_yes" value="1" {{(isset($skill[0]->is_arpa) && ($skill[0]->is_arpa == 1)) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',1, 0)" type="radio" name="is_arpa"  class="rb_arpa_no" value="0" {{(isset($skill[0]->is_arpa) && ($skill[0]->is_arpa == '0') ) ? 'checked': ''}}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_arpa_disabled}} type="radio" name="arpa_status"  class="rb_end_deco_yes stc_1" value="yes" {{ ( isset($skill[0]->arpa_status) && ($skill[0]->arpa_status == 'yes')) ? 'checked': '' }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_arpa_disabled}} type="radio" name="arpa_status"  class="rb_end_deco_no stc_1" value="no" {{ ( isset($skill[0]->arpa_status) && ($skill[0]->arpa_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            Behaviour Based Safety Process
                                                            <input type="hidden" name="behaviour_safety_process" value="Behaviour Based Safety Process">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',2, 1)" type="radio" name="is_bbsp" class="rb_behaviour_safety_yes"  value="1"{{(isset($skill[0]->is_bbsp) && ($skill[0]->is_bbsp == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',2, 0)" type="radio" name="is_bbsp" class="rb_behaviour_safety_no" value="0" {{(isset($skill[0]->is_bbsp) && ($skill[0]->is_bbsp == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_bbsp_disabled}} type="radio" name="behaviour_safety_process_status"  class="rb_end_deco_yes stc_2" value="yes" {{ ( isset($skill[0]->behaviour_safety_process_status) && ($skill[0]->behaviour_safety_process_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_bbsp_disabled}} type="radio" name="behaviour_safety_process_status"  class="rb_end_deco_no stc_2" value="no" {{ ( isset($skill[0]->behaviour_safety_process_status) && ($skill[0]->behaviour_safety_process_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            Boatmaster License
                                                            <input type="hidden" name="boatmaster_license" value="Boatmaster License">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',3, 1)" type="radio" name="is_bl" class="rb_boat_license_yes"  value="1"{{(isset($skill[0]->is_bl) && ($skill[0]->is_bl == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',3, 0)" type="radio" name="is_bl" class="rb_boat_license_no" value="0" {{(isset($skill[0]->is_bl) && ($skill[0]->is_bl == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_bl_disabled}} type="radio" name="boatmaster_license_status"  class="rb_end_deco_yes stc_3" value="yes" {{ ( isset($skill[0]->boatmaster_license_status) && ($skill[0]->boatmaster_license_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_bl_disabled}} type="radio" name="boatmaster_license_status"  class="rb_end_deco_no stc_3" value="no" {{ ( isset($skill[0]->boatmaster_license_status) && ($skill[0]->boatmaster_license_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>4</td>
                                                        <td>
                                                            Bridge Team Management
                                                            <input type="hidden" name="bridge_team_management" value="Bridge Team Management">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('stc',4, 1)"  type="radio" name="is_btm" class="rb_bridgeteam_mgt_yes" value="1"{{(isset($skill[0]->is_btm) && ($skill[0]->is_btm == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('stc',4, 0)"  type="radio" name="is_btm" class="rb_bridgeteam_mgt_no"  value="0" {{(isset($skill[0]->is_btm) && ($skill[0]->is_btm == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_btm_disabled}} type="radio" name="bridge_team_management_status"  class="rb_end_deco_yes stc_4" value="yes" {{ ( isset($skill[0]->bridge_team_management_status) && ($skill[0]->bridge_team_management_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_btm_disabled}} type="radio" name="bridge_team_management_status"  class="rb_end_deco_no stc_4" value="no" {{ ( isset($skill[0]->bridge_team_management_status) && ($skill[0]->bridge_team_management_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>
                                                            Chemical Tanker Training
                                                            <input type="hidden" name="chemical_tankertraining" value="Chemical Tanker Training">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',5, 1)"  type="radio" name="is_ctt" class="rb_chemical_tank_yes"  value="1"{{(isset($skill[0]->is_ctt) && ($skill[0]->is_ctt == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',5, 0)"  type="radio" name="is_ctt" class="rb_chemical_tank_no" value="0" {{(isset($skill[0]->is_ctt) && ($skill[0]->is_ctt == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_ctt_disabled}} type="radio" name="chemical_tankertraining_status"  class="rb_end_deco_yes stc_5" value="yes" {{ ( isset($skill[0]->chemical_tankertraining_status) && ($skill[0]->arpa_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_ctt_disabled}} type="radio" name="chemical_tankertraining_status"  class="rb_end_deco_no stc_5" value="no" {{ ( isset($skill[0]->chemical_tankertraining_status) && ($skill[0]->arpa_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>
                                                            COWS - Crude Oil Washing
                                                            <input type="hidden" name="cows_crudeoil_washing" value="COWS - Crude Oil Washing">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',6, 1)"  type="radio" name="is_ccow" class="rb_cows_yes" value="1"{{(isset($skill[0]->is_ccow) && ($skill[0]->is_ccow == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',6, 0)"  type="radio" name="is_ccow" class="rb_cows_no"  value="0" {{(isset($skill[0]->is_ccow) && ($skill[0]->is_ccow == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_ccow_disabled}} type="radio" name="cows_crudeoil_washing_status"  class="rb_end_deco_yes stc_6" value="yes" {{ ( isset($skill[0]->cows_crudeoil_washing_status) && ($skill[0]->cows_crudeoil_washing_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_ccow_disabled}} type="radio" name="cows_crudeoil_washing_status"  class="rb_end_deco_no stc_6" value="no" {{ ( isset($skill[0]->cows_crudeoil_washing_status) && ($skill[0]->cows_crudeoil_washing_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>
                                                            Crane Operator Certificate
                                                            <input type="hidden" name="crane_operator_certificate" value="Crane Operator Certificate">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',7, 1)"  type="radio" name="is_coc" class="rb_crencerti_yes" value="1"{{(isset($skill[0]->is_coc) && ($skill[0]->is_coc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',7, 0)"  type="radio" name="is_coc" class="rb_crencerti_no" value="0" {{(isset($skill[0]->is_coc) && ($skill[0]->is_coc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_coc_disabled}} type="radio" name="crane_operator_certificate_status"  class="rb_end_deco_yes stc_7" value="yes" {{ ( isset($skill[0]->arpa_status) && ($skill[0]->crane_operator_certificate_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_coc_disabled}} type="radio" name="crane_operator_certificate_status"  class="rb_end_deco_no stc_7" value="no" {{ ( isset($skill[0]->arpa_status) && ($skill[0]->crane_operator_certificate_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td>
                                                            DP - Induction
                                                            <input type="hidden" name="dp_induction" value="DP - Induction">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',8, 1)"  type="radio" name="is_induction"  class="rb_dpinduction_yes" value="1"{{(isset($skill[0]->is_induction) && ($skill[0]->is_induction == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',8, 0)"  type="radio" name="is_induction" class="rb_dpinduction_no" value="0" {{(isset($skill[0]->is_induction) && ($skill[0]->is_induction == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_induction_disabled}} type="radio" name="dp_induction_status"  class="rb_end_deco_yes stc_8" value="yes" {{ ( isset($skill[0]->dp_induction_status) && ($skill[0]->dp_induction_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_induction_disabled}} type="radio" name="dp_induction_status"  class="rb_end_deco_no stc_8" value="no" {{ ( isset($skill[0]->dp_induction_status) && ($skill[0]->dp_induction_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>9</td>
                                                        <td>
                                                            DP - Limited
                                                            <input type="hidden" name="dp_limited" value="DP - Limited">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',9, 1)"  type="radio" name="is_limited" class="rb_dplimited_yes" value="1"{{(isset($skill[0]->is_limited) && ($skill[0]->is_limited == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',9, 0)"  type="radio" name="is_limited" class="rb_dplimited_no" value="0" {{(isset($skill[0]->is_limited) && ($skill[0]->is_limited == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_limited_disabled}} type="radio" name="dp_limited_status"  class="rb_end_deco_yes stc_9" value="yes" {{ ( isset($skill[0]->dp_limited_status) && ($skill[0]->dp_limited_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_limited_disabled}} type="radio" name="dp_limited_status"  class="rb_end_deco_no stc_9" value="no" {{ ( isset($skill[0]->dp_limited_status) && ($skill[0]->dp_limited_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>10</td>
                                                        <td>
                                                            DP - Simulator
                                                            <input type="hidden" name="dp_simulator" value="DP - Simulator">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('stc',10, 1)"  type="radio" name="is_simulator"  class="rb_dpsimulator_yes" value="1" {{(isset($skill[0]->is_simulator) && ($skill[0]->is_simulator == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',10, 0)"  type="radio" name="is_simulator"  class="rb_dpsimulator_no" value="0"  {{(isset($skill[0]->is_simulator) && ($skill[0]->is_simulator == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_simulator_disabled}} type="radio" name="dp_simulator_status"  class="rb_end_deco_yes stc_10" value="yes" {{ ( isset($skill[0]->dp_simulator_status) && ($skill[0]->dp_simulator_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_simulator_disabled}} type="radio" name="dp_simulator_status"  class="rb_end_deco_no stc_10" value="no" {{ ( isset($skill[0]->dp_simulator_status) && ($skill[0]->dp_simulator_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>    
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>11</td>
                                                        <td>
                                                            DP - Full
                                                            <input type="hidden" name="dp_full" value="DP - Full">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',11, 1)"  type="radio" name="others_dt"  value="1" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('stc',11, 0)" type="radio" name="others_dt"  value="0" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="dp_full_status"  class="rb_end_deco_yes stc_11" value="yes" {{ ( isset($skill[0]->dp_full_status) && ($skill[0]->dp_full_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="dp_full_status"  class="rb_end_deco_no stc_11" value="no" {{ ( isset($skill[0]->dp_full_status) && ($skill[0]->dp_full_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>     
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>12</td>
                                                        <td>
                                                            DP Maintenance
                                                            <input type="hidden" name="others" value="DP Maintenance">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',12, 1)"  type="radio" name="dp_maintenance_require"  value="1" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',12, 0)"  type="radio" name="dp_maintenance_require"  value="0" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="dp_maintenance_status"  class="rb_end_deco_yes stc_12" value="yes" {{ ( isset($skill[0]->dp_maintenance_status) && ($skill[0]->dp_maintenance_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="dp_maintenance_status"  class="rb_end_deco_no stc_12" value="no" {{ ( isset($skill[0]->dp_maintenance_status) && ($skill[0]->dp_maintenance_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>          
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>13</td>
                                                        <td>
                                                            ECDIS
                                                            <input type="hidden" name="ecdis" value="ECDIS">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',13, 1)"  type="radio" name="ecdis_require"  value="1" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',13, 0)"  type="radio" name="ecdis_require"  value="0" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="ecdis_staus"  class="rb_end_deco_yes stc_13" value="yes" {{ ( isset($skill[0]->ecdis_staus) && ($skill[0]->ecdis_staus == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="ecdis_staus"  class="rb_end_deco_no stc_13" value="no" {{ ( isset($skill[0]->ecdis_staus) && ($skill[0]->ecdis_staus == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>     
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>14</td>
                                                        <td>
                                                            ECDIS KH
                                                            <input type="hidden" name="ecdis_kh" value="ECDIS KH">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',14, 1)"  type="radio" name="others_dt"  value="1" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',14, 0)"  type="radio" name="others_dt"  value="0" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="ecdis_kh_status"  class="rb_end_deco_yes stc_14" value="yes" {{ ( isset($skill[0]->ecdis_kh_status) && ($skill[0]->ecdis_kh_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="ecdis_kh_status"  class="rb_end_deco_no stc_14" value="no" {{ ( isset($skill[0]->ecdis_kh_status) && ($skill[0]->ecdis_kh_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>    
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>15</td>
                                                        <td>
                                                            Engineroom Systems Management
                                                            <input type="hidden" name="engineroom_simulator" value="Engineroom Systems Management">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',15, 1)"  type="radio" name="engineroom_simulator_require"  value="1" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',15, 0)"  type="radio" name="engineroom_simulator_require"  value="0" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="engineroom_simulator_status"  class="rb_end_deco_yes stc_15" value="yes" {{ ( isset($skill[0]->engineroom_simulator_status) && ($skill[0]->engineroom_simulator_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="engineroom_simulator_status"  class="rb_end_deco_no stc_15" value="no" {{ ( isset($skill[0]->engineroom_simulator_status) && ($skill[0]->engineroom_simulator_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>16</td>
                                                        <td>
                                                            Engineroom Simulator Course
                                                            <input type="hidden" name="engineroom_simulator_course" value="Engineroom Simulator Course">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',16, 1)"  type="radio" name="engineroom_simulator_course_dt"  value="1" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('stc',16, 0)"  type="radio" name="engineroom_simulator_course_dt"  value="0" {{(isset($skill[0]->is_Seamans_book_cdc) && ($skill[0]->is_Seamans_book_cdc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="engineroom_simulator_course_status"  class="rb_end_deco_yes stc_16" value="yes" {{ ( isset($skill[0]->arpa_status) && ($skill[0]->engineroom_simulator_course_status == 'yes')) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_Seamans_book_cdc_disabled}} type="radio" name="engineroom_simulator_course_status"  class="rb_end_deco_no stc_16" value="no" {{ ( isset($skill[0]->arpa_status) && ($skill[0]->engineroom_simulator_course_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>                                                    
                                                </tbody>
                                                
                                            </table>
                                            <button type="submit" id="skills_submit" class="btn btn-success btn-primary small-btn">Next</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>
                                */?>

                                <!-- 5-->
                                <div class="panel panel-default" id="personal_tab5">
                                    <div class="panel-heading" role="tab" id="headingFive">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive"  {{($return_tab && $return_tab=="personal_tab") ? ' style="background-color:#03a84e;color:white"' : ''}}  class='{{($return_tab && $return_tab=="personal_tab") ? '' : 'collapsed'}}'> 
                                                Personal Document
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFive" class="panel-collapse {{($return_tab && $return_tab=='personal_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingFive">
                                        @if( session('success') && $return_tab == 'personal_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>{{ session('success') }}
                                            </div>
                                        @endif
                                        <!-- Flash Msg on success-->
                                        @if( session('error')  && $return_tab == 'personal_tab')
                                            <div class="msg alert alert-danger alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Error ! </b>{{ session('error') }}
                                            </div>
                                        @endif
                                        <div class="panel-body">
                                            <form name="personal_doc_form" method='POST' action="{{ route('personaldoc.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="personaldoc_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Doc No</th>
                                                        <th style="width: 50%">Doc Name</th>
                                                        <th style="width: 20%">Do you have it?</th>
                                                        <th style="width: 20%">Is Document valid?</th>            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            Driver License
                                                            <input type="hidden" name="driver_license" value="Driver License">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> 
                                                                    <input onclick="updateValidTable('pd',1, 1)" type="radio" name="is_driver_license"  class="rb_driver_lice_yes" value="1" {{(isset($personal[0]->is_driver_license) && ($personal[0]->is_driver_license == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('pd',1, 0)" type="radio" name="is_driver_license" class="rb_driver_lice_no"  value="0" {{(isset($personal[0]->is_driver_license) && ($personal[0]->is_driver_license == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_driver_license_disabled}} type="radio" name="driver_license_status"  class="rb_end_deco_yes pd_1" value="yes" {{ ( isset($personal[0]->driver_license_status) && ($personal[0]->driver_license_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_driver_license_disabled}} type="radio" name="driver_license_status"  class="rb_end_deco_no pd_1" value="no" {{ ( isset($personal[0]->driver_license_status) && ($personal[0]->driver_license_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                            
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            Photograph
                                                            <input type="hidden" name="photograph" value="Photograph">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  onclick="updateValidTable('pd',2, 1)" type="radio" name="is_photograph" class="rb_photograph_yes" value="1" {{(isset($personal[0]->is_photograph) && ($personal[0]->is_photograph == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('pd',2, 0)" type="radio" name="is_photograph" class="rb_photograph_no" value="0" {{(isset($personal[0]->is_photograph) && ($personal[0]->is_photograph == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_photograph_disabled}} type="radio" name="photograph_status"  class="rb_end_deco_yes pd_2" value="yes" {{ ( isset($personal[0]->photograph_status) && ($personal[0]->photograph_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_photograph_disabled}} type="radio" name="photograph_status"  class="rb_end_deco_no pd_2" value="no" {{ ( isset($personal[0]->photograph_status) && ($personal[0]->photograph_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                        
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            Resume
                                                            <input type="hidden" name="resume" value="Resume">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('pd',3, 1)" type="radio" name="is_resume" class="rb_resume_yes" value="1" {{(isset($personal[0]->is_resume) && ($personal[0]->is_resume == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('pd',3, 0)" type="radio" name="is_resume" class="rb_resume_no" value="0" {{(isset($personal[0]->is_resume) && ($personal[0]->is_resume == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_resume_disabled}} type="radio" name="resume_status"  class="rb_end_deco_yes pd_3" value="yes" {{ ( isset($personal[0]->resume_status) && ($personal[0]->resume_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_resume_disabled}} type="radio" name="resume_status"  class="rb_end_deco_no pd_3" value="no" {{ ( isset($personal[0]->resume_status) && ($personal[0]->resume_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                        
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>4</td>
                                                        <td>
                                                            Other
                                                            <input type="hidden" name="personal_other_docs" value="Peronsal Other">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('pd',4, 1)" type="radio" name="is_personal_other" class="rb_per_otherdocs_yes"  value="1" {{(isset($personal[0]->is_personal_other) && ($personal[0]->is_personal_other == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('pd',4, 0)" type="radio" name="is_personal_other" class="rb_per_otherdocs_no" value="0" {{(isset($personal[0]->is_personal_other) && ($personal[0]->is_personal_other == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>  
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_personal_other_disabled}} type="radio" name="personal_other_docs_status"  class="rb_end_deco_yes pd_4" value="yes" {{ ( isset($personal[0]->personal_other_docs_status) && ($personal[0]->personal_other_docs_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label class="radio-inline"> <input  {{$is_personal_other_disabled}} type="radio" name="personal_other_docs_status"  class="rb_end_deco_no pd_4" value="no" {{ ( isset($personal[0]->personal_other_docs_status) && ($personal[0]->personal_other_docs_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <button type="submit" id="personal_submit" class="btn btn-success btn-primary small-btn">Next</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>

                                <!--6 -->
                                <div class="panel panel-default" id="coc_tab6">
                                    <div class="panel-heading" role="tab" id="headingSix">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix" {{($return_tab && $return_tab=="coc_tab") ? ' style="background-color:#03a84e;color:white"' : ''}} class='{{($return_tab && $return_tab=="coc_tab") ? '' : 'collapsed'}}'>
                                                COC
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseSix" class="panel-collapse  {{($return_tab && $return_tab=='coc_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingSix">
                                        @if( session('success') && $return_tab == 'coc_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>{{ session('success') }}
                                            </div>
                                        @endif
                                        <!-- Flash Msg on success-->
                                        @if( session('error')  && $return_tab == 'coc_tab')
                                            <div class="msg alert alert-danger alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Error ! </b>{{ session('error') }}
                                            </div>
                                        @endif
                                        <div class="panel-body">
                                            <form name="cocdoc_form" method='POST' action="{{ route('cocDocs.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="coc_doc_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Doc No</th>
                                                        <th style="width: 50%">Doc Name</th>
                                                        <th style="width: 20%">Do you have it?</th>
                                                        <th style="width: 20%">Is Document valid?</th>            
                                                    </tr>
                                                </thead>
                                                <tbody>    
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            Master, Unlimited
                                                            <input type="hidden" name="master_unlimited" value="Master, Unlimited">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',2, 1)" type="radio" name="is_master_unlimited" class="rb_masunlimit_yes" value="1" {{(isset($coc[0]->is_master_unlimited) && ($coc[0]->is_master_unlimited == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',2, 0)" type="radio" name="is_master_unlimited" class="rb_masunlimit_no"  value="0" {{(isset($coc[0]->is_master_unlimited) && ($coc[0]->is_master_unlimited == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_master_unlimited_disabled}} type="radio" name="master_unlimited_status"  class="rb_end_deco_yes coc_2" value="yes" {{ ( isset($coc[0]->master_unlimited_status) && ($coc[0]->master_unlimited_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_master_unlimited_disabled}} type="radio" name="master_unlimited_status"  class="rb_end_deco_no coc_2" value="no" {{ ( isset($coc[0]->master_unlimited_status) && ($coc[0]->master_unlimited_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                  
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            Chief Mate, Unlimited
                                                            <input type="hidden" name="chief_mate_unlimited" value="Chief Mate, Unlimited">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',3, 1)" type="radio" name="is_chief_mate_unlimited" class="rb_cmateunli_yes"  value="1" {{(isset($coc[0]->is_chief_mate_unlimited) && ($coc[0]->is_chief_mate_unlimited == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',3, 0)" type="radio" name="is_chief_mate_unlimited"  class="rb_cmateunli_no" value="0" {{(isset($coc[0]->is_chief_mate_unlimited) && ($coc[0]->is_chief_mate_unlimited == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_chief_mate_unlimited_disabled}} type="radio" name="chief_mate_unlimited_status"  class="rb_end_deco_yes coc_3" value="yes" {{ ( isset($coc[0]->chief_mate_unlimited_status) && ($coc[0]->chief_mate_unlimited_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_chief_mate_unlimited_disabled}} type="radio" name="chief_mate_unlimited_status"  class="rb_end_deco_no coc_3" value="no" {{ ( isset($coc[0]->chief_mate_unlimited_status) && ($coc[0]->chief_mate_unlimited_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                             
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            Officers in Charge of a Navigational Watch, Unlimited
                                                            <input type="hidden" name="officers_incharge_navigational_unlimited" value="Officers in Charge of a Navigational Watch, Unlimited">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',1, 1)" type="radio" name="is_officers_incharge_navigational_unlimited" class="rb_officer_nav_watch_yes" value="1" {{(isset($coc[0]->is_officers_incharge_navigational_unlimited) && ($coc[0]->is_officers_incharge_navigational_unlimited == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',1, 0)" type="radio" name="is_officers_incharge_navigational_unlimited"  class="rb_officer_nav_watch_no" value="0" {{(isset($coc[0]->is_officers_incharge_navigational_unlimited) && ($coc[0]->is_officers_incharge_navigational_unlimited == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_officers_incharge_navigational_unlimited_disabled}} type="radio" name="officers_incharge_navigational_unlimited_status"  class="rb_end_deco_yes coc_1" value="yes" {{ ( isset($coc[0]->officers_incharge_navigational_unlimited_status) && ($coc[0]->officers_incharge_navigational_unlimited_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_officers_incharge_navigational_unlimited_disabled}} type="radio" name="officers_incharge_navigational_unlimited_status"  class="rb_end_deco_no coc_1" value="no" {{ ( isset($coc[0]->officers_incharge_navigational_unlimited_status) && ($coc[0]->officers_incharge_navigational_unlimited_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>
                                                            Rating Forming Part of a Navigational Watch
                                                            <input type="hidden" name="rating_forming_part_navigational_watch" value="Rating Forming Part of a Navigational Watch">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',6, 1)" type="radio" name="is_rating_forming_part_navigational_watch"  class="rb_ratingnavwatch_yes" value="1" {{(isset($coc[0]->is_rating_forming_part_navigational_watch) && ($coc[0]->is_rating_forming_part_navigational_watch == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',6, 0)" type="radio" name="is_rating_forming_part_navigational_watch" class="rb_ratingnavwatch_no" value="0" {{(isset($coc[0]->is_rating_forming_part_navigational_watch) && ($coc[0]->is_rating_forming_part_navigational_watch == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_rating_forming_part_navigational_watch_disabled}} type="radio" name="rating_forming_part_navigational_watch_status"  class="rb_end_deco_yes coc_6" value="yes" {{ ( isset($coc[0]->rating_forming_part_navigational_watch_status) && ($coc[0]->rating_forming_part_navigational_watch_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_rating_forming_part_navigational_watch_disabled}} type="radio" name="rating_forming_part_navigational_watch_status"  class="rb_end_deco_no coc_6" value="no" {{ ( isset($coc[0]->rating_forming_part_navigational_watch_status) && ($coc[0]->rating_forming_part_navigational_watch_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                          
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>
                                                            Able Seafarer Deck (COP)
                                                            <input type="hidden" name="able_seafarer_deck" value="Able Seafarer Deck (COP)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',7, 1)" type="radio" name="is_able_seafarer_deck" class="rb_ablsererd_yes" value="1" {{(isset($coc[0]->is_able_seafarer_deck) && ($coc[0]->is_able_seafarer_deck == '1') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',7, 0)" type="radio" name="is_able_seafarer_deck" class="rb_ablsererd_no" value="0" {{(isset($coc[0]->is_able_seafarer_deck) && ($coc[0]->is_able_seafarer_deck == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_able_seafarer_deck_disabled}} type="radio" name="able_seafarer_deck_status"  class="rb_end_deco_yes coc_7" value="yes" {{ ( isset($coc[0]->able_seafarer_deck_status) && ($coc[0]->able_seafarer_deck_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_able_seafarer_deck_disabled}} type="radio" name="able_seafarer_deck_status"  class="rb_end_deco_no coc_7" value="no" {{ ( isset($coc[0]->able_seafarer_deck_status) && ($coc[0]->able_seafarer_deck_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                          
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>
                                                            Masters on Ships of Less Than 500 Gross Tonnage, Near Coastal
                                                            <input type="hidden" name="masters_ships_lessthan_500gt" value="Masters on Ships of Less Than 500 Gross Tonnage, Near Coastal">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',4, 1)" type="radio" name="is_masters_ships_lessthan_500gt"  class="rb_mshiogre500_yes" value="1" {{(isset($coc[0]->is_masters_ships_lessthan_500gt) && ($coc[0]->is_masters_ships_lessthan_500gt == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',4, 0)" type="radio" name="is_masters_ships_lessthan_500gt"  class="rb_mshiogre500_no" value="0" {{(isset($coc[0]->is_masters_ships_lessthan_500gt) && ($coc[0]->is_masters_ships_lessthan_500gt == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_masters_ships_lessthan_500gt_disabled}} type="radio" name="masters_ships_lessthan_500gt_status"  class="rb_end_deco_yes coc_4" value="yes" {{ ( isset($coc[0]->masters_ships_lessthan_500gt_status) && ($coc[0]->masters_ships_lessthan_500gt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_masters_ships_lessthan_500gt_disabled}} type="radio" name="masters_ships_lessthan_500gt_status"  class="rb_end_deco_no coc_4" value="no" {{ ( isset($coc[0]->masters_ships_lessthan_500gt_status) && ($coc[0]->masters_ships_lessthan_500gt_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>7</td>
                                                        <td>
                                                            Officers in Charge of a Navigational Watch on Ships of Less Than 500 Gross Tonnage, Near Coastal
                                                            <input type="hidden" name="officers_charge_navigational_less_500" value="Officers in Charge of a Navigational Watch on Ships of Less Than 500 Gross Tonnage, Near Coastal">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',5, 1)" type="radio" name="is_officers_charge_navigational_less_500"  class="rb_navofficer500_yes" value="1" {{(isset($coc[0]->is_officers_charge_navigational_less_500) && ($coc[0]->is_officers_charge_navigational_less_500 == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',5, 0)" type="radio" name="is_officers_charge_navigational_less_500" class="rb_navofficer500_no" value="0" {{(isset($coc[0]->is_officers_charge_navigational_less_500) && ($coc[0]->is_officers_charge_navigational_less_500 == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_officers_charge_navigational_less_500_disabled}} type="radio" name="officers_charge_navigational_less_500_status"  class="rb_end_deco_yes coc_5" value="yes" {{ ( isset($coc[0]->officers_charge_navigational_less_500_status) && ($coc[0]->officers_charge_navigational_less_500_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_officers_charge_navigational_less_500_disabled}} type="radio" name="officers_charge_navigational_less_500_status"  class="rb_end_deco_no coc_5" value="no" {{ ( isset($coc[0]->officers_charge_navigational_less_500_status) && ($coc[0]->officers_charge_navigational_less_500_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td>
                                                            Chief Engineer Officer
                                                            <input type="hidden" name="chief_engineer_officer" value="Chief Engineer Officer">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',9, 1)" type="radio" name="is_chief_engineer_officer" class="rb_chiefEO_yes" value="1" {{(isset($coc[0]->is_chief_engineer_officer) && ($coc[0]->is_chief_engineer_officer == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',9, 0)" type="radio" name="is_chief_engineer_officer" class="rb_chiefEO_no" value="0" {{(isset($coc[0]->is_chief_engineer_officer) && ($coc[0]->is_chief_engineer_officer == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_chief_engineer_officer_disabled}} type="radio" name="chief_engineer_officer_status"  class="rb_end_deco_yes coc_9" value="yes" {{ ( isset($coc[0]->chief_engineer_officer_status) && ($coc[0]->chief_engineer_officer_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_chief_engineer_officer_disabled}} type="radio" name="chief_engineer_officer_status"  class="rb_end_deco_no coc_9" value="no" {{ ( isset($coc[0]->chief_engineer_officer_status) && ($coc[0]->chief_engineer_officer_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>9</td>
                                                        <td>
                                                            Second Engineer Officer
                                                            <input type="hidden" name="second_engineer_officer" value="Second Engineer Officer">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',10, 1)" type="radio" name="is_second_engineer_officer" class="rb_secEO_yes" value="1" {{(isset($coc[0]->is_second_engineer_officer) && ($coc[0]->is_second_engineer_officer == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',10, 0)" type="radio" name="is_second_engineer_officer" class="rb_secEO_no" value="0" {{(isset($coc[0]->is_second_engineer_officer) && ($coc[0]->is_second_engineer_officer == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_second_engineer_officer_disabled}} type="radio" name="second_engineer_officer_status"  class="rb_end_deco_yes coc_10" value="yes" {{ ( isset($coc[0]->second_engineer_officer_status) && ($coc[0]->second_engineer_officer_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_second_engineer_officer_disabled}} type="radio" name="second_engineer_officer_status"  class="rb_end_deco_no coc_10" value="no" {{ ( isset($coc[0]->second_engineer_officer_status) && ($coc[0]->second_engineer_officer_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                          
                                                        </td>
                                                    </tr> 
                                                    <tr>
                                                        <td>10</td>
                                                        <td>
                                                            Officer in Charge of an Engineering Watch
                                                            <input type="hidden" name="officer_charge_engineering_watch" value="Officer in Charge of an Engineering Watch">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',8, 1)" type="radio" name="is_officer_charge_engineering_watch" class="rb_offwatchin_yes" value="1" {{(isset($coc[0]->is_officer_charge_engineering_watch) && ($coc[0]->is_officer_charge_engineering_watch == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',8, 0)" type="radio" name="is_officer_charge_engineering_watch" class="rb_offwatchin_no" value="0" {{(isset($coc[0]->is_officer_charge_engineering_watch) && ($coc[0]->is_officer_charge_engineering_watch == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_officer_charge_engineering_watch_disabled}} type="radio" name="officer_charge_engineering_watch_status"  class="rb_end_deco_yes coc_8" value="yes" {{ ( isset($coc[0]->officer_charge_engineering_watch_status) && ($coc[0]->officer_charge_engineering_watch_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_officer_charge_engineering_watch_disabled}} type="radio" name="officer_charge_engineering_watch_status"  class="rb_end_deco_no coc_8" value="no" {{ ( isset($coc[0]->officer_charge_engineering_watch_status) && ($coc[0]->officer_charge_engineering_watch_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>11</td>
                                                        <td>
                                                            Rating Forming Part of an Engineering Watch  
                                                            <input type="hidden" name="rating_formingpart_engineering_watch" value="Rating Forming Part of an Engineering Watch">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',11, 1)" type="radio" name="is_rating_formingpart_engineering_watch" class="rb_offwatchin_yes" value="1" {{(isset($coc[0]->is_rating_formingpart_engineering_watch) && ($coc[0]->is_rating_formingpart_engineering_watch == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',11, 0)" type="radio" name="is_rating_formingpart_engineering_watch" class="rb_offwatchin_no" value="0" {{(isset($coc[0]->is_rating_formingpart_engineering_watch) && ($coc[0]->is_rating_formingpart_engineering_watch == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_rating_formingpart_engineering_watch_disabled}} type="radio" name="rating_formingpart_engineering_watch_status"  class="rb_end_deco_yes coc_11" value="yes" {{ ( isset($coc[0]->rating_formingpart_engineering_watch_status) && ($coc[0]->rating_formingpart_engineering_watch_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_rating_formingpart_engineering_watch_disabled}} type="radio" name="rating_formingpart_engineering_watch_status"  class="rb_end_deco_no coc_11" value="no" {{ ( isset($coc[0]->rating_formingpart_engineering_watch_status) && ($coc[0]->rating_formingpart_engineering_watch_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>12</td>
                                                        <td>
                                                            Able Seafarer Engine (COP) 
                                                            <input type="hidden" name="able_seafarer_engine" value="Able Seafarer Engine (COP)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',12, 1)" type="radio" name="is_able_seafarer_engine" class="rb_offwatchin_yes" value="1" {{(isset($coc[0]->is_able_seafarer_engine) && ($coc[0]->is_able_seafarer_engine == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',12, 0)" type="radio" name="is_able_seafarer_engine" class="rb_offwatchin_no" value="0" {{(isset($coc[0]->is_able_seafarer_engine) && ($coc[0]->is_able_seafarer_engine == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_able_seafarer_engine_disabled}} type="radio" name="able_seafarer_engine_status"  class="rb_end_deco_yes coc_12" value="yes" {{ ( isset($coc[0]->able_seafarer_engine_status) && ($coc[0]->able_seafarer_engine_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_able_seafarer_engine_disabled}} type="radio" name="able_seafarer_engine_status"  class="rb_end_deco_no coc_12" value="no" {{ ( isset($coc[0]->able_seafarer_engine_status) && ($coc[0]->able_seafarer_engine_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>13</td>
                                                        <td>
                                                            Chief Engineer Officer and Second Engineer Officer on Ships Between 750 KW and 3000 KW 
                                                            <input type="hidden" name="cef_second_eo_ships_750_3000" value="Chief Engineer Officer and Second Engineer Officer on Ships Between 750 KW and 3000 KW">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',13, 1)" type="radio" name="is_cef_second_eo_ships_750_3000" class="rb_offwatchin_yes" value="1" {{(isset($coc[0]->is_cef_second_eo_ships_750_3000) && ($coc[0]->is_cef_second_eo_ships_750_3000 == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',13, 0)" type="radio" name="is_cef_second_eo_ships_750_3000" class="rb_offwatchin_no" value="0" {{(isset($coc[0]->is_cef_second_eo_ships_750_3000) && ($coc[0]->is_cef_second_eo_ships_750_3000 == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_cef_second_eo_ships_750_3000_disabled}} type="radio" name="cef_second_eo_ships_750_3000_status"  class="rb_end_deco_yes coc_13" value="yes" {{ ( isset($coc[0]->cef_second_eo_ships_750_3000_status) && ($coc[0]->cef_second_eo_ships_750_3000_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_cef_second_eo_ships_750_3000_disabled}} type="radio" name="cef_second_eo_ships_750_3000_status"  class="rb_end_deco_no coc_13" value="no" {{ ( isset($coc[0]->cef_second_eo_ships_750_3000_status) && ($coc[0]->cef_second_eo_ships_750_3000_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>14</td>
                                                        <td>
                                                            Electro-Technical Officer COC 
                                                            <input type="hidden" name="electro_technical_officer" value="Electro-Technical Officer COC">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',14, 1)" type="radio" name="is_electro_technical_officer" class="rb_offwatchin_yes" value="1" {{(isset($coc[0]->is_electro_technical_officer) && ($coc[0]->is_electro_technical_officer == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',14, 0)" type="radio" name="is_electro_technical_officer" class="rb_offwatchin_no" value="0" {{(isset($coc[0]->is_electro_technical_officer) && ($coc[0]->is_electro_technical_officer == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_electro_technical_officer_disabled}} type="radio" name="electro_technical_officer_status"  class="rb_end_deco_yes coc_14" value="yes" {{ ( isset($coc[0]->electro_technical_officer_status) && ($coc[0]->electro_technical_officer_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_electro_technical_officer_disabled}} type="radio" name="electro_technical_officer_status"  class="rb_end_deco_no coc_14" value="no" {{ ( isset($coc[0]->electro_technical_officer_status) && ($coc[0]->electro_technical_officer_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>15</td>
                                                        <td>
                                                            Cook COC
                                                            <input type="hidden" name="cook_coc" value="Cook COC">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',15, 1)" type="radio" name="is_cook_coc" class="rb_offwatchin_yes" value="1" {{(isset($coc[0]->is_cook_coc) && ($coc[0]->is_cook_coc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',15, 0)" type="radio" name="is_cook_coc" class="rb_offwatchin_no" value="0" {{(isset($coc[0]->is_cook_coc) && ($coc[0]->is_cook_coc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_cook_coc_disabled}} type="radio" name="cook_coc_status"  class="rb_end_deco_yes coc_15" value="yes" {{ ( isset($coc[0]->cook_coc_status) && ($coc[0]->cook_coc_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_cook_coc_disabled}} type="radio" name="cook_coc_status"  class="rb_end_deco_no coc_15" value="no" {{ ( isset($coc[0]->cook_coc_status) && ($coc[0]->cook_coc_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>16</td>
                                                        <td>
                                                            GMDSS Radio Operator 
                                                            <input type="hidden" name="gmdss_radio_operator" value="GMDSS Radio Operator">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',16, 1)" type="radio" name="is_gmdss_radio_operator" class="rb_offwatchin_yes" value="1" {{(isset($coc[0]->is_gmdss_radio_operator) && ($coc[0]->is_gmdss_radio_operator == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('coc',16, 0)" type="radio" name="is_gmdss_radio_operator" class="rb_offwatchin_no" value="0" {{(isset($coc[0]->is_gmdss_radio_operator) && ($coc[0]->is_gmdss_radio_operator == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_gmdss_radio_operator_disabled}} type="radio" name="gmdss_radio_operator_status"  class="rb_end_deco_yes coc_16" value="yes" {{ ( isset($coc[0]->gmdss_radio_operator_status) && ($coc[0]->gmdss_radio_operator_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_gmdss_radio_operator_disabled}} type="radio" name="gmdss_radio_operator_status"  class="rb_end_deco_no coc_16" value="no" {{ ( isset($coc[0]->gmdss_radio_operator_status) && ($coc[0]->gmdss_radio_operator_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <button type="submit" id="coc_submit" class="btn btn-success btn-primary small-btn">Next</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>

                                <!--7 -->
                                <div class="panel panel-default" id="STCW_tab7">
                                    <div class="panel-heading" role="tab" id="headingSeven">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven" {{($return_tab && $return_tab=="stcw_tab") ? ' style="background-color:#03a84e;color:white"' : ''}} class='{{($return_tab && $return_tab=="stcw_tab") ? '' : 'collapsed'}}'>
                                                STCW
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseSeven" class="panel-collapse  {{($return_tab && $return_tab=='stcw_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingSeven">
                                        @if($return_tab == 'stcw_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>STCW document details updated.
                                            </div>
                                        @endif

                                        <div class="panel-body">



                                            <form name="stcwdoc_form" method='POST' action="{{ route('stcwdoc.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="stcw_doc_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Doc No</th>
                                                        <th style="width: 50%">Doc Name</th>
                                                        <th style="width: 20%">Do you have it?</th>
                                                        <th style="width: 20%">Is Document valid?</th>            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            Basic Training for Oil and Chemical Tanker Cargo Operations
                                                            <input type="hidden" name="basic_training_chemical_tc_operations" value="Basic Training for Oil and Chemical Tanker Cargo Operations">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',1, 1)" type="radio" name="is_basic_training_chemical_tc_operations" class="rb_btchemitcopr_yes"  value="1" {{(isset($stcw[0]->is_basic_training_chemical_tc_operations) && ($stcw[0]->is_basic_training_chemical_tc_operations == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',1, 0)" type="radio" name="is_basic_training_chemical_tc_operations" class="rb_btchemitcopr_no" value="0" {{(isset($stcw[0]->is_basic_training_chemical_tc_operations) && ($stcw[0]->is_basic_training_chemical_tc_operations == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_basic_training_chemical_tc_operations_disabled}} type="radio" name="basic_training_chemical_tc_operations_status"  class="rb_end_deco_yes STCW_1" value="yes" {{ ( isset($stcw[0]->basic_training_chemical_tc_operations_status) && ($stcw[0]->basic_training_chemical_tc_operations_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_basic_training_chemical_tc_operations_disabled}} type="radio" name="basic_training_chemical_tc_operations_status"  class="rb_end_deco_no STCW_1" value="no" {{ ( isset($stcw[0]->basic_training_chemical_tc_operations_status) && ($stcw[0]->basic_training_chemical_tc_operations_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            Advanced Training for Oil Tanker Cargo Operations
                                                            <input type="hidden" name="advanced_tc_operations" value="Advanced Training for Oil Tanker Cargo Operations">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',2, 1)" type="radio" name="is_advanced_tc_operations" class="rb_atfocaropr_yes"  value="1" {{(isset($stcw[0]->is_advanced_tc_operations) && ($stcw[0]->is_advanced_tc_operations == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',2, 0)" type="radio" name="is_advanced_tc_operations" class="rb_atfocaropr_no" value="0" {{(isset($stcw[0]->is_advanced_tc_operations) && ($stcw[0]->is_advanced_tc_operations == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_advanced_tc_operations_disabled}} type="radio" name="advanced_tc_operations_status"  class="rb_end_deco_yes STCW_2" value="yes" {{ ( isset($stcw[0]->advanced_tc_operations_status) && ($stcw[0]->advanced_tc_operations_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_advanced_tc_operations_disabled}} type="radio" name="advanced_tc_operations_status"  class="rb_end_deco_no STCW_2" value="no" {{ ( isset($stcw[0]->advanced_tc_operations_status) && ($stcw[0]->advanced_tc_operations_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                 
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            Advanced Training for Chemical Tanker Cargo Operations
                                                            <input type="hidden" name="advanced_chemical_tc_operations" value="Advanced Training for Chemical Tanker Cargo Operations">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',3, 1)" type="radio" name="is_advanced_chemical_tc_operations" class="rb_atfortco_yes" value="1" {{(isset($stcw[0]->is_advanced_chemical_tc_operations) && ($stcw[0]->is_advanced_chemical_tc_operations == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',3, 0)" type="radio" name="is_advanced_chemical_tc_operations" class="rb_atfortco_no" value="0" {{(isset($stcw[0]->is_advanced_chemical_tc_operations) && ($stcw[0]->is_advanced_chemical_tc_operations == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_advanced_chemical_tc_operations_disabled}} type="radio" name="advanced_chemical_tc_operations_status"  class="rb_end_deco_yes STCW_3" value="yes" {{ ( isset($stcw[0]->advanced_chemical_tc_operations_status) && ($stcw[0]->advanced_chemical_tc_operations_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_advanced_chemical_tc_operations_disabled}} type="radio" name="advanced_chemical_tc_operations_status"  class="rb_end_deco_no STCW_3" value="no" {{ ( isset($stcw[0]->advanced_chemical_tc_operations_status) && ($stcw[0]->advanced_chemical_tc_operations_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                             
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>4</td>
                                                        <td>
                                                            Basic Training for Liquified Gas Tanker Cargo
                                                            <input type="hidden" name="bt_liquified_gas_tc" value="Basic Training for Liquified Gas Tanker Cargo">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',4, 1)" type="radio" name="is_bt_liquified_gas_tc" class="rb_liquidgsc_yes" value="1" {{(isset($stcw[0]->is_bt_liquified_gas_tc) && ($stcw[0]->is_bt_liquified_gas_tc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',4, 0)" type="radio" name="is_bt_liquified_gas_tc" class="rb_liquidgsc_no" value="0" {{(isset($stcw[0]->is_bt_liquified_gas_tc) && ($stcw[0]->is_bt_liquified_gas_tc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_bt_liquified_gas_tc_disabled}} type="radio" name="bt_liquified_gas_tc_status"  class="rb_end_deco_yes STCW_4" value="yes" {{ ( isset($stcw[0]->bt_liquified_gas_tc_status) && ($stcw[0]->bt_liquified_gas_tc_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_bt_liquified_gas_tc_disabled}} type="radio" name="bt_liquified_gas_tc_status"  class="rb_end_deco_no STCW_4" value="no" {{ ( isset($stcw[0]->bt_liquified_gas_tc_status) && ($stcw[0]->bt_liquified_gas_tc_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>
                                                            Advanced Training for Liquified Gas Tanker Cargo


                                                            <?php //print_r($stcw[0]->is_at_for_liquified_gas_tc);?>
                                                            <input type="hidden" name="at_for_liquified_gas_tc" value="Advanced Training for Liquified Gas Tanker Cargo">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',5, 1)" type="radio" name="is_at_for_liquified_gas_tc" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_at_for_liquified_gas_tc) && ($stcw[0]->is_at_for_liquified_gas_tc == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',5, 0)" type="radio" name="is_at_for_liquified_gas_tc" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_at_for_liquified_gas_tc) && ($stcw[0]->is_at_for_liquified_gas_tc == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_at_for_liquified_gas_tc_disabled}} type="radio" name="at_for_liquified_gas_tc_status"  class="rb_end_deco_yes STCW_5" value="yes" {{ ( isset($stcw[0]->at_for_liquified_gas_tc_status) && ($stcw[0]->at_for_liquified_gas_tc_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_at_for_liquified_gas_tc_disabled}} type="radio" name="at_for_liquified_gas_tc_status"  class="rb_end_deco_no STCW_5" value="no" {{ ( isset($stcw[0]->at_for_liquified_gas_tc_status) && ($stcw[0]->at_for_liquified_gas_tc_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>
                                                            Personal Survival Techniques (PST)

                                                            <input type="hidden" name="pst" value="Personal Survival Techniques (PST)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',6, 1)" type="radio" name="is_pst" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_pst) && ($stcw[0]->is_pst == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',6, 0)" type="radio" name="is_pst" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_pst) && ($stcw[0]->is_pst == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_pst_disabled}} type="radio" name="pst_status"  class="rb_end_deco_yes STCW_6" value="yes" {{ ( isset($stcw[0]->pst_status) && ($stcw[0]->pst_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_pst_disabled}} type="radio" name="pst_status"  class="rb_end_deco_no STCW_6" value="no" {{ ( isset($stcw[0]->pst_status) && ($stcw[0]->pst_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>
                                                            Proficiency in Fire Prevention and Fire Fighting (FPFF)

                                                            <input type="hidden" name="fpff" value="Proficiency in Fire Prevention and Fire Fighting (FPFF)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',7, 1)" type="radio" name="is_fpff" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_fpff) && ($stcw[0]->is_fpff == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',7, 0)" type="radio" name="is_fpff" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_fpff) && ($stcw[0]->is_fpff == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_fpff_disabled}} type="radio" name="fpff_status"  class="rb_end_deco_yes STCW_7" value="yes" {{ ( isset($stcw[0]->fpff_status) && ($stcw[0]->fpff_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_fpff_disabled}} type="radio" name="fpff_status"  class="rb_end_deco_no STCW_7" value="no" {{ ( isset($stcw[0]->fpff_status) && ($stcw[0]->fpff_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td>
                                                            Proficiency in Elementary First Aid (EFA)
                                                            <input type="hidden" name="efa" value="Proficiency in Elementary First Aid (EFA)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',8, 1)" type="radio" name="is_efa" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_efa) && ($stcw[0]->is_efa == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',8, 0)" type="radio" name="is_efa" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_efa) && ($stcw[0]->is_efa == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_efa_disabled}} type="radio" name="efa_status"  class="rb_end_deco_yes STCW_8" value="yes" {{ ( isset($stcw[0]->efa_status) && ($stcw[0]->efa_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_efa_disabled}} type="radio" name="efa_status"  class="rb_end_deco_no STCW_8" value="no" {{ ( isset($stcw[0]->efa_status) && ($stcw[0]->efa_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>9</td>
                                                        <td>
                                                            Proficiency in Personal Safety and Social Responsibilities (PSSR)
                                                            <input type="hidden" name="pssr" value="Proficiency in Personal Safety and Social Responsibilities (PSSR)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',9, 1)" type="radio" name="is_pssr" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_pssr) && ($stcw[0]->is_pssr == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',9, 0)" type="radio" name="is_pssr" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_pssr) && ($stcw[0]->is_pssr == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_pssr_disabled}} type="radio" name="pssr_status"  class="rb_end_deco_yes STCW_9" value="yes" {{ ( isset($stcw[0]->pssr_status) && ($stcw[0]->pssr_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_pssr_disabled}} type="radio" name="pssr_status"  class="rb_end_deco_no STCW_9" value="no" {{ ( isset($stcw[0]->pssr_status) && ($stcw[0]->pssr_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>10</td>
                                                        <td>
                                                            Proficiency in Survival Crafts, Rescue Boats Other Than Fast Rescue Boats (PSCRB)
                                                            <input type="hidden" name="pscrb" value="Proficiency in Survival Crafts, Rescue Boats Other Than Fast Rescue Boats (PSCRB)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',10, 1)" type="radio" name="is_pscrb" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_pscrb) && ($stcw[0]->is_pscrb == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',10, 0)" type="radio" name="is_pscrb" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_pscrb) && ($stcw[0]->is_pscrb == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_pscrb_disabled}} type="radio" name="pscrb_status"  class="rb_end_deco_yes STCW_10" value="yes" {{ ( isset($stcw[0]->pscrb_status) && ($stcw[0]->pscrb_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_pscrb_disabled}} type="radio" name="pscrb_status"  class="rb_end_deco_no STCW_10" value="no" {{ ( isset($stcw[0]->pscrb_status) && ($stcw[0]->pscrb_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>11</td>
                                                        <td>
                                                            Proficiency in Advance Fire Fighting (AFF)
                                                            <input type="hidden" name="aff" value="Proficiency in Advance Fire Fighting (AFF)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',11, 1)" type="radio" name="is_aff" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_aff) && ($stcw[0]->is_aff == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',11, 0)" type="radio" name="is_aff" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_aff) && ($stcw[0]->is_aff == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_aff_disabled}} type="radio" name="aff_status"  class="rb_end_deco_yes STCW_11" value="yes" {{ ( isset($stcw[0]->aff_status) && ($stcw[0]->aff_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_aff_disabled}} type="radio" name="aff_status"  class="rb_end_deco_no STCW_11" value="no" {{ ( isset($stcw[0]->aff_status) && ($stcw[0]->aff_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>12</td>
                                                        <td>
                                                            Proficiency in Medical First Aid (MFA)
                                                            <input type="hidden" name="mfa" value="Proficiency in Medical First Aid (MFA)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',12, 1)" type="radio" name="is_mfa" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_mfa) && ($stcw[0]->is_mfa == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',12, 0)" type="radio" name="is_mfa" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_mfa) && ($stcw[0]->is_mfa == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_mfa_disabled}} type="radio" name="mfa_status"  class="rb_end_deco_yes STCW_12" value="yes" {{ ( isset($stcw[0]->mfa_status) && ($stcw[0]->mfa_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_mfa_disabled}} type="radio" name="mfa_status"  class="rb_end_deco_no STCW_12" value="no" {{ ( isset($stcw[0]->mfa_status) && ($stcw[0]->mfa_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>13</td>
                                                        <td>
                                                            Proficiency in Medical Care
                                                            <input type="hidden" name="proficiency_in_medical_care" value="Proficiency in Medical Care">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',13, 1)" type="radio" name="is_proficiency_in_medical_care" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_proficiency_in_medical_care) && ($stcw[0]->is_proficiency_in_medical_care == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',13, 0)" type="radio" name="is_proficiency_in_medical_care" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_proficiency_in_medical_care) && ($stcw[0]->is_proficiency_in_medical_care == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_proficiency_in_medical_care_disabled}} type="radio" name="proficiency_in_medical_care_status"  class="rb_end_deco_yes STCW_13" value="yes" {{ ( isset($stcw[0]->proficiency_in_medical_care_status) && ($stcw[0]->proficiency_in_medical_care_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_proficiency_in_medical_care_disabled}} type="radio" name="proficiency_in_medical_care_status"  class="rb_end_deco_no STCW_13" value="no" {{ ( isset($stcw[0]->proficiency_in_medical_care_status) && ($stcw[0]->proficiency_in_medical_care_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>14</td>
                                                        <td>
                                                            Ship Security Officer
                                                            <input type="hidden" name="ship_security_officer" value="Ship Security Officer">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',14, 1)" type="radio" name="is_ship_security_officer" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_ship_security_officer) && ($stcw[0]->is_ship_security_officer == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',14, 0)" type="radio" name="is_ship_security_officer" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_ship_security_officer) && ($stcw[0]->is_ship_security_officer == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_ship_security_officer_disabled}} type="radio" name="ship_security_officer_status"  class="rb_end_deco_yes STCW_14" value="yes" {{ ( isset($stcw[0]->ship_security_officer_status) && ($stcw[0]->ship_security_officer_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_ship_security_officer_disabled}} type="radio" name="ship_security_officer_status"  class="rb_end_deco_no STCW_14" value="no" {{ ( isset($stcw[0]->ship_security_officer_status) && ($stcw[0]->ship_security_officer_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>15</td>
                                                        <td>
                                                            Security Training for Seafarers with Designated Security Duties
                                                            <input type="hidden" name="designated_security_duties" value="Security Training for Seafarers with Designated Security Duties">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',15, 1)" type="radio" name="is_designated_security_duties" class="rb_atflgasc_yes"  value="1" {{(isset($stcw[0]->is_designated_security_duties) && ($stcw[0]->is_designated_security_duties == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('STCW',15, 0)" type="radio" name="is_designated_security_duties" class="rb_atflgasc_no" value="0" {{(isset($stcw[0]->is_designated_security_duties) && ($stcw[0]->is_designated_security_duties == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_designated_security_duties_disabled}} type="radio" name="designated_security_duties_status"  class="rb_end_deco_yes STCW_15" value="yes" {{ ( isset($stcw[0]->designated_security_duties_status) && ($stcw[0]->designated_security_duties_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_designated_security_duties_disabled}} type="radio" name="designated_security_duties_status"  class="rb_end_deco_no STCW_15" value="no" {{ ( isset($stcw[0]->designated_security_duties_status) && ($stcw[0]->designated_security_duties_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>       
 
                                                </tbody>
                                            </table>
                                            <button type="submit" id="stcw_submit" class="btn btn-success btn-primary small-btn">Next</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>

                                <!--8 -->
                                <?php /*<div class="panel panel-default" id="offshore_tab8">
                                    <div class="panel-heading" role="tab" id="headingEight">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight" {{($return_tab && $return_tab=="offshore_tab") ? ' style="background-color:#03a84e;color:white"' : ''}} class='{{($return_tab && $return_tab=="offshore_tab") ? '' : 'collapsed'}}'>
                                                Offshore Certification
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseEight" class="panel-collapse  {{($return_tab && $return_tab=='offshore_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingEight">
                                        @if( session('success') && $return_tab == 'offshore_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>{{ session('success') }}
                                            </div>
                                        @endif
                                        <!-- Flash Msg on success-->
                                        @if( session('error')  && $return_tab == 'offshore_tab')
                                            <div class="msg alert alert-danger alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Error ! </b>{{ session('error') }}
                                            </div>
                                        @endif
                                        <div class="panel-body">
                                           <form name="offshore_form" method='POST' action="{{ route('Offshoredoc.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="offshore_doc_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Doc No</th>
                                                        <th>Doc Name</th>
                                                        <th>Do you have it?</th>
                                                        <th>Is Document valid?</th>                                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            AGT0- Authorised Gas Tester Training Level 1
                                                            <input type="hidden" name="agt0" value="AGT0- Authorised Gas Tester Training Level 1">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',1, 1)" type="radio" name="is_agt0" class="rb_AGT0_yes" value="1" {{(isset($offshore[0]->is_agt0) && ($offshore[0]->is_agt0 == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',1, 0)" type="radio" name="is_agt0" class="rb_AGT0_no" value="0" {{(isset($offshore[0]->is_agt0) && ($offshore[0]->is_agt0 == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt0_disabled}} type="radio" name="agt0_status"  class="rb_end_deco_yes OCER_1" value="yes" {{ ( isset($offshore[0]->agt0_status) && ($offshore[0]->agt0_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt0_disabled}} type="radio" name="agt0_status"  class="rb_end_deco_no OCER_1" value="no" {{ ( isset($offshore[0]->agt0_status) && ($offshore[0]->agt0_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                          
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>
                                                            AGT1 (CBT)- Authorised Gas Tester Training Level 1 (CBT) 
                                                            <input type="hidden" name="agtl1_cbt" value="AGT1 (CBT)- Authorised Gas Tester Training Level 1 (CBT)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',2, 1)" type="radio" name="is_agt1_cbt" class="rb_AGT1_yes" value="1" {{(isset($offshore[0]->is_agt1_cbt) && ($offshore[0]->is_agt1_cbt == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',2, 0)" type="radio" name="is_agt1_cbt" class="rb_AGT2_yes" value="0" {{(isset($offshore[0]->is_agt1_cbt) && ($offshore[0]->is_agt1_cbt == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt1_cbt_disabled}} type="radio" name="agtl1_cbt_status"  class="rb_end_deco_yes OCER_2" value="yes" {{ ( isset($offshore[0]->agtl1_cbt_status) && ($offshore[0]->agtl1_cbt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt1_cbt_disabled}} type="radio" name="agtl1_cbt_status"  class="rb_end_deco_no OCER_2" value="no" {{ ( isset($offshore[0]->agtl1_cbt_status) && ($offshore[0]->agtl1_cbt_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>
                                                            AGT1- Authorised Gas Tester Training Level 2
                                                            <input type="hidden" name="agt2" value="Advanced Training for Chemical Tanker Cargo Operations">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',3, 1)" type="radio" name="is_agt2" class="rb_AGT1agtl2_yes" value="1" {{(isset($offshore[0]->is_agt2) && ($offshore[0]->is_agt2 == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',3, 0)" type="radio" name="is_agt2" class="rb_AGT1agtl2_no" value="0" {{(isset($offshore[0]->is_agt2) && ($offshore[0]->is_agt2 == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt2_disabled}} type="radio" name="agt2_status"  class="rb_end_deco_yes OCER_3" value="yes" {{ ( isset($offshore[0]->agt2_status) && ($offshore[0]->agt2_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt2_disabled}} type="radio" name="agt2_status"  class="rb_end_deco_no OCER_3" value="no" {{ ( isset($offshore[0]->agt2_status) && ($offshore[0]->agt2_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                               
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>4</td>
                                                        <td>
                                                            AGT2 (CBT)- Authorised Gas Tester Training Level 2 (CBT)
                                                            <input type="hidden" name="agt2_cbt" value="AGT2 (CBT)- Authorised Gas Tester Training Level 2 (CBT)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',4, 1)" type="radio" name="is_agt2_cbt" class="rb_AGT1cbtagttl2_yes" value="1" {{(isset($offshore[0]->is_agt2_cbt) && ($offshore[0]->is_agt2_cbt == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',4, 0)" type="radio" name="is_agt2_cbt" class="rb_AGT1cbtagttl2_no" value="0" {{(isset($offshore[0]->is_agt2_cbt) && ($offshore[0]->is_agt2_cbt == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt2_cbt_disabled}} type="radio" name="agt2_cbt_status"  class="rb_end_deco_yes OCER_4" value="yes" {{ ( isset($offshore[0]->agt2_cbt_status) && ($offshore[0]->agt2_cbt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt2_cbt_disabled}} type="radio" name="agt2_cbt_status"  class="rb_end_deco_no OCER_4" value="no" {{ ( isset($offshore[0]->agt2_cbt_status) && ($offshore[0]->agt2_cbt_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>
                                                            AGT3 (CBT)- Authorised Gas Tester Training Level 3 (CBT)
                                                            <input type="hidden" name="agt3_cbt" value="AGT2- Authorised Gas Tester Training Level 3">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',5, 1)" type="radio" name="is_agt3_cbt" class="rb_AGT3agttl3_yes" value="1" {{(isset($offshore[0]->is_agt3_cbt) && ($offshore[0]->is_agt3_cbt == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',5, 0)" type="radio" name="is_agt3_cbt" class="rb_AGT3agttl3_no" value="0" {{(isset($offshore[0]->is_agt3_cbt) && ($offshore[0]->is_agt3_cbt == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt3_cbt_disabled}} type="radio" name="agt3_cbt_status"  class="rb_end_deco_yes OCER_5" value="yes" {{ ( isset($offshore[0]->agt3_cbt_status) && ($offshore[0]->agt3_cbt_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_agt3_cbt_disabled}} type="radio" name="agt3_cbt_status"  class="rb_end_deco_no OCER_5" value="no" {{ ( isset($offshore[0]->agt3_cbt_status) && ($offshore[0]->agt3_cbt_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                         
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>
                                                            AMA-ERRV Crew Advanced Medical Aid
                                                            <input type="hidden" name="ama_errv_crew_advanced_medical_aid" value="AMA-ERRV Crew Advanced Medical Aid">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',6, 1)" type="radio" name="is_ama_errv" class="rb_amaerrvmaid_yes" value="1" {{(isset($offshore[0]->is_ama_errv) && ($offshore[0]->is_ama_errv == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',6, 0)" type="radio" name="is_ama_errv" class="rb_amaerrvmaid_no" value="0" {{(isset($offshore[0]->is_ama_errv) && ($offshore[0]->is_ama_errv == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_ama_errv_disabled}} type="radio" name="ama_errv_crew_advanced_medical_aid_status"  class="rb_end_deco_yes OCER_6" value="yes" {{ ( isset($offshore[0]->ama_errv_crew_advanced_medical_aid_status) && ($offshore[0]->ama_errv_crew_advanced_medical_aid_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_ama_errv_disabled}} type="radio" name="ama_errv_crew_advanced_medical_aid_status"  class="rb_end_deco_no OCER_6" value="no" {{ ( isset($offshore[0]->ama_errv_crew_advanced_medical_aid_status) && ($offshore[0]->ama_errv_crew_advanced_medical_aid_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>
                                                            BOAT- Travel Safely by Boat
                                                            <input type="hidden" name="boat_travel_safely_by_boat" value="BOAT- Travel Safely by Boat">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',7, 1)" type="radio" name="is_boat" class="rb_boattsboat_yes" value="1" {{(isset($offshore[0]->is_boat) && ($offshore[0]->is_boat == '1') ) ? 'checked': ''  }}> Yes </label>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',7, 0)" type="radio" name="is_boat" class="rb_boattsboat_no" value="0" {{(isset($offshore[0]->is_boat) && ($offshore[0]->is_boat == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_boat_disabled}} type="radio" name="boat_travel_safely_by_boat_status"  class="rb_end_deco_yes OCER_7" value="yes" {{ ( isset($offshore[0]->boat_travel_safely_by_boat_status) && ($offshore[0]->boat_travel_safely_by_boat_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_boat_disabled}} type="radio" name="boat_travel_safely_by_boat_status"  class="rb_end_deco_no OCER_7" value="no" {{ ( isset($offshore[0]->boat_travel_safely_by_boat_status) && ($offshore[0]->boat_travel_safely_by_boat_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td>
                                                            BOER- Basic Onshore Emergency Response
                                                            <input type="hidden" name="boer_basic_onshore_emergency_response" value="BOER- Basic Onshore Emergency Response">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',8, 1)" type="radio" name="is_boer" class="rb_boer_yes"  value="1" {{(isset($offshore[0]->is_boer) && ($offshore[0]->is_boer == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',8, 0)" type="radio" name="is_boer" class="rb_boer_no" value="0" {{(isset($offshore[0]->is_boer) && ($offshore[0]->is_boer == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_boer_disabled}} type="radio" name="boer_basic_onshore_emergency_response_status"  class="rb_end_deco_yes OCER_8" value="yes" {{ ( isset($offshore[0]->boer_basic_onshore_emergency_response_status) && ($offshore[0]->boer_basic_onshore_emergency_response_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_boer_disabled}} type="radio" name="boer_basic_onshore_emergency_response_status"  class="rb_end_deco_no OCER_8" value="no" {{ ( isset($offshore[0]->boer_basic_onshore_emergency_response_status) && ($offshore[0]->boer_basic_onshore_emergency_response_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                           
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>9</td>
                                                        <td>
                                                            BOSIET (with CA-EBS)- Basic Offshore Safety Induction and Emergency Training (with CA-EBS)
                                                            <input type="hidden" name="bosiet_with_ca_ebs" value="BOSIET (with CA-EBS)- Basic Offshore Safety Induction and Emergency Training (with CA-EBS)">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',9, 1)" type="radio" name="is_bosiet_ca" class="rb_bosiet_caebs_yes" value="1" {{(isset($offshore[0]->is_bosiet_ca) && ($offshore[0]->is_bosiet_ca == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',9, 0)" type="radio" name="is_bosiet_ca" class="rb_bosiet_caebs_no" value="0" {{(isset($offshore[0]->is_bosiet_ca) && ($offshore[0]->is_bosiet_ca == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_bosiet_ca_disabled}} type="radio" name="bosiet_with_ca_ebs_status"  class="rb_end_deco_yes OCER_9" value="yes" {{ ( isset($offshore[0]->bosiet_with_ca_ebs_status) && ($offshore[0]->bosiet_with_ca_ebs_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_bosiet_ca_disabled}} type="radio" name="bosiet_with_ca_ebs_status"  class="rb_end_deco_no OCER_9" value="no" {{ ( isset($offshore[0]->bosiet_with_ca_ebs_status) && ($offshore[0]->bosiet_with_ca_ebs_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>10</td>
                                                        <td>
                                                            BOSIET- Basic Offshore Safety Induction and Emergency Training 
                                                            <input type="hidden" name="bosiet" value="BOSIET- Basic Offshore Safety Induction and Emergency Training">
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',10, 1)" type="radio" name="is_bosiet" class="rb_bosietet_yes" value="1" {{(isset($offshore[0]->is_bosiet) && ($offshore[0]->is_bosiet == '1') ) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input onclick="updateValidTable('OCER',10, 0)" type="radio" name="is_bosiet" class="rb_bosietet_no" value="0" {{(isset($offshore[0]->is_bosiet) && ($offshore[0]->is_bosiet == '0') ) ? 'checked': ''  }}> No </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_bosiet_disabled}} type="radio" name="bosiet_status"  class="rb_end_deco_yes OCER_10" value="yes" {{ ( isset($offshore[0]->bosiet_status) && ($offshore[0]->bosiet_status == 'yes')) ? 'checked': ''  }}> Yes </label>                    
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="radio-inline"> <input  {{$is_bosiet_disabled}} type="radio" name="bosiet_status"  class="rb_end_deco_no OCER_10" value="no" {{ ( isset($offshore[0]->bosiet_status) && ($offshore[0]->bosiet_status == 'no')) ? 'checked': ''  }}> No </label>
                                                            </div>                                                            
                                                        </td>
                                                    </tr> 
                                                </tbody>
                                            </table>
                                            <button type="submit" id="offshore_submit" class="btn btn-success btn-primary small-btn">Next</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>
                                */?>
                               
                                <!--10 -->
                                <div class="panel panel-default" id="other_tab10">
                                    <div class="panel-heading" role="tab" id="headingTen">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseTen" {{($return_tab && $return_tab=="any_other_tab") ? ' style="background-color:#03a84e;color:white"' : ''}} class='{{($return_tab && $return_tab=="any_other_tab") ? '' : 'collapsed'}}'>                                               
                                                others
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTen" class="panel-collapse {{($return_tab && $return_tab=='any_other_tab') ? 'collapse in' : 'collapse'}}" role="tabpanel" aria-labelledby="headingTen">
                                        @if( session('success') && $return_tab == 'any_other_tab')
                                            <div class="msg alert alert-success alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Success ! </b>{{ session('success') }}
                                            </div>
                                        @endif
                                        <!-- Flash Msg on success-->
                                        @if( session('error')  && $return_tab == 'any_other_tab')
                                            <div class="msg alert alert-danger alert-dismissable fade in msg_diplay" style="margin: 1% 0;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <b>Error ! </b>{{ session('error') }}
                                            </div>
                                        @endif
                                        <div class="panel-body">
                                            <form name="other_docs_form" method='POST' action="{{ route('anyotherdoc.save') }}">
                                                @csrf
                                                 <input type="hidden" name="candidate_id" value="{{ $candidate_id }}">
                                                 <!-- <input type="hidden" name="document_type" value="Endorsements"> -->
                                                <table id="other_docs_table" class="table table-striped table-bordered dataTable" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>Doc Name</th>
                                                        <th>Do you have it?</th>
                                                        <th>Is Document valid?</th>
                                                        <th></th>                                    
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php //echo "<pre>";print_R($any_other_docs);

                                                    if(!empty($any_other_docs)){
                                                        $i = 1;
                                                        foreach($any_other_docs as $other_doc){?>
                                                            <tr id="row_<?php echo $i;?>">                        
                                                                <td>               
                                                                    <input type="text" class="form-control" name="doc_name_<?php echo $i;?>" value="<?php echo $other_doc->doc_name;?>" placeholder="Enter Your Document Name">
                                                                </td>
                                                                <td>
                                                                    <div class="col-sm-5">
                                                                        <label class="radio-inline"> <input onclick="updateValidTable('OTHER','<?php echo $i;?>', 1)" type="radio" name="is_doc_name_<?php echo $i;?>" class="radio_otherdoc" value="1" <?php echo (isset($other_doc->is_doc_name) && $other_doc->is_doc_name=="1") ? 'checked' : '';?>> Yes </label>                    
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <label class="radio-inline"> <input onclick="updateValidTable('OTHER','<?php echo $i;?>', 0)" type="radio" name="is_doc_name_<?php echo $i;?>" class="radio_otherdoc" value="0" <?php echo (isset($other_doc->is_doc_name) && $other_doc->is_doc_name=="0") ? 'checked' : '';?>> No </label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-sm-5">
                                                                        <label class="radio-inline"> <input type="radio" name="doc_name_status_<?php echo $i;?>"  class="rb_end_deco_yes OTHER_<?php echo $i;?>" value="yes" <?php echo (isset($other_doc->is_doc_name) && $other_doc->is_doc_name=="0") ? 'disabled="true"' : '';?>  <?php echo (isset($other_doc->is_doc_name) && $other_doc->doc_name_status=="yes") ? 'checked' : '';?>> Yes </label>                    
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <label class="radio-inline"> <input type="radio" name="doc_name_status_<?php echo $i;?>"  class="rb_end_deco_no OTHER_<?php echo $i;?>" value="no" <?php echo (isset($other_doc->is_doc_name) && $other_doc->is_doc_name=="0") ? 'disabled="true"' : '';?> <?php echo (isset($other_doc->is_doc_name) && $other_doc->doc_name_status=="no") ? 'checked' : '';?>> No </label>
                                                                    </div>                              
                                                                </td>
                                                               <td><button type="button" onclick="removeRow(<?php echo $i;?>)" class="btn btn-danger">- Delete</button></td>
                                                            </tr>
                                                            
                                                        <?php 

                                                            $i++;
                                                        }
                                                     }else {
                                                        ?>

                                                        <tr>
                                                            
                                                            <td>               
                                                                <input type="text" class="form-control" name="doc_name_1" value="" placeholder="Enter Your Document Name">
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-5">
                                                                    <label class="radio-inline"> <input onclick="updateValidTable('OTHER',1, 1)" type="radio" name="is_doc_name_1" class="radio_otherdoc" value="1"> Yes </label>                    
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <label class="radio-inline"> <input onclick="updateValidTable('OTHER',1, 0)" type="radio" name="is_doc_name_1" class="radio_otherdoc" value="0" > No </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-5">
                                                                    <label class="radio-inline"> <input type="radio" name="doc_name_status_1"  class="rb_end_deco_yes OTHER_1" value="yes"> Yes </label>                    
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <label class="radio-inline"> <input type="radio" name="doc_name_status_1"  class="rb_end_deco_no OTHER_1" value="no"> No </label>
                                                                </div>                              
                                                            </td>
                                                            <td>
                                                               
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>                                            
                                            <button type="button" id="addmore" class='btn btn-primary'>+ Add More</button>

                                            <input type="hidden" id="counter_val" name="counter_val" value="<?php echo (!empty($any_other_docs) && count($any_other_docs)) ? count($any_other_docs) : 1;?>">

                                            <button type="submit" id="others_submit" class="btn btn-success btn-primary small-btn">Save Docs</button>
                                           </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion end  -->
                        </div>
                    </div>    
                </div>
            </div><!-- End Dashboard body-->
            </div>
        </div>
    </div>
</section>
			<!-- General Detail End -->
@endsection
@section('datepicker')
<script>


    function removeRow(row_count){
        $("#row_"+row_count).remove();
    }
    
    $(document).ready(function () {

      var i= '<?php echo (!empty($any_other_docs) && count($any_other_docs)) ? count($any_other_docs) + 1 : "2"?>';
      $("#addmore").click(function(){

        $("#counter_val").val(i);

        var other_str = 'OTHER';

        var data ='<tr id="row_'+i+'">';
       
        data +='<td><input type="text" class="form-control" name="doc_name_'+i+'" value="" placeholder="Enter Your Document Name"></td>';
        data +='<td><div class="col-sm-5"><label class="radio-inline"> <input onclick="updateValidTable(\'' + other_str + '\','+i+', 1)" type="radio" name="is_doc_name_'+i+'" class="radio_otherdoc" value="1"> Yes </label></div><div class="col-sm-5"><label class="radio-inline"> <input onclick="updateValidTable(\'' + other_str + '\','+i+', 0)" type="radio" name="is_doc_name_'+i+'" class="radio_otherdoc" value="0" > No </label></div></td>';
        data +='<td><div class="col-sm-5"><label class="radio-inline"> <input type="radio" name="doc_name_status_'+i+'" class="rb_end_deco_yes OTHER_'+i+'" value="yes"> Yes </label></div><div class="col-sm-5"><label class="radio-inline"> <input type="radio" name="doc_name_status_'+i+'"  class="rb_end_deco_no OTHER_'+i+'" value="no"> No </label></div></td><td><button type="button" onclick="removeRow('+i+')" class="btn btn-danger">- Delete</button></td>';
        data +='</tr>';
        $('#other_docs_table').append(data);

        
        i++;
    });


        setTimeout(function(){
            $(".msg_diplay").remove();
        }, 5000 );

        $('#endorse_table').DataTable({
            pageLength: 20,
            paging: false,
            info: false,
        });
        $('#traveldoc_table').DataTable({
            pageLength: 20,
            paging: false,
            info: false,
        });
        $('#medicaldoc_table').DataTable({
            pageLength: 20,
            paging: false,
            info: false,
        });
        //$('#skill_trainingdoc_table').DataTable();
        $('#personaldoc_table').DataTable({
            pageLength: 20,
            paging: false,
            info: false,
        });
        $('#coc_doc_table').DataTable({
            pageLength: 20,
            paging: false,
            info: false,
        });
        $('#stcw_doc_table').DataTable({
            pageLength: 20,
            paging: false,
            info: false,
        });
        //$('#offshore_doc_table').DataTable();
        //$('#yacht_doc_table').DataTable();
        $('#other_docs_table').DataTable({
            pageLength: 20,
            paging: false,
            info: false,
        });
        /* Tab hide variables DocCount */
        //'travel', 'medical','skill', 'personal','coc','stcw', 'offshore','yacht','any_other_docs'
        var endoresDocCount = "<?php  echo $endorsDocStatus ?>";
        var travelDocCount = "<?php  echo $travelDocStatus ?>";
        var medicalDocCount = "<?php  echo $medicalDocStatus ?>";        
        //var skillDocCount = "<?php  echo $skillDocStatus ?>";        
        var personalDocCount = "<?php echo $personalDocStatus ?>";
        
        var cocDocCount = "<?php  echo $cocDocStatus ?>";        
        var stcwDocCount = "<?php  echo $stcwDocStatus ?>";        
        //var offshoreDocCount = "<?php  echo $offshoreDocStatus ?>";        
        
        /* Tab hide others */
        
        if(endoresDocCount == 0){ //tab1
            // alert('Endorsement count: '+endoresDocCount);
            $('#travel_tab2').hide();
            $('#medical_tab3').hide();
            $('#satc_tab4').hide();
            $('#personal_tab5').hide();
            $('#coc_tab6').hide();
            $('#STCW_tab7').hide();
            $('#offshore_tab8').hide();
            $('#other_tab10').hide();
        }

        //Endorsement 
        $( "#endors_dec_chemical_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        $('#endors_dec_gas_dt').datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $('#endors_dec_others_dt').datepicker({
           defaultDate: null,
           changeYear: true,
           changeMonth: true,
            yearRange: '1950:2100',
        });
        $('#endors_dec_petroleum_dt').datepicker({
           defaultDate: null,
           changeYear: true,
           changeMonth: true,
            yearRange: '1950:2100',
        });
        $('#endors_others_dt').datepicker({
           defaultDate: null,
           changeYear: true,
           changeMonth: true,
            yearRange: '1950:2100',
        });

        //Travel Docs

        $( "#passport_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        $( "#Seamans_book_cdc_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        $( "#uk_work_permit_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#us_visa_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#others_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        //medical docs
        $( "#drug_alcohol_blood_test_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#seafarers_medical_examination_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#ukooa_medical_fitness_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#yellow_fever_vaccination_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
     
        //skill docs        
        $( "#arpa_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#behaviour_safety_process_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#boatmaster_license_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#bridge_team_management_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#chemical_tankertraining_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#cows_crudeoil_washing_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        

        $( "#crane_operator_certificate_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#dp_induction_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#dp_limited_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#dp_simulator_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        //personal docs 
        $( "#driver_license_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#photograph_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#resume_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#personal_other_docs_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        //coc docs
        $( "#officers_incharge_navigational_unlimited_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#master_unlimited_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#chief_mate_unlimited_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#masters_ships_lessthan_500gt_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#officers_charge_navigational_less_500_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#rating_forming_part_navigational_watch_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#able_seafarer_deck_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#officer_charge_engineering_watch_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#chief_engineer_officer_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#second_engineer_officer_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        //stcw docs
        $( "#basic_training_chemical_tc_operations_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#advanced_tc_operations_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#advanced_chemical_tc_operations_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#bt_liquified_gas_tc_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#at_for_liquified_gas_tc_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#crowd_mgt_training_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#safety_training_for_personnel_providing_ds_dt" ).datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#human_behaviour_training_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#crisis_mgt_human_behaviour_training_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#passenger_cargo_hull_integrity_training_dt ").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#basic_safety_tc_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        //offshore Docs
        $( "#agt0_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#agtl1_cbt_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#agt2_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#agt2_cbt_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#agt3_cbt_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        $( "#ama_errv_crew_advanced_medical_aid_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#boat_travel_safely_by_boat_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#boer_basic_onshore_emergency_response_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#bosiet_with_ca_ebs_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#bosiet_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
       
        //YACHT CERTIFICATION
        $( "#advanced_powerboat_certificate_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        $( "#basic_sea_survival_certificate_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#csy_offshore_certificate_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#ds_certificate_competence_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#ds_shorebased_certificate_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#diveboat_coxswain_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#diesel_engine_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        $( "#diveboat_master_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        $( "#first_aid_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        
        $( "#international_pleasure_craft_certificate_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });

        //any other docs
        $( "#doc_expiry_dt").datepicker({
            defaultDate: null,
            changeYear: true,
            changeMonth: true,
            yearRange: '1950:2100',
        });
        
        
        $("#endorsement_submit").click(function(){
           var edors_dce_val1 = $("input[name='is_endors_name_dec_chemical']:checked").val();
            // alert('edors_dce_val1: ' + edors_dce_val1)
            if(edors_dce_val1 == '1'){
                var edors_dce_isvalid_val1 = $("input[name='endors_dec_chemical_dt_status']:checked").val();
                // alert('edors_dce_isvalid_val1' + edors_dce_isvalid_val1);
                if(!edors_dce_isvalid_val1 || (edors_dce_isvalid_val1 == 'undefined')){
                    alert('Please select DCE - Chemical(Dangerous Cargo Endorsement) document valid or not?');
                    return false;
                }                
            }

            var edors_Gas_dce_val2 = $("input[name='is_endors_name_dec_gas']:checked").val();
            if(edors_Gas_dce_val2 == '1'){
                var edors_Gas_dce_isvalid_val2 = $("input[name='endors_dec_gas_dt_status']:checked").val();
                // alert('edors_Gas_dce_isvalid_val2: ' + edors_Gas_dce_isvalid_val2)
                if(!edors_Gas_dce_isvalid_val2 || (edors_Gas_dce_isvalid_val2 == 'undefined')){
                    alert('Please select DCE - Gas(Dangerous Cargo Endorsement) document valid or not?');
                    return false;
                }                
            }
            // alert('edors_Gas_dce_isvalid_val2: ' + edors_Gas_dce_isvalid_val2)
           
            var edors_Others_dce_val3 = $("input[name='is_endors_name_dec_others']:checked").val();
            if(edors_Others_dce_val3 == '1'){
                var edors_Others_dce_isvalid_val3 = $("input[name='endors_dec_others_dt_status']:checked").val();
                // alert('edors_Others_dce_isvalid_val3: ' + edors_Others_dce_isvalid_val3)
                if(!edors_Others_dce_isvalid_val3 || (edors_Others_dce_isvalid_val3 == 'undefined')){
                    alert('Please select DCE - Others(Dangerous Cargo Endorsement) document valid or not?');
                    return false;
                }                
            }

            var edors_Petroleum_dce_val4 = $("input[name='is_endors_name_dec_petroleum']:checked").val();
            if(edors_Petroleum_dce_val4 == '1'){
                var edors_Petroleum_dce_isvalid_val4 = $("input[name='endors_dec_petroleum_dt_status']:checked").val();
                // alert('edors_Petroleum_dce_isvalid_val4: ' + edors_Petroleum_dce_isvalid_val4)
                if(!edors_Petroleum_dce_isvalid_val4 || (edors_Petroleum_dce_isvalid_val4 == 'undefined')){
                    alert('Please select DCE - Petroleum (Dangerous Cargo Endorsement) document valid or not?');
                    return false;
                }               
            }  

            /*var edors_others_val5 = $("input[name='is_endors_name_others']:checked").val();
            if(edors_others_val5 == '1'){
                var edors_Others_isvalid_val5 = $("input[name='endors_others_dt_status']:checked").val();
                // alert('edors_Petroleum_dce_isvalid_val4: ' + edors_Petroleum_dce_isvalid_val4)
                if(!edors_Others_isvalid_val5 || (edors_Others_isvalid_val5 == 'undefined')){
                    alert('Please select Others document valid or not?');
                    return false;
                }               
            }   */         
        });

        $("#medical_submit").click(function(){            

            var medical_DandB_sTest_val1 = $("input[name='is_drug_alcohol_blood_test']:checked").val();
            // alert('medical_DandB_sTest_val1: '+medical_DandB_sTest_val1)
            if(medical_DandB_sTest_val1 == '1'){
                var medical_drug_alcohol_isvalid_val1 = $("input[name='drug_alcohol_blood_test_status']:checked").val();
                // alert('medical_drug_alcohol_isvalid_val1' + medical_drug_alcohol_isvalid_val1);
                if(!medical_drug_alcohol_isvalid_val1 || (medical_drug_alcohol_isvalid_val1 == 'undefined')){
                    alert('Please select Drug and Alcohol Test / Blood Test document valid or not?');
                    return false;
                }                
            }

            var medical_Seafarer_mediexa_val2 = $("input[name='is_seafarers_medical_examination']:checked").val();
            if(medical_Seafarer_mediexa_val2 == '1'){
                var medical_seafarers_medical_isvalid_val2 = $("input[name='seafarers_medical_examination_status']:checked").val();
                // alert('medical_seafarers_medical_isvalid_val2' + medical_seafarers_medical_isvalid_val2);
                if(!medical_seafarers_medical_isvalid_val2 || (medical_seafarers_medical_isvalid_val2 == 'undefined')){
                    alert("Please select Seafarer's Medical Examination document valid or not?");
                    return false;
                }                
            }

           /* var medical_ukooa_medical_val3 = $("input[name='is_ukooa_medical_fitness']:checked").val();
            if(medical_ukooa_medical_val3 == '1'){
                var medical_ukooa_medical_isvalid_val3 = $("input[name='ukooa_medical_fitness_status']:checked").val();
                // alert('medical_ukooa_medical_isvalid_val3' + medical_ukooa_medical_isvalid_val3);
                if(!medical_ukooa_medical_isvalid_val3 || (medical_ukooa_medical_isvalid_val3 == 'undefined')){
                    alert("Please select UKOOA - Medical Fitness document valid or not?");
                    return false;
                }
            }*/

            var medical_yellow_fever_val4 = $("input[name='is_yellow_fever_vaccination']:checked").val();
            if(medical_yellow_fever_val4 == '1'){
                var medical_yellow_fever_isvalid_val4 = $("input[name='yellow_fever_vaccination_status']:checked").val();
                // alert('medical_yellow_fever_isvalid_val4' + medical_yellow_fever_isvalid_val4);
                if(!medical_yellow_fever_isvalid_val4 || (medical_yellow_fever_isvalid_val4 == 'undefined')){
                    alert("Please select Yellow Fever Vaccination document valid or not?");
                    return false;
                }
            }

          /*  var medical_others_val5 = $("input[name='is_medical_others']:checked").val();
            if(medical_others_val5 == '1'){
                var medical_Others_isvalid_val5 = $("input[name='medical_others_dt_status']:checked").val();
                // alert('edors_Petroleum_dce_isvalid_val4: ' + edors_Petroleum_dce_isvalid_val4)
                if(!medical_Others_isvalid_val5 || (medical_Others_isvalid_val5 == 'undefined')){
                    alert('Please select Others document valid or not?');
                    return false;
                }               
            }  */   
        });

        //Next 3
        $("#travel_submit").click(function(){
            //Row 1
            // var r1_radio_val = $("input[name='endors_dec_chemical_require']:checked").val();
            // var col2_radio_val = $("input[name='endors_dec_chemical_dt_status']:checked").val();
           
            var travel_Passport_val1 = $("input[name='is_passport']:checked").val();
            if(travel_Passport_val1 == '1'){
                var travel_passport_status_isvalid_val1 = $("input[name='passport_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!travel_passport_status_isvalid_val1 || (travel_passport_status_isvalid_val1 == 'undefined')){
                    alert("Please select Passport document valid or not?");
                    return false;
                }
            }

            var travel_Seamans_cdc_val2 = $("input[name='is_Seamans_book_cdc']:checked").val();
            if(travel_Seamans_cdc_val2 == '1'){
                var travel_Seamans_cdc_isvalid_val2 = $("input[name='Seamans_book_cdc_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!travel_Seamans_cdc_isvalid_val2 || (travel_Seamans_cdc_isvalid_val2 == 'undefined')){
                    alert("Please select Seaman's Book/CDC (Continuous Discharge Certificate) document valid or not?");
                    return false;
                }
            }

            /*var travel_uk_work_permit_val3 = $("input[name='is_uk_work_permit']:checked").val();
            if(travel_uk_work_permit_val3 == '1'){
                var travel_uk_work_permit_isvalid_val3 = $("input[name='uk_work_permit_staus']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!travel_uk_work_permit_isvalid_val3 || (travel_uk_work_permit_isvalid_val3 == 'undefined')){
                    alert("Please select UK Work Permit document valid or not?");
                    return false;
                }
            }*/

            var travel_us_visa_val4 = $("input[name='is_uk_visa']:checked").val();
            if(travel_us_visa_val4 == '1'){
                var travel_us_visa_isvalid_val4 = $("input[name='us_visa_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!travel_us_visa_isvalid_val4 || (travel_us_visa_isvalid_val4 == 'undefined')){
                    alert("Please select US Visa document valid or not?");
                    return false;
                }
            }

            /*var travel_other_val4 = $("input[name='is_travel_others']:checked").val();
            if(travel_other_val4 == '1'){
                var travel_others_isvalid_val4 = $("input[name='travel_others_dt_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!travel_others_isvalid_val4 || (travel_others_isvalid_val4 == 'undefined')){
                    alert("Please select Others document valid or not?");
                    return false;
                }
            }*/
        });        

        $("#skills_submit").click(function(){
            var skill_ARPA_val1 = $("input[name='is_arpa']:checked").val();
            if(skill_ARPA_val1 == '1'){
                var skill_ARPA_isvalid_val4 = $("input[name='arpa_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_ARPA_isvalid_val4 || (skill_ARPA_isvalid_val4 == 'undefined')){
                    alert("Please select ARPA document valid or not?");
                    return false;
                }
            }
            var skill_BBSP_val2 = $("input[name='is_bbsp']:checked").val();
            if(skill_BBSP_val2 == '1'){
                var skill_BBSP_isvalid_val2 = $("input[name='behaviour_safety_process_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_BBSP_isvalid_val2 || (skill_BBSP_isvalid_val2 == 'undefined')){
                    alert("Please select Behaviour Based Safety Process document valid or not?");
                    return false;
                }
            }

            var skill_Boatmaste_val3 = $("input[name='is_bl']:checked").val();
            if(skill_Boatmaste_val3 == '1'){
                var skill_Boatmaste_isvalid_val3 = $("input[name='boatmaster_license_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_Boatmaste_isvalid_val3 || (skill_Boatmaste_isvalid_val3 == 'undefined')){
                    alert("Please select Boatmaster License document valid or not?");
                    return false;
                }
            }

            var skill_Bridge_team_val4 = $("input[name='is_btm']:checked").val();
            if(skill_Bridge_team_val4 == '1'){
                var skill_Bridge_team_isvalid_val4 = $("input[name='bridge_team_management_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_Bridge_team_isvalid_val4 || (skill_Bridge_team_isvalid_val4 == 'undefined')){
                    alert("Please select Bridge Team Management document valid or not?");
                    return false;
                }
            }

            var skill_chemical_tanker_val5 = $("input[name='is_ctt']:checked").val();
            if(skill_chemical_tanker_val5 == '1'){
                var skill_chemical_tanker_isvalid_val5 = $("input[name='chemical_tankertraining_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_chemical_tanker_isvalid_val5 || (skill_chemical_tanker_isvalid_val5 == 'undefined')){
                    alert("Please select Chemical Tanker Training document valid or not?");
                    return false;
                }
            }

            var skill_cows_crudeoil_val6 = $("input[name='is_ccow']:checked").val();
            if(skill_cows_crudeoil_val6 == '1'){
                var skill_cows_crudeoil_isvalid_val6 = $("input[name='cows_crudeoil_washing_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_cows_crudeoil_isvalid_val6 || (skill_cows_crudeoil_isvalid_val6 == 'undefined')){
                    alert("Please select COWS - Crude Oil Washing document valid or not?");
                    return false;
                }
            }

            var skill_crane_operator_val7 = $("input[name='is_coc']:checked").val();
            if(skill_crane_operator_val7 == '1'){
                var skill_crane_operator_isvalid_val7 = $("input[name='crane_operator_certificate_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_crane_operator_isvalid_val7 || (skill_crane_operator_isvalid_val7 == 'undefined')){
                    alert("Please select Crane Operator Certificate document valid or not?");
                    return false;
                }
            }

            var skill_dp_induction_val8 = $("input[name='is_induction']:checked").val();
            if(skill_dp_induction_val8 == '1'){
                var skill_dp_induction_isvalid_val8 = $("input[name='dp_induction_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_dp_induction_isvalid_val8 || (skill_dp_induction_isvalid_val8 == 'undefined')){
                    alert("Please select DP - Induction document valid or not?");
                    return false;
                }
            }

            var skill_dp_limited_val9 = $("input[name='is_limited']:checked").val();
            if(skill_dp_limited_val9 == '1'){
                var skill_dp_limited_isvalid_val9 = $("input[name='dp_limited_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_dp_limited_isvalid_val9 || (skill_dp_limited_isvalid_val9 == 'undefined')){
                    alert("Please select DP - Limited document valid or not?");
                    return false;
                }
            }

            var skill_dp_limited_val10 = $("input[name='is_simulator']:checked").val();
            if(skill_dp_limited_val10 == '1'){
                var skill_dp_limited_isvalid_val10 = $("input[name='dp_simulator_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!skill_dp_limited_isvalid_val10 || (skill_dp_limited_isvalid_val10 == 'undefined')){
                    alert("Please select DP - Simulator document valid or not?");
                    return false;
                }
            }
        });

        $("#personal_submit").click(function(){            

            var personal_driver_license_val1 = $("input[name='is_driver_license']:checked").val();
            if(personal_driver_license_val1 == '1'){
                var personal_driver_license_isvalid_val1 = $("input[name='driver_license_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!personal_driver_license_isvalid_val1 || (personal_driver_license_isvalid_val1 == 'undefined')){
                    alert("Please select Driver License document valid or not?");
                    return false;
                }
            }

            var personal_photograph_val2 = $("input[name='is_photograph']:checked").val();
            if(personal_photograph_val2 == '1'){
                var personal_photograph_isvalid_val2 = $("input[name='photograph_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!personal_photograph_isvalid_val2 || (personal_photograph_isvalid_val2 == 'undefined')){
                    alert("Please select Photograph document valid or not?");
                    return false;
                }
            }

            var personal_resume_val3 = $("input[name='is_resume']:checked").val();
            if(personal_resume_val3 == '1'){
                var personal_resume_val3 = $("input[name='resume_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!personal_resume_val3 || (personal_resume_val3 == 'undefined')){
                    alert("Please select Resume document valid or not?");
                    return false;
                }
            }
            
            var personal_personal_other_val4 = $("input[name='is_personal_other']:checked").val();
            if(personal_personal_other_val4 == '1'){
                var personal_personal_other_val4 = $("input[name='personal_other_docs_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!personal_personal_other_val4 || (personal_personal_other_val4 == 'undefined')){
                    alert("Please select Peronsal Other document valid or not?");
                    return false;
                }
            }
        });

        $("#coc_submit").click(function(){            

            var coc_officers_incharge_val1 = $("input[name='is_officers_incharge_navigational_unlimited']:checked").val();
            if(coc_officers_incharge_val1 == '1'){
                var coc_officers_incharge_isvalid_val1 = $("input[name='officers_incharge_navigational_unlimited_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!coc_officers_incharge_isvalid_val1 || (coc_officers_incharge_isvalid_val1 == 'undefined')){
                    alert("Please select Officers In Charge of a Navigational Watch document valid or not?");
                    return false;
                }
            }

            var coc_master_unlimited_val2 = $("input[name='is_master_unlimited']:checked").val();
            // alert('coc_master_unlimited_val2: '+coc_master_unlimited_val2);
            if(coc_master_unlimited_val2 == '1'){
                var coc_master_unlimited_isvalid_val2 = $("input[name='master_unlimited_status']:checked").val();
                // alert('coc_master_unlimited_isvalid_val2: ' + coc_master_unlimited_isvalid_val2);
                if(!coc_master_unlimited_isvalid_val2 || (coc_master_unlimited_isvalid_val2 == 'undefined')){
                    alert("Please select Master Unlimited document valid or not?");
                    return false;
                }
            }

            var coc_chief_mate_val3 = $("input[name='is_chief_mate_unlimited']:checked").val();
            if(coc_chief_mate_val3 == '1'){
                var coc_chief_mate_isvalid_val3 = $("input[name='chief_mate_unlimited_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!coc_chief_mate_isvalid_val3 || (coc_chief_mate_isvalid_val3 == 'undefined')){
                    alert("Please select Chief Mate Unlimited document valid or not?");
                    return false;
                }
            }

            var coc_masters_ships_val4 = $("input[name='is_masters_ships_lessthan_500gt']:checked").val();
            if(coc_masters_ships_val4 == '1'){
                var coc_masters_ships_isvalid_val4 = $("input[name='masters_ships_lessthan_500gt_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!coc_masters_ships_isvalid_val4 || (coc_masters_ships_isvalid_val4 == 'undefined')){
                    alert("Please select Masters On Ships Of Less Than 500 Gross Tonnage document valid or not?");
                    return false;
                }
            }

            var coc_officers_charge_nav_val5 = $("input[name='is_officers_charge_navigational_less_500']:checked").val();
            if(coc_officers_charge_nav_val5 == '1'){
                var coc_officers_charge_nav_isvalid_val5 = $("input[name='officers_charge_navigational_less_500_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!coc_officers_charge_nav_isvalid_val5 || (coc_officers_charge_nav_isvalid_val5 == 'undefined')){
                    alert("Please select Officers In Charge of a Navigational Watch on Ships of Less Than 500 Gross Tonnage document valid or not?");
                    return false;
                }
            }

            var coc_rating_forming_val6 = $("input[name='is_rating_forming_part_navigational_watch']:checked").val();
            if(coc_rating_forming_val6 == '1'){
                var coc_rating_forming_isvalid_val6 = $("input[name='rating_forming_part_navigational_watch_status']:checked").val();
                // alert('travel_yellow_fever_isvalid_val4' + travel_yellow_fever_isvalid_val4);
                if(!coc_rating_forming_isvalid_val6 || (coc_rating_forming_isvalid_val6 == 'undefined')){
                    alert("Please select Rating Forming Part Of A Navigational Watch document valid or not?");
                    return false;
                }
            }

            var coc_able_seafarer_val7 = $("input[name='is_able_seafarer_deck']:checked").val();
            if(coc_able_seafarer_val7 == '1'){
                var coc_able_seafarer_isvalid_val2 = $("input[name='able_seafarer_deck_status']:checked").val();
                if(!coc_able_seafarer_isvalid_val2 || (coc_able_seafarer_isvalid_val2 == 'undefined')){
                    alert("Please select Able Seafarer Deck document valid or not?");
                    return false;
                }
            }

            var coc_officer_charge_val8 = $("input[name='is_officer_charge_engineering_watch']:checked").val();
            if(coc_officer_charge_val8 == '1'){
                var coc_officer_charge_isvalid_val8 = $("input[name='officer_charge_engineering_watch_status']:checked").val();
                if(!coc_officer_charge_isvalid_val8 || (coc_officer_charge_isvalid_val8 == 'undefined')){
                    alert("Please select Officer In Charge Of An Engineering Watch document valid or not?");
                    return false;
                }
            }

            var coc_chief_engineer_val9 = $("input[name='is_chief_engineer_officer']:checked").val();
            if(coc_chief_engineer_val9 == '1'){
                var coc_chief_engineer_isvalid_val9 = $("input[name='chief_engineer_officer_status']:checked").val();
                if(!coc_chief_engineer_isvalid_val9 || (coc_chief_engineer_isvalid_val9 == 'undefined')){
                    alert("Please select Chief Engineer Officer document valid or not?");
                    return false;
                }
            }

            var coc_second_engineer_val10 = $("input[name='is_second_engineer_officer']:checked").val();
            if(coc_second_engineer_val10 == '1'){
                var coc_second_engineer_isvalid_val10 = $("input[name='second_engineer_officer_status']:checked").val();
                if(!coc_second_engineer_isvalid_val10 || (coc_second_engineer_isvalid_val10 == 'undefined')){
                    alert("Please select Second Engineer Officer document valid or not?");
                    return false;
                }
            }

            var is_rating_formingpart_engineering_watch = $("input[name='is_rating_formingpart_engineering_watch']:checked").val();
            if(is_rating_formingpart_engineering_watch == '1'){
                var rating_formingpart_engineering_watch_status = $("input[name='rating_formingpart_engineering_watch_status']:checked").val();
                if(!rating_formingpart_engineering_watch_status || (rating_formingpart_engineering_watch_status == 'undefined')){
                    alert("Please select Rating Forming Part of an Engineering Watch document valid or not?");
                    return false;
                }
            }

            var is_able_seafarer_engine = $("input[name='is_able_seafarer_engine']:checked").val();
            if(is_able_seafarer_engine == '1'){
                var able_seafarer_engine_status = $("input[name='able_seafarer_engine_status']:checked").val();
                if(!able_seafarer_engine_status || (able_seafarer_engine_status == 'undefined')){
                    alert("Please select Able Seafarer Engine (COP) document valid or not?");
                    return false;
                }
            }

            var is_cef_second_eo_ships_750_3000 = $("input[name='is_cef_second_eo_ships_750_3000']:checked").val();
            if(is_cef_second_eo_ships_750_3000 == '1'){
                var cef_second_eo_ships_750_3000_status = $("input[name='cef_second_eo_ships_750_3000_status']:checked").val();
                if(!cef_second_eo_ships_750_3000_status || (cef_second_eo_ships_750_3000_status == 'undefined')){
                    alert("Please select Chief Engineer Officer and Second Engineer Officer on Ships Between 750 KW and 3000 KW document valid or not?");
                    return false;
                }
            }

            var is_electro_technical_officer = $("input[name='is_electro_technical_officer']:checked").val();
            if(is_electro_technical_officer == '1'){
                var electro_technical_officer_status = $("input[name='electro_technical_officer_status']:checked").val();
                if(!electro_technical_officer_status || (electro_technical_officer_status == 'undefined')){
                    alert("Please select Electro-Technical Officer COC document valid or not?");
                    return false;
                }
            }

            var is_cook_coc = $("input[name='is_cook_coc']:checked").val();
            if(is_cook_coc == '1'){
                var cook_coc_status = $("input[name='cook_coc_status']:checked").val();
                if(!cook_coc_status || (cook_coc_status == 'undefined')){
                    alert("Please select Cook COC document valid or not?");
                    return false;
                }
            }

            var is_gmdss_radio_operator = $("input[name='is_gmdss_radio_operator']:checked").val();
            if(is_gmdss_radio_operator == '1'){
                var gmdss_radio_operator_status = $("input[name='gmdss_radio_operator_status']:checked").val();
                if(!gmdss_radio_operator_status || (gmdss_radio_operator_status == 'undefined')){
                    alert("Please select GMDSS Radio Operator document valid or not?");
                    return false;
                }
            }
        });
        
        $("#stcw_submit").click(function(){
            var stcw_basic_training_val1 = $("input[name='is_basic_training_chemical_tc_operations']:checked").val();
            if(stcw_basic_training_val1 == '1'){
                var stcw_basic_training_isvalid_val1 = $("input[name='basic_training_chemical_tc_operations_status']:checked").val();
                if(!stcw_basic_training_isvalid_val1 || (stcw_basic_training_isvalid_val1 == 'undefined')){
                    alert("Please select Basic Training for Oil and Chemical Tanker Cargo Operations document valid or not?");
                    return false;
                }
            }

            var stcw_advanced_tc_val2 = $("input[name='is_advanced_tc_operations']:checked").val();
            if(stcw_advanced_tc_val2 == '1'){
                var stcw_advanced_tc_isvalid_val2 = $("input[name='advanced_tc_operations_status']:checked").val();
                if(!stcw_advanced_tc_isvalid_val2 || (stcw_advanced_tc_isvalid_val2 == 'undefined')){
                    alert("Please select Advanced Training for Oil Tanker Cargo Operations document valid or not?");
                    return false;
                }
            }

            var stcw_advanced_chemical_val3 = $("input[name='is_advanced_chemical_tc_operations']:checked").val();
            if(stcw_advanced_chemical_val3 == '1'){
                var stcw_advanced_chemical_val3 = $("input[name='advanced_chemical_tc_operations_status']:checked").val();
                if(!stcw_advanced_chemical_val3 || (stcw_advanced_chemical_val3 == 'undefined')){
                    alert("Please select Advanced Training for Chemical Tanker Cargo Operations document valid or not?");
                    return false;
                }
            }

            var stcw_bt_liquified_val4 = $("input[name='is_bt_liquified_gas_tc']:checked").val();
            if(stcw_bt_liquified_val4 == '1'){
                var stcw_bt_liquified_isvalid_val4 = $("input[name='bt_liquified_gas_tc_status']:checked").val();
                if(!stcw_bt_liquified_isvalid_val4 || (stcw_bt_liquified_isvalid_val4 == 'undefined')){
                    alert("Please select Basic Training for Liquified Gas Tanker Cargo document valid or not?");
                    return false;
                }
            }
            
            var stcw_at_for_liquified_val5 = $("input[name='is_at_for_liquified_gas_tc']:checked").val();
            if(stcw_at_for_liquified_val5 == '1'){
                var stcw_at_for_liquified_isvalid_val5 = $("input[name='at_for_liquified_gas_tc_status']:checked").val();
                if(!stcw_at_for_liquified_isvalid_val5 || (stcw_at_for_liquified_isvalid_val5 == 'undefined')){
                    alert("Please select Advanced Training for Liquified Gas Tanker Cargo document valid or not?");
                    return false;
                }
            }

            var stcw_pst_6 = $("input[name='is_pst']:checked").val();
            if(stcw_pst_6 == '1'){
                var pst_status = $("input[name='pst_status']:checked").val();
                if(!pst_status || (pst_status == 'undefined')){
                    alert("Please select Personal Survival Techniques (PST) document valid or not?");
                    return false;
                }
            }

            var stcw_fpff_7 = $("input[name='is_fpff']:checked").val();
            if(stcw_fpff_7 == '1'){
                var fpff_status = $("input[name='fpff_status']:checked").val();
                if(!fpff_status || (fpff_status == 'undefined')){
                    alert("Please select Proficiency in Fire Prevention and Fire Fighting (FPFF) document valid or not?");
                    return false;
                }
            }

            var stcw_efa_8 = $("input[name='is_efa']:checked").val();
            if(stcw_efa_8 == '1'){
                var efa_status = $("input[name='efa_status']:checked").val();
                if(!efa_status || (efa_status == 'undefined')){
                    alert("Please select Proficiency in Elementary First Aid (EFA) document valid or not?");
                    return false;
                }
            }

            var stcw_pssr_9 = $("input[name='is_pssr']:checked").val();
            if(stcw_pssr_9 == '1'){
                var pssr_status = $("input[name='pssr_status']:checked").val();
                if(!pssr_status || (pssr_status == 'undefined')){
                    alert("Please select Proficiency in Personal Safety and Social Responsibilities (PSSR) document valid or not?");
                    return false;
                }
            }

            var stcw_pscrb_10 = $("input[name='is_pscrb']:checked").val();
            if(stcw_pscrb_10 == '1'){
                var pscrb_status = $("input[name='pscrb_status']:checked").val();
                if(!pscrb_status || (pscrb_status == 'undefined')){
                    alert("Please select Proficiency in Survival Crafts, Rescue Boats Other Than Fast Rescue Boats (PSCRB) document valid or not?");
                    return false;
                }
            }

            var stcw_aff_11 = $("input[name='is_aff']:checked").val();
            if(stcw_aff_11 == '1'){
                var aff_status = $("input[name='aff_status']:checked").val();
                if(!aff_status || (aff_status == 'undefined')){
                    alert("Please select Proficiency in Advance Fire Fighting (AFF) document valid or not?");
                    return false;
                }
            }

            var stcw_mfa_12 = $("input[name='is_mfa']:checked").val();
            if(stcw_mfa_12 == '1'){
                var mfa_status = $("input[name='mfa_status']:checked").val();
                if(!mfa_status || (mfa_status == 'undefined')){
                    alert("Please select Proficiency in Medical First Aid (MFA) document valid or not?");
                    return false;
                }
            }

            var stcw_proficiency_in_medical_care_13 = $("input[name='is_proficiency_in_medical_care']:checked").val();
            if(stcw_proficiency_in_medical_care_13 == '1'){
                var proficiency_in_medical_care_status = $("input[name='proficiency_in_medical_care_status']:checked").val();
                if(!proficiency_in_medical_care_status || (proficiency_in_medical_care_status == 'undefined')){
                    alert("Please select Proficiency in Medical Care document valid or not?");
                    return false;
                }
            }

            var stcw_ship_security_officer_14 = $("input[name='is_ship_security_officer']:checked").val();
            if(stcw_ship_security_officer_14 == '1'){
                var ship_security_officer_status = $("input[name='ship_security_officer_status']:checked").val();
                if(!ship_security_officer_status || (ship_security_officer_status == 'undefined')){
                    alert("Please select Ship Security Officer document valid or not?");
                    return false;
                }
            }

            var stcw_pst_15 = $("input[name='is_designated_security_duties']:checked").val();
            if(stcw_pst_15 == '1'){
                var pst_status = $("input[name='designated_security_duties_status']:checked").val();
                if(!pst_status || (pst_status == 'undefined')){
                    alert("Please select Security Training for Seafarers with Designated Security Duties document valid or not?");
                    return false;
                }
            }

            /*var stcw_crowd_mgt_val6 = $("input[name='is_crowd_mgt_training']:checked").val();
            if(stcw_crowd_mgt_val6 == '1'){
                var stcw_crowd_mgt_isvalid_val6 = $("input[name='crowd_mgt_training_status']:checked").val();
                if(!stcw_crowd_mgt_isvalid_val6 || (stcw_crowd_mgt_isvalid_val6 == 'undefined')){
                    alert("Please select Crowd Managemnet Training document valid or not?");
                    return false;
                }
            }

            var stcw_crowd_mgt_val7 = $("input[name='is_safety_training_for_personnel_providing_ds']:checked").val();
            if(stcw_crowd_mgt_val7 == '1'){
                var stcw_crowd_mgt_isvalid_val7 = $("input[name='safety_training_for_personnel_providing_ds_status']:checked").val();
                if(!stcw_crowd_mgt_isvalid_val7 || (stcw_crowd_mgt_isvalid_val7 == 'undefined')){
                    alert("Please select Safety Training for Personnel Providing Direct Service to Passengers in Passenger Spaces document valid or not?");
                    return false;
                }
            }

            var stcw_crisis_mgt_val8 = $("input[name='is_crisis_mgt_human_behaviour_training']:checked").val();
            // alert('stcw_crisis_mgt_val8: '+stcw_crisis_mgt_val8)
            if(stcw_crisis_mgt_val8 == '1'){
                var stcw_crowd_mgt_isvalid_val8 = $("input[name='crisis_mgt_human_behaviour_training_status']:checked").val();
                // alert('stcw_crowd_mgt_isvalid_val8: '+stcw_crowd_mgt_isvalid_val8)
                if(!stcw_crowd_mgt_isvalid_val8 || (stcw_crowd_mgt_isvalid_val8 == 'undefined')){
                    alert("Please select Crisis Management and Human Behaviour Training document valid or not?");
                    return false;
                }
            }

            var stcw_passenger_cargo_val9 = $("input[name='is_passenger_cargo_hull_integrity_training']:checked").val();
            if(stcw_passenger_cargo_val9 == '1'){
                var stcw_passenger_cargo_isvalid_val9 = $("input[name='passenger_cargo_hull_integrity_training_status']:checked").val();
                if(!stcw_passenger_cargo_isvalid_val9 || (stcw_passenger_cargo_isvalid_val9 == 'undefined')){
                    alert("Please select Passenger Safety, Cargo Safety and Hull Integrity Training document valid or not?");
                    return false;
                }
            }

            var stcw_basic_safety_val10 = $("input[name='is_basic_safety_tc']:checked").val();
            if(stcw_basic_safety_val10 == '1'){
                var stcw_basic_safety_isvalid_val10 = $("input[name='basic_safety_tc_status']:checked").val();
                if(!stcw_basic_safety_isvalid_val10 || (stcw_basic_safety_isvalid_val10 == 'undefined')){
                    alert("Please select Basic Safety Training Certificate document valid or not?");
                    return false;
                }
            }*/
        });

        $("#offshore_submit").click(function(){
            var offshore_agt0_dt_val1 = $("input[name='is_agt0']:checked").val();
            if(offshore_agt0_dt_val1 == '1'){
                var offshore_agt0_isvalid_val1 = $("input[name='agt0_status']:checked").val();
                if(!offshore_agt0_isvalid_val1 || (offshore_agt0_isvalid_val1 == 'undefined')){
                    alert("Please select AGT0- Authorised Gas Tester Training Level 1 document valid or not?");
                    return false;
                }
            }

            var offshore_agtl1_cbt_val2 = $("input[name='is_agt1_cbt']:checked").val();
            if(offshore_agtl1_cbt_val2 == '1'){
                var offshore_agtl1_cbt_isvalid_val2 = $("input[name='agtl1_cbt_status']:checked").val();
                if(!offshore_agtl1_cbt_isvalid_val2 || (offshore_agtl1_cbt_isvalid_val2 == 'undefined')){
                    alert("Please select AGT1 (CBT)- Authorised Gas Tester Training Level 1 (CBT) document valid or not?");
                    return false;
                }
            }

            var offshore_agt2_val3 = $("input[name='is_agt2']:checked").val();
            if(offshore_agt2_val3 == '1'){
                var offshore_agtl2_isvalid_val3 = $("input[name='agt2_status']:checked").val();
                if(!offshore_agtl2_isvalid_val3 || (offshore_agtl2_isvalid_val3 == 'undefined')){
                    alert("Please select AGT1- Authorised Gas Tester Training Level 2 document valid or not?");
                    return false;
                }
            }

            var offshore_agt2_cbt_val4 = $("input[name='is_agt2_cbt']:checked").val();
            if(offshore_agt2_cbt_val4 == '1'){
                var offshore_agt2_cbt_isvalid_val4 = $("input[name='agt2_cbt_status']:checked").val();
                if(!offshore_agt2_cbt_isvalid_val4 || (offshore_agt2_cbt_isvalid_val4 == 'undefined')){
                    alert("Please select AGT2 (CBT)- Authorised Gas Tester Training Level 2 (CBT) document valid or not?");
                    return false;
                }
            }

            var offshore_agt3_cbt_val5 = $("input[name='is_agt3_cbt']:checked").val();
            if(offshore_agt3_cbt_val5 == '1'){
                var offshore__agt3_cbt_isvalid_val5 = $("input[name='agt3_cbt_status']:checked").val();
                if(!offshore__agt3_cbt_isvalid_val5 || (offshore__agt3_cbt_isvalid_val5 == 'undefined')){
                    alert("Please select AGT3 (CBT)- Authorised Gas Tester Training Level 3 (CBT) document valid or not?");
                    return false;
                }
            }

            var offshore_ama_errv_crew_val6 = $("input[name='is_ama_errv']:checked").val();
            if(offshore_ama_errv_crew_val6 == '1'){
                var offshore_ama_errv_crew_isvalid_val6 = $("input[name='ama_errv_crew_advanced_medical_aid_status']:checked").val();
                if(!offshore_ama_errv_crew_isvalid_val6 || (offshore_ama_errv_crew_isvalid_val6 == 'undefined')){
                    alert("Please select AMA-ERRV Crew Advanced Medical Aid document valid or not?");
                    return false;
                }
            }

            var offshore_boat_travel_val7 = $("input[name='is_boat']:checked").val();
            if(offshore_boat_travel_val7 == '1'){
                var offshore_boat_travel_isvalid_val7 = $("input[name='boat_travel_safely_by_boat_status']:checked").val();
                
                if(!offshore_boat_travel_isvalid_val7 || (offshore_boat_travel_isvalid_val7 == 'undefined')){
                    alert("Please select BOAT- Travel Safely by Boat document valid or not?");
                    return false;
                }
            }

            var offshore_boer_basic_val8 = $("input[name='is_boer']:checked").val();
            if(offshore_boer_basic_val8 == '1'){
                var offshore_boer_basic_isvalid_val8 = $("input[name='boer_basic_onshore_emergency_response_status']:checked").val();
                if(!offshore_boer_basic_isvalid_val8 || (offshore_boer_basic_isvalid_val8 == 'undefined')){
                    alert("Please select BOER- Basic Onshore Emergency Response document valid or not?");
                    return false;
                }
            }

            var offshore_bosiet_ebs_val9 = $("input[name='is_bosiet_ca']:checked").val();
            if(offshore_bosiet_ebs_val9 == '1'){
                var offshore_bosiet_ebs_isvalid_val8 = $("input[name='bosiet_with_ca_ebs_status']:checked").val();
                if(!offshore_bosiet_ebs_isvalid_val8 || (offshore_bosiet_ebs_isvalid_val8 == 'undefined')){
                    alert("Please select BOSIET (with CA-EBS)- Basic Offshore Safety Induction and Emergency Training (with CA-EBS) document valid or not?");
                    return false;
                }
            }

            var offshore_bosiet_last_val10 = $("input[name='is_bosiet']:checked").val();
            if(offshore_bosiet_last_val10 == '1'){
                var offshore_bosiet_last_isvalid_val10 = $("input[name='bosiet_status']:checked").val();
                if(!offshore_bosiet_last_isvalid_val10 || (offshore_bosiet_last_isvalid_val10 == 'undefined')){
                    alert("Please select BOSIET- Basic Offshore Safety Induction and Emergency Training document valid or not?");
                    return false;
                }
            }

        });

        $("input[name='is_endors_name_dec_chemical']").click(function(){
            var radio_val = $("input[name='is_endors_name_dec_chemical']:checked").val();
            if(radio_val == '1'){
                // $('#endors_dec_chemical_dt').show();
                alert('Select DCE - Chemical(Dangerous Cargo Endorsement) is document valid or not');
            }
            if(radio_val == 'No'){
                $('#endors_dec_chemical_dt').hide();
                $('#endors_dec_chemical_dt').val('');
            }
        });

        //Travel show inputbox based on value
       /* if($('#passport_dt').val().length != 0){
            $(".rb_passport_yes").attr('checked','checked');
        }else{
            $(".rb_passport_no").attr('checked','checked');
            $("#passport_dt").hide();
        }
        $("input[name='passport_dt_require']").click(function(){
            var radio_val = $("input[name='passport_dt_require']:checked").val();
            if(radio_val == '1'){
                $('#passport_dt').show();
            }
            if(radio_val == 'No'){
                $('#passport_dt').hide();
                $('#passport_dt').val('');
            }
        });

        if($('#Seamans_book_cdc_dt').val().length != 0){
            $(".rb_semanbook_yes").attr('checked','checked');
        }else{
            $(".rb_semanbook_no").attr('checked','checked');
            $("#Seamans_book_cdc_dt").hide();
        }
        $("input[name='Seamans_book_cdc_require']").click(function(){
            var radio_val = $("input[name='Seamans_book_cdc_require']:checked").val();
            if(radio_val == '1'){
                $('#Seamans_book_cdc_dt').show();
            }
            if(radio_val == 'No'){
                $('#Seamans_book_cdc_dt').hide();
                $('#Seamans_book_cdc_dt').val('');
            } 
        });
        
        if($('#uk_work_permit_dt').val().length != 0){
            $(".rb_ukpermit_yes").attr('checked','checked');
        }else{
            $(".rb_ukpermit_no").attr('checked','checked');
            $("#uk_work_permit_dt").hide();
        }
        $("input[name='uk_work_permit_require']").click(function(){
            var radio_val = $("input[name='uk_work_permit_require']:checked").val();
            if(radio_val == '1'){
                $('#uk_work_permit_dt').show();
            }
            if(radio_val == 'No'){
                $('#uk_work_permit_dt').hide();
                $('#uk_work_permit_dt').val('');
            } 
        });

        if($('#us_visa_dt').val().length != 0){
            $(".rb_usvisa_yes").attr('checked','checked');
        }else{
            $(".rb_usvisa_no").attr('checked','checked');
            $("#us_visa_dt").hide();
        }
        $("input[name='us_visa_require']").click(function(){
            var radio_val = $("input[name='us_visa_require']:checked").val();
            if(radio_val == '1'){
                $('#us_visa_dt').show();
            }
            if(radio_val == 'No'){
                $('#us_visa_dt').hide();
                $('#us_visa_dt').val('');
            } 
        });

        //medical inputbox show hide
        if($('#drug_alcohol_blood_test_dt').val().length != 0){//1
            $(".rb_drugtest_yes").attr('checked','checked');
        }else{
            $(".rb_drugtest_no").attr('checked','checked');
            $("#drug_alcohol_blood_test_dt").hide();
        }
        $("input[name='drug_alcoloh_test_require']").click(function(){
            var radio_val = $("input[name='drug_alcoloh_test_require']:checked").val();
            if(radio_val == '1'){
                $('#drug_alcohol_blood_test_dt').show();
            }
            if(radio_val == 'No'){
                $('#drug_alcohol_blood_test_dt').hide();
                $('#drug_alcohol_blood_test_dt').val('');
            } 
        });

        if($('#seafarers_medical_examination_dt').val().length != 0){//2
            $(".rb_seadrer_yes").attr('checked','checked');
        }else{
            $(".rb_seadrer_no").attr('checked','checked');
            $("#seafarers_medical_examination_dt").hide();
        }
        $("input[name='Seafarer_mediexa_require_require']").click(function(){
            var radio_val = $("input[name='Seafarer_mediexa_require_require']:checked").val();
            if(radio_val == '1'){
                $('#seafarers_medical_examination_dt').show();
            }
            if(radio_val == 'No'){
                $('#seafarers_medical_examination_dt').hide();
                $('#seafarers_medical_examination_dt').val('');
            } 
        });
        
        if($('#ukooa_medical_fitness_dt').val().length != 0){//3
            
            $(".rb_ukooa_yes").attr('checked','checked');
        }else{
            $(".rb_ukooa_no").attr('checked','checked');
            $("#ukooa_medical_fitness_dt").hide();
        }
        $("input[name='ukooa_medical_fitness_require']").click(function(){
            var radio_val = $("input[name='ukooa_medical_fitness_require']:checked").val();
            // alert(radio_val)
            if(radio_val == '1'){
                $('#ukooa_medical_fitness_dt').show();
            }
            if(radio_val == 'No'){
                $('#ukooa_medical_fitness_dt').hide();
                $('#ukooa_medical_fitness_dt').val('');
            } 
        });

        if($('#yellow_fever_vaccination_dt').val().length != 0){//4
            $(".rb_yfever_yes").attr('checked','checked');
        }else{
            $(".rb_yfever_no").attr('checked','checked');
            $("#yellow_fever_vaccination_dt").hide();
        }
        $("input[name='yellow_fever_vaccination_require']").click(function(){
            var radio_val = $("input[name='yellow_fever_vaccination_require']:checked").val();
            if(radio_val == '1'){
                $('#yellow_fever_vaccination_dt').show();
            }
            if(radio_val == 'No'){
                $('#yellow_fever_vaccination_dt').hide();
                $('#yellow_fever_vaccination_dt').val('');
            } 
        });

        // skill and traing hide show docs
        if($('#arpa_dt').val().length != 0){//1

            $(".rb_arpa_yes").attr('checked','checked');
        }else{
            $(".rb_arpa_no").attr('checked','checked');
            $("#arpa_dt").hide();
        }
        $("input[name='arpa_require']").click(function(){
            var radio_val = $("input[name='arpa_require']:checked").val();

            if(radio_val == '1'){
                $('#arpa_dt').show();
            }
            if(radio_val == 'No'){
                $('#arpa_dt').hide();
                $('#arpa_dt').val('');
            } 
        });

        if($('#behaviour_safety_process_dt').val().length != 0){//2
            $(".rb_behaviour_safety_yes").attr('checked','checked');
        }else{
            $(".rb_behaviour_safety_no").attr('checked','checked');
            $("#behaviour_safety_process_dt").hide();
        }
        $("input[name='behaviour_safety_process_require']").click(function(){
            var radio_val = $("input[name='behaviour_safety_process_require']:checked").val();
            if(radio_val == '1'){
                $('#behaviour_safety_process_dt').show();
            }
            if(radio_val == 'No'){
                $('#behaviour_safety_process_dt').hide();
                $('#behaviour_safety_process_dt').val('');
            } 
        });

        if($('#boatmaster_license_dt').val().length != 0){//3
            $(".rb_boat_license_yes").attr('checked','checked');
        }else{
            $(".rb_boat_license_no").attr('checked','checked');
            $("#boatmaster_license_dt").hide();
        }
        $("input[name='boatmaster_license_require']").click(function(){
            var radio_val = $("input[name='boatmaster_license_require']:checked").val();
            if(radio_val == '1'){
                $('#boatmaster_license_dt').show();
            }
            if(radio_val == 'No'){
                $('#boatmaster_license_dt').hide();
                $('#boatmaster_license_dt').val('');
            } 
        });

        if($('#bridge_team_management_dt').val().length != 0){//4
            $(".rb_bridgeteam_mgt_yes").attr('checked','checked');
        }else{
            $(".rb_bridgeteam_mgt_no").attr('checked','checked');
            $("#bridge_team_management_dt").hide();
        }
        $("input[name='bridge_team_management_require']").click(function(){
            var radio_val = $("input[name='bridge_team_management_require']:checked").val();
            if(radio_val == '1'){
                $('#bridge_team_management_dt').show();
            }
            if(radio_val == 'No'){
                $('#bridge_team_management_dt').hide();
                $('#bridge_team_management_dt').val('');
            } 
        });

        if($('#chemical_tankertraining_dt').val().length != 0){//5
            $(".rb_chemical_tank_yes").attr('checked','checked');
        }else{
            $(".rb_chemical_tank_no").attr('checked','checked');
            $("#chemical_tankertraining_dt").hide();
        }
        $("input[name='chemical_tankertraining_require']").click(function(){
            var radio_val = $("input[name='chemical_tankertraining_require']:checked").val();
            if(radio_val == '1'){
                $('#chemical_tankertraining_dt').show();
            }
            if(radio_val == 'No'){
                $('#chemical_tankertraining_dt').hide();
                $('#chemical_tankertraining_dt').val('');
            } 
        });

        if($('#cows_crudeoil_washing_dt').val().length != 0){//6
            $(".rb_cows_yes").attr('checked','checked');
        }else{
            $(".rb_cows_no").attr('checked','checked');
            $("#cows_crudeoil_washing_dt").hide();
        }
        $("input[name='cows_crudeoil_washing_require']").click(function(){
            var radio_val = $("input[name='cows_crudeoil_washing_require']:checked").val();
            if(radio_val == '1'){
                $('#others_dt').show();
            }
            if(radio_val == 'No'){
                $('#cows_crudeoil_washing_dt').hide();
                $('#cows_crudeoil_washing_dt').val('');
            } 
        });

        if($('#crane_operator_certificate_dt').val().length != 0){//7
            $(".rb_crencerti_yes").attr('checked','checked');
        }else{
            $(".rb_crencerti_no").attr('checked','checked');
            $("#crane_operator_certificate_dt").hide();
        }
        $("input[name=crane_operator_certificate_require").click(function(){
            var radio_val = $("input[name='crane_operator_certificate_require']:checked").val();
            if(radio_val == '1'){
                $('#crane_operator_certificate_dt').show();
            }
            if(radio_val == 'No'){
                $('#crane_operator_certificate_dt').hide();
                $('#crane_operator_certificate_dt').val('');
            } 
        });

        if($('#dp_induction_dt').val().length != 0){//8
            $(".rb_dpinduction_yes").attr('checked','checked');
        }else{
            $(".rb_dpinduction_no").attr('checked','checked');
            $("#dp_induction_dt").hide();
        }
        $("input[name=dp_induction_require").click(function(){
            var radio_val = $("input[name='dp_induction_require']:checked").val();
            if(radio_val == '1'){
                $('#dp_induction_dt').show();
            }
            if(radio_val == 'No'){
                $('#dp_induction_dt').hide();
                $('#dp_induction_dt').val('');
            } 
        });

        if($('#dp_limited_dt').val().length != 0){//9
            $(".rb_dplimited_yes").attr('checked','checked');
        }else{
            $(".rb_dplimited_no").attr('checked','checked');
            $("#dp_limited_dt").hide();
        }
        $("input[name=dp_limited_require").click(function(){
            var radio_val = $("input[name='dp_limited_require']:checked").val();
            if(radio_val == '1'){
                $('#dp_limited_dt').show();
            }
            if(radio_val == 'No'){
                $('#dp_limited_dt').hide();
                $('#dp_limited_dt').val('');
            } 
        });

        if($('#dp_simulator_dt').val().length != 0){//10
            $(".rb_dpsimulator_yes").attr('checked','checked');
        }else{
            $(".rb_dpsimulator_no").attr('checked','checked');
            $("#dp_simulator_dt").hide();
        }
        $("input[name=dp_simulator_require").click(function(){
            var radio_val = $("input[name='dp_simulator_require']:checked").val();
            if(radio_val == '1'){
                $('#dp_simulator_dt').show();
            }
            if(radio_val == 'No'){
                $('#dp_simulator_dt').hide();
                $('#dp_simulator_dt').val('');
            } 
        });
        //personal hide show text box
        if($('#driver_license_dt').val().length != 0){//10
            $(".rb_driver_lice_yes").attr('checked','checked');
        }else{
            $(".rb_driver_lice_no").attr('checked','checked');
            $("#driver_license_dt").hide();
        }
        $("input[name=driver_license_require").click(function(){
            var radio_val = $("input[name='driver_license_require']:checked").val();
            if(radio_val == '1'){
                $('#driver_license_dt').show();
            }
            if(radio_val == 'No'){
                $('#driver_license_dt').hide();
                $('#driver_license_dt').val('');
            } 
        });

        if($('#photograph_dt').val().length != 0){//2
            $(".rb_photograph_yes").attr('checked','checked');
        }else{
            $(".rb_photograph_no").attr('checked','checked');
            $("#photograph_dt").hide();
        }
        $("input[name=photograph_require").click(function(){
            var radio_val = $("input[name='photograph_require']:checked").val();
            if(radio_val == '1'){
                $('#photograph_dt').show();
            }
            if(radio_val == 'No'){
                $('#photograph_dt').hide();
                $('#photograph_dt').val('');
            } 
        });

        if($('#resume_dt').val().length != 0){//3
            $(".rb_resume_yes").attr('checked','checked');
        }else{
            $(".rb_resume_no").attr('checked','checked');
            $("#resume_dt").hide();
        }
        $("input[name=resume_require").click(function(){
            var radio_val = $("input[name='resume_require']:checked").val();
            if(radio_val == '1'){
                $('#resume_dt').show();
            }
            if(radio_val == 'No'){
                $('#resume_dt').hide();
                $('#resume_dt').val('');
            } 
        });

        if($('#personal_other_docs_dt').val().length != 0){//4
            $(".rb_per_otherdocs_yes").attr('checked','checked');
        }else{
            $(".rb_per_otherdocs_no").attr('checked','checked');
            $("#personal_other_docs_dt").hide();
        }
        $("input[name=personal_other_docs_require").click(function(){
            var radio_val = $("input[name='personal_other_docs_require']:checked").val();
            if(radio_val == '1'){
                $('#personal_other_docs_dt').show();
            }
            if(radio_val == 'No'){
                $('#personal_other_docs_dt').hide();
                $('#personal_other_docs_dt').val('');
            } 
        });
        //coc
        if($('#officers_incharge_navigational_unlimited_dt').val().length != 0){//1
            $(".rb_officer_nav_watch_yes").attr('checked','checked');
        }else{
            $(".rb_officer_nav_watch_no").attr('checked','checked');
            $("#officers_incharge_navigational_unlimited_dt").hide();
        }
        $("input[name=officers_incharge_navigational_unlimited_require").click(function(){
            var radio_val = $("input[name='officers_incharge_navigational_unlimited_require']:checked").val();
            if(radio_val == '1'){
                $('#officers_incharge_navigational_unlimited_dt').show();
            }
            if(radio_val == 'No'){
                $('#officers_incharge_navigational_unlimited_dt').hide();
                $('#officers_incharge_navigational_unlimited_dt').val('');
            } 
        });

        if($('#master_unlimited_dt').val().length != 0){//2
            $(".rb_masunlimit_yes").attr('checked','checked');
        }else{
            $(".rb_masunlimit_no").attr('checked','checked');
            $("#master_unlimited_dt").hide();
        }
        $("input[name=master_unlimited_require").click(function(){
            var radio_val = $("input[name='master_unlimited_require']:checked").val();
            if(radio_val == '1'){
                $('#master_unlimited_dt').show();
            }
            if(radio_val == 'No'){
                $('#master_unlimited_dt').hide();
                $('#master_unlimited_dt').val('');
            } 
        });

        if($('#chief_mate_unlimited_dt').val().length != 0){//3
            $(".rb_cmateunli_yes").attr('checked','checked');
        }else{
            $(".rb_cmateunli_no").attr('checked','checked');
            $("#chief_mate_unlimited_dt").hide();
        }
        $("input[name=chief_mate_unlimited_require").click(function(){
            var radio_val = $("input[name='chief_mate_unlimited_require']:checked").val();
            if(radio_val == '1'){
                $('#chief_mate_unlimited_dt').show();
            }
            if(radio_val == 'No'){
                $('#chief_mate_unlimited_dt').hide();
                $('#chief_mate_unlimited_dt').val('');
            } 
        });

        if($('#masters_ships_lessthan_500gt_dt').val().length != 0){//4
            $(".rb_mshiogre500_yes").attr('checked','checked');
        }else{
            $(".rb_mshiogre500_no").attr('checked','checked');
            $("#masters_ships_lessthan_500gt_dt").hide();
        }

        $("input[name=masters_ships_lessthan_500gt_require").click(function(){
            var radio_val = $("input[name='masters_ships_lessthan_500gt_require']:checked").val();
            if(radio_val == '1'){
                $('#masters_ships_lessthan_500gt_dt').show();
            }
            if(radio_val == 'No'){
                $('#masters_ships_lessthan_500gt_dt').hide();
                $('#masters_ships_lessthan_500gt_dt').val('');
            } 
        });

        if($('#officers_charge_navigational_less_500_dt').val().length != 0){//5
            $(".rb_navofficer500_yes").attr('checked','checked');
        }else{
            $(".rb_navofficer500_no").attr('checked','checked');
            $("#officers_charge_navigational_less_500_dt").hide();
        }
        
        $("input[name=officers_charge_navigational_less_500_require").click(function(){
            var radio_val = $("input[name='officers_charge_navigational_less_500_require']:checked").val();
            if(radio_val == '1'){
                $('#officers_charge_navigational_less_500_dt').show();
            }
            if(radio_val == 'No'){
                $('#officers_charge_navigational_less_500_dt').hide();
                $('#officers_charge_navigational_less_500_dt').val('');
            } 
        });

        if($('#rating_forming_part_navigational_watch_dt').val().length != 0){//6
            $(".rb_ratingnavwatch_yes").attr('checked','checked');
        }else{
            $(".rb_ratingnavwatch_no").attr('checked','checked');
            $("#rating_forming_part_navigational_watch_dt").hide();
        }
        
        $("input[name=rating_forming_part_navigational_watch_require").click(function(){
            var radio_val = $("input[name='rating_forming_part_navigational_watch_require']:checked").val();
            if(radio_val == '1'){
                $('#rating_forming_part_navigational_watch_dt').show();
            }
            if(radio_val == 'No'){
                $('#rating_forming_part_navigational_watch_dt').hide();
                $('#rating_forming_part_navigational_watch_dt').val('');
            } 
        });

        if($('#able_seafarer_deck_dt').val().length != 0){//7
            $(".rb_ablsererd_yes").attr('checked','checked');
        }else{
            $(".rb_ablsererd_no").attr('checked','checked');
            $("#able_seafarer_deck_dt").hide();
        }
        
        $("input[name=able_seafarer_deck_require").click(function(){
            var radio_val = $("input[name='able_seafarer_deck_require']:checked").val();
            if(radio_val == '1'){
                $('#able_seafarer_deck_dt').show();
            }
            if(radio_val == 'No'){
                $('#able_seafarer_deck_dt').hide();
                $('#able_seafarer_deck_dt').val('');
            } 
        });
        
        if($('#officer_charge_engineering_watch_dt').val().length != 0){//8
            $(".rb_offwatchin_yes").attr('checked','checked');
        }else{
            $(".rb_offwatchin_no").attr('checked','checked');
            $("#officer_charge_engineering_watch_dt").hide();
        }
        
        $("input[name=officer_charge_engineering_watch_require").click(function(){
            var radio_val = $("input[name='officer_charge_engineering_watch_require']:checked").val();
            if(radio_val == '1'){
                $('#officer_charge_engineering_watch_dt').show();
            }
            if(radio_val == 'No'){
                $('#officer_charge_engineering_watch_dt').hide();
                $('#officer_charge_engineering_watch_dt').val('');
            } 
        });

        if($('#chief_engineer_officer_dt').val().length != 0){//9
            $(".rb_chiefEO_yes").attr('checked','checked');
        }else{
            $(".rb_chiefEO_no").attr('checked','checked');
            $("#chief_engineer_officer_dt").hide();
        }
        
        $("input[name=chief_engineer_officer_require").click(function(){
            var radio_val = $("input[name='chief_engineer_officer_require']:checked").val();
            if(radio_val == '1'){
                $('#chief_engineer_officer_dt').show();
            }
            if(radio_val == 'No'){
                $('#chief_engineer_officer_dt').hide();
                $('#chief_engineer_officer_dt').val('');
            } 
        });

        if($('#second_engineer_officer_dt').val().length != 0){//10
            $(".rb_secEO_yes").attr('checked','checked');
        }else{
            $(".rb_secEO_no").attr('checked','checked');
            $("#second_engineer_officer_dt").hide();
        }
        
        $("input[name=second_engineer_officer_require").click(function(){
            var radio_val = $("input[name='second_engineer_officer_require']:checked").val();
            if(radio_val == '1'){
                $('#second_engineer_officer_dt').show();
            }
            if(radio_val == 'No'){
                $('#second_engineer_officer_dt').hide();
                $('#second_engineer_officer_dt').val('');
            } 
        });
        //stcw
        
        if($('#basic_training_chemical_tc_operations_dt').val().length != 0){//1
            $(".rb_btchemitcopr_yes").attr('checked','checked');
        }else{
            $(".rb_btchemitcopr_no").attr('checked','checked');
            $("#basic_training_chemical_tc_operations_dt").hide();
        }
        
        $("input[name=basic_training_chemical_tc_operations_require").click(function(){
            var radio_val = $("input[name='basic_training_chemical_tc_operations_require']:checked").val();
            if(radio_val == '1'){
                $('#basic_training_chemical_tc_operations_dt').show();
            }
            if(radio_val == 'No'){
                $('#basic_training_chemical_tc_operations_dt').hide();
                $('#basic_training_chemical_tc_operations_dt').val('');
            } 
        });

        if($('#advanced_tc_operations_dt').val().length != 0){//2
            $(".rb_atfocaropr_yes").attr('checked','checked');
        }else{
            $(".rb_atfocaropr_no").attr('checked','checked');
            $("#advanced_tc_operations_dt").hide();
        }
        
        $("input[name=advanced_tc_operations_require").click(function(){
            var radio_val = $("input[name='advanced_tc_operations_require']:checked").val();
            if(radio_val == '1'){
                $('#advanced_tc_operations_dt').show();
            }
            if(radio_val == 'No'){
                $('#advanced_tc_operations_dt').hide();
                $('#advanced_tc_operations_dt').val('');
            } 
        });
        
        if($('#advanced_chemical_tc_operations_dt').val().length != 0){//3
            $(".rb_atfortco_yes").attr('checked','checked');
        }else{
            $(".rb_atfortco_no").attr('checked','checked');
            $("#advanced_chemical_tc_operations_dt").hide();
        }
        
        $("input[name=advanced_chemical_tc_operations_require").click(function(){
            var radio_val = $("input[name='advanced_chemical_tc_operations_require']:checked").val();
            if(radio_val == '1'){
                $('#advanced_chemical_tc_operations_dt').show();
            }
            if(radio_val == 'No'){
                $('#advanced_chemical_tc_operations_dt').hide();
                $('#advanced_chemical_tc_operations_dt').val('');
            } 
        });
        
        if($('#bt_liquified_gas_tc_dt').val().length != 0){//3
            $(".rb_liquidgsc_yes").attr('checked','checked');
        }else{
            $(".rb_liquidgsc_no").attr('checked','checked');
            $("#bt_liquified_gas_tc_dt").hide();
        }
        
        $("input[name=bt_liquified_gas_tc_require").click(function(){
            var radio_val = $("input[name='bt_liquified_gas_tc_require']:checked").val();
            if(radio_val == '1'){
                $('#bt_liquified_gas_tc_dt').show();
            }
            if(radio_val == 'No'){
                $('#bt_liquified_gas_tc_dt').hide();
                $('#bt_liquified_gas_tc_dt').val('');
            } 
        });

        if($('#at_for_liquified_gas_tc_dt').val().length != 0){//4
            $(".rb_atflgasc_yes").attr('checked','checked');
        }else{
            $(".rb_atflgasc_no").attr('checked','checked');
            $("#at_for_liquified_gas_tc_dt").hide();
        }
        
        $("input[name=at_for_liquified_gas_tc_require").click(function(){
            var radio_val = $("input[name='at_for_liquified_gas_tc_require']:checked").val();
            if(radio_val == '1'){
                $('#at_for_liquified_gas_tc_dt').show();
            }
            if(radio_val == 'No'){
                $('#at_for_liquified_gas_tc_dt').hide();
                $('#at_for_liquified_gas_tc_dt').val('');
            } 
        });
        
        if($('#crowd_mgt_training_dt').val().length != 0){//6
            $(".rb_cmgttra_yes").attr('checked','checked');
        }else{
            $(".rb_cmgttra_no").attr('checked','checked');
            $("#crowd_mgt_training_dt").hide();
        }
        
        $("input[name=crowd_mgt_training_require").click(function(){
            var radio_val = $("input[name='crowd_mgt_training_require']:checked").val();
            if(radio_val == '1'){
                $('#crowd_mgt_training_dt').show();
            }
            if(radio_val == 'No'){
                $('#crowd_mgt_training_dt').hide();
                $('#crowd_mgt_training_dt').val('');
            } 
        });

        if($('#safety_training_for_personnel_providing_ds_dt').val().length != 0){//7
            $(".rb_safetpdstopp_yes").attr('checked','checked');
        }else{
            $(".rb_safetpdstopp_no").attr('checked','checked');
            $("#safety_training_for_personnel_providing_ds_dt").hide();
        }
        
        $("input[name=safety_training_for_personnel_providing_ds_require").click(function(){
            var radio_val = $("input[name='safety_training_for_personnel_providing_ds_require']:checked").val();
            if(radio_val == '1'){
                $('#safety_training_for_personnel_providing_ds_dt').show();
            }
            if(radio_val == 'No'){
                $('#safety_training_for_personnel_providing_ds_dt').hide();
                $('#safety_training_for_personnel_providing_ds_dt').val('');
            } 
        });

        
        if($('#crisis_mgt_human_behaviour_training_dt').val().length != 0){//8
            $(".rb_cmgtht_yes").attr('checked','checked');
        }else{
            $(".rb_cmgtht_no").attr('checked','checked');
            $("#crisis_mgt_human_behaviour_training_dt").hide();
        }
        
        $("input[name=crisis_mgt_human_behaviour_training_require").click(function(){
            var radio_val = $("input[name='crisis_mgt_human_behaviour_training_require']:checked").val();
            if(radio_val == '1'){
                $('#crisis_mgt_human_behaviour_training_dt').show();
            }
            if(radio_val == 'No'){
                $('#crisis_mgt_human_behaviour_training_dt').hide();
                $('#crisis_mgt_human_behaviour_training_dt').val('');
            } 
        });

        if($('#passenger_cargo_hull_integrity_training_dt').val().length != 0){//9
            $(".rb_hullinte_cs_yes").attr('checked','checked');
        }else{
            $(".rb_hullinte_cs_no").attr('checked','checked');
            $("#passenger_cargo_hull_integrity_training_dt").hide();
        }
        
        $("input[name=passenger_cargo_passenger_cargo_hull_integrity_training_require").click(function(){
            var radio_val = $("input[name='passenger_cargo_passenger_cargo_hull_integrity_training_require']:checked").val();
            if(radio_val == '1'){
                $('#passenger_cargo_hull_integrity_training_dt').show();
            }
            if(radio_val == 'No'){
                $('#passenger_cargo_hull_integrity_training_dt').hide();
                $('#passenger_cargo_hull_integrity_training_dt').val('');
            } 
        });
        
        if($('#basic_safety_tc_dt').val().length != 0){//10
            $(".rb_basicstc_yes").attr('checked','checked');
        }else{
            $(".rb_basicstc_no").attr('checked','checked');
            $("#basic_safety_tc_dt").hide();
        }
        
        $("input[name=basic_safety_tc_require").click(function(){
            var radio_val = $("input[name='basic_safety_tc_require']:checked").val();
            if(radio_val == '1'){
                $('#basic_safety_tc_dt').show();
            }
            if(radio_val == 'No'){
                $('#basic_safety_tc_dt').hide();
                $('#basic_safety_tc_dt').val('');
            } 
        });
        //offshore
        if($('#agt0_dt').val().length != 0){//1
            $(".rb_AGT0_yes").attr('checked','checked');
        }else{
            $(".rb_AGT0_no").attr('checked','checked');
            $("#agt0_dt").hide();
        }
        
        $("input[name=agt0_dt_require").click(function(){
            var radio_val = $("input[name='agt0_dt_require']:checked").val();
            if(radio_val == '1'){
                $('#agt0_dt').show();
            }
            if(radio_val == 'No'){
                $('#agt0_dt').hide();
                $('#agt0_dt').val('');
            } 
        });

        if($('#agtl1_cbt_dt').val().length != 0){//2
            $(".rb_AGT2_yes").attr('checked','checked');
        }else{
            $(".rb_AGT2_no").attr('checked','checked');
            $("#agtl1_cbt_dt").hide();
        }
        
        $("input[name=agtl1_cbt_dt").click(function(){
            var radio_val = $("input[name='agtl1_cbt_require']:checked").val();
            if(radio_val == '1'){
                $('#agtl1_cbt_dt').show();
            }
            if(radio_val == 'No'){
                $('#agtl1_cbt_dt').hide();
                $('#agtl1_cbt_dt').val('');
            } 
        });

        if($('#agt2_dt').val().length != 0){//3
            $(".rb_AGT1agtl2_yes").attr('checked','checked');
        }else{
            $(".rb_AGT1agtl2_no").attr('checked','checked');
            $("#agt2_dt").hide();
        }
        
        $("input[name=agt2_require").click(function(){
            var radio_val = $("input[name='agt2_require']:checked").val();
            if(radio_val == '1'){
                $('#agt2_dt').show();
            }
            if(radio_val == 'No'){
                $('#agt2_dt').hide();
                $('#agt2_dt').val('');
            } 
        });

        if($('#agt2_cbt_dt').val().length != 0){//4
            $(".rb_AGT1cbtagttl2_yes").attr('checked','checked');
        }else{
            $(".rb_AGT1cbtagttl2_no").attr('checked','checked');
            $("#agt2_cbt_dt").hide();
        }
        
        $("input[name=agt2_cbt_require").click(function(){
            var radio_val = $("input[name='agt2_cbt_require']:checked").val();
            if(radio_val == '1'){
                $('#agt2_cbt_dt').show();
            }
            if(radio_val == 'No'){
                $('#agt2_cbt_dt').hide();
                $('#agt2_cbt_dt').val('');
            } 
        });

        if($('#agt3_cbt_dt').val().length != 0){//5
            $(".rb_AGT3agttl3_yes").attr('checked','checked');
        }else{
            $(".rb_AGT3agttl3_no").attr('checked','checked');
            $("#agt3_cbt_dt").hide();
        }
        
        $("input[name=agt3_cbt_require").click(function(){
            var radio_val = $("input[name='agt3_cbt_require']:checked").val();
            if(radio_val == '1'){
                $('#agt3_cbt_dt').show();
            }
            if(radio_val == 'No'){
                $('#agt3_cbt_dt').hide();
                $('#agt3_cbt_dt').val('');
            } 
        });
        if($('#ama_errv_crew_advanced_medical_aid_dt').val().length != 0){//6
            $(".rb_amaerrvmaid_yes").attr('checked','checked');
        }else{
            $(".rb_amaerrvmaid_no").attr('checked','checked');
            $("#ama_errv_crew_advanced_medical_aid_dt").hide();
        }
        
        $("input[name=ama_errv_crew_advanced_medical_aid_require").click(function(){
            var radio_val = $("input[name='ama_errv_crew_advanced_medical_aid_require']:checked").val();
            if(radio_val == '1'){
                $('#ama_errv_crew_advanced_medical_aid_dt').show();
            }
            if(radio_val == 'No'){
                $('#ama_errv_crew_advanced_medical_aid_dt').hide();
                $('#ama_errv_crew_advanced_medical_aid_dt').val('');
            } 
        });

        if($('#boat_travel_safely_by_boat_dt').val().length != 0){//7
            $(".rb_boattsboat_yes").attr('checked','checked');
        }else{
            $(".rb_boattsboat_no").attr('checked','checked');
            $("#boat_travel_safely_by_boat_dt").hide();
        }
        
        $("input[name=boat_travel_safely_by_boat_require").click(function(){
            var radio_val = $("input[name='boat_travel_safely_by_boat_require']:checked").val();
            if(radio_val == '1'){
                $('#boat_travel_safely_by_boat_dt').show();
            }
            if(radio_val == 'No'){
                $('#boat_travel_safely_by_boat_dt').hide();
                $('#boat_travel_safely_by_boat_dt').val('');
            } 
        });

        if($('#boer_basic_onshore_emergency_response_dt').val().length != 0){//8
            $(".rb_boer_yes").attr('checked','checked');
        }else{
            $(".rb_boer_no").attr('checked','checked');
            $("#boer_basic_onshore_emergency_response_dt").hide();
        }
        
        $("input[name=boer_basic_onshore_emergency_response_require").click(function(){
            var radio_val = $("input[name='boer_basic_onshore_emergency_response_require']:checked").val();
            if(radio_val == '1'){
                $('#boer_basic_onshore_emergency_response_dt').show();
            }
            if(radio_val == 'No'){
                $('#boer_basic_onshore_emergency_response_dt').hide();
                $('#boer_basic_onshore_emergency_response_dt').val('');
            } 
        });

        if($('#bosiet_with_ca_ebs_dt').val().length != 0){//9
            $(".rb_bosiet_caebs_yes").attr('checked','checked');
        }else{
            $(".rb_bosiet_caebs_no").attr('checked','checked');
            $("#bosiet_with_ca_ebs_dt").hide();
        }
        
        $("input[name=bosiet_with_ca_ebs_require").click(function(){
            var radio_val = $("input[name='bosiet_with_ca_ebs_require']:checked").val();
            if(radio_val == '1'){
                $('#bosiet_with_ca_ebs_dt').show();
            }
            if(radio_val == 'No'){
                $('#bosiet_with_ca_ebs_dt').hide();
                $('#bosiet_with_ca_ebs_dt').val('');
            } 
        });
        
        
        if($('#bosiet_dt').val().length != 0){//9
            $(".rb_bosietet_yes").attr('checked','checked');
        }else{
            $(".rb_bosietet_no").attr('checked','checked');
            $("#bosiet_dt").hide();
        }
        
        $("input[name=bosiet_require").click(function(){
            var radio_val = $("input[name='bosiet_require']:checked").val();
            if(radio_val == '1'){
                $('#bosiet_dt').show();
            }
            if(radio_val == 'No'){
                $('#bosiet_dt').hide();
                $('#bosiet_dt').val('');
            } 
        });
        //yatch certificate
        if($('#advanced_powerboat_certificate_dt').val().length != 0){//1
            $(".rb_advpowc_yes").attr('checked','checked');
        }else{
            $(".rb_advpowc_no").attr('checked','checked');
            $("#advanced_powerboat_certificate_dt").hide();
        }
        
        $("input[name=advanced_powerboat_certificate_require").click(function(){
            var radio_val = $("input[name='advanced_powerboat_certificate_require']:checked").val();
            if(radio_val == '1'){
                $('#advanced_powerboat_certificate_dt').show();
            }
            if(radio_val == 'No'){
                $('#advanced_powerboat_certificate_dt').hide();
                $('#advanced_powerboat_certificate_dt').val('');
            } 
        });
        
        if($('#basic_sea_survival_certificate_dt').val().length != 0){//2
            $(".rb_seaservival_yes").attr('checked','checked');
        }else{
            $(".rb_seaservival_no").attr('checked','checked');
            $("#basic_sea_survival_certificate_dt").hide();
        }
        
        $("input[name=basic_sea_survival_certificate_require").click(function(){
            var radio_val = $("input[name='basic_sea_survival_certificate_require']:checked").val();
            if(radio_val == '1'){
                $('#basic_sea_survival_certificate_dt').show();
            }
            if(radio_val == 'No'){
                $('#basic_sea_survival_certificate_dt').hide();
                $('#basic_sea_survival_certificate_dt').val('');
            } 
        });

        if($('#csy_offshore_certificate_dt').val().length != 0){//3
            $(".rb_costyoffsc_yes").attr('checked','checked');
        }else{
            $(".rb_costyoffsc_no").attr('checked','checked');
            $("#csy_offshore_certificate_dt").hide();
        }
        
        $("input[name=csy_offshore_certificate_require").click(function(){
            var radio_val = $("input[name='csy_offshore_certificate_require']:checked").val();
            if(radio_val == '1'){
                $('#csy_offshore_certificate_dt').show();
            }
            if(radio_val == 'No'){
                $('#csy_offshore_certificate_dt').hide();
                $('#csy_offshore_certificate_dt').val('');
            } 
        });

        if($('#ds_certificate_competence_dt').val().length != 0){//4
            $(".rb_datskipcom_no").attr('checked','checked');
        }else{
            $(".rb_datskipcom_no").attr('checked','checked');
            $("#ds_certificate_competence_dt").hide();
        }
        
        $("input[name=ds_certificate_competence_require").click(function(){
            var radio_val = $("input[name='ds_certificate_competence_require']:checked").val();
            if(radio_val == '1'){
                $('#ds_certificate_competence_dt').show();
            }
            if(radio_val == 'No'){
                $('#ds_certificate_competence_dt').hide();
                $('#ds_certificate_competence_dt').val('');
            } 
        });

        if($('#ds_shorebased_certificate_dt').val().length != 0){//5
            $(".rb_dskshorebase_no").attr('checked','checked');
        }else{
            $(".rb_dskshorebase_no").attr('checked','checked');
            $("#ds_shorebased_certificate_dt").hide();
        }
        
        $("input[name=ds_shorebased_certificate_require").click(function(){
            var radio_val = $("input[name='ds_shorebased_certificate_require']:checked").val();
            if(radio_val == '1'){
                $('#ds_shorebased_certificate_dt').show();
            }
            if(radio_val == 'No'){
                $('#ds_shorebased_certificate_dt').hide();
                $('#ds_shorebased_certificate_dt').val('');
            } 
        });

        if($('#diesel_engine_dt').val().length != 0){//6
            $(".rb_dieselegine_yes").attr('checked','checked');
        }else{
            $(".rb_dieselegine_no").attr('checked','checked');
            $("#diesel_engine_dt").hide();
        }
        
        $("input[name=diesel_engine_require").click(function(){
            var radio_val = $("input[name='diesel_engine_require']:checked").val();
            if(radio_val == '1'){
                $('#diesel_engine_dt').show();
            }
            if(radio_val == 'No'){
                $('#diesel_engine_dt').hide();
                $('#diesel_engine_dt').val('');
            } 
        });

        if($('#diveboat_coxswain_dt').val().length != 0){//7
            $(".rb_divecoxsw_yes").attr('checked','checked');
        }else{
            $(".rb_divecoxsw_no").attr('checked','checked');
            $("#diveboat_coxswain_dt").hide();
        }
        
        $("input[name=diveboat_coxswain_require").click(function(){
            var radio_val = $("input[name='diveboat_coxswain_require']:checked").val();
            if(radio_val == '1'){
                $('#diveboat_coxswain_dt').show();
            }
            if(radio_val == 'No'){
                $('#diveboat_coxswain_dt').hide();
                $('#diveboat_coxswain_dt').val('');
            } 
        });

        if($('#diveboat_master_dt').val().length != 0){//8
            $(".rb_divemster_yes").attr('checked','checked');
        }else{
            $(".rb_divemster_no").attr('checked','checked');
            $("#diveboat_master_dt").hide();
        }
        
        $("input[name=diveboat_master_require").click(function(){
            var radio_val = $("input[name='diveboat_master_require']:checked").val();
            if(radio_val == '1'){
                $('#diveboat_master_dt').show();
            }
            if(radio_val == 'No'){
                $('#diveboat_master_dt').hide();
                $('#diveboat_master_dt').val('');
            } 
        });

        if($('#first_aid_dt').val().length != 0){//9
            $(".rb_firstaid_yes").attr('checked','checked');
        }else{
            $(".rb_firstaid_no").attr('checked','checked');
            $("#first_aid_dt").hide();
        }
        
        $("input[name=first_aid_require").click(function(){
            var radio_val = $("input[name='first_aid_require']:checked").val();
            if(radio_val == '1'){
                $('#first_aid_dt').show();
            }
            if(radio_val == 'No'){
                $('#first_aid_dt').hide();
                $('#first_aid_dt').val('');
            } 
        });

        if($('#international_pleasure_craft_certificate_dt').val().length != 0){//10
            $(".rb_intercopc_yes").attr('checked','checked');
        }else{
            $(".rb_intercopc_no").attr('checked','checked');
            $("#international_pleasure_craft_certificate_dt").hide();
        }
        
        $("input[name=international_pleasure_craft_certificate_require").click(function(){
            var radio_val = $("input[name='international_pleasure_craft_certificate_require']:checked").val();
            if(radio_val == '1'){
                $('#international_pleasure_craft_certificate_dt').show();
            }
            if(radio_val == 'No'){
                $('#international_pleasure_craft_certificate_dt').hide();
                $('#international_pleasure_craft_certificate_dt').val('');
            } 
        });

        //any other docs
        $('#doc_expiry_dt').hide();
        $('.radio_otherdoc').click(function(){
            var radio_val = $("input[name='any_other_doc_require']:checked").val();
            if(radio_val == '1'){
                $('#doc_expiry_dt').show();
            }
            if(radio_val == 'No'){
                $('#doc_expiry_dt').hide();
            }
        });*/
        
    });//Document ready


    function updateValidTable(section, row_number, value){
        console.log('Section : '+section);
        console.log('row_number : '+row_number);
        console.log('value : '+value);
        if(value==1){
            $("."+section+"_"+row_number).attr('disabled',false);
        } else {
            $("."+section+"_"+row_number).attr('disabled',true);
            $("."+section+"_"+row_number).prop("checked", false);
        }
    }

</script>

@endsection