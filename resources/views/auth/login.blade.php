@extends('layouts/fullApp')

@section('styles')
<link href="{{asset('assets/css/pages/login/classic/login-4.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="d-flex flex-column flex-root">
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
		</div>
@endsection

@section('scripts')
@endsection