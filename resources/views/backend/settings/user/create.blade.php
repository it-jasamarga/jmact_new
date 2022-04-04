<form action="{{ route($route.'.store') }}" method="POST" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Add User</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">{{ __('Name') }}</label><span class="text-danger">*</span>
                    <input id="name" type="text" class="form-control" name="name" required autocomplete="off" autofocus placeholder="Name" maxlength="30">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="is_ldap" class="">{{ __('Authentication') }}</label><span class="text-danger">*</span>
                    <label class="checkbox">
                        <input type="checkbox" class="form-control" name="is_ldap" value="1" onchange="ann.x(this)" required/>
                        <span></span>
                        &nbsp; JM Click
                    </label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="username" class="">{{ __('Username') }}</label><span class="text-danger">*</span>
                    <input id="username" type="text" class="form-control" name="username"  required autocomplete="off" autofocus placeholder="Username" maxlength="30">
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
            <div class="col-md-12 x-ann">
                <div class="form-group">
                    <label>{{ __('Password') }}</label><span class="text-danger">*</span>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" required placeholder="Password">
                </div>
            </div>
            <div class="col-md-12 x-ann">
                <div class="form-group">
                    <label>{{ __('Confirm Password') }}</label><span class="text-danger">*</span>
                    <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required placeholder="Confirm Password">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="unit_id" class="">{{ __('Unit') }}</label><span class="text-danger">*</span>
                    <select class="form-control select2" name="unit_id" required>
                        {!! App\Models\MasterUnit::options('unit','id',[],'( Pilih Unit )') !!}
                    </select>
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="regional_id" class="">{{ __('Regional') }}</label>
                    <select class="form-control select2" name="regional_id">
                        {!! App\Models\MasterRegional::options('name','id',[],'( Pilih Unit )') !!}
                    </select>
                </div>
            </div> --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label for="role" class="">{{ __('Role') }}</label><span class="text-danger">*</span>
                    <select class="form-control select2" name="role" required>
                        {!! App\Models\Role::options('name','id',['filters'=>['active'=>1]],'( Pilih Role )') !!}
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="active" class="">{{ __('Status') }}</label><span class="text-danger">*</span>
                    <select class="form-control select2" name="active" required>
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

<script>
    window.ann = {
        x: function(source) {
            // console.log();
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
</script>
