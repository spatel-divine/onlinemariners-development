@extends('layouts.app_adminafterlogin')
@section('content')
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

    /* drop down compnay name css*/
    .input-group{ width: 60%; }
    .combobox-container .input-group{
      display: flex !important;
    }
</style>
<link rel="stylesheet" href="https://rawgit.com/danielfarrell/bootstrap-combobox/master/css/bootstrap-combobox.css">
<script src="https://rawgit.com/danielfarrell/bootstrap-combobox/master/js/bootstrap-combobox.js"></script>
<div class="content-wrapper">
  <?php
  use Illuminate\Support\Facades\Input;
    // echo '123<pre>';
    // // print_r($employerList);
    // print_r($documentList);
    // exit;
  ?>
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      Add Postjob
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Add Postjob</li>
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
              <h3 class="box-title">Add Postjob Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal add-employee-form" method="POST" action="{{ route('insertNewPostJob') }}" enctype="multipart/form-data" >
              @csrf
              
              <input type="hidden" name="id" value="">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Company Name</label>
                  <div class="col-sm-10">
                    <select name="employer_id" id="jb-nationality" class="form-control combobox" required>
                      <option value=''>Select Company Name</option>
                      @foreach ($employerList as $emp)                      
                          <option value="{{ $emp->id  }}" style="text-transform: capitalize;">{{ $emp->company_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>                
                

                <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Job Title</label>
                  <div class="col-sm-10">
                    <input type="text" name="job_title" class="form-control" value="" placeholder="Job Title" required>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Job Description</label>
                  <div class="col-sm-10">
                    <!-- <input type="email" name="email" class="form-control"  value="" placeholder="Job Description" required> -->
                    <textarea id="job_description" class="form-control" name="job_description" rows="5" cols="106" placeholder="Job Description"></textarea>
                  </div>
                </div>
                <!-- Document Name -->
                <!-- <option>Adhar Card</option>
                <option>Pan Card</option>
                <option>Driving Licence</option>
                <option>Voter Card</option>
                <option>Bank PassBook</option>
                <option>Degree Certificate</option> -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Document Name</label>
                  <div class="col-sm-10">
                    <select class="form-control select2"name="document_name[]" multiple="multiple" data-placeholder="Select a Document" style="width: 100%;" required>                      
                      @foreach($documentList as $k=>$v)
                        <option value="{{ $documentList[$k] }}">{{ $documentList[$k] }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <!-- Application Deadline -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Application Deadline</label>
                  <div class="col-sm-10">
                    <input type="text" name="app_deadline" class="form-control" value="" placeholder="Select Application Deadline" id="app_deadline" autocomplete="off" required>
                  </div>
                </div>
                <!-- label Ctrl + Mouse right click to add other ranks from options-->
                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                    <b style="color: green;">Press Ctrl + Mouse right click to add other ranks from options</b>
                  </div>
                </div> -->

                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Rank Postion*:</label>
                  <div class="col-sm-10">
                              <select id="rank" name="rank[]" class="form-control custom-select rank" multiple required>                               
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

              <!-- wage--> 
              <!-- <div class="col-sm-offset-2 col-sm-10" style="margin-left: 15.7%;">                    
                <div id="wages" class="">
                </div>                    
              </div>

              <div class="form-group">
                <div class="row"></div>
              </div> -->
              <!-- end wage-->
              <!-- Insert &  Delete button for ranks -->              
              <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                  <input class="col-sm-2 btn btn-info" type='button' value='+ Add' id='addButton'>
                  <input class="col-sm-2 btn btn-warning" type='button' value='- Remove' id='removeButton' style="margin-left:10px;">  
                </div>
              </div>
              <!-- Dynamic rank -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Rank *:</label>
                  <div class="col-sm-10">
                    <div class="card-box">
                  <div id='TextBoxesGroup'>
                      <div id="TextBoxDiv0">
                        <div class="row">                
                            <div class="afterthis col-md-12 col-lg-12 col-sm-12">
                            <table id="BoxTable">
                                <thead>
                                  <tr>
                                      <th>Rank</th>
                                      <th>Contract Duration(In Months)</th>
                                      <!-- <th>Experience(In Years)</th> -->
                                      <th>Wages( In Dollar)</th>
                                  </tr>
                                </thead>
                                <tbody id="appendhere">
                                  <tr id="TemplateRow" class="MyClass">
                                    <td>
                                      <select onchange="getval(this);" class="form-control mainrank rank" id="rank[0]" name="rank[0]"  required="">                        
                                        <option value='Captain / Master' >Captain / Master</option>
                                        <option value='Chief Engineer'  >Chief Engineer</option>
                                        <option value='Chief Officer'  >Chief Officer</option>
                                        <option value='2nd Engineer'  >2nd Engineer</option>
                                        <option value='2nd Officer'  >2nd Officer</option>
                                        <option value='3rd Engineer'>3rd Engineer</option>
                                        <option value='3rd Officer' >3rd Officer</option>
                                        <option value='4th Engineer'>4th Engineer</option>
                                        <option value='Electrical Officer'>Electrical Officer</option>
                                        <option value='Electrical Technical Officer'>Electrical Technical Officer</option>
                                        <option value='Trainee Electrical Officer'>Trainee Electrical Officer</option>
                                        <option value='AB'>AB</option>
                                        <option value='Oiler'>Oiler</option>
                                        <option value='Deck Cadet'>Deck Cadet</option>
                                        <option value='Engine Cadet'>Engine Cadet</option>
                                        <option value='OS'>OS</option><option value='Wiper'>Wiper</option><option value='Trainee OS'>Trainee OS</option><option value='Trainee Wiper'>Trainee Wiper</option><option value='Deck Fitter'>Deck Fitter</option><option value='Engine Fitter'>Engine Fitter</option><option value='Bosun'>Bosun</option><option value='Pumpman'> Pumpman</option><option value='Motorman'>Motorman</option><option value='Crane Operator'>Crane Operator</option><option value='Chief Cook'>Chief Cook</option><option value='Cook'>Cook</option><option value='2nd Cook'>2nd Cook</option><option value='Assistant Cook'>Assistant Cook</option><option value='General Steward'>General Steward</option><option value='Trainee General Steward'>Trainee General Steward</option>
                                      </select>
                                    </td>
                                    <td>
                                        <input type="number" step=0.01 name="contract_duration[]"  Step 0.5 class="form-control" placeholder="Contract Duration" required />
                                    </td>
                                    <!-- <td>
                                        <input type="number" step=0.01 name="experience_years[]"  Step 0.5 class="form-control" placeholder="Experience Years" required />
                                    </td> -->
                                    <td>
                                        <input type="number" class ="BoxValClass form-control" name="wage[]"  id="BoxVal"  placeholder="Enter wages" />
                                    </td>                      
                                  </tr>
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
                <label class="col-sm-2 control-label">Vessel Type*</label>
                <div class="col-sm-10">
                  <select name="vassel_type" class="form-control custom-select" required><!-- multiple-->
                    <option value="" >Vessel Type</option>
                    <option value="Tanker Ship" {{ old('vassel_type')=='Tanker Ship' ? 'selected' : ''  }}>Tanker Ship</option>
                    <option value="Container Ship"{{ old('vassel_type')=='Container Ship' ? 'selected' : ''  }}>Container Ship</option>
                    <option value="General Cargo Ship"{{ old('vassel_type')=='General Cargo Ship' ? 'selected' : ''  }}>General Cargo Ship</option>
                    <option value="Bulk Carrier" {{ old('vassel_type')=='Bulk Carrier' ? 'selected' : ''  }}>Bulk Carrier</option>
                    <option value="Car Carrier / Ro-Ro Ship" {{ old('vassel_type')=='Car Carrier / Ro-Ro Ship' ? 'selected' : ''  }}>Car Carrier / Ro-Ro Ship</option>
                    <option value="Live-Stock Carrier" {{ old('vassel_type')=='Live-Stock Carrier' ? 'selected' : ''  }}>Live-Stock Carrier</option>
                    <option value="Passenger Ship" {{ old('vassel_type')=='Passenger Ship' ? 'selected' : ''  }}>Passenger Ship</option>
                    <option value="Offshore Ship" {{ old('vassel_type')=='Offshore Ship' ? 'selected' : ''  }}>Offshore Ship</option>
                    <option value="Special Purpose Ship" {{ old('vassel_type')=='Special Purpose Ship' ? 'selected' : ''  }}>Special Purpose Ship</option>
                    <option value="Other Ship"{{ old('vassel_type')=='Other Ship' ? 'selected' : ''  }}>Other Ship </option>
                  </select>
                </div>
              </div>  
                <!-- Joining port -->
               <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Enter port of joining*:</label>
                <div class="col-sm-10">
                  <input type="text" name="joining_port" class="form-control" placeholder="Enter your joining" value="{{ old('joining_port') }}" required>
                </div>
              </div>

              
                <!-- Country -->
                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                     <select name='country' class="form-control" id="country" required>
                        <option value=""> Select Country</option> -->
                        {{-- @foreach($countries as $country) --}}
                        <!-- <option value="{{-- $country->name --}}" {{-- ($postjobs[0]->country == $country->name) ? "selected":"" --}} > {{-- $country->name --}}</option> -->
                        {{-- @endforeach --}}
                      <!-- </select>
                  </div>
                </div>   -->
                <!-- State -->
                 <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">State*</label>
                  <div class="col-sm-10">
                     <select name='state' class="form-control" id="State" required>
                        <option value=""> Select State</option> -->
                        {{-- @foreach($states as $state) --}}
                        <!-- <option value="{{-- $state->name --}}" {{-- ($postjobs[0]->state == $state->name) ? "selected":"" --}} > {{-- $state->name --}}</option> -->
                        {{-- @endforeach --}}
                      <!-- </select>
                  </div>
                </div> -->

               
                <!-- Addres -->      
               <!--  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-10">
                    <input type="text" id="my-address" name="address" class="form-control" value="" placeholder="Address" required>
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
                    <input type="file" name="postjob_banner">                    
                  </div>                  
                </div> -->
              <!--
                <div class="form-group">                  
                  <div class="col-sm-offset-2 col-sm-10">
                    <?php
                      // $profileimg = $employer[0]->pic_path;
                      // if(isset($profileimg) && ($profileimg != 'emp-default.png')){
                      //     $path = url('public/empProfile/'.$profileimg);
                    ?>
                      <img id="profileimg" src="{{-- $path --}}" alt="profileimg" height="80" width="80" />
                    <?php  //} ?>                    
                  </div>                  
                </div> -->
                <!-- city
                state
                country -->                
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="col-sm-offset-2 btn btn-default">Add</button>
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
  $('.select2').select2();
  var date = new Date();
  date.setDate(date.getDate());
   $('#app_deadline').datepicker({
      format: "mm/dd/yyyy",     
      startDate: date,
      autoclose: true
    });

   $(".rank").change(function() {
        var multipleValues = $(".rank").val() || "";
        var result = "";
        if (multipleValues != "") {
            var aVal = multipleValues.toString().split(",");
            $.each(aVal, function(i, value) {
              result += "<div>";
                result += "<div style='display:block; padding-top:1%;'>";
                result += "<label>Fill Details for Rank Position <strong>"+ value +"</strong> *: </label></div>";

                // result += "<input type='text' name='opval" + (parseInt(i) + 1) + "' value='" + "'"+value.trim()+"'" + "'>";
                // value = value.replace(' ','-');
                // value = value.replace('/','-');
                // result += "<input type='text' name='optext" + (parseInt(i) + 1) + "' value='" + $("#rank").find("option[value=" + value + "]").text().trim() + "'>";
                // result +="<div class='col-lg-6 col-md-6 col-sm-12'>" //(parseInt(i) + 1)
                // result += "<input type='number' style='width:25%;display:inline-block!important; margin-right:2px;' class='form-control' placeholder='"+ 'Contract Duration(in months) for '+value + "' name='"+'contract_duration[]' + "' value='' Required>";
                result += "<div class='row'>";
                result += "<label class='col-sm-3'>Contract Duration(in months)*:</label>";
                result += "<label class='col-sm-3'>Experience Years(in years)*:</label>";
                result += "<label class='col-sm-3'>Experience Years(in months)*:</label>";
                result += "<label class='col-sm-3'>Wage for Rank '"+ value +"'*:</label></div>";
                result += "<input class='col-sm-3 form-control' type='number' style='width:25%;display:inline-block!important; margin-right:2px;' class='form-control' placeholder='"+ 'Contract Duration(in months) for '+value + "' name='"+'contract_duration[]' + "' value='' Required>";
                
                // result += "<input type='number' style='width:25%;display:inline-block !important;margin-right:2px;' class='form-control' name='"+'experience_years[]' + "' placeholder='"+ 'Experience Years(in years) for'+value + "'value='' min='0' max='12' Required>";
         result += "<div class='col-sm-3'><select id='jb-leve' name='experience_years[]' class='form-control' Required><option value=''>Experience in Year</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option><option value='16'>16</option><option value='17'>17</option><option value='18'>18</option><option value='19'>19</option><option value='20'>20</option><option value='21'>21</option><option value='22'>22</option><option value='23'>23</option><option value='24'>24</option><option value='25'>25</option><option value='26'>26</option><option value='27'>27</option><option value='28'>28</option><option value='29'>29</option><option value='30'>30</option><option value='31'>31</option><option value='32'>32</option><option value='33'>33</option><option value='34'>34</option><option value='35'>35</option><option value='36'>36</option><option value='37'>37</option><option value='38'>38</option><option value='39'>39</option><option value='40'>40</option><option value='41'>41</option><option value='42'>42</option><option value='43'>43</option><option value='44'>44</option><option value='45'>45</option><option value='46'>46</option><option value='47'>47</option><option value='48'>48</option><option value='49'>49</option><option value='50'>50</option></select></div>";
                //result += "<input class='col-sm-3 form-control' type='number' style='width:24%;display:inline-block !important;margin-right:2px;'  name='"+'experience_months[]' + "' placeholder='"+ 'Experience Months(in months) for '+value + "'value='' min='0' max='12' Required>";
                 result += "<div class='col-sm-3'><select id='jb-leve' name='experience_months[]' class='form-control' Required><option value=''>Experience in Months</option><option value='3'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option></select></div>";

                result += "<input class='col-sm-3 form-control' type='number' style='width:24%;display:inline-block !important;margin-right:2px;' name='"+'wage[]' + "' placeholder='"+ 'Wages for '+value + "'value='' Required>";
                result += "</div>";
            });


        }
        //Set Result
        $("#wages").html(result);

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

    //company logo
    
    function readURLClogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#companylogoimg').attr('src', e.target.result);                
            }            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#company_logo").change(function(){
        readURLClogo(this);
    });
    
    /* Auto complete company name */
    var el = $('.combobox').combobox();

      el.on('change', function(e){
       if($(this).data('combobox').$element.val() == ''){
         console.log('Its triggered incorrectly');
         return false;
       }

       var dic = $(this).data('combobox').map,
        val = $(this).val(),
        clean = true;
        
       for(var i in dic){
         if(!dic.hasOwnProperty(i)) continue;
         if(dic[i] == val){
           console.log(dic[i], i); // dic[i] = value, i = label
           clean = false;
           break;
         }
       }
       
       if(clean)
         console.log('Input was cleared');
      });

      /* End  Auto complete company name */
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
      var counter = 1;
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
                  
        

        // newTextBoxDiv.after().html('<td><select onchange="getval(this);" class="form-control rank" id="rank[' + counter + ']" name="rank[' + counter + ']">'+htmloptions+'</select></td><td><input type="number" step=0.01 name="contract_duration[]"  Step 0.5 class="form-control" required /></td><td><input type="number" step="0.01" name="experience_years[]" 0.5="" class="form-control"></td><td><input type="number" class="BoxValClass form-control" name="wage[]" placeholder="Enter wage"></td>');
		newTextBoxDiv.after().html('<td><select onchange="getval(this);" class="form-control rank" id="rank[' + counter + ']" name="rank[' + counter + ']">'+htmloptions+'</select></td><td><input type="number" step=0.01 name="contract_duration[]"  Step 0.5 class="form-control" placeholder="Contract Duration" required /></td><td><input type="number" class="BoxValClass form-control" name="wage[]" placeholder="Enter wage"></td>');
        newTextBoxDiv.appendTo("#appendhere");

       counter++;

      });


      //REMOVE ROW  
       $("#removeButton").click(function () {
                 
          if(counter==1){
            alert("No more textbox to remove");
            return false;
          }               
          counter--;          
          $("#TextBoxDiv" + counter).remove();
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