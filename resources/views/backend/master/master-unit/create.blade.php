<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tambah Unit</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="code" class="">{{ __('Kode Unit') }}</label><span class="text-danger">*</span>
                    <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" required autocomplete="kode_unit" autofocus placeholder="Kode Unit" maxlength="10">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="unit" class="">{{ __('Unit') }}</label><span class="text-danger">*</span>
                    <input id="unit" type="text" class="form-control" name="unit" value="{{ old('unit') }}" required autocomplete="unit" autofocus placeholder="Unit" maxlength="30">
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
