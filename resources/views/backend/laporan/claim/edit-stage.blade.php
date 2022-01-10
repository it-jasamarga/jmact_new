<form action="{{ route($route.'.historyStage',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tahapan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="tahap" class="">{{ __('Tahap') }}</label>
                    <select class="form-control select2" name="tahap">
                        <option value="">( Pilih Tahapan )</option>
                        <option value="Negosiasi/Klarifikasi">Negosiasi/Klarifikasi</option>
                        <option value="Pembayaran">Pembayaran</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="nominal" class="">{{ __('Nominal Claim (Rp)') }}</label><span class="text-danger">*</span>
                    <input id="nominal" type="text" class="form-control" name="nominal" value="{{ old('nominal') }}" required autocomplete="nominal" autofocus placeholder="Nominal Claim (Rp)" maxlength="30">
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
