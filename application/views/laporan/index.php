<?php

$a = $total_siswa_hadir;
$b = $total_siswa_tidak_hadir;
$c = $a + $b;
if ($c == 0) {
    $persentase = 0;
} else {
    $persentase = ($a / $c) * 100;
}
?>
<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">
    <!-- Page Heading -->
    <h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->

        <div class="col-xl-3 col-md-3 mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Siswa</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"> <?= $total_siswa; ?></div>
                        </div>
                        <div class="col-auto">
                            <span style="color: Mediumslateblue;">
                                <i class="fa fa-users fa-3x" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-3 mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Guru </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"> <?= $total_guru ?></div>
                        </div>
                        <div class="col-auto">
                            <span style="color: Mediumslateblue;">
                                <i class="fas fa-user-graduate fa-3x"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-3 mb-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Ruangan </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"> <?= $total_ruangan ?></div>
                        </div>
                        <div class="col-auto">
                            <span style="color: Mediumslateblue;">
                                <i class="fa fa-university fa-3x" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                Persentase Siswa Kehadiran Hari ini</div>
                            <!-- <div class="h5 font-weight-bold text-gray-800"><?= 'hadir' . $total_siswa_hadir ?> <?= 'tidak hadir' . $total_siswa_tidak_hadir ?> -->
                            <div class="h5 font-weight-bold text-gray-800"><?= number_format($persentase, 2); ?>%</div>
                            <!-- <div class="h5 font-weight-bold text-gray-800">  </div> -->
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:<?= number_format($persentase, 2); ?>%"></div>
                                <!-- <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: 70%"></div> -->
                            </div>
                        </div>
                        <div class="col-auto">
                            <span style="color: Mediumslateblue;">
                                <i class="fas fa-chart-pie fa-3x "></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary ">Monitoring Ruangan | <?= date('D, d-m-y', strtotime($tanggal)) ?></h6>
        </div>

        <div class="card-body">
            <?= $this->session->flashdata('message'); ?>

            <div class="responsive">
                <table class="table table-striped table-bordered" id="monitoring_ruangan" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Ruangan</th>
                            <th scope="col">Pic</th>
                            <th scope="col">Status Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data_ruangan = $this->db->query("SELECT * FROM student_room
                        JOIN user ON student_room.pic = user.id")->result_array();
                        $no = 1;
                        foreach ($data_ruangan as $key => $data_ruangan) {
                            $data_pembelajaran = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND is_done = '0'")->row_array();
                            $cek_pembelajaran = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND is_done = '0'")->num_rows();
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data_ruangan['description'] ?></td>
                                <td><?= $data_ruangan['name'] ?></td>
                                <td><?php
                                    if ($cek_pembelajaran > 0) {
                                        echo '<a href = "' . base_url() . 'laporan/guru_mapel/' . $data_pembelajaran['id'] . '">
                                <div class="alert alert-danger" role="alert"> Sedang Dalam Pembelajaran </div>
                                </a>';
                                    } elseif ($cek_pembelajaran == 0) {
                                        echo ' <div class="alert alert-success" role="alert"> Ruangan Kosong</div>';
                                    } else {
                                        echo $cek_pembelajaran;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    <script>
        var tabel = null;
        $(document).ready(function() {
            tabel = $('#monitoring_ruangan').DataTable({
                "scrollX": true,
                // "processing": true,
                // "responsive": true,
                // "serverSide": true,
                // "ordering": true, // Set true agar bisa di sorting
                // "order": [
                //     [0, 'asc']
                // ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
                // "ajax": {
                //     "url": "< ?= base_url('Laporan/monitoring_ruangan'); ?>", // URL file untuk proses select datanya
                //     "type": "POST"
                // },
                // "deferRender": true,
                // "aLengthMenu": [
                //     [10, 50, 100],
                //     [10, 50, 100]
                // ], // Combobox Limit
                // "columns": [{
                //         "data": 'pic',
                //         "sortable": false,
                //         render: function(data, type, row, meta) {
                //             return meta.row + meta.settings._iDisplayStart + 1;
                //         }
                //     },
                //     {
                //         "data": "description",


                //     }, // Tampilkan kategori
                //     {
                //         "data": "pic",
                //     }, // Tampilkan kategori
                //     {
                //         "data": "is_done",
                //         "render": function(data, type, row, meta) {
                //             if (data == '1') {
                //                 return '  <div class="alert alert-danger" role="alert"> Sedang Dalam Pembelajaran </div>';
                //             } else if (data == '0') {
                //                 return ' <div class="alert alert-success" role="alert"> Ruangan Kosong</div>';
                //             }
                //         }
                //     },
                //     {
                //         "data": "is_done",
                //         "render": function(data, type, row, meta) {
                //             if (data == '1') {
                //                 return '  <div class="alert alert-danger" role="alert"> Sedang Dalam Pembelajaran </div>';
                //             } else if (data == '0') {
                //                 return ' <div class="alert alert-success" role="alert"> Ruangan Kosong</div>';
                //             }
                //         }
                //     }

                // ],
            });
        });
    </script>





    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary ">Riwayat Pembelajaran | <?= date('D, d-m-y', strtotime($tanggal)) ?></h6>
        </div>

        <div class="card-body">
            <?= $this->session->flashdata('message'); ?>

            <div class="responsive">
                <div>
                    <!-- ============================ Display Only On Desktop Mode ============================ -->
                    <div class="d-none d-lg-block">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                                <form action="<?= base_url('laporan/index/cek_tanggal') ?>" method="POST">
                                    <div class="input-group mb-6">
                                        <input type="date" name="tanggal" class="form-control col-md-3" value="<?= $tanggal ?>">
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
                            <div class="col-md-12 mb-4">
                                <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                                <form action="<?= base_url('laporan/index/cek_tanggal') ?>" method="POST">
                                    <input type="date" name="tanggal" class="form-control col-md-3" value="<?= $tanggal ?>">
                                    <br>
                                    <button class="btn btn-primary form-control" style="text-align: left;">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-filter"></i>
                                        </span> &ensp;&ensp;
                                        <span class="text">Filter Tanggal</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- </div> -->
                </div>
                <table class="table table-striped table-bordered" id="history" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Ruangan</th>
                            <th scope="col">Guru</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Jam Mulai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data_ruangan = $this->db->query("SELECT student_room_history.date as tanggal, user.name , student_room_history.class, student_room_history.start_time, student_room.description as ruangan 
                        FROM `student_room_history` 
                        inner join user on user.id = student_room_history.teacher_id
                        INNER JOIN student_room on student_room.room_id = student_room_history.room_id
                        WHERE student_room_history.date = '" . $tanggal . "'")->result_array();
                        $no = 1;
                        foreach ($data_ruangan as $key => $data_ruangan) {
                            $data_pembelajaran = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND is_done = '0'")->row_array();
                            $cek_pembelajaran = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND is_done = '0'")->num_rows();
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data_ruangan['ruangan'] ?></td>
                                <td><?= $data_ruangan['name'] ?></td>
                                <td><?= $data_ruangan['class'] ?></td>
                                <td><?= $data_ruangan['start_time'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>





    <script>
        var tabel = null;
        $(document).ready(function() {
            tabel = $('#history').DataTable({
                "scrollX": true,
            });
        });
    </script>