<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Ubah Bidang Keluhan</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label for="keluhan" class="">{{ __('Bidang Keluhan') }}</label>
                    <input id="keluhan" type="text" class="form-control" name="keluhan" value="{{ $record->keluhan }}" required autocomplete="keluhan" autofocus placeholder="Bidang Keluhan" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="bidang" class="">{{ __('Bidang') }}</label>
                    <input id="bidang" type="text" class="form-control" name="bidang" value="{{ $record->bidang }}" required autocomplete="bidang" autofocus placeholder="Bidang" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('Status') }}</label>
                    <select class="form-control select2" name="active">
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
