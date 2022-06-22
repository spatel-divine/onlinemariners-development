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
                  <div class="col-sm-3">
                    <a class="btn btn-success btn-small" id="featured">Featured JobPost</a>
                    <a class="btn btn-warning btn-small" id="unfeatured">Unfeatured JobPost</a>  
                  </div>                
                  <div class="headerdivider col-sm-1" style="border-left: 2px solid #9e9fa5;" ></div>
                  <div class="col-sm-3">
                    <a class="btn btn-success btn-small " id="itfjobs">ITF Job</a>
                    <a class="btn btn-warning btn-small" id="nonitfjobs">Make Non-ITF Job</a>
                  </div>
                  <div class="col-sm-5">
                    <p class="col-sm-9" style="color: green;font-weight: bold;padding-top: 2%;">* If checkbox checked then its Featured or ITF Job.</p>
                    <a href="{{ route('addPostjob') }}" class="btn btn-primary">Add Postjob</a>
                  </div>
                </div>                
            </div>
            <div class="box-body">
              <table id="example1" data-order='[[ 0, "desc" ]]' class="table table-bordered table-striped">
                <thead>                
                <tr>
                  <th>Feature-Job</th>
                  <th>ITF-Job</th>
                  <th>Employer Name</th>
                  <th>Company Name</th>
<!--                   <th>Job Title</th> -->
                  <th>Job Deadline</th>
                  <th>Rank</th>
                  <!-- <th>Wage</th> -->
                  <!-- <th>Country</th> -->
                  <!-- <th>Feature-Job</th>
                  <th>ITF-Job</th> -->
                  <th>Status</th>                  
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if($postjobs)
                @foreach($postjobs as $job)
                <tr>
                  <td>
                    <?php 
                      $oldJobpostID = $job->id;
                      $jobCount = 1;
                      $postwage_ID = $job->postwage_id;
                      // var_dump($job->id != $job->id);                      
                      if($jobCount == 1){
                      // echo $job->featured_job;
                    ?>
                    <input type="checkbox" id="{{ $job->id }}" class="featurepost" name="featurepost[]" value="{{ $job->id }}"  postjob-id="{{ $job->id }}" postwage-id="{{ $job->postwage_id }}" {{ ($job->featured_job == 1) ? 'checked' : 'unckecked'  }}>
                    <?php 
                        
                        $jobCount = 0;
                       }
                      $jobCount++;
                      echo $job->id;
                    ?>
                    <!-- <input type="hidden" id="{{ $postwage_ID }}" class="postwage" name="postwage_id" value="{{ $postwage_ID }}" > -->
                  </td>
                  <td>
                    <?php 
                      $oldJobpostID = $job->id;
                      $jobCount = 1;
                      $postwage_ID = $job->postwage_id;
                      // var_dump($job->id != $job->id);                      
                      if($jobCount == 1){
                      // echo $job->featured_job;
                    ?>
                    <input type="checkbox" id="{{ $job->id }}" class="itfjobpost" name="itfjobpost[]" value="{{ $job->id }}"  postjob-id="{{ $job->id }}" postwage-id="{{ $job->postwage_id }}" {{ ($job->itf_jobs == 1) ? 'checked' : 'unckecked'  }}>
                    <?php 
                        
                        $jobCount = 0;
                       }
                      $jobCount++;
                      echo $job->id;
                    ?>
                    <!-- <input type="hidden" id="{{ $postwage_ID }}" class="postwage" name="postwage_id" value="{{ $postwage_ID }}" > -->
                  </td>
                  <td>{{ mb_strimwidth($job->name, 0, 20, "...") }}</td>                  
                  <td>{{ mb_strimwidth($job->company_name, 0, 20, "...") }}</td>                  
                  <td>{{ mb_strimwidth(date('m-d-Y' , strtotime($job->app_deadline)) , 0,20,"...") }}</td>
                  <td>{{ mb_strimwidth($job->rank_position, 0,20,'...') }}</td>
                  <!-- <td>{{-- '$ '.mb_strimwidth($job->wages, 0,10,'...') --}}</td> -->                  
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
                  <th>Feature-Job</th>
                  <th>ITF-Job</th>
                  <th>Employer Name</th>
                  <th>Company Name</th>
