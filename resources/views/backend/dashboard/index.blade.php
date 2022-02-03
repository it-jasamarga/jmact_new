
@extends('layouts/app')

@section('styles')
<style>
  #x-listTables_wrapper>.dt-buttons { display: none; }
  #x-listTables_filter { display: none; }
</style>
@endsection

@section('toolbars')
@endsection

@section('content')
<div class="card card-custom" data-card="true">
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
					<div class="accordion accordion-toggle-arrow pb-4" id="accordionOvertime">
					<div class="card">
							<div class="card-header">
								<div class="card-title collapsed" data-toggle="collapse" data-target="#JNT">
									Jasamarga Nusantara Tol
									<div class="symbol symbol-35 symbol-light-warning ml-3">
										<span class="symbol-label font-size-h6">0</span>
									</div>
								</div>
							</div>
							<div id="JNT" class="collapse" data-parent="#accordionOvertime">
								<div class="card-body pl-10">
									Tidak terdapat overtime.
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<div class="card-title collapsed" data-toggle="collapse" data-target="#JTT">
									Jasamarga Transjawa Tol
									<div class="symbol symbol-35 symbol-light-warning ml-3">
										<span class="symbol-label font-size-h6">3</span>
									</div>
								</div>
							</div>
							<div id="JTT" class="collapse" data-parent="#accordionOvertime">
								<div class="card-body pl-10">
									<div class="row">
										<div class="col-10">RO1 - Jakarta - Tangerang</div>
										<div class="col-2 fw-bold text-right"><p class="mr-5">2</p></div>
									</div>
									<div class="row">
										<div class="col-10">RO2 - Prof. DR. Ir. Soedijatmo</div>
										<div class="col-2 fw-bold text-right"><p class="mr-5">1</p></div>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<div class="card-title collapsed" data-toggle="collapse" data-target="#JMT">
									Jasamarga Metropolitan Tol
									<div class="symbol symbol-35 symbol-light-warning ml-3">
										<span class="symbol-label font-size-h6">7</span>
									</div>
								</div>
							</div>
							<div id="JMT" class="collapse" data-parent="#accordionOvertime">
								<div class="card-body pl-10">
									<div class="row">
										<div class="col-10">RO1 - Palikanci</div>
										<div class="col-2 fw-bold text-right"><p class="mr-5">5</p></div>
									</div>
									<div class="row">
										<div class="col-10">RO2 - Semarang ABC</div>
										<div class="col-2 fw-bold text-right"><p class="mr-5">2</p></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6">
					<canvas id="chart-summary" width="auto" height="auto"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<br>


<div class="card card-custom" data-card="true">
	<div class="card-header row pt-5">
		<div class="col-2">
			<select id="categorySelector"  data-post="category" class="form-control filter-control select2" place-holder="Pilih Kategori">
				<option value="regional">Regional</option>
				<option value="ro">R.O</option>
				<option value="ruas">Ruas</option>
			</select>
		</div>
		<div class="col-3">
			<select class="form-control filter-control dashboard-filter-chart select2" data-post="category_id" id="category_id" name="category_id" place-holder="">
				<option value=""></option>
			</select>
		</div>

		<div class="col-3">
			<fieldset class="form-group ">
				<input type="text" name="date_start" data-post="tanggal_awal" class="form-control filter-control pickadate-start dashboard-filter-chart" placeholder="Waktu Dari">
			</fieldset>
		</div>
		<div class="col-3">
			<fieldset class="form-group">
				<input type="text" name="date_end" data-post="tanggal_akhir" class="form-control filter-control pickadate-end dashboard-filter-chart" placeholder="Waktu Sampai">
			</fieldset>
		</div>

		<div class="col-1 text-right">
		<a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
			<i class="ki ki-arrow-down icon-nm"></i>
		</a>
		</div>
	</div>
	<div class="card-body pb-20">
		<div class="form">
			<div class="row mt-10">

					<canvas id="chart-area" width="auto" height="auto"></canvas>

			</div>

			<div class="row mt-10 align-bottom">
				<div class="col-8 align-bottom">

					<canvas id="chart-source" width="auto" height="auto"></canvas>

				</div>
				<div class="col-4">

					<canvas id="chart-sector" width="auto" height="auto"></canvas>

				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="card card-custom {{ @$class }}">
				{{-- Body --}}
				<div class="card-body pt-4 table-responsive" >
					<table class="table data-thumb-view table-striped" id="listTables">
					<thead>
						<tr>
							<th>No</th>
							<th>No Tiket</th>
							<th>Sumber</th>
							<th>Lokasi</th>
							<th>Waktu Kejadian</th>
							<th>Bidang Keluhan</th>
							<th>Golongan Kendaraan</th>
							<th>Nama Pelanggan</th>
							<th>Nomor Telepon</th>
							<th>Status</th>
						</tr>
					</thead>

					</table>
				</div>
				</div>
			</div>
		</div>



	</div>
