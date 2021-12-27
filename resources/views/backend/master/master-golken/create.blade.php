<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tambah Golongan Kendaraan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="golongan" class="">{{ __('Golongan') }}</label><span class="text-danger">*</span>
                    <input id="golongan" type="text" class="form-control" name="golongan" value="{{ old('golongan') }}" required autocomplete="golongan" autofocus placeholder="Golongan" maxlength="20">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description" class="">{{ __('Deskripsi') }}</label><span class="text-danger">*</span>
                    <textarea name="description" class="form-control" cols="4" rows="4" placeholder="Deskripsi" required></textarea>
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
