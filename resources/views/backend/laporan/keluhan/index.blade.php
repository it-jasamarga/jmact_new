@extends('layouts/app')

@section('styles')
@endsection

@section('toolbars')
    <!-- <a href="" class="btn btn-light-warning font-weight-bolder btn-sm" data-modal="#mediumModal">Create Data</a> -->
@endsection

@section('content')
    <div class="card card-custom" data-card="true" id="kt_card_4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">{{ "Filter Data $title" }}
                    <span class="text-muted pt-2 font-size-sm d-block">pengelolahan data </span>
                </h3>
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
                            <input type="text" data-post="no_tiket" id="dataFilter" class="form-control filter-control"
                                placeholder="No Tiket">
                        </fieldset>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="users-list-role">Nama Pelanggan</label>
                        <fieldset class="form-group">
                            <input type="text" data-post="nama_cust" id="dataFilter" class="form-control filter-control"
                                placeholder="Nama Pelanggan">
                        </fieldset>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="users-list-role">Nama Inputer</label>
                        <fieldset class="form-group">
                            <input type="text" data-post="user_id" id="dataFilter" class="form-control filter-control"
                                placeholder="Nama Inputer">
                        </fieldset>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="users-list-role">Ruas Jalan Tol</label>
                        <fieldset class="form-group">
                            <select class="form-control filter-control select2" data-post="ruas_id" id="dataFilter">
                                {!! App\Models\MasterRuas::options('name', 'id', [], '( Ruas Jalan Tol )') !!}
                            </select>
                        </fieldset>
                    </div>

                    {{-- <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Bidang</label>
          <fieldset class="form-group">
            <select class="form-control filter-control select2" data-post="bidang_id">
                {!! App\Models\MasterBk::options('keluhan','id',[],'( Bidang )') !!}
            </select>
          </fieldset>
        </div> --}}

                    @php
                        $masterBk = App\Models\MasterBk::get()->groupBy('bidang');
                    @endphp
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label for="bidang_id" class="">{{ __('Bidang') }}</label>
                            <select class="form-control filter-control select2" name="bidang_id" data-post="bidang_id">
                                <option value="" selected>Pilih Data</option>
                                @foreach ($masterBk as $k => $value)
                                    <optgroup label="{{ $k }}">
                                        @if ($value->count() > 0)
                                            @foreach ($value as $item)
                                                <option value="{{ $item->id }}">{{ $item->keluhan }}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="users-list-role">Sumber</label>
                        <fieldset class="form-group">
                            <select class="form-control filter-control select2" data-post="sumber_id">
                                {!! App\Models\MasterSumber::options('description', 'id', [], '( Sumber )') !!}
                            </select>
                        </fieldset>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="users-list-role">Status</label>
                        <fieldset class="form-group">
                            <select class="form-control filter-control select2" data-post="status_id">
                                {!! App\Models\MasterStatus::options('status', 'id', ['filters' => ['type' => 1]], '( Status )') !!}
                            </select>
                        </fieldset>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="users-list-role">Waktu Dari</label>
                        <fieldset class="form-group ">
                            <input type="text" data-post="tanggal_awal" id="dataFilter"
                                class="form-control filter-control pickadate-start" placeholder="Waktu Dari">
                        </fieldset>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="users-list-role">Waktu Sampai</label>
                        <fieldset class="form-group">
                            <input type="text" data-post="tanggal_akhir" id="dataFilter"
                                class="form-control filter-control pickadate-end" placeholder="Waktu Sampai">
                        </fieldset>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary clear">
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
                <div class="card-body pt-4 table-responsive">
                    <table class="table data-thumb-view table-striped" id="listTables">
                        <thead>
                            <tr>
                                <th id="listTables">No</th>
                                <th id="listTables">No Tiket</th>
                                <th id="listTables">Ruas</th>
                                <th id="listTables">Lokasi</th>
                                <th id="listTables">Waktu Kejadian</th>
                                <th id="listTables">Nama Pelanggan</th>
                                <th id="listTables">No Telepon</th>
                                <th id="listTables">Sumber</th>
                                <th id="listTables">Bidang Keluhan</th>
                                <th id="listTables">Golongan Kendaraan</th>
                                <th id="listTables">Status</th>
                                <th id="listTables">Action</th>
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
        $(document).ready(function() {
            loadList([
                // { data:'numSelect', name:'numSelect', searchable: false,orderable: false },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'no_tiket',
                    name: 'no_tiket'
                },
                {
                    data: 'ruas_id',
                    name: 'ruas_id'
                },
                {
                    data: 'lokasi_kejadian',
                    name: 'lokasi_kejadian'
                },
                {
                    data: 'tanggal_kejadian',
                    name: 'tanggal_kejadian'
                },
                {
                    data: 'nama_cust',
                    name: 'nama_cust'
                },
                {
                    data: 'no_telepon',
                    name: 'no_telepon'
                },
                {
                    data: 'sumber_id',
                    name: 'sumber_id'
                },
                {
                    data: 'bidang_id',
                    name: 'bidang_id'
                },
                {
                    data: 'golongan_id',
                    name: 'golongan_id'
                },
                {
                    data: 'status_id',
                    name: 'status_id'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false
                }
            ], [{
                    extend: 'excelHtml5',
                    text: "<i class='flaticon2-file'></i>Export Keluhan</a>",
                    className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
                    title: 'JMACT - Data Keluhan',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                @if (auth()->user()->can('keluhan.create'))
                    {
                    text: "<i class='flaticon-file-1'></i>Add Keluhan</a>",
                    className: "btn buttons-copy btn btn-light-primary font-weight-bold mr-2 buttons-html5 add-page",
                    attr: {
                    'data-url': "{{ route($route . '.create') }}"
                    }
                    },
                @endif
            ]);



        });
    </script>
@endsection
