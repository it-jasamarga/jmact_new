@extends('layouts/app')

@section('styles')
@endsection

@section('toolbars')
    {{-- <a href="" class="btn btn-light-warning font-weight-bolder btn-sm" data-modal="#mediumModal">Create Data</a> --}}
@endsection

@section('content')

    <div class="flex-row-fluid ml-lg-8 d-block" id="kt_inbox_list">
        <!--begin::Card-->
        <div class="card card-custom card-stretch">
            <!--begin::Header-->
            <div class="card-header row row-marginless align-items-center flex-wrap py-5 h-auto">
                <!--begin::Toolbar-->
                <div class="col-12 col-sm-6 col-xxl-4 order-2 order-xxl-1 d-flex flex-wrap align-items-center">
                    <div class="d-flex align-items-center mr-1 my-2">
                        <label data-inbox="group-select" class="checkbox checkbox-inline checkbox-primary mr-3">
                            <input type="checkbox">
                            <span class="symbol-label"></span>
                        </label>

                    </div>
                    <div class="d-flex align-items-center mr-1 my-2">
                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title=""
                            data-original-title="Archive">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z"
                                            fill="#000000" opacity="0.3"></path>
                                        <path
                                            d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </span>
                        <span class="btn btn-default btn-icon btn-sm mr-2 d-none" data-toggle="tooltip" title=""
                            data-original-title="Spam">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Warning-1-circle.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10">
                                        </circle>
                                        <rect fill="#000000" x="11" y="7" width="2" height="8"
                                            rx="1"></rect>
                                        <rect fill="#000000" x="11" y="16" width="2" height="2"
                                            rx="1"></rect>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </span>
                        <span class="btn btn-default btn-icon btn-sm mr-2" data-toggle="tooltip" title=""
                            data-original-title="Delete">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                            fill="#000000" fill-rule="nonzero"></path>
                                        <path
                                            d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                            fill="#000000" opacity="0.3"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </span>

                    </div>
                </div>

                <!--begin::Pagination-->
                <div
                    class="col-12 col-sm-6 col-xxl-4 order-2 order-xxl-3 d-flex align-items-center justify-content-sm-end text-right my-2">
                    {{-- @include('backend.notification.partials.pagination') --}}
                    {!! $record->links('backend.partial.pagination') !!}
                </div>
                <!--end::Pagination-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body table-responsive px-0">
                <!--begin::Items-->
                <div class="list list-hover min-w-500px" data-inbox="list">

                    @if ($record->count() > 0)
                        @foreach ($record as $k => $value)
                            @php
                                $style = '';
                                $title = '';

                                if ($value->status == 'Unread') {
                                    $style = 'background: #e0e8ff';
                                }

                                if (strpos($value->title, 'Keluhan ') !== false) {
                                    $title = str_replace('Keluhan ', '', $value->title);
                                } elseif (strpos($value->title, 'Klaim ') !== false) {
                                    $title = str_replace('Klaim ', '', $value->title);
                                } else {
                                    $title = $value->title;
                                }

                            @endphp
                            <div class="d-flex align-items-start list-item card-spacer-x py-3 addClick"
                                data-id="{{ $value->id }}"
                                data-href="{{ $value->target_type == 'KeluhanPelanggan' ? url('keluhan' . '/' . $value->id) : url('claim' . '/' . $value->id) }}"
                                data-inbox="message">
                                <!--begin::Toolbar-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Actions-->
                                    <div class="d-flex align-items-center mt-2 mr-3" data-inbox="actions">
                                        <label class="checkbox checkbox-inline checkbox-primary flex-shrink-0 mr-3">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                        {{-- <a href="#" class="btn btn-icon btn-xs btn-hover-text-warning active" data-toggle="tooltip" data-placement="right" title="" data-original-title="Star">
                                        <i class="flaticon-star text-muted"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon btn-xs text-hover-warning" data-toggle="tooltip" data-placement="right" title="" data-original-title="Mark as important">
                                        <i class="flaticon-add-label-button text-muted"></i>
                                    </a> --}}
                                    </div>
                                    <!--end::Actions-->
                                    <!--begin::Author-->
                                    <div class="d-flex align-items-center flex-wrap w-xxl-120px mt-2 mr-3"
                                        data-toggle="view">
                                        <a href="javascript:void(0)"
                                            class="{{ $value->status == 'Unread' ? 'font-weight-bolder' : 'text-muted' }} text-dark-75 text-hover-primary">{{ $value->target_type == 'KeluhanPelanggan' ? 'Keluhan' : 'Klaim' }}</a>
                                    </div>
                                    <!--end::Author-->
                                </div>
                                <!--end::Toolbar-->
                                <!--begin::Info-->
                                <div class="flex-grow-1 mt-2 mr-2" data-toggle="view">
                                    <div>
                                        <span
                                            class="{{ $value->status == 'Unread' ? 'font-weight-bolder' : 'text-muted' }} font-size-lg mr-2">{{ $title }}
                                            -</span>
                                        <span class="text-muted">{{ $value->message }}</span>
                                    </div>
                                    {{-- <div class="mt-2">
                                    <span class="label label-light-primary font-weight-bold label-inline mr-1">inbox</span>
                                    <span class="label label-light-danger font-weight-bold label-inline">task</span>
                                </div> --}}
                                </div>
                                <!--end::Info-->
                                <!--begin::Datetime-->
                                <div class="mt-2 mr-3 {{ $value->status == 'Unread' ? 'font-weight-bolder' : 'text-muted' }} w-80px text-right"
                                    data-toggle="view">8:30 PM</div>
                                <!--end::Datetime-->
                            </div>
                        @endforeach
                    @endif

                </div>
                <!--end::Items-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.addClick', function() {

            var id = $(this).data('id');
            var url = $(this).data('href');

            console.log('url', url);

            $.ajax({
                type: "POST",
                url: "{{ url('notification-status') }}",
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function() {
                    console.log('success')
                    window.location.href = url;
                },
                error: function() {
                    console.log('error')
                },
            })
        });
    </script>
@endsection
