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
    // print_r($employer)
  ?>
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      Add Employer
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Add Employer</li>
    </ol>
  </section>
  <!-- Main Content -->
  <section class="content">  
    <div class="row">
      <div class="col-sm-10">
        <?php
          // echo 'error:';
          // print_r($errors->all());
        ?>
          @if (count($errors->all()) > 0)
          
          <ul>
              <div class="alert alert-danger alert-dismissable fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                @foreach ($errors->all() as $error)
                  <li style="color: white;list-style-type: none;text-transform: capitalize;">{{ $error }}</li>
                @endforeach
             </div>
          </ul>
          @endif
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
              <h3 class="box-title">Add Employer Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal add-employee-form" method="POST" action="{{ route('addEmp') }}" enctype="multipart/form-data" >
              @csrf
              <?php 
                if(isset($employer[0]->id)){
                  $empID = $employer[0]->id;
                }else{
                  $empID = '';
                }
                
              ?>
              <input type="hidden" name="id" value="{{ $empID }}">
              <div class="box-body">
                <div class="form-group">                  
                  <div class="col-sm-offset-2 col-sm-10">
                    <?php

                      // $profileimg = $employer[0]->pic_path;
                      if(isset($profileimg) && ($profileimg != 'emp-default.png')){
                          $path = url('public/empProfile/'.$profileimg);
                      }else{
                          $path = url('public/assets/img/avatar-default.png');
                      }
                    ?>
                    <img id="profileimg" src="{{ $path }}" alt="profileimg" height="80" width="80" />
                  </div>                  
                </div>                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Profile Picture</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="old_pic_path" value="{{ isset($employer[0]->pic_path) ? $employer[0]->pic_path : ''  }}" >
                    <input type="file" name="pic_path" id="pic_path">
                  </div>                  
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control"  value="{{ old('email') }}" placeholder="Email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Company Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" placeholder="Company Name" required>
                  </div>
                </div>

                <!-- <input type="hidden" name="contact_person" class="form-control" value="null" placeholder="Contact Person"> -->
                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Contact Person</label>
                  <div class="col-sm-10">
                    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}" placeholder="Contact Person" required>
                  </div>
                </div> -->
                <!-- <input type="hidden" name="contact_person" class="form-control" value="null" placeholder="Contact Person"> -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Mobile Number</label>
                  <div class="col-sm-10">
                    <input type="number" name="mobile_number" class="form-control" value="{{ old('mobile_number') }}" placeholder="Mobile Number" required>
                  </div>
                </div>

               <!--  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-10">
                    <input type="text" id="my-address" name="address" class="form-control" value="{{ old('address') }}" placeholder="Address" required>
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
                <!-- street1 -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">street1</label>
                  <div class="col-sm-10">
                    <input type="text" name="street1" class="form-control" value="{{ old('street1') }}" placeholder="Enter address street1" required>
                  </div>
                </div>
                <!-- street2 -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">street2</label>
                  <div class="col-sm-10">
                    <input type="text" name="street2" class="form-control" value="{{ old('street2') }}" placeholder="Enter address street2">
                  </div>
                </div>

                

                <!-- Country -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Country*</label>
                  <div class="col-sm-10">
                    <select name="country" class="form-control" id="country" required>
                      <option value="">Select Country</option>
                      @foreach($countries as $country)
                      <option value="{{ $country->id }}" {{ old('country') == $country->name ? "selected" :""}}>{{ $country->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                
                <!-- State -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">State*</label>
                  <div class="col-sm-10">
                    <select name="state" class="form-control" id="state" required>
                      <option value="">Select State</option>
                      @foreach($states as $state)
                      <option value="{{ $state->id }}" {{ old('state') == $state->name ? "selected" :""}}>{{ $state->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>                
                
                <!-- City -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-10">
                    <select name="city" class="form-control" id="city" required>
                      <option value="">Select City</option>
                    </select>
                    <!-- <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="Enter City" required> -->
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-4">
                    <?php 
                      if(isset($employer[0]->company_logo)){
                        $companyLogo = $employer[0]->company_logo;  
                      }
                      
                      if(isset($companyLogo) && ($companyLogo != '')){
                          $path = url('public/companyLogo/'.$companyLogo);
                      }
                    ?>
                    @if(isset($companyLogo))
                    <img src="{{ $path }}" name="company_logo" id="companylogoimg" width="80" height="80">
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Company Logo</label>
                  <div class="col-sm-6">                    
                    <input type="hidden" name="old_company_logo" value="{{ isset($employer[0]->company_logo) ? $employer[0]->company_logo : '' }}">
                    <input type="file" name="company_logo" id="company_logo">
                  </div>
                </div>
                <!-- city
                state
                country -->                
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="col-sm-offset-2 btn btn-default">Add</button>
                <a href="{{ route('employer.lists') }}" class="btn btn-info">Cancel</a>
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

    //company logo
    
    function readURLClogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#companylogoimg').attr('src', e.target.result);                
            }            
            reader.readAsDataURL(input.files[0]);
        }
        var reader = new FileReader();

        //Read the contents of Image File.
        reader.readAsDataURL(input.files[0]);
        reader.onload = function (e) {
          //Initiate the JavaScript Image object.
          var image = new Image();

          //Set the Base64 string return from FileReader as source
          image.src = e.target.result;

          //Validate the File Height and Width.
          image.onload = function () {
            var height = this.height;
            var width = this.width;
            if (height <= 225 || width <= 225) {
              alert("company Logo's maximum Height must be less than or equal to 225px and Width must be less than or equal to 225px.");
              return false;
            }
            alert("Uploaded image has valid Height and Width.");
            return true;
          };
        };
    }
    
    $("#company_logo").change(function(){
        readURLClogo(this);
    });
    /* Country state city selection */
    $('#country').change(function(){
      var countryID = $(this).val();  
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if(countryID){
        $.ajax({
          type:"POST",
          url:"{{ route('getStateList') }}",
          data:{ countryID: countryID },
          success:function(data){ 
              
          $("#state").html(data);  
          // if(res){
          //   $("#state").empty();
          //   $("#state").append('<option>Select</option>');
          //   $.each(res,function(key,value){
          //     $("#state").append('<option value="'+key+'">'+value+'</option>');
          //   });
          
          // }else{
          //   $("#state").empty();
          // }
          }
        });
      }else{
        $("#state").empty();
        $("#city").empty();
      }   
    });
    /* based on state select city option*/
    $('#state').change(function(){
      var stateID = $(this).val();  
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if(stateID){
        $.ajax({
          type:"POST",
          url:"{{ route('getCityList') }}",
          data:{ stateID: stateID },
          success:function(data){ 
          $("#city").html(data);  
          // if(res){
          //   $("#state").empty();
          //   $("#state").append('<option>Select</option>');
          //   $.each(res,function(key,value){
          //     $("#state").append('<option value="'+key+'">'+value+'</option>');
          //   });
          
          // }else{
          //   $("#state").empty();
          // }
          }
        });
      }else{
        // $("#state").empty();
        $("#city").empty();
      }   
    });
    </script>
@endsection