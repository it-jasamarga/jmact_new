<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Edit Ruas</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="regional_id" class="">{{ __('Regional') }}</label><span class="text-danger">*</span>
                    <select class="form-control option-ajax select2" data-child="regional" name="regional_id" required>
                        {!! App\Models\MasterRegional::options('name','id',['selected' => $record->ro->regional_id],'( Pilih Regional )') !!}
                    </select>
                </div>
            </div> --}}

            <div class="col-md-12">
                <div class="form-group">
                    <label for="ro_id" class="">{{ __('RO') }}</label><span class="text-danger">*</span>
                    <select class="form-control option-ajax select2" id="ro" name="ro_id" required>
                        {!! App\Models\MasterRo::options('name','id',['selected' => $record->ro_id, 'filters' => ['regional_id' => $record->ro->regional_id]],'( Pilih RO )') !!}
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Ruas') }}</label><span class="text-danger">*</span>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $record->name }}" required autocomplete="name" autofocus placeholder="Ruas" maxlength="30">
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
