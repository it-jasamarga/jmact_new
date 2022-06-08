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
            <form action="{{ route($route . '.prosesSla', $record->id) }}" method="POST" id="formData"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_tiket" class="">{{ __('No Tiket') }}</label><span
                                class="text-danger">*</span>
                            <input id="no_tiket" type="text" class="form-control" name="no_tiket"
                                value="{{ $record->no_tiket }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputer_pic" class="">{{ __('Inputer PIC') }}</label><span
                                class="text-danger">*</span>
                            <input id="inputer_pic" type="text" class="form-control" name="inputer_pic"
                                value="{{ $record->creator ? $record->creator->username : '' }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_cust" class="">{{ __('Nama Pelanggan') }}</label><span
                                class="text-danger">*</span>
                            <input id="nama_cust" type="text" class="form-control" name="nama_cust"
                                value="{{ $record->nama_cust }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sosial_media" class="">{{ __('Sosial Media') }}</label>
                            <input id="sosial_media" type="text" class="form-control" name="sosial_media"
                                value="{{ $record->sosial_media }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_telepon" class="">{{ __('No Telepon') }}</label>
                            <input id="no_telepon" type="text" class="form-control" name="no_telepon"
                                value="{{ $record->no_telepon }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_pelaporan"
                                class="">{{ __('Tanggal Pelaporan') }}</label><span
                                class="text-danger">*</span>
                            <input id="tanggal_pelaporan" type="text" class="form-control " name="tanggal_pelaporan"
                                value="{{ $record->tanggal_pelaporan }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lokasi_kejadian" class="">{{ __('Lokasi Kejadian') }}</label><span
                                class="text-danger">*</span>
                            <input id="lokasi_kejadian" type="text" class="form-control" name="lokasi_kejadian"
                                value="{{ $record->lokasi_kejadian }}" readonly>
                        </div>
                    </div>

                    {{-- <div class="col-md-4">
          <div class="form-group">
              <label for="lokasi_kejadian" class="">{{ __('Jenis Keluhan') }}</label><span class="text-danger">*</span>
              <select disabled="" class="form-control select2" name="unit_id">
                {!! App\Models\MasterUnit::options('unit','id',['selected' => $record->unit_id],'( Jenis Keluhan )') !!}
              </select>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label for="lokasi_kejadian" class="">{{ __('Marcom') }}</label><span class="text-danger">*</span>
              <select disabled="" class="form-control select2 option-ajax" data-child="ruas" name="regional_id">
                {!! App\Models\MasterRegional::options('name','id',['selected' => $record->regional_id],'( Marcom )') !!}
              </select>
          </div>
      </div> --}}

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ruas_id" class="">{{ __('Ruas Jalan Tol') }}</label><span
                                class="text-danger">*</span>
                            <select disabled="" class="form-control select2" id="ruas" name="ruas_id">
                                {!! App\Models\MasterRuas::options('name', 'id', ['selected' => $record->ruas_id], '( Ruas Jalan Tol )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sumber_id" class="">{{ __('Sumber') }}</label><span
                                class="text-danger">*</span>
                            <select disabled="" class="form-control select2" name="sumber_id">
                                {!! App\Models\MasterSumber::options('description', 'id', ['selected' => $record->sumber_id], '( Sumber )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bidang_id" class="">{{ __('Bidang Keluhan') }}</label><span
                                class="text-danger">*</span>
                            <select disabled class="form-control select2" name="bidang_id">
                                {!! App\Models\MasterBk::options('keluhan', 'id', ['selected' => $record->bidang_id], '( Bidang Keluhan )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="golongan_id" class="">{{ __('Golongan Kendaraan') }}</label><span
                                class="text-danger">*</span>
                            <select disabled="" class="form-control select2" name="golongan_id">
                                {!! App\Models\MasterGolken::options('golongan', 'id', ['selected' => $record->golongan_id], '( Golongan Kendaraan )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="url_file" class="">{{ __('Lampiran') }}</label>
                            {{-- <input id="url_file" type="text" class="form-control custome-modal" name="url_file"
                                value="{{ $record->url_file }}" readonly
                                data-url="keluhan/show-attachment/{{ $record->id }}" data-modal="#xlarge"
                                style="cursor: pointer"> --}}
                            <a class="custome-modal alert alert-custom alert-default" href="javascript:void(0)"
                                id="url_file" data-url="keluhan/show-attachment/{{ $record->id }}" data-modal="#xlarge"
                                style="cursor: pointer;">
                                {{ $record->url_file }}
                            </a>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="lokasi_kejadian"
                                class="">{{ __('Keterangan Keluhan') }}</label><span
                                class="text-danger">*</span>
                            <textarea name="keterangan_keluhan" class="form-control" placeholder="Keterangan Keluhan"
                                readonly>{{ $record->keterangan_keluhan }}</textarea>
                        </div>
                    </div>


                </div>
                <a href="{{ route($route . '.index') }}" class="btn btn-secondary">
                    <em class="flaticon-circle"></em>
                    Kembali
                </a>
                <div class="btn btn-light-success save float-right">
                    <em class="flaticon-add-circular-button"></em>
                    Mulai Pengerjaan
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
