<!-- Back-End - Get Data -->
<!-- < ?php
    // $jumlah_pegawai = $this->Admin_model->getPegawai()->num_rows();
? > -->
<!-- <nav class="navbar fixed-bottom navbar-expand d-lg-none d-sm-block" style="background-color: #004F7A">
    <ul class="navbar-nav nav-justified w-100">
        <li class="nav-item">
            <a id="kirim" style="color: white; "><i class="fa fa-qrcode" aria-hidden="true"></i> SCAN QR CODE</a>
        </li>
    </ul>
</nav> -->

<?= $this->session->flashdata('message_absen'); ?>
<!--< ?= $this->session->flashdata('message'); ?>-->

<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">
    <!-- Page Heading -->
    <h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>
    <div class="row gutters-sm">

    <!--DATA PEMBELAJARAN HARI INI-->
        <!--<div class="col-md-12 col-xl-6  col-sm-12">-->
            <!--<div class="card shadow mb-4">-->
                <!--<div class="card-header py-3">-->
                <!--    <h6 class="m-0 font-weight-bold text-primary text-center">Data Pembelajaran Hari Ini</h6>-->
                <!--</div>-->
                <!--<div class="card-body">-->
                    <!--<table class="table table-striped table-bordered" id="table-kelas" style="width:100%;">-->
                        <!--<thead class="text-primary">-->
                            <!--<tr>-->
                            <!--    <th scope="col">Jam Mulai</th>-->
                            <!--    <th scope="col">Jam Selesai</th>-->
                                <!-- <th scope="col">Nama</th> -->
                            <!--    <th scope="col">Mata Pelajaran</th>-->
                            <!--    <th scope="col">Ruangan</th>-->
                            <!--    <th scope="col">Kelas</th>-->
                            <!--    <th scope="col">Status</th>-->
                            <!--    <th scope="col">Aksi</th>-->
                            <!--</tr>-->
                        <!--</thead>-->
                        <!-- <tfoot class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Kelas</th>
                                <th>Wali Kelas</th>
                                <th>Ketua Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot> -->
        <!--                <tbody>-->
        <!--                </tbody>-->
        <!--            </table>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    <!--DATA PEMBELAJARAN HARI INI-->


        <div class="col-xl-12 col-md-12 ">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 text-center">
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
                                    <!--<div class="card p-4">-->
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
                                    <!--</div>-->
                                </div>

                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 text-center">

                                                    <?php if ($status_guru >= 1) : ?>

                                                        <div class="alert alert-danger text-center" role="alert">
                                                            Sedang Mengajar
                                                        </div>
                                                        <?php
                                                        $data_mapel = $this->db->query("SELECT id FROM student_room_history Where is_done = '0' AND teacher_id = '" . $user['id'] . "' AND date = '" . date('Y-m-d') . "'")->row_array();
                                                        ?>
                                                        <a href="<?= base_url(); ?>guru/guru_mapel/<?= $data_mapel['id'] ?>" class="btn btn-primary form-control">Detail Pembelajaran</a>
                                                    <?php elseif ($status_guru == 0) : ?>

                                                        <div class="alert alert-success" role="alert">
                                                            Sedang Kosong
                                                        </div>
                                                    <?php endif ?>

                                                </div>


                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h6 class="mt-1">Email</h6>
                                                </div>
                                                <div class="col-sm-8 text-secondary">:
                                                    <?= $user['email'] ?>
                                                    <!--< ?= $user['id'] ?>-->
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <h6 class="mt-1">Gender</h6>
                                                </div>
                                                <div class="col-sm-8 text-secondary">:
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
                                                    <h6 class="mt-0">Wali Kelas</h6>
                                                </div>
                                                <div class="col-sm-8 text-secondary">:
                                                    <?= $nama_kelas ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <!--<div class="row">-->
                                            <!--    <div class="col-sm-4">-->
                                            <!--        <h6 class="mt-0">Mata Pelajaran </h6>-->
                                            <!--    </div>-->
                                            <!--    <div class="col-sm-8 text-secondary">:-->
                                            <!--        ##-->
                                            <!--    </div>-->
                                            <!--</div>-->
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


    <script>
        var tabel = null;
        var tanggal = '<?= date('Y-m-d') ?>';
        $(document).ready(function() {
            tabel = $('#table-kelas').DataTable({
                "scrollX": true,
                "processing": true,
                // "responsive": true,
                "serverSide": true,
                "scroller": true,
                "scrollCollapse": true,
                "ordering": true, // Set true agar bisa di sorting
                "order": [
                    [0, 'asc']
                ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
                "ajax": {
                    "url": "<?= base_url('guru/data_pembelajaran/'); ?>" + tanggal, // URL file untuk proses select datanya
                    "type": "POST"
                },
                "deferRender": true,
                "aLengthMenu": [
                    [10, 50, 100],
                    [10, 50, 100]
                ], // Combobox Limit
                "columns": [{
                        "data": "start_time"
                    },
                    {
                        "data": "end_time"
                    },
                    {
                        "data": "lessons"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "class"
                    },
                    {
                        "data": "is_done",
                        "render": function(data, type, row, meta) {
                            // return '<a href="show/' + data + '">Show</a>';
                            if (data == '1') {
                                return '<span class="badge badge-success">Pembelajaran Selesai</span>';
                            } else {
                                return '<span class="badge badge-danger">Pembelajaran Sedang Berlangsung</span>';
                            }

                        }
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            // return '<a href="show/' + data + '">Show</a>';
                            var konfirmasi = "confirm('Apakah anda Yakin?')";
                            return '<a href="' + '<?= base_url(); ?>guru/guru_mapel/' + data + '" class="badge btn-primary">Detail Pembelajaran</a>';
                        }
                    },
                ],
            });
        });
    </script>

    <!-- Begin Page Content -->


    <!-- Page Heading -->

    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary ">History Absen Siswa | <?= date('D, d-m-y') ?></h6>
        </div>

        <div class="card-body">
            <?= $this->session->flashdata('message'); ?>

            <div class="responsive">
                <table class="table table-striped table-bordered text-nowrap" id="table-student_attendance" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>

    </div> -->
