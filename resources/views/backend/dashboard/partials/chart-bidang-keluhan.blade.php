<script>
	// $(document).ready(function(){
	// 	loadChartBidangKeluhan();
	// });

	// $(document).on('change','.filter-chart-bidang-keluhan',function(){
	// 	loadChartBidangKeluhan();
	// });

	const sectors = ['Transaksi','Lalin','Konstruksi','Konstruksi','Iklan'];

	var data = {
		labels: sectors,
		datasets: [{
			label: 'My First Dataset',
			data: [300, 50, 100, 25, 118],
			backgroundColor: [
				'rgb(255, 99, 132)',
				'rgb(54, 162, 235)',
				'rgb(255, 205, 86)',
				'rgb(255, 86, 205)',
				'rgb(86, 255, 205)'
			],
			hoverOffset: 4
		}]
	};

	var ctx = document.getElementById('chart-bidang-keluhan').getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: data,
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
</script>