<!-- Begin Page Content -->
<?php
$guru = $this->Admin_model->getTotalGuru();
$siswa = $this->Admin_model->getAllSiswa();
$guru1 = $this->Admin_model->getTotalGuru()->result_array();
$siswa1 = $this->Admin_model->getAllSiswa()->result_array();

// foreach ($data_kelas as $dk) :
// 	$class_id = $dk['class_id'];
// 	$class    = $dk['class'];
// 	$wk       = $dk['homeroom_teacher'];
// 	$km       = $dk['class_leader'];
// 	$grade    = $dk['grade'];
// endforeach;
?>
<div class="container-fluid dashboard-atas">

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary "><?= $title ?></h6>
		</div>
		<div class="card-body">
			<?= $this->session->flashdata('message'); ?>
			<div class="row">
				<div class="col-lg-6">
				</div>
			</div>

			<!-- ============================ Display Only On Desktop Mode ============================ -->
			<div class="d-none d-lg-block">
				<div class="row">
					<div class="col-md-4 mb-2">
						<button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#addNewUser">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Kelas Baru</span>
						</button>
					</div>
				</div>
			</div>

			<!-- ============================ Display Only On Mobile Mode ============================ -->
			<div class="d-lg-none">
				<div class="row">
					<div class="col-md-4 mb-2">
						<button class="btn btn-info form-control" data-toggle="modal" data-target="#addNewUser">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Kelas Baru</span>
						</button>
					</div>
				</div>
			</div>

			<br>

			<div class="responsive">
				<table class="table table-striped table-bordered" id="table-kelas" style="width:100%;">
					<thead class="text-primary">
						<tr>
							<th scope="col">No</th>
							<!-- <th scope="col">Nama</th> -->
							<th scope="col">Kelas</th>
							<th scope="col">Wali Kelas</th>
							<th scope="col">Ketua Kelas</th>
							<th scope="col">Total Siswa</th>
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
			<!-- </div> -->
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
			"ScrollX": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[0, 'asc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				"url": "<?= base_url('operator/data_kelas'); ?>", // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 50, 100],
				[10, 50, 100]
			], // Combobox Limit
			"columns": [{
					"data": 'class_id',
					"sortable": false,
					render: function(data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				// {
				// 	"data": "name"
				// }, 
				{
					"data": "class"
				},
				{
					"data": "name"
				},
				{
					"data": "class_leader"
				},
				{
					"data": "grade"
				},
				{
					// foreach ($data_kelas as $dk) :
					// 	$class_id = $dk['class_id'];
					// 	$class    = $dk['class'];
					// 	$wk       = $dk['homeroom_teacher'];
					// 	$km       = $dk['class_leader'];
					// 	$grade    = $dk['grade'];
					// endforeach;
					"data": "class_id",
					"render": function(data, type, row, meta) {
						// return '<a href="show/' + data + '">Show</a>';
						var konfirmasi = "confirm('Apakah anda Yakin?')";
						// return '<a href="' + '< ?= base_url(); ?>operator/editKelas/' + data + '" class="btn btn-primary">EDIT</a>' +
						// 		' ' +
						// 		'<a href="' + '< ?= base_url(); ?>operator/deleteKelas/' + data + '" class="btn btn-danger" onclick="return ' + konfirmasi + '">HAPUS</a>';
						return ''
						+
						// '< ?php foreach ($data_kelas as $dk) : ?>'
						// +
						'<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editKelas" href="" data-class_id="' + data + '" data-class="" data-wk="" data-km="" data-grade="">EDIT</a>'
						// + 
						// '< ?php endforeach; ?>'
						+ 
						' ' 
						+
						'<a href="' + '<?= base_url(); ?>operator/deleteKelas/' + data + '" class="btn btn-danger" onclick="return ' + konfirmasi + '">HAPUS</a>';
					}
				},
			],
		});
	});
</script>

