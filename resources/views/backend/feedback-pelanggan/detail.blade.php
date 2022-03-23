<style>
.modal-body > .row > div > input, ul {
    margin-bottom: 15px;
    font-weight: bold;
}
.modal-body > .row > div > textarea {
    font-weight: bold;
}
</style>

    <div class="modal-header">
        <h3 class="modal-title">Detail Feedback Pelanggan</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-12"><label>No Tiket</label></div>
            <div class="col-12"><input type="text" readonly class="form-control" value="{{ $record['no_tiket'] }}"></div>
        </div>
        <div class="row">
            <div class="col-12"><label>Waktu Pengisian Feedback</label></div>
            <div class="col-12"><input type="text" readonly class="form-control" value="{{ $record['created_at'] }}"></div>
        </div>
        <div class="row">
            <div class="col-12"><label>Nama Pelanggan</label></div>
            <div class="col-12"><input type="text" readonly class="form-control" value="{{ $record->pelanggan['nama_pelanggan'] ?? $record->pelanggan['nama_cust'] }}"></div>
        </div>
        <div class="row">
            <div class="col-12"><label>No Telepon/Sosial Media</label></div>
            <div class="col-12"><input type="text" readonly class="form-control" value="{{ $record['no_telepon_sosial_media'] }}"></div>
        </div>
        <div class="row">
            <div class="col-12"><label>Layanan dari petugas di lapangan</label></div>
            <div class="col-12"><input type="text" readonly class="form-control" value="{{ $kepuasan[$record['rating']] }}"></div>
        </div>
        <div class="row">
            <div class="col-12"><label>Hal yang dirasa kurang puas</label></div>
            <div class="col-12">
                <ul>
            @foreach (json_decode($record['ketidakpuasan']) as $item)
                <li>{{ $item }}</li>
            @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12"><label>Saran dan Masukan</label></div>
            <div class="col-12"><textarea readonly class="form-control">{{ $record['saran_masukan'] }}</textarea></div>
        </div>
    </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="flaticon-circle"></i>
            Tutup
        </button>
    </div>