</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- DataTable Content -->
<script>
    var tabel = null;
    $(document).ready(function() {
        tabel = $('#table-student_attendance').DataTable({
            "scrollX": true,
            "processing": true,
            // "responsive": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'asc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?= base_url('guru/data_student_attendance'); ?>", // URL file untuk proses select datanya
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
                {
                    "data": "name"
                }, // Tampilkan kategori
                {
                    "data": "class_name"
                }, // Tampilkan kategori
                {
                    "data": "date"
                }, // Tampilkan nama sub kategori
                {
                    "data": "time"
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        if (data == '0') {
                            return '<span class="badge badge-pill badge-danger">Belum Absen</span>';
                        } else if (data == '1') {
                            return '<span class="badge badge-pill badge-success">Hadir Tepat Waktu</span>';
                        } else if (data == '2') {
                            return '<span class="badge badge-pill badge-warning">Hadir Terlambat</span>';
                        } else if (data == '3') {
                            return '<span class="badge badge-pill badge-info">Sakit</span>';
                        } else if (data == '4') {
                            return '<span class="badge badge-pill badge-primary">Izin</span>';
                        } else {
                            return '<span class="badge badge-pill badge-danger">Alfa / Belum Absen </span>';
                        }
                    }
                },
                // {
                //     "data": "description"
                // },
                // {
                //     "data": "gender",
                //     "render": function(data, type, row, meta) {
                //         if (data == '0') {
                //             return 'Laki-laki';
                //         } else {
                //             return 'Perempuan';
                //         }
                //     }
                // },

                {
                    "data": "attendance_id",
                    "render": function(data, type, row, meta) {
                        // return '<a href="show/' + data + '">Show</a>';
                        return '<div class="text-center"> <a href="' + '<?= base_url(); ?>guru/hadir/' + data + '" class="btn btn-success btn-sm-block">H</a>' + ' ' +
                            '<a href="' + '<?= base_url(); ?>guru/telat/' + data + '" class="btn btn-warning text-justify">T</a>' + ' ' +
                            '<a href="' + '<?= base_url(); ?>guru/sakit/' + data + '" class="btn btn-info">S</a>' + ' ' +
                            '<a href="' + '<?= base_url(); ?>guru/izin/' + data + '" class="btn btn-primary">I</a>' + ' ' +
                            '<a href="' + '<?= base_url(); ?>guru/alpha/' + data + '" class="btn btn-danger">A</a> </div>'



                    }
                },
            ],
        });
    });
</script>