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
                    <label for="code" class="">{{ __('Kode Status') }}</label><span class="text-danger">*</span>
                    <input id="code" type="text" class="form-control" name="code" value="{{ $record->code }}" required autocomplete="code" autofocus placeholder="Kode Status" maxlength="10" readonly>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="status" class="">{{ __('Deskripsi') }}</label><span class="text-danger">*</span>
                    {{-- <input id="status" type="text" class="form-control" name="status" value="{{ $record->status }}" required autocomplete="status" autofocus placeholder="Deskripsi" maxlength="10"> --}}
                    <textarea name="status" class="form-control" cols="4" rows="4" required placeholder="Deskripsi">{{$record->status}}</textarea>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('Status') }}</label><span class="text-danger">*</span>
                    <select class="form-control select2" name="active" required>
                        <option value="">Pilih Status</option>
                        <option value="1" {{ ($record->active == 1) ? "selected" : ""}}>Active</option>
                        <option value="0" {{ ($record->active == 0) ? "selected" : ""}}>Non-Active</option>
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
