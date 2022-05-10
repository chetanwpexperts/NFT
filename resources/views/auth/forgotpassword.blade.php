@extends('layouts.authlayout')

@section('content')

  	<!--SignIn-Section-->
	<section id="mob_img">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="inner-logo">
						<a href="{{ url('/') }}"><img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/> </a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="signin_bg">
						<img src="{{ URL::asset('public/assets/img/forgotpasword.png'); }}" class="img-responsive"/>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="signin_form">
						<div class="signin_title">
							<p><img src="{{ URL::asset('public/assets/img/back_icon.png'); }}"/><a href="{{ url('/login') }}"><span>Back</span></a></p>
							<h3>Enter Email</h3>
						</div>
						<form id="forgotbutn" method="POST">
						@csrf
						  <div class="form-group">
							<label for="exampleInputEmail1">Email</label>
							<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter your Email Address">
						  </div>
						  <button type="submit" class="btn btn-default btn_sign forgotbutn">Send Password</button>
						  <p class="email-txt">A temporary password will be sent to your email, you can login using the password and change that again inside your dashboard</p>
						</form>
						<div class="alert alert-success" id="success-alert">
                          <button type="button" class="close" data-dismiss="alert">x</button>
                          <strong>Email sent with temporary password! </strong> Please login.
                        </div>
                        <div class="alert alert-error" id="error-alert">
                          <button type="button" class="close" data-dismiss="alert">x</button>
                          <strong>Error! Email not found </strong> Email not register with us. Please signup.
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
