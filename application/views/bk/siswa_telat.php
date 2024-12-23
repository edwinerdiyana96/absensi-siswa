<?php
$nama_siswa = $this->db->query("SELECT * FROM user WHERE id = '" . $user_id . "'")->row_array();
?>

<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">

	<!-- Page Heading -->
	<!-- <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1> -->

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary "><?= $title ?></h6>
		</div>

		<div class="card-body">
			<?= $this->session->flashdata('message'); ?>

			<div class="responsive">
				<table class="table table-striped table-bordered" id="table-student_attendance" style="width:100%;">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Waktu</th>
							<th scope="col">Status</th>
							<th scope="col">Keterangan</th>
							<th scope="col">Aksi</th>
							<!-- <th scope="col">Aksi</th> -->
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

		</div>

	</div>
</div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- DataTable Content -->
<script>
	var tabel = null;
	$(document).ready(function() {
		tabel = $('#table-student_attendance').DataTable({
			"processing": true,
			// "responsive": true,
      		"scrollX": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[0, 'asc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				"url": "<?= base_url('bk/data_student_attendance'); ?>", // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 50, 100],
				[10, 50, 100]
			], // Combobox Limit
			"columns": [{
					"data": 'attendance_id',
					"sortable": false,
					render: function(data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{
					"data": "name"
				}, // Tampilkan kategori
				{
					"data": "date"
				}, // Tampilkan nama sub kategori
				{
					"data": "time"
				},
				{
					"data": "status",
					"render": function(data, type, row, meta) {
						if (data == '0') {
							return '<span class="badge badge-pill badge-danger">Belum Absen</span>';
						} else if (data == '1') {
							return '<span class="badge badge-pill badge-success">Hadir Tepat Waktu</span>';
						} else if (data == '2') {
							return '<span class="badge badge-pill badge-warning">Hadir Terlambat</span>';
						} else if (data == '3') {
							return '<span class="badge badge-pill badge-info">Sakit</span>';
						} else if (data == '4') {
							return '<span class="badge badge-pill badge-primary">Izin</span>';
						} else {
							return '<span class="badge badge-pill badge-danger">Alfa</span>';
						}
					}
				},
				{
					"data": "description"
				},

				{
					"data": "id",
					"render": function(data, type, row, meta) {
						return '' +
							'<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#detailSiswa" href="" data-id="' + data + '">DETAIL</a>'
					}
				},

				// {
				//     "data": "gender",
				//     "render": function(data, type, row, meta) {
				//         if (data == '0') {
				//             return 'Laki-laki';
				//         } else {
				//             return 'Perempuan';
				//         }
				//     }
				// },

				// {
				// 	"data": "attendance_id",
				// 	"render": function(data, type, row, meta) {
				// 		// return '<a href="show/' + data + '">Show</a>';
				// 		return '<a href="' + '< ?= base_url(); ?>bk/update/' + data + '" class="btn btn-warning"> UPDATE </a>' +
				// 			' ' + ' ' +
				// 			'<a href="#view_detail" class="btn btn-info"> DETAIL </a>'
				// 	}
				// },
			],
		});
	});
</script>

<!-- Modal Edit Ruangan -->
<div class="modal fade" id="detailSiswa" tabindex="-1" role="dialog" aria-labelledby="detailSiswa" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <h5 class="modal-title" id="addRoleModelLabel">INFORMASI SISWA: < ?= strtoupper($nama_siswa['name']) ?></h5> -->
				<span class="badge badge-pill badge-primary"><h5 class="modal-title" id="judul" style="width: 100%; display: inline-block; text-align: center;"></h5></span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('bk/index/edit') ?>" method="POST">
				<div class="modal-body">

					<!-- Isi Modal Fetch Data -->
					<div class="fetched-data"></div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
					<!-- <button type="submit" class="btn btn-primary">UPDATE</button> -->
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#detailSiswa').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('id');
			$.ajax({
				type: 'post',
				url: '<?= base_url('Ajax/AjaxDetailSiswa/') ?>' + id, //Here you will fetch records 
				data: 'id=' + id, //Pass $id
				success: function(data) {
					$('.fetched-data').html(data); //Show fetched data from database
				}
			});

			$.ajax({
				type: 'post',
				url: '<?= base_url('Ajax/AjaxJudulDetailSiswa/') ?>' + id, //Here you will fetch records 
				data: 'id=' + id, //Pass $id
				success: function(data) {
					$('#judul').html(data); //Show fetched data from database
				}
			});
		});
	});
</script>
