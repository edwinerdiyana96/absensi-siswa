<!-- Begin Page Content -->
<?php
$guru = $this->Admin_model->getTotalGuru();
$siswa = $this->Admin_model->getAllSiswa();
$guru1 = $this->Admin_model->getTotalGuru()->result_array();
$siswa1 = $this->Admin_model->getAllSiswa()->result_array();

$mapel = $this->db->query("SELECT * FROM student_lessons WHERE mapel_id = '" . $lessons_id . "'")->row_array();

// foreach ($data_kelas as $dk) :
//  $class_id = $dk['class_id'];
//  $class    = $dk['class'];
//  $wk       = $dk['homeroom_teacher'];
//  $km       = $dk['class_leader'];
//  $grade    = $dk['grade'];
// endforeach;
?>
<div class="container-fluid dashboard-atas">


	<div class="card shadow mb-12">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary ">DATA GURU <?= strtoupper($mapel['lessons']) ?></h6>
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
					<div class="col-md-4 mb-2">
						<button class="btn btn-info  btn-icon-split" data-toggle="modal" data-target="#addNewUser">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Guru</span>
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
							<span class="text">Tambah Guru</span>
						</button>
					</div>
				</div>
			</div>
			<br>

			<div class="responsive">
				<table class="table table-striped table-bordered " id="table-kelas" style="width:100%;">
					<thead class="text-primary">
						<tr>
							<th scope="col">No</th>
							<!-- <th scope="col">Nama</th> -->
							<th scope="col">Nama Guru</th>
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
	var lessons_id = '<?= $lessons_id ?>';
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
				"url": "<?= base_url('operator/data_mapel_guru/'); ?>" + lessons_id, // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 50, 100],
				[10, 50, 100]
			], // Combobox Limit
			"columns": [{
					"data": 'id',
					"sortable": false,
					render: function(data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				// {
				//  "data": "name"
				// }, 
				{
					"data": "name"
				},
				{
					"data": "grade"
				},
				{
					"data": "teacher_lessons_id",
					"render": function(data, type, row, meta) {
						// return '<a href="show/' + data + '">Show</a>';
						var konfirmasi = "confirm('Apakah anda Yakin?')";
						return '<a href="' + '<?= base_url(); ?>operator/delete_guru_mapel/' + data + '" class="btn btn-danger" onclick="return ' + konfirmasi + '">HAPUS</a>';
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
				<h5 class="modal-title" id="addRoleModelLabel">Tambah Guru Mapel</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('operator/add_mapel_guru') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" class="form-control" id="lesson" name="lesson_id" value="<?= $lessons_id ?>">
					</div>
					<div class="form-group">
						<label for="wali" class="col-sm-12 control-label">Nama Guru</label>
						<select class="form-control" name="guru">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value="" selected> --- Pilih Guru --- </Option>
							<?php foreach ($guru->result_array() as $guru) :
							?>
								<Option value="<?= $guru['id'] ?>"> <?= $guru['name'] ?></Option>
							<?php endforeach; ?>
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