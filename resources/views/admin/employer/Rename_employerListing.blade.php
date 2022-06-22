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
    // print_r($employers)
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
                  <th>Status</th>
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
                      ?>
                      <img src="{{ $path }}" width="80" height="80" alt="emp-image"/>
                  </td>
                  <td>{{ ($emp->name) ? $emp->name : 'Not Updated'  }}</td>
                  <td>{{ ($emp->email) ? $emp->email : 'Not Updated'  }}</td>
                  <td>{{ ($emp->mobile_number) ? $emp->mobile_number : 'Not Updated'  }}</td>
                  <td>{{ ($emp->city) ? $emp->city : 'Not Updated'  }}</td>
                  <td>{{ ($emp->country) ? $emp->country : 'Not updated'  }}</td>                  
                  <td>
                    <?php 
                      $status = $emp->profile_status; 
                      if($status == '1'){
                        echo '<lable class="label label-success">Active</lable>'; 
                      }else{
                        echo '<lable class="label label-danger">InActive</lable>'; 
                      }
                    ?>
                  </td>
                  <td>
                    <form class="form-horizontal" method="post" action="{{ route('deleteEmp',[ 'employer_id' => $emp->id]) }}">

                          <a href="{{ route('editEmp', [ 'employer_id' => $emp->id])  }}" style="margin-right: 10px;" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                          {{ csrf_field() }}
                          <!-- <input type="hidden" name="_method" value="DELETE"> -->
                          <!-- <input type="hidden" name="employer_id" value="{{ $emp->id }}"> -->
                          <button type="submit" onclick="return confirm('Are You Sure ?');" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button>
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
                  <th>Status</th>
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
