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
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route($route . '.store') }}" method="POST" id="formData" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="unit_id" value="{{ auth()->user()->unit_id }}">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_pelanggan" class="">{{ __('Nama Pelanggan') }}</label><span
                                class="text-danger">*</span>
                            <input id="nama_pelanggan" type="text" class="form-control" name="nama_pelanggan"
                                value="{{ old('nama_pelanggan') }}" required autocomplete="off" autofocus
                                placeholder="Nama Pelanggan" maxlength="100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik_pelanggan" class="">{{ __('NIK Pelanggan') }}</label><span
                                class="text-danger">*</span>
                            <input id="nik_pelanggan" type="text" class="form-control" name="nik_pelanggan"
                                value="{{ old('nik_pelanggan') }}" required autocomplete="off" autofocus
                                placeholder="NIK Pelanggan" maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..*)\.,/g, '$1')">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_telepon" class="">{{ __('No Telepon') }}</label>
                            <input id="no_telepon" type="text" class="form-control" name="no_telepon"
                                value="{{ old('no_telepon') }}" autocomplete="off" autofocus placeholder="No Telepon"
                                maxlength="13"
                                oninput="this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..*)\.,/g, '$1')">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sosial_media" class="">{{ __('Sosial Media') }}</label>
                            <input id="sosial_media" type="text" class="form-control" name="sosial_media"
                                value="{{ old('sosial_media') }}" autocomplete="off" autofocus placeholder="Sosial Media"
                                maxlength="100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alamat_pelanggan" class="">{{ __('Alamat Pelanggan') }}</label><span
                                class="text-danger">*</span>
                            <textarea name="alamat_pelanggan" class="form-control" rows="1" placeholder="Alamat Pelanggan"></textarea>
                        </div>
                    </div>

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
                $q->where('claim', 1);
            },
        ],
    ],
    '( Sumber )',
) !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_pelaporan" class="">{{ __('Tanggal Pelaporan') }}</label><span
                                class="text-danger">*</span>
                            <input id="tanggal_pelaporan" type="text" class="form-control datetimepicker"
                                name="tanggal_pelaporan" value="{{ old('tanggal_pelaporan') }}" required
                                autocomplete="off" autofocus placeholder="Tanggal Pelaporan" maxlength="20">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lokasi_kejadian" class="">{{ __('Lokasi Kejadian') }}</label><span
                                class="text-danger">*</span>
                            <input id="lokasi_kejadian" type="text" class="form-control" name="lokasi_kejadian"
                                value="{{ old('lokasi_kejadian') }}" required autocomplete="off" autofocus
                                placeholder="Lokasi Kejadian" maxlength="20">
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

                    {{-- <div class="col-md-6">
          <div class="form-group">
              <label for="sumber_id" class="">{{ __('Sumber') }}</label><span class="text-danger">*</span>
              <select class="form-control select2" name="sumber_id">
                {!! App\Models\MasterSumber::options('description','id',[],'( Sumber )') !!}
              </select>
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label for="bidang_id" class="">{{ __('Bidang Keluhan') }}</label><span class="text-danger">*</span>
              <select class="form-control select2" name="bidang_id">
                {!! App\Models\MasterBk::options('bidang','id',[],'( Bidang Keluhan )') !!}
              </select>
          </div>
      </div> --}}

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
                            <label for="jenis_kendaraan" class="">{{ __('Jenis Kendaraan') }}</label><span
                                class="text-danger">*</span>
                            <input id="jenis_kendaraan" type="text" class="form-control" name="jenis_kendaraan"
                                value="{{ old('jenis_kendaraan') }}" required autocomplete="off" autofocus
                                placeholder="Jenis Kendaraan" maxlength="20">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_polisi" class="">{{ __('No Polisi') }}</label><span
                                class="text-danger">*</span>
                            <input id="no_polisi" type="text" class="form-control" name="no_polisi"
                                value="{{ old('no_polisi') }}" required autocomplete="off" autofocus
                                placeholder="No Polisi" maxlength="11">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_claim_id" class="">{{ __('Klaim') }}</label><span
                                class="text-danger">*</span>
                            <select class="form-control select2" id="jenis_claim" name="jenis_claim_id">
                                {!! App\Models\MasterJenisClaim::options('jenis_claim', 'id', [], '( Ruas Jalan Tol )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nominal_customer"
                                class="">{{ __('Besaran klaim yang diajukan') }}</label><span
                                class="text-danger">*</span>
                            <input id="nominal_customer" type="text" class="form-control" name="nominal_customer"
                                value="{{ old('nominal_customer') }}" required autocomplete="off" autofocus
                                placeholder="Besaran claim yang diajukan" maxlength="20"
                                oninput="this.value = convertToRupiah(this.value.replace(/[^0-9.,]/g, '').replace(/(\..*)\.,/g, '$1'))">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="claim" class="">{{ __('Lampiran') }}</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="claim" name="url_file"
                                    data-max-file-size="2M" data-allowed-file-extensions="jpg png gif jpeg"
                                    data-default-file="" data-show-remove="true" required />
                                <label class="custom-file-label" for="claim">Pilih file</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keterangan_claim" class="">{{ __('Keterangan Klaim') }}</label><span
                                class="text-danger">*</span>
                            <textarea name="keterangan_claim" class="form-control" rows="1" placeholder="Keterangan Klaim"></textarea>
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
        // $(document).on("change", "#nominal_customer", function(){
        //     var input = $(this).val()
        //     console.log(input)
        //     $("[name='nominal_customer']").val(convertToRupiah(input))
        // })
    </script>
@endsection
