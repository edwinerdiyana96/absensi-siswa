<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">
    <h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>

    <div class="col-xl-12 col-md-12 ">

        <div class="card shadow mb-4">

            <!-- <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary ">Data Tanggal / Hari Libur</h6>
            </div> -->

            <div class="card-body">
                <!-- <div class="table-responsive"> -->
                <button class="btn btn-primary" data-toggle="modal" data-target="#libur">Tetapkan hari Libur</button>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="table-holiday" width="100%">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <!-- <tfoot class="text-primary"></tfoot> -->
                        <tbody>
                            <?php foreach ($data_holiday as $key => $ua) : ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo tgl_indo($ua['date']); ?></td>
                                    <td><?php echo $ua['description']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="libur" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header no-bd">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                            Tetapkan</span>
                        <span class="fw-light">
                            Hari Libur
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('operator/delete_date_attendance') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label>Tanggal Awal Libur</label>
                                    <input type="date" class="form-control" name="awal" required value="<?= date('Y-m-d') ?>">
                                </div>

                                <div class="form-group form-group-default">
                                    <label>Tanggal Akhir Libur</label>
                                    <input type="date" class="form-control" name="akhir" required value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group form-group-default">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" placeholder="Masukkan Keterangan" name="description" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary form-control">Tetapkan Hari Libur</button>
                    <!-- <button type="button" class="btn " data-dismiss="modal">Close</button> -->
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>