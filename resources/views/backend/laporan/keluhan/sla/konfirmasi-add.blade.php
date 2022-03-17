<form action="{{ route($route . '.konfirmasiPelanggan', $record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Konfirmasi Pelanggan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group row">
                    <label for="kontak_pelanggan" class="col-3 col-form-label">{{ __('Kontak Pelanggan') }}</label>
                    @if (@$record->report()->orderByDesc('created_at')->first() && @$record->checkStatus(['05']) === 'true')
                    <div class="col-9 col-form-label">
                        <div class="radio-list">
                            <label class="radio">
                                <input type="radio"  name="kontak_pelanggan" {{@$record->report()->orderByDesc('created_at')->first()->kontak_pelanggan == '1' ? 'checked' : ''}}/>
                                <span></span>
                                Ya
                            </label>
                            <label class="radio">
                                <input type="radio"  name="kontak_pelanggan" {{@$record->report()->orderByDesc('created_at')->first()->kontak_pelanggan == '1' ? 'checked' : ''}}/>
                                <span></span>
                                Tidak
                            </label>
                        </div>
                    </div>
                    @else
                    {{-- <form class="form">
                        <div class="form-group row"> --}}
                            {{-- <label for="penyelesaian" class="col-3 col-form-label">{{ __('Kontak Pelanggan') }}</label> --}}
                            <div class="col-9 col-form-label">
                                <div class="radio-list">
                                    <label class="radio">
                                        <input type="radio" name="kontak_pelanggan" value="1"/>
                                        <span></span>
                                        Ya
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="kontak_pelanggan" value="0"/>
                                        <span></span>
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        {{-- </div>
                    </form> --}}
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-3 col-form-label">
                        <label for="konfirmasi_pelanggan" class="">{{ __('Konfirmasi Pelanggan') }}</label><span
                            class="text-danger">*</span>
                    </div>
                        <div class="col-9 col-form-label">
                    @if (@$record->report()->orderByDesc('created_at')->first() && @$record->checkStatus(['05']) === 'true')
                        <textarea name="konfirmasi_pelanggan" class="form-control" placeholder="Konfirmasi Pelanggan"
                            readonly>{{ @$record->report()->orderByDesc('created_at')->first()->konfirmasi_pelanggan }}</textarea>
                    @else
                        <textarea name="konfirmasi_pelanggan" class="form-control"
                            placeholder="Konfirmasi Pelanggan"></textarea>
                    @endif
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
        @if ($record->checkStatus(['05']) === 'false')
            <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
                <em class="flaticon-add-circular-button"></em>
                Simpan
            </button>
        @endif
    </div>

</form>
