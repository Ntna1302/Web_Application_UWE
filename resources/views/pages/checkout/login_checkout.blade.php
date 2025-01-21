@extends('layout')
@section('content')

<section id="form">
	<!--form-->
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-sm-offset-1">
				<div class="login-form">
					<!--login form-->
					<h2>Login to your account</h2>
					@php
					$message = Session::get('message');
					$error = Session::get('error');

					if($message){
					echo '<div class="alert alert-success">'.$message.'</div>';
					Session::put('message',null);}
					elseif($error){
					echo '<div class="alert alert-danger">'.$error.'</div>';
					Session::put('error',null);
					}
					@endphp

					<form action="{{URL::to('/login-customer')}}" method="POST">
						{{csrf_field()}}

						<input type="text" name="email_account" placeholder="Email" />
						<input type="password" name="password_account" placeholder="Password" />

						<span>
							<a href="{{url('/quen-mat-khau')}}">Forgot password?</a>
						</span>
						<button type="submit" class="btn btn-default">Login</button>
					</form>

					<style type="text/css">
						ul.list-login {
							margin: 10px;
							padding: 0;
						}

						ul.list-login li {
							display: inline;
							margin: 5px;
						}
					</style>
					<ul class="list-login">
						<li>
							<a href="{{url('login-customer-google')}}">
								<img src="{{asset('public/frontend/images/gg.png')}}" alt="Login with Google account" width="10%">
							</a>
						</li>
					</ul>
				</div>
				<!--/login form-->
			</div>
			<div class="col-sm-2">
				<h2 class="or">Or</h2>
			</div>
			<div class="col-sm-3">

				<div class="signup-form">
					<!--sign up form-->
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					<h2>Register</h2>
					<form action="{{URL::to('/add-customer')}}" method="POST">
						{{ csrf_field() }}

						<input type="text" name="customer_name" placeholder="Full Name" />
						<input type="text" name="customer_email" placeholder="Email Address" />
						<input type="password" name="customer_password" placeholder="Password" />
						<input type="text" name="customer_phone" placeholder="Phone" />
						<button type="submit" class="btn btn-default">Register</button>
					</form>
				</div>
				<!--/sign up form-->
			</div>

		</div>
	</div>
</section>
<!--/form-->

@endsection
