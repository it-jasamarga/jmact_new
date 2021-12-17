<form action="{{ route($route.'.update',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf

    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Ubah Data</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            

            <div class="col-md-4">
                <div class="form-group">
                    <label for="name" class="">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ $record->name }}" required autocomplete="name" autofocus placeholder="Name" maxlength="50">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name" class="">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ $record->email }}" required autocomplete="email" autofocus placeholder="Email" maxlength="50">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name" class="">{{ __('Phone') }}</label>
                    <input id="phone" type="text" class="form-control" name="phone" value="{{ $record->phone }}" required autocomplete="phone" autofocus placeholder="Phone" maxlength="13" oninput="this.value= this.value.replace(/[^0-9.,]/g, '').replace(/(\..*)\.,/g, '$1')">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name" class="">{{ __('Role') }}</label>
                    <select class="form-control" name="role">
                        {!! App\Models\Role::options('name','id',["selected" => ($record->roles->first()) ? $record->roles->first()->id : ""],'( Choose Role )') !!}
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" required placeholder="Password">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ __('Password Confirmation') }}</label>
                    <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required placeholder="Password Confirmation">
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
