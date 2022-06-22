@extends('layouts.app_adminafterlogin')
@section('content')
<style type="text/css">
    table.table-bordered.dataTable tbody td {
      border-bottom-width: 0;
      text-transform: capitalize;
    }
</style>
<div class="content-wrapper">
  <?php
    // echo '<pre>';
    // print_r($candidate);
  ?>
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      Edit Candidate
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Edit Candidate</li>
    </ol>
  </section>
  <!-- Main Content -->
  <section class="content">  
    <div class="row">
      <div class="col-sm-10">
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
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Candidate Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="{{ route('updateCandidate', ['id' => $candidate[0]->id]) }}" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" name="id" value="{{ $candidate[0]->id }}">
              <div class="box-body">
                <div class="form-group">                  
                  <div class="col-sm-offset-3 col-sm-9">
                    <?php 
                      $profileimg = $candidate[0]->profile_path;
                      if($profileimg){
                        $path = url('/public/profile/'.$profileimg);
                      }else{
                        $path = url('public/assets/img/avatar-default.png');
                      }
                    ?>
                    <img id="profileimg" src="{{ $path }}" alt="profileimg" height="80" width="80" />
                  </div>                  
                </div>                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Profile Picture</label>
                  <div class="col-sm-9">
                    <input type="hidden" name="old_pic_path" value="">
                    <input type="file" name="profile_path" id="profile_path">
                  </div>                  
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" value="{{ $candidate[0]->name }}" placeholder="Name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-9">
                    <input type="email" name="email" class="form-control"  value="{{ $candidate[0]->email }}" placeholder="Email">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                  <div class="col-sm-9">
                    <input type="text" name="password" class="form-control" placeholder="Password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Phone Number</label>
                  <div class="col-sm-9">
                    <input type="text" name="phone_number" class="form-control" value="{{ $candidate[0]->phone_number }}" placeholder="Contact Person">
                  </div>
                </div>                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Nationality</label>
                  <div class="col-sm-9">
                    <input type="text" name="nationality" class="form-control" value="{{ $candidate[0]->nationality }}" placeholder="Nationality">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Date of Birth</label>
                  <div class="col-sm-9">
                    <input type="text" name="dob" class="form-control" value="{{ date('m-d-Y', strtotime($candidate[0]->dob)) }}" placeholder="Date Of Birth">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Rank</label>
                  <div class="col-sm-9">
                    <select name="applied_for" id="position-appilied-for" class="form-control">
                                                            <option value="">Choose Position</option>
