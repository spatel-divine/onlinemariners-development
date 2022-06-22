@extends('layouts.app_adminafterlogin')
@section('content')
<style type="text/css">
    .table_td {
      border-bottom-width: 0;
    }
</style>
<div class="content-wrapper">
  
  <!-- Page Content header -->
  <section class="content-header">
    <h1>
      Enquiries Listing
      <!-- <small>advanced tables</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Enquiries Listing</li>
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
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" data-order='[[ 0, "desc" ]]' class="table table-bordered table-striped">
                <thead>                
                <tr>
                  <th style="width: 10%">Ref No.</th>
                  <th style="width: 10%">Name</th>
                  <th style="width: 20%">Email</th>
                  <th style="width: 20%">Phone Number</th>
                  <th style="width: 10%">Subject</th>
                  <th style="width: 30%">Message</th>
                </tr>
                </thead>
                <tbody>
                @if($enquiries)
                @foreach($enquiries as $c)
                <tr>
                  <td style="width: 10%" class="table_td">{{ $c->id }}</td>
                  <td style="width: 10%"  class="table_td">{{ $c->name }}</td>
                  <td style="width: 10%" class="table_td">{{ $c->email }}</td>
                  <td style="width: 10%" class="table_td">{{ $c->phone_number }}</td>
                  <td style="width: 10%" class="table_td">{{ $c->subject }}</td>
                  <td style="width: 10%" class="table_td">{{ $c->message }}</td>
                  
                </tr>
                @endforeach
                @endif
                </tbody>
                <tfoot>
                  <th style="width: 10%">Ref No.</th>
                  <th style="width: 10%">Name</th>
                  <th style="width: 20%">Email</th>
                  <th style="width: 20%">Phone Number</th>
                  <th style="width: 10%">Subject</th>
                  <th style="width: 30%">Message</th>
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

@endsection
