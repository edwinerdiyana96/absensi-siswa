<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Tabel <?= $menu ?></h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                    <table class="table table-striped table-bordered" id="table-kelas" style="width:100%;">
                        <thead class="text-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Jenis Kelamin</th> 
                                <th scope="col">No HP</th>
                                <th scope="col">Email</th>
                                <th scope="col">Tanggal Gabung</th>
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
				"url": "<?= base_url('datatables/data_kelas'); ?>", // URL file untuk proses select datanya
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
				{"data": "class"},
				{"data": "name"},
				{"data": "class_leader"
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
						'<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editKelas" href="" data-class_id="' + data + '">EDIT</a>'
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
 </div>  



  <footer class="footer py-4">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="copyright text-center text-sm text-muted text-lg-start">
            <center>
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              created by
              <a href="https://www.atensi.co.id" class="font-weight-bold" target="_blank">Atensi Indonesia</a>
              for a better web.
            </center>
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>
</main>
