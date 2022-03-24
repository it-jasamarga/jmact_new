@extends('layouts/app')

@section('content')
<style>
#listTables_filter { display: none }
</style>
    <div class="card card-custom" data-card="true" id="kt_card_4">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">{{ "Filter Data" }}</h3>
            </div>
            <div class="card-toolbar">
                <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
                    <i class="ki ki-arrow-down icon-nm"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-6">
                        <label for="no_tiket">No Tiket</label>
                        <fieldset class="form-group">
                            <input type="text" autocomplete="off" data-post="no_tiket" id="dataFilter" class="form-control filter-control" placeholder="No Tiket">
                        </fieldset>
                    </div>
                    <div class="col-6">
                        <label for="status">Status</label>
                        <select class="form-control filter-control select2" name="status" data-post="status">
                            <option value="">( Pilih Status )</option>
                            <option value="outstanding">Outstanding</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                </div>
                <!--div class="row">
                    <div class="col-6">
                        <label for="users-list-role">Waktu Dari</label>
                        <fieldset class="form-group ">
                            <input type="text" data-post="tanggal_awal" id="dataFilter"
                                class="form-control filter-control pickadate-start" placeholder="Waktu Dari">
                        </fieldset>
                    </div>
                    <div class="col-6">
                        <label for="users-list-role">Waktu Sampai</label>
                        <fieldset class="form-group">
                            <input type="text" data-post="tanggal_akhir" id="dataFilter"
                                class="form-control filter-control pickadate-end" placeholder="Waktu Sampai">
                        </fieldset>
                    </div>
                </div-->
                <button type="button" class="btn btn-secondary clear">
                    <i class="flaticon-circle"></i>
                    Clear Search
                </button>
                <button type="button" class="btn btn-light-primary filter-data">
                    <i class="flaticon-search"></i>
                    Search Data
                </button>
            </form>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card card-custom {{ @$class }}">
                {{-- Body --}}
                <div class="card-body pt-4 table-responsive">
                    <table class="table data-thumb-view table-striped" id="listTables">
                        <thead>
                            <tr>
                                <th>No Tiket</th>
                                <th>Nama Pelanggan</th>
                                <th>No Telepon/Sosial Media</th>
                                <th>Terakhir dihubungi</th>
                                <th>URL Feedback</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Page js files --}}
    <script>
        $(document).ready(function() {
            loadList([
                { data: 'no_tiket', name: 'no_tiket' },
                { data: 'nama_pelanggan', name: 'nama_pelanggan' },
                { data: 'no_telepon_sosial_media', name: 'no_telepon_sosial_media' },
                { data: 'last_contact', name: 'last_contact' },
                { data: 'url_feedback', name: 'url_feedback' },
                { data: 'action', name: 'action', searchable: false, orderable: false }
            ], [{
                    extend: 'excelHtml5',
                    text: "<i class='flaticon2-file'></i>Export Feedback</a>",
                    className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
                    title: 'JMACT - Feedback',
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
            ]);



        });
    </script>
@endsection
