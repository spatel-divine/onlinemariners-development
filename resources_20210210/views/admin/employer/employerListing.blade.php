@extends('layouts.app_adminafterlogin')
@section('content')
<style type="text/css">
    table.table-bordered.dataTable tbody td {
      border-bottom-width: 0;
      /*text-transform: capitalize;*/
    }
</style>
<div class="content-wrapper">
  <?php
    // echo '<pre>';
    // print_r($employers);
    // exit;
  ?>
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      Employer Listing
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Employer Listing</li>
    </ol>
  </section>
  <!-- Main Content -->
  <section class="content">  
    <div class="row">
      <div class="col-sm-12">
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
          <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Data Table With Full Features</h3> -->
              <div class="row">
                <div class="col-sm-10"></div>
                <div class="col-sm-2"><a href="{{ route('emploadform') }}" class="btn btn-primary">Add Employer</a></div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" data-order='[[ 0, "desc" ]]' class="table table-bordered table-striped">
                <thead>                
                <tr>
                  <th>Ref NO</th>
                  <th>Profile Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile Number</th>                  
                  <th>City</th>
                  <th>Country</th>
                  <th>Email Verified</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if($employers)
                @foreach($employers as $emp)
                <tr>
                  <td>{{ $emp->id }}</td>
                  <td>
                      <?php
                        $file = $emp->pic_path;
                        if($file && ($file != 'emp-default.png') && ($file != '')){
                            $path = url('/public/empProfile/'.$file);
                        }else{
                            $path = url('/public/assets/img/avatar-default.png');
                        }
                        $city = '';
                        $country = '';
                        if($emp->city != ''){
                          $cityid = $emp->city;
                          $city = DB::table('cities')->select('id','name')->where('id', $cityid)->get();                         
                        }
                        
                        if($emp->country != ''){
                          $countryid = $emp->country;
                          $country = DB::table('countries')->select('id','name')->where('id', $countryid)->get();                          
                        }
                        // if($city[0]->name == ''){
                        //   $city[0]->name = '';
                        // }
                        // if($country[0]->name == ''){
                        //   $country[0]->name = '';
                        // }
                        
                        // echo "<pre>";
                        // print_r($city);
                        // exit;
                        // var_dump(ltrim($city[0]->name,"'"));
                        // print_r($city[0]->name);
                        // print_r($city[0]->name);
                        // echo '<br>country: '.$city[0]->name;
                        // echo '<br>country: '.$country[0]->name;
                        // exit;
                        //echo trim(str_replace("'", " ", $city[0]->name));
                       	//(ltrim($city[0]->name,"'"))
                      ?>
                      <img src="{{ $path }}" width="80" height="80" alt="emp-image"/>
                  </td>
                  <td style="text-transform: capitalize;">{{ isset($emp->name) ? $emp->name : 'Not Updated'  }}</td>
                  <td>{{ isset($emp->email) ? $emp->email : 'Not Updated'  }}</td>
                  <td >{{ isset($emp->mobile_number) ? $emp->mobile_number : 'Not Updated'  }}</td>
                  <td style="text-transform: capitalize;">{{ isset($emp->city) ?  $emp->city : 'Not Updated'  }}</td>
                  <td style="text-transform: capitalize;">{{ isset($emp->country) ? $emp->country : 'Not updated'  }}</td>
                  <td>                    
                    <div class="form-group" style="padding: 5% 0;">                      
                      <!-- <label>Select</label> -->
                      <select id="verified_<?php echo $emp->id; ?>" class="form-control profile_status" name="profile_status" data-id="<?php echo $emp->id; ?>">
                        <option>Select Verified Status</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                      </select>
                    </div><br>

                    <?php 
                      $verified = $emp->email_varified;
                      $empId = $emp->id;                      
                      if($verified == '1'){
                        ?>
                        <lable id="old_status_<?php echo $empId; ?>" class="label label-success">Active</lable>
                      <?php }else{ ?>
                        <lable id="old_status_<?php echo $empId; ?>" class="label label-danger pstatus_<?php echo $emp->id; ?>">InActive</lable>
                     <?php } ?>                  
                    <label id="<?php echo 'current_status_'.$emp->id ?>" class="cstatus"></label>                    
                  </td>
                  <td>
                    <form class="form-horizontal" method="post" action="{{ route('deleteEmp',[ 'employer_id' => $emp->id]) }}">
                          <a href="{{ route('editEmp', [ 'employer_id' => $emp->id])  }}" style="margin-right: 10px;" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                          {{ csrf_field() }}
                          <!-- <input type="hidden" name="_method" value="DELETE"> -->
                          <!-- <input type="hidden" name="employer_id" value="{{ $emp->id }}"> -->
                          <button type="submit" onclick="return confirm('Are you sure you want to delete selected employer, All Employer related information will be deleted like Profile, Conversations, Applied Jobs, Post Jobs Etc?');" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button>
                      </form>
                  </td>
                </tr>
                @endforeach
                @endif
                </tbody>
                <tfoot>
                  <th>Ref NO</th>
                  <th>Profile Image</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile Number</th>                  
                  <th>City</th>
                  <th>Country</th>
                  <th>Email Verified</th>
                  <th>Actions</th>
                </tfoot>
              </table>
            </div>
      
        </div><!-- /.box -->
      </div><!-- col-sm-12 -->
    </div><!-- end of row -->
  </section>
</div>
@endsection
@section('custom_js')
<script type="text/javascript">
    
    // $('.cstatus').hide();

    $('.profile_status').on('change', function() {
      var empid = $(this).attr('data-id');
      var profile_status = this.value;
      // alert('empid:'+ empid+ ' profile_status' + profile_status);
      if(profile_status == 'Select Verified Status'){
        return false;
      }

      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      // var empid = $('.pstatus_'+empid).attr('data-id');      
       
      $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{ route('employerStatus') }}",
        data: {'empid': empid, 'profile_status': profile_status},
        success: function(data){
          // alert('Res: '+data);
          // console.log('Res: '+data);
          // alert('old_status_'+empid);
          

          $("#old_status_"+empid).hide();

          if(data == '1' || profile_status){            
            $("#current_status_"+empid).show();
            if(profile_status == '1'){
              //success active User
              // alert('active')              
              $("#current_status_"+empid).removeAttr("label-danger");  
              $("#current_status_"+empid).addClass("label label-success");
              $("#current_status_"+empid).text("Active");
            }else{
              // alert('Inactive')
              //Fail and Inactive User
              $("#current_status_"+empid).removeClass("label-success");
              $("#current_status_"+empid).addClass("label label-danger");
              $("#current_status_"+empid).text("InActive");
            }

            // var text2 = 'Select Email Verified Status';
            // $("#verified_"+empid+"option").filter(function() {
            //   return this.text == text2; 
            // }).attr('selected', true);
          }
          // else{
          //   $("#current_status_"+empid).removeAttr("class");  
          // }
          
        }

      });//end of ajax call

    });//end of select option

</script>
@endsection