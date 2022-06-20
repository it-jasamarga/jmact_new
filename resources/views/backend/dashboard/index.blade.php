
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

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<button class="nav-link active" type="button" tab="keluhan">Dashboard Keluhan</button>
			</li>
			<li class="nav-item">
				<button class="nav-link" type="button" tab="claim">Dashboard Claim</button>
			</li>
		</ul>
		<input type="hidden" id="dashscope" name="dashscope" data-post="dashscope" class="filter-control" value="keluhan">
<div class="dashboard-keluhan card card-custom" data-card="true">
	<div class="card-header">
		<div class="card-title">
			@if ($overtime['total'] > 0)
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
			@endif
			<h6 class="card-text pl-2">
			@if ($overtime['total'] > 0)
				Tiket Keluhan Overtime berjumlah {{ $overtime['total'] }}
			@endif
			</h6>
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
					<h6 class="card-text pl-2">Overtime : {{ $overtime['total'] }}</h6>
					<div class="accordion accordion-toggle-arrow pb-4" id="keluhan_accordionOvertime">
					@foreach ($overtime['regional'] as $regional => $regional_data)
						<div class="card">
							<div class="card-header">
								<div class="card-title collapsed" data-toggle="collapse" data-target="#keluhan_OT_{{ str_replace(' ', '', $regional) }}">
									{{ $regional }}
									<div class="symbol symbol-35 symbol-light-warning ml-3">
										<span class="symbol-label font-size-h6">{{ $regional_data['total'] }}</span>
									</div>
								</div>
							</div>
							<div id="keluhan_OT_{{ str_replace(' ', '', $regional) }}" class="collapse" data-parent="#keluhan_accordionOvertime">
								<div class="card-body pl-10">
								@if ($regional_data['total'] == 0)
									Tidak terdapat overtime.
								@else
									@foreach ($regional_data['ruas'] as $ruas => $ruas_total)
									<div class="row">
										<div class="col-10">{{ $ruas }}</div>
										<div class="col-2 fw-bold text-right"><p class="mr-5">{{ $ruas_total }}</p></div>
									</div>
									@endforeach
								@endif
								</div>
							</div>
						</div>
					@endforeach
					</div>
				</div>
				<div class="col-6">
					<canvas id="keluhan_chart-summary" width="auto" height="auto"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>
<br class="dashboard-keluhan">
<div class="dashboard-keluhan card card-custom" data-card="true">
	<div class="card-header row pt-5">
		<div class="col-2">
			<select id="keluhan_categorySelector" data-post="category" name="keluhan_category" class="form-control filter-control select2" place-holder="Pilih Kategori">
				<option value="regional">Regional</option>
				<option value="ro">R.O</option>
				<option value="ruas">Ruas</option>
			</select>
		</div>
		<div class="col-3">
			<select class="form-control filter-control keluhan_dashboard-filter-chart select2" data-post="category_id-x" id="keluhan_category_id" name="keluhan_category_id" place-holder="">
				<option value=""></option>
			</select>
		</div>

		<div class="col-3">
			<fieldset class="form-group ">
				<input type="text" name="keluhan_date_start" data-post="tanggal_awal" class="form-control filter-control pickadate-start keluhan_dashboard-filter-chart" placeholder="Waktu Dari">
			</fieldset>
		</div>
		<div class="col-3">
			<fieldset class="form-group">
				<input type="text" name="keluhan_date_end" data-post="tanggal_akhir" class="form-control filter-control pickadate-end keluhan_dashboard-filter-chart" placeholder="Waktu Sampai">
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
			<div id="keluhan_no-chart-data" class="row" style="display:none">
				<div class="col-12 text-center" style="color:red;font-size:.85em">
					no data to render chart
				</div>
			</div>
			<div class="row mt-10">

					<canvas id="keluhan_chart-area" width="auto" height="auto"></canvas>

			</div>

			<div class="row mt-10 align-bottom">
				<div class="col-8 align-bottom">

					<canvas id="keluhan_chart-source" width="auto" height="auto"></canvas>

				</div>
				<div class="col-4">

					<canvas id="keluhan_chart-sector" width="auto" height="auto"></canvas>

				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="card card-custom {{ @$class }}">
				{{-- Body --}}
				<div class="card-body pt-4 table-responsive" >
					<table class="table data-thumb-view table-striped" id="keluhan_listTables">
					<thead>
						<tr>
							<th>No</th>
							<th>No Tiket</th>
							<th>Sumber</th>
							<th>Lokasi</th>
							<th>Tanggal Pelaporan</th>
							<th>Bidang Keluhan</th>
							<th>Golongan Kendaraan</th>
							<th>Nama Pelanggan</th>
							<th>Nomor Telepon</th>
							<th>Sosial Media</th>
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

