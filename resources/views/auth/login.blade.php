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
						<img src="{{ URL::asset('public/assets/img/signin.png'); }}" class="img-responsive" style="width: 66%;position: relative;left: 12rem;" />
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="signin_form">
					    <div class="card-body">
                            @if (Session::get('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                        </div>
						<div class="signin_title">
							<p>
							    <img src="{{ URL::asset('public/assets/img/home_icon.png'); }}"/>
							    <a href="{{ url('/') }}"><span>Home</span></a>
							</p>
							<h3>Sign in <span>or new user?</span><a href="{{ url('/registration') }}">SignUp</a></h3>
						</div>
						<form action="{{ route('login.post') }}" method="POST">
						  @csrf
						  <div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
							@if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
						  </div>
						  <div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
							@if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
						  </div>
						  <div class="form-group">
							<a href="{{route('forgotpassword')}}" class="forgot_link">Forgot Password?</a>
						  </div>
						  <button type="submit" class="btn btn-default btn_sign">Sign in</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection
