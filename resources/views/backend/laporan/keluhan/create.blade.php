@extends('layouts/app')

@section('styles')
@endsection

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_4">
 <div class="card-header">
  <div class="card-title">
    <h3 class="card-label">{{ $title }}
      <span class="text-muted pt-2 font-size-sm d-block">pengelolahan data </span></h3>
    </div>
    <div class="card-toolbar">
   </div>
 </div>
 <div class="card-body">
 <form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="unit_id" value="{{auth()->user()->unit_id}}">
    <div class="row">
      <div class="col-md-6">
          <div class="form-group">
              <label for="nama_cust" class="">{{ __('Nama Pelanggan') }}</label><span class="text-danger">*</span>
              <input id="nama_cust" type="text" class="form-control" name="nama_cust" value="{{ old('nama_cust') }}" required autocomplete="off" autofocus placeholder="Nama Pelanggan" maxlength="20">
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label for="kontak_cust" class="">{{ __('Kontak Pelanggan') }}</label><span class="text-danger">*</span>
              <input id="kontak_cust" type="text" class="form-control" name="kontak_cust" value="{{ old('kontak_cust') }}" required autocomplete="off" autofocus placeholder="Kontak Pelanggan" maxlength="20">
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label for="tanggal_kejadian" class="">{{ __('Tanggal Kejadian') }}</label><span class="text-danger">*</span>
              <input id="tanggal_kejadian" type="text" class="form-control datetimepicker" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" required autocomplete="off" autofocus placeholder="Tanggal Kejadian" maxlength="20">
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label for="lokasi_kejadian" class="">{{ __('Lokasi Kejadian') }}</label><span class="text-danger">*</span>
              <input id="lokasi_kejadian" type="text" class="form-control" name="lokasi_kejadian" value="{{ old('lokasi_kejadian') }}" required autocomplete="off" autofocus placeholder="Lokasi Kejadian" maxlength="20">
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
              <label for="ruas_id" class="">{{ __('Ruas Jalan Tol') }}</label><span class="text-danger">*</span>
              <select class="form-control select2" id="ruas" name="ruas_id">
                {!! App\Models\MasterRuas::options('name','id',[],'( Ruas Jalan Tol )') !!}
              </select>
          </div>
      </div>

      <div class="col-md-6">
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
                {!! App\Models\MasterBk::options('keluhan','id',[],'( Bidang Keluhan )') !!}
              </select>
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
              <label for="golongan_id" class="">{{ __('Golongan Kendaraan') }}</label><span class="text-danger">*</span>
              <select class="form-control select2" name="golongan_id">
                {!! App\Models\MasterGolken::options('golongan','id',[],'( Golongan Kendaraan )') !!}
              </select>
          </div>
      </div>

      <div class="col-md-12">
          <div class="form-group">
              <label for="keterangan_keluhan" class="">{{ __('Keterangan Keluhan') }}</label><span class="text-danger">*</span>
              <textarea name="keterangan_keluhan" class="form-control" placeholder="Keterangan Keluhan" ></textarea>
          </div>
      </div>


    </div>
    <a href="{{ route($route.'.index') }}" class="btn btn-secondary" >
      <i class="flaticon-circle"></i>
      Kembali
    </a>
    <div class="btn btn-light-success save float-right">
      <i class="flaticon-add-circular-button"></i>
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
