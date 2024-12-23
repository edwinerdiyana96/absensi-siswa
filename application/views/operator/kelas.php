<!-- Begin Page Content -->
<?php
$guru = $this->Admin_model->getTotalGuru();
$siswa = $this->Admin_model->getAllSiswa();
$guru1 = $this->Admin_model->getTotalGuru()->result_array();
$siswa1 = $this->Admin_model->getAllSiswa()->result_array();
$siswa2 = $this->Admin_model->getAllSiswa()->result_array();

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
							<th scope="col">Status Kelas</th>
							<th scope="col">Kode Group</th>
							<th scope="col">Chat Id Telegram</th>
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
			"scrollX": true,
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
					"data": "status"
				},
				{
					"data": "kode_group"
				},
				{
					"data": "chat_id"
				},
				{
					"data": "class_id",
					"render": function(data, type, row, meta) {
						// return '<a href="show/' + data + '">Show</a>';
						var konfirmasi = "confirm('Apakah anda Yakin?')";
						// return '<a href="' + '< ?= base_url(); ?>operator/editKelas/' + data + '" class="btn btn-primary">EDIT</a>' +
						// 		' ' +
						// 		'<a href="' + '< ?= base_url(); ?>operator/deleteKelas/' + data + '" class="btn btn-danger" onclick="return ' + konfirmasi + '">HAPUS</a>';
						return '' +
							// '< ?php foreach ($data_kelas as $dk) : ?>'
							// +

							'<a href="' + '<?= base_url(); ?>operator/kelas/pkl/' + data + '" class="btn btn-success" onclick="return ' + konfirmasi + '">PKL</a> '
							// + 
							// '< ?php endforeach; ?>'
							+
							'<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editKelas" href="" data-class_id="' + data + '">EDIT</a> ' +
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
						<label for="nama" class="col-sm-12 control-label">Masukan Nama Kelas (Contoh: X TKJ 1) </label>
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
						<label for="group_id" class="col-sm-12 control-label">Kode Group </label>
						<input type="text" class="form-control" id="group_id" name="kode_group" placeholder="Kode Group">
					</div>
					<div class="form-group">
						<label for="chat_id" class="col-sm-12 control-label">Chat Id </label>
						<input type="text" class="form-control" id="chat_id" name="chat_id" placeholder="Kode Group">
					</div>
					<!-- <div class="form-group">
						<label for="km" class="col-sm-12 control-label">Ketua Kelas</label> -->
					<input type="hidden" class="form-control" name="km" value="0">
					<!-- <select class="form-control" name="km">
							<Option value="" selected> --- Pilih Ketua Kelas --- </Option>
							< ?php foreach ($siswa->result_array() as $siswa) :
							?>
								<Option value="< ?= $siswa['id'] ?>"> < ?= $siswa['name'] ?> (< ?= $siswa['class_name'] ?>)</Option>
							< ?php endforeach; ?>
						</select> -->
					<!-- </div> -->
					<!-- 					
					<div class="form-group">
						<label for="wakil" class="col-sm-12 control-label">Wakil Ketua</label> -->
					<input type="hidden" class="form-control" name="wakil" value="0">
					<!-- <select class="form-control" name="wakil">
							<Option value="" selected> --- Pilih Ketua Kelas --- </Option>
							< ?php foreach ($siswa2 as $siswa2) :
							?>
								<Option value="< ?= $siswa2['id'] ?>"> < ?= $siswa2['name'] ?> (< ?= $siswa2['class_name'] ?>)</Option>
							< ?php endforeach; ?>
						</select> -->
					<!-- </div> -->

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
	$(document).ready(function() {
		$('#editKelas').on('show.bs.modal', function(e) {
			var class_id = $(e.relatedTarget).data('class_id');
			$.ajax({
				type: 'post',
				url: '<?= base_url('Ajax/AjaxKelas/') ?>' + class_id, //Here you will fetch records 
				data: 'class_id=' + class_id, //Pass $id
				success: function(data) {
					$('.fetched-data').html(data); //Show fetched data from database
				}
			});
		});
	});
</script>