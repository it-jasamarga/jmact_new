@extends('layouts/app')

@section('styles')
@endsection

@section('toolbars')
  <a href="" class="btn btn-light-warning font-weight-bolder btn-sm" data-modal="#mediumModal">Create Data</a>
@endsection

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_4">
 <div class="card-header">
  <div class="card-title">
    <h3 class="card-label">{{ $title }}
      <span class="text-muted pt-2 font-size-sm d-block">pengelolahan data </span></h3>
    </div>
    <div class="card-toolbar">
      <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
        <i class="ki ki-arrow-down icon-nm"></i>
      </a>
   </div>
 </div>
 <div class="card-body">
  <form>
    <div class="row">
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">No Tiket</label>
          <fieldset class="form-group">
            <input type="text" data-post="no_tiket" id="dataFilter" class="form-control filter-control" placeholder="No Tiket">
          </fieldset>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Nama Pelanggan</label>
          <fieldset class="form-group">
            <input type="text" data-post="nama_pelanggan" id="dataFilter" class="form-control filter-control" placeholder="Nama Pelanggan">
          </fieldset>
        </div>
        {{-- <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Status</label>
          <fieldset class="form-group">
            <input type="text" data-post="user_id" id="dataFilter" class="form-control filter-control" placeholder="Status">
          </fieldset>
        </div> --}}
        <div class="col-12 col-sm-6 col-lg-4">
            <label for="users-list-role">Status</label>
            <fieldset class="form-group">
              <select class="form-control select2" data-post="status_id">
                  {!! App\Models\MasterStatus::options('status','id',[],'( Status )') !!}
              </select>
            </fieldset>
          </div>
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Ruas Jalan Tol</label>
          <fieldset class="form-group">
            <select class="form-control select2" data-post="ruas_id">
                {!! App\Models\MasterRuas::options('name','id',[],'( Ruas Jalan Tol )') !!}
            </select>
          </fieldset>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Claim</label>
          <fieldset class="form-group">
            <select class="form-control select2" data-post="jenis_claim_id">
                {!! App\Models\MasterJenisClaim::options('jenis_claim','id',[],'( Claim )') !!}
            </select>
          </fieldset>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Golongan Kendaraan</label>
          <fieldset class="form-group">
            <select class="form-control select2" data-post="golongan_id">
              {!! App\Models\MasterGolken::options('description','id',[],'( Sumber )') !!}
            </select>
          </fieldset>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Waktu Dari</label>
          <fieldset class="form-group ">
            <input type="text" data-post="first_date" id="dataFilter" class="form-control filter-control pickadate-start" placeholder="Waktu Dari">
          </fieldset>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Waktu Sampai</label>
          <fieldset class="form-group">
            <input type="text" data-post="second_date" id="dataFilter" class="form-control filter-control pickadate-end" placeholder="Waktu Sampai">
          </fieldset>
        </div>
    </div>
    <button type="button" class="btn btn-secondary clear" >
      <i class="flaticon-circle"></i>
      Clear Search
    </button>
    <button type="button" class="btn btn-light-primary filter-data">
      <i class="flaticon-search"></i>
      Search Data
    </button>
  </form>
</div>
</div>

<br>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="card card-custom {{ @$class }}">
      {{-- Body --}}
      <div class="card-body pt-4 table-responsive" >
        <table class="table data-thumb-view table-striped" id="listTables">
          <thead>
            <tr>
              <th width="24">No</th>
              <th>No Tiket</th>
              <th>Ruas</th>
              <th>Lokasi</th>
              <th>Waktu Kejadian</th>
              <th>Nama Pelanggan</th>
              <th>Kontak Pelanggan</th>
              <th>Claim</th>
              <th>Golongan Kendaraan</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
{{-- Page js files --}}
<script>
  $(document).ready(function () {
    loadList([
      // { data:'numSelect', name:'numSelect', searchable: false,orderable: false },
      { data:'DT_RowIndex', name:'DT_RowIndex', searchable: false,orderable: false  },
      { data:'no_tiket', name:'no_tiket' },
      { data:'ruas_id', name:'ruas_id' },
      { data:'lokasi_kejadian', name:'lokasi_kejadian' },
      { data:'tanggal_kejadian', name:'tanggal_kejadian' },
      { data:'nama_pelanggan', name:'nama_pelanggan' },
      { data:'kontak_pelanggan', name:'kontak_pelanggan' },
      { data:'keterangan_claim', name:'keterangan_claim' },
      { data:'golongan_id', name:'golongan_id' },
      { data:'status_id', name:'status_id' },
      { data:'action', name: 'action', searchable: false,orderable: false }
    ],[
        {
          extend: 'excelHtml5',
          text: "<i class='flaticon2-file'></i>Export Claim</a>",
          className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
        },
        {
          text: "<i class='flaticon-file-1'></i>Add Claim</a>",
          className: "btn buttons-copy btn btn-light-primary font-weight-bold mr-2 buttons-html5 add-page",
          attr: {
            'data-url': "{{ route($route.'.create') }}"
          }
        },
      ]);
  });
</script>
@endsection
