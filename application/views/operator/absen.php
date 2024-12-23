<?php
$var_kelas = str_replace(" ", "-", $kelas);
?>

<?= $this->session->flashdata('message'); ?>

<div class="container-fluid dashboard-atas">
    <h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <?php
        if ($sortir == 'Filter Bulanan') { ?>
            <div class="tab-pane fade show " id="today" role="tabpanel" aria-labelledby="today-tab">
            <?php } else { ?>
                <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
                <?php } ?>

                <div class="row">
                    <!-- Area Chart -->
                    <div class="col-xl-12 cold-md-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Absen Harian | <?= date('D, d-m-y') ?></h6>
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
                                                    <form action="<?= base_url('operator/absen_siswa/filter_harian') ?>" method="POST">
                                                        <div class="input-group mb-6">
                                                            <select class="form-control" name="class">
                                                                <?php foreach ($class as $r) :
                                                                    if ($r['class'] == $kelas) { ?>
                                                                        <Option value="<?= $r['class'] ?>" selected> <?= $r['class'] ?></Option>
                                                                    <?php } else { ?>
                                                                        <Option value="<?= $r['class'] ?>"><?= $r['class'] ?></Option>
                                                                <?php }
                                                                endforeach; ?>
                                                            </select> &ensp;
                                                            <input type="date" name="filter" class="form-control col-md-3" value="<?= $tanggal_sekarang ?>">
                                                            <div class="col-md-6 ">
                                                                <button class="btn btn-primary btn-icon-split">
                                                                    <span class="icon text-white-50">
                                                                        <i class="fa fa-filter"></i>
                                                                    </span>
                                                                    <span class="text">Filter Tanggal</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>


                                        <!-- ============================ Display Only On Mobile Mode ============================ -->
                                        <div class="d-lg-none">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                                                    <form action="<?= base_url('operator/absen_siswa/filter_harian') ?>" method="POST">
                                                        <select class="form-control" name="class">
                                                            <!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
                                                            <?php foreach ($class as $r) :
                                                                if ($r['class'] == $kelas) { ?>
                                                                    <Option value="<?= $r['class'] ?>" selected> <?= $r['class'] ?></Option>
                                                                <?php } else { ?>
                                                                    <Option value="<?= $r['class'] ?>"><?= $r['class'] ?></Option>
                                                            <?php }
                                                            endforeach; ?>
                                                        </select> &ensp;
                                                        <input type="date" name="filter" class="form-control col-md-3" value="<?= $tanggal_sekarang ?>">
                                                        <br>
                                                        <button class="btn btn-primary form-control" style="text-align: left;">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-filter"></i>
                                                            </span> &ensp;&ensp;
                                                            <span class="text">Filter Tanggal</span>
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

                                    <form action="<?= base_url('operator/update_absensi') ?>" method="POST">
                                        <table class="table table-striped table-bordered" style="width:100%;">
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
                                                <?php
                                                // echo $kelas;
                                                $no = 1;
                                                $cek = 0;
                                                $array = $this->db->query("SELECT * FROM `student_attendance` 
                                            JOIN `user` ON student_attendance.`user_id` = user.`id` WHERE
                                            user.class_name like '" . $kelas . "%' and student_attendance.date = '" . $tanggal_sekarang . "'ORDER BY user.name ASC")->result_array();
                                                foreach ($array as $key => $array) { ?>
                                                    <tr>
                                                        <input type="hidden" name="user<?= $cek ?>" value="<?= $array['user_id'] ?>">
                                                        <input type="hidden" name="class" value="<?= $array['class'] ?>">
                                                        <td scope="col"><?= $no++ ?></td>
                                                        <!-- <td scope="col">Nama</td> -->
                                                        <td scope="col"><?= $array['name'] ?></td>
                                                        <td scope="col"><?= $array['class_name'] ?></td>
                                                        <td scope="col"><?= $array['date'] ?></td>
                                                        <td scope="col"><?= $array['time'] ?></td>
                                                        <td>
                                                            <!-- <label class="slds-checkbox-button slds-checkbox-button_is-checked" for="example-unique-id-31">
                                        <input type="checkbox" class="btn slds-assistive-text" name = "aksi[]" value="< ?= $array['student_room_id']?>" style="width: 20px; height: 20px;" />
                                    </label> -->

                                                            <!-- Desktop View -->
                                                            <div class="d-none d-lg-block" style="text-align: justify; text-justify: inter-word;">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="pilih<?= $cek ?>" <?php if (($array['status'] == '0' and $array['description'] == '-') or ($array['status'] == '0' and $array['description'] == 'Siswa ini belum absen pagi!')) {
                                                                                                                    echo 'checked';
                                                                                                                } ?> value="0" style="width: 15px; height: 15px;">&ensp; Alfa/Belum Absen &ensp; | &ensp;
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="pilih<?= $cek ?>" <?php if ($array['status'] == '1') {
                                                                                                                    echo 'checked';
                                                                                                                } ?> value="1" style="width: 15px; height: 15px;">&ensp; Hadir Tepat Waktu &ensp; | &ensp;
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="pilih<?= $cek ?>" <?php if ($array['status'] == '2') {
                                                                                                                    echo 'checked';
                                                                                                                } ?> value="2" style="width: 15px; height: 15px;">&ensp; Hadir Telat &ensp; | &ensp;
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="pilih<?= $cek ?>" <?php if ($array['status'] == '3') {
                                                                                                                    echo 'checked';
                                                                                                                } ?> value="3" style="width: 15px; height: 15px;">&ensp; Sakit &ensp; | &ensp;
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="pilih<?= $cek ?>" <?php if ($array['status'] == '4') {
                                                                                                                    echo 'checked';
                                                                                                                } ?> value="4" style="width: 15px; height: 15px;">&ensp; Izin &ensp; | &ensp;
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="pilih<?= $cek ?>" <?php if ($array['status'] == '0' and $array['description'] == 'Bolos') {
                                                                                                                    echo 'checked';
                                                                                                                } ?> value="Bolos" style="width: 15px; height: 15px;">&ensp; Bolos &ensp; | &ensp;
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="pilih<?= $cek ?>" <?php if ($array['status'] == '0' and $array['description'] == 'PKL/OJT') {
                                                                                                                    echo 'checked';
                                                                                                                } ?> value="PKL/OJT" style="width: 15px; height: 15px;">&ensp; PKL/OJT &ensp; | &ensp;
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="pilih<?= $cek ?>" <?php if ($array['status'] == '0' and $array['description'] == 'Lainnya') {
                                                                                                                    echo 'checked';
                                                                                                                } ?> value="Lainnya" style="width: 15px; height: 15px;">&ensp; Lainnya &ensp; | &ensp;
                                                                </label>
                                                            </div>

                                                            <!-- Mobile View -->
                                                            <div class="d-lg-none" style="text-align: justify; text-justify: inter-word;">
                                                                <div class="form-check">
                                                                    <input type="radio" name="m<?= $cek ?>" <?php if ($array['status'] == '0' and $array['description'] == '-' or $array['status'] == '0' and $array['description'] == 'Siswa ini belum absen pagi!') {
                                                                                                                echo 'checked';
                                                                                                            } ?> value="0" name="m<?= $cek ?>" id="m<?= $cek ?>">
                                                                    <label class="form-check-label" for="m<?= $cek ?>">
                                                                        Alfa/Belum Absen
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" <?php if ($array['status'] == '1') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> value="1" name="m<?= $cek ?>" id="m<?= $cek ?>2">
                                                                    <label class="form-check-label" for="m<?= $cek ?>2">
                                                                        Hadir
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" <?php if ($array['status'] == '2') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> value="2" name="m<?= $cek ?>" id="m<?= $cek ?>3">
                                                                    <label class="form-check-label" for="m<?= $cek ?>3">
                                                                        Telat
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" <?php if ($array['status'] == '3') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> value="3" name="m<?= $cek ?>" id="m<?= $cek ?>4">
                                                                    <label class="form-check-label" for="m<?= $cek ?>4">
                                                                        Sakit
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" <?php if ($array['status'] == '4') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> value="4" name="m<?= $cek ?>" id="m<?= $cek ?>5">
                                                                    <label class="form-check-label" for="m<?= $cek ?>5">
                                                                        Izin
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" <?php if ($array['status'] == '0' and $array['description'] == 'Bolos') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> value="Bolos" name="m<?= $cek ?>" id="m<?= $cek ?>6">
                                                                    <label class="form-check-label" for="m<?= $cek ?>6">
                                                                        Bolos
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" <?php if ($array['status'] == '0' and $array['description'] == 'PKL/OJT') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> value="PKL/OJT" name="m<?= $cek ?>" id="m<?= $cek ?>7">
                                                                    <label class="form-check-label" for="m<?= $cek ?>7">
                                                                        PKL/OJT
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" <?php if ($array['status'] == '0' and $array['description'] == 'Lainnya') {
                                                                                                                        echo 'checked';
                                                                                                                    } ?> value="Lainnya" name="m<?= $cek ?>" id="m<?= $cek ?>8">
                                                                    <label class="form-check-label" for="m<?= $cek ?>8">
                                                                        Lainnya
                                                                    </label>
                                                                </div>
                                                            </div>


                                                        </td>
                                                    </tr>
                                                <?php $cek++;
                                                } ?>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td colspan="5"></td>
                                                    <td>
                                                        <input type="hidden" name="tanggal" value="<?= $tanggal_sekarang ?>">
                                                        <div class="d-none d-lg-block" style="text-align: justify; text-justify: inter-word;">
                                                            <button type="submit" class="btn btn-primary form-control" name="aksi" value="desktop">Simpan</button>
                                                        </div>

                                                        <div class="d-lg-none" style="text-align: justify; text-justify: inter-word;">
                                                            <button type="submit" class="btn btn-primary form-control" name="aksi" value="mobile">Simpan</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </form>
                                </div>
                            </div>



                        </div>

                    </div>
                </div>
                </div>


                <!-- DataTable Content -->
                <script>
                    var tabel = null;
                    var tanggal = '<?= $tanggal_sekarang ?>';
                    var kelas = '<?= $var_kelas ?>';
                    $(document).ready(function() {
                        tabel = $('#rekap-harian').DataTable({
                            "scrollX": true,
                            // "processing": true,
                            // // "responsive": true,
                            // "ScrollX": true,
                            // "serverSide": true,
                            // "ordering": true, // Set true agar bisa di sorting
                            // "order": [
                            //     [0, 'asc']
                            // ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
                            // "ajax": {
                            //     "url": "<?= base_url('operator/data_rekap_harian/'); ?>" + tanggal + "/" + kelas, // URL file untuk proses select datanya
                            //     "type": "POST"
                            // },
                            // "deferRender": true,
                            // "aLengthMenu": [
                            //     [10, 50, 100],
                            //     [10, 50, 100]
                            // ], // Combobox Limit
                            // "columns": [{
                            //         "data": 'attendance_id',
                            //         "sortable": false,
                            //         render: function(data, type, row, meta) {
                            //             return meta.row + meta.settings._iDisplayStart + 1;
                            //         }
                            //     },
                            //     // {
                            //     //  "data": "name"
                            //     // }, 
                            //     {
                            //         "data": "name"
                            //     },
                            //     {
                            //         "data": "class_name"
                            //     },
                            //     {
                            //         "data": "date"
                            //     },
                            //     {
                            //         "data": "time"
                            //     },
                            //     {
                            //         "data": "status",
                            //         "render": function(data, type, row, meta) {
                            //             if (data == 0) {
                            //                 return '<span class="badge badge-danger">Belum Absen</span>';
                            //             }
                            //             if (data == 1) {
                            //                 return '<span class="badge badge-success">Hadir Tepat Waktu</span>';
                            //             }
                            //             if (data == 2) {
                            //                 return '<span class="badge badge-warning">Hadir Telat</span>';
                            //             }
                            //             if (data == 3) {
                            //                 return '<span class="badge badge-primary">Sakit</span>';
                            //             }
                            //             if (data == 4) {
                            //                 return '<span class="badge badge-secondary">Izin</span>';
                            //             }
                            //         }
                            //     },
                            // ],
                        });
                    });
                </script>

                <!-- tab perbulan -->
                <?php
                if ($sortir == 'Filter Bulanan') { ?>
                    <div class="tab-pane fade show active" id="month" role="tabpanel" aria-labelledby="month-tab">
                    <?php } else { ?>
                        <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                        <?php } ?>

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
                                                    <form action="<?= base_url('operator/rekap/filter_bulanan') ?>" method="POST">
                                                        <div class="input-group mb-6">
                                                            <select class="form-control" name="class">
                                                                <!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
                                                                <?php foreach ($class as $r) :
                                                                    if ($r['class'] == $kelas) { ?>
                                                                        <Option value="<?= $r['class'] ?>" selected> <?= $r['class'] ?></Option>
                                                                    <?php } else { ?>
                                                                        <Option value="<?= $r['class'] ?>"><?= $r['class'] ?></Option>
                                                                <?php }
                                                                endforeach; ?>
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
                                                <div class="col-md-6 text-right">
                                                    <button class="btn btn-danger" data-toggle="modal" data-target="#export">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-file-excel"></i>
                                                        </span>
                                                        <span class="text">Export To Excel</span>
                                                    </button>

                                                    <button class="btn btn-info" data-toggle="modal" data-target="#import">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-file-excel"></i>
                                                        </span>
                                                        <span class="text">Import Rekap Absen Manual</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- ============================ Display Only On Mobile Mode ============================ -->
                                        <div class="d-lg-none">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                                                    <form action="<?= base_url('operator/rekap/filter_bulanan') ?>" method="POST">
                                                        <select class="form-control" name="class">
                                                            <!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
                                                            <?php foreach ($class as $r) :
                                                                if ($r['class'] == $kelas) { ?>
                                                                    <Option value="<?= $r['class'] ?>" selected> <?= $r['class'] ?></Option>
                                                                <?php } else { ?>
                                                                    <Option value="<?= $r['class'] ?>"><?= $r['class'] ?></Option>
                                                            <?php }
                                                            endforeach; ?>
                                                        </select><br>
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

                                                    <button class="btn btn-danger form-control" data-toggle="modal" data-target="#export" style="text-align: left;">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-file-excel"></i>
                                                        </span> &ensp;&ensp;
                                                        <span class="text">Export To Excel</span>
                                                    </button>
                                                    <br><br>


                                                    <button class="btn btn-info form-control" data-toggle="modal" data-target="#import" style="text-align: left;">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-file-excel"></i>
                                                        </span> &ensp;&ensp;
                                                        <span class="text">Import Rekap Absen Manual</span>
                                                    </button>
                                                    <br><br>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                        <!-- </div> -->

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" id="rekap-bulanan" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Bulan</th>
                                                        <th>Nama</th>
                                                        <th>Sakit</th>
                                                        <th>Izin</th>
                                                        <th>Alpha</th>
                                                        <th>Total Hadir</th>
                                                        <th>Total Tidak Hadir</th>
                                                        <th>Persentase Kehadiran</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Bulan</th>
                                                        <th>Nama</th>
                                                        <th>Sakit</th>
                                                        <th>Izin</th>
                                                        <th>Alpha</th>
                                                        <th>Total Hadir</th>
                                                        <th>Total Tidak Hadir</th>
                                                        <th>Persentase Kehadiran</th>
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
                var bulan = '<?= $bulan_sekarang ?>';
                var kelas = '<?= $var_kelas ?>';
                $(document).ready(function() {
                    tabel = $('#rekap-bulanan').DataTable({
                        "processing": true,
                        // "responsive": true,
                        "scrollX": true,
                        "serverSide": true,
                        "ordering": true, // Set true agar bisa di sorting
                        "order": [
                            [0, 'asc']
                        ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
                        "ajax": {
                            "url": "<?= base_url('operator/data_rekap_bulanan/'); ?>" + bulan + "/" + kelas, // URL file untuk proses select datanya
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
                            // {
                            //  "data": "name"
                            // }, 
                            {
                                "data": "name"
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
            <div class="modal fade" id="import" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRoleModelLabel">Import Laporan Absensi Manual</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('operator/import_laporan') ?>" method="POST" enctype='multipart/form-data'>
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="alert alert-success" role="alert"> Download Format Excel Upload Data!
                                            <a href="<?= base_url('assets/uploads/template_absen_manual.xlsx') ?>" download>
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
                                <button type="submit" class="btn btn-primary form-control">Export Laporan</button>
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