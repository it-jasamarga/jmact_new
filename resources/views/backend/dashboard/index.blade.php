
@extends('layouts/app')

@section('styles')
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
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
				<div class="col-6 border pt-2">
					<h6 class="card-text pl-2">Overtime : 10</h6>
					{{-- <div class="accordion pb-5" id="accordionOvertime">
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingOvertime-1">
							<button class="accordion-button collapsed col-12" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOvertime-1" aria-expanded="false" aria-controls="collapseOvertime-1">
								Jasamarga Transjawa Tol<span class="badge bg-primary ml-2">3</span>
							</button>
							</h2>
							<div id="collapseOvertime-1" class="accordion-collapse collapse" aria-labelledby="headingOvertime-1" data-bs-parent="#accordionOvertime">
								<div class="accordion-body pl-10">
									<div class="row">
										<div class="col-10">RO1 - Jakarta - Tangerang</div>
										<div class="col-2 fw-bold text-end"><p class="mr-5">2</p></div>
									</div>
									<div class="row">
										<div class="col-10">RO2 - Prof. DR. Ir. Soedijatmo</div>
										<div class="col-2 fw-bold text-end"><p class="mr-5">1</p></div>
									</div>
								</div>
							</div>
						</div>
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingOvertime-2">
							<button class="accordion-button collapsed col-12" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOvertime-2" aria-expanded="false" aria-controls="collapseOvertime-2">
								Jasamarga Metropolitan Tol<span class="badge bg-primary ml-2">7</span>
							</button>
							</h2>
							<div id="collapseOvertime-2" class="accordion-collapse collapse" aria-labelledby="headingOvertime-2" data-bs-parent="#accordionOvertime">
								<div class="accordion-body pl-10">
									<div class="row">
										<div class="col-10">RO1 - Palikanci</div>
										<div class="col-2 fw-bold text-end"><p class="mr-5">5</p></div>
									</div>
									<div class="row">
										<div class="col-10">RO2 - Semarang ABC</div>
										<div class="col-2 fw-bold text-end"><p class="mr-5">2</p></div>
									</div>
								</div>
							</div>
						</div>
					</div> --}}
					<div class="accordion accordion-toggle-arrow pb-4" id="accordionExample1">
						<div class="card">
							<div class="card-header">
								<div class="card-title" data-toggle="collapse" data-target="#collapseOne1">
									Jasamarga Transjawa Tol
									<div class="symbol symbol-35 symbol-light-warning ml-3">
										<span class="symbol-label font-size-h6">3</span>
									</div>
								</div>
							</div>
							<div id="collapseOne1" class="collapse show" data-parent="#accordionExample1">
								<div class="card-body">
									<div class="row">
										<div class="col-10">RO1 - Jakarta - Tangerang</div>
										<div class="col-2 fw-bold text-end"><p class="mr-5">2</p></div>
									</div>
									<div class="row">
										<div class="col-10">RO2 - Prof. DR. Ir. Soedijatmo</div>
										<div class="col-2 fw-bold text-end"><p class="mr-5">1</p></div>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo1">
									Jasamarga Metropolitan Tol
									<div class="symbol symbol-35 symbol-light-warning ml-3">
										<span class="symbol-label font-size-h6">7</span>
									</div>
								</div>
							</div>
							<div id="collapseTwo1" class="collapse" data-parent="#accordionExample1">
								<div class="card-body">
									<div class="row">
										<div class="col-10">RO1 - Palikanci</div>
										<div class="col-2 fw-bold text-end"><p class="mr-5">5</p></div>
									</div>
									<div class="row">
										<div class="col-10">RO2 - Semarang ABC</div>
										<div class="col-2 fw-bold text-end"><p class="mr-5">2</p></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6">
					<canvas id="chart-status-pengerjaan" width="auto" height="auto"></canvas>
				</div>
			</div>
			<div class="row mt-10 align-bottom">
				<div class="col-4 align-bottom">
					<div class="row">
						<div class="col-6">
						  	<select class="form-control filter-chart-ruas select2" data-post="ruas_id" place-holder="Pilih Ruas">
								{!! App\Models\MasterRuas::options(function($q){
								$ro = ($q->ro) ? $q->ro->name : '-';
								$regional = ($q->ro->regional) ? $q->ro->regional->name : '-';
									return $q->name.' - '.$ro.' - '.$regional;
								},'id',[],'( Ruas Jalan Tol )') !!}
							</select>
				 		</div>
				 		<div class="col-6">
						  	<select class="form-control filter-chart-ruas select2" data-post="regional_id" place-holder="Pilih Regional">
								{!! App\Models\MasterRegional::options('name','id',[],'( Regional)') !!}
							</select>
				 		</div>
					</div>
					<div class="row mt-5">
				 		<div class="col-6">
							<select class="form-control filter-chart-ruas select2" data-post="month" place-holder="Pilih Bulan">
								<option value="">(Month)</option>
							@for( $i = 1; $i <= 12; $i++ )
								<option value="{{ $i }}">{{ strftime( '%B', mktime( 0, 0, 0, $i, 1 ) ) }}</option>
							@endfor
							</select>
						</div>
				 		<div class="col-6">
							<select class="form-control filter-chart-ruas select2" data-post="year" place-holder="Pilih Tahun">
								<option value="">(Year)</option>
							@for( $i = 2015; $i <= Date("Y")*1; $i++ )
								<option value="{{ $i }}">{{ $i }}</option>
							@endfor
							</select>
				 		</div>
					</div>

					<canvas id="chart-ruas" width="auto" height="auto"  style="position:absolute; top: 200px"></canvas>

				</div>
				<div class="col-4 align-bottom">
					<div class="row">
				 		<div class="col-6">
							<select class="form-control filter-chart-sumber select2" data-post="month" place-holder="Pilih Bulan">
								<option value="">(Month)</option>
							@for( $i = 1; $i <= 12; $i++ )
								<option value="{{ $i }}">{{ strftime( '%B', mktime( 0, 0, 0, $i, 1 ) ) }}</option>
							@endfor
							</select>
						</div>
				 		<div class="col-6">
							<select class="form-control filter-chart-sumber select2" data-post="year" place-holder="Pilih Tahun">
								<option value="">(Year)</option>
							@for( $i = 2015; $i <= Date("Y")*1; $i++ )
								<option value="{{ $i }}">{{ $i }}</option>
							@endfor
							</select>
				 		</div>
					</div>

					<canvas id="chart-sumber" width="auto" height="auto" style="position:absolute; top: 200px"></canvas>

				</div>
				<div class="col-4">
					<div class="row">
				 		<div class="col-6">
							<select class="form-control filter-chart-bidang-keluhan select2" data-post="month" place-holder="Pilih Bulan">
								<option value="">(Month)</option>
							@for( $i = 1; $i <= 12; $i++ )
								<option value="{{ $i }}">{{ strftime( '%B', mktime( 0, 0, 0, $i, 1 ) ) }}</option>
							@endfor
							</select>
						</div>
				 		<div class="col-6">
							<select class="form-control filter-chart-bidang-keluhan select2" data-post="year" place-holder="Pilih Tahun">
								<option value="">(Year)</option>
							@for( $i = 2015; $i <= Date("Y")*1; $i++ )
								<option value="{{ $i }}">{{ $i }}</option>
							@endfor
							</select>
				 		</div>
					</div>

					<canvas id="chart-bidang-keluhan" width="auto" height="auto" drop-style="background:yellow"></canvas>

				</div>
			</div>

			<!--div class="card card-custom gutter-b">
			 	<div class="card-body">
				 		<div class="row">
				 			<div class="col-md-6">
						  	<select class="form-control filter-chart-ruas select2" data-post="ruas_id">
		            {!! App\Models\MasterRuas::options(function($q){
                    $ro = ($q->ro) ? $q->ro->name : '-';
                    $regional = ($q->ro->regional) ? $q->ro->regional->name : '-';
                        return $q->name.' - '.$ro.' - '.$regional;
                    },'id',[],'( Ruas Jalan Tol )') !!}
		          </select>
				 		</div>
				 		<div class="col-md-6">
						  	<select class="form-control filter-chart-ruas select2" data-post="regional_id">
								{!! App\Models\MasterRegional::options('name','id',[],'( Regional)') !!}
							</select>
				 		</div>
				 		<div class="col-md-6 pt-5">

						 
							<select class="form-control filter-chart-ruas select2" data-post="month">
								<option value="">(Month)</option>
							@for( $i = 1; $i <= 12; $i++ )
								<option value="{{ $i }}">{{ strftime( '%B', mktime( 0, 0, 0, $i, 1 ) ) }}</option>
							@endfor
							</select>


						</div>
				 		<div class="col-md-6 pt-5">

						 
							<select class="form-control filter-chart-ruas select2" data-post="year">
								<option value="">(Year)</option>
							@for( $i = 2015; $i <= Date("Y")*1; $i++ )
								<option value="{{ $i }}">{{ $i }}</option>
							@endfor
							</select>


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
			</div-->
		</div>
	</div>
</div>

<br>
@endsection

@section('scripts')

@include('backend.dashboard.partials.chart-status-pengerjaan')
@include('backend.dashboard.partials.chart-ruas')
@include('backend.dashboard.partials.chart-sumber')
@include('backend.dashboard.partials.chart-bidang-keluhan')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> --}}

<script>
	$(document).ready(function () {
		console.log('2000ms to render dropdown place-holder');
		setTimeout(function() { 
			$('.select2-selection__placeholder').each(function( index ) {
				let select = $($(this).closest('.select2-container')[0]).prev()[0];
				if (select.hasAttribute('place-holder')) $(this).text($(select).attr('place-holder'));
			});
			console.log("dropdowns' place-holder rendered");
		}, 2000);
	});
</script>

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