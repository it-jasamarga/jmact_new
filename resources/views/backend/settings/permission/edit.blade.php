<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Ubah Data</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Permission') }}</label>
                    <select class="select2 form-control" required="" name="permission">
                        <option value="">Pilih Menu</option>
                        @if(count($dataMenu) > 0)
                            @foreach($dataMenu as $k => $value)
                                <option value="{{ $value }}" {{ ($value === $permission) ? "selected" : "" }}>{{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Permission') }}</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $name }}" required autocomplete="name" autofocus placeholder="Permission" maxlength="50">
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
    <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
        <i class="flaticon-add-circular-button"></i>
        Simpan
    </button>
</div>

</form>
