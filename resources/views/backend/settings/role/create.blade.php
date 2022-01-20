@extends('layouts/app')

@section('styles')
@endsection

@section('content')
    <div class="card card-custom" data-card="true" id="kt_card_4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">{{ $title }}
                    <span class="text-muted pt-2 font-size-sm d-block">pengelolahan data </span>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
                    <i class="ki ki-arrow-down icon-nm"></i>
                </a>
            </div>
        </div>
        <form action="{{ route($route . '.store') }}" method="POST" id="formData" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Role') }}</label>
                            <input id="name" type="text" class="form-control" name="name" required autocomplete="off"
                                autofocus placeholder="Role" maxlength="50">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role" class="">{{ __('Status') }}</label>
                            <select class="form-control select2" name="active">
                                <option value="">Pilih Status</option>
                                <option value="1">Active</option>
                                <option value="0">Non-Active</option>
                            </select>
                        </div>
                    </div>

                </div>

                {{-- <input type="hidden" name="id" value="{{ $record->id }}"> --}}
                {{-- <input type="hidden" name="name" value="{{ $record->name }}"> --}}
                <div class="panel panel-default">
                    @include('backend.settings.role.partial.create-permission')
                </div>
                <div class="panel-footer pt-4">
                    <a href="{{ route($route . '.index') }}" class="btn btn-secondary">
                        <i class="flaticon-circle"></i>
                        Kembali
                    </a>
                    <div class="btn btn-light-success save float-right">
                        <i class="flaticon-add-circular-button"></i>
                        Simpan Data
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).on('click', '.verticall.all', function(e) {
            e.preventDefault();
            var container = $(this).closest('thead');
            var action = $(this).data('action');
            var selector = $('.' + action + '.check');
            var checked = true;
            container.next('tbody').find(selector).each(function(e) {
                checked = !$(this).prop('checked') ? false : checked;
            });

            container.next('tbody').find(selector).prop('checked', !checked);
        });

        $(document).on('click', '.verticall-custom.all', function(e) {
            e.preventDefault();
            var classs = $(this).data('class');
            var checked = true;
            $('.' + classs).each(function(e) {
                checked = !$(this).prop('checked') ? false : checked;
            });

            $('.' + classs).prop('checked', !checked);
        });

        $(document).on('click', '.horizontal.all', function(e) {
            e.preventDefault();
            var container = $(this).closest('tr');
            var selector = $('.check');
            var checked = true;

            container.find(selector).each(function(e) {
                checked = !$(this).prop('checked') ? false : checked;
                // $(this).prop('checked', !$(this).prop('checked'));
            });

            container.find(selector).prop('checked', !checked);
        });
    </script>
@endsection
