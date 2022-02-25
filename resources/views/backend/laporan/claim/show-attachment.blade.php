<form method="POST" id="formData" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Detail Lampiran</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="url_file" class="">{{ __('Bukti Lampiran') }}</label>
                    <iframe
                        src="{{ asset('storage/' .@$record->report()->orderByDesc('created_at')->first()->url_file) }}"
                        title="Detail" width="100%" height="480px"></iframe>
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
    </div>

</form>
