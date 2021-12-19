<form action="{{ route($route.'.reportSla',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Report Pengerjaan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="keluhan" class="">{{ __('Bukti Pengerjaan') }}</label><span class="text-danger">*</span>
                    @if(@$record->report()->orderByDesc('created_at')->first())
                        <input type="file" name="url_file" class="dropify" data-max-file-size="10M" data-allowed-file-extensions="jpg png gif jpeg ico doc docx xls xlsx" data-default-file="{{ asset('storage/'.@$record->report()->orderByDesc('created_at')->first()->url_file) }}" data-show-remove="false" disabled  >
                    @else
                        <input type="file" name="url_file" class="dropify" data-max-file-size="10M" data-allowed-file-extensions="jpg png gif jpeg ico doc docx xls xlsx" data-default-file="" data-show-remove="true" required  >
                    @endif
                </div>
            </div>
           
            <div class="col-md-12">
                <div class="form-group">
                    <label for="bidang" class="">{{ __('Keterangan Pekerjaan') }}</label><span class="text-danger">*</span>
                    @if(@$record->report()->orderByDesc('created_at')->first())
                        <textarea name="keterangan" class="form-control" placeholder="Keterangan Pekerjaan" readonly>{{ @$record->report()->orderByDesc('created_at')->first()->keterangan }}</textarea>
                    @else
                        <textarea name="keterangan" class="form-control" placeholder="Keterangan Pekerjaan"></textarea>
                    @endif
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
    @if(!$record->report()->orderByDesc('created_at')->first())
    <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
        <i class="flaticon-add-circular-button"></i>
        Simpan
    </button>
    @endif
</div>

</form>
