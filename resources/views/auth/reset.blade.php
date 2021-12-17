@extends('layouts/fullApp')

@section('styles')
<link href="{{asset('assets/css/pages/login/classic/login-1.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="d-flex flex-column flex-root">
  <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
    <div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url('{{ asset('assets/media/bg/bg-4.jpg') }}');">
      <div class="d-flex flex-row-fluid flex-column justify-content-between">
        <a href="#" class="flex-column-auto mt-5 pb-lg-0 pb-10">
          <img src="{{ asset('assets/media/logos/logo-letter-1.png') }}" class="max-h-70px" alt="" />
        </a>
        <div class="flex-column-fluid d-flex flex-column justify-content-center">
          <h3 class="font-size-h1 mb-5 text-white">Welcome to Panel!</h3>
          <p class="font-weight-lighter text-white opacity-80">The ultimate panel admin web apps.</p>
        </div>
        <div class="d-none flex-column-auto d-lg-flex justify-content-between mt-10">
          <div class="opacity-70 font-weight-bold text-white">© 2021 ResFood</div>
        </div>
      </div>
    </div>
    <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
      <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
        <div class="login-form login-signin">
          <div class="text-center mb-10 mb-lg-20">
            <h3 class="font-size-h1">Reset Password</h3>
            <p class="text-muted font-weight-bold">Enter your new password to reset your password</p>
          </div>
          <!--begin::Form-->
          @if(session('error'))
          <div class="card card-custom gutter-b bg-diagonal bg-diagonal-info bg-diagonal-r-danger rounded h-150px ">
           <div class="card-body">
            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
             <div class="d-flex flex-column mr-5">
              <a href="#" class="h4 text-dark text-hover-primary mb-5">
              Message
              </a>
              <p class="text-dark">
                {{ (session('error')) ? session('error') : 'Sorry You Have Some Trouble' }}
              </p>
             </div>
            </div>
           </div>
          </div>
          @endif

          <form method="POST" action="{{ url('reset-password') }}" class="form" id="formData" novalidate="novalidate" id="kt_login_forgot_form">
            @csrf
            <input type="hidden" name="email" value="{{ request()->email }}">
            <input type="hidden" name="token" value="{{ request()->token }}">
            <div class="form-group">
              <input class="form-control form-control-solid h-auto py-5 px-6 @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" autocomplete="off" value="{{ old('password') }}"/>
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <input class="form-control form-control-solid h-auto py-5 px-6 @error('password') is-invalid @enderror" type="password" placeholder="Password Confirmation" name="password_confirmation" autocomplete="off" value="{{ old('password_confirmation') }}"/>
              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group d-flex flex-wrap flex-center">
              <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
              <a href="{{ route('login') }}" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Login</a>
            </div>
          </form>
          <!--end::Form-->
        </div>
      </div>
      <div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
        <div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">© 2021 ResFood</div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/pages/custom/login/login-general.js') }}"></script>
@endsection