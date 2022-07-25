<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title> JMACT - {{ @$title }}</title>
		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		{{-- <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" /> --}}
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/jm-logo.png') }}" />
		@include('panels/styles')
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<!--begin::Logo-->
			<a href="index.html">
				<img alt="Logo" src="{{ asset('assets/media/logos/logo-jmact.png') }}" />
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<!--begin::Aside Mobile Toggle-->
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>
				<!--end::Aside Mobile Toggle-->
				<!--begin::Header Menu Mobile Toggle-->
				{{-- <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button> --}}
				<!--end::Header Menu Mobile Toggle-->
				<!--begin::Topbar Mobile Toggle-->
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
				<!--end::Topbar Mobile Toggle-->
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">

				@include('panels.sidebar')
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					@include('panels.header')
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									@if(@$breadcrumbs)
										<h4 class="d-flex align-items-center text-dark font-weight-bold my-1 mr-3">{{ (@$breadcrumbs[0]) ? $breadcrumbs[0]['name'] : '' }}</h4>
										{{-- <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold my-2 p-0">
											@foreach($breadcrumbs as $k => $value)
												@if($k !== 0)
													<li class="breadcrumb-item text-muted">
														<a href="{{ url($value['link']) }}" class="text-muted">{{ $value['name'] }}</a>
													</li>
												@endif
											@endforeach
										</ul> --}}
									@endif
									<!--begin::Actions-->
									{{-- <div class="subheader-separator subheader-separator-ver ml-4 mt-2 mb-2 mr-4 bg-gray-200"></div>

									@section('toolbars')
									<a href="javascript:void(0)" class="btn btn-light-warning font-weight-bolder btn-sm add-modal" data-modal="#mediumModal">Create Data</a>
									@show --}}
									<!--end::Actions-->
								</div>
								<!--end::Info-->
								<!--begin::Toolbar-->
								<div class="d-flex align-items-center mr-2">
									<!--begin::Daterange-->
									{{-- <a href="#" class="btn btn-sm btn-light font-weight-bold mr-2" > --}}
										<span class="text-muted font-size-base font-weight-bold mr-2" id="kt_dashboard_daterangepicker_title">Today</span>
										<span class="text-primary font-size-base font-weight-bolder" id="kt_dashboard_daterangepicker_date">
											{{\Carbon\Carbon::now()->format('M d')}}
										</span>
									{{-- </a> --}}
									<!--end::Daterange-->

								</div>
								<!--end::Toolbar-->
							</div>
						</div>
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								@yield('content')
							</div>
						</div>
					</div>
					@include('panels.footer')
				</div>

			</div>
		</div>

		@include('panels.partials.notification')
		@include('panels.partials.scroll-top')
		@include('panels.partials.user')
		@include('panels.partials.modal')
		@include('panels/scripts')

<script>
	window.bell = new Audio("{{ url('bell-001.ogg') }}");
</script>

	</body>

</html>
