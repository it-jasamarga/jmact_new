
@extends('layouts/app')

@section('styles')
@endsection

@section('toolbars')
@endsection

@section('content')

<div class="card card-custom" data-card="true" id="kt_card_4">
	<div class="card-header">
		<div class="card-title">
			<span class="svg-icon svg-icon-warning svg-icon-3x">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<rect x="0" y="0" width="24" height="24"/>
						<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
						<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"/>
						<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"/>
					</g>
				</svg>
			</span>
			<h6 class="card-text pl-2">Tiket Keluhan Overtime berjumlah 10</h6>
		</div>
		<div class="card-toolbar">
			<a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
			  	<i class="ki ki-arrow-down icon-nm"></i>
			</a>
		 </div>
	</div>
	<div class="card-body">
		<div class="form">
			<div class="row px-4">
				<div class="col-8 border pt-2">
					<label>Overtime : 10</label>
					<div class="col-md-6 border pt-2">
						<div class="row">
							<label>Jasamarga Transjawa Tol</label>
						</div>
					</div>
					<div class="col-md-6 border my-4">
						{{-- <div class="row"> --}}
							{{-- <label>Jasamarga Metropolitan Tol</label> --}}
							{{-- <div class="col-md-12"> --}}
								<div class="form-group row">
									<label for="regional" class="col-form-label">{{ __('Jasamarga Metropolitan Tol') }}</label>
									<select class="form-control select2" name="active">
										<option value="">Pilih Status</option>
										<option value="1">Active</option>
										<option value="0">Non-Active</option>
									</select>
								</div>
							{{-- </div> --}}
						{{-- </div> --}}
					</div>
				</div>
				<div class="col-4">
				</div>
			</div>
		</div>
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
              <th width="24">No</th>
              <th>Regional</th>
              <th>Inputer</th>
              <th>Sumber</th>
              <th>Ruas</th>
              <th>Waktu Kejadian</th>
              <th>Status</th>
            </tr>
          </thead>

        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
	$(document).ready(function () {
    loadList([
      // { data:'numSelect', name:'numSelect', searchable: false,orderable: false },
      { data:'DT_RowIndex', name:'DT_RowIndex', searchable: false,orderable: false  },
      { data:'regional_id', name:'regional_id' },
      { data:'inputer', name:'inputer' },
      { data:'sumber_id', name:'sumber_id' },
      { data:'ruas_id', name:'ruas_id' },
      { data:'tanggal_kejadian', name:'tanggal_kejadian' },
      { data:'status_id', name:'status_id' },
    ],[
        {
          extend: 'excelHtml5',
          text: "<i class='flaticon2-file'></i>Export</a>",
          className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
        }
      ]);
  });
</script>
@endsection