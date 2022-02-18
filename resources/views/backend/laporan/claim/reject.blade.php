<form action="{{ route($route.'.claimDetail',$record->id) }}" method="POST" id="formDataReject" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <input type="hidden" name="status" value="00">
    <div class="modal-header">
        <h3 class="modal-title">Reject Claim</h3>
    </div>
    <div class="modal-body">
        <div class="row">
           
            <div class="col-md-12">
                <div class="form-group">
                    <label for="keterangan_reject" class="">{{ __('Keterangan Reject') }}</label><span class="text-danger">*</span>
                    <textarea name="keterangan_reject" class="form-control" placeholder="Keterangan Reject" rows="4" required></textarea>
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
    {{-- @if(!$record->report()->orderByDesc('created_at')->first()) --}}
    <button type="button" class="btn btn-light-success font-weight-bold mr-2 save" data-form="formDataReject">
        <i class="flaticon-add-circular-button"></i>
        Simpan
    </button>
    {{-- @endif --}}
</div>

</form>
