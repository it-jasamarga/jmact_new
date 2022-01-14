
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
				<div class="col-md-12">
					
				</div>
			</div>

			<div class="card card-custom gutter-b">
			 	<div class="card-body">
				 		<div class="row">
				 			<div class="col-md-6">
						  	<select class="form-control filter-chart1 select2" data-post="ruas_id">
		            {!! App\Models\MasterRuas::options(function($q){
                    $ro = ($q->ro) ? $q->ro->name : '-';
                    $regional = ($q->ro->regional) ? $q->ro->regional->name : '-';
                        return $q->name.' - '.$ro.' - '.$regional;
                    },'id',[],'( Ruas Jalan Tol )') !!}
		          </select>
				 		</div>
				 		<div class="col-md-6">
						  	<select class="form-control filter-chart1 select2" data-post="regional_id">
		            	{!! App\Models\MasterRegional::options('name','id',[],'( Regional)') !!}
		          	</select>
				 		</div>
				 		<div class="col-md-6 pt-5">
						  	<input id="month" type="text" class="form-control filter-chart1 pickadate-month" data-post="month" value="{{ old('month') }}" required autocomplete="month" autofocus placeholder="Bulan" maxlength="20">
				 		</div>
				 		<div class="col-md-6 pt-5">
						  	<input id="year" type="text" class="form-control filter-chart1 pickadate-year" data-post="year" value="{{ old('year') }}" required autocomplete="year" autofocus placeholder="Tahun" maxlength="20">
				 		</div>
				  </div>
			 	</div>
			 	<div class="card-body">
					<div class="card card-custom card-fit card-border">
						<canvas id="chart-1" width="400" height="400"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br>
@endsection

@section('scripts')
@include('backend.dashboard.partials.chart-1')

{{-- <script>
	$(document).ready(function () {
    loadList([
      { data:'DT_RowIndex', name:'DT_RowIndex', searchable: false,orderable: false  },
      { data:'regional_id', name:'regional_id' },
      { data:'user_id', name:'user_id' },
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
</script> --}}
@endsection