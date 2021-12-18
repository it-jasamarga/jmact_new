<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tambah Sumber</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="code" class="">{{ __('Kode Unit') }}</label>
                    <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" required autocomplete="code" autofocus placeholder="Kode Unit" maxlength="10">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description" class="">{{ __('Sumber') }}</label>
                    <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus placeholder="Sumber" maxlength="10">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="active" class="">{{ __('Status') }}</label>
                    <input id="active" type="text" class="form-control" name="active" value="{{ old('active') }}" required autocomplete="active" autofocus placeholder="Status" maxlength="10">
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
