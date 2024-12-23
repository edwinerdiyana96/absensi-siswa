<div class="container-fluid">
    <div class="row text-center mt-2">
        <div class="col-md-12">
            <?= $this->session->flashdata('message_absen'); ?>
        </div>
    </div>


    <div class="row gutters-sm">
        <div class="col-xl-6 col-md-6 ">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Pengguna</h6>
                </div>
                <div class="card-body">
                    <!-- <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a>
              <a class="nav-link" id="nav-pass-tab" data-toggle="tab" href="#nav-pass" role="tab" aria-controls="nav-pass" aria-selected="false">Update Password</a>
            </div>
          </nav> -->

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                            <div class="row gutters-sm">

                                <div class="col-md-4">
                                    <div class="card mb-0">
                                        <div class="card-body mb-4">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                <img src="<?= base_url('assets/img/profile/') . $user['image'] ?>" alt="Profile Photo" class="rounded-circle" width="150" height="150">

                                                <div class="mt-2">
                                                    <h5><?= $user['name'] ?></h5>
                                                    <hr>
                                                    <h6 class="text-muted font-size-sm align-items-center text-center" style="color:black; display: inline-block; text-align:center;"> <?= $user['department'] ?> </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h6 class="mt-1">Email:</h6>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <?= $user['email'] ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h6 class="mt-1">Gender:</h6>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    <?php if ($user['gender'] == 'L') {
                                                        echo 'Laki-Laki';
                                                    } else {
                                                        echo 'Perempuan';
                                                    } ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h6 class="mt-0">Wali Kelas : </h6>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                   ###
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h6 class="mt-0">Mata Pelajaran :</h6>
                                                </div>
                                                <div class="col-sm-8 text-secondary">
                                                    ##
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>





        <!-- Donut Chart -->
        <div class="col-xl-6 col-md-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Persentase Kehadiran Siswa Bulan <?= bulan_indo(date('m')); ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="chart-area">
                            <canvas id="grafik_perhari"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="card shadow mb-4">

        <!-- rekap -->

        <div class="container-fluid dashboard-atas">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true"> Persentase Kehadiran Bulan <?= bulan_indo(date('m')); ?></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="month" aria-selected="false">Rekap Perbulan</a>
                </li>
                <li class="nav-item" role="presentation">
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-12 cold-md-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->


                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered display" id="tableTanggal" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jam Masuk</th>
                                                        <th>Jam Istirahat</th>
                                                        <th>Jam Pulang</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jam Masuk</th>
                                                        <th>Jam Istirahat</th>
                                                        <th>Jam Pulang</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>

                                                    <?php
                                                    foreach ($riwayat as $key => $riwayat) { ?>
                                                        <tr>
                                                            <td><?= tgl_indo($riwayat['date']) ?></td>
                                                            <td class="text-success"><?= $riwayat['time_in'] ?></td>
                                                            <td class="text-success"><?= $riwayat['time_break'] ?></td>
                                                            <td class="text-success"><?= $riwayat['time_out'] ?></td>
                                                            <td>
                                                                <?php
                                                                if ($riwayat['confirm'] == 0) {
                                                                    echo "<span class='badge badge-warning'>Konfirmasi Absen</span>";
                                                                } elseif ($riwayat['confirm'] == 2) {
                                                                    echo "<span class='badge badge-danger'>Absen di Tolak</span>";
                                                                } else {
                                                                    if ($riwayat['status'] == 0) {
                                                                        echo "<span class='badge badge-danger'>Belum Absen</span>";
                                                                    } elseif ($riwayat['status'] == 1) {
                                                                        echo "<span class='badge badge-primary'>Hadir</span>";
                                                                    } elseif ($riwayat['status'] == 2) {
                                                                        echo "<span class='badge badge-warning'>Hadir Terlambat</span>";
                                                                    } elseif ($riwayat['status'] == 3) {
                                                                        echo "<span class='badge badge-secondary'>Sakit</span>";
                                                                    } elseif ($riwayat['status'] == 1) {
                                                                        echo "<span class='badge badge-secondary'>Izin</span>";
                                                                    }
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                            </div>



                        </div>
                    </div>
                </div>


                <!-- tab perbulan -->
                <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
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
                                    <div class="form-group md-2 mb-3">
                                        <div>
                                            <?php
                                            $bulan_sekarang = bulan_indo(date('m')); ?>
                                            <form action="<?= base_url('user/export') ?>" method="POST">

                                                <div class="input-group mb-6">
                                                    <select id="bulan" name="bulan" class="form-control col-md-3">
                                                        <option value=""> Pilih Semua Bulan</option>
                                                        <option value="Januari">Januari</option>
                                                        <option value="Februari">Februari</option>
                                                        <option value="Maret">Maret</option>
                                                        <option value="April">April</option>
                                                        <option value="Mei">Mei</option>
                                                        <option value="Juni">Juni</option>
                                                        <option value="Juli">Juli</option>
                                                        <option value="Agustus">Agustus</option>
                                                        <option value="September">September</option>
                                                        <option value="Oktober">Oktober</option>
                                                        <option value="November">November</option>
                                                        <option value="Desember">Desember</option>
                                                    </select>

                                                    <div class="col-md-6 "> <button class="btn btn-success btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-file-excel"></i>
                                                            </span>
                                                            <span class="text">Export To Excel</span>
                                                        </button></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tableBulan" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Bulan</th>
                                                    <th>Nama</th>
                                                    <th>Tepat Waktu</th>
                                                    <th>Telat</th>
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
                                                    <th>Tepat Waktu</th>
                                                    <th>Telat</th>
                                                    <th>Sakit</th>
                                                    <th>Izin</th>
                                                    <th>Alpha</th>
                                                    <th>Total Hadir</th>
                                                    <th>Total Tidak Hadir</th>
                                                    <th>Persentase Kehadiran</th>
                                                </tr>
                                            </tfoot>

                                            <tbody>
                                                
                                                            <tr>
                                                                <td><?= $bulan[$i] ?></td>
                                                                <td><?= $data_pegawai['name'] ?></td>
                                                                <td class="text-success"></td>
                                                                <td class="text-warning"></td>
                                                                <td class="text-primary"></td>
                                                                <td class="text-secondary"></td>
                                                                <td class="text-danger"></td>
                                                                <td class="text-info"></td>
                                                                <td class="text-danger"></td>
                                                                <td></td>
                                                            </tr>
                                              

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                </div>
            </div>

            <script>
                jQuery(document).ready(function($) {
                    $('bulan').find('option[value=Maret]').attr('selected', 'selected');
                });
            </script>
        </div>
        <!-- rekap -->
    </div>



</div>
</div>
</div>