<form action="{{ route($route.'.historyStage',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    @if(($record->status->code == "03"))
        <input type="hidden" name="status" value="04">
        @elseif(($record->status->code == "04"))
        <input type="hidden" name="status" value="05">
        @elseif(($record->status->code == "05"))
        <input type="hidden" name="status" value="06">
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
                                    <input type="checkbox" name="Checkboxes4" class="form-control" {{($record->status->code == "03") ? "" : "disabled"}}/>
                                    <span></span>
                                    Negosiasi dan Klarifikasi
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" name="Checkboxes4" class="form-control" {{($record->status->code == "04") ? "" : "disabled"}}/>
                                    <span></span>
                                    Pembayaran
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" name="Checkboxes4" class="form-control" {{($record->status->code == "05") ? "" : "disabled"}}/>
                                    <span></span>
                                    Pembayaran Selesai
                                </label>
                            </div>
                            {{-- <div class="radio-list">
                                <label class="radio">
                                    <input type="radio"  name="radios4"/>
                                    <span></span>
                                    Negosiasi dan Klarifikasi
                                </label>
                                <label class="radio">
                                    <input type="radio" checked="checked" name="radios4"/>
                                    <span></span>
                                    Pembayaran
                                </label>
                                <label class="radio radio-disabled">
                                    <input type="radio" disabled="disabled" name="radios4"/>
                                    <span></span>
                                    Pembayaran Selesai
                                </label>
                            </div> --}}
                        </div>
                    </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="nominal" class="">{{ __('Nominal Claim (Rp)') }}</label><span class="text-danger">*</span>
                    <input id="nominal" type="text" class="form-control" name="nominal" value="{{ old('nominal') }}" required autocomplete="nominal" autofocus placeholder="Nominal Claim (Rp)" maxlength="30" {{($record->status->code == "03" || $record->status->code == "04") ? "disabled" : ""}}>
                </div>
            </div>

        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <i class="flaticon-circle"></i>
        Tutup
    </button>
    <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
        <i class="flaticon-add-circular-button"></i>
        Simpan
    </button>
</div>

</form>
