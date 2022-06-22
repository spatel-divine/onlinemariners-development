@extends('layouts.app_adminafterlogin')
@section('content')
<?php
  // echo "<pre>";
  // // print_r($latestUsers);
  // print_r($latestPostjobs);
  // exit;
  // echo 'User ID: '.Session::get('userid');
?>
<style type="text/css">
  table.table-bordered.dataTable tbody td {
    border-bottom-width: 0;
    text-transform: capitalize !important;
  }
</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $employerCount }}</h3>
              <p>Total Active Employer</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('employer.lists') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $candidateCount }}<sup style="font-size: 20px"></sup></h3>
              <p>Total Active Candidate</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('candidate.listing') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $totalJobpostCount }}</h3>
              <p>Total Active Job Posted</p>
            </div>
            <div class="icon">
              <i class="fa fa-briefcase"></i>
            </div>
            <a href="{{ route('postjobs.lists') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $totalJobApplyCount }}</h3>
              <p>Candidate Apply For Job </p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('jobapply.listing') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      
      <!-- /.row (main row) -->
      <div class="row">
        <!-- Table 1 -->
        <div class="col-lg-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Recently Registered User</h3>
            </div>              
            <div class="box-body">
              <table id="userlist" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Country</th>
                  <!-- <th>Engine version</th> -->
<!--                   <th>Say Hi...</th> -->
                </tr>
                </thead>
                <tbody>
                @foreach($latestUsers as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td style="text-transform: lowercase !important;">{{ $user->email }}</td>
                  <td>
                    <?php 
                      if(isset($user->country)){
                        echo $user->country;
                      }else if(isset($user->nationality)){
                        echo $user->nationality;
                      }else{
                        echo 'Not Updated yet';
                      }
                    ?>
                  </td>
                  <!-- <td>{{-- $user->name --}}</td> -->
                  <td>
                    <?php
                      $chatid = '';
                      if(isset($user->candidate_chat_id)){
                        $chatid = $user->candidate_chat_id;
                      }else{
                        $chatid = $user->employer_chat_id;
                      }
                      // echo $chatid.'<br>'; target="_blank"
                      $chatUrl = "https://chatingapp.onlinemariners.com/login?id=".$chatid."";
                    ?>
<!--                     <a href="#" class="btn btn-primary" id="{{ $chatid }}" ><i class="fa fa-fw fa-headphones"></i></a> -->
                  </td>
                </tr>
                @endforeach
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <!-- End Table 1 -->
        <!-- Start table 2 -->
        <div class="col-lg-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Recent Post Job</h3>
            </div>              
            <div class="box-body">
              <table id="candidatelist" class="table table-bordered table-hover">
                <thead>
                <tr>                  
                  <th>Employer Name</th>
                  <th>Company Name</th>
                  <th>Country</th>
                  <th>Rank Position</th>                  
                </tr>
                </thead>
                <tbody>
                @foreach($latestPostjobs as $jobs)
                @php
                  $jobs->name = (isset($jobs->name) && ($jobs->name != '')) ? $jobs->name : 'Not Updated' ;
                  $jobs->company_name = isset($jobs->company_name) ? $jobs->company_name : 'Not Updated' ;
                  $jobs->country = isset($jobs->country) ? $jobs->country : 'Not Updated' ;
                  $jobs->rank_position = isset($jobs->rank_position) ? $jobs->rank_position : 'Not Updated' ;
                @endphp
                <tr>                  
                  <td>{{ mb_strimwidth($jobs->name, 0, 15, "...")  }}</td>
                  <td>{{ mb_strimwidth($jobs->company_name, 0, 20, "...")  }}</td>
                  <td>{{ mb_strimwidth($jobs->country, 0, 15 , "...") }}</td>
                  <td>{{ mb_strimwidth($jobs->rank_position, 0, 15, "...") }}</td>
                </tr>
                @endforeach
              </table>
            </div>              
          </div>
        </div>
        <!-- Start table 2 -->
          </div>          
        </div>
      </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('custom_js')
<script>
  $(function () {
    $('#userlist').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    });
    $('#candidatelist').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    });
  })
</script>
@endsection