<!--                   <th>Job Title</th> -->
                  <th>Job Deadline</th>
                  <th>Rank</th>
                  <!-- <th>Wage</th> -->
                  <!-- <th>Country</th> -->
                  <!-- <th>Feature-Job</th>
                  <th>ITF-Job</th> -->
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
    //featuared job post 
     $('#featured').click(function () {
        var selectedID = [];
        
        $(':checkbox[name="featurepost[]"]:checked').each (function () {
            selectedID.push(this.id);            
        });
        // alert('job count '+selectedID.length);

        if(selectedID.length > 8){
          alert('Can not feature more than 8 jobpost');
          location.reload();
          return false;
        }
        // var postIds = selectedID.split(',');
        /*
        var list = [];
        for (var i = 0; i < selectedID.length; i++) { 
            list.push();
            // alert("Key" + key + ' Value ' + value.length);
            alert(selectedID[i]);
        } */
          // var postData = { values: list };
        var postdatas =   JSON.stringify(selectedID);
        alert('post data: '+  postdatas);

        var postjobID = $(this).attr("postjob-id");
        var postwageID = $(this).attr("postwage-id");
        // if(this.checked) {        
          // alert('featured'+postjobID);
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:"POST",
            url: "{{ route('featurePostjob') }}",
            data: {postdatas: postdatas},
            success: function(data){
                alert('Selected postjobs are jobfeatured now')
                // var postwage_id = JSON.parse(data);
                // $('#postwage_id').val(postwage_id);        
              }
          });
    });

    //
    $('#unfeatured').click(function () {
      var selectedID = [];
        
        $(':checkbox[name="featurepost[]"]:checked').each (function () {
            selectedID.push(this.id);
        });
        // alert('unfeatured'+selectedID);
        var postdatas =   JSON.stringify(selectedID);
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:"POST",
            url: "{{ route('unfeaturePostjob') }}",
            data: {postdatas: postdatas},
            success: function(data){
                alert('Selected postjobs are Unfeatured now')
                // var postwage_id = JSON.parse(data);
                // $('#postwage_id').val(postwage_id);        
              }
          });
    });
   
      //itfjobs
     $('#itfjobs').click(function () {
        var selectedID = [];
        
        $(':checkbox[name="itfjobpost[]"]:checked').each (function () {
            selectedID.push(this.id);            
        });
        // alert('job count '+selectedID.length);

        if(selectedID.length > 8){
          alert('Can not feature more than 8 jobpost');
          location.reload();
          return false;
        }
        
          // var postData = { values: list };
        var postdatas =   JSON.stringify(selectedID);
        alert('post data: '+  postdatas);

        var postjobID = $(this).attr("postjob-id");
        var postwageID = $(this).attr("postwage-id");
        // if(this.checked) {        
          // alert('featured'+postjobID);
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:"POST",
            url: "{{ route('itfjobsPostjob') }}",
            data: {postdatas: postdatas},
            success: function(data){
                alert('Selected post now becomes ITF-jobs')
                // var postwage_id = JSON.parse(data);
                // $('#postwage_id').val(postwage_id);        
              }
          });
    });

    //nonitfjobs Ajax Call
    $('#nonitfjobs').click(function () {
      var selectedID = [];
        
        $(':checkbox[name="itfjobpost[]"]:checked').each (function () {
            selectedID.push(this.id);
        });
        // alert('unfeatured'+selectedID);
        var postdatas =   JSON.stringify(selectedID);
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type:"POST",
            url: "{{ route('nonitfjobsPostjob') }}",
            data: {postdatas: postdatas},
            success: function(data){
                alert('Selected postjobs becomes Non-ITF post now');
                // window.location.reload();
                // location.reload()
                // var postwage_id = JSON.parse(data);
                // $('#postwage_id').val(postwage_id);        
              }
          });
    });
    
    
  });
</script>
@endsection