<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">
	<!-- Page Heading -->
	<h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>


	<div class="card">
		<div class="card-header">

			<div>
				<!-- ============================ Display Only On Desktop Mode ============================ -->
				<div class="d-none d-lg-block">
					<div class="row">
						<div class="col-md-6">
							<!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
							<form action="<?= base_url('guru/room_teacher/filter') ?>" method="POST">
								<div class="input-group mb-6">
									<input type="date" name="filter" class="form-control col-md-3" value="<?= $tanggal_sekarang ?>">
									<div class="col-md-6 ">
										<button class="btn btn-primary btn-icon-split">
											<span class="icon text-white-50">
												<i class="fa fa-filter"></i>
											</span>
											<span class="text">Lihat Data</span>
										</button>
									</div>
								</div>
							</form>
						</div>
						<br><br><br>
						<div class="col-md-6 text-right">
							<button class="btn btn-danger" data-toggle="modal" data-target="#export">
								<span class="icon text-white-50">
									<i class="fas fa-file-excel"></i>
								</span>
								<span class="text">Export To Excel</span>
							</button>
						</div>
					</div>
				</div>


				<!-- ============================ Display Only On Mobile Mode ============================ -->
				<div class="d-lg-none">
					<div class="row">
						<div class="col-md-12">
							<!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
							<form action="<?= base_url('guru/room_teacher/filter') ?>" method="POST">
								<div class="input-group mb-6">
									<input type="date" name="filter" class="form-control col-md-3" value="<?= $tanggal_sekarang ?>">
									<div class="col-md-6 ">
										<button class="btn btn-primary btn-icon-split">
											<span class="icon text-white-50">
												<i class="fa fa-filter"></i>
											</span>
											<span class="text">Lihat Data</span>
										</button>
									</div>
								</div>
							</form>
							<br>

							<button class="btn btn-danger form-control" data-toggle="modal" data-target="#export" style="text-align: left;">
								<span class="icon text-white-50">
									<i class="fas fa-file-excel"></i>
								</span> &ensp;&ensp;
								<span class="text">Export To Excel</span>
							</button><br><br>
						</div>
					</div>
				</div>
				<!-- </div> -->
				<!-- </div> -->
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table-kelas" style="width:100%;">
					<thead class="text-primary">
						<tr>
							<!-- <th scope="col">Nama</th> -->
							<th scope="col">Jam Mulai</th>
							<th scope="col">Jam Selesai</th>
							<th scope="col">Mata Pelajaran</th>
							<th scope="col">Ruangan</th>
							<th scope="col">Kelas</th>
							<th scope="col">Status</th>
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


	<script>
		var tabel = null;
		var tanggal = '<?= $tanggal_sekarang ?>';
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
					"url": "<?= base_url('guru/data_pembelajaran/'); ?>" + tanggal, // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[10, 50, 100],
					[10, 50, 100]
				], // Combobox Limit
				"columns": [{
						"data": "start_time"
					},
					{
						"data": "end_time"
					},
					{
						"data": "lessons"
					},
					{
						"data": "description"
					},
					{
						"data": "class"
					},
					{
						"data": "is_done",
						"render": function(data, type, row, meta) {
							// return '<a href="show/' + data + '">Show</a>';
							if (data == '1') {
								return '<span class="badge badge-success">Pembelajaran Selesai</span>';
							} else {
								return '<span class="badge badge-danger">Pembelajaran Sedang Berlangsung</span>';
							}

						}
					},
					{
						"data": "id",
						"render": function(data, type, row, meta) {
							// return '<a href="show/' + data + '">Show</a>';
							var konfirmasi = "confirm('Apakah anda Yakin?')";
							return '<a href="' + '<?= base_url(); ?>guru/guru_mapel/' + data + '" class="badge btn-primary">Detail Pembelajaran</a> &ensp;' +
								'<a href="' + '<?= base_url(); ?>guru/export_rekap_satuan/' + data + '" class="badge btn-danger">Export Rekap</a>';
						}
					},
				],
			});
		});
	</script>






	<!-- Modal Add Role -->
	<div class="modal fade" id="export" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRoleModelLabel">Export Rekap Pembelajaran</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('guru/export_rekap') ?>" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Tanggal Laporan</label>
									<input type="date" class="form-control" name="tanggal" required value="<?= date('Y-m-d') ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary form-control">Export Laporan</button>
					</div>
				</form>
			</div>
		</div>
	</div>