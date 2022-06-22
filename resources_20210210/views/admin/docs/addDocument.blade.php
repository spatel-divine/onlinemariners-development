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
      Add Document
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Add Document</li>
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
            <form class="form-horizontal" method="post" action="{{ route('admin.addDocs') }}" enctype="multipart/form-data" >
              @csrf
              <!-- <input type="hidden" name="id" value=""> -->
              <div class="box-body">
                <div class="form-group">                  
                  <div class="col-sm-offset-3 col-sm-9">
                    <?php 
                      // if(isset($candidate[0]->profile_path)){
                      //   $profileimg = $candidate[0]->profile_path;
                      // }else{
                      //  $profileimg = ''; 
                      // }
                      // if($profileimg){
                      //   $path = url('/public/profile/'.$profileimg);
                      // }else{
                      //   $path = url('public/assets/img/avatar-default.png');
                      // }
                    ?>
                    <!-- <img id="profileimg" src="{{-- $path --}}" alt="profileimg" height="80" width="80" /> -->
                  </div>                  
                </div>
                <!-- Name -->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-9">
                    <input type="text" name="document_name" class="form-control" value="" placeholder="Name" required>
                  </div>
                </div>
                
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="col-sm-offset-4 btn btn-default">Add</button>
                <a href="{{ route('admin.doclisting') }}" class="btn btn-info">Cancel</a>
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