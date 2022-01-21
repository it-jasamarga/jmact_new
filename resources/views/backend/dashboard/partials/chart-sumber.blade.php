<script>
	// $(document).ready(function(){
	// 	loadChartSumber();
	// });

	// $(document).on('change','.filter-chart-sumber',function(){
	// 	loadChartSumber();
	// });

	function loadChartSumber(){
		var array = [];
		$('.filter-chart-sumber').each(function(idx, el) {
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

		var labels = ['Belmera'];
		var data = {
		  labels: labels,
		  datasets: [
		    {
		      label: 'Instagram',
		      data: [45],
		      borderColor: '#0b4ba1',
		      backgroundColor: '#0b4ba1',
		    },
		    {
		      label: 'Faceboook',
		      data: [55],
		      borderColor: '#1BC5BD',
		      backgroundColor: '#1BC5BD',
		    }
		  ]
		};
		var ctx = document.getElementById('chart-sumber').getContext('2d');
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
						text: 'Sumber'
					}
				}
			}
		});
</script>