@extends('mail.panels.index')

@section('content')
<p>Hello, You are receiving this email because we received a password reset request for your account.</p>
<p>This password reset link will expire in 60 minutes.<p>
	<p>If you did not request a password reset, no further action is required.<p><br>
		<a href="{{ @$record }}" title="">
			{{ @$record }}
		</a>
@endsection
