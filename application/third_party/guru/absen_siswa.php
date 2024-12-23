<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="container-fluid dashboard-atas">
        <div class="alert alert-success">
            <div class="row">
                <div class="col-md-9">
                    <h5 class="text-left"> Silakan scan QR Code Ruangan untuk membuka absen </h5>
                </div>
                <div class="col-md-3">
                    <a href="#" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white">
                            <i class="fas fa-qrcode"></i>
                        </span>
                        <span class="text">
                            Scan Qr Code
                        </span>
                    </a>
                </div>
            </div>
            </div>



        <div class="card shadow mb-4">
            <div class="card-header ">
                <h1 class="h3 mb-4 text-primary-800"><?= $title; ?></h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <?= $this->session->flashdata('message'); ?>
                        <!-- <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#Add"> Tambah Submenu </a> -->
                        <table class="table table-hover  responsive" id="tableBulan">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIS</th>
                                    <th scope="col">NAMA</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Mapel</th>
                                    <th scope="col">Status</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th scope="row">1</th>
                                    <td>2014081037</td>
                                    <td>Dede Husen</td>
                                    <td>XII TKJ</td>
                                    <td>Matematika</td>
                                    <td>
                                        <div class="btn btn-danger btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-close"></i>
                                            </span>
                                            <span class="text">Apha</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit" data-sm_id="<?= $sm['id']; ?>" data-sm_menu_id="<?= $sm['menu_id']; ?>" data-sm_title="<?= $sm['title']; ?>" data-sm_menu="<?= $sm['menu']; ?>" data-sm_url="<?= $sm['url']; ?>" data-sm_icon='<?= $sm['icon']; ?>' data-active="<?= $sm['is_active']; ?>">Update Kehadiran</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td>2014081037</td>
                                    <td>Dede Husen</td>
                                    <td>XII TKJ</td>
                                    <td>Matematika</td>
                                    <td>
                                        <div class="btn btn-success btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">Hadir</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit" data-sm_id="<?= $sm['id']; ?>" data-sm_menu_id="<?= $sm['menu_id']; ?>" data-sm_title="<?= $sm['title']; ?>" data-sm_menu="<?= $sm['menu']; ?>" data-sm_url="<?= $sm['url']; ?>" data-sm_icon='<?= $sm['icon']; ?>' data-active="<?= $sm['is_active']; ?>">
                                            Update Kehadiran</a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- End of Main Content -->

    <!-- Button trigger modal -->

    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="AddLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddLabel">Update kehadiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/update_absen') ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">

                            <input type="hidden" class="form-control" id="id" name="id" placeholder="Submenu Title">
                        </div>
                        <div class="form-group">
                            <select name="status_kehadiran" id="menu_id" class="form-control">
                                <option value="">Pilih Kehadiran</option>
                                <!-- < ?php foreach ($menu as $m) : ?>
                                    <option value="< ?= $m['id'] ?>">< ?= $m['menu'] ?></option>
                                < ?php endforeach; ?> -->

                                <option value="">Hadir</option>
                                <option value="">Sakit</option>
                                <option value="">Sakit</option>
                                <option value="">Alpha</option>
                            </select>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- edit -->

    <script>
        $(document).ready(function() {
            $('#edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var title = button.data('sm_title')
                var menu_id = button.data('sm_menu_id')
                var menu = button.data('sm_menu')
                var url = button.data('sm_url')
                var icon = button.data('sm_icon')
                var active = button.data('sm_active')
                var id = button.data('sm_id')

                var modal = $(this)
                modal.find('#title').text('Update' + title)
                modal.find('#title').val(title)
                modal.find('#menu_id').val(menu_id)
                modal.find('#menu').val(menu)
                modal.find('#url').val(url)
                modal.find('#icon').val(icon)
                modal.find('#id').val(id)

            })

        });
    </script>