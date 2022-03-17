<form action="{{ route($route . '.reportSla', $record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Report Pengerjaan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="penyelesaian" class="">{{ __('Tipe Penyelesaian') }}</label>
                    @if (@$record->report()->orderByDesc('created_at')->first())
                    <input id="tipe_penyelesaian" type="text" readonly class="form-control" name="tipe_penyelesaian" value="{{ @$record->report()->orderByDesc('created_at')->first()->tipe_penyelesaian }}">
                    @else
                    <select class="form-control select2" name="tipe_penyelesaian">
                        <option value="">Pilih Tipe Penyelesaian</option>
                        <option value="Penyelesaian Langsung" {{ (@$record->report()->tipe_penyelesaian == "Penyelesaian Langsung") ? "selected" : ""}}>Penyelesaian Langsung</option>
                        <option value="Penyelesaian Tidak Langsung" {{ (@$record->report()->tipe_penyelesaian == "Penyelesaian Tidak Langsung") ? "selected" : ""}}>Penyelesaian Tidak Langsung</option>
                    </select>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="url_file" class="">{{ __('Bukti Pengerjaan') }}</label><span
                        class="text-danger">*</span>
                    @if (@$record->report()->orderByDesc('created_at')->first())
                        <iframe
                            src="{{ asset('storage/' .@$record->report()->orderByDesc('created_at')->first()->url_file) }}"
                            title="Detail" width="100%" height="340px"></iframe>
                    @else
                        <input type="file" name="url_file" class="dropify" data-max-file-size="10M"
                            data-allowed-file-extensions="jpg png gif jpeg ico doc docx xls xlsx pdf txt"
                            data-default-file="" data-show-remove="true" required>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="keterangan" class="">{{ __('Keterangan Pekerjaan') }}</label><span
                        class="text-danger">*</span>
                    @if (@$record->report()->orderByDesc('created_at')->first())
                        <textarea name="keterangan" class="form-control" placeholder="Keterangan Pekerjaan"
                            readonly>{{ @$record->report()->orderByDesc('created_at')->first()->keterangan }}</textarea>
                    @else
                        <textarea name="keterangan" class="form-control"
                            placeholder="Keterangan Pekerjaan"></textarea>
                    @endif
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
        @if (!$record->report()->orderByDesc('created_at')->first())
            <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
                <em class="flaticon-add-circular-button"></em>
                Simpan
            </button>
        @endif
    </div>

</form>
