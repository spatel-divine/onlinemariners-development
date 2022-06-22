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
    // print_r($documentList);    
    // exit;
  ?>
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      New Documents Listing
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">New Documents Listing</li>
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
                  <!-- <a href="{{-- route('candiform') --}}" class="btn btn-primary">Add Documents</a> -->
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" data-order='[[ 0, "desc" ]]' class="table table-bordered table-striped">
                <thead>                
                <tr>
                  <th>Ref No</th>
                  <th>Document Name</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($documentList as $d)
                  <tr>
                    <td>{{ isset($d->id) ? $d->id : 'Not updated'  }}</td>                    
                    <td>{{ isset($d->document_name) ? $d->document_name : 'Not updated'  }}</td>
                    <td><form class="form-horizontal" method="post" action="{{-- route('admin.deleteDocs',[ 'document_id' => $d->id]) --}}">
                          <a href="{{ route('admin.editForm', ['document_id' => $d->id]) }}" style="margin-right: 10px;" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                          {{ csrf_field() }}                          
                          <!-- <button type="submit" onclick="return confirm('Are You Sure ?');" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button> -->
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <th>Ref No</th>
                  <th>Document Name</th>                  
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
