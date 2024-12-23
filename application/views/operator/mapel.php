<!-- Begin Page Content -->
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
					<div class="col-md-4 mb-2">
						<button class="btn btn-info  btn-icon-split" data-toggle="modal" data-target="#addNewUser">
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
							<span class="text">Tambah Mata Pelajaran Baru</span>
						</button>
					</div>
				</div>
			</div>

			<br>

			<!-- <div class="responsive"> -->
			<table class="table table-striped table-bordered" id="table-kelas" style="width:100%;">
				<thead class="text-primary">
					<tr>
						<th scope="col">No</th>
						<!-- <th scope="col">Nama</th> -->
						<th scope="col">Mata Pelajaran</th>
						<th scope="col">Total Guru</th>
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
			<!-- </div> -->
		</div>

	</div>
</div>
<!-- DataTable Content -->
<script>
	var tabel = null;
	$(document).ready(function() {
		tabel = $('#table-kelas').DataTable({
			// "responsive": true,
			// "scrollY": 200,
			"scrollX": true,
			// "ScrollX": true,
			"processing": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[0, 'asc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				"url": "<?= base_url('operator/data_mapel'); ?>", // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 50, 100],
				[10, 50, 100]
			], // Combobox Limit
			"columns": [{
					"data": 'mapel_id',
					"sortable": false,
					render: function(data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				// {
				//  "data": "name"
				// }, 
				{
					"data": "lessons"
				},
				{
					"data": "guru"
				},
				{
					"data": "grade"
				},
				{
					"data": "mapel_id",
					"render": function(data, type, row, meta) {
						// return '<a href="show/' + data + '">Show</a>';
						var konfirmasi = "confirm('Apakah anda Yakin?')";
						return '<a href="' + '<?= base_url(); ?>operator/mapel/updateguru/' + data + '" class="btn btn-primary">Data Guru Mapel</a>' +
							' ' +
							'<a type="button" class="btn btn-success" data-toggle="modal" data-target="#editdata" href="" data-class_id="' + data + '">EDIT</a> ' +
							'<a href="' + '<?= base_url(); ?>operator/mapel/delete/' + data + '" class="btn btn-danger" onclick="return ' + konfirmasi + '">HAPUS</a>';
					}
				},
			],
		});
	});
</script>




<!-- Modal Edit Kelas -->
<div class="modal fade" id="editdata" tabindex="-1" role="dialog" aria-labelledby="editdataLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editdataLabel">Update Mata Pelajaran</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action='<?= base_url('operator/mapel/edit'); ?>' method="POST">

					<!-- Isi Modal Fetch Data -->
					<div class="fetched-data"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
				<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#editdata').on('show.bs.modal', function(e) {
			var class_id = $(e.relatedTarget).data('class_id');
			$.ajax({
				type: 'post',
				url: '<?= base_url('Ajax/AjaxMapel/') ?>' + class_id, //Here you will fetch records 
				data: 'class_id=' + class_id, //Pass $id
				success: function(data) {
					$('.fetched-data').html(data); //Show fetched data from database
				}
			});
		});
	});
</script>


<!-- Modal Add Role -->
<div class="modal fade" id="addNewUser" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoleModelLabel">Tambah Mata Pelajaran</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('operator/mapel/add') ?>" method="POST">
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