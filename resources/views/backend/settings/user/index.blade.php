@extends('layouts/app')

@section('styles')
@endsection

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_4">
 <div class="card-header">
  <div class="card-title">
    <h3 class="card-label">{{ $title }}
    <span class="text-muted pt-2 font-size-sm d-block">pengelolahan data </span></h3>
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
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Name</label>
          <fieldset class="form-group">
            <input type="text" data-post="name" id="dataFilter" class="form-control filter-control" placeholder="Name" autocomplete="off">
          </fieldset>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Username</label>
          <fieldset class="form-group">
            <input type="text" data-post="username" id="dataFilter" class="form-control filter-control" placeholder="Username" autocomplete="off">
          </fieldset>
        </div>
        {{-- <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Email</label>
          <fieldset class="form-group">
            <input type="text" data-post="email" id="dataFilter" class="form-control filter-control" placeholder="Email">
          </fieldset>
        </div> --}}
        {{-- <div class="col-12 col-sm-6 col-lg-4">
          <label for="users-list-role">Unit</label>
          <fieldset class="form-group">
            <input type="text" data-post="unit" id="dataFilter" class="form-control filter-control" placeholder="Unit">
          </fieldset>
        </div> --}}
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="form-group">
              <label for="users-list-role" class="">{{ __('Unit') }}</label>
              <select class="form-control filter-control select2" name="unit_id" data-post="unit_id">
                  {!! App\Models\MasterUnit::options('unit','id',[],'( Pilih Unit )') !!}
              </select>
          </div>
      </div>
      </div>
      <button type="button" class="btn btn-secondary clear" >
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
      <div class="card-body pt-4 table-responsive" >
        <table class="table data-thumb-view table-striped" id="listTables">
          <thead>
            <tr>
              {{-- <th width="15">
                <label class="checkbox checkbox-single checkbox-solid checkbox-primary mb-0">
                  <input type="checkbox" value="" class="group-checkable"/>
                  <span></span>
                </label>
              </th> --}}
              <th width="24">No</th>
              <th>Name</th>
              <th>Username/NPP</th>
              <th>Status</th>
              <th>Action</th>
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
  $(document).ready(function () {
    loadList([
      // { data:'numSelect', name:'numSelect', searchable: false,orderable: false },
      { data:'DT_RowIndex', name:'DT_RowIndex', searchable: false, orderable: false  },
      { data:'name', name:'name' },
      { data:'username', name:'username' },
      { data:'active', name:'active' },
      { data:'action', name: 'action', searchable: false, orderable: false }
    ],[
      @if(auth()->user()->can('user-account.create'))
        {
          text: "<i class='flaticon-file-1'></i>Add User</a>",
          className: "btn buttons-copy btn btn-light-primary font-weight-bold mr-2 buttons-html5 add-modal",
          attr: {
            'data-modal': "#largeModal"
          }
        }
        @endif
      ]);
  });
</script>
@endsection