<div class="dashboard-claim card card-custom" data-card="true" style="display:none">
<div class="card-header row pt-5">
		<div class="col-2">
			<select id="claim_categorySelector" data-post="category" name="claim_category" class="form-control filter-control dashboard-selector select2" place-holder="Pilih Kategori">
				<option value="regional">Regional</option>
				<option value="ro">R.O</option>
				<option value="ruas">Ruas</option>
			</select>
		</div>
		<div class="col-3">
			<select class="form-control filter-control dashboard-filter select2" data-post="category_id" id="claim_category_id" name="claim_category_id" place-holder="">
				<option value=""></option>
			</select>
		</div>

		<div class="col-3">
			<fieldset class="form-group ">
				<input type="text" name="claim_date_start" data-post="tanggal_awal" class="form-control filter-control pickadate-start dashboard-filter" placeholder="Waktu Dari">
			</fieldset>
		</div>
		<div class="col-3">
			<fieldset class="form-group">
				<input type="text" name="claim_date_end" data-post="tanggal_akhir" class="form-control filter-control pickadate-end dashboard-filter" placeholder="Waktu Sampai">
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
			<div id="claim_no-chart-data" class="row" style="display:none">
				<div class="col-12 text-center" style="color:red;font-size:.85em">
					no data to render chart
				</div>
			</div>
			<div class="row align-bottom">
				<div class="col-4 align-bottom">

					<canvas id="claim_chart-count" width="auto" height="auto"></canvas>

				</div>
				<div class="col-4 align-bottom">

					<canvas id="claim_chart-value" width="auto" height="auto"></canvas>

				</div>
				<div class="col-4 align-bottom">

					<canvas id="claim_chart-type" width="auto" height="auto"></canvas>

				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="card card-custom {{ @$class }}">
				{{-- Body --}}
				<div class="card-body pt-4 table-responsive" >
					<table class="table data-thumb-view table-striped" id="claim_listTables">
					<thead>
						<tr>
							<th>No</th>
							<th>No Tiket</th>
							<th>Lokasi</th>
							<th>Tanggal Pelaporan</th>
							<th>Tipe Claim</th>
							<th>Service Provider</th>
							<th>Nilai Diajukan</th>
							<th>Nilai Dibayarkan</th>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>


