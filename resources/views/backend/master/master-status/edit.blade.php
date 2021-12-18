<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Ubah Status</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="code" class="">{{ __('Kode Status') }}</label>
                    <input id="code" type="text" class="form-control" name="code" value="{{ $record->code }}" required autocomplete="code" autofocus placeholder="Kode Status" maxlength="10">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="status" class="">{{ __('Deskripsi') }}</label>
                    <input id="status" type="text" class="form-control" name="status" value="{{ $record->status }}" required autocomplete="status" autofocus placeholder="Deskripsi" maxlength="10">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="active" class="">{{ __('Status') }}</label>
                    <input id="active" type="text" class="form-control" name="active" value="{{ $record->active }}" required autocomplete="active" autofocus placeholder="Status" maxlength="10">
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
