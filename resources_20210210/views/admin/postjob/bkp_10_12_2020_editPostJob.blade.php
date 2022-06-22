@extends('layouts.app_adminafterlogin')
@section('content')

<?php
  $rank_position = [];
  $wage_list = [];
  $contract_duration = [];
  $experience_years = [];
  $experience_months = [];
  // $i = 0;
  // echo count($wages);
  // exit;
  $final = [];
  foreach ($wages as $k => $v) {    
    $sub = [];
    // echo $v->rank_position.'<br>';
    $rank_position[] = $v->rank_position;
    $wage_list[] = $v->wages;
    $contract_duration[] = $v->contract_duration;
    $experience_years[] = $v->experience_years;
    $experience_months[] = $v->experience_months;
    $sub['rank_position'] = $v->rank_position; 
    $sub['contract_duration'] = $v->contract_duration; 
    $sub['experience_years'] = $v->experience_years; 
    $sub['experience_months'] = $v->experience_months;
    $sub['wages'] = $v->wages; 

    $final[] = $sub; 
  }

  // $final = json_encode($final);
  //print_r($final);
  //exit;
  // echo "<pre>";
  // print_r($postjobs);
  // exit;
  $oldWages = implode(",",$rank_position);  
?>
<style type="text/css">
    table.table-bordered.dataTable tbody td {
      border-bottom-width: 0;
      text-transform: capitalize;
    }
/* dynamoc rank table */
    form{
        margin: 20px 0;
    }
    form input, button{
        padding: 5px;
    }
    table{
        width: 100%;
        margin-bottom: 20px;
    border-collapse: collapse;
    }
    table, th, td{
        border: 1px solid #cdcdcd;
    }
    table th, table td{
        padding: 10px;
        text-align: left;
    }
