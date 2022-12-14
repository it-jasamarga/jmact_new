@extends('layouts/app')

@section('styles')
    <style>
        a:hover {
            color: orangered;
        }
    </style>
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
            <form action="{{ route($route . '.claimDetail', $record->id) }}" method="POST" id="formData"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-12">
                        <canvas id="flowgraph" class="col-12" height="auto" style="border:#EEE solid 1px" />
                    </div>
                </div>
                <input type="hidden" name="status" value="02">
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="alert alert-custom alert-default" role="alert"
                            style="max-height: 350px;overflow-y:visible">
                            <div class="timeline timeline-2">
                                <div class="timeline-bar"></div>
                                @if ($record->history->count() > 0)
                                    @foreach ($record->history as $k => $value)
                                        <div class="timeline-item">
                                            <div class="timeline-badge bg-success"></div>
                                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                                <span class="mr-3">
                                                    @if ($value->status->code == 03)
                                                        {{ $value->status->status }} oleh {{ $value->user->username }}
                                                        ke {{ $value->unit->unit }}
                                                    @elseif($value->status->code == 01 || $value->status->code == 02)
                                                        {{ $value->status->status }} oleh {{ $value->user->username }}
                                                    @else
                                                        {{ $value->status->status }}
                                                    @endif
                                                </span>
                                                <span class="text-muted text-right">{{ $value->created_at }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        @if ($record->status->code == '03')
                            <div class="alert alert-custom alert-default" role="alert">
                                <div class="alert-icon"><em class="flaticon-warning text-primary"></em></div>
                                <div class="alert-text">
                                    {{ $record->keterangan_reject }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="separator separator-solid mt-2 mb-4"></div>
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
                            <label for="tanggal_input"
                                class="">{{ __('Tanggal Input Klaim') }}</label><span
                                class="text-danger">*</span>
                            <input id="tanggal_input" type="text" class="form-control" name="tanggal_input"
                                value="{{ $record->created_at }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_pelanggan" class="">{{ __('Nama Pelanggan') }}</label><span
                                class="text-danger">*</span>
                            <input id="nama_pelanggan" type="text" class="form-control" name="nama_pelanggan"
                                value="{{ $record->nama_pelanggan }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik_pelanggan" class="">{{ __('NIK Pelanggan') }}</label><span
                                class="text-danger">*</span>
                            <input id="nik_pelanggan" type="text" class="form-control" name="nik_pelanggan"
                                value="{{ $record->nik_pelanggan }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_telepon" class="">{{ __('No Telepon') }}</label><span
                                class="text-danger">*</span>
                            <input id="no_telepon" type="text" class="form-control" name="no_telepon"
                                value="{{ $record->no_telepon }}" readonly>
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
                            <label for="alamat_pelanggan"
                                class="">{{ __('Alamat Pelanggan') }}</label><span
                                class="text-danger">*</span>
                            <textarea name="alamat_pelanggan" class="form-control" placeholder="Alamat Pelanggan" rows="1" readonly>{{ $record->alamat_pelanggan }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ruas_id" class="">{{ __('Ruas Jalan Tol') }}</label><span
                                class="text-danger">*</span>
                            <select disabled class="form-control select2" id="ruas" name="ruas_id">
                                {!! App\Models\MasterRuas::options('name', 'id', ['selected' => $record->ruas_id], '( Ruas Jalan Tol )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sumber_id" class="">{{ __('Sumber') }}</label><span
                                class="text-danger">*</span>
                            <select disabled class="form-control select2" name="sumber_id">
                                {!! App\Models\MasterSumber::options('description', 'id', ['selected' => $record->sumber_id], '( Sumber )') !!}
                            </select>
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
                            <label for="lokasi_kejadian"
                                class="">{{ __('Golongan Kendaraan') }}</label><span
                                class="text-danger">*</span>
                            <select disabled class="form-control select2" name="golongan_id">
                                {!! App\Models\MasterGolken::options('golongan', 'id', ['selected' => $record->golongan_id], '( Golongan Kendaraan )') !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_kendaraan" class="">{{ __('Jenis Kendaraan') }}</label><span
                                class="text-danger">*</span>
                            <input id="jenis_kendaraan" type="text" class="form-control" name="jenis_kendaraan"
                                value="{{ $record->jenis_kendaraan }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_polisi" class="">{{ __('No Polisi') }}</label><span
                                class="text-danger">*</span>
                            <input id="no_polisi" type="text" class="form-control" name="no_polisi"
                                value="{{ $record->no_polisi }}" readonly>
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="keterangan_claim" class="">{{ __('Claim') }}</label><span
                                class="text-danger">*</span>
                            <input id="keterangan_claim" type="text" disabled="" class="form-control"
                                name="keterangan_claim" value="{{ $record->keterangan_claim }}" required
                                autocomplete="keterangan_claim" autofocus placeholder="Claim" maxlength="20">
                        </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_claim_id" class="">{{ __('Klaim') }}</label><span
                                class="text-danger">*</span>
                            <select disabled class="form-control select2" id="jenis_claim" name="jenis_claim_id">
                                {!! App\Models\MasterJenisClaim::options('jenis_claim', 'id', ['selected' => $record->jenis_claim_id], '( Ruas Jalan Tol )') !!}
                            </select>
                        </div>
                    </div>
                    {{-- </div> --}}

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nominal_customer"
                                class="">{{ __('Besaran klaim yang diajukan') }}</label><span
                                class="text-danger">*</span>
                            <input id="nominal_customer" type="text" class="form-control" name="nominal_customer"
                                value="{{ $record->nominal_customer }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keterangan_claim"
                                class="">{{ __('Keterangan Klaim') }}</label><span
                                class="text-danger">*</span>
                            <textarea name="keterangan_claim" class="form-control" placeholder="Keterangan Klaim" rows="1" readonly>{{ $record->keterangan_claim }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="url_file" class="">{{ __('Lampiran') }}</label>
                            {{-- <input id="url_file" type="text" class="form-control custome-modal" name="url_file"
                                value="{{ $record->url_file }}" readonly data-url="claim/show-attachment/{{ $record->id }}" data-modal="#xlarge" style="cursor: pointer"> --}}
                            <a class="custome-modal alert alert-custom alert-default" href="javascript:void(0)"
                                id="url_file" data-url="claim/show-attachment/{{ $record->id }}" data-modal="#xlarge"
                                style="cursor: pointer;">
                                {{ $record->url_file }}
                            </a>
                            {{-- <div class="custom-file">
                                <input type="file" class="custom-file-input" id="keluhan" name="url_file"
                                    data-max-file-size="2M" data-allowed-file-extensions="jpg png gif jpeg"
                                    data-default-file="" data-show-remove="true" required  disabled="" value="{{ $record->url_file }}" />
                                <label class="custom-file-label" for="keluhan"></label>
                            </div> --}}
                        </div>
                    </div>

                </div>

                @if (substr(Request::server('HTTP_REFERER'), -15) == 'pencarian-tiket')
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <em class="flaticon-circle"></em>
                        Kembali
                    </a>
                @else
                    <a href="{{ route($route . '.index') }}" class="btn btn-secondary">
                        <em class="flaticon-circle"></em>
                        Kembali
                    </a>
                    @if ($record->status->code == '01')
                        @if (auth()->user()->hasRole('Manager Area') ||
                            auth()->user()->hasRole('Superadmin'))
                            <div class="btn btn-light-success float-right save">
                                <em class="flaticon-plus"></em>
                                Approve
                            </div>

                            <div class="btn btn-light-danger float-right mr-2 custome-modal" data-status="reject"
                                data-modal="#largeModal" data-url="claim/reject/{{ $record->id }}">
                                <em class="flaticon-cancel"></em>
                                Reject
                            </div>
                        @endif
                    @endif
                @endif
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Page js files --}}
    <script src="../js/flowist.js"></script>
    <script>
        // $(document).on("click", ".save", function(){
        //     var save = $(this).data("status")
        //     if (save === "reject") {
        //         $("[name='status']").val("00")
        //     }
        // })
        $(document).ready(function() {
            $("[name='nominal_customer']").val(convertToRupiah("{{ $record->nominal_customer }}"));
            let flowgraph = new Flowist('flowgraph', 3, 7, 10);
            // ann.claim.draw(sc, "CS JMTO", "Spv JMTO", "RO", "Service Provider", "Regional");

            let color = {
                circle: {
                    active: '#b4d9ea',
                    passive: '#ebecec'
                },
                line: {
                    active: '#51a7ce',
                    passive: '#a1a6a6'
                },
                text: {
                    active: '#51a7ce',
                    passive: '#a1a6a6'
                }
            }

            flowgraph.assets.load([
                '{{ url('icon') }}/inputer.png',
                '{{ url('icon') }}/regional.png',
                '{{ url('icon') }}/ro.png',
                '{{ url('icon') }}/service_provider.png',
                '{{ url('icon') }}/supervisor_manager.png',
                '{{ url('icon') }}/gray_inputer.png',
                '{{ url('icon') }}/gray_regional.png',
                '{{ url('icon') }}/gray_ro.png',
                '{{ url('icon') }}/gray_service_provider.png',
                '{{ url('icon') }}/gray_supervisor_manager.png'],
            ()=>{
                // flowgraph.grid.draw();
                let sc = {{ $record->status->code * 1 }};
                let is_project = {{ ($record->penyelesaian === 'proyek') ? 'true' : 'false'; }}; // TODO: get from field, sc >= 4
                debug({flowgraph}, 'status->code: '+ sc);

                flowgraph.draw.thickness((flowgraph.row.height/2) * 0.75);

                flowgraph.draw.color(color.circle.active);

                // first column circle
                flowgraph.grid.move.cell(2, 1);
                flowgraph.draw.dot();

                if (sc <= 1) flowgraph.draw.color(color.circle.passive);

                // second column circle
                flowgraph.grid.move.cell(2, 3);
                flowgraph.draw.dot();

                if (sc <= 3) flowgraph.draw.color(color.circle.passive);

                // third column circle
                flowgraph.grid.move.cell(2, 5);
                flowgraph.draw.dot();

                if (sc <= 4) flowgraph.draw.color(color.circle.passive);

                // fourth column circle
                if (is_project) {
                    flowgraph.grid.move.cell(2, 7);
                    flowgraph.draw.dot();
                } else {
                    flowgraph.grid.move.cell(1, 7);
                    flowgraph.draw.dot();
                    flowgraph.grid.move.cell(3, 7);
                    flowgraph.draw.dot();
                }

                flowgraph.draw.color(color.line.active);
                flowgraph.draw.thickness(5);

                // first column line
                flowgraph.grid.move.cell(2, 2, 0, -1);
                flowgraph.grid.lineto.cell(2, 2, 0, 1);

                if ((sc <= 1) || (sc == 3)) flowgraph.draw.color(color.line.passive);

                // second column line
                flowgraph.grid.move.cell(2, 4, 0, -1);
                flowgraph.grid.lineto.cell(2, 4, 0, 1);
                
                if (sc <= 3) flowgraph.draw.color(color.line.passive);

                // third column line
                if (is_project) {
                    flowgraph.grid.move.cell(2, 6, 0, -1);
                    flowgraph.grid.lineto.cell(2, 6, 0, 1);
                } else {
                    flowgraph.grid.move.cell(2, 6, 0, -1);
                    flowgraph.grid.lineto.cell(1, 7, 0, -1);
                    flowgraph.draw.dash(15, 5);
                    flowgraph.grid.move.cell(2, 6, 0, -1);
                    flowgraph.grid.lineto.cell(3, 7, 0, -1);
                }

                let d = 0.6 * (flowgraph.column.width > flowgraph.row.height ? flowgraph.row.height : flowgraph.column.width);

                flowgraph.draw.font("bold 16px verdana");

                flowgraph.grid.move.cell(2, 1);
                flowgraph.draw.resource('inputer', d, d, "JMTO Area", color.text.active, 35);

                flowgraph.grid.move.cell(2, 3);
                flowgraph.draw.resource((sc>1? '' : 'gray_')+ 'supervisor_manager', d, d, "Manager Area", sc>1? color.text.active : color.text.passive, 35);

                flowgraph.grid.move.cell(2, 5);
                flowgraph.draw.resource((((sc>2) && (sc!=3))? '' : 'gray_')+ 'ro', d, d, "Representative Office", ((sc>2) && (sc!=3))? color.text.active : color.text.passive, 35);

                if (is_project) {
                    flowgraph.grid.move.cell(2, 7);
                    flowgraph.draw.resource((sc>4? '' : 'gray_')+ 'regional', d, d, "Regional", sc>4? color.text.active : color.text.passive, 35);
                } else {
                    flowgraph.grid.move.cell(1, 7);
                    flowgraph.draw.resource((sc>4? '' : 'gray_')+ 'service_provider', d, d, "Service Provider", sc>4? color.text.active : color.text.passive, 35);

                    flowgraph.grid.move.cell(3, 7);
                    flowgraph.draw.resource((sc>4? '' : 'gray_')+ 'regional', d, d, "Regional", sc>4? color.text.active : color.text.passive, 35);
                }

                flowgraph.draw.font("14px verdana");
                flowgraph.draw.dash(0, 0);
                flowgraph.draw.color(color.line.active);
                flowgraph.grid.move.cell(1, 1, -1, -1);
                flowgraph.draw.adjust(0, 10);
                flowgraph.grid.lineto.cell(1, 1, -1, 1, -100, 10);
                flowgraph.draw.adjust(15, 5);
                flowgraph.draw.align('left');
                flowgraph.draw.color('#666666');
                flowgraph.draw.text("User Pelaksana Laporan");

                flowgraph.draw.dash(15, 5);
                flowgraph.draw.color(color.line.active);
                flowgraph.grid.move.cell(1, 1, -1, -1);
                flowgraph.draw.adjust(0, 30);
                flowgraph.grid.lineto.cell(1, 1, -1, 1, -100, 30);
                flowgraph.draw.adjust(15, 5);
                flowgraph.draw.align('left');
                flowgraph.draw.color('#666666');
                flowgraph.draw.text("User Monitoring");

            });

        })
    </script>
@endsection
