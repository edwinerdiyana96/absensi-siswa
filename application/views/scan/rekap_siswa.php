
<div class="container-fluid dashboard-atas">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <?php
            if ($sortir == 'Filter Bulanan') { ?>
                <a class="nav-link" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">Perhari</a>
            <?php }else{ ?>
                <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">Perhari</a>
            <?php }?>
            
        </li>
        <li class="nav-item" role="presentation">
            <?php
            if ($sortir == 'Filter Bulanan') { ?>
                <a class="nav-link active" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="month" aria-selected="false">Perbulan</a>
            <?php }else{ ?>
                <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="month" aria-selected="false">Perbulan</a>
            <?php }?>
            
        </li>
        <li class="nav-item" role="presentation">
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
            <?php
            if ($sortir == 'Filter Bulanan') { ?>
               <div class="tab-pane fade show " id="today" role="tabpanel" aria-labelledby="today-tab">
            <?php }else{ ?>
                <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
            <?php }?>
        
            <div class="row">
                <!-- Area Chart -->
                <div class="col-xl-12 cold-md-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Rekap Absen Harian</h6>
                        </div>



                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="form-group md-2 mb-3">
                                <div>
                                    <!-- ============================ Display Only On Desktop Mode ============================ -->
                            <div class="d-none d-lg-block">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                                        <form action="<?= base_url('siswa/rekap_absen/filter') ?>" method="POST">
                                            <div class="input-group mb-6">
                                                <input type="month" name="filter" class="form-control col-md-3" value="<?= $bulan_sekarang ?>">
                                                <div class="col-md-6 ">
                                                    <button class="btn btn-primary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fa fa-filter"></i>
                                                        </span>
                                                        <span class="text">Filter Bulan</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <br><br><br>

                                </div>
                            </div>


                            <!-- ============================ Display Only On Mobile Mode ============================ -->
                            <div class="d-lg-none">
                                <div class="row">
                                    <div class="col-md-12">
                                         <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                                         <form action="<?= base_url('siswa/rekap_absen/filter') ?>" method="POST">
                                            <input type="month" name="filter" class="form-control col-md-3" value="<?= $bulan_sekarang ?>">
                                                <br> 
                                            <button class="btn btn-primary form-control" style="text-align: left;">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-filter"></i>
                                                </span> &ensp;&ensp;
                                                <span class="text">Filter Bulan</span>
                                            </button>
                                        </form>
                                        <br>

                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- </div> -->
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="rekap-harian" style="width:100%;">
                                    <thead class="text-primary">
                                        <tr>
                                            <th scope="col">No</th>
                                            <!-- <th scope="col">Nama</th> -->
                                            <th scope="col">Nama</th>
                                            <th scope="col">Kelas</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Jam Masuk</th>
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

                </div>
            </div>
        </div>


<!-- DataTable Content -->
<script>
    var tabel = null;
    var bulan = '<?= $bulan_sekarang ?>';
    var user = "<?= $user['id']?>";
    $(document).ready(function() {
        tabel = $('#rekap-harian').DataTable({
            "processing": true,
            // "responsive": true,
            "ScrollX": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?= base_url('siswa/data_rekap_siswa/'); ?>"+bulan+"/"+user, // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [
                [10, 50, 100],
                [10, 50, 100]
            ], // Combobox Limit
            "columns": [{
                    "data": 'attendance_id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                // {
                //  "data": "name"
                // }, 
                {"data": "name"},
                {"data": "class_name"},
                {"data": "date"},
                {"data": "time"},
                {"data": "status",
                    "render": function(data, type, row, meta) {
                        if(data == 0) {
                            return '<span class="badge badge-danger">Belum Absen</span>';
                        } if(data == 1) {
                            return '<span class="badge badge-success">Hadir Tepat Waktu</span>';
                        } if(data == 2) {
                            return '<span class="badge badge-warning">Hadir Telat</span>';
                        } if(data == 3) {
                            return '<span class="badge badge-primary">Sakit</span>';
                        } if(data == 4) {
                            return '<span class="badge badge-secondary">Izin</span>';
                        }
                    }
                },
            ],
        });
    });
