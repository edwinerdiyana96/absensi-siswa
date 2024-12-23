<div class="container-fluid dashboard-atas">
	<h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>
	<div class="row text-center mt-2">
		<div class="col-md-12">
			<?= $this->session->flashdata('message_absen'); ?>
		</div>
	</div>


	<?= $this->session->flashdata('message'); ?>

	<div class="row gutters-sm">

		<!-- PROFIL SISWA -->
		<div class="col-xl-6 col-md-6 mt-2 mb-2">
			<section class="card shadow">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">PROFIL SISWA</h6>
				</div>
				<div class="card-body">

					<div class="row">

						<div class="col-lg-5 mb-2 d-flex align-items-stretch">
							<div class="card" style="width: 100%;">
								<div class="card-body">
									<div class="d-flex flex-column align-items-center text-center">
										<img src="<?= base_url('assets/img/profile/') . $user['image'] ?>" alt="Profile Photo" class="rounded-circle" width="150" height="150">

										<div class="mt-2">
											<hr>
											<h6 class="text-muted font-size-sm align-items-center text-center" style="color:black; display: inline-block; text-align:center;"> <?= $user['name'] ?> </h6>
											<?php if ($class_leader != 0) : ?>
												<h6 class="alert alert-primary mt-2" role="alert" style="color:black; display: inline-block; text-align:center; width:100%;">Ketua Kelas</h6>
											<?php else : ?>
												<h6 class="alert alert-primary mt-2" role="alert" style="color:black; display: inline-block; text-align:center; width:100%;">Siswa Biasa</h6>
											<?php endif; ?>
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
											: <?=$user['class_name']?>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-lg-5">
											<h6 class="mt-1">NIS</h6>
										</div>
										<div class="col-lg-7 text-secondary">
											: <?=$user['email']?>
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
					<h6 class="m-0 font-weight-bold text-primary">PRESENTASI KEHADIRAN BULAN INI (<?php echo strtoupper(bulan_indo(date("m"))); ?>)</h6>
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
                                        <h5 class="font-weight-bold text-primary text-uppercase mb-1">APLHA</h5>
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