</div>

@endsection

@section('scripts')

@include('backend.dashboard.partials.chart-status-pengerjaan')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>

<script defer>

	window.firstTime = true;

	let updateChartSummary = function(data) {
		console.log('## Update Chart Summary', {data});

		var chartBars = {
			overtime: {
				label: 'Overtime',
				color: 'red'
			},
			onprogress: {
				label: 'On Progress',
				color: 'yellow'
			},
			ontime: {
				label: 'On Time',
				color: 'blue'
			}
		}

		var chartData = {
			labels: [],
			datasets: []
		};

		var chartValues = {}
		$.each(data.regional, function(index, name) {
			chartData.labels.push(name.replace(/^Jasamarga (.*) Tol$/, '$1'))
			$.each(chartBars, function(key, item) {
				(typeof chartValues[key] === 'undefined') && (chartValues[key] = []);
				var value = (typeof data.statistic[name] === 'undefined') ? 0 : data.statistic[name][key];
				chartValues[key].push(value);
			})
		})

		$.each(chartBars, function(key, item) {
			var dataset = {
				label: item.label,
				data: chartValues[key],
				borderColor: item.color,
				backgroundColor: item.color
			}
			chartData.datasets.push(dataset);
		})

		console.log({chartData});

		var ctx = document.getElementById('chart-summary').getContext('2d');

		var myChart = new Chart(ctx, {
			type: 'bar',
			plugins: [ChartDataLabels],
			data: chartData,
			options: {
				responsive: true,
				plugins: {
					datalabels: {
						anchor: 'end', // remove this line to get label in middle of the bar
						align: 'end',
						// formatter: (val) => (`${val} Keluhan`),
						labels: { value: { color: '#000' } }
					},

					legend: {
						position: 'right',
						align: 'middle'
					},
					title: {
						display: true,
						text: 'Status Pengerjaan Regional'
					}
				}
			}
		});

	}

	let loadChartSummary = function() {

		let url = "lookup/data/chart/summary";
		console.log('## Load Chart Summary @ '+url);
		$.post( url, { "_token": "{{ csrf_token() }}" }, function(resp) {
			// success
		})
		.done(function(resp) {
			if (resp.status=='ok') {
				updateChartSummary(resp.data);
			}
		})
		.fail(function(resp) { console.log("## POST Error", resp); });

	}

	Chart.register(ChartDataLabels);

	window.appVars = {

@foreach ($appVars as $key => $value)
		'{{ $key }}': "{{ $value }}",
@endforeach

	};

	window.charts = {};

	let updateChart = function(name, filters, stage = 0, data = {}, type = 'bar') {
		console.log('## Update Stage #'+stage+' Chart "'+name+'"', {filters:filters, data:data});

		var chartName = 'chart-'+name;

		if (typeof window.charts[chartName] !== 'undefined') {
			window.charts[chartName].destroy();
			delete window.charts[chartName];
		}

		if (stage == 0) {
			let url = "lookup/data/chart/"+name;
			let params = { '_token': "{{ csrf_token() }}", 'filters': filters };
			console.log('## POST '+url, {params});
			$.post(url, params, function(resp) {
				// success
			})
			.done(function(resp) {
				if (resp.status=='ok') {
					updateChart(resp.name, resp.filters, 1, resp.data, resp.type);
				}
			})
			.fail(function(resp) { console.log("## POST Error", resp); });

		} else if (stage == 1) {

			var maxValue = Math.max.apply(Math, Object.values(data[name]));

			var iColor = 0;
			var datasets = [];

			$.each(data[name], function(label, value) {
				var colorRef = "";
				switch (name) {
					case 'area':
						colorRef = $('#categorySelector').children("option:selected").val()=='ruas' ? ("Chart Area "+$('#category_id').children("option:selected").text()) : ("Chart Area "+$('#category_id').children("option:selected").text()+" - "+label);
						break;
					case 'source':
						colorRef = ("Chart Source "+label);
						break;
					case 'sector':
						colorRef = ("Chart Sector "+label);
						break;
				}

				var color = typeof appVars[colorRef] !== 'undefined' ? appVars[colorRef] : "RGBA(0,0,0,0.1)";
				if (typeof appVars[colorRef] === 'undefined') console.log ('!! ERROR: No color for "'+ colorRef + '"')
				// console.log('## ', colorRef, color);

				if (type=='bar') {
					var dataset = {};
					var values = [];
					values.push(value);
					dataset['label'] = label;
					dataset['data'] = values;
					dataset['borderColor'] = color;
					dataset['backgroundColor'] = color;
					datasets.push(dataset);
				}
			})

			// console.log({datasets});

			let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "Octtober", "November", "December"];

			var oChart = false;
			var ctx = document.getElementById(chartName).getContext('2d');

			if (type=='bar') {
				var labels = [];
				var title = 'Chart';
				switch (name) {
					case 'area':
						title = $('#categorySelector').children("option:selected").text() +' '+ $('#category_id').children("option:selected").text();
						break;
					case 'source':
						title = 'Grafik Sumber Laporan';
						break;
					case 'sector':
						title = 'Grafik Bidang Keluhan';
						break;
				}
				labels.push(title);	//+' - '+months[filters.month-1]+' '+filters.year);

				var data = {
					labels: labels,
					datasets: datasets
				};

				var oChart = new Chart(ctx, {
					type: 'bar',
					plugins: [ChartDataLabels],
					data: data,
					options: {
						"animation": {
							"duration": 1,
							"onComplete": function() {
								// console.log('## Chart rendered', this);
							}
						},
						showDatapoints: true,
						responsive: true,
						// events: [],
						scales: {
							y: { max: (maxValue+10) }
						},
						interaction: {
							mode: 'index'
						},
						plugins: {

							datalabels: {
								anchor: 'end', // remove this line to get label in middle of the bar
								align: 'end',
								// formatter: (val) => (`${val} Keluhan`),
								labels: { value: { color: '#000' } }
							},

							legend: { display: true, position: 'right' },
							title: { display: false }
						}
					}
				});
			} else if (type=='pie') {
				var colors = [];
				$.each(data[name], function(name, value) {
					// console.log('==', 'Chart Sector '+name);
					colors.push(appVars['Chart Sector '+name])
				});
				// console.log('==', {colors});
				var oChart = new Chart(ctx, {
					type: 'pie',
					data: {
						labels: Object.keys(data[name]),
						datasets: [{
							label: '',
							data: Object.values(data[name]),
							backgroundColor: colors,
							hoverOffset: 4
						}]
					},
					options: {
						responsive: true,
						plugins: {
							legend: {
								position: 'right',
							},
							title: {
								font: {weight: 'normal'},
								position: 'bottom',
								display: true,
								text: 'Grafik Bidang Keluhan'
							}
						}
					}
				});
			}

			if (oChart) window.charts[chartName] = oChart;

		}
	}

	let checkFilters = function() {
		let filters = {};
		let category = $('#categorySelector').val();

		if (category.length > 0) filters['category'] = category;

		$('.dashboard-filter-chart').each(function () {
			if (this.value.trim().length > 0) filters[this.name] = this.value;
		});

		let filterCount = Object.keys(filters).length;

		console.log("## Filter: "+filterCount, {filters});

		if (filterCount == 4) {
			console.log('## Applying filters');
			updateChart('area', filters);
			updateChart('source', filters);
			updateChart('sector', filters);
		}

		if (firstTime) {
			firstTime = false;
			loadList([
				{ data:'DT_RowIndex', name:'DT_RowIndex', searchable: false, orderable: false  },
				{ data:'no_tiket', name:'no_tiket' },
				{ data:'sumber_id', name:'sumber_id' },
				{ data:'lokasi_kejadian', name:'lokasi_kejadian' },
				{ data:'tanggal_kejadian', name:'tanggal_kejadian' },
				{ data:'bidang_id', name:'bidang_id' },
				{ data:'golongan_id', name:'golongan_id' },
				{ data:'nama_cust', name:'nama_cust' },
				{ data:'no_telepon', name:'no_telepon' },
				{ data:'status_id', name:'status_id' },
			],[
			{
			extend: 'excelHtml5',
			text: "<i class='flaticon2-file'></i>Export Keluhan</a>",
			className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
			title: 'JMACT - Data Keluhan',
			exportOptions: {
				// columns: ':not(:last-child)',
			}
			}]);		

		}
	}

	let fillCategory = function() {
		let category = $('#categorySelector').children("option:selected").val();
		let category_id = $('#category_id');
		let placeholder = $(category_id).next().find('span.select2-selection__placeholder');
		
		console.log('## Fill Category', category);

		$("#category_id").empty();
		// $('#category_id').append($('<option>', { value: "", text: "" }));

		$(placeholder).text('Memuat data..');

		$.post( "lookup/area/"+category, { "_token": "{{ csrf_token() }}" }, function(resp) {
			// success
		})
		.done(function(resp) {
			if (resp.status=='ok') {


				let category_id = $('#category_id');
				let placeholder = $(category_id).next().find('span.select2-selection__placeholder');
				
				let records = resp.data;
				$.each(records, function (id, text) {
					$('#category_id').append($('<option>', { value: id, text: text }));
				});

				$(placeholder).text('Pilih '+$('#categorySelector').children("option:selected").text());
				checkFilters();
			}
		})
		.fail(function(resp) { console.log("## POST Error", resp); });
	}

	const placeholderUpdateDelay = 1500;

	$(document).ready(function () {
		/*
		console.log('## '+placeholderUpdateDelay+'ms to render dropdown place-holders');
		setTimeout(function() { 
			$('.select2-selection__placeholder').each(function( index ) {
				let select = $($(this).closest('.select2-container')[0]).prev()[0];
				if (select.hasAttribute('place-holder')) {
					let placeholder = $(select).attr('place-holder').trim();
					if (placeholder.length > 0) {
						$(this).text(placeholder);
					}
				}
			});
			console.log("## dropdowns' place-holders rendered");
		}, placeholderUpdateDelay);
		*/

		loadChartSummary();

		$('#categorySelector').on('change', fillCategory);

		$('.dashboard-filter-chart').on('change', function () {
			checkFilters();
		})

		/* let today = new Date();
		$('select[name="month"').val(today.getMonth()+1);
		$('select[name="year"').val(today.getFullYear()); */

		$('input[name="date_start"').val((new Date()).toISOString().slice(0, -17)+'-01');
		$('input[name="date_end"').val((new Date()).toISOString().slice(0, -14));

		fillCategory();

	});
</script>

<script>
	$(document).ready(function () {
  });
</script> --}}
@endsection