</script>

        <!-- tab perbulan -->
        <?php
            if ($sortir == 'Filter Bulanan') { ?>
                <div class="tab-pane fade show active" id="month" role="tabpanel" aria-labelledby="month-tab">
            <?php }else{ ?>
                <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
            <?php }?>
        
            <div class="row">
                <!-- Area Chart -->
                <div class="col-xl-12 cold-md-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Rekap Absen Perbulan</h6>
                        </div>



                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- ============================ Display Only On Desktop Mode ============================ -->
                            <div class="d-none d-lg-block">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                                        <form action="<?= base_url('siswa/rekap_absen/filter_mapel') ?>" method="POST">
                                            <div class="input-group mb-6">
                                            <select class="form-control" name="mapel">
                                                <!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
                                                <?php foreach ($array_mapel as $r) : 
                                                $lessons = $this->db->query("SELECT * FROM student_lessons where mapel_id = '".$r['lessons_id']."'")->row_array();
                                                $data_class = $this->Siswa_model->getAllClassByName($user['class_name'])->row_array();
                                                    
                                                    if ($r['lessons_id'] == $mapel) { ?>
                                                        <Option value="<?= $r['lessons_id'] ?>" selected> <?= $lessons['lessons'] ?></Option>
                                                        <?php } else { ?>
                                                        <Option value="<?= $r['lessons_id'] ?>"><?= $lessons['lessons'] ?></Option>
                                                <?php } ?>
                                            
                                            <?php endforeach; ?>
                                            </select> &ensp;
                                                <input type="month" name="filter" class="form-control col-md-3" value="<?= $bulan_sekarang ?>">
                                                <div class="col-md-6 ">
                                                    <button class="btn btn-primary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fa fa-filter"></i>
                                                        </span>
                                                        <span class="text">Filter Bulan</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <br><br><br>
                                </div>
                            </div>


                            <!-- ============================ Display Only On Mobile Mode ============================ -->
                            <div class="d-lg-none">
                                <div class="row">
                                    <div class="col-md-12">
                                         <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                                         <form action="<?= base_url('siswa/rekap_absen/filter_mapel') ?>" method="POST">
                                         <select class="form-control" name="mapel">
                                                <!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
                                                <?php foreach ($array_mapel as $r) : 
                                                $lessons = $this->db->query("SELECT * FROM student_lessons where mapel_id = '".$r['lessons_id']."'")->row_array();
                                                $data_class = $this->Siswa_model->getAllClassByName($user['class_name'])->row_array();

                                                if ($lessons['grade']==$data_class['grade']) {
                                                    if ($r['lessons_id'] == $mapel) { ?>
                                                        <Option value="<?= $r['lessons_id'] ?>" selected> <?= $lessons['lessons'] ?></Option>
                                                        <?php } else { ?>
                                                        <Option value="<?= $r['lessons_id'] ?>"><?= $lessons['lessons'] ?></Option>
                                                <?php }}  ?>
                                            
                                            <?php endforeach; ?>
                                            </select> <br>
                                            <input type="month" name="filter" class="form-control col-md-3" value="<?= $bulan_sekarang ?>">
                                                <br> 
                                            <button class="btn btn-primary form-control" style="text-align: left;">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-filter"></i>
                                                </span> &ensp;&ensp;
                                                <span class="text">Filter Bulan</span>
                                            </button>
                                        </form>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- </div> -->

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="rekap-bulanan" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Mapel</th>
                                            <th>Guru</th>
                                            <th>Ruangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Mapel</th>
                                            <th>Guru</th>
                                            <th>Ruangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
  
</div>

<script>
    var tabel = null;
    var mapel = '<?= $mapel ?>';
    var user = '<?= $user['id'] ?>';
    $(document).ready(function() {
        tabel = $('#rekap-bulanan').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?= base_url('siswa/data_rekap_siswa_mapel/'); ?>"+mapel+"/"+user, // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [
                [10, 50, 100],
                [10, 50, 100]
            ], // Combobox Limit
            "columns": [
                {"data": "date"},
                {"data": "time"},
                {"data": "lessons_id"},
                {"data": "teacher_id"},
                {"data": "room_id"},
                {"data": "status",
                    "render": function(data, type, row, meta) {
                        if(data == 0) {
                            return '<span class="badge badge-danger">Belum Absen</span>';
                        } if(data == 1) {
                            return '<span class="badge badge-success">Hadir Tepat Waktu</span>';
                        } if(data == 2) {
                            return '<span class="badge badge-warning">Hadir Telat</span>';
                        } if(data == 3) {
                            return '<span class="badge badge-primary">Sakit</span>';
                        } if(data == 4) {
                            return '<span class="badge badge-secondary">Izin</span>';
                        }
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
				<h5 class="modal-title" id="addRoleModelLabel">Export Laporan Kehadiran siswa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('operator/export_laporan') ?>" method="POST">
				<div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label>Tanggal Awal</label>
                                <input type="date" class="form-control" name="awal" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group form-group-default">
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control" name="akhir" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label>Pilih Kelas</label>
                                <select class="form-control" name="class">
                                    <!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
                                    <?php foreach ($class as $r) : ?>
                                        <Option value="<?= $r['class'] ?>"> <?= $r['class'] ?></Option>
                                    <?php endforeach; ?>
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