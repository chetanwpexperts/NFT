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
						<img src="{{ URL::asset('public/assets/img/signin.png'); }}" class="img-responsive"/>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="signin_form">
						<div class="signin_title">
							<h3>Set Password</h3>
						</div>
						<form method="POST" id="setpassword" enctype="multipart/form-data">
                          @csrf
                         @isset($_REQUEST['tokan'])
                            <input type="hidden" name="reset_tokan" class="form-control" id="reset_tokan" value="{{$_REQUEST['tokan']}}" />
                          @endisset				 
                           <div class="form-group">
							<label for="newpassword">Enter Password</label>
							<input type="password" name="password" class="form-control" id="newpassword" placeholder="Enter Password">
						  </div>
						  <div class="form-group">
							<label for="confrimpassword">Re-Enter Password</label>
							<input type="password" name="conf_pass" class="form-control" id="confrimpassword" placeholder="Confirm Password">
						  </div>
						  <button type="submit" class="btn btn-default btn_sign">Save & Proceed</button><p class="password-txt">We will not take more of your time JUST 1 more step left</p>
						</form>
						<div class="alert alert-success" id="success-alert">
                          <button type="button" class="close" data-dismiss="alert">x</button>
                          <strong>Password Saved! </strong> Redirecting...
                        </div>
                        <div class="alert alert-error" id="error-alert">
                          <button type="button" class="close" data-dismiss="alert">x</button>
                          <strong>Password Not Matched! </strong> Password and Confirm password should be same.
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
