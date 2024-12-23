<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">
    <!-- Page Heading -->
    <h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>
   

        <div class="card">
            <div class="card-header">
                	<div class="input-group mb-6">
                           <div class="col-md-6 ">
                                <a href="<?= $_SERVER['HTTP_REFERER'] ?>">
                                <button class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fa fa-caret-left"></i>
                                </span>
                                <span class="text">Kembali</span>
                                </button>
                                </a>
                            </div>
					</div>
            </div>
			
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="table-kelas" style="width:100%;">
					<thead class="text-primary">
						<tr>
							<th scope="col">No</th>
							<!-- <th scope="col">Nama</th> -->
							<th scope="col">Nama</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Jam</th>
							<th scope="col">Keterangan</th>
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
				"url": "<?= base_url('guru/detail_pembelajaran/'.$id.'/'.$kd.'/'.$description); ?>", // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 50, 100],
				[10, 50, 100]
			], // Combobox Limit
			"columns": [{
					"data": 'student_room_id',
					"sortable": false,
					render: function(data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{"data": "name"},
				{"data": "tanggal"},
                {"data": "time"},
                {"data": "description"},
			],
		});
	});
</script>