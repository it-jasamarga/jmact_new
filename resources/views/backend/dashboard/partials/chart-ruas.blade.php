<script>
	$(document).ready(function(){
		loadChartRuas();
	});

	$(document).on('change','.filter-chart-ruas',function(){
		loadChartRuas();
	});

	function loadChartRuas(){
		var array = [];
		$('.filter-chart-ruas').each(function(idx, el) {
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
		      label: 'Dataset 1',
		      data: [45,50],
		      borderColor: '#0b4ba1',
		      backgroundColor: '#0b4ba1',
		    },
		    {
		      label: 'Dataset 2',
		      data: [55,23],
		      borderColor: '#1BC5BD',
		      backgroundColor: '#1BC5BD',
		    }
		  ]
		};
		var ctx = document.getElementById('chart-ruas').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: data,
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Ruas'
					}
				}
			}
		});
</script>