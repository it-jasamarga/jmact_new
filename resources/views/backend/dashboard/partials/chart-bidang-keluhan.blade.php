<script>
	$(document).ready(function(){
		loadChartRuas();
	});

	$(document).on('change','.filter-chart-bidang-keluhan',function(){
		loadChartRuas();
	});

	function loadChartRuas(){
		var array = [];
		$('.filter-chart-bidang-keluhan').each(function(idx, el) {
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

		var labels = ['Januari', 'Februari'];
		var data = {
		  labels: labels,
		  datasets: [
		    {
		      label: 'Dataset 1',
		      data: [45,50],
		      borderColor: '#0b4ba1',
		      backgroundColor: '#0b4ba1',
		    }
		  ]
		};
		var ctx = document.getElementById('chart-bidang-keluhan').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'doughnut',
			data: data,
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Bidang Keluhan'
					}
				}
			}
		});
</script>