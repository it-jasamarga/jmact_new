<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Buat Data</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="code" class="">{{ __('Code') }}</label>
                    <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" required autocomplete="code" autofocus placeholder="Code" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description" class="">{{ __('Deskripsi') }}</label>
                    <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Deskripsi"></textarea>
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
