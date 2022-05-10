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
						<img src="{{ URL::asset('public/assets/img/signup_bg.png'); }}" class="img-responsive" style="width: 66%;position: relative;left: 12rem;" />
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="signin_form">
						<div class="signin_title">
							<p><img src="{{ URL::asset('public/assets/img/home_icon.png'); }}"/><a href="{{ url('/') }}"><span>Home</span></a></p>
							<h3>Sign in <span>or Exisiting user?</span><a href="{{ route('login') }}">Sign In</a></h3>
						</div>
						<form method="POST" id="registration" enctype="multipart/form-data">
                          @csrf
						  <div class="form-group">
							<div class="form-group">
								<label class="display_text">Choose Display Photo</label>
								<input type="file" name="dp" id="dp" class="form-control" placeholder="image" style="display:none" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
								<button class="imp_btn" id="OpenImgUpload">
								    <img id="blah" src="{{ URL::asset('public/assets/img/user_upload.png'); }}" height="112px" width="112px" />
								    <span id="spnFilePath"></span>
								</button>
							</div>
							<label for="exampleInputEmail1">Display Name</label>
							<input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter Display Name">
							@if ($errors->has('name'))
                                  <span class="text-danger">{{ $errors->first('name') }}</span>
                              @endif
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Email Address</label>
							<input type="email" name="email" class="form-control" id="emailId" placeholder="Enter Email Address">
							@if ($errors->has('email'))
                                  <span class="text-danger">{{ $errors->first('email') }}</span>
                              @endif
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Phone Number</label>
							<input type="phone" name="phone" class="form-control" maxlength="10" id="phoneId" placeholder="Enter your phone number" onkeypress="return checkOnlyDigits(event)" />
							@if ($errors->has('phone'))
                                  <span class="text-danger">{{ $errors->first('phone') }}</span>
                              @endif
						  </div>
						  <button type="submit" class="btn btn-default btn_sign btnsignup">Send OTP</button><p class="otp-txt">Email and phone number will be verified using OTP</p>
						</form>
						<div class="alert alert-success" id="success-alert">
                          <button type="button" class="close" data-dismiss="alert">x</button>
                          <strong>Data Submited! </strong> please verify your otp sent on your number and email.
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
