<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Ubah Data</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="golken" class="">{{ __('Nama Golongan Kendaraan') }}</label>
                    <input id="golken" type="text" class="form-control" name="golken" value="{{ $record->golken }}" required autocomplete="golken" autofocus placeholder="Nama Golongan Kendaraan" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description" class="">{{ __('Deskripsi') }}</label>
                    <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Deskripsi">{{ $record->deskripsi }}</textarea>
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
