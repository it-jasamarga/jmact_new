<script>
	$(document).ready(function(){
		loadChartStatusPengerjaan();
	});

	$(document).on('change','.filter-chart-status-pengerjaan',function(){
		loadChartStatusPengerjaan();
	});

	function loadChartStatusPengerjaan(){
		var array = [];
		$('.filter-chart-status-pengerjaan').each(function(idx, el) {
	        var name = $(el).data('post');
	        var val = $(el).val();
	        array[name] = val;
	    });
	    console.log('array',array)
	  
		$.ajax({
			url: "{{ route('dashboard.chart1') }}",
            type: 'POST',
            data: {
                '_method' : 'POST',
                '_token' : '{{ csrf_token() }}',
                'data' : array
            },
            success: function (resp) {
            	console.log('resp',resp)
            },
            error: function (resp) {
            }
		});
	}

	var DATA_COUNT = 7;
		var NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

		var labels = ['Januari', 'Febuari'];
		var data = {
		  labels: labels,
		  datasets: [
		    {
		      label: 'Overtime',
		      data: [45,50],
		      borderColor: 'red',
		      backgroundColor: 'red',
		    },
		    {
		      label: 'On Progress',
		      data: [55,23],
		      borderColor: 'yellow',
		      backgroundColor: 'yellow',
		    },
		    {
		      label: 'On Time',
		      data: [55,23],
		      borderColor: 'blue',
		      backgroundColor: 'blue',
		    }
		  ]
		};
		var ctx = document.getElementById('chart-status-pengerjaan').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: data,
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'right',
						align: 'middle'
					},
					title: {
						display: true,
						text: 'Status Pengerjaan'
					}
				}
			}
		});
</script>