<option value="Captain / Master" {{ $candidate[0]->applied_for =='Captain / Master' ? 'selected' : ''  }}>Captain / Master</option>
<option value="Chief Engineer" {{ $candidate[0]->applied_for=='Chief Engineer' ? 'selected' : ''  }}>Chief Engineer</option>
<option value="Chief Officer" {{ $candidate[0]->applied_for=='Chief Officer' ? 'selected' : ''  }}>Chief Officer</option>
<option value="2 nd Engineer" {{ $candidate[0]->applied_for=='2nd Engineer' ? 'selected' : ''  }}>2nd Engineer</option>
<option value="2 nd Officer" {{ $candidate[0]->applied_for=='2nd Officer' ? 'selected' : ''  }}>2nd Officer</option>
<option value="3 rd Engineer" {{ $candidate[0]->applied_for=='3rd Engineer' ? 'selected' : ''  }}>3rd Engineer</option>
<option value="3 rd Officer" {{ $candidate[0]->applied_for=='3rd Officer' ? 'selected' : ''  }}>3rd Officer</option>
<option value="4 th Engineer" {{ $candidate[0]->applied_for=='4th Engineer' ? 'selected' : ''  }}>4th Engineer</option>
<option value="Electrical Officer" {{ $candidate[0]->applied_for=='Electrical Officer' ? 'selected': ''  }}>Electrical Officer</option>
<option value="Electrical Technical Officer" {{ $candidate[0]->applied_for=='Electrical Technical Officer' ? 'selected' : ''  }}>Electrical Technical Officer</option>
<option value="Trainee Electrical Officer" {{ $candidate[0]->applied_for=='Trainee Electrical Officer' ? 'selected' : ''  }}>Trainee Electrical Officer</option>
<option value="AB" {{ $candidate[0]->applied_for=='AB' ? 'selected' : ''  }}>AB</option>
<option value="Oiler" {{ $candidate[0]->applied_for=='Oiler' ? 'selected' : ''  }}>Oiler</option>
<option value="Deck Cadet" {{ $candidate[0]->applied_for=='Deck Cadet' ? 'selected' : ''  }}>Deck Cadet</option>
<option value="Engine Cadet" {{ $candidate[0]->applied_for=='Engine Cadet' ? 'selected' : ''  }}>Engine Cadet</option>
<option value="OS" {{ $candidate[0]->applied_for=='OS' ? 'selected' : ''  }}>OS</option>
<option value="Wiper" {{ $candidate[0]->applied_for=='Wiper' ? 'selected' : ''  }}>Wiper</option>
<option value="Trainee OS" {{ $candidate[0]->applied_for=='Trainee OS' ? 'selected' : ''  }}>Trainee OS</option>
<option value="Trainee Wiper" {{ $candidate[0]->applied_for=='Trainee Wiper' ? 'selected' : ''  }}>Trainee Wiper</option>
<option value="Deck Fitter" {{ $candidate[0]->applied_for=='Deck Fitter' ? 'selected' : ''  }}>Deck Fitter</option>
<option value="Engine Fitter" {{ $candidate[0]->applied_for=='Engine Fitter' ? 'selected' : ''  }}>Engine Fitter</option>
<option value="Bosun" {{ $candidate[0]->applied_for=='Bosun' ? 'selected' : ''  }}>Bosun</option>
<option value="Pumpman" {{ $candidate[0]->applied_for=='Pumpman' ? 'selected' : ''  }}> Pumpman</option>
<option value="Motorman" {{ $candidate[0]->applied_for=='Motorman' ? 'selected' : ''  }}>Motorman</option>
<option value="Crane Operator" {{ $candidate[0]->applied_for=='Crane Operator' ? 'selected' : ''  }}>Crane Operator</option>
<option value="Chief Cook" {{ $candidate[0]->applied_for=='Chief Cook' ? 'selected' : ''  }}>Chief Cook</option>
<option value="Cook" {{ $candidate[0]->applied_for=='Cook' ? 'selected' : ''  }}>Cook</option>
<option value="2nd Cook" {{ $candidate[0]->applied_for=='2nd Cook' ? 'selected' : ''  }}>2nd Cook</option>
<option value="Assistant Cook" {{ $candidate[0]->applied_for=='Assistant Cook' ? 'selected' : ''  }}>Assistant Cook</option>
<option value="General Steward" {{ $candidate[0]->applied_for=='General Steward' ? 'selected' : ''  }}>General Steward</option>
<option value="Trainee General Steward" {{ $candidate[0]->applied_for=='Trainee General' ? 'selected' : ''  }}>Trainee General Steward</option>
                                                        </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Experience in Years</label>
                  <div class="col-sm-3">
                    <select name="experience_years" id="experience_years" class="form-control">
                        <option value=''>No of years</option>
                        <option value='0' {{ $candidate[0]->experience_years =='0' ? 'selected' : ''  }}>0</option>
                        <option value='1'{{ $candidate[0]->experience_years=='1' ? 'selected' : ''  }}>1</option>
                        <option value='2'{{ $candidate[0]->experience_years=='2' ? 'selected' : ''  }}>2</option>
                        <option value='3'{{ $candidate[0]->experience_years=='3' ? 'selected' : ''  }}>3</option>
                        <option value='4'{{ $candidate[0]->experience_years=='4' ? 'selected' : ''  }}>4</option>
                        <option value='5'{{ $candidate[0]->experience_years=='5' ? 'selected' : ''  }}>5</option>
                        <option value='6'{{ $candidate[0]->experience_years=='6' ? 'selected' : ''  }}>6</option>
                        <option value='7'{{ $candidate[0]->experience_years=='7' ? 'selected' : ''  }}>7</option>
                        <option value='8'{{ $candidate[0]->experience_years=='8' ? 'selected' : ''  }}>8</option>
                        <option value='9'{{ $candidate[0]->experience_years=='9' ? 'selected' : ''  }}>9</option>
                        <option value='10'{{ $candidate[0]->experience_years=='10' ? 'selected' : ''  }}>10</option>
                        <option value='11'{{ $candidate[0]->experience_years=='11' ? 'selected' : ''  }}>11</option>
                        <option value='12'{{ $candidate[0]->experience_years=='12' ? 'selected' : ''  }}>12</option>
                    </select>
                  </div>

                  <label for="inputPassword3" class="col-sm-3 control-label">Experience in Months</label>
                  <div class="col-sm-3">
                    <select name="experience_months" id="experience_months" class="form-control">
                        <option value=''>No Of Months</option>
                        <option value='0' {{ $candidate[0]->experience_months =='0' ? 'selected' : ''  }}>0</option>
                        <option value='1'{{ $candidate[0]->experience_months=='1' ? 'selected' : ''  }}>1</option>
                        <option value='2'{{ $candidate[0]->experience_months=='2' ? 'selected' : ''  }}>2</option>
                        <option value='3'{{ $candidate[0]->experience_months=='3' ? 'selected' : ''  }}>3</option>
                        <option value='4'{{ $candidate[0]->experience_months=='4' ? 'selected' : ''  }}>4</option>
                        <option value='5'{{ $candidate[0]->experience_months=='5' ? 'selected' : ''  }}>5</option>
                        <option value='6'{{ $candidate[0]->experience_months=='6' ? 'selected' : ''  }}>6</option>
                        <option value='7'{{ $candidate[0]->experience_months=='7' ? 'selected' : ''  }}>7</option>
                        <option value='8'{{ $candidate[0]->experience_months=='8' ? 'selected' : ''  }}>8</option>
                        <option value='9'{{ $candidate[0]->experience_months=='9' ? 'selected' : ''  }}>9</option>
                        <option value='10'{{ $candidate[0]->experience_months=='10' ? 'selected' : ''  }}>10</option>
                        <option value='11'{{ $candidate[0]->experience_months=='11' ? 'selected' : ''  }}>11</option>
                        <option value='12'{{ $candidate[0]->experience_months=='12' ? 'selected' : ''  }}>12</option>
                    </select>
                  </div>
                </div> 

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Competency Certificate / Watchkeeping</label>
                  <div class="col-sm-9">
                     <select name="competency_certificate" id="jb-category" class="form-control">
                        <option value=''>Select Certificate of Competency</option>
                        <option value='Not Applicable' {{ $candidate[0]->competency_certificate=='Not Applicable' ? 'selected' : ''  }}>Not Applicable</option>
                        <option value='India' {{ $candidate[0]->competency_certificate=='India' ? 'selected' : ''  }}>India</option>
                        <option value='UK' {{ $candidate[0]->competency_certificate=='UK' ? 'selected' : ''  }}>UK</option>
                        <option value='Panama' {{ $candidate[0]->competency_certificate=='Panama' ? 'selected' : ''  }}>Panama</option>
                        <option value='Singapore' {{ $candidate[0]->competency_certificate=='Singapore' ? 'selected' : ''  }}>Singapore</option>
                        <option value='New Zealand' {{ $candidate[0]->competency_certificate=='New Zealand' ? 'selected' : ''  }}>New Zealand</option>
                        <option value='Australia' {{ $candidate[0]->competency_certificate=='Australia' ? 'selected' : ''  }}>Australia</option>
                        <option value='Honduras' {{ $candidate[0]->competency_certificate=='Honduras' ? 'selected' : ''  }}>Honduras</option>
                    </select>
                  </div>
                </div>

                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Last vessel served</label>
                  <div class="col-sm-9">
                     <select name="last_vassel_served" id="last-vassel-served" class="form-control">
                          <option value="">Select vessel served</option>
                          <option value="Vessel Type" {{ $candidate[0]->last_vassel_served=='Vessel Type' ? 'selected' : ''  }}>Vessel Type</option>
                          <option value="Tanker Ship" {{ $candidate[0]->last_vassel_served=='Tanker Ship' ? 'selected' : ''  }}>Tanker Ship</option>
                          <option value="Container Ship"{{ $candidate[0]->last_vassel_served=='Container Ship' ? 'selected' : ''  }}>Container Ship</option>
                          <option value="General Cargo Ship"{{ $candidate[0]->last_vassel_served=='General Cargo Ship' ? 'selected' : ''  }}>General Cargo Ship</option>
                          <option value="Bulk Carrier" {{ $candidate[0]->last_vassel_served=='Bulk Carrier' ? 'selected' : ''  }}>Bulk Carrier</option>
                          <option value="Car Carrier / Ro-Ro Ship" {{ $candidate[0]->last_vassel_served=='Car Carrier / Ro-Ro Ship' ? 'selected' : ''  }}>Car Carrier / Ro-Ro Ship</option>
                          <option value="Live-Stock Carrier" {{ $candidate[0]->last_vassel_served=='Live-Stock Carrier' ? 'selected' : ''  }}>Live-Stock Carrier</option>
                          <option value="Passenger Ship" {{ $candidate[0]->last_vassel_served=='Passenger Ship' ? 'selected' : ''  }}>Passenger Ship</option>
                          <option value="Offshore Ship" {{ $candidate[0]->last_vassel_served=='Offshore Ship' ? 'selected' : ''  }}>Offshore Ship</option>
                          <option value="Special Purpose Ship" {{ $candidate[0]->last_vassel_served=='Special Purpose Ship' ? 'selected' : ''  }}>Special Purpose Ship</option>
                          <option value="Other Ship"{{ $candidate[0]->last_vassel_served=='Other Ship' ? 'selected' : ''  }}>Other Ship </option>
                      </select>
                  </div>
                </div>
              
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">My CV / Resume</label>
                  <div class="col-sm-9">                    
                    <input type="file" name="resume_file" id="resume_file">
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="col-sm-offset-2 btn btn-default">Update</button>
                <a href="{{ route('candidate.listing') }}" class="btn btn-info">Cancel</a>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
      </div><!-- col-sm-12 -->
    </div><!-- end of row -->
  </section>
</div>
@endsection
@section('custom_js')
<script type="text/javascript">
  
    //profile pic
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profileimg').attr('src', e.target.result);              
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#pic_path").change(function(){
        readURL(this);
    });

    </script>
@endsection