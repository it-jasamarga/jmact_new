<script>
	$(document).ready(function(){
		loadChart1();
	});

	$(document).on('change','.filter-chart1',function(){
		loadChart1();
	});

	function loadChart1(){
		var array = [];
		$('.filter-chart1').each(function(idx, el) {
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

	const DATA_COUNT = 7;
		const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

		const labels = ['Januari', 'Febuari'];
		const data = {
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
		const ctx = document.getElementById('chart-1').getContext('2d');
		const myChart = new Chart(ctx, {
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
						text: 'Chart.js Bar Chart'
					}
				}
			}
		});
</script>