@extends('layouts.authlayout')

@section('content')

  	<!--SignIn-Section-->
	<section id="mob_img">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="inner-logo">
						<a href="{{ url('/') }}"><img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/>  </a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="signin_bg">
						<img src="{{ URL::asset('public/assets/img/signin.png'); }}" class="img-responsive"/>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="signin_form">
						<div class="signin_title">
							<p><img src="{{ URL::asset('public/assets/img/back_icon.png'); }}"/>
							<a href="{{ url('/registration') }}"><span>Back</span></a></p>
							<h3>Re-send OTP</h3>
						</div>
						<form action="{{ route('auth.resendotp') }}" method="POST" id="verifyotp">
						  @csrf
						  <div class="form-group">
							<label for="otpverify">OTP received on email</label>
							<input type="text" name="email_otp" maxlength="6" class="form-control" id="otpverify" placeholder="Enter OTP">
						  </div>
						  <div class="form-group">
							<label for="otpverifyphone">OTP received on phone</label>
							<input type="text" name="phone_otp" maxlength="6" class="form-control" id="otpverifyphone" placeholder="Enter OTP">
						  </div>
						  <button type="submit" class="btn btn-default btn_sign verifyotp">Resend Otp</button><p id="countdown" class="resend-text">resend OTP in 45 sec</p>
						</form>
						<div class="alert alert-success" id="success-alert">
                          <button type="button" class="close" data-dismiss="alert">x</button>
                          <strong>OTP Matched! </strong> Your email and phone number is verified.
                        </div>
						<div class="alert alert-error" id="error-alert">
                          <button type="button" class="close" data-dismiss="alert">x</button>
                          <strong>Not Matched! </strong> Wrong OTP.
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
<script src="{{ URL::asset('public/assets/js/jquery.js'); }}"></script>
<script>
jQuery(document).ready(function(){
var timeleft = 45;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);
    document.getElementById("countdown").innerHTML = "<a href='{{route('auth.otpresend')}}'>Resend</a>";
  } else {
    document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
  }
  timeleft -= 1;
}, 1000);
});
</script>
