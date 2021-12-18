<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Ubah Ruas</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('Regional') }}</label>
                    <select class="form-control option-ajax select2" data-child="ro" name="regional_id">
                        {!! App\Models\MasterRegional::options('name','id',['selected' => $record->ro->regional_id],'( Pilih Regional )') !!}
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('RO') }}</label>
                    <select class="form-control" id="ro" name="ro_id">
                        {!! App\Models\MasterRo::options('name','id',['selected' => $record->ro_id, 'filters' => ['regional_id' => $record->ro->regional_id]],'( Pilih RO )') !!}
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Ruas') }}</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $record->name }}" required autocomplete="name" autofocus placeholder="Ruas" maxlength="10">
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
