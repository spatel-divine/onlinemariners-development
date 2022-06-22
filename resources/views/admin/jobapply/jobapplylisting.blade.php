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
    // print_r($jobapplyList);
    // exit;
  ?>
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      JobApply Listing
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">JobApply Listing</li>
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
                  <th>Employer Name</th>
                  <th>Candidate Name</th> 
                  <th>Job Title</th>                  
                  <th>Job Deadline</th>
                                  <th>Rank</th>    
                  <th>Vessel Type</th>              
                  <th>Application Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if($jobapplyList)
                @foreach($jobapplyList as $joblist)
                <tr>
                  <td>{{ mb_strimwidth($joblist->employer_name, 0,20,'...') }}</td>
                  <td>{{ mb_strimwidth($joblist->candidate_name, 0,20,'...') }}</td> 
                  <td>{{ mb_strimwidth($joblist->job_title, 0,20,'...') }}</td>                 
                  <td>{{ mb_strimwidth($joblist->app_deadline, 0,20,'...') }}</td>
                  <td>{{ mb_strimwidth($joblist->rank_position, 0,20,'...') }}</td>
                  <td>{{ mb_strimwidth($joblist->vassel_type, 0,20,'...') }}</td>
                  <td>
                    <?php 
                      $status = $joblist->apply_status;
                      if($status == '0'){
                        echo '<lable class="label label-default">Pending</lable>'; 
                      }else if($status == '1'){
                        echo '<lable class="label label-primary">Selected</lable>'; 
                      }else if($status == '2'){
                        echo '<lable class="label label-success">Shotlisted</lable>'; 
                      }else if($status == '3'){
                        echo '<lable class="label label-info">Called For Interview</lable>'; 
                      }else if($status == '4'){
                        echo '<lable class="label label-warning">Under review</lable>'; 
                      }else if($status == '5'){
                        echo '<lable class="label label-danger">Rejected</lable>'; 
                      }
                      ?>
                  </td>
                  <td>
                    <form class="form-horizontal" method="post" action="{{ route('deleteEmp',[ 'postjob_id' => 1]) }}">
                          <a href="{{ route('editPostjob', [ 'postjob_id' => $joblist->postjob_id])  }}" style="margin-right: 10px;" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                          {{ csrf_field() }}                          
                          <button type="submit" onclick="return confirm('Are You Sure ?');" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button>
                          <!-- <a href="" class="btn btn-primary btn-xs" style="margin-left:5%;"><i class='fa fa-list'></i></a> -->
                      </form>
                  </td>
                </tr>
                @endforeach
                @endif
                </tbody>
                <tfoot>
                  <th>Employer Name</th>
                  <th>Candidate Name</th> 
                  <th>Job Title</th>                  
                  <th>Job Deadline</th>
                  <th>Vessel Type</th>
                  <th>Rank</th>                  
                  <th>Application Status</th>
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
