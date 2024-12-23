<!--===============================================================================================-->
<link rel="icon" type="image/png" href="<?= base_url('assets/'); ?>img/iconsmkkarnas.png">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>vendor/animate/animate.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>vendor/select2/select2.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>css/util.css">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/'); ?>css/main.css">

<?php
$cookie = array(
	'name'   => 'remember_me_token',
	'value'  => 'Random string',
	'expire' => '1209600',  // Two weeks
	'domain' => 'absensi.edwinerdiyana.com',
	'path'   => '/'
);

set_cookie($cookie);
?>

<div class="limiter">
	<div class="container-login100">


		<div class="wrap-login100">

			<form class="login100-form validate-form" method="POST" action="<?= base_url('ortu/add') ?>">
				<span class="login100-form-title p-b-43">
					FORM PENDAFTARAN <br> AKUN ORANGTUA SISWA
				</span>
				<div class="small text-danger">
					<?= $this->session->flashdata('message'); ?>
				</div>

                
                <div class="form-group form-group-default">
                    <label>Nama Orangtua</label>
					<input type="text" name="name" class=" form-control" required placeholder="Masukkan Nama di sini">
				</div>

                <div class="form-group form-group-default">
                    <label>NIS Siswa</label>
					<input type="number" name="nis" class=" form-control" required placeholder="Masukkan Nis Siswa di sini">
				</div>

                <div class="form-group form-group-default">
                    <label>No Telepon</label>
					<input type="number" name="phone" class=" form-control" required placeholder="Masukkan No Telepon Orangtua">
				</div>

                <div class="form-group form-group-default">
                    <label>Password</label>
					<input type="password" name="password" class=" form-control" required placeholder="Masukkan password">
				</div>

    <br>
				<div class="container-login100-form-btn">
					<button type="submit" class="btn btn-primary form-control">
						Daftar Akun
					</button>
				</div>

				<!-- <div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or sign up using
						</span>
					</div> -->

				<!-- <div class="login100-form-social flex-c-m">
						<a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
							<i class="fa fa-facebook-f" aria-hidden="true"></i>
						</a>

						<a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</div> -->
			</form>

			<div class="login100-more" style="background-image: url('<?= base_url('assets/'); ?>images/background.jpeg');">
			</div>
		</div>
	</div>
</div>





<!--===============================================================================================-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url('assets/'); ?>vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/popper.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url('assets/'); ?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url('assets/'); ?>vendor/daterangepicker/moment.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url('assets/'); ?>vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="<?= base_url('assets/'); ?>js/main.js"></script>


