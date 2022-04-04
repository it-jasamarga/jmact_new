@extends('layouts/app')

@section('styles')
@endsection

@section('content')
    <div class="card card-custom" data-card="true" id="kt_card_4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">{{ $title }}
                    {{-- <span class="text-muted pt-2 font-size-sm d-block">pengelolahan data </span> --}}
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
                    <em class="ki ki-arrow-down icon-nm"></em>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route($route . '.update', $record->id) }}" method="POST" id="formData"
                enctype="multipart/form-data">
                @method('PATCH')
                @csrf

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="">{{ __('Role') }}</label><span class="text-danger">*</span>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $record->name }}"
                                required readonly autocomplete="name" autofocus placeholder="Role" maxlength="50">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type_id" class="">{{ __('Type') }}</label><span class="text-danger">*</span>
                            <select class="form-control select2" name="type_id">
                                <option value="">Pilih Type</option>
                                {!! App\Models\MasterType::options('type', 'id', ['selected' => $record->type_id], '( Pilih Type )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="active" class="">{{ __('Status') }}</label><span class="text-danger">*</span>
                            <select class="form-control select2" name="active" required>
                                <option value="">Pilih Status</option>
                                <option value="1" {{ $record->active == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $record->active == 0 ? 'selected' : '' }}>Non-Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ro_id" class="">{{ __('RO') }}</label>
                            <select class="form-control select2" id="ro" name="ro_id" required>
                                {!! App\Models\MasterRo::options(
                                    function ($q) {
                                        $regional = $q->regional ? $q->regional->name : '-';
                                        return $q->name . ' - ' . $regional;
                                    },
                                    'id',
                                    ['selected' => $record->ro_id],
                                    '( Pilih RO )',
                                ) !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regional_id" class="">{{ __('Regional') }}</label>
                            <select class="form-control select2" id="regional" name="regional_id">
                                {!! App\Models\MasterRegional::options('name', 'id', ['selected' => $record->regional_id], '( Pilih Regional )') !!}
                            </select>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="id" value="{{ $record->id }}">
                {{-- <input type="hidden" name="name" value="{{ $record->name }}"> --}}
                <div class="panel panel-default">
                    @include(
                        'backend.settings.role.partial.edit-permission'
                    )
                </div>
                <div class="panel-footer pt-4">
                    {{-- <a href="{{ url()->previous() }}" class="btn btn-sm btn-default btn-addon">
        <i class="flaticon-reply"></i> Back
      </a>
      <button type="button" class="btn btn-sm btn-light-success font-weight-bold btn-addon pull-right save button">
        <i class="flaticon-cogwheel"></i> Save
      </button> --}}

                    <a href="{{ route($route . '.index') }}" class="btn btn-secondary">
                        <i class="flaticon-circle"></i>
                        Kembali
                    </a>
                    <div class="btn btn-light-success save float-right">
                        <i class="flaticon-add-circular-button"></i>
                        Simpan Data
                    </div>
                </div>

            </form>
        </div>
    </div>
    <br>
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

        $(document).on('change', "[name='type_id']", function(e) {
            var type = $("[name='type_id'] option:selected").text();
            if (type == "Regional") {
                $('#ro').attr('disabled', true);
                $('#regional').attr('disabled', false);
            } else if (type == "Representative Office") {
                $('#ro').attr('disabled', false);
                $('#regional').attr('disabled', true);
            } else {
                $('#ro').attr('disabled', false);
                $('#regional').attr('disabled', false);
            }
        });
    </script>
@endsection
