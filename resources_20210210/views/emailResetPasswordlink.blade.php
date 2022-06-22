@extends('layouts.app')
<?php 
    $url = url('public/assets/img/bn2.jpg');
?>
@section('content')
    <section class="inner-header-title" style="background-image:url({{ $url }});">
        <div class="container">
            <h1>Login</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="tab-sec gray">
        <div class="container">
        
            <div class="col-lg-8 col-md-8 col-sm-12 col-lg-offset-2 col-md-offset-2">
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
                <!-- Email not varify then click below link-->
                @if( session('email') )
                <div class="register-account text-center">
                    <div class="alert alert-success alert-dismissable fade in">
                         <a class="close" data-dismiss="alert" aria-label="close"> &times;</a>
                         <a href="{{ route('signin.emailverify') }}" style="color:blue; font-size:14;">Click here and check you inbox to varify email</a>
                    </div>
                </div>
                @endif
                <!-- End Flash Msg on success-->
                <div class="new-logwrap">
                <form method="POST" action="{{ route('resetlink') }}">
                    @csrf
                    <!-- <div class="form-group">
                        <label>Username</label>
                        <div class="input-with-icon">
                            <input type="text" class="form-control" placeholder="Enter Your Username">
                            <i class="theme-cl ti-user"></i>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-with-icon">
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter Your Email" required>
                            <i class="theme-cl ti-email"></i>
                        </div>
                    </div>
                                    
                    <div class="form-groups">
                        <button type="submit" class="btn btn-primary theme-bg full-width">Send</button>
                    </div>
                </form>
                
                </div>
            </div>
        </div>
    </section>
@endsection
