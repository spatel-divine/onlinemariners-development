  @extends('layouts.app_adminafterlogin')
@section('content')
<style type="text/css">
    table.table-bordered.dataTable tbody td {
      border-bottom-width: 0;
      text-transform: capitalize;
    }
    
    .headerdivider {
        border-left: 1px solid #38546d;
        /*background: #fff;*/
        width: 1px;
        height: 40px;
        /*position: absolute;
        left: 306px;
        top: -3px;*/
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
      Postjob Listing
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Tables</a></li> -->
      <li class="active">Postjob Listing</li>
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
            <div class="row">
                <div class="col-sm-12" style="margin-left: 1%">
                  <div class="col-sm-4">
                  </div>   
                  <div class="col-sm-8">
                    <p class="col-sm-9" style="color: green;font-weight: bold;padding-top: 2%;">* If Yes its Featured or ITF Job.</p>
                    <a href="{{ route('addPostjob') }}" class="btn btn-primary">Add Postjob</a>
                  </div>
                </div>                
            </div>
            <div class="box-body">
              <table id="example1" data-order='[[ 0, "desc" ]]' class="table table-bordered table-striped">
                <thead>                
                <tr>
                  <th>Employer Name</th>
                  <th>Company Name</th>
                  <th>Application Deadline Date</th>
                  <th>Rank</th>
                  <th>Is Featured</th>
                  <th>Is ITF</th>
                  <th>Status</th>                  
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if($postjobs)
                @foreach($postjobs as $job)
                <tr>
                  <td>{{ mb_strimwidth($job->name, 0, 20, "...") }}</td><td>{{ mb_strimwidth($job->company_name, 0, 20, "...") }}</td>
                  <td>{{ mb_strimwidth(date('m-d-Y' , strtotime($job->app_deadline)) , 0,20,"...") }}</td>
                  <td>{{ mb_strimwidth($job->rank_position, 0,20,'...') }}</td>
                  <td>  

                      <div class="checkbox">
                        <label>
                          <input jobId="{{(isset($job->id) && $job->id) ? $job->id : ''}}" class="is_featured" data-on="Yes" data-off="No" type="checkbox" data-toggle="toggle" {{(isset($job->featured_job) && $job->featured_job=='1') ? 'Checked' : ''}}>
                        </label>
                      </div>
                  </td>
                  <td>
                    
                    <div class="checkbox">
                        <label>
                          <input jobId="{{(isset($job->id) && $job->id) ? $job->id : ''}}" class="is_itf" data-on="Yes" data-off="No" type="checkbox" data-toggle="toggle"  {{(isset($job->itf_jobs) && $job->itf_jobs=='1') ? 'Checked' : ''}}>
                        </label>
                      </div>

                  </td>          
                  <td>
                    <?php 
                      $status = $job->postjob_status; 
                      if($status == '1'){
                        echo '<lable class="label label-success">Active</lable>'; 
                      }else{
                        echo '<lable class="label label-danger">InActive</lable>'; 
                      }
                    ?>
                  </td>
                  
                  <td>
                    <form class="form-horizontal" method="post" action="{{ route('deletePostjob',[ 'postjob_id' => $job->id]) }}">
                          <a href="{{ route('editPostjob', [ 'postjob_id' => $job->id])  }}" style="margin-right: 10px;" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                          {{ csrf_field() }}                          
                          <button type="submit" onclick="return confirm('Are You Sure ?');" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button>
                          <!-- <a href="" class="btn btn-primary btn-xs" style="margin-left:5% "><i class='fa fa-list'></i></a> -->
                      </form>
                  </td>
                </tr>
                @endforeach
                @endif
                </tbody>
                <tfoot>
                  <th>Employer Name</th>
                  <th>Company Name</th>
                  <th>Application Deadline Date</th>
                  <th>Rank</th>
                  <th>Is Featured</th>
                  <th>Is ITF</th>
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
@section('custom_js')
<script type="text/javascript">
  $(document).ready(function() {
        $(document).on("change",".is_itf",function(){
            var jobId = $(this).attr('jobId');
            var ItfValue = $(this).is(":checked");
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({
              type:"POST",
              url: "{{ route('setunsetitfjob') }}",
              data: {jobId: jobId, ItfValue:ItfValue},
              success: function(data){
                if(ItfValue==false){
                  alert('Selected postjob becomes Non-ITF post now');
                }else{
                  alert('Selected postjob becomes ITF post now');
                }
                      
              }
            });
      });

      $(document).on("change",".is_featured",function(){
            var jobId = $(this).attr('jobId');
            var FeatureValue = $(this).is(":checked");
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
              type:"POST",
              url: "{{ route('setunsetfeaturedjob') }}",
              data: {jobId: jobId, FeatureValue:FeatureValue},
              success: function(data){
                if(FeatureValue==false){
                  alert('Selected postjob becomes Non-Featured post now');
                }else{
                  alert('Selected postjob becomes Featured post now');
                }
                      
              }
            });
      });
    
  });
</script>
@endsection