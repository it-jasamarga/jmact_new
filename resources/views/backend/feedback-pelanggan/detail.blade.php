<style>
.modal-body > .row {
    margin-bottom: 15px;
}
input, ul, textarea {
    font-weight: bold!important;
}
ul {
    padding-left: 15px;
}
</style>

    <div class="modal-header">
        <h3 class="modal-title">Detail Feedback Pelanggan</h3>
    </div>
    <div class="modal-body">
@if (is_null($record))
        <div class="row">
            <div class="col-12 d-flex align-items-center">Pelanggan tidak memberikan feedback pada waktunya.</div>
        </div>
@else
        <div class="row">
            <div class="col-4 d-flex align-items-center"><label>No Tiket</label></div>
            <div class="col-8 d-flex align-items-center"><input type="text" readonly class="form-control" value="{{ $record['no_tiket'] }}"></div>
        </div>
        <div class="row">
            <div class="col-4 d-flex align-items-center"><label>Waktu Pengisian Feedback</label></div>
            <div class="col-8 d-flex align-items-center"><input type="text" readonly class="form-control" value="{{ $record['created_at']->formatLocalized('%A %d %B %Y %T') }}"></div>
        </div>
        <div class="row">
            <div class="col-4 d-flex align-items-center"><label>Nama Pelanggan</label></div>
            <div class="col-8 d-flex align-items-center"><input type="text" readonly class="form-control" value="{{ $record->pelanggan['nama_pelanggan'] ?? $record->pelanggan['nama_cust'] }}"></div>
        </div>
        <div class="row">
            <div class="col-4 d-flex align-items-center"><label>No Telepon/Sosial Media</label></div>
            <div class="col-8 d-flex align-items-center"><input type="text" readonly class="form-control" value="{{ $record['no_telepon_sosial_media'] }}"></div>
        </div>
        <div class="row">
            <div class="col-4 d-flex align-items-center"><label>Layanan dari petugas di lapangan</label></div>
            <div class="col-8 d-flex align-items-center"><input type="text" readonly class="form-control" value="{{ $kepuasan[$record['rating']] }}"></div>
        </div>
{{--
        <div class="row">
            <div class="col-4 d-flex align-items-center"><label>Hal yang dirasa kurang puas</label></div>
            <div class="col-8 d-flex align-items-center">
                <ul>
            @foreach (json_decode($record['ketidakpuasan']) as $item)
                <li>{{ $item }}</li>
            @endforeach
                </ul>
            </div>
        </div>
--}}
        <div class="row">
            <div class="col-4 d-flex align-items-center"><label>Saran dan Masukan</label></div>
            <div class="col-8 d-flex align-items-center"><textarea readonly class="form-control">{{ $record['saran_masukan'] }}</textarea></div>
        </div>
@endif

    </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="flaticon-circle"></i>
            Tutup
        </button>
    </div>
