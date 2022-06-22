<form action="{{ route($route . '.reportSla', $record->id) }}" method="POST" id="formData"
    enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">
            @if (@$record->report()->orderByDesc('created_at')->first())
                Detail Report Pengerjaan
            @else
                Report Pengerjaan
            @endif
        </h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="penyelesaian" class="">{{ __('Tipe Penyelesaian') }}</label><span
                            class="text-danger">*</span>
                    </div>
                    <div class="col-9 col-form-label">
                        @if (@$record->report()->orderByDesc('created_at')->first())
                            <input id="tipe_penyelesaian" type="text" readonly class="form-control"
                                name="tipe_penyelesaian"
                                value="{{ @$record->report()->orderByDesc('created_at')->first()->tipe_penyelesaian }}">
                        @else
                            <select class="form-control select2" name="tipe_penyelesaian" required>
                                <option value="">Pilih Tipe Penyelesaian</option>
                                <option value="Penyelesaian Langsung"
                                    {{ @$record->report()->tipe_penyelesaian == 'Penyelesaian Langsung' ? 'selected' : '' }}>
                                    Penyelesaian Langsung</option>
                                <option value="Penyelesaian Tidak Langsung"
                                    {{ @$record->report()->tipe_penyelesaian == 'Penyelesaian Tidak Langsung' ? 'selected' : '' }}>
                                    Penyelesaian Tidak Langsung</option>
                            </select>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="url_file" class="">{{ __('Bukti Pengerjaan') }}</label><span
                            class="text-danger">*</span>
                    </div>
                    <div class="col-9 col-form-label">
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
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="keterangan" class="">{{ __('Keterangan Pengerjaan') }}</label><span
                            class="text-danger">*</span>
                    </div>
                    <div class="col-9 col-form-label">
                        @if (@$record->report()->orderByDesc('created_at')->first())
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan Pengerjaan"
                                readonly>{{ @$record->report()->orderByDesc('created_at')->first()->keterangan }}</textarea>
                        @else
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan Pengerjaan"></textarea>
                        @endif
                    </div>
                </div>
            </div>


            @if (@$record->status->code == '06')
                <input type="hidden" name="kontak_pelanggan" value="0">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="kontak_pelanggan"
                            class="col-3 col-form-label">{{ __('Kontak Pelanggan') }}</label>
                        @if (@$record->report()->orderByDesc('created_at')->first())
                            <div class="col-9 col-form-label">
                                <div class="radio-list">
                                    <label class="radio">
                                        <input type="radio" name="kontak_pelanggan"
                                            {{ @$record->report()->orderByDesc('created_at')->first()->kontak_pelanggan == 1? 'checked disabled': '' }} />
                                        <span></span>
                                        Ya
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="kontak_pelanggan"
                                            {{ @$record->report()->orderByDesc('created_at')->first()->kontak_pelanggan == 0? 'checked disabled': '' }} />
                                        <span></span>
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        @else
                            <div class="col-9 col-form-label">
                                <div class="radio-list">
                                    <label class="radio">
                                        <input type="radio" name="kontak_pelanggan" value="1" />
                                        <span></span>
                                        Ya
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="kontak_pelanggan" value="0" />
                                        <span></span>
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-3 col-form-label">
                            <label for="konfirmasi_pelanggan"
                                class="">{{ __('Konfirmasi Pelanggan') }}</label><span
                                class="text-danger">*</span>
                        </div>
                        <div class="col-9 col-form-label">
                            @if (@$record->report()->orderByDesc('created_at')->first() && @$record->status->code == '06')
                                <textarea name="konfirmasi_pelanggan" class="form-control" placeholder="Konfirmasi Pelanggan"
                                    readonly>{{ @$record->report()->orderByDesc('created_at')->first()->konfirmasi_pelanggan }}</textarea>
                            @else
                                <textarea name="konfirmasi_pelanggan" class="form-control" placeholder="Konfirmasi Pelanggan"></textarea>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

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
