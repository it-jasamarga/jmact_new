<form action="{{ route($route . '.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Add Jenis Claim</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="code" class="">{{ __('Kode Status') }}</label><span
                        class="text-danger">*</span>
                    <input id="code" type="text" class="form-control" name="code" required autocomplete="off" autofocus
                        placeholder="Kode Status" maxlength="10">
                </div>
            </div> --}}

            <div class="col-md-12">
                <div class="form-group">
                    <label for="jenis_claim" class="">{{ __('Jenis Claim') }}</label><span
                        class="text-danger">*</span>
                    <input id="jenis_claim" type="text" class="form-control" name="jenis_claim" required
                        autocomplete="off" autofocus placeholder="Jenis Claim" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="unit_id" class="">{{ __('Unit') }}</label><span class="text-danger">*</span>
                    <select class="form-control select2" name="unit_id">
                        {!! App\Models\MasterUnit::options('unit', 'id', [], '( Pilih Unit )') !!}
                    </select>
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
