<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary "><?= $title ?></h6>
            <!-- ============================ Display Only On Desktop Mode ============================ -->
            <div class="d-none d-lg-block">
                <button class="btn btn-info" data-toggle="modal" data-target="#import" style="float: right">
                    <span class="icon text-white-50">
                        <i class="fas fa-file-excel"></i>
                    </span>
                    <span class="text">Import Rekap Absensi</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            </div>

            <br>
            <div class="responsive">
                <!-- ============================ Display Only On Mobile Mode ============================ -->
                <div class="d-lg-none">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#addNewUser"> Tambah Pegawai</a> -->
                            <button class="btn btn-info form-control" data-toggle="modal" data-target="#import">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-excel"></i>
                                </span>
                                <span class="text">Import Rekap Absensi</span>
                            </button>

                            <br><br><br>

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered" id="table-generate_qrcode" style="width:100%;">
                    <thead class="text-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Jam Masuk</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <!-- <tfoot class="text-primary">
						<tr>
							<th>No</th>
							<th>Code</th>
							<th>PNG</th>
							<th>Aksi</th>
						</tr>
					</tfoot> -->
                    <tbody>
                        <?php


                        $num = 1;
                        foreach ($laporan as $laporan) :
                            $data_user = $this->db->query("SELECT * FROM user WHERE id = '" . $laporan['user_id'] . "'")->row_array();
                        ?>
                            </tr>
                            <td><?= $num++ ?></td>
                            <td><?= $data_user['name'] ?></td>
                            <td>
                                <img class="zoom  img-thumbnail img-responsive  " style="width: 100px; height: 100px;" src="<?= base_url('uploads/' . $laporan['image']) ?>">
                            </td>
                            <td><?= $laporan['time'] ?></td>
                            <td><?= date('Y-m-d') ?></td>
                            <td>

                                <?php if ($laporan['status'] == 1) : {
                                        echo '<span class="badge badge-pill badge-success">Hadir Tepat Waktu</span>';
                                    }

                                elseif ($laporan['status'] == 2) : {
                                        echo '<span class="badge badge-pill badge-secondary">Hadir Telambat</span>';
                                    }

                                elseif ($laporan['status'] == 3) : {
                                        echo '<span class="badge badge-pill badge-primary">Sakit</span>';
                                    }

                                elseif ($laporan['status'] == 4) : {
                                        echo '<span class="badge badge-pill badge-primary">Izin</span>';
                                    }

                                elseif ($laporan['status'] == 5) : {
                                        echo '<span class="badge badge-pill badge-warning">OFF</span>';
                                    }

                                elseif ($laporan['status'] == 0) : {
                                        if ($laporan['time_in'] < '11:00:00' && $laporan['date'] == date('Y-m-d')) {
                                            echo '<span class="badge badge-pill badge-info">Belum Hadir</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-danger">Alpha</span>';
                                        }
                                    }
                                ?>
                                <?php endif; ?>
                            </td>

                            </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $("#table-generate_qrcode").DataTable({
            rowReorder: {
                selector: "td:nth-child(2)",
            },
            // responsive: true,
            "scrollX": true,
        });
    });
</script>




<!-- Modal Add Role -->
<div class="modal fade" id="import" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
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