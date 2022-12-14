<form action="{{ route($route . '.historyStage', $record->id) }}" method="POST" id="formData"
    enctype="multipart/form-data">
    @method('PUT')
    @csrf
    @if ($record->status->code == '01' || $record->status->code == '02' || $record->status->code == '04' || $record->status->code == '05')
        <input type="hidden" name="status" value="06">
    @elseif($record->status->code == '06')
        <input type="hidden" name="status" value="07">
    @elseif($record->status->code == '07')
        <input type="hidden" name="status" value="08">
    @endif
    <div class="modal-header">
        <h3 class="modal-title">Tahapan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                {{-- <div class="form-group">
                    <label for="tahap" class="">{{ __('Tahap') }}</label>
                    <select class="form-control select2" name="tahap">
                        <option value="">( Pilih Tahapan )</option>
                        <option value="Negosiasi/Klarifikasi">Negosiasi/Klarifikasi</option>
                        <option value="Pembayaran">Pembayaran</option>
                    </select>
                </div> --}}
                <div class="form-group row">
                    <label class="col-3 col-form-label">Tahap</label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-list">
                            <label class="checkbox">
                                {{-- dd({{$record->status}}) --}}
                                <input type="checkbox" class="form-control" name="negosiasi_dan_klarifikasi"
                                    {{ $record->status->code == '01' || $record->status->code == '02' || $record->status->code == '03' ? '' : 'disabled' }}
                                    {{ $record->status->code == '04' || $record->status->code == '05' || $record->status->code == '06' || $record->status->code == '07' ? 'checked' : '' }} />
                                <span></span>
                                Negosiasi dan Klarifikasi
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" class="form-control" name="proses_pembayaran"
                                    {{ $record->status->code == '06' ? '' : 'disabled' }}
                                    {{ $record->status->code == '07' || $record->status->code == '08' ? 'checked' : '' }} />
                                <span></span>
                                Proses Pembayaran
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" class="form-control" name="pembayaran_selesai"
                                    {{ $record->status->code == '07' ? '' : 'disabled' }}
                                    {{ $record->status->code == '08' ? 'checked' : '' }} />
                                <span></span>
                                Pembayaran Selesai
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="nominal_final" class="">{{ __('Nominal Klaim (Rp)') }}</label><span
                        class="text-danger">*</span>
                    <input id="nominal_final" type="text" class="form-control" name="nominal_final"
                        value="{{ $record->nominal_final }}" required autocomplete="nominal_final" autofocus
                        placeholder="Nominal Klaim (Rp)" maxlength="30"
                        {{ $record->status->code == '01' || $record->status->code == '02' || $record->status->code == '04' || $record->status->code == '06' ? 'disabled' : '' }}
                        oninput="this.value = convertToRupiah(this.value.replace(/[^0-9.,]/g, '').replace(/(\..*)\.,/g, '$1'))">
                </div>
            </div>

        </div>
    </div>

    </div>
    <div class="modal-footer">
        @if ($record->status->code == '08')
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="flaticon-circle"></i>
                Tutup
            </button>
        @else
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="flaticon-circle"></i>
                Tutup
            </button>
            <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
                <i class="flaticon-add-circular-button"></i>
                Simpan
            </button>
        @endif
    </div>

</form>
