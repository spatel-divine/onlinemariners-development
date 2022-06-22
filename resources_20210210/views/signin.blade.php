@extends('layouts.app')
<style type="text/css">
    
    @media (min-width: 320px) and (max-width: 480px) {
        .new-logwrap {
            background: #fff;
            padding: 20px !important;
            margin: 0 auto;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
        }
    }   
</style>

@section('content')
    <section class="inner-header-title" style="background-image:url(public/assets/img/online_mariners_bredcrump.jpg);">
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
           {{-- @if( session('email') )
            <!-- <div class="register-account text-center">
                <div class="alert alert-success alert-dismissable fade in">
                     <a class="close" data-dismiss="alert" aria-label="close"> &times;</a>
                     <a href="{{ route('signin.emailverify') }}" style="color:blue; font-size:14;">Click here and check you inbox to varify email</a>
                </div>
            </div> -->
            @endif --}}
            
        	<!-- Social Login buttons -->        
            <div class="social-login row">
                
                <div class="col-md-6">
                    <a href="{{ route('fb.redirect','facebook') }}" class="jb-btn-icon social-login-facebook"><i class="fa fa-facebook"></i>Facebook</a>
                </div>
                
                <div class="col-md-6">
                    <a href="{{ route('fb.redirect','google') }}" class="jb-btn-icon social-login-google"><i class="fa fa-google-plus"></i>Google</a>
                </div>
                
                <!-- <div class="col-md-6">
                    <a href="#" class="jb-btn-icon social-login-twitter"><i class="fa fa-twitter"></i>Twitter</a>
                </div>
                
                <div class="col-md-6">
                    <a href="#" class="jb-btn-icon social-login-linkedin"><i class="fa fa-linkedin"></i>Linkedin</a>
                </div> -->
                
            </div>
        	<div class="social-devider" style='margin-bottom: 35px;'>
                <span class="line"></span>
                <span class="circle">Or</span>
            </div>
            <!-- End Flash Msg on success-->
            <div class="new-logwrap">
            <div class="register-account">
                By hitting the <a href="{{ route('signup') }}" class="theme-cl">"Register OR SignUp"</a> link, you will be able to register a new account in case you have not registered before.
            </div>
            <form method="POST" action="{{ route('signin.validate') }}">
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

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-with-icon">
                        <input type="password" name="password" class="form-control" placeholder="Enter Your Password" required>
                        <i class="theme-cl ti-lock"></i>
                    </div>
                </div>
                

                <div class="form-groups">
                    <button type="submit" class="btn btn-primary theme-bg full-width">Login</button>
                </div>
            </form>
            <!-- Reset Password -->
            <!-- <div class="forget-account">
                <a class="theme-cl" href="{{-- route('emailenter') --}}">Forget Password?</a>
            </div> -->
            

            </div>
            </div>
        </div>
    </section>
@endsection
