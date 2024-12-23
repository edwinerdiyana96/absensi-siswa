<style type="text/css">
    .text-justify {
        text-align: justify;
    }
</style>

<div class="container" id="QR-Code">
    <div class="w-100 d-inline-block">
        <div class="panel panel-info">
            <div class="panel-body text-center">
                <div class="w-100 d-inline-block">
                    <div class="w-100 d-inline-block text-center">
                        <button class="w-100 d-inline-block text-center btn-success">SILAHKAN PILIH GURU MAPEL: </button>
                    </div>

                </div>

                <div class="alert alert-success" role="alert">

                    <form id='form_absen' action="<?= base_url('scan/absensi_flexible/') ?>" method="post" class="mb-4">
                        <input type='text' hidden name="user_id" id='user_id' value="<?= $user['id'] ?>">
                        <input type='text' hidden name="kelas" id='kelas' value="<?= $user['class_name'] ?>">
                        <!-- <input type='text' name="attendance_id" id='attendance_id' value="< ?= $attendance['attendance_id'] ?>"> -->
                        <select name="room_history" id="" class="form-control">
                            <?php
                            foreach ($guru as $key => $guru) { ?>
                                <option value="<?= $guru['id'] ?>"><?= $guru['name'] ?></option>
                            <?php } ?>
                        </select>
                        <button type="text" class="btn btn-primary form-control mt-2">Konfirmasi Pilihan</button>
                    </form><br>


                    <h4 class="alert-heading">PERHATIAN!</h4>
                    <p class="text-justify" style="text-align: justify; display:inline-block;">
                        Silahkan pilih guru mata pelajaran yang sedang berjalan, jika nama guru yang sedang mengajar tidak muncul, pastikan guru sudah melakukan scan ruangan kemudian coba lakukan reload halaman ini!

                    </p>
                    <hr>
                    <p class="mb-0">Jika Ada Kendala atau Pertanyaan Silahkan Hubungi Administrator!</p>
                </div>


                <br>
            </div>
        </div>

    </div>
</div>