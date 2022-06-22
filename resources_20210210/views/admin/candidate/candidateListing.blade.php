@extends('layouts.app_adminafterlogin')
@section('content')
<style type="text/css">
    .table_td {
      border-bottom-width: 0;
      text-transform: capitalize;
    }
</style>
<div class="content-wrapper">
  <?php
    // echo '<pre>';
    // print_r($candidates);
    // //email_verified_at
    // exit;
  ?>
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      Candidate Listing
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Candidate Listing</li>
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
                <div class="col-sm-2">
                  <a href="{{ route('candiform') }}" class="btn btn-primary">Add Candidate</a>
                </div>
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
                  <th>Phone Number</th>
                  <th>Rank</th>
                  <th>Country</th>
                  <th>Email Verification Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if($candidates)
                @foreach($candidates as $c)
                <tr>
                  <td class="table_td">{{ $c->id }}</td>
                  <td class="table_td">
                      <?php
                        $file = $c->profile_path;
                        if($file && ($file != 'emp-default.png') && ($file != '')){
                            $path = url('/public/profile/'.$file);
                        }else{
                            $path = url('/public/assets/img/avatar-default.png');
                        }
                      ?>
                      <img src="{{ $path }}" width="80" height="80" alt="emp-image"/>
                  </td>
                  <td class="table_td">{{ ($c->name) ? $c->name : 'Not Updated'  }}</td>
                  <td class="table_td">{{ ($c->email) ? $c->email : 'Not Updated'  }}</td>
                  <td class="table_td">{{ ($c->phone_number) ? $c->phone_number : 'Not Updated'  }}</td>
                  <td class="table_td">{{ ($c->applied_for) ? $c->applied_for : 'Not Updated'  }}</td>
                  <td class="table_td">{{ ($c->nationality) ? $c->nationality : 'Not updated'  }}</td>                  
                  <td class="table_td">
                    <div class="form-group" style="padding: 5% 0;">                      
                      <!-- <label>Select</label> -->
                      <select id="verified_<?php echo $c->id; ?>" class="form-control candidate_email_verified" name="candidate_email_verified" data-id="<?php echo $c->id; ?>">
                        <option>Select Verified Status</option>
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                      </select>
                    </div><br>
                    <?php 
                      $status = $c->email_verified_at;
                      $candidateID = $c->id;
                      if($status == '1'){
                    ?>
                        <lable id="old_ev_status_<?php echo $candidateID; ?>" class="label label-success">Active</lable> 
                    <?php }else{ ?>
                        <lable id="old_ev_status_<?php echo $candidateID; ?>" class="label label-danger">InActive</lable>
                     <?php } ?>
                     <label id="<?php echo 'current_everified_status_'.$candidateID ?>" class="cstatus"></label>
                  </td>
                  <td class="table_td">
                    <form class="form-horizontal" method="post" action="{{ route('deleteCandidate',[ 'candidate_id' => $c->id]) }}">
                          <a href="{{ route('editCandidate', ['candidate_id' => $c->id])  }}" style="margin-right: 10px;" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                          {{ csrf_field() }}                          
                          <button type="submit" onclick="return confirm('Are you sure you want to delete selected cacndidate, All Candidate related information will be deleted like Profile, Conversations, Applied Jobs, Docs Etc?');" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button>
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
                  <th>Phone Number</th>
                  <th>Rank</th>
                  <th>Country</th>
                  <th>Email Verification Status</th>
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
  $('.candidate_email_verified').on('change', function() {
      var candidateID = $(this).attr('data-id');
      var email_verified_status = this.value;
      // alert('empid:'+ empid+ ' profile_status' + profile_status);
      if(email_verified_status == 'Select Verified Status'){
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
        url: "{{ route('candiEverifiedChange') }}",
        data: {'candidateID': candidateID, 'email_verified_status': email_verified_status},
        success: function(data){
          // alert('Res: '+data);
          // console.log('Res: '+data);
          // alert('old_status_'+empid);
          

          $("#old_ev_status_"+candidateID).hide();

          if(data == '1' || email_verified_status){            
            $("#current_everified_status_"+candidateID).show();
            if(email_verified_status == '1'){
              //success active User
              // alert('active')              
              $("#current_everified_status_"+candidateID).removeAttr("label-danger");  
              $("#current_everified_status_"+candidateID).addClass("label label-success");
              $("#current_everified_status_"+candidateID).text("Active");
            }else{
              // alert('Inactive')
              //Fail and Inactive User
              $("#current_everified_status_"+candidateID).removeClass("label-success");
              $("#current_everified_status_"+candidateID).addClass("label label-danger");
              $("#current_everified_status_"+candidateID).text("InActive");
            }
         
          }                  
        }

      });//end of ajax call

    });//end of select option
</script>
@endsection
