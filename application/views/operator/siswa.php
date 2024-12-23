<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">

	<!-- Page Heading -->
	<!-- <div class="container-fluid dashboard-atas"> -->

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
					<div class="col-md-7">
						<!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
						<button class="btn btn-info btn-icon-split mb-2" data-toggle="modal" data-target="#addNewUser">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Siswa</span>
						</button>
						<button class="btn btn-success btn-icon-split mb-2" data-toggle="modal" data-target="#excel">
							<span class="icon text-white-50">
								<i class="fas fa-file-excel"></i>
							</span>
							<span class="text">Tambah Siswa By Excel</span>
						</button>
						<button class="btn btn-secondary btn-icon-split mb-2" data-toggle="modal" data-target="#kenaikan">
							<span class="icon text-white-50">
								<i class="fas fa-file-excel"></i>
							</span>
							<span class="text">Kenaikan Tingkat</span>
						</button>
					</div>
					<br><br><br>
					<div class="col-md-5 text-right">
						<form action="<?= base_url('operator/siswa/export') ?>" method="POST">
							<select class="btn btn-outline-danger" name="grade" style="text-align: left;">
								<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
								<Option value="ALL"> Semua Angkatan (Kelas) </Option>
								<Option value="X"> Angkatan Kelas X (10) </Option>
								<Option value="XI"> Angkatan Kelas XI (11) </Option>
								<Option value="XII"> Angkatan Kelas XII (12) </Option>
							</select>
							<button class="btn btn-danger">
								<span class="icon text-white-50">
									<i class="fas fa-file-excel"></i>
								</span>
								<span class="text">Export To Excel</span>
							</button>
						</form>
					</div>
				</div>
			</div>


			<!-- ============================ Display Only On Mobile Mode ============================ -->
			<div class="d-lg-none">
				<div class="row">
					<div class="col-md-12">
						<!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
						<button class="btn btn-info mb-2 form-control" data-toggle="modal" data-target="#addNewUser" style="text-align: left;">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span> &ensp;&ensp;
							<span class="text">Tambah Siswa</span>
						</button><br>
						<button class="btn btn-success mb-2 form-control" data-toggle="modal" data-target="#excel" style="text-align: left;">
							<span class="icon text-white-50">
								<i class="fas fa-file-excel"></i>
							</span> &ensp;&ensp;
							<span class="text">Tambah Siswa By Excel</span>
						</button><br>
						<button class="btn btn-secondary mb-2 form-control" data-toggle="modal" data-target="#kenaikan" style="text-align: left;">
							<span class="icon text-white-50">
								<i class="fas fa-file-excel"></i>
							</span> &ensp;&ensp;
							<span class="text">Kenaikan Tingkat</span>
						</button>
						<br><br>

						<form action="<?= base_url('operator/siswa/export') ?>" method="POST">
							<select class="btn btn-outline-danger form-control mb-2" name="grade" style="text-align: left;">
								<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
								<Option value="ALL"> Semua Angkatan (Kelas) </Option>
								<Option value="X"> Angkatan Kelas X (10) </Option>
								<Option value="XI"> Angkatan Kelas XI (11) </Option>
								<Option value="XII"> Angkatan Kelas XII (12) </Option>
							</select><br>
							<button class="btn btn-danger form-control" style="text-align: left;">
								<span class="icon text-white-50">
									<i class="fas fa-file-excel"></i>
								</span> &ensp;&ensp;
								<span class="text">Export To Excel</span>
							</button>
						</form>
					</div>
				</div>
			</div>
			<!-- </div> -->
			<!-- </div> -->

			<!-- <div class="card-body"> -->
			<div class="responsive">
				<table class="table table-striped table-bordered" id="table-siswa" style="width: 100%;">
					<thead class="text-primary">
						<tr>
							<th scope="col">No</th>
							<th scope="col">NIS</th>
							<th scope="col">Nama</th>
							<th scope="col">Kelas</th>
							<th scope="col">Nomor Hp</th>
							<th scope="col">Jenis Kelamin</th>
							<th scope="col">Status Siswa</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- </div> -->

<!-- </div> -->
<!-- /.container-fluid -->

<!-- </div> -->
<!-- End of Main Content -->

