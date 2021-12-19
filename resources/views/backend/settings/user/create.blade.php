<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tambah Data User</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label for="username" class="">{{ __('Name') }}</label>
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Name" maxlength="20">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email" class="">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" maxlength="20">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="unit_id" class="">{{ __('Unit') }}</label>
                    <input id="unit_id" type="text" class="form-control" name="unit_id" value="{{ old('unit_id') }}" required autocomplete="unit_id" autofocus placeholder="Unit" maxlength="10">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="role" class="">{{ __('Role') }}</label>
                    <select class="form-control" name="role">
                        {!! App\Models\Role::options('name','id',[],'( Pilih Role )') !!}
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" required placeholder="Password">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __('Password Confirmation') }}</label>
                    <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required placeholder="Password Confirmation">
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
