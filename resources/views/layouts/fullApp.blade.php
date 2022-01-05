<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>JMACT - {{ @$title }}</title>
		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		{{-- <link rel="shortcut icon" href="assets/media/logos/favicon.ico" /> --}}
		<link rel="shortcut icon" href="assets/media/logos/jm-logo.png" />

		@include('panels/styles')
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		
				
		@yield('content')

		@include('panels/scripts')
	</body>

</html>