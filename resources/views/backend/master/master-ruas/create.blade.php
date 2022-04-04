<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Add Ruas</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('Regional') }}</label><span class="text-danger">*</span>
                    <select class="form-control option-ajax select2" data-child="ro" name="regional_id" required>
                        {!! App\Models\MasterRegional::options('name','id',[],'( Pilih Regional )') !!}
                    </select>
                </div>
            </div> --}}

            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('RO') }}</label><span class="text-danger">*</span>
                    {{-- <select class="form-control select2" id="ro" name="ro_id" required>
                        {!! App\Models\MasterRo::options('name','id',[],'( Pilih RO )') !!}
                    </select> --}}
                    <select class="form-control select2" id="ro" name="ro_id">
                        {!! App\Models\MasterRo::options(
                            function ($q) {
                                $regional = $q->regional ? $q->regional->name : '-';
                                return $q->name . ' - ' . $regional;
                            },
                            'id',
                            [],
                            '( Pilih RO )',
                        ) !!}
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Ruas') }}</label><span class="text-danger">*</span>
                    <input id="name" type="text" class="form-control" name="name" value="" required autocomplete="name" autofocus placeholder="Ruas" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('Status') }}</label><span class="text-danger">*</span>
                    <select class="form-control select2" name="active" required>
                        <option value="">Pilih Status</option>
                        <option value="1">Active</option>
                        <option value="0">Non-Active</option>
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
