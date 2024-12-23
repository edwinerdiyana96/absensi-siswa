<div class="container-fluid dashboard-atas">
	<h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>
	<div class="row text-center mt-2">
		<div class="col-md-12">
			<?= $this->session->flashdata('message_absen'); ?>
			<!--< ?= $this->session->flashdata('message'); ?>-->
		</div>
	</div>


	<!--< ?= $this->session->flashdata('message'); ?>-->

	<!-- < ?php
	$cek_ruangan = $this->db->query("SELECT * FROM student_room_history WHERE class = '" . $user['class_name'] . "' AND date = '" . date('Y-m-d') . "' AND is_done = '0'")->num_rows();
	$data_history = $this->db->query("SELECT student_room.status FROM student_room_history 
	INNER JOIN student_room ON student_room.room_id = student_room_history.room_id
	WHERE class = '" . $user['class_name'] . "' AND date = '" . date('Y-m-d') . "' AND is_done = '0'")->row_array();
	if ($cek_ruangan == 0 OR $data_history['status'] == 'Flexible') { ?>

		<div class="alert alert-primary" role="alert">
			//============================ Display Only On Desktop Mode ============================
			<div class="d-none d-lg-block" style="text-align: justify; text-justify: inter-word;">
				Kamu adalah <i>administrator</i> kelas (bisa KM atau Wakil KM), silahkan klik tombol MASUK KELAS untuk memindai <b>QR CODE</b> pada ruangan (setelah guru membuka ruangan / scan terlebih dahulu) dan masuk ke kelas yang dituju!
				<br>
				<a href="< ?php echo base_url('scan/km'); ?>" class="alert-link"><button type="button" class="btn btn-primary"> MASUK KELAS </button></a>
			</div>
			============================ Display Only On Mobile Mode ============================
			<div class="d-lg-none" style="text-align: justify; text-justify: inter-word;">
				Kamu adalah <i>administrator</i> kelas (bisa KM atau Wakil KM), silahkan klik tombol MASUK KELAS untuk memindai <b>QR CODE</b> pada ruangan (setelah guru membuka ruangan / scan terlebih dahulu) dan masuk ke kelas yang dituju! <br>
				<br>
				<a href="< ?php echo base_url('scan/km'); ?>" class="alert-link"><button type="button" class="btn btn-primary form-control"> MASUK KELAS </button></a>
			</div>
		</div>


	< ?php } ?> -->



	<div class="col-md-12">
		<?php 
		$cek_status = $status_siswa->num_rows();
		if ($cek_status >= 1) {
			$data_status = $this->db->query("SELECT * FROM student_room_history WHERE date = '".date('Y-m-d')."' AND class = '".$user['class_name']."' AND is_done = '0'")->result_array();
			foreach ($data_status as $key => $data_status) {
			$teacher = $this->db->query("SELECT * FROM user Where id = '".$data_status['teacher_id']."'")->row_array();
			$mapel = $this->db->query("SELECT * FROM student_lessons WHERE mapel_id = '".$data_status['lesson_id']."'")->row_array();
			// $kbm = $this->db->query("SELECT * FROM student_room_history WHERE teacher_id = '".$data_status['teacher_id']."'")->row_array();
			?>
			<div class="alert alert-danger" role="alert">
				Sedang Dalam Kegiatan Belajar Mengajar Dengan <b> Mata Pelajaran: <?= $mapel['lessons']?></b> | <b>Guru : <?= $teacher['name']?></b>
			</div>
		<?php }} ?>
	</div>
	<div class="row gutters-sm">

		<!-- PROFIL SISWA -->
		<div class="col-xl-6 col-md-6 mt-2 mb-2">
			<section class="card shadow">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary text-center">PROFIL SISWA</h6>
				</div>
				<div class="card-body">

					<div class="row">

						<div class="col-lg-5 mb-2 d-flex align-items-stretch">
							<div class="card" style="width: 100%;">
								<div class="card-body">
									<div class="d-flex flex-column align-items-center text-center">
										<img src="<?= base_url('assets/img/profile/') . $user['image'] ?>" alt="Profile Photo" class="rounded-circle" width="150" height="150">

										<!-- <div class="mt-2">
											<hr>
											<h6 class="text-muted font-size-sm align-items-center text-center" style="color:black; display: inline-block; text-align:center;"> <?= $user['name'] ?> </h6>
											< ?php if ($class_leader != 0) : ?>
												<h6 class="alert alert-primary mt-2" role="alert" style="color:black; display: inline-block; text-align:center; width:100%;">Ketua Kelas</h6>
											< ?php else : ?>
												<h6 class="alert alert-primary mt-2" role="alert" style="color:black; display: inline-block; text-align:center; width:100%;">Siswa Biasa</h6>
											< ?php endif; ?>
										</div> -->
										 <div class="mt-2">
											<hr>
											<h6 class="alert alert-primary mt-2" role="alert" style="color:black; display: inline-block; text-align:center; width:100%;"><?= $user['name'] ?></h6>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-7 mb-2 d-flex align-items-stretch">
							<div class="card" style="width: 100%;">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-5">
											<h6 class="mt-1">KELAS</h6>
										</div>
										<div class="col-lg-7 text-secondary">
											: <?= $user['class_name'] ?>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-lg-5">
											<h6 class="mt-1">NIS</h6>
										</div>
										<div class="col-lg-7 text-secondary">
											: <?= $user['email'] ?>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-lg-5">
											<h6 class="mt-0">Gender</h6>
										</div>
										<?php if ($user['gender'] == 0) { ?>
											<div class="col-lg-7 text-secondary">
												: Laki-laki
											</div>
										<?php } else { ?>
											<div class="col-lg-7 text-secondary">
												: Perempuan
											</div>
										<?php } ?>
									</div>
									<hr>
									<div class="row">
										<div class="col-lg-5">
											<h6 class="mt-0">No. HP</h6>
										</div>
										<div class="col-lg-7 text-secondary">
											: <?= $user['phone'] ?>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-lg-5">
											<h6 class="mt-0">Alamat</h6>
										</div>
										<div class="col-lg-7 text-secondary">
											: <?= $user['address'] ?>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</section>
		</div>

		<!-- PRESENTASI KEHADIRAN BULAN INI -->
		<div class="col-xl-6 col-md-6 mt-2 mb-2">
			<section class="card shadow">
				<div class="card-header py-3">
					<?php
					date_default_timezone_set("Asia/Jakarta");
					$date = new DateTime("now");
					?>
					<h6 class="m-0 font-weight-bold text-primary text-center">PRESENTASI KEHADIRAN BULAN INI (<?php echo strtoupper(bulan_indo(date("m"))); ?>)</h6>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xl-12">
							<!-- <div class="alert alert-success" role="alert">
								<div class="row ">
									<div class="col-md-6 co-sm-12 col-xl-6 text-sm-left text-sm-center">
										Hari, Tanggal :
									</div>
									<div class="col-md-6 co-sm-12 col-xl-6 text-right text-sm-center ">
										< ?php
										date_default_timezone_set("Asia/Jakarta");
										$date = new DateTime("now");
										echo date("D, d-m-Y"); ?>
									</div>
								</div>
							</div> -->
						</div>
					</div>

					<div class="row p-4">
						<div class="col-xl-6 col-sm-12 col-md-12 mb-2">
							<div class="card border-left-success shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">

											<h5 class="font-weight-bold text-primary text-uppercase mb-1">Hadir</h5>

											<div class=" h5 mb-0 font-weight-bold text-gray-800"><?= $hadir; ?>
											</div>
										</div>
										<div class="col-auto">
											<i class="fas fa-calendar fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-sm-12 col-md-12 col-md-12 mb-2">
							<div class="card border-left-info shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<h5 class="font-weight-bold text-primary text-uppercase mb-1">Sakit</h5>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sakit; ?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-calendar fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-sm-12 col-md-6 col-md-12 mb-2">
							<div class="card border-left-primary shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-primary">
										<div class="col mr-2">
											<h5 class="font-weight-bold text-primary text-uppercase mb-1">IZIN</h5>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $izin; ?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-calendar fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-sm-12 col-md-6 col-md-12 mb-2">
							<div class="card border-left-primary shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<h5 class="font-weight-bold text-primary text-uppercase mb-1">TIDAK / BELUM HADIR</h5>
											<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $alpha; ?></div>
										</div>
										<div class="col-auto">
											<i class="fas fa-calendar fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<hr>

		<!-- INFORMASI LAIINYA -->
		<!-- <div class="col-xl-12 col-md-12 mt-2 mb-2">
			<section class="card shadow">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">INFORMASI LAIINYA</h6>
				</div>
				<div class="card-body" style="height: 370px;">

					<div class="row">

					</div>

				</div>
			</section>
		</div> -->

	</div>
</div>

</div>
</div>
</div>