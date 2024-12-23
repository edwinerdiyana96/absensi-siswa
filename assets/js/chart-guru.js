var xValues = ["Hadir", "Sakit", "Izin", "Alpha"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["#b91d47", "#00aba9", "#2b5797","#1e7145"];

new Chart("chartGuru", {
	type: "doughnut",
	data: {
		labels: xValues,

		datasets: [
			{
				backgroundColor: barColors,
				data: yValues,
			},
		],
	},
	options: { 
		title: {
			display: true,
			text: "Persentase kehadiran siswa",
			position: "bottom"
		},
		layout: {
			padding: 20,
		},
	},
});
