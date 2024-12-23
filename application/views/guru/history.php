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
						<div class="col-md-8">
							<!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
							<div class="input-group mb-8">

								<div class="col-md-2">
									<button class="btn btn-success" data-toggle="modal" data-target="#mapel">
										<span class="icon text-white-50">
											<i class="fa fa-filter"></i>
										</span>
										<span class="text">Pilih Mapel</span>
									</button>
								</div>
								<?php
								if ($cek_kelas != 0) {
								?>
									<div class="col">
										<form action="<?= base_url('guru/histori_bulanan/filter') ?>" method="POST">
											<input type="hidden" name="mapel" value="<?= $mapel ?>">
											<input type="hidden" name="bulan" value="<?= $bulan_sekarang ?>">
											<select name="kelas" id="" class="form-control">
												<?php
												foreach ($data_kelas as $key => $row) { ?>
													<option value="<?= $row['class'] ?>"><?= $row['class'] ?></option>
												<?php }
												?>
											</select>
									</div>

									<div class="col-md-6">
										<button class="btn btn-primary btn-icon-split">
											<span class="icon text-white-50">
												<i class="fa fa-filter"></i>
											</span>
											<span class="text">Lihat Data</span>
										</button>
									</div>
								<?php } ?>
							</div>
							</form>
						</div>
						<br><br><br>
						<?php
						if ($cek_kelas != 0) {
						?>
							<div class="col-md-4 text-right">
								<button class="btn btn-danger" data-toggle="modal" data-target="#export">
									<span class="icon text-white-50">
										<i class="fas fa-file-excel"></i>
									</span>
									<span class="text">Export To Excel</span>
								</button>
							</div>
						<?php } ?>
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
							<th scope="col">Nama</th>
							<th scope="col">Mata Pelajaran</th>
							<th scope="col">Kelas</th>
							<th scope="col">Sakit</th>
							<th scope="col">Izin</th>
							<th scope="col">Alpha</th>
							<th scope="col">Bolos</th>
							<th scope="col">PKL</th>
							<th scope="col">Dispensasi</th>
							<th scope="col">Tugas Sekolah</th>
							<th scope="col">Total Hadir</th>
							<th scope="col">Total Tidak Hadir</th>
							<th scope="col">Persentase</th>
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
					<!-- < ?php
					if ($cek_kelas != 0) { ?>
						<tbody>
							< ?php
							$data_mapel    = $this->db->get_where('student_lessons', ['mapel_id' => $mapel])->row_array();
							$data_siswa = $this->db->get_where('user', ['class_name' => $kelas, 'department' => 'Siswa'])->result_array();
							foreach ($data_siswa as $key => $row) { ?>
								<tr>
									<td>< ?= $row['name'] ?></td>
									<td>< ?= $data_mapel['lessons'] ?></td>
									<td>< ?= $row['class_name'] ?></td>
									<td>< ?php
										// 	$data = $this->db->query("SELECT count(*) as total FROM student_room_absent 
										// INNER JOIN student_room_history ON student_room_absent.room_history_id = student_room_history.id
										// WHERE student_room_absent.student_id = '" . $row['id'] . "' AND student_room_absent.status = '2'")->row_array();
										// 	echo $data['total'];
										?></td>
									<td>< ?= $row['name'] ?></td>
									<td>< ?= $row['name'] ?></td>
									<td>< ?= $row['name'] ?></td>
									<td>< ?= $row['name'] ?></td>
									<td>< ?= $row['name'] ?></td>
									<td>< ?= $row['name'] ?></td>
									<td>< ?= $row['name'] ?></td>
								</tr>
							< ?php } ?>
						</tbody>
					< ?php } ?> -->
				</table>
			</div>
		</div>
	</div>

	<?php
	$konvert_kelas = urlencode($kelas);
	$hasil = str_replace("+", "-", $konvert_kelas);
	?>

	<script>
		var tabel = null;
		var kelas = '<?= str_replace(" ", "-", $kelas); ?>';
		var bulan = '<?= $bulan_sekarang ?>';
		var awal = '<?= $awal ?>';
		var akhir = '<?= $akhir ?>';
		var lesson_id = '<?= $mapel ?>';
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
					"url": "<?= base_url('guru/siswa_by_kelas/'); ?>" + kelas + "/" + awal + "/" + akhir + "/" + lesson_id, // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[10, 50, 100],
					[10, 50, 100]
				], // Combobox Limit
				"columns": [{
						"data": "name"
					},
					{
						"data": "id",
						"render": function(data, type, row, meta) {
							return '<?= $nama_mapel ?>';
						}
					},
					{
						"data": "class_name"
					},
					{
						"data": "view_sakit"
					},
					{
						"data": "view_izin"
					},
					{
						"data": "view_alpha"
					},
					{
						"data": "view_bolos"
					},
					{
						"data": "view_pkl"
					},
					{
						"data": "view_dispensasi"
					},
					{
						"data": "view_tugas"
					},
					{
						"data": "view_hadir"
					},
					{
						"data": "view_tidak_hadir"
					},
					{
						"data": "view_persentase"
					},
				],
			});
		});
	</script>






	<!-- Modal Add Role -->
	<div class="modal fade" id="mapel" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRoleModelLabel">Export Rekap Pembelajaran</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('guru/histori_bulanan/filter') ?>" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Tanggal Awal</label>
									<input type="date" class="form-control" name="awal" required value="<?= date('Y-m') ?>">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Tanggal Akhir</label>
									<input type="date" class="form-control" name="akhir" required value="<?= date('Y-m-d') ?>">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Mata Pelajaran</label>
									<select name="mapel" value class="form-control">
										<?php
										foreach ($teacher_lessons as $key => $teacher_lessons) { ?>
											<option value="<?= $teacher_lessons['mapel_id'] ?>"><?= $teacher_lessons['lessons'] ?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary form-control">Submit Mata Pelajaran</button>
					</div>
				</form>
			</div>
		</div>
	</div>











	<!-- Modal Add Role -->
	<div class="modal fade" id="export" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRoleModelLabel">Export Rekap Bulanan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('guru/export_history_bulanan') ?>" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Tanggal Awal</label>
									<input type="date" class="form-control" name="awal" required value="<?= date('Y-m') ?>">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Tanggal Akhir</label>
									<input type="date" class="form-control" name="akhir" required value="<?= date('Y-m-d') ?>">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Mata Pelajaran</label>
									<input type="text" class="form-control" disabled value="<?= $nama_mapel ?>">
									<input type="hidden" name="mapel" value="<?= $mapel ?>">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group form-group-default">
									<label>Kelas</label>
									<select name="kelas" id="" class="form-control">
										<?php
										foreach ($data_kelas as $key => $row) { ?>
											<option value="<?= $row['class'] ?>"><?= $row['class'] ?></option>
										<?php }
										?>
									</select>
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