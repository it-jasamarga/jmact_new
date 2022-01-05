@extends('layouts/fullApp')

@section('content')
{{-- <div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('assets/media/bg/bg-3.jpg');">
					<div class="login-form text-center p-7 position-relative overflow-hidden">

						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-15">
							<a href="#">
								<img src="assets/media/logos/logo-letter-13.png" class="max-h-75px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->

						<!--begin::Login Sign in form-->
						<div class="login-signin">

							<div class="mb-20">
								<h3>Sign In To Admin</h3>
								<div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
							</div>

							<form class="form" id="formData" method="POST" action="{{ route('login') }}">
							@csrf

								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8 @error('username') is-invalid @enderror" type="text" placeholder="Username" name="username" autocomplete="off" />
									@error('username')
										<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group mb-5">
									<input class="form-control h-auto form-control-solid py-4 px-8 @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" />
								@error('password')
									<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
									</span>
								@enderror
								</div>

								<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
									<div class="checkbox-inline">
										<label class="checkbox m-0 text-muted">
										<input type="checkbox" name="remember" />
										<span></span>Remember me</label>
									</div>
									<!-- <a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forget Password ?</a> -->
								</div>

								<button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign In</button>

							</form>
							
						</div>
						<!--end::Login Sign in form-->
						
					</div>
				</div>
			</div>
			<!--end::Login-->
		</div> --}}
		<div id="kt_header" class="header">
			<div class="container-fluid d-flex align-items-stretch justify-content-between" style="background-color: #0b4ba1;">
				<!--begin::Heading-->
				<div class="row justify-content-center">
					<!--begin::Title-->
						<div class="text-white">
						  JM
						</div>
						<div class="text-yellow">
						  Act
						</div>
					<!--end::Title-->
				</div>
				<!--begin::Heading-->
			</div>
		</div>
	

		<!--begin::Body-->
	<body id="kt_body" class="bg-body">
	
	<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('assets/media/bg/bg-3.jpg');">
		<!--begin::Main-->
		{{-- <div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png"> --}}
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					{{-- <a href="#" class="mb-12">
						<img alt="" src="assets/media/logos/logo-4.png" class="h-40px" />
					</a> --}}
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form  class="form w-100" method="POST" action="{{ route('login') }}" novalidate="novalidate" id="formData" action="#">
							@csrf
							<!--begin::Heading-->
							<div class="row justify-content-center mb-10">
								<!--begin::Title-->
									<div class="text-blue">
									  JM
									</div>
									<div class="text-yellow">
									  Act
									</div>
								<!--end::Title-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="form-group mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Username</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg h-auto form-control-solid py-4 px-4 @if($errors->first('username')) is-invalid @endif @if($errors->first('message')) is-invalid @endif" type="text" name="username" autocomplete="off" value="{{ old('username') }}"/>
								@if($errors->first('username'))
									<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('username') }}</strong>
									</span>
								@endif
								@if($errors->first('message'))
									<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('message') }}</strong>
									</span>
								@endif
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="form-group mb-10">
									<!--begin::Label-->
									<label class="form-label fs-6 fw-bolder text-dark">Password</label>
									<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg h-auto form-control-solid py-4 px-4 @if($errors->first('password')) is-invalid @endif @if($errors->first('message')) is-invalid @endif" type="password" name="password" />
								@if($errors->first('password'))
									<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
								@if($errors->first('message'))
									<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('message') }}</strong>
									</span>
								@endif
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							
							<!--begin::Actions-->
							<div class="text-center mb-6">
								<!--begin::Submit button-->
								<button id="kt_login_signin_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Login</span>
								</button>
								<!--end::Submit button-->
							</div>
							<!--end::Actions-->

							<div class="form-group">
									<div class="form-group d-flex flex-wrap justify-content-between align-items-center">
										<div class="checkbox-inline">
											<label class="checkbox m-0 text-muted">
											<input type="checkbox" name="remember" />
											<span></span>Remember me</label>
										</div>
										<a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forgot Password?</a>
									</div>
							</div>
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
			{{-- </div>
			<!--end::Authentication - Sign-in-->
		</div> --}}
		<!--end::Main-->
		
	</div>
</body>
<!--end::Body-->
@endsection

@section('scripts')
@endsection

@section('styles')
<link href="{{asset('assets/css/pages/login/classic/login-4.css')}}" rel="stylesheet" type="text/css" />
<style>
  .text-blue {
    color: #0b4ba1;
	font-weight: bold;
	font-size: 48px;
  }
  .btn-login{
    color: #ffffff;
	background-color: #0b4ba1;
	border-color: #0b4ba1;
	text-transform: none;
	overflow: visible;
  }
  .text-yellow {
    color: #ffcb03;
	font-weight: bold;
	font-size: 48px;
  }
  .text-white {
    color: #ffffff;
	font-weight: bold;
	font-size: 48px;
  }
</style>
@endsection