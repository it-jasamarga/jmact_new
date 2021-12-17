@extends('layouts/app')

@section('styles')
@endsection

@section('content')
<div class="card card-custom card-collapsed" data-card="true" id="kt_card_4">
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
              <th width="15">
                <label class="checkbox checkbox-single checkbox-solid checkbox-primary mb-0">
                  <input type="checkbox" value="" class="group-checkable"/>
                  <span></span>
                </label>
              </th>
              <th width="25">#</th>
              <th>Regional</th>
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
      { data:'numSelect', name:'numSelect', searchable: false,orderable: false },
      { data:'DT_RowIndex', name:'DT_RowIndex', searchable: false,orderable: false  },
      { data:'name', name:'name' },
      { data:'action', name: 'action', searchable: false,orderable: false }
      ]);
  });
</script>
@endsection
