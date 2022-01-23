<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tambah Data User</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control" name="name" required autocomplete="off" autofocus placeholder="Name" maxlength="30">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="username" class="">{{ __('Username/NPP') }}</label>
                    <input id="username" type="text" class="form-control" name="username"  required autocomplete="off" autofocus placeholder="Username/NPP" maxlength="30">
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="email" class="">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" maxlength="20">
                </div>
            </div> --}}
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="unit_id" class="">{{ __('Unit') }}</label>
                    <input id="unit_id" type="text" class="form-control" name="unit_id" value="{{ old('unit_id') }}" required autocomplete="unit_id" autofocus placeholder="Unit" maxlength="10">
                </div>
            </div> --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" required placeholder="Password">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __('Confirm Password') }}</label>
                    <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required placeholder="Confirm Password">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="unit_id" class="">{{ __('Unit') }}</label>
                    <select class="form-control select2" name="unit_id">
                        {!! App\Models\MasterUnit::options('unit','id',[],'( Pilih Unit )') !!}
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional_id" class="">{{ __('Regional') }}</label>
                    <select class="form-control select2" name="regional_id">
                        {!! App\Models\MasterRegional::options('name','id',[],'( Pilih Unit )') !!}
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="role" class="">{{ __('Role') }}</label>
                    <select class="form-control select2" name="role">
                        {!! App\Models\Role::options('name','id',['filters'=>['active'=>1]],'( Pilih Role )') !!}
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="regional" class="">{{ __('Status') }}</label>
                    <select class="form-control select2" name="active">
                        <option value="">Pilih Status</option>
                        <option value="1">Active</option>
                        <option value="0">Non-Active</option>
                    </select>
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
