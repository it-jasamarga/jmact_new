<form action="{{ route($route . '.update', $record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Edit Data</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="code" class="">{{ __('Kode Aduan') }}</label><span class="text-danger">*</span>
                    </div>
                    <div class="col-9">
                        <input id="code" type="text" class="form-control" name="code" value="{{ $record->code }}"
                            required autocomplete="code" autofocus placeholder="Kode Aduan" maxlength="10" readonly>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="description" class="">{{ __('Sumber') }}</label><span class="text-danger">*</span>
                    </div>
                    <div class="col-9">
                        <input id="description" type="text" class="form-control" name="description"
                            value="{{ $record->description }}" required autocomplete="description" autofocus
                            placeholder="Sumber" maxlength="50">
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
                        <input type="checkbox" class="form-control" name="type[keluhan]" value="1" {{$record->keluhan == 1 ? 'checked' : ''}}/>
                        <span></span>
                        Keluhan
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" class="form-control" name="type[claim]" value="1" {{ $record->claim == 1 ? 'checked' : ''}}/>
                        <span></span>
                        Claim
                    </label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="status" class="">{{ __('Status') }}</label><span class="text-danger">*</span>
                    </div>
                    <div class="col-9">
                        <select class="form-control select2" name="active" required>
                            <option value="">Pilih Status</option>
                            <option value="1" {{ $record->active == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $record->active == 0 ? 'selected' : '' }}>Non-Active</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <em class="flaticon-circle"></em>
            Tutup
        </button>
        <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
            <em class="flaticon-add-circular-button"></em>
            Simpan
        </button>
    </div>

</form>
