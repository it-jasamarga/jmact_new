<form action="{{ route($route.'.detailReject',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
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
                    <label for="catatan_reject" class="">{{ __('Catatan Reject') }}</label><span class="text-danger">*</span>
                    <textarea name="catatan_reject" class="form-control" placeholder="Catatan Reject" rows="4"></textarea>
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
    <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
        <i class="flaticon-add-circular-button"></i>
        Simpan
    </button>
    {{-- @endif --}}
</div>

</form>