<!-- Modal Add Kelas -->
<div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoleModelLabel">Tambah Kelas Baru</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('operator/kelas/add') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<label for="grade" class="col-sm-12 control-label">Pilih Tingkat</label>
						<select class="form-control" name="grade">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value="X"> X</Option>
							<Option value="XI"> XI</Option>
							<Option value="XII"> XII</Option>
						</select>
					</div>
					<div class="form-group">
						<label for="nama" class="col-sm-12 control-label">Masukan Nama Kelas (Contoh: TKJ 1) </label>
						<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kelas">
					</div>
					<div class="form-group">
						<label for="wali" class="col-sm-12 control-label">Wali Kelas</label>
						<select class="form-control" name="wali">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value="" selected> --- Pilih Wali Kelas --- </Option>
							<?php foreach ($guru->result_array() as $guru) :
							?>
								<Option value="<?= $guru['id'] ?>"> <?= $guru['name'] ?></Option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="km" class="col-sm-12 control-label">Ketua Kelas</label>
						<select class="form-control" name="km">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value="" selected> --- Pilih Ketua Kelas --- </Option>
							<?php foreach ($siswa->result_array() as $siswa) :
							?>
								<Option value="<?= $siswa['id'] ?>"> <?= $siswa['name'] ?> (<?= $siswa['class_name'] ?>)</Option>
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

<!-- Modal Edit Kelas -->
<div class="modal fade" id="editKelas" tabindex="-1" role="dialog" aria-labelledby="editKelasLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editKelasLabel">UPDATE</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action='<?= base_url('operator/updateKelas'); ?>' method="POST">
					<div class="form-group">
						<label for="class_id" class="col-form-label">ID : </label>

						<input type="button" class="class_id btn btn-success" name="class_id" id="class_id" readonly style="margin-left: 5px;">
						<!-- <label for="class" class="col-form-label">Kelas</label>
						<input type="text" class="form-control class" name="class" id="class">
						<label for="wk" class="col-form-label">Wali Kelas</label>
						<input type="text" class="form-control wk" name="wk" id="wk">
						<label for="km" class="col-form-label">Ketua Kelas</label>
						<input type="text" class="form-control km" name="km" id="km">
						<label for="grade" class="col-form-label">Tingkat</label>
						<input type="text" class="form-control grade" name="grade" id="grade"> -->
					</div>
					<div class="form-group">
						<label for="grade" class="col-sm-12 control-label">Tingkat</label>
						<select class="form-control grade" name="grade" id="grade" required>
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<option value="" selected> --- Pilih Tingkat --- </option>
							<option value="X"> X</option>
							<option value="XI"> XI</option>
							<option value="XII"> XII</option>
						</select>
					</div>
					<div class="form-group">
						<label for="class" class="col-sm-12 control-label">Masukan Nama Kelas (Contoh: TKJ 1) </label>
						<input type="text" class="form-control class" name="class" id="class" placeholder="Nama Kelas" required>
					</div>
					<div class="form-group">
						<label for="wk" class="col-sm-12 control-label">Wali Kelas</label>
						<select class="form-control wk" name="wk" id="wk" required>
							<option value="" selected> --- Pilih Wali Kelas --- </option>
							<?php foreach ($guru1 as $gr1) : ?>
								<option value="<?= $gr1['id'] ?>"><?= $gr1['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="km" class="col-sm-12 control-label">Ketua Kelas</label>
						<select class="form-control km" name="km" id="km" required>
							<option value="" selected> --- Pilih Ketua Kelas --- </option>
							<?php foreach ($siswa1 as $sw1) : ?>
								<option value="<?= $sw1['id'] ?>"> <?= $sw1['name'] ?> (<?= $sw1['class_name'] ?>)</option>
							<?php endforeach; ?>
						</select>
					</div>
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
	$('#editKelas').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var class_id = button.data('class_id') // Extract info from data-* attributes
		var class_name = button.data('class') // Extract info from data-* attributes
		var wk = button.data('wk');
		var km = button.data('km');
		var grade = button.data('grade');
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('.modal-title').text('UPDATE KELAS ' + class_name)
		modal.find('.class_id').val(class_id)
		modal.find('.class').val(class_name)
		modal.find('.wk').val(wk)
		modal.find('.km').val(km)
		modal.find('.grade').val(grade)
	})
</script>
