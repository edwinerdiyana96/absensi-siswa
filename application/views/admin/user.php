<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">

	<!-- Page Heading -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary "><?= $title ?></h6>
		</div>
		<div class="card-body">
			<?= $this->session->flashdata('message'); ?>
			<div class="row">
				<div class="col-md-6 ">
					<!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
					<button class="btn btn-info  btn-icon-split" data-toggle="modal" data-target="#addNewUser">
						<span class="icon text-white-50">
							<i class="fas fa-plus"></i>
						</span>
						<span class="text">Tambah Pegawai</span>
					</button>

					<button class="btn btn-success btn-icon-split" onclick="window.location.href='<?= base_url('admin/export_user') ?>'">
						<span class="icon text-white-50">
							<i class="fas fa-file-excel"></i>
						</span>
						<span class="text">Export To Excel</span>
					</button>
				</div>
			</div>

			<br>

			<!-- <div class="card-body"> -->
			<div class="responsive">
				<table class="table table-striped table-bordered table-hover" id="table-guru" style="width:100%;">
					<thead class="text-primary">
						<tr>
							<th scope="col">No.</th>
							<th scope="col">Nama</th>
							<th scope="col">Jabatan</th>
							<th scope="col">Email</th>
							<th scope="col">Nomor HP</th>
							<th scope="col">Jenis Kelamin</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>

					<tbody>
					</tbody>

				</table>
			</div>
			<!-- </div> -->
		</div>
	</div>

</div>
<!-- /.container-fluid -->
<script>
	var tabel = null;
	$(document).ready(function() {
		tabel = $('#table-guru').DataTable({
			"processing": true,
			// "responsive": true,
			"scrollX": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[0, 'asc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				"url": "<?= base_url('admin/data_user'); ?>", // URL file untuk proses select datanya
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
					"data": "name"
				}, // Tampilkan kategori
				{
					"data": "department"
				},
				{
					"data": "email"
				}, // Tampilkan nama sub kategori
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
					"data": "id",
					"render": function(data, type, row, meta) {
						// return '<a href="show/' + data + '">Show</a>';
						var konfirmasi = "confirm('Apakah anda Yakin?')";
						return '<a href="<?= base_url('admin/editUserProfile/') ?>' + data + '" class="btn btn-info mt-2">Update User </a>' +
							' ' +
							'<a href="<?= base_url('admin/deleteuser/') ?>' + data + '" class="btn btn-danger mt-2" onclick=" return ' + konfirmasi + '">Delete</a>' +
							' ' +
							'<a href="<?= base_url('admin/editUserAccess/') ?>' + data + '" class="btn btn-primary mt-2">Akses Menu</a>';
					}
				},
			],
		});
	});
</script>
<!-- End of Main Content -->


<!-- Modal Add Role -->

<div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoleModelLabel">Tambah Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('admin/addNewUser') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap">
					</div>
					<div class="form-group">
						<select class="form-control" name="gender">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value="L">Laki - Laki</Option>
							<Option value="P">Perempuan</Option>
						</select>
					</div>
					<div class="form-group">
						<select class="form-control" name="department">
							<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
							<Option value=""> Pilih Jabatan</Option>
							<?php foreach ($role as $r) : ?>
								<Option value="<?= $r['id'] ?>"> <?= $r['role'] ?></Option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<input type="email" class="form-control" id="email" name="email" placeholder="email">
					</div>
					<div class="form-group">
						<input type="number" class="form-control" id="no_hp" name="phone" placeholder="Nomor Telpon">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="password" name="password" placeholder="password">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>