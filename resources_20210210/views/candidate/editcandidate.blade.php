
<?php 
use Illuminate\Support\Facades\Input;
// print_r()

if($candidateData){
    $code = explode("-", isset($candidateData->phone_number) ? $candidateData->phone_number : '');

    $country_code = isset($code[0]) ? $code[0] : '' ;
    $phone_number = isset($code[1]) ? $code[1] :  '';

    $landline_numbercode = explode("-", isset($candidateData->landline_number) ? $candidateData->landline_number : '');

    $country_code_landline = isset($landline_numbercode[0]) ? $landline_numbercode[0] : '' ;
    $landline_number = isset($landline_numbercode[1]) ? $landline_numbercode[1] :  '';

    $resume_file = isset($candidateData->resume_file) ? $candidateData->resume_file : '';
    
    if($candidateData->dob != ''){
        $dateInput = explode('-', isset($candidateData->dob) ? $candidateData->dob : '');    
    }

    if(isset($dateInput) && ($dateInput != null)){
        $dob = $dateInput[1].'/'.$dateInput[2].'/'.$dateInput[0];
    }else{
        $dob = '';
    }

    if($candidateData->availablefrom != '' && isset($candidateData->availablefrom)){
        $date = explode('-',isset($candidateData->availablefrom) ? $candidateData->availablefrom : '');    
    }
    
    if(isset($date) && $date != ''){
        $availablefrom = $date[1].'/'.$date[2].'/'.$date[0];    
    }else{
        $availablefrom = '';
    }
}

