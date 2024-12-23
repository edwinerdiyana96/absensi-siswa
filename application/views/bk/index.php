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
				<table class="table table-striped table-bordered " id="table-student_attendance" style="width:100%;">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Waktu</th>
							<th scope="col">Status</th>
							<th scope="col">Keterangan</th>
							<th scope="col">Aksi</th>
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

				{
					"data": "attendance_id",
					"render": function(data, type, row, meta) {
						return ''
					+
					'<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editDataKehadiran" href="" data-attendance_id="' + data + '">EDIT</a>'
					
					}
				},
			],
		});
	});
</script>

<!-- Modal Edit Ruangan -->
<div class="modal fade" id="editDataKehadiran" tabindex="-1" role="dialog" aria-labelledby="editDataKehadiranLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRoleModelLabel">Update Data Kehadiran</h5>
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
						<button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
						<button type="submit" class="btn btn-primary">UPDATE</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#editDataKehadiran').on('show.bs.modal', function (e) {
				var attendance_id = $(e.relatedTarget).data('attendance_id');
				$.ajax({
					type : 'post',
            url : '<?= base_url('Ajax/AjaxDataKehadiran/')?>'+attendance_id, //Here you will fetch records 
            data :  'attendance_id='+ attendance_id, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
        }
    });
			});
		});
	</script>
