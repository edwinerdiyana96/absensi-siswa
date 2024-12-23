<!-- Begin Page Content -->
<?php
$guru = $this->Admin_model->getTotalGuru();
?>
<div class="container-fluid dashboard-atas">

	<div class="card shadow mb-4">
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
					<div class="col-md-4 mb-2">
						<button class="btn btn-info  btn-icon-split" data-toggle="modal" data-target="#addNewUser">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text">Tambah Ruangan Baru</span>
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
							<span class="text">Tambah Ruangan Baru</span>
						</button>
					</div>
				</div>
			</div>

			<br>

			<div class="responsive">
				<table class="table table-striped table-bordered" id="table-ruangan" style="width:100%;">
					<thead class="text-primary">
						<tr>
							<th>No.</th>
							<th>Kode Ruangan</th>
							<th>Deskripsi Ruangan</th>
							<th>PIC Ruangan</th>
							<th>QR Code</th>
							<th>Status Ruangan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

		</div>
	</div>

	<!-- DataTable Content -->
	<script>
		var tabel = null;
		$(document).ready(function() {
			tabel = $('#table-ruangan').DataTable({
				"processing": true,
				// "responsive": true,
				"scrollX": true,
				"serverSide": true,
				"ordering": true, // Set true agar bisa di sorting
				"order": [
					[0, 'asc']
				], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
				"ajax": {
					"url": "<?= base_url('operator/data_ruangan'); ?>", // URL file untuk proses select datanya
					"type": "POST"
				},
				"deferRender": true,
				"aLengthMenu": [
					[10, 50, 100],
					[10, 50, 100]
				], // Combobox Limit
				"columns": [{
						"data": 'room_id',
						"sortable": false,
						render: function(data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1;
						}
					},
					{
						"data": "no"
					},
					{
						"data": "description"
					},
					{
						"data": "name"
					},
					{
						"data": "qr_token",
						"render": function(data, type, row, meta) {
							// return '<a href="< ?= base_url('operator/cetak/') ?>'+data+'" target="_blank" class="btn btn-primary mt-2 zoom "><i class="fa fa-download "></i>&ensp;<img class="zoom  img-thumbnail img-responsive  " style="width: 100px; height: 100px;" src="< ?= base_url('assets/qr/ruangan/') ?>'+data+'.png"></a>';
							return '<a href="<?= base_url('assets/qr/ruangan/') ?>' + data + '.png" download class="btn btn-primary mt-2 zoom "><i class="fa fa-download "></i>&ensp;<img class="zoom  img-thumbnail img-responsive  " style="width: 100px; height: 100px;" src="<?= base_url('assets/qr/ruangan/') ?>' + data + '.png"></a>';
						}
					},
					{
						"data": "status"
					},
					{
						"data": "room_id",
						"render": function(data, type, row, meta) {
							var konfirmasi = "confirm('Apakah anda Yakin?')";
							return '' +
								'<a href="' + '<?= base_url(); ?>operator/ruangan/cetak/' + data + '" class="btn btn-success">CETAK</a> &ensp;' +
								'<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editRuangan" href="" data-room_id="' + data + '">EDIT</a>' +
								' ' +
								'<a href="' + '<?= base_url(); ?>operator/ruangan/delete/' + data + '" class="btn btn-danger" onclick="return ' + konfirmasi + '">HAPUS</a>';
						}
					},
				],
			});
		});
	</script>

	<!-- Modal Add Ruangan -->
	<div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRoleModelLabel">Tambah Ruangan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('operator/ruangan/add') ?>" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<input type="text" class="form-control" id="no" name="no" placeholder="Kode Ruangan">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="description" name="description" placeholder="Deskripsi Ruangan">
						</div>
						<div class="form-group">
							<select class="form-control" name="pic">
								<!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
								<Option value=""> Pilih PIC Ruangan</Option>
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



	<!-- Modal Edit Ruangan -->
	<div class="modal fade" id="editRuangan" tabindex="-1" role="dialog" aria-labelledby="editKelasLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRoleModelLabel">Edit Ruangan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?= base_url('operator/ruangan/edit') ?>" method="POST">
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
		$(document).ready(function() {
			$('#editRuangan').on('show.bs.modal', function(e) {
				var room_id = $(e.relatedTarget).data('room_id');
				$.ajax({
					type: 'post',
					url: '<?= base_url('Ajax/AjaxRuangan/') ?>' + room_id, //Here you will fetch records 
					data: 'room_id=' + room_id, //Pass $id
					success: function(data) {
						$('.fetched-data').html(data); //Show fetched data from database
					}
				});
			});
		});
	</script>