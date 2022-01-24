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
 <form >
    <div class="row">
        <div class="col-md-5">
            <div class="alert alert-custom alert-default" role="alert" style="max-height: 350px;overflow-y:visible">
                <div class="timeline timeline-2">
                    <div class="timeline-bar"></div>
                    @if($record->history->count() > 0)
                        @foreach($record->history as $k => $value)
                            <div class="timeline-item">
                                <div class="timeline-badge bg-success"></div>
                                <div class="timeline-content d-flex align-items-center justify-content-between">
                                    <span class="mr-3">
                                        <a href="#">Status Tiket {{ $record->no_tiket }} {{ $value->status->status }} </a> 
                                    </span>
                                    <span class="text-muted text-right">{{ $value->created_at }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-7">

        </div>
    </div>
        <div class="separator separator-solid mt-2 mb-4"></div>
    <div class="row">
        <div class="col-md-6">
          <div class="form-group">
              <label for="no_tiket" class="">{{ __('No Tiket') }}</label><span class="text-danger">*</span>
              <input id="no_tiket" type="text" disabled="" class="form-control" name="no_tiket" value="{{ $record->no_tiket }}" required autocomplete="no_tiket" autofocus placeholder="No Tiket" maxlength="20">
          </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="nik_pelanggan" class="">{{ __('NIK Pelanggan') }}</label><span class="text-danger">*</span>
                <input id="nik_pelanggan" disabled="" type="text" class="form-control" name="nik_pelanggan" value="{{ $record->nik_pelanggan }}" required autocomplete="nik_pelanggan" autofocus placeholder="NIK Pelanggan" maxlength="20">
            </div>
        </div>
  
        <div class="col-md-6">
            <div class="form-group">
                <label for="kontak_pelanggan" class="">{{ __('Kontak Pelanggan') }}</label><span class="text-danger">*</span>
                <input id="kontak_pelanggan" disabled="" type="text" class="form-control" name="kontak_pelanggan" value="{{ $record->kontak_pelanggan }}" required autocomplete="kontak_pelanggan" autofocus placeholder="Kontak Pelanggan" maxlength="20">
            </div>
        </div>
  
        <div class="col-md-6">
          <div class="form-group">
              <label for="alamat_pelanggan" class="">{{ __('Alamat Pelanggan') }}</label><span class="text-danger">*</span>
              <textarea name="alamat_pelanggan" disabled="" class="form-control" placeholder="Alamat Pelanggan" >{{ $record->alamat_pelanggan }}</textarea>
          </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="lokasi_kejadian" class="">{{ __('Ruas Jalan Tol') }}</label><span class="text-danger">*</span>
                <select disabled="" class="form-control select2" id="ruas" name="ruas_id">
                    {!! App\Models\MasterRuas::options('name','id',['selected' => $record->ruas_id],'( Ruas Jalan Tol )') !!}
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="tanggal_kejadian" class="">{{ __('Tanggal Kejadian') }}</label><span class="text-danger">*</span>
                <input id="tanggal_kejadian" type="text" disabled="" class="form-control " name="tanggal_kejadian" value="{{ $record->tanggal_kejadian }}" required autocomplete="tanggal_kejadian" autofocus placeholder="Tanggal Kejadian" maxlength="20">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="lokasi_kejadian" class="">{{ __('Lokasi Kejadian') }}</label><span class="text-danger">*</span>
                <input id="lokasi_kejadian" type="text" disabled="" class="form-control" name="lokasi_kejadian" value="{{ $record->lokasi_kejadian }}" required autocomplete="lokasi_kejadian" autofocus placeholder="Lokasi Kejadian" maxlength="20">
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
                <label for="lokasi_kejadian" class="">{{ __('Golongan Kendaraan') }}</label><span class="text-danger">*</span>
                <select disabled="" class="form-control select2" name="golongan_id">
                    {!! App\Models\MasterGolken::options('golongan','id',['selected' => $record->golongan_id],'( Golongan Kendaraan )') !!}
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="jenis_kendaraan" class="">{{ __('Jenis Kendaraan') }}</label><span class="text-danger">*</span>
                <input id="jenis_kendaraan" type="text" disabled="" class="form-control" name="jenis_kendaraan" value="{{ $record->jenis_kendaraan }}" required autocomplete="jenis_kendaraan" autofocus placeholder="Jenis Kendaraan" maxlength="20">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="no_polisi" class="">{{ __('No Polisi') }}</label><span class="text-danger">*</span>
                <input id="no_polisi" type="text" disabled="" class="form-control" name="no_polisi" value="{{ $record->no_polisi }}" required autocomplete="no_polisi" autofocus placeholder="No Polisi" maxlength="20">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="keterangan_claim" class="">{{ __('Claim') }}</label><span class="text-danger">*</span>
                <input id="keterangan_claim" type="text" disabled="" class="form-control" name="keterangan_claim" value="{{ $record->keterangan_claim }}" required autocomplete="keterangan_claim" autofocus placeholder="Claim" maxlength="20">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="nominal_customer" class="">{{ __('Besaran claim yang diajukan') }}</label><span class="text-danger">*</span>
                <input id="nominal_customer" type="text" disabled="" class="form-control" name="nominal_customer" value="{{ $record->nominal_customer }}" required autocomplete="nominal_customer" autofocus placeholder="Besaran claim yang diajukan" maxlength="20">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="lokasi_kejadian" class="">{{ __('Keterangan Claim') }}</label><span class="text-danger">*</span>
                <textarea name="keterangan_claim" disabled="" class="form-control" placeholder="Keterangan Claim" >{{ $record->keterangan_claim }}</textarea>
            </div>
        </div>

    </div>
    
    <a href="{{ route($route.'.index') }}" class="btn btn-secondary" >
      <i class="flaticon-circle"></i>
      Kembali
    </a>

    <div class="btn btn-light-success float-right" >
        <i class="flaticon-plus"></i>
        Approve
    </div>
    
    <div class="btn btn-light-danger float-right mr-2">
      <i class="flaticon-cancel"></i>
      Reject
    </div>
    
    {{-- @if($record->report->count() > 0)
    <div class="btn btn-light-success float-right custome-modal" data-url="keluhan/sla/report/{{ $record->id }}" data-modal="#mediumModal">
      <i class="flaticon2-file"></i>
      Detail Report
    </div>
    @else
        @if(($record->report->count() == 0) && ($record->mulaiSla->count() == 0))
            <div class="btn btn-light-success float-right custome-modal" data-url="keluhan/sla/report/{{ $record->id }}" data-modal="#mediumModal">
                <i class="flaticon2-file"></i>
                Teruskan Jenis Keluhan
            </div>
        @endif
    @endif --}}
  </form>
</div>
</div>
@endsection

@section('scripts')
{{-- Page js files --}}
<script>
  
</script>
@endsection
