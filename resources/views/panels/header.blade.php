<!--begin::Header-->
<div id="kt_header" class="header header-fixed">
	<!--begin::Container-->
	<div class="container-fluid d-flex align-items-stretch justify-content-end" style="background-color: #0b4ba1;">
		<!--begin::Header Menu Wrapper-->
		{{-- <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
			<!--begin::Header Menu-->
			<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
				<!--begin::Header Nav-->
				<ul class="menu-nav">
					<li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active" data-menu-toggle="click" aria-haspopup="true">
						<a href="javascript:;" class="menu-link menu-toggle">
							<span class="menu-text">
								<h6 class="text-primary font-weight-bolder">Adukan Cermati Tuntaskan</h6>
							</span>
						</a>
					</li>
				</ul>
				<!--end::Header Nav-->
			</div>
			<!--end::Header Menu-->
		</div> --}}
		<!--end::Header Menu Wrapper-->
		<!--begin::Topbar-->
		<div class="topbar">
			
			<!--begin::Notifications-->
			<div class="dropdown">
				<!--begin::Toggle-->
				<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
					<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-check pulse-primary">
						<span class="svg-check svg-icon svg-icon-primary svg-icon-2x">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<path d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z" fill="#000000"/>
									<rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2"/>
								</g>
							</svg>
							<!--end::Svg Icon-->
						</span>
						<span class="pulse-ring"></span>
					</div>
				</div>
				<!--end::Toggle-->
				<!--begin::Dropdown-->
				<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
					<form>
						<!--begin::Header-->
						<div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: {{ asset('assets/media/misc/bg-1.jpg') }} ">
							<!--begin::Title-->
							<h4 class="d-flex flex-center rounded-top">
								<span class="text-black">User Notifications</span>
								<span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2 totalNotif">0</span>
							</h4>
							<!--end::Title-->
							<!--begin::Tabs-->
							<ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-black nav-tabs-line-active-border-success mt-3 px-8 " role="tablist">
								<li class="nav-item">
									<a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications">Alerts</a>
								</li>
							</ul>
							<!--end::Tabs-->
						</div>
						<!--end::Header-->
						<!--begin::Content-->
						<div class="tab-content">
							<!--begin::Tabpane-->
							<div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
								<!--begin::Scroll-->
								<div class="scroll pr-7 mr-n7 addHeader" data-scroll="true" data-height="300" data-mobile-height="200">
									<!--begin::Item-->
									
									<!--end::Item-->
								</div>
								<!--end::Scroll-->
								<!--begin::Action-->
								<!-- <div class="d-flex flex-center pt-7">
									<a href="#" class="btn btn-light-primary font-weight-bold text-center">See All</a>
								</div> -->
								<!--end::Action-->
							</div>
						</div>
						<!--end::Content-->
					</form>
				</div>
				<!--end::Dropdown-->
			</div>
			<!--end::Notifications-->
			
			<!--begin::User-->
			<div class="topbar-item">
				<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
					<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
					<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">Sean</span>
					<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
						<span class="symbol-label font-size-h5 font-weight-bold">S</span>
					</span>
				</div>
			</div>
			<!--end::User-->
		</div>
		<!--end::Topbar-->
	</div>
	<!--end::Container-->
</div>
<!--end::Header-->