<script defer>

	window.firstTime = true;

	window.unification = {
		current: 'keluhan',
		claim_activated: false
	}

	window.tabs = document.querySelectorAll('button[tab]');
	tabs.forEach(tab => {
		tab.addEventListener('click', function (event) {
			event.preventDefault();
			let node = event.target;
			if (! node.classList.contains('active')) {
				tabs.forEach(tab => {
					if (tab.classList.contains('active')) {
						tab.classList.remove('active');
						document.querySelectorAll(".dashboard-"+ tab.getAttribute('tab')).forEach(target => {
							target.style.display = "none";
						});
					}
				});
				node.classList.add('active');
				document.querySelectorAll(".dashboard-"+ node.getAttribute('tab')).forEach(target => {
					target.style.display = "";
				});
				unification.current = node.getAttribute('tab');
				$('#dashscope').val(unification.current);
				if (unification.current == 'claim') {
					if (! unification.claim_activated) {
						console.log('## '+unification.current+': Activating');
						unification.claim_activated = true;
						loadList([
							{ data:'DT_RowIndex', name:'DT_RowIndex', searchable: false, orderable: false  },
							{ data:'no_tiket', name:'no_tiket' },
							{ data:'lokasi_kejadian', name:'lokasi_kejadian' },
							{ data:'tanggal_pelaporan', name:'tanggal_pelaporan' },
							{ data:'tipe_claim', name:'tipe_claim' },
							{ data:'service_provider', name:'service_provider' },
							{ data:'nilai_claim_diajukan', name:'nilai_claim_diajukan' },
							{ data:'nilai_claim_dibayarkan', name:'nilai_claim_dibayarkan' },
							{ data:'status', name:'status' },
						],[
						{
						extend: 'excelHtml5',
						text: "<i class='flaticon2-file'></i>Export Claim</a>",
						className: "btn buttons-copy btn btn-light-success font-weight-bold mr-2 buttons-html5",
						title: 'JMACT - Data Claim',
						exportOptions: {
							// columns: ':not(:last-child)',
						}
						}], '#claim_listTables', function (row, data, index) {
							// console.log({data});
							let columns = {
								'nilai_claim_diajukan':6,
								'nilai_claim_dibayarkan':7
							};
							Object.keys(columns).forEach(key => {
								let col = columns[key];
								let num = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(data[key]).replace('Rp', "").replace(',00', "");
								$('td', row).eq(col).text(num);
							});
						});
						dashboard.filters.category.fillup();
					}
				}
			}
		})
	});

	let keluhan_updateChartSummary = function(data) {
		console.log('## Keluhan: Update Chart Summary', {data});

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
				var value = (((typeof data['statistic'] === 'undefined')) || (typeof data.statistic[name] === 'undefined')) ? 0 : data.statistic[name][key];
				chartValues[key].push(value);
			})
		})

		var yMin = 0, yMax = 0;

		$.each(chartBars, function(key, item) {
			var dataset = {
				label: item.label,
				data: chartValues[key],
				borderColor: item.color,
				backgroundColor: item.color
			}
			if (Math.min(...chartValues[key]) < yMin) yMin = Math.min(...chartValues[key]);
			if (Math.max(...chartValues[key]) > yMax) yMax = Math.max(...chartValues[key]);
			chartData.datasets.push(dataset);
		})

		// console.log({chartData});

		var ctx = document.getElementById('keluhan_chart-summary').getContext('2d');

		var myChart = new Chart(ctx, {
			type: 'bar',
			plugins: [ChartDataLabels],
			data: chartData,
			options: {
				responsive: true,

				scales: {
					y: {
						min: yMin,
						max: yMax,
						ticks: {
							stepSize: Math.ceil(yMax / 4)
						}
					}
				},

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
						text: ''	// Status Pengerjaan Regional'
					}
				}
			}
		});

	}

	let keluhan_loadChartSummary = function() {

		let url = "lookup/data/chart/summary";
		console.log('## Keluhan: Load Chart Summary @ '+url);
		$.post( url, { "_token": "{{ csrf_token() }}" }, function(resp) {
			// success
		})
		.done(function(resp) {
			if (resp.status=='ok') {
				keluhan_updateChartSummary(resp.data);
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

	window.keluhan_charts = {};

	let keluhan_updateChart = function(name, filters, stage = 0, data = {}, type = 'bar') {
		console.log('## Keluhan: Update Stage #'+stage+' Chart "'+name+'"', {filters:filters, data:data});

		var chartName = 'keluhan_chart-'+name;

		if (typeof window.keluhan_charts[chartName] !== 'undefined') {
			window.keluhan_charts[chartName].destroy();
			delete window.keluhan_charts[chartName];
		}

		if (stage == 0) {
			let url = "lookup/data/chart/"+name;
			let params = { '_token': "{{ csrf_token() }}", 'filters': filters };
			console.log('## Keluhan: POST '+url, {params});
			$.post(url, params, function(resp) {
				// success
			})
			.done(function(resp) {
				if (resp.status=='ok') {
					keluhan_updateChart(resp.name, resp.filters, 1, resp.data, resp.type);
				}
			})
			.fail(function(resp) { console.log("## Keluhan: POST Error", resp); });

		} else if (stage == 1) {

			if (Object.entries(data).length == 0) {
				$('#keluhan_no-chart-data').show();
				$(document.getElementById(chartName)).hide();
				console.log('## Keluhan: Data empty => hide chart-'+name+' canvas');
			} else {
				$('#keluhan_no-chart-data').hide();
				$(document.getElementById(chartName)).show();
				console.log('## Keluhan: Data available => show chart-'+name+' canvas');

				var maxValue = Math.max.apply(Math, Object.values(data[name]));

				var iColor = 0;
				var datasets = [];

				$.each(data[name], function(label, value) {
					var colorRef = "";
					switch (name) {
						case 'area':
							colorRef = $('#keluhan_categorySelector').children("option:selected").val()=='ruas' ? ("Chart Area "+$('#keluhan_category_id').children("option:selected").text()) : ("Chart Area "+$('#keluhan_category_id').children("option:selected").text()+" - "+label);
							break;
						case 'source':
							colorRef = ("Chart Source "+label);
							break;
						case 'sector':
							colorRef = ("Chart Sector "+label);
							break;
					}

					var color = typeof appVars[colorRef] !== 'undefined' ? appVars[colorRef] : "RGBA(0,0,0,0.1)";
					if (typeof appVars[colorRef] === 'undefined') console.log ('!! Keluhan ERROR: No color for "'+ colorRef + '"')
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
							title = $('#keluhan_categorySelector').children("option:selected").text() +' '+ $('#keluhan_category_id').children("option:selected").text();
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

				if (oChart) window.keluhan_charts[chartName] = oChart;
			}

		}
	}

	let keluhan_checkFilters = function() {
		let filters = {};
		let category = $('#keluhan_categorySelector').val();

		if (category.length > 0) filters['keluhan_category'] = category;

		$('.keluhan_dashboard-filter-chart').each(function () {
			if (this.value.trim().length > 0) filters[this.name] = this.value;
		});

		let filterCount = Object.keys(filters).length;

		console.log("## Filter: "+filterCount, {filters});
		console.log("## #keluhan_category_id", $('#keluhan_category_id').val());

		if (filterCount == 4) {
			filters['scope'] = unification.current;
			console.log('## Applying filters');
			keluhan_updateChart('area', filters);
			keluhan_updateChart('source', filters);
			keluhan_updateChart('sector', filters);
			if (! firstTime) {
				console.log('## re-draw table');
				$('#keluhan_listTables').DataTable().ajax.reload();
			}
		}

		if (firstTime) {
			firstTime = false;
			loadList([
				{ data:'DT_RowIndex', name:'DT_RowIndex', searchable: false, orderable: false  },
				{ data:'no_tiket', name:'no_tiket' },
				{ data:'sumber_id', name:'sumber_id' },
				{ data:'lokasi_kejadian', name:'lokasi_kejadian' },
				{ data:'tanggal_pelaporan', name:'tanggal_pelaporan' },
				{ data:'bidang_id', name:'bidang_id' },
				{ data:'golongan_id', name:'golongan_id' },
				{ data:'nama_cust', name:'nama_cust' },
				{ data:'no_telepon', name:'no_telepon' },
				{ data:'sosial_media', name:'sosial_media' },
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
			}], '#keluhan_listTables');
		}
	}


	window.testdata = {
		"count": {
			"data": [
				{
					"name": "Representative Office 1",
					"total": 1
				}
			],
			"title": "Jumlah Claim"
		}
	}

	window.charting = {
		bar: function(canvasName, title, datasets, maxValue) {
			let ctx = document.getElementById(canvasName).getContext('2d');
			let data = { labels: [], datasets: datasets };
			data.labels.push(title);

			if (maxValue<1) maxValue = 1;

			let oChart = new Chart(ctx, {
				type: 'bar',
				// plugins: [ChartDataLabels],
				data: data,
				options: {
					"animation": {"duration": 1, "onComplete": function() { console.log('## Chart rendered', this); }},
					showDatapoints: true,
					responsive: true,
					scales: { y: { max: (maxValue), ticks: { stepSize: Math.ceil((maxValue) / 4) } } },
					interaction: { mode: 'index' },
					// layout: { padding: { top: 25 } },
					plugins: {
						datalabels: {
							display: false,
							anchor: 'end', // remove this line to get label in middle of the bar
							align: 'end',
							// formatter: (val) => (`${val} Keluhan`),
							labels: { value: { color: '#000' } }
						},
						legend: { display: false, position: 'right' },
						title: { display: false }
					}
				}
			});

			return oChart;
		}
	}

	window.dashboard = {
		charts: {
			instances: [],
			// params: {
			// 	claim: {
			// 		count: {
			// 			title: "Jumlah Claim"
			// 		}
			// 	}
			// },
			draw: {
				keluhan: function(resp) {
					console.log('## Draw Keluhan Charts', {resp});
				},
				claim: function(resp) {
					console.log('## Draw Claim Charts', {resp});

					let prefix = '#'+unification.current+'_';

					$.each(resp.charts, function(name, detail) {
						let datasets = [];
						// console.log(name, {detail});

						if ((typeof dashboard.charts.instances[unification.current] !== 'undefined') && (typeof dashboard.charts.instances[unification.current][name] !== 'undefined')) {
							dashboard.charts.instances[unification.current][name].destroy();
							delete dashboard.charts.instances[unification.current][name];
						}

						let max = 0;
						$.each(detail.data, function(index, item) {
							// console.log(item.name, ">>>", item.value);
							let colorRef = "";
							switch (name) {
								case 'count':
								case 'value':
									colorRef = $(prefix+'categorySelector').children("option:selected").val()=='ruas' ? ("Chart Area "+$(prefix+'category_id').children("option:selected").text()) : ("Chart Area "+$(prefix+'category_id').children("option:selected").text()+" - "+item.name);
									break;
								case 'type':
									colorRef = "Chart Claim Type "+item.name;
									break;
								default:
									colorRef = (item.name);
									break;
							}

							let color = typeof appVars[colorRef] !== 'undefined' ? appVars[colorRef] : "RGBA(0,0,0,0.1)";
							if (typeof appVars[colorRef] === 'undefined') console.log ('!! Keluhan ERROR: No color for "'+ colorRef + '"')

							if (item.value > max) max = item.value;

							// BAR
							let dataset = {};
							let values = [];
							values.push(item.value == null ? 0 : item.value);
							dataset['label'] = item.name;
							dataset['data'] = values;
							dataset['borderColor'] = color;
							dataset['backgroundColor'] = color;
							datasets.push(dataset);
						})

						if (typeof dashboard.charts.instances[unification.current] === 'undefined') dashboard.charts.instances[unification.current] = [];
						console.log('>>>claim_chart-'+name, detail.title, datasets, max);
						if (datasets.length > 0) dashboard.charts.instances[unification.current][name] = charting.bar('claim_chart-'+name, detail.title, datasets, max);
					});

/*

					return;

					var name = "count";
					var chartName = 'claim_chart-'+name;

					if (typeof dashboard.charts.instances[chartName] !== 'undefined') {
						dashboard.charts.instances[chartName].destroy();
						delete dashboard.charts.instances[chartName];
					}
					if (Object.entries(resp.data).length == 0) {
						$(prefix+'no-chart-data').show();
						$('#'+chartName).hide();
						console.log('## '+unification.current+': Data empty => hide '+chartName+' canvas');
					} else {
						$(prefix+'no-chart-data').hide();
						$('#'+chartName).show();
						console.log('## '+unification.current+': Data available => show '+chartName+' canvas');

						var maxValue = Math.max.apply(Math, Object.values(resp.data[name]));

						var datasets = [];

						$.each(data[name], function(label, value) {
							var colorRef = "";
							switch (name) {
								case 'area':
									colorRef = $('#keluhan_categorySelector').children("option:selected").val()=='ruas' ? ("Chart Area "+$('#keluhan_category_id').children("option:selected").text()) : ("Chart Area "+$('#keluhan_category_id').children("option:selected").text()+" - "+label);
									break;
								case 'source':
									colorRef = ("Chart Source "+label);
									break;
								case 'sector':
									colorRef = ("Chart Sector "+label);
									break;
							}

							var color = typeof appVars[colorRef] !== 'undefined' ? appVars[colorRef] : "RGBA(0,0,0,0.1)";
							if (typeof appVars[colorRef] === 'undefined') console.log ('!! Keluhan ERROR: No color for "'+ colorRef + '"')
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
									title = $('#keluhan_categorySelector').children("option:selected").text() +' '+ $('#keluhan_category_id').children("option:selected").text();
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

						if (oChart) window.keluhan_charts[chartName] = oChart;
					}

*/

				}
			}
		},
		filters: {
			check: function() {
				console.log('## '+unification.current+': Check filters');

				let prefix = '#'+unification.current+'_';
				let filters = {};
				let category = $(prefix+'categorySelector').val();

				if (category.length > 0) filters[unification.current+'_category'] = category;

				$('.dashboard-filter').each(function () { if (this.value.trim().length > 0) filters[this.name] = this.value; });

				let count = Object.keys(filters).length;
				console.log("## Filter: "+count, {filters});

				if (count == 4) {
					filters['scope'] = unification.current;
					console.log('## '+unification.current+': Applying filters');
					// TODO: Update Charts

					let url = "lookup/data/chart/dashboard";
					let params = { '_token': "{{ csrf_token() }}", 'filters': filters };
					console.log('## '+unification.current+': POST '+url, {params});
					$.post(url, params, function(resp) { /* what should we do now */ })
					.done(function(resp) {
						if (resp.status=='ok') {
							// resp.name, resp.filters, resp.data, resp.type
							let f = window['dashboard']['charts']['draw'][unification.current];
							if (typeof f === 'function') f(resp);
						} else console.log("## Response Error", resp);
					})
					.fail(function(resp) { console.log("## POST Error", resp); });


					console.log('## '+unification.current+': Redraw table');
					$(prefix+'listTables').DataTable().ajax.reload();
				}

			},
			category: {
				fillup: function() {
					let prefix = '#'+unification.current+'_';
					let category = $(prefix+'categorySelector').children("option:selected").val();
					let target = $(prefix+'category_id');
					let placeholder = $(prefix+'category_id').next().find('span.select2-selection__placeholder');
					console.log('## '+unification.current+': Fillup Category "'+category);
					$(prefix+'category_id').empty();
					$(placeholder).text('Memuat data..');
					let url = "lookup/area/"+category;
					let params = { '_token': "{{ csrf_token() }}" };
					console.log('## '+unification.current+': POST '+url, {params});
					$.post(url, params, function(resp) { /* what should we do now */ })
					.done(function(resp) {
						if (resp.status=='ok') {
							let prefix = '#'+unification.current+'_';
							let target = $(prefix+'category_id');
							let placeholder = $(target).next().find('span.select2-selection__placeholder');
							$.each(resp.data, function (id, text) {
								$(target).append($('<option>', { value: id, text: text }));
							});
							$(placeholder).text('Pilih '+$(prefix+'categorySelector').children("option:selected").text());
							dashboard.filters.check();
						} else console.log("## Response Error", resp);
					})
					.fail(function(resp) { console.log("## POST Error", resp); });
				}
			}
		}
	}

	let keluhan_fillCategory = function() {
		let category = $('#keluhan_categorySelector').children("option:selected").val();
		let category_id = $('#keluhan_category_id');
		let placeholder = $(category_id).next().find('span.select2-selection__placeholder');
		
		console.log('## Keluhan: Fill Category', category);

		$("#keluhan_category_id").empty();
		// $('#category_id').append($('<option>', { value: "", text: "" }));

		$(placeholder).text('Memuat data..');

		$.post( "lookup/area/"+category, { "_token": "{{ csrf_token() }}" }, function(resp) {
			// success
		})
		.done(function(resp) {
			if (resp.status=='ok') {


				let category_id = $('#keluhan_category_id');
				let placeholder = $(category_id).next().find('span.select2-selection__placeholder');
				
				let records = resp.data;
				$.each(records, function (id, text) {
					$('#keluhan_category_id').append($('<option>', { value: id, text: text }));
				});

				$(placeholder).text('Pilih '+$('#keluhan_categorySelector').children("option:selected").text());
				keluhan_checkFilters();
			}
		})
		.fail(function(resp) { console.log("## Keluhan: POST Error", resp); });
	}

	// const placeholderUpdateDelay = 1500;

	$(document).ready(function () {
		keluhan_loadChartSummary();

		keluhan_fillCategory();
		$('#keluhan_categorySelector').on('change', keluhan_fillCategory);
		$('.keluhan_dashboard-filter-chart').on('change', function () {
			keluhan_checkFilters();
		})
		$('input[name="keluhan_date_start"').val((new Date()).toISOString().slice(0, -17)+'-01');
		$('input[name="keluhan_date_end"').val((new Date()).toISOString().slice(0, -14));

		//////////

		$('input[name="claim_date_start"').val((new Date()).toISOString().slice(0, -17)+'-01');
		$('input[name="claim_date_end"').val((new Date()).toISOString().slice(0, -14));

		$('.dashboard-selector').on('change', dashboard.filters.category.fillup);
		$('.dashboard-filter').on('change', dashboard.filters.check);

		@if (session()->pull('ndt_alert', false))
			alert("Mohon maaf, device yang Anda gunakan tidak mendukung sistem notifikasi otomatis.");
		@endif

	});
</script>

@endsection