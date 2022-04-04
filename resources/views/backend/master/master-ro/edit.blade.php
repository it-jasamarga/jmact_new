<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Edit Ro</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Ro') }}</label><span class="text-danger">*</span>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $record->name }}" required autocomplete="name" autofocus placeholder="Ro" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional_id" class="">{{ __('Pilih Regional') }}</label><span class="text-danger">*</span>
                    <select class="form-control select2" name="regional_id" required>
                        {!! App\Models\MasterRegional::options('name','id',['selected' => $record->regional_id],'( Pilih Regional )') !!}
                    </select>
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
