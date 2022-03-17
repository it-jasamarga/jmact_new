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
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route($route . '.store') }}" method="POST" id="formData" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="unit_id" value="{{ (\Auth::check()) ? auth()->user()->unit_id : null}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_cust" class="">{{ __('Nama Pelanggan') }}</label><span
                                class="text-danger">*</span>
                            <input id="nama_cust" type="text" class="form-control" name="nama_cust"
                                value="{{ old('nama_cust') }}" required autocomplete="off" autofocus
                                placeholder="Nama Pelanggan" maxlength="100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sosial_media" class="">{{ __('Sosial Media') }}</label>
                            <input id="sosial_media" type="text" class="form-control" name="sosial_media"
                                value="{{ old('sosial_media') }}" required autocomplete="off" autofocus
                                placeholder="Kontak Pelanggan" maxlength="100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_telepon" class="">{{ __('No Telepon') }}</label><span
                                class="text-danger">*</span>
                            <input id="no_telepon" type="text" class="form-control" name="no_telepon"
                                value="{{ old('no_telepon') }}" required autocomplete="off" autofocus
                                placeholder="No Telepon" maxlength="12"
                                oninput="this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..*)\.,/g, '$1')">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_pelaporan" class="">{{ __('Tanggal Pelaporan') }}</label><span
                                class="text-danger">*</span>
                            <input id="tanggal_pelaporan" type="text" class="form-control datetimepicker"
                                name="tanggal_pelaporan" value="{{ old('tanggal_pelaporan') }}" required autocomplete="off"
                                autofocus placeholder="Tanggal Pelaporan" maxlength="20">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lokasi_kejadian" class="">{{ __('Lokasi Kejadian') }}</label><span
                                class="text-danger">*</span>
                            <input id="lokasi_kejadian" type="text" class="form-control" name="lokasi_kejadian"
                                value="{{ old('lokasi_kejadian') }}" required autocomplete="off" autofocus
                                placeholder="Lokasi Kejadian" maxlength="100">
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
          <div class="form-group">
              <label for="unit_id" class="">{{ __('Jenis Keluhan') }}</label><span class="text-danger">*</span>
              <select class="form-control select2" name="unit_id">
                {!! App\Models\MasterUnit::options('unit','id',[],'( Jenis Keluhan )') !!}
              </select>
          </div>
      </div> --}}

                    {{-- <div class="col-md-6">
          <div class="form-group">
              <label for="regional_id" class="">{{ __('Marcom') }}</label><span class="text-danger">*</span>
              <select class="form-control select2 option-ajax" data-child="ruas" name="regional_id">
                {!! App\Models\MasterRegional::options('name','id',[],'( Marcom )') !!}
              </select>
          </div>
      </div> --}}

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ruas_id" class="">{{ __('Ruas Jalan Tol') }}</label><span
                                class="text-danger">*</span>
                            <select class="form-control select2" id="ruas" name="ruas_id">
                                {!! App\Models\MasterRuas::options('name', 'id', [], '( Ruas Jalan Tol )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sumber_id" class="">{{ __('Sumber') }}</label><span
                                class="text-danger">*</span>
                            <select class="form-control select2" name="sumber_id">
                                {!! App\Models\MasterSumber::options(
    'description',
    'id',
    [
        'filters' => [
            function ($q) {
                $q->where('keluhan', 1);
            },
        ],
    ],
    '( Sumber )',
) !!}
                            </select>
                        </div>
                    </div>

                    @php
                    $masterBk = App\Models\MasterBk::get()->groupBy('bidang');
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bidang_id" class="">{{ __('Bidang Keluhan') }}</label><span
                                class="text-danger">*</span>
                            <select class="form-control select2" name="bidang_id">
                                <option value="" selected>Pilih Data</option>
                                @foreach ($masterBk as $k => $value)
                                    <optgroup label="{{$k}}">
                                        @if($value->count() > 0)
                                            @foreach ($value as $item)
                                                <option value="{{$item->id}}" >{{$item->keluhan}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="golongan_id" class="">{{ __('Golongan Kendaraan') }}</label><span
                                class="text-danger">*</span>
                            <select class="form-control select2" name="golongan_id">
                                {!! App\Models\MasterGolken::options('golongan', 'id', [], '( Golongan Kendaraan )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keluhan" class="">{{ __('Lampiran') }}</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="keluhan" name="url_file"
                                    data-max-file-size="2M" data-allowed-file-extensions="jpg png gif jpeg"
                                    data-default-file="" data-show-remove="true" required />
                                <label class="custom-file-label" for="keluhan">Pilih file</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="keterangan_keluhan"
                                class="">{{ __('Keterangan Keluhan') }}</label><span
                                class="text-danger">*</span>
                            <textarea name="keterangan_keluhan" class="form-control"
                                placeholder="Keterangan Keluhan"></textarea>
                        </div>
                    </div>

                </div>
                <a href="{{ route($route . '.index') }}" class="btn btn-secondary">
                    <em class="flaticon-circle"></em>
                    Kembali
                </a>
                <div class="btn btn-light-success save float-right">
                    <em class="flaticon-add-circular-button"></em>
                    Simpan Data
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Page js files --}}
    <script>

    </script>
@endsection
