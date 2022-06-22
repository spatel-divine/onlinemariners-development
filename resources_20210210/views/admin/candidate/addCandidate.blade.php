@extends('layouts.app_adminafterlogin')
@section('content')
<?php 
use Illuminate\Support\Facades\Input; 
?>
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
      Add Candidate
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Add Candidate</li>
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
              <h3 class="box-title">Add Candidate Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="{{ route('addCandidate') }}" enctype="multipart/form-data" >
              @csrf
              <!-- <input type="hidden" name="id" value=""> -->
              <div class="box-body">
                <div class="form-group">                  
                  <div class="col-sm-offset-3 col-sm-9">
                    <?php 
                      if(isset($candidate[0]->profile_path)){
                        $profileimg = $candidate[0]->profile_path;
                      }else{
                       $profileimg = ''; 
                      }
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
                    <input type="file" name="profile_path" id="profile_path" required>
                  </div>                  
                </div>
                <!-- phone number -->
                <div class="row">
                  <div class="col-sm-3 control-label">
                      <label>Contact Number<span style="color: red;">*</span></label> 
                  </div>
                  <div class="form-group">
                      <div class="col-sm-2">
                          <input type="number" name="country_code" class="form-control" placeholder="Country Code" value="">
                      </div>
                      <div class="col-sm-6">
                          <input type="number" name="phone_number" class="form-control" placeholder="Phone Number" value="">
                      </div>
                  </div> 
                </div>
                <!-- Name -->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Name<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" value="" placeholder="Name" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Email<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="email" name="email" class="form-control"  value="" placeholder="Email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Password<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" name="password" class="form-control"  value="" placeholder="Password" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Phone Number<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" name="phone_number" class="form-control" value="" placeholder="Contact Person" required>
                  </div>
                </div>                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Nationality</label>
                  <div class="col-sm-9">
                    <select name="nationality" id="jb-nationality" class="form-control">
                      <option value=''>Select Country</option>
                      @foreach ($countryList as $c)
                      <!-- <option value="{{ $c->countryname }}">{{ $c->countryname }}</option> -->
                      @if (Input::old('nationality') == $c->countryname)
                          <option value="{{ $c->countryname }}" selected>{{ $c->countryname }}</option>
                      @else
                           <option value="{{ $c->countryname }}">{{ $c->countryname }}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Date of Birth<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="date" name="dob" class="form-control" value="" placeholder="Date Of Birth" required>

                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Rank<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select name="applied_for" id="position-appilied-for" class="form-control" required>
                        <option value="">Choose Position</option>
                            <option value="Captain / Master" >Captain / Master</option>
                            <option value="Chief Engineer" >Chief Engineer</option>
                            <option value="Chief Officer" >Chief Officer</option>
                            <option value="2 nd Engineer" >2nd Engineer</option>
                            <option value="2 nd Officer" >2nd Officer</option>
                            <option value="3 rd Engineer" >3rd Engineer</option>
                            <option value="3 rd Officer" >3rd Officer</option>
                            <option value="4 th Engineer" >4th Engineer</option>
                            <option value="Electrical Officer" >Electrical Officer</option>
                            <option value="Electrical Technical Officer" >Electrical Technical Officer</option>
                            <option value="Trainee Electrical Officer" >Trainee Electrical Officer</option>
                            <option value="AB" >AB</option>
                            <option value="Oiler" >Oiler</option>
                            <option value="Deck Cadet" >Deck Cadet</option>
                            <option value="Engine Cadet" >Engine Cadet</option>
                            <option value="OS" >OS</option>
                            <option value="Wiper" >Wiper</option>
                            <option value="Trainee OS" >Trainee OS</option>
                            <option value="Trainee Wiper" >Trainee Wiper</option>
                            <option value="Deck Fitter" >Deck Fitter</option>
                            <option value="Engine Fitter" >Engine Fitter</option>
                            <option value="Bosun" >Bosun</option>
                            <option value="Pumpman" > Pumpman</option>
                            <option value="Motorman" >Motorman</option>
                            <option value="Crane Operator" >Crane Operator</option>
                            <option value="Chief Cook" >Chief Cook</option>
                            <option value="Cook" >Cook</option>
                            <option value="2nd Cook" >2nd Cook</option>
                            <option value="Assistant Cook" >Assistant Cook</option>
                            <option value="General Steward" >General Steward</option>
                            <option value="Trainee General Steward" >Trainee General Steward</option>
                        </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Experience in Years<span style="color: red;">*</span></label>
                  <div class="col-sm-3">
                    <select name="experience_years" id="experience_years" class="form-control" required>
                        <option value=''>No of years</option>
                        <option value='0'>0</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>
                        <option value='6'>6</option>
                        <option value='7'>7</option>
                        <option value='8'>8</option>
                        <option value='9'>9</option>
                        <option value='10'>10</option>
                        <option value='11'>11</option>
                        <option value='12'>12</option>
                    </select>
                  </div>

                  <label for="inputPassword3" class="col-sm-3 control-label">Experience in Months<span style="color: red;">*</span></label>
                  <div class="col-sm-3">
                    <select name="experience_months" id="experience_months" class="form-control" required>
                        <option value=''>No of Months</option>
                        <option value='0' >0</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>
                        <option value='6'>6</option>
                        <option value='7'>7</option>
                        <option value='8'>8</option>
                        <option value='9'>9</option>
                        <option value='10'>10</option>
                        <option value='11'>11</option>
                        <option value='12'>12</option>
                    </select>
                  </div>
                </div> 

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Available From<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="date" name="availablefrom" id="availablefrom" class="form-control hasDatepicker" placeholder="Enter Date" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Competency Certificate / Watchkeeping<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                     <select name="competency_certificate" id="jb-category" class="form-control" required>
                        <option value=''>Select Certificate of Competency</option>
                        <option value='Not Applicable'>Not Applicable</option>
                        <option value='India'>India</option>
                        <option value='UK'>UK</option>
                        <option value='Panama'>Panama</option>
                        <option value='Singapore'>Singapore</option>
                        <option value='New Zealand'>New Zealand</option>
                        <option value='Australia'>Australia</option>
                        <option value='Honduras'>Honduras</option>
                    </select>
                  </div>
                </div>

                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Last vessel Served<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                     <select name="last_vassel_served" id="last-vassel-served" class="form-control" required>
                          <option value="">Select vessel served</option>
                          <option value="Vessel Type">Vessel Type</option>
                          <option value="Tanker Ship">Tanker Ship</option>
                          <option value="Container Ship">Container Ship</option>
                          <option value="General Cargo Ship">General Cargo Ship</option>
                          <option value="Bulk Carrier">Bulk Carrier</option>
                          <option value="Car Carrier / Ro-Ro Ship">Car Carrier / Ro-Ro Ship</option>
                          <option value="Live-Stock Carrier">Live-Stock Carrier</option>
                          <option value="Passenger Ship">Passenger Ship</option>
                          <option value="Offshore Ship">Offshore Ship</option>
                          <option value="Special Purpose Ship">Special Purpose Ship</option>
                          <option value="Other Ship">Other Ship </option>
                      </select>
                  </div>
                </div>
              
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">My CV / Resume<span style="color: red;">*</span></label>
                  <div class="col-sm-9">                    
                    <input type="file" name="resume_file" id="resume_file" required>
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="col-sm-offset-2 btn btn-default">Add</button>
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
  //available from
  $( "#available_fromas").datepicker({
      defaultDate: null,
      changeYear: true,
      changeMonth: true,
      yearRange: '1950:2100',
  });

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