<form action="{{ route($route . '.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tambah Sumber</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="code" class="">{{ __('Kode Unit') }}</label><span
                            class="text-danger">*</span>
                    </div>
                    <div class="col-9">
                        <input id="code" type="text" class="form-control" name="code" required autocomplete="code"
                            autofocus placeholder="Kode Unit" maxlength="30">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="description" class="">{{ __('Sumber') }}</label><span
                            class="text-danger">*</span>
                    </div>
                    <div class="col-9">
                        <input id="description" type="text" class="form-control" name="description" required
                            autocomplete="description" autofocus placeholder="Sumber" maxlength="50">
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="type[keluhan]" value="0">
            <input type="hidden" name="type[claim]" value="0">

            <div class="col-md-12 form-group row">
                <div class="col-3 col-form-label">
                    <label>Laporan Pelanggan</label><span class="text-danger">*</span>
                </div>
                <div class="col-9 checkbox-inline" required>
                    <label class="checkbox">
                        <input type="checkbox" class="form-control" name="type[keluhan]" value="1" />
                        <span></span>
                        Keluhan
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" class="form-control" name="type[claim]" value="1" />
                        <span></span>
                        Claim
                    </label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="status" class="">{{ __('Status') }}</label>
                    </div>
                    <div class="col-9">
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
