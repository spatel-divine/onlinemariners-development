@extends('layouts.app_adminlogin')
@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Online</b> Mariners</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
     <!-- Flash Msg on success-->
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
    <form action="{{ route('logintodashboard') }}" method="post">
      @csrf
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="User Name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span><!-- glyphicon glyphicon-envelope -->
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div> -->
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection