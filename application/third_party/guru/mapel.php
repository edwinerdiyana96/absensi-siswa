<!-- Begin Page Content -->
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<?php
$guru = $this->Admin_model->getTotalGuru();
?>
<div class="container-fluid dashboard-atas">

	<div class="card shadow mb-12">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary "><?= $title ?></h6>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<?= $this->session->flashdata('message'); ?>
				</div>
			</div>

			<!-- ============================ Display Only On Desktop Mode ============================ -->
			<div class="d-none d-lg-block">
				<div class="row">
					<div class="col-md-6 mb-2">
						<button class="btn btn-info  btn-icon-split" data-toggle="modal" data-target="#addNewUser">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Mapel</span>
						</button>
					</div>


					<div class="col-md-6 mb-2">
						<button class="btn btn-primary  btn-icon-split" data-toggle="modal" data-target="#addMapelBaru" style="float: right">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Mata Pelajaran Baru</span>
						</button>
					</div>
				</div>
			</div>

			<!-- ============================ Display Only On Mobile Mode ============================ -->
			<div class="d-lg-none">
				<div class="row">
					<div class="col-md-12 mb-2">
						<button class="btn btn-info form-control" data-toggle="modal" data-target="#addNewUser">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Mapel</span>
						</button>
						<br><br>
						<button class="btn btn-primary form-control" data-toggle="modal" data-target="#addMapelBaru">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Mata Pelajaran Baru</span>
						</button>
					</div>
				</div>
			</div>

			<br>

			<div class="responsive">
				<table class="table table-striped table-bordered" id="table-kelas" style="width:100%;">
					<thead class="text-primary">
						<tr>
							<!-- <th scope="col">No</th> -->
							<!-- <th scope="col">Nama</th> -->
							<th scope="col">Mata Pelajaran</th>
							<th scope="col">Kelas / Angkatan</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>
					<!-- <tfoot class="text-primary">
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Ketua Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot> -->
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>
<!-- DataTable Content -->
<script>
	var tabel = null;
	$(document).ready(function() {
		tabel = $('#table-kelas').DataTable({
			"processing": true,
			// "responsive": true,
			"scrollX": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[0, 'asc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				"url": "<?= base_url('guru/data_mapel/' . $user['id']); ?>", // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 50, 100],
				[10, 50, 100]
			], // Combobox Limit
			"columns": [
				// {
				// 	"data": 'mapel_id',
				// 	"sortable": false,
				// 	render: function(data, type, row, meta) {
				// 		return meta.row + meta.settings._iDisplayStart + 1;
				// 	}
				// },
				// {
				//  "data": "name"
				// }, 
				{
					"data": "lessons"
				},
				{
					"data": "grade"
				},
				{
					"data": "mapel_id",
					"render": function(data, type, row, meta) {
						// return '<a href="show/' + data + '">Show</a>';
						var konfirmasi = "confirm('Apakah anda Yakin?')";
						return '<a href="' + '<?= base_url(); ?>guru/mapel/delete/' + data + '" class="btn btn-danger" onclick="return ' + konfirmasi + '">HAPUS</a>';
					}
				},
			],
		});
	});
</script>




<!-- Modal Add Role -->
<div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoleModelLabel">Tambah Mapel</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('guru/mapel/add') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<select class="form-control" id="mapel" name="mapel" required style="width: 100%; height: 100px;">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<?php
							$mapel = $this->db->query("SELECT student_lessons.* FROM student_lessons WHERE mapel_id != '0' ")->result_array();
							foreach ($mapel as $key => $mapel) {
								$cek = $this->Auth_model->getTeacherLessonsByMapel($user['id'], $mapel['mapel_id'])->num_rows();
								if ($cek == 0) {
									echo '<Option value="' . $mapel['mapel_id'] . '"> ' . $mapel['lessons'] . ' (Kelas : ' . $mapel['grade'] . ')</Option>';
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary form-control">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>



<!-- Modal Add Role -->
<div class="modal fade" id="addMapelBaru" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoleModelLabel">Tambah Mata Pelajaran Baru</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('guru/mapel/add_new') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="lesson" name="lesson" placeholder="Nama Mata Pelajaran">
					</div>
					<div class="form-group">
						<select class="form-control" name="grade" required>
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value="X"> Kelas X</Option>
							<Option value="XI"> Kelas XI</Option>
							<Option value="XII"> Kelas XII</Option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary form-control">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('#mapel').select2({
		minimumInputLength: 3,
		theme: "classic"
	});
</script>