</style>
<div class="content-wrapper">
  <?php
    // echo '<pre>';
    // print_r($postjobs);
    // exit;
  ?>
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      Edit Postjob
      <!-- <small>advanced tables</small> -->
    </h1>
    <!--Breadcrumb -->
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Edit Postjob</li>
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
              <h3 class="box-title">Edit Postjob Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal add-employee-form" method="POST" action="{{ route('updatePostjobAdmin') }}" enctype="multipart/form-data" >
              @csrf              
              <input type="hidden" name="id" value="{{ isset($postjobs[0]->id) ? $postjobs[0]->id : '' }}">
              <div class="box-body">
                <!-- Company Name -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Company Name</label>
                  <div class="col-sm-10">
                    <select name="employer_id" id="jb-nationality" class="form-control" required>
                      <option value=''>Select Company Name</option>
                      @foreach ($employerList as $emp)                      
                          <option value="{{ $emp->id  }}" {{ ($postjobs[0]->employer_id == $emp->id) ? 'selected' : '' }} style="text-transform: capitalize;">
                            {{ $emp->company_name }}
                          </option>
                      @endforeach
                    </select>
                  </div>
                </div>                
                
                <!-- Job Title -->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Job Title</label>
                  <div class="col-sm-10">
                    <input type="text" name="job_title" class="form-control" value="{{-- isset($postjobs[0]->job_title) ? $postjobs[0]->job_title : '' --}}" placeholder="Job Title" required>
                  </div>
                </div>

                <!-- Job Description -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Job Description</label>
                  <div class="col-sm-10">
                    <!-- <input type="email" name="email" class="form-control"  value="" placeholder="Job Description" required> -->
                    <textarea id="job_description" class="form-control" name="job_description" rows="5" cols="106" placeholder="Job Description">{{ isset($postjobs[0]->job_description) ? $postjobs[0]->job_description : '' }}</textarea>
                  </div>
                </div>

                <!-- App Deadline -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Application Deadline</label>
                  <div class="col-sm-10">
                    <input type="text" name="app_deadline" class="form-control" value="{{ isset($postjobs[0]->app_deadline) ? date( 'm/d/Y', strtotime($postjobs[0]->app_deadline) ) : '' }}" placeholder="App Deadline" id="app_deadline" autocomplete="off" required>
                  </div>
                </div>
                <!-- label MULTI SELECT -->
                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                    <b style="color: green;">Press Ctrl + Mouse right click to add other ranks from options</b>
                  </div>
                </div> -->

                <!-- Rank Postion -->
                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Rank Postion*:</label>
                  <div class="col-sm-10">
                   <label>Select Rank*: </label>                            
                      <select id="rank1" name="rank1[]" class="form-control custom-select rank1" multiple required>
                        <option value="">Choose Position</option>
                        <option value="Captain / Master" >Captain / Master</option>
                        <option value="Chief Engineer"  >Chief Engineer</option>
                        <option value="Chief Officer"  >Chief Officer</option>
                        <option value="2nd Engineer"  >2nd Engineer</option>
                        <option value="2nd Officer"  >2nd Officer</option>
                        <option value="3rd Engineer">3rd Engineer</option>
                        <option value="3rd Officer" >3rd Officer</option>
                        <option value="4th Engineer">4th Engineer</option>
                        <option value="Electrical Officer">Electrical Officer</option>
                        <option value="Electrical Technical Officer">Electrical Technical Officer</option>
                        <option value="Trainee Electrical Officer">Trainee Electrical Officer</option>
                        <option value="AB">AB</option>
                        <option value="Oiler">Oiler</option>
                        <option value="Deck Cadet">Deck Cadet</option>
                        <option value="Engine Cadet">Engine Cadet</option>
                        <option value="OS">OS</option>
                        <option value="Wiper">Wiper</option>
                        <option value="Trainee OS">Trainee OS</option>
                        <option value="Trainee Wiper">Trainee Wiper</option>
                        <option value="Deck Fitter">Deck Fitter</option>
                        <option value="Engine Fitter">Engine Fitter</option>
                        <option value="Bosun">Bosun</option>
                        <option value="Pumpman"> Pumpman</option>
                        <option value="Motorman">Motorman</option>
                        <option value="Crane Operator">Crane Operator</option>
                        <option value="Chief Cook">Chief Cook</option>
                        <option value="Cook">Cook</option>
                        <option value="2nd Cook">2nd Cook</option>
                        <option value="Assistant Cook">Assistant Cook</option>
                        <option value="General Steward">General Steward</option>
                        <option value="Trainee General Steward">Trainee General Steward</option>
                      </select>
                  </div>
                </div>
 -->
               <!-- Dynamic rank  Insert &  Delete button for ranks -->              
              <div class="form-group" style="margin-top: 0%">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                  <input class="col-sm-2 btn btn-info" type='button' value='+ Add' id='addButton'>
                  <input class="col-sm-2 btn btn-warning" type='button' value='- Remove' id='removeButton' style="margin-left:10px;">  
                </div>
              </div>
              <!-- wage-->
              <!-- <div class="col-sm-12" style="margin-left: 15.7%;">
                <div id="wages" class="">
                </div>                    
              </div> -->
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Rank Postion*:</label>
                <div id="wages" class="col-sm-10"></div>
              </div>
              <!-- <div class="form-group">
                <div class="row"></div>
              </div> -->

             
               <!-- Dynamic rank Tabele -->
                <div class="form-group">
                  <!-- <label for="inputPassword3" class="col-sm-2 control-label">Rank Postion*:</label> -->
                  
                  <label for="inputPassword3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10" style="margin-top:-36px">
                    <div class="card-box">
                  <div id='TextBoxesGroup'>
                      <div id="TextBoxDiv0">
                        <div class="row">                
                            <div class="afterthis col-md-12 col-lg-12 col-sm-12">
                            <table id="BoxTable" >
                                <!-- style="width: 866px;" -->
                                <tbody id="appendhere">
                                  
                                </tbody>
                              </table>
                            </div>
                        </div><!-- end of row -->
                      </div>
                      <!-- TextBoxDiv0 -->
                      </div>
                </div> 
                  </div>
                </div>      
              <!-- Vassel Type -->              
              <div class="form-group">
                <label class="col-sm-2 control-label">Vassel Type*</label>
                <div class="col-sm-10">
                  <select name="vassel_type" class="form-control custom-select" required><!-- multiple-->
                    <option value="" >Vessel Type</option>
                    <option value="Tanker Ship" {{ ($postjobs[0]->vassel_type =='Tanker Ship') ? 'selected' : ''  }}>Tanker Ship</option>
                    <option value="Container Ship"{{ ($postjobs[0]->vassel_type =='Container Ship') ? 'selected' : ''  }}>Container Ship</option>
                    <option value="General Cargo Ship"{{ ($postjobs[0]->vassel_type =='General Cargo Ship') ? 'selected' : ''  }}>General Cargo Ship</option>
                    <option value="Bulk Carrier" {{ ($postjobs[0]->vassel_type =='Bulk Carrier') ? 'selected' : ''  }}>Bulk Carrier</option>
                    <option value="Car Carrier / Ro-Ro Ship" {{ ($postjobs[0]->vassel_type =='Car Carrier / Ro-Ro Ship') ? 'selected' : ''  }}>Car Carrier / Ro-Ro Ship</option>
                    <option value="Live-Stock Carrier" {{ ($postjobs[0]->vassel_type =='Live-Stock Carrier') ? 'selected' : ''  }}>Live-Stock Carrier</option>
                    <option value="Passenger Ship" {{ ($postjobs[0]->vassel_type =='Passenger Ship') ? 'selected' : ''  }}>Passenger Ship</option>
                    <option value="Offshore Ship" {{ ($postjobs[0]->vassel_type =='Offshore Ship') ? 'selected' : ''  }}>Offshore Ship</option>
                    <option value="Special Purpose Ship" {{ ($postjobs[0]->vassel_type =='Special Purpose Ship') ? 'selected' : ''  }}>Special Purpose Ship</option>
                    <option value="Other Ship"{{ ($postjobs[0]->vassel_type =='Other Ship') ? 'selected' : ''  }}>Other Ship </option>
                  </select>
                </div>
              </div> 
              <!-- Country -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                     <select name='country' class="form-control" id="country" required>
                        <option value=""> Select Country</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->name }}" {{ ($postjobs[0]->country == $country->name) ? "selected":"" }}>{{ $country->name }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>  
                <!-- State -->
                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">State*</label>
                  <div class="col-sm-10">
                     <select name='state' class="form-control" id="State" required>
                        <option value=""> Select State</option>
                        @foreach($states as $state)
                        <option value="{{ $state->name }}" {{ ($postjobs[0]->state == $state->name) ? "selected":"" }}>{{ $state->name }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
 
              <!-- Address -->
                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-10">
                    <input type="text" id="my-address" name="address" class="form-control" value="{{ isset($postjobs[0]->address  ) ? $postjobs[0]->address   : '' }}" placeholder="Address" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <input type="hidden" id="city" name="city" class="form-control" placeholder="City" value="Ahmedabad">
                  </div>
                  <div class="col-sm-4">
                    <input type="hidden" id="state" name="state" class="form-control" placeholder="State" value="Gujarat">
                  </div>
                  <div class="col-sm-4">
                    <input type="hidden" id="country" name="country" class="form-control" placeholder="Country" value="India">
                  </div>
                </div> -->
                
                               
<!--                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner Image</label>
                  <div class="col-sm-10">
                    <input type="file" name="postjob_banner" value="" >                    
                  </div>                  
                </div> -->

                <!-- Banner hearding -->
                @if($postjobs[0]->postjob_banner != '')
<!--                 <div class="col-sm-offset-2 col-sm-10" style="padding: 2% 0 2% 0;"><b>Current Job Banner</b></div> -->
                @endif

                <!-- Banner image  -->
              <!--
                <div class="form-group">                  
                  <div class="col-sm-offset-2 col-sm-10">
                    <?php
                      
                      //$banner_image = $postjobs[0]->postjob_banner;                                 
                      // if(isset($banner_image) && ($banner_image != '')){
                      //     $banner_path = url('public/postjobBanner/'.$banner_image);
                    ?>
                      <img id="banner_path" src="{{-- $banner_path --}}" alt="banner_img" height="250" width="400" />
                    <?php  //} ?>                    
                  </div>                  
                </div> -->
                <!-- city
                state
                country -->                
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="col-sm-offset-2 btn btn-default">Update</button>
                <a href="{{ route('postjobs.lists') }}" class="btn btn-info">Cancel</a>
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
  var date = new Date();
  date.setDate(date.getDate());
   $('#app_deadline').datepicker({
      format: "mm/dd/yyyy",     
      startDate: date,
      autoclose: true
    });

 $('#editPostTable').DataTable();

  $(document).ready(function(){
   var ranks = [<?php echo '"'.implode('","',  $rank_position ).'"' ?>];
    ranks = ranks.toString();
    // console.log(typeof(values) +' ' +typeof(ranks));   
    $.each(ranks.split(","), function(i,e){
      // console.log('val of e:'+e.toString());
        $(".rank option[value='" + e.toString() + "']").prop("selected", true);
    });
      
    //var multipleValues = $(".rank").val() || "";
    var result = "";
    var wage = [<?php echo '"'.implode('","',  $wage_list ).'"' ?>].toString();
    var c_duration = [<?php echo '"'.implode('","',  $contract_duration ).'"' ?>].toString();
    var exp_years = [<?php echo '"'.implode('","',  $experience_years ).'"' ?>].toString();
    var exp_months = [<?php echo '"'.implode('","',  $experience_months ).'"' ?>].toString();
    // wage = wage.toString();
    var final  = [ wage, c_duration, exp_years, exp_months];
    for (var i = 0, l1 = final.length; i < l1; i++) { 
    for (var j = 0, l2 = final[i].length; j < l2; j++) {
        // console.log(final[i][j]); 
      }
    }
//     // return false;
    var data  = final;//$.parseJSON()
    var data = <?php echo json_encode($final) ?>;
    var obj = data;

//         // [{"id":"2","client_id":"2","first_name":"test1","last_name":"test2"},
//         // {"id":"3","client_id":"2","first_name":"test3","last_name":"test4"}];
//         // document.getElementById("whereToPrint").innerHTML = JSON.stringify(obj);
        $.each(obj,function(i,o){
            console.log(o.rank_position +' '+ o.contract_duration);
        }); 
        var year = '';
        if (wage != "") 
        {
            // var aVal = final.toString().split(",");
            // $.each(aVal, function(i, value) {   

              result +=""; 
              result += "<div class='row'>";
              result += "<div class='col-sm-12'><table id='editPostTable' >";
              result +="<thead><tr><th>Rank</th><th>Contract Duration(In Months)</th><th>Experience(In Years)</th><th>Wage(In Dollar)</th></tr></thead>";
          $.each(obj,function(i,ob){
              //console.log('Inner rank postion : '+ ob.experience_years);

              if(ob.rank_position == 'Captain / Master'){
                  var rank1 = 'selected';
              }
              if(ob.rank_position == 'Chief Engineer'){
                  var  rank2 = 'selected';
              }
              if(ob.rank_position == 'Chief Officer'){
                  var rank3 = 'selected';
              }
              if(ob.rank_position == '2nd Engineer'){
                  var  rank4 = 'selected';
              } 
              if(ob.rank_position == '2nd Officer'){
                  var rank5 = 'selected';
              }
              if(ob.rank_position == '3rd Engineer'){
                  var rank6 = 'selected';
              }
              if(ob.rank_position == '3rd Officer'){
                  var rank7 = 'selected';
              }
              if(ob.rank_position == '4th Engineer'){
                  var rank8 = 'selected';
              }
              if(ob.rank_position == 'Electrical Officer'){
                  var rank9 = 'selected';
              }
              if(ob.rank_position == 'Electrical Technical Officer'){
                  var rank10 = 'selected';
              }
              if(ob.rank_position == 'Trainee Electrical Officer'){
                  var rank11 = 'selected';
              } 
              if(ob.rank_position == 'AB'){
                  var rank12 = 'selected';
              }if(ob.rank_position == 'Oiler'){
                  var rank13 = 'selected';
              }
              if(ob.rank_position == 'Deck Cadet'){
                  var rank14 = 'selected';
              }if(ob.rank_position == 'Engine Cadet'){
                  var rank15 = 'selected';
              }
              if(ob.rank_position == 'OS'){
                  var rank16 = 'selected';
              }
              if(ob.rank_position == 'Wiper'){
                  var rank17 = 'selected';
              }
              if(ob.rank_position == 'Trainee OS'){
                  var rank18 = 'selected';
              }
              if(ob.rank_position == 'Trainee Wiper'){
                  var rank19 = 'selected';
              }
              if(ob.rank_position == 'Deck Fitter'){
                  var rank20 = 'selected';
              }if(ob.rank_position == 'Engine Fitter'){
                  var rank21 = 'selected';
              }if(ob.rank_position == 'Bosun'){
                  var rank22 = 'selected';
              }if(ob.rank_position == 'Pumpman'){
                  var rank23 = 'selected';
              }if(ob.rank_position == 'Motorman'){
                  var rank24 = 'selected';
              }if(ob.rank_position == 'Crane Operator'){
                  var rank25 = 'selected';
              }
              if(ob.rank_position == 'Chief Cook'){
                  var rank26 = 'selected';
              }
              if(ob.rank_position == 'Cook'){
                  var rank27 = 'selected';
              }
              if(ob.rank_position == '2nd Cook'){
                  var rank28 = 'selected';
              }
              if(ob.rank_position == 'Assistant Cook'){
                  var rank29 = 'selected';
              }if(ob.rank_position == 'General Steward'){
                  var rank30 = 'selected';
              }
              if(ob.rank_position == 'Trainee General Steward'){
                  var rank31 = 'selected';
              }
            result +="<tr id='TemplateRow_"+i+"' class='MyClass'><td><select onchange='getval(this);' class='form-control mainrank rank col-sm-3' id='rank["+ i +"]' name='rank["+ i +"]' required=''><option value='Captain / Master' "+ rank1 +">Captain / Master</option><option value='Chief Engineer' "+ rank2 +">Chief Engineer</option><option value='Chief Officer' "+ rank3 +">Chief Officer</option><option value='2nd Engineer' "+ rank4 +">2nd Engineer</option><option value='2nd Officer' "+ rank5 +">2nd Officer</option><option value='3rd Engineer' "+ rank6 +">3rd Engineer</option><option value='3rd Officer' "+ rank7 +">3rd Officer</option><option value='4th Engineer' "+ rank8 +">4th Engineer</option><option value='Electrical Officer' "+ rank9 +">Electrical Officer</option><option value='Electrical Technical Officer' "+ rank10 +">Electrical Technical Officer</option><option value='Trainee Electrical Officer' "+ rank11 +">Trainee Electrical Officer</option><option value='AB' "+ rank12 +">AB</option><option value='Oiler' "+ rank13 +">Oiler</option><option value='Deck Cadet' "+ rank14 +">Deck Cadet</option><option value='Engine Cadet' "+ rank15 +">Engine Cadet</option><option value='OS' "+ rank16 +">OS</option><option value='Wiper' "+ rank17 +">Wiper</option><option value='Trainee OS' "+ rank18 +">Trainee OS</option><option value='Trainee Wiper' "+ rank19 +">Trainee Wiper</option><option value='Deck Fitter' "+ rank20 +">Deck Fitter</option><option value='Engine Fitter' "+ rank21 +">Engine Fitter</option><option value='Bosun' "+ rank22 +">Bosun</option><option value='Pumpman' "+ rank23 +"> Pumpman</option><option value='Motorman' "+ rank24 +">Motorman</option><option value='Crane Operator' "+ rank25 +">Crane Operator</option><option value='Chief Cook' "+ rank26 +">Chief Cook</option><option value='Cook' "+ rank27 +">Cook</option><option value='2nd Cook' "+ rank28 +">2nd Cook</option><option value='Assistant Cook' "+ rank29 +">Assistant Cook</option><option value='General Steward' "+ rank30 +">General Steward</option><option value='Trainee General Steward' "+ rank31 +">Trainee General Steward</option></select></td>";

            result +="<td><input type='number' step='0.01' name='contract_duration[]' 0.5='' class='form-control col-sm-3' placeholder='Contract Duration' value='"+ ob.contract_duration +"' required></td>";

            result +="<td><input type='number' step='0.01' name='experience_years[]' 0.5='' class='form-control col-sm-3' placeholder='Experience Years'value='"+ob.experience_years+"' required></td>";

            result +="<td><input type='number' class='BoxValClass form-control col-sm-3' name='wage[]' id='BoxVal' placeholder='Enter wage' value='"+ob.wages+"'' required></td></tr>";

            
                // result += "<div>";
                // result += "<div style='display:block'>";
                // result += "<label>Fill Details for Rank Position <strong>"+ ob.rank_position +"</strong> *: </label></div>";                              
                // result += "<div class='row'>";
                // result += "<label class='col-sm-3'>Contract Duration(in months)*:</label>";
                // result += "<label class='col-sm-3'>Experience Years(in years)*:</label>";
                // result += "<label class='col-sm-3'>Experience Years(in months)*:</label>";
                // result += "<label class='col-sm-3'>Wage for Rank '"+ ob.rank_position +"'*:</label></div>";
                // result += "<input type='number' style='width:25%;display:inline-block!important; margin-right:2px;' class='form-control col-sm-3' placeholder='"+ 'Contract Duration(in months) for '+ob.contract_duration + "' name='"+'contract_duration[]' + "' value='"+ob.contract_duration+"' Required>";
               

                // console.log('year is: '+ob.experience_years+''+ob.experience_months);
              
                // if(ob.experience_years == '1'){
                //   var year1 = 'selected';
                // }
                // if(ob.experience_years == '2'){
                //   var  year2 = 'selected';
                // }
                // if(ob.experience_years == '3'){
                //   var year3 = 'selected';
                // }
                // if(ob.experience_years == '4'){
                //   var  year4 = 'selected';
                // } 
                // if(ob.experience_years == '5'){
                //   var year5 = 'selected';
                // }
                // if(ob.experience_years == '6'){
                //   var year6 = 'selected';
                // }
                // if(ob.experience_years == '7'){
                //   var year7 = 'selected';
                // }
                // if(ob.experience_years == '8'){
                //   var year8 = 'selected';
                // }
                // if(ob.experience_years == '9'){
                //   var year9 = 'selected';
                // }
                // if(ob.experience_years == '10'){
                //   var year10 = 'selected';
                // }
                // if(ob.experience_years == '11'){
                //   var year11 = 'selected';
                // } 
                // if(ob.experience_years == '12'){
                //   var year12 = 'selected';
                // }if(ob.experience_years == '13'){
                //   var year13 = 'selected';
                // }
                // if(ob.experience_years == '14'){
                //   var year14 = 'selected';
                // }if(ob.experience_years == '15'){
                //   var year15 = 'selected';
                // }
                // if(ob.experience_years == '16'){
                //   var year16 = 'selected';
                // }
                // if(ob.experience_years == '17'){
                //   var year17 = 'selected';
                // }
                // if(ob.experience_years == '18'){
                //   var year18 = 'selected';
                // }
                // if(ob.experience_years == '19'){
                //   var year19 = 'selected';
                // }
                // if(ob.experience_years == '20'){
                //   var year20 = 'selected';
                // }if(ob.experience_years == '21'){
                //   var year21 = 'selected';
                // }if(ob.experience_years == '22'){
                //   var year22 = 'selected';
                // }if(ob.experience_years == '23'){
                //   var year23 = 'selected';
                // }if(ob.experience_years == '24'){
                //   var year24 = 'selected';
                // }if(ob.experience_years == '25'){
                //   var year25 = 'selected';
                // }
                // if(ob.experience_years == '26'){
                //   var year26 = 'selected';
                // }
                // if(ob.experience_years == '27'){
                //   var year27 = 'selected';
                // }
                // if(ob.experience_years == '28'){
                //   var year28 = 'selected';
                // }
                // if(ob.experience_years == '29'){
                //   var year29 = 'selected';
                // }if(ob.experience_years == '30'){
                //   var year30 = 'selected';
                // }
                // if(ob.experience_years == '31'){
                //   var year31 = 'selected';
                // }
                // if(ob.experience_years == '32'){
                //   var year32 = 'selected';
                // }
                // if(ob.experience_years == '33'){
                //   var year33 = 'selected';
                // }
                // if(ob.experience_years == '34'){
                //   var year34 = 'selected';
                // }
                // if(ob.experience_years == '35'){
                //   var year35 = 'selected';
                // }
                // if(ob.experience_years == '36'){
                //   var year36 = 'selected';
                // }
                // if(ob.experience_years == '37'){
                //   var year37 = 'selected';
                // }
                // if(ob.experience_years == '38'){
                //   var year38 = 'selected';
                // }
                // if(ob.experience_years == '39'){
                //   var year39 = 'selected';
                // }
                // if(ob.experience_years == '40'){
                //   var year40 = 'selected';
                // }
                // if(ob.experience_years == '41'){
                //   var year41 = 'selected';
                // }
                // if(ob.experience_years == '42'){
                //   var year42 = 'selected';
                // }
                // if(ob.experience_years == '43'){
                //   var year43 = 'selected';
                // }
                // if(ob.experience_years == '44'){
                //   var year44 = 'selected';
                // }if(ob.experience_years == '45'){
                //   var year45 = 'selected';
                // }if(ob.experience_years == '46'){
                //   var year46 = 'selected';
                // }if(ob.experience_years == '47'){
                //   var year47 = 'selected';
                // }if(ob.experience_years == '48'){
                //   var year48 = 'selected';
                // }if(ob.experience_years == '49'){
                //   var year49 = 'selected';
                // }if(ob.experience_years == '50'){
                //   var year50 = 'selected';
                // }
                // //month
                // if(ob.experience_months == '1'){
                //   var month1 = 'selected';
                // }
                // if(ob.experience_months == '2'){
                //   var month2 = 'selected';
                // }
                // if(ob.experience_months == '3'){
                //   var month3 = 'selected';
                // }
                // if(ob.experience_months == '4'){
                //   var month4 = 'selected';
                // } 
                // if(ob.experience_months == '5'){
                //   var month5 = 'selected';
                // }
                // if(ob.experience_months == '6'){
                //   var month6 = 'selected';
                // }
                // if(ob.experience_months == '7'){
                //   var month7 = 'selected';
                // }
                // if(ob.experience_months == '8'){
                //   var month8 = 'selected';
                // }
                // if(ob.experience_months == '9'){
                //   var month9 = 'selected';
                // }
                // if(ob.experience_months == '10'){
                //   var month10 = 'selected';
                // }
                // if(ob.experience_months == '11'){
                //   var month11 = 'selected';
                // } 
                // if(ob.experience_months == '12'){
                //   var month12 = 'selected';
                // }

                // $year = 
                
                // result += "<div class='col-sm-3'><select id='jb-leve' name='experience_years[]' class='form-control' Required><option value=''>Experience in Year</option><option value='1' "+ year1 +">1</option><option value='2' "+ year2 +">2</option><option value='3' "+ year3 +">3</option><option value='4' "+ year4 +">4</option><option value='5' "+ year5 +">5</option><option value='6 "+ year6 +"6</option><option value='7' "+ year7 +">7</option><option value='8' "+ year8 +">8</option><option value='9' "+ year9 +">9</option><option value='10' "+ year10 +">10</option><option value='11' "+ year11 +">11</option><option value='12' "+ year12 +">12</option><option value='13' "+ year13 +">13</option><option value='14' "+ year14 +">14</option><option value='15' "+ year15 +">15</option><option value='16' "+ year16 +">16</option><option value='17' "+ year17 +">17</option><option value='18' "+ year18 +">18</option><option value='19' "+ year19 +">19</option><option value='20' "+ year20 +">20</option><option value='21' "+ year21 +">21</option><option value='22' "+ year22 +">22</option><option value='23' "+ year23 +">23</option><option value='24' "+ year24 +">24</option><option value='25' "+ year25 +">25</option><option value='25' "+ year25 +">25</option><option value='26' "+ year26 +">26</option><option value='27' "+ year27 +">27</option><option value='28' "+ year28 +">28</option><option value='29' "+ year29 +">29</option><option value='30' "+ year30 +">30</option><option value='31' "+ year31 +">31</option><option value='32' "+ year32 +">32</option><option value='33' "+ year33 +">33</option><option value='34' "+ year34 +">34</option><option value='35' "+ year35 +">35</option><option value='36' "+ year36 +">36</option><option value='37' "+ year37 +">37</option><option value='38' "+ year38 +">38</option><option value='39' "+ year39 +">39</option><option value='40' "+ year40 +">40</option><option value='41' "+ year41 +">41</option><option value='42' "+ year42 +">42</option><option value='43' "+ year43 +">43</option><option value='44' "+ year44 +">44</option><option value='45' "+ year45 +">45</option><option value='46' "+ year46 +">46</option><option value='47' "+ year47 +">47</option><option value='48' "+ year48 +">48</option><option value='49' "+ year49 +">49</option><option value='50' "+ year50 +">50</option></select></div>";
                
                // result += "<div class='col-sm-3'><select id='jb-leve' name='experience_months[]' class='form-control' Required><option value=''>Experience in Months</option><option value='1' "+ month1 +">1</option><option value='2' "+ month2 +">2</option><option value='3' "+ month3 +">3</option><option value='4' "+ month4 +">4</option><option value='5' "+ month5 +">5</option><option value='6 "+ month6 +"6</option><option value='7' "+ month7 +">7</option><option value='8' "+ month8 +">8</option><option value='9' "+ month9 +">9</option><option value='10' "+ month10 +">10</option><option value='11' "+ month11 +">11</option><option value='12' "+ month12 +">12</option></select></div>";
                // result += "<input type='number' style='width:24%;display:inline-block !important;margin-right:2px;' class='form-control col-sm-3' name='"+'wage[]' + "' placeholder='"+ 'Wages for '+ob.wages + "'value='"+ob.wages+"' Required>";
                // result += "</div>";
            });

        }
        result +="</table></div></div>";
        // result +="</div>";
        //Set Result
        $("#wages").html(result);
  });
    
  //new rank and wage add 
  $(".rank").change(function() {
    var multipleValues = $(".rank").val() || "";
    var result = $("#wages").html(result);
    if (multipleValues != "") {
        var aVal = multipleValues.toString().split(",");
        $.each(aVal, function(i, value) {
            

            // result += "<div class='row'>";
            // result += "<label class='col-sm-3'>Contract Duration(in months)*:</label>";
            // result += "<label class='col-sm-3'>Experience Years(in years)*:</label>";
            // result += "<label class='col-sm-3'>Experience Years(in months)*:</label>";
            // result += "<label class='col-sm-3'>Wage for Rank '"+ value +"'*:</label></div>";
            // result += "<input class='col-sm-3 form-control' type='number' style='width:25%;display:inline-block!important; margin-right:2px;' class='form-control' placeholder='"+ 'Contract Duration(in months) for '+value + "' name='"+'contract_duration[]' + "' value='' Required>";

            // result += "<div class='col-sm-3'><select id='jb-leve' name='experience_years[]' class='form-control' Required><option value=''>Experience in Year</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option></select></div>";
            
            // result += "<div class='col-sm-3'><select id='jb-leve' name='experience_months[]' class='form-control' Required><option value=''>Experience in Months</option><option value='3'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option></select></div>";

            // result += "<input class='col-sm-3 form-control' type='number' style='width:24%;display:inline-block !important;margin-right:2px;' name='"+'wage[]' + "' placeholder='"+ 'Wages for '+value + "'value='' Required>";
        });
    }
    //Set Result
    $("#wages").html(result);
  });
    
  </script>
<!-- script to add dynamic ranks -->
<script type="text/javascript">
  //counter
  ccounter = 1; 
  function getval(sel)
  {
    
    $($(sel).closest(".afterthis") ).siblings().remove();
    $(html).insertAfter( $(sel).closest(".afterthis") );          
    ccounter++;
  }





  $(document).ready(function(){
    //Add button
      // var counter = 2;
       var rowCount = document.getElementById('editPostTable').rows.length - 1;
       //alert('rowCount '+rowCount);
      //return false;
      var counter = rowCount;
      $("#addButton").click(function () {

        if(counter>31){
          alert("Only 31 textboxes allow");
          return false;
        }

        if($('.mainrank').val() == '')
        {
            alert("Please select value");
            return false;
        }

      
        // var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter);
        var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'TextBoxDiv' + counter);
        var selectedoptions = [];

        $( "select.rank" ).each(function( index ) {
          selectedoptions.push($(this).val());
        });

       //var options = ['animation','website','mobileapplication','logo','digitalmarketing','other'];
       var options = ['Captain / Master','Chief Engineer','Chief Officer','2nd Engineer','2nd Officer','3rd Engineer','3rd Officer','4th Engineer','Electrical Officer','Electrical Technical Officer','Trainee Electrical Officer','AB','Oiler','Deck Cadet','Engine Cadet','OS','Wiper','Trainee OS','Trainee Wiper','Deck Fitter','Engine Fitter','Bosun','Pumpman',' Motorman','Crane Operator', 'Chief Cook','Cook','2nd Cook','Assistant Cook','General Steward','Trainee General Steward'];


       // console.log(selectedoptions);

       var htmloptions = '';

       jQuery.each(options, function(index, item) {            
            if(jQuery.inArray(item, selectedoptions) == -1)
            {
                htmloptions += '<option value="'+item+'">'+item+'</option>';
            }
       });
                  
        
       //alert('Count is :'+count)
        //newTextBoxDiv.after().html('<td><select onchange="getval(this);" class="form-control rank" id="rank[' + counter + ']" name="rank[' + counter + ']">'+htmloptions+'</select></td><td><input type="number" step=0.01 name="contract_duration[]"  Step 0.5 class="form-control" placeholder="Contract Duration" required /></td><td><input type="number" step="0.01" name="experience_years[]" placeholder="Contract Duration" 0.5="" class="form-control"></td><td><input type="number" class="BoxValClass form-control" name="wage[]" placeholder="Enter wage"></td>');
        // newTextBoxDiv.after().html('<td><select onchange="getval(this);" class="form-control rank" id="rank[' + counter + ']" name="rank[' + counter + ']">'+htmloptions+'</select></td><td><input type="number" step=0.01 name="contract_duration[]"  Step 0.5 class="form-control" placeholder="Contract Duration" required /></td><td><input type="number" step="0.01" name="experience_years[]" placeholder="Enter Experience Years" 0.5="" class="form-control"></td><td><input type="number" class="BoxValClass form-control" name="wage[]" placeholder="Enter wage"></td>');
        
         newTextBoxDiv.after().html('<td><select onchange="getval(this);" class="form-control rank" id="rank[' + counter + ']" name="rank[' + counter + ']">'+htmloptions+'</select></td><td><input type="number" step=0.01 name="contract_duration[]"  Step 0.5 class="form-control" placeholder="Contract Duration" required /></td><td><input type="number" class="BoxValClass form-control" name="wage[]" placeholder="Enter wage"></td>');

        newTextBoxDiv.appendTo("#appendhere");

       counter++;

      });


      //REMOVE ROW  
       $("#removeButton").click(function () {
                 
          // if(counter==1){
          //   alert("No more textbox to remove");
          //   return false;
          // }               
          // }  
          var rowCount = document.getElementById('editPostTable').rows.length - 1;
          // alert(rowCount);
          if(rowCount > 0){
            counter--;          
            $("#TextBoxDiv" + counter).remove();
          }
          if(rowCount > 1){
            rowCount--;
            $("#TemplateRow_" + rowCount).remove();  
          }
          if(rowCount==1){
            alert("Atleast one rank require");
            return false;
          }
       });
      
      $("#getButtonValue").click(function () {
    
        var msg = '';
        for(i=1; i<counter; i++){
            msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
        }
              alert(msg);
      });
    });
</script>
@endsection