?>
@extends('layouts.app_afterLogin')
@section('content')
    <section class="dashboard-wrap">
        <div class="container-fluid">
                    <div class="row">
                        <!-- Sidebar Wrap -->
                        <div class="col-lg-3 col-md-4">
                            <div class="side-dashboard">
                                <?php //echo url('public/assets/img/avatar-default.png')?>
                                <div class="dashboard-avatar">                            
                                    <div class="dashboard-avatar-thumb">
                                        <?php                                            
                                            $name = $profileimg[0]->profile_path;
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
                                        <!-- <span>Zivara Technoloty</span> -->
                                    </div>
                                    <!-- profile pic -->
                                    <form class="candidate-profile-form" method="POST" action="{{ route('cand.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <span class="control-fileupload">
                                            <label for="file">Update Profile Image</label>
                                            <input type="file" name="profile_path" id="profile_path">

                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dashboard-avatar" style="padding: 0px;">
                                                    <div class="form-group">
                                                        <label>Availability Status</label><br>
                                                        <!-- <div class="col-lg-4 col-md-6 col-sm-12"> -->
                                                         
                                                            <label class="radio-inline"> 
                                                                <input data-toggle='tooltip' title="Profile visible to the Employers" name="availability_status" type="radio" value="Available" name="optradio" {{ (isset($profileimg[0]->availability_status) && ($profileimg[0]->availability_status == 'Available')) ? 'Checked':''}}>Available
                                                            </label>
                                                       
                                                        <!-- </div> -->
                                                        <!-- <div class="col-lg-4 col-md-6 col-sm-12"> -->
                                                         
                                                            <label class="radio-inline">
                                                                <input  data-toggle='tooltip' title="Profile not visible to the Employers"  name="availability_status" type="radio" value="Onboard" name="optradio" {{ (isset($profileimg[0]->availability_status) && ($profileimg[0]->availability_status == 'Onboard')) ? 'Checked':''}}>Onboard
                                                            </label>
                                                      
                                                        <!-- </div> -->
                                                    </div>  
                                                </div>
                                
                                <div class="dashboard-menu">
                                    <ul>
                                        <li>
                                            <a href="{{ route('cand.dashboard') }}"><i class="ti-dashboard"></i>Dashboard</a>
                                        </li>
                                        @if($profileimg[0]->candidate_status == 0)
                                        <li>
                                            <a href="{{ route('cand.profile') }}"><i class="ti-ruler-pencil"></i>Create Profile</a>
                                        </li>
                                        @endif
                                        @if($profileimg[0]->candidate_status == 1)
                                            <li class="active">
                                                <a href="{{ route('cand.edit') }}"><i class="ti-briefcase"></i>Update Profile</a>
                                            </li>
                                           
                                            <li>
                                                <a href="{{ route('endorsment.docs') }}"><i class="ti-briefcase"></i>Documents</a>
                                            </li>
                                        @endif
                                        
                                        @if( ($candidateData->docs_uploaded == 1) )
                                        <li>
                                            <a href="{{ route('cand.applylist') }}"><i class="ti-briefcase"></i>Job Applications</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('profileViewByEmployer') }}"><i class="ti-briefcase"></i>Profile Viewed BY Employer</a>
                                        </li>
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
                                            {{ 'You have '.$conversationUnreadCount.' unread messages.'  }}
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
                                @if( session('success') )
                                    <div class="alert alert-success alert-dismissable fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <b>Success ! </b>{{ session('success') }}
                                    </div>
                                @endif
                                <!-- Flash Msg on success-->
                                @if( session('error') )
                                    <div class="alert alert-danger alert-dismissable fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <b>Error ! </b>{{ session('error') }}
                                    </div>
                                @endif
                                @if( count($errors) > 0 )
                                    <div class="alert alert-danger alert-dismissable fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <ul>
                                             @foreach ($errors->all() as $error)
                                                 <li style="text-transform: capitalize;">{{ $error }}</li>
                                             @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <!-- Flash msg For document upload -->
                                @if( isset($profileimg[0]->docs_uploaded) && ($profileimg[0]->docs_uploaded == 0) )
                                    <div class="alert alert-danger alert-dismissable fade in">
                                        <!-- <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> -->
                                        <b>Error ! </b>{{ 'Active account by completing next step is to click on "Documents" from menu And update your documents avaibility.' }}
                                    </div>
                                @endif
                                <div class="dashboard-caption">
                                    
                                    <div class="dashboard-caption-header">
                                        <h4><i class="ti-briefcase"></i>Update Profile</h4>
                                    </div>
                                    
                                    <div class="dashboard-caption-wrap">
                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label style="font-size:18px !important;">
                                                        <span style="color: red;">*</span> Indicate Mandatory field.
                                                    </label> 
                                                </div>
                                            </div>
 
                                            <!-- row -->
                                            <input type="hidden" name="update_candidate" value="update">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label>Contact Number (Mobile)<span style="color: red;">*</span></label> 
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <input type="number" name="country_code" class="form-control" placeholder="91" value="{{ isset($country_code) ? $country_code : '' }}">
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <input type="number" name="phone_number" class="form-control" placeholder="xxxxxxxxxx" value="{{ isset($phone_number) ? $phone_number : '' }}">
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label>Contact Number (Landline)</label> 
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                                        <input type="number" name="country_code_landline" class="form-control" placeholder="91" value="{{ isset($country_code_landline) ? $country_code_landline : '' }}">
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                                        <input type="number" name="landline_number" class="form-control" placeholder="xxxxxxxxxx" value="{{ isset($landline_number) ? $landline_number : '' }}">
                                                        
                                                    </div>
                                                </div> 
                                            </div>


                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Email Address</label>
                                                        <?php $uemail = Session::get('userEmail');?>
                                                        <input type="text" class="form-control" value="<?php echo (isset($uemail)) ?  trim($uemail) : ''; ?>"  
                                                        disabled>
                                                    </div>  
                                                </div>
                                            </div>
                                             <!-- row -->
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Nationality<span style="color: red;">*</span></label>
                                                        <select name="nationality" id="jb-nationality" class="form-control">
                                                            <option value=''>Select Country</option>
                                                            @foreach ($countryList as $c)
                                                            <!-- <option value="{{ $c->countryname }}">{{ $c->countryname }}</option> -->
                                                            @if ($candidateData->nationality == $c->countryname)
                                                                <option value="{{ $c->countryname }}" selected>{{ $c->countryname }}</option>
                                                            @else
                                                                 <option value="{{ $c->countryname }}">{{ $c->countryname }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>  
                                                </div>
                                            </div>


                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label>Date of Birth<span style="color: red;">*</span></label>
                                                        <input type="text" name="dob" autocomplete="off" id="candidate-dob"  class="form-control" value="{{ $dob }}">
                                                    </div>  
                                                </div>
                                            </div>

                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Current Rank<span style="color: red;">*</span></label>
                                                        <select name="applied_for" id="position-appilied-for" class="form-control">
                                                            <option value="">Choose Rank</option>
<option value="Captain / Master" {{ $candidateData->applied_for =='Captain / Master' ? 'selected' : ''  }}>Captain / Master</option>
<option value="Chief Engineer" {{ $candidateData->applied_for=='Chief Engineer' ? 'selected' : ''  }}>Chief Engineer</option>
<option value="Chief Officer" {{ $candidateData->applied_for=='Chief Officer' ? 'selected' : ''  }}>Chief Officer</option>
<option value="2 nd Engineer" {{ $candidateData->applied_for=='2nd Engineer' ? 'selected' : ''  }}>2nd Engineer</option>
<option value="2 nd Officer" {{ $candidateData->applied_for=='2nd Officer' ? 'selected' : ''  }}>2nd Officer</option>
<option value="3 rd Engineer" {{ $candidateData->applied_for=='3rd Engineer' ? 'selected' : ''  }}>3rd Engineer</option>
<option value="3 rd Officer" {{ $candidateData->applied_for=='3rd Officer' ? 'selected' : ''  }}>3rd Officer</option>
<option value="4 th Engineer" {{ $candidateData->applied_for=='4th Engineer' ? 'selected' : ''  }}>4th Engineer</option>
<option value="Electrical Officer" {{ $candidateData->applied_for=='Electrical Officer' ? 'selected': ''  }}>Electrical Officer</option>
<option value="Electrical Technical Officer" {{ $candidateData->applied_for=='Electrical Technical Officer' ? 'selected' : ''  }}>Electrical Technical Officer</option>
<option value="Trainee Electrical Officer" {{ $candidateData->applied_for=='Trainee Electrical Officer' ? 'selected' : ''  }}>Trainee Electrical Officer</option>
<option value="AB" {{ $candidateData->applied_for=='AB' ? 'selected' : ''  }}>AB</option>
<option value="Oiler" {{ $candidateData->applied_for=='Oiler' ? 'selected' : ''  }}>Oiler</option>
<option value="Deck Cadet" {{ $candidateData->applied_for=='Deck Cadet' ? 'selected' : ''  }}>Deck Cadet</option>
<option value="Engine Cadet" {{ $candidateData->applied_for=='Engine Cadet' ? 'selected' : ''  }}>Engine Cadet</option>
<option value="OS" {{ $candidateData->applied_for=='OS' ? 'selected' : ''  }}>OS</option>
<option value="Wiper" {{ $candidateData->applied_for=='Wiper' ? 'selected' : ''  }}>Wiper</option>
<option value="Trainee OS" {{ $candidateData->applied_for=='Trainee OS' ? 'selected' : ''  }}>Trainee OS</option>
<option value="Trainee Wiper" {{ $candidateData->applied_for=='Trainee Wiper' ? 'selected' : ''  }}>Trainee Wiper</option>
<option value="Deck Fitter" {{ $candidateData->applied_for=='Deck Fitter' ? 'selected' : ''  }}>Deck Fitter</option>
<option value="Engine Fitter" {{ $candidateData->applied_for=='Engine Fitter' ? 'selected' : ''  }}>Engine Fitter</option>
<option value="Bosun" {{ $candidateData->applied_for=='Bosun' ? 'selected' : ''  }}>Bosun</option>
<option value="Pumpman" {{ $candidateData->applied_for=='Pumpman' ? 'selected' : ''  }}> Pumpman</option>
<option value="Motorman" {{ $candidateData->applied_for=='Motorman' ? 'selected' : ''  }}>Motorman</option>
<option value="Crane Operator" {{ $candidateData->applied_for=='Crane Operator' ? 'selected' : ''  }}>Crane Operator</option>
<option value="Chief Cook" {{ $candidateData->applied_for=='Chief Cook' ? 'selected' : ''  }}>Chief Cook</option>
<option value="Cook" {{ $candidateData->applied_for=='Cook' ? 'selected' : ''  }}>Cook</option>
<option value="2nd Cook" {{ $candidateData->applied_for=='2nd Cook' ? 'selected' : ''  }}>2nd Cook</option>
<option value="Assistant Cook" {{ $candidateData->applied_for=='Assistant Cook' ? 'selected' : ''  }}>Assistant Cook</option>
<option value="General Steward" {{ $candidateData->applied_for=='General Steward' ? 'selected' : ''  }}>General Steward</option>
<option value="Trainee General Steward" {{ $candidateData->applied_for=='Trainee General' ? 'selected' : ''  }}>Trainee General Steward</option>
                                                        </select>
                                                    </div>  
                                                </div>
                                            </div>
                                            

                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                         <label>My rank experience is of<span style="color: red;">*</span> </label>
                                                    </div>  
                                                </div>  
                                                    <div class="col-lg-4  col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                        <label>No. of Years<span style="color: red;">*</span></label>
                                                        <select name="experience_years" id="experience_years" class="form-control">
                                                            <option value=''>No. of Years</option>
                                                            <option value='0' {{ $candidateData->experience_years =='0' ? 'selected' : ''  }}>0</option>
                                                            <option value='1'{{ $candidateData->experience_years=='1' ? 'selected' : ''  }}>1</option>
                                                            <option value='2'{{ $candidateData->experience_years=='2' ? 'selected' : ''  }}>2</option>
                                                            <option value='3'{{ $candidateData->experience_years=='3' ? 'selected' : ''  }}>3</option>
                                                            <option value='4'{{ $candidateData->experience_years=='4' ? 'selected' : ''  }}>4</option>
                                                            <option value='5'{{ $candidateData->experience_years=='5' ? 'selected' : ''  }}>5</option>
                                                            <option value='6'{{ $candidateData->experience_years=='6' ? 'selected' : ''  }}>6</option>
                                                            <option value='7'{{ $candidateData->experience_years=='7' ? 'selected' : ''  }}>7</option>
                                                            <option value='8'{{ $candidateData->experience_years=='8' ? 'selected' : ''  }}>8</option>
                                                            <option value='9'{{ $candidateData->experience_years=='9' ? 'selected' : ''  }}>9</option>
                                                            <option value='10'{{ $candidateData->experience_years=='10' ? 'selected' : ''  }}>10</option>
                                                            <option value='11'{{ $candidateData->experience_years=='11' ? 'selected' : ''  }}>11</option>
                                                            <option value='12'{{ $candidateData->experience_years=='12' ? 'selected' : ''  }}>12</option>
                                                        </select>
                                                    
                                                        </div>
                                                    </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>No. of Months<span style="color: red;">*</span></label>
                                                        <select name="experience_months" id="jb-experience-months" class="form-control">
                                                            <option value=''>No. of Months</option>
                                                            <option value='0' {{ $candidateData->experience_months=='0' ? 'selected' : ''  }}>0</option>
                                                            <option value='1'{{ $candidateData->experience_months=='1' ? 'selected' : ''  }}>1</option>
                                                            <option value='2'{{ $candidateData->experience_months=='2' ? 'selected' : ''  }}>2</option>
                                                            <option value='3'{{ $candidateData->experience_months=='3' ? 'selected' : ''  }}>3</option>
                                                            <option value='4'{{ $candidateData->experience_months=='4' ? 'selected' : ''  }}>4</option>
                                                            <option value='5'{{ $candidateData->experience_months=='5' ? 'selected' : ''  }}>5</option>
                                                            <option value='6'{{ $candidateData->experience_months=='6' ? 'selected' : ''  }}>6</option>
                                                            <option value='7'{{ $candidateData->experience_months=='7' ? 'selected' : ''  }}>7</option>
                                                            <option value='8'{{ $candidateData->experience_months=='8' ? 'selected' : ''  }}>8</option>
                                                            <option value='9'{{ $candidateData->experience_months=='9' ? 'selected' : ''  }}>9</option>
                                                            <option value='10'{{ $candidateData->experience_months=='10' ? 'selected' : ''  }}>10</option>
                                                            <option value='11'{{ $candidateData->experience_months=='11' ? 'selected' : ''  }}>11</option>
                                                            <option value='12'{{ $candidateData->experience_months=='12' ? 'selected' : ''  }}>12</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="form-group">
                                                        <label>I am available from<span style="color: red;">*</span></label>
                                                        <input type="text" autocomplete="off" name="availablefrom" id="availablefrom"  class="form-control" 
                                                        value="{{ $availablefrom }}">
                                                    </div>  
                                                </div>
                                            </div>


                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label>I hold a Valid USA Visa (C1/D)<span style="color: red;">*</span></label>
                                                        <!-- <div class="col-lg-4 col-md-6 col-sm-12"> -->
                                                          <input name="usavisa_c1d" type="radio" value="yes" name="optradio" >Yes
                                                        <!-- </div> -->
                                                        <!-- <div class="col-lg-4 col-md-6 col-sm-12"> -->
                                                          <input name="usavisa_c1d" type="radio" value="no" name="optradio" checked>No
                                                        <!-- </div> -->
                                                    </div>  
                                                </div>
                                            </div>
                                            
                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label>I hold a Certificate of Competency / Watchkeeping from<span style="color: red;">*</span>
                                                        </label>
                                                        <select name="competency_certificate" id="jb-category" class="form-control">
                                                            <option value=''>Select Certificate of Competency</option>
                                                            <option value='Not Applicable' {{ $candidateData->competency_certificate=='Not Applicable' ? 'selected' : ''  }}>Not Applicable</option>
                                                            <option value='India' {{ $candidateData->competency_certificate=='India' ? 'selected' : ''  }}>India</option>
                                                            <option value='UK' {{ $candidateData->competency_certificate=='UK' ? 'selected' : ''  }}>UK</option>
                                                            <option value='Panama' {{ $candidateData->competency_certificate=='Panama' ? 'selected' : ''  }}>Panama</option>
                                                            <option value='Singapore' {{ $candidateData->competency_certificate=='Singapore' ? 'selected' : ''  }}>Singapore</option>
                                                            <option value='New Zealand' {{ $candidateData->competency_certificate=='New Zealand' ? 'selected' : ''  }}>New Zealand</option>
                                                            <option value='Australia' {{ $candidateData->competency_certificate=='Australia' ? 'selected' : ''  }}>Australia</option>
                                                            <option value='Honduras' {{ $candidateData->competency_certificate=='Honduras' ? 'selected' : ''  }}>Honduras</option>
                                                            <option value='Others' {{ $candidateData->competency_certificate=='Others' ? 'selected' : ''  }}>Others</option>
                                                        </select>
                                                    </div>  
                                                </div>
                                            </div>

                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Last vessel served<span style="color: red;">*</span></label>
                                                        <select name="last_vassel_served" id="last-vassel-served" class="form-control">
                                                            <option value="">Select vessel served</option>
                                                            <option value="Vessel Type" {{ $candidateData->last_vassel_served=='Vessel Type' ? 'selected' : ''  }}>Vessel Type</option>
                                                            <option value="Tanker Ship" {{ $candidateData->last_vassel_served=='Tanker Ship' ? 'selected' : ''  }}>Tanker Ship</option>
                                                            <option value="Container Ship"{{ $candidateData->last_vassel_served=='Container Ship' ? 'selected' : ''  }}>Container Ship</option>
                                                            <option value="General Cargo Ship"{{ $candidateData->last_vassel_served=='General Cargo Ship' ? 'selected' : ''  }}>General Cargo Ship</option>
                                                            <option value="Bulk Carrier" {{ $candidateData->last_vassel_served=='Bulk Carrier' ? 'selected' : ''  }}>Bulk Carrier</option>
                                                            <option value="Car Carrier / Ro-Ro Ship" {{ $candidateData->last_vassel_served=='Car Carrier / Ro-Ro Ship' ? 'selected' : ''  }}>Car Carrier / Ro-Ro Ship</option>
                                                            <option value="Live-Stock Carrier" {{ $candidateData->last_vassel_served=='Live-Stock Carrier' ? 'selected' : ''  }}>Live-Stock Carrier</option>
                                                            <option value="Passenger Ship" {{ $candidateData->last_vassel_served=='Passenger Ship' ? 'selected' : ''  }}>Passenger Ship</option>
                                                            <option value="Offshore Ship" {{ $candidateData->last_vassel_served=='Offshore Ship' ? 'selected' : ''  }}>Offshore Ship</option>
                                                            <option value="Special Purpose Ship" {{ $candidateData->last_vassel_served=='Special Purpose Ship' ? 'selected' : ''  }}>Special Purpose Ship</option>
                                                            <option value="Other Ship"{{ $candidateData->last_vassel_served=='Other Ship' ? 'selected' : ''  }}>Other Ship </option>
                                                            <option value="Not Applicable"{{ $candidateData->last_vassel_served=='Not Applicable' ? 'selected' : ''  }}>Not Applicable </option>
                                                        </select>
                                                    </div>  
                                                </div>
                                            </div>

                                            <!-- row -->
                                            <!-- row -->
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label>Vessel Size<span style="color: red;">*</span></label> 
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <input type="number" name="vassel_dwt" class="form-control" placeholder="DWT  Size" value="{{ $candidateData->vassel_dwt }}">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <input type="number" name="vassel_grt" class="form-control" placeholder="GRT  size" value="{{ $candidateData->vassel_dwt }}">
                                                    </div>
                                                </div> 
                                            </div>

                                            
                                            <!-- row -->
                                            <div class="row mrg-top-20" style="ma">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <label>My CV / Resume <span style="color: red;">*</span></label> 
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <span class="control-fileupload">
                                                        <label for="file">My CV / Resume</label>
                                                        <input type="file" name="resume_file" id="resume_file" value="{{ old('resume_file') }}">
                                                        </span>
                                                    </div>  
                                                </div>
                                                <?php
                                                    $ResumeFile = url('public/resume/'.$resume_file);
                                                ?>
                                                <!-- <a href="{{ $ResumeFile }}" style="margin-left:2%;font-size: 18px;">
                                                    Download Resume
                                                </a> -->
                                                <a href="{{ route('download.resume',$candidateData->id) }}" style="margin-left:2%;font-size: 18px;" class="btn btn-info small-width"><i class="ti-download mrg-r-5"></i>Download Resume</a>
                                            </div>
                                            
                                            

                                            <!-- row -->
                                            <div class="row mrg-top-30">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group text-center">
                                                        <button type="submit" class="btn-savepreview"><i class="ti-angle-double-right"></i>Update </button>
                                                    </div>  
                                                </div>
                                            </div>

                                            
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
    </section>
@endsection
@section('datepicker')
<script>
    // $('#candidate-dob').dateDropper();
    // $('#availablefrom').dateDropper();
    $('#expirejob').dateDropper();
    /* Current working DatepIcker */
    $( "#candidate-dob" ).datepicker({
        defaultDate: null,
        changeYear: true,
        changeMonth: true,        
        yearRange: '1950:2100',        
    });

    $( "#availablefrom" ).datepicker({
        defaultDate: null,
        changeYear: true,
        changeMonth: true,        
        yearRange: '1950:2100',
        minDate: 0
    });

    //resume upload 
    $(function() {
      $('input[type=file]').change(function(){
        var t = $(this).val();
        var labelText = 'File : ' + t.substr(12, t.length);
        $(this).prev('label').text(labelText);
      });   

    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>

@endsection