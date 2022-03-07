<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf

    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Ubah Data User</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $record->name }}" required autocomplete="off" autofocus placeholder="Name" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="is_ldap" class="">{{ __('Authentication') }}</label>
                    <label class="checkbox">
                        <input type="checkbox" class="form-control" name="is_ldap" value="1" onchange="ann.x(this)" {{$record->is_ldap == 1 ? 'checked' : ''}} />
                        <span></span>
                        &nbsp; JM Click
                    </label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="username" class="">{{ __('Username') }}</label>
                    <input id="username" type="text" class="form-control" name="username" value="{{ $record->username }}" required autocomplete="off" autofocus placeholder="Username" maxlength="30">
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="email" class="">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ $record->email }}" required autocomplete="email" autofocus placeholder="Email" maxlength="30">
                </div>
            </div> --}}
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="unit_id" class="">{{ __('Unit') }}</label>
                    <input id="unit_id" type="text" class="form-control" name="unit_id" value="{{ $record->unit_id }}" required autocomplete="unit_id" autofocus placeholder="Unit" maxlength="13">
                </div>
            </div> --}}
            <div class="col-md-12 x-ann">
                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" class="form-control" name="password" required placeholder="Password">
                </div>
            </div>
            <div class="col-md-12 x-ann">
                <div class="form-group">
                    <label>{{ __('Password Confirmation') }}</label>
                    <input type="password" class="form-control" name="password_confirmation" required placeholder="Password Confirmation">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="unit_id" class="">{{ __('Unit') }}</label>
                    <select class="form-control select2" name="unit_id">
                        {!! App\Models\MasterUnit::options('unit','id',["selected" => $record->unit_id],'( Pilih Unit )') !!}
                    </select>
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="regional_id" class="">{{ __('Regional') }}</label>
                    <select class="form-control select2" name="regional_id">
                        {!! App\Models\MasterRegional::options('name','id',["selected" => $record->regional_id],'( Pilih Regional )') !!}
                    </select>
                </div>
            </div> --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label for="role" class="">{{ __('Role') }}</label>
                    <select class="form-control select2" name="role">
                        {!! App\Models\Role::options('name','id',["selected" => ($record->roles->first()) ? $record->roles->first()->id : ""],'( Pilih Role )') !!}
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="active" class="">{{ __('Status') }}</label>
                    <select class="form-control select2" name="active">
                        <option value="">Pilih Status</option>
                        <option value="1" {{ ($record->active == 1) ? "selected" : ""}}>Active</option>
                        <option value="0" {{ ($record->active == 0) ? "selected" : ""}}>Non-Active</option>
                    </select>
                </div>
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

<script>
    window.ann = {
        x: function(source) {
            // console.log(source.name, source.checked);
            if (source.checked) {
                $('label[for="username"]').text('NPP');
                $('input[name="username"]').attr('placeholder', 'NPP');
                $('.x-ann').hide();
            } else {
                $('label[for="username"]').text('Username');
                $('input[name="username"]').attr('placeholder', 'Username');
                $('.x-ann').show();
            }
        }
    }
    ann.x($('input[name="is_ldap"]')[0]);
</script>