<!-- DataTable Content -->
<script>
	var tabel = null;
	$(document).ready(function() {
		tabel = $('#table-siswa').DataTable({
			"processing": true,
			// "responsive": true,
			"scrollX": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[0, 'asc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				"url": "<?= base_url('operator/data_siswa'); ?>", // URL file untuk proses select datanya
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
				{
					"data": "email"
				}, // Tampilkan kategori
				{
					"data": "name"
				}, // Tampilkan nama sub kategori
				{
					"data": "class_name"
				},
				{
					"data": "phone"
				},
				{
					"data": "gender",
					"render": function(data, type, row, meta) {
						if (data == 'L') {
							return 'Laki-laki';
						} else {
							if (data == 'P') {
								return 'Perempuan';
							} else {
								return '-';
							}
						}
					}
				},
				{
					"data": "is_pkl",
					"render": function(data, type, row, meta) {
						if (data == '1') {
							return '<span class="badge badge-danger">Sedang PKL</span>';
						} else {
							return '<span class="badge badge-success">Normal</span>';
						}
					}
				},
				{
					"data": "id",
					"render": function(data, type, row, meta) {
						// return '<a href="show/' + data + '">Show</a>';
						var konfirmasi = "confirm('Apakah anda Yakin?')";
						return '<a href="' + '<?= base_url(); ?>admin/update_pkl/' + data + '" class="btn btn-success" onclick="return ' + konfirmasi + '">RUBAH STATUS PKL</a>' +
							' ' +
							'<a href="' + '<?= base_url(); ?>admin/editUserProfile/' + data + '" class="btn btn-primary">EDIT</a>' +
							' ' +
							'<a href="' + '<?= base_url(); ?>operator/siswa/delete/' + data + '" class="btn btn-danger" onclick="return ' + konfirmasi + '">HAPUS</a>';
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
				<h5 class="modal-title" id="addRoleModelLabel">Tambah Siswa Baru</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('operator/siswa/add') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<input type="number" class="form-control" id="email" name="nis" placeholder="Nis Siswa" required>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" required>
					</div>
					<div class="form-group">
						<select class="form-control" name="gender">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value="L">Laki - Laki</Option>
							<Option value="P">Perempuan</Option>
						</select>
					</div>
					<div class="form-group">
						<select class="form-control" name="class">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value=""> Pilih Kelas</Option>
							<?php foreach ($class as $r) : ?>
								<Option value="<?= $r['class'] ?>"> <?= $r['class'] ?></Option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="address" name="address" placeholder="Alamat Lengkap" required>
					</div>
					<div class="form-group">
						<input type="number" class="form-control" id="no_hp" name="phone" placeholder="Nomor Telpon" required>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="password" name="password" placeholder="password" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary form-control">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Tambah Kontak Excel -->
<div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header no-bd">
				<h5 class="modal-title">
					<span class="fw-mediumbold">
						Tambah Data Siswa By</span>
					<span class="fw-light">
						Excel
					</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('operator/siswa/excel') ?>" method="POST" enctype='multipart/form-data'>
					<div class="row">
						<div class="col-md-12">

							<div class="alert alert-success" role="alert"> Download Format Excel Upload Data!
								<a href="<?= base_url('assets/uploads/template_siswa.xlsx') ?>" download>
									<button type="button" class="close"><span style="color: gray;" class="fa fa-download"></span></button>
								</a>
							</div>

							<div class="form-group form-group-default">
								<label>File Excel</label>
								<input type="file" class="form-control" placeholder="Data siswa" name="file" required>
								<!-- <input type="hidden" name="id" value="<?= $group['group_id'] ?>"> -->
								<small style="color: red;">* untuk proses upload data besar di usahakan menggunakan format CSV</small>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger">Update Data</button>
				<!-- <button type="button" class="btn " data-dismiss="modal">Close</button> -->
			</div>
			</form>
		</div>
	</div>
</div>



<!-- Modal Tambah Kontak Excel -->
<div class="modal fade" id="kenaikan" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header no-bd">
				<h5 class="modal-title">
					<span class="fw-mediumbold">
						Kenaikan Tingkat</span>
					<span class="fw-light">
					</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('operator/kenaikan') ?>" method="POST" enctype='multipart/form-data'>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="grade" class="col-sm-12 control-label">Pilih Tingkat</label>
								<select class="form-control" name="grade">
									<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
									<Option value="X"> X</Option>
									<Option value="XI"> XI</Option>
									<Option value="XII"> XII</Option>
								</select>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger form-control">Konfirmasi Kenaikan Kelas</button>
				<!-- <button type="button" class="btn " data-dismiss="modal">Close</button> -->
			</div>
			</form>
		</div>
	</div>
</div>