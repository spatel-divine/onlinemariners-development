@include('email.header') 
<p style="margin-top:5px;margin-bottom:10px;">Hi {{$toname}},</p>

<p>Welcome to TheirSpot. Below is your profile activation code.</p>

<h2>{{$verification_code}}</h2>

<p style="margin-bottom:10px;">Please enter this on your profile activation screen.</p>

@include('email.footer') 
