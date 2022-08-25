
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}" crossorigin="anonymous"></script>

<!-- <script src="{{ asset('assets/plugins/global/jquery-3.6.0.js') }}" ></script> -->

<!-- <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script> -->
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('assets/js/pages/widgets.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/cropper/cropper.bundle.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/draggable/draggable.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/dropify/js/dropify.min.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/inview/jquery.inview.min.js') }}"></script>
<!-- <script src="{{ asset('assets/plugins/custom/select/select2.min.js') }}"></script> -->

<script src="{{ asset('assets/plugins/custom/summernote/summernote.min.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/sweetalert2/sweetalert2.all.min.js') }}"></script>

<script src="{{ asset('assets/plugins/global/jquery.form.min.js') }}"></script>

<!-- PICKDATE -->
<script src="{{ asset('assets/plugins/custom/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/pickadate/legacy.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/jquery-datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>

<!-- END PICKDATE -->

<script src="{{ asset('assets/plugins/global/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/chartjs/chart.min.js') }}"></script>


<script>
var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
</script>

@yield('scripts')
@include('lib.js')
@include('lib.firebase')
@include('lib.datatable')
