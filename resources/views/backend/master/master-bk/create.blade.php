<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tambah Bidang Keluhan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="keluhan" class="">{{ __('Bidang Keluhan') }}</label><span class="text-danger">*</span>
                    <input id="keluhan" type="text" class="form-control" name="keluhan" value="{{ old('keluhan') }}" required autocomplete="keluhan" autofocus placeholder="Bidang Keluhan" maxlength="30">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="bidang" class="">{{ __('Bidang') }}</label><span class="text-danger">*</span>
                    <input id="bidang" type="text" class="form-control" name="bidang" value="{{ old('bidang') }}" required autocomplete="bidang" autofocus placeholder="Bidang" maxlength="30">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('Status') }}</label>
                    <select class="form-control select2" name="active">
                        <option value="">Pilih Status</option>
                        <option value="1">Active</option>
                        <option value="0">Non-Active</option>
                    </select>
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
