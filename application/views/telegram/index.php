<!-- Begin Page Content -->
<div class="container-fluid dashboard-atas">
	<h1 class="h3 mb-4  text-gray-800"><?= $title ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">DATA SISWA YANG TIDAK HADIR (TINGKAT X) : <?= $total_alpha_x; ?> ORANG</h6>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<?= $this->session->flashdata('message'); ?>
				</div>
			</div>
			<!-- <ul>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Hadir: < ?= $total_hadir_hari_ini; ?> Orang</h6>
				</li>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Terlambat: < ?= $total_terlambat; ?> Orang</h6>
				</li>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Tidak Hadir: < ?= $total_tidak_hadir_hari_ini; ?> Orang</h6>
				</li>
			</ul> -->
			<!-- ============================ Display Only On Desktop Mode ============================ -->
			<div class="d-none d-lg-block">
				<div class="row">
					<div class="col-md-12 mb-2">
						<a href='<?= base_url('telegram/send_alpha_x/'); ?>'><button class="btn btn-info form-control">KIRIM KE TELEGRAM</button></a>
					</div>
				</div>
			</div>
			<!-- ============================ Display Only On Mobile Mode ============================ -->
			<div class="d-lg-none">
				<div class="row">
					<div class="col-md-12 mb-2">
						<a href='<?= base_url('telegram/send_alpha_x/'); ?>'><button class="btn btn-info form-control">KIRIM KE TELEGRAM</button></a>
					</div>
				</div>
			</div>
			<br>
			<div class="responsive">
				<table class="table table-striped table-bordered text-nowrap" id="table-telegram-x" style="width:100%;">
					<thead class="text-primary text-center">
						<tr>
							<th>NO.</th>
							<th>NAMA</th>
							<th>KELAS</th>
							<th>TANGGAL</th>
						</tr>
					</thead>

					<tbody class="text-center">
						<?php foreach ($alpha_x as $key1 => $alpha_x) : ?>
							<tr>
								<td><?php echo $key1 + 1; ?></td>
								<td><?php echo $alpha_x['name']; ?> </a></td>
								<td><?php echo $alpha_x['class_name']; ?></td>
								<td><?php echo $alpha_x['date']; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<br>
			<br>
		</div>
	</div>
	<!-- KELAS X -->

	<!-- KELAS XI -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">DATA SISWA YANG TIDAK HADIR (TINGKAT XI) : <?= $total_alpha_xi; ?> ORANG</h6>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<?= $this->session->flashdata('message'); ?>
				</div>
			</div>
			<!-- <ul>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Hadir: < ?= $total_hadir_hari_ini; ?> Orang</h6>
				</li>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Terlambat: < ?= $total_terlambat; ?> Orang</h6>
				</li>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Tidak Hadir: < ?= $total_tidak_hadir_hari_ini; ?> Orang</h6>
				</li>
			</ul> -->
			<!-- ============================ Display Only On Desktop Mode ============================ -->
			<div class="d-none d-lg-block">
				<div class="row">
					<div class="col-md-12 mb-2">
						<a href='<?= base_url('telegram/send_alpha_xi/'); ?>'><button class="btn btn-info form-control">KIRIM KE TELEGRAM</button></a>
					</div>
				</div>
			</div>
			<!-- ============================ Display Only On Mobile Mode ============================ -->
			<div class="d-lg-none">
				<div class="row">
					<div class="col-md-12 mb-2">
						<a href='<?= base_url('telegram/send_alpha_xi/'); ?>'><button class="btn btn-info form-control">KIRIM KE TELEGRAM</button></a>
					</div>
				</div>
			</div>
			<br>
			<div class="responsive">
				<table class="table table-striped table-bordered text-nowrap" id="table-telegram-xi" style="width:100%;">
					<thead class="text-primary text-center">
						<tr>
							<th>NO.</th>
							<th>NAMA</th>
							<th>KELAS</th>
							<th>TANGGAL</th>
						</tr>
					</thead>

					<tbody class="text-center">
						<?php foreach ($alpha_xi as $key2 => $alpha_xi) : ?>
							<tr>
								<td><?php echo $key2 + 1; ?></td>
								<td><?php echo $alpha_xi['name']; ?> </a></td>
								<td><?php echo $alpha_xi['class_name']; ?></td>
								<td><?php echo $alpha_xi['date']; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<br>
			<br>
		</div>
	</div>
	<!-- KELAS XI -->

	<!-- KELAS XII -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">DATA SISWA YANG TIDAK HADIR (TINGKAT XII) : <?= $total_alpha_xii; ?> ORANG</h6>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<?= $this->session->flashdata('message'); ?>
				</div>
			</div>
			<!-- <ul>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Hadir: < ?= $total_hadir_hari_ini; ?> Orang</h6>
				</li>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Terlambat: < ?= $total_terlambat; ?> Orang</h6>
				</li>
				<li>
					<h6 class="m-0 font-weight-bold text-primary">Total Yang Tidak Hadir: < ?= $total_tidak_hadir_hari_ini; ?> Orang</h6>
				</li>
			</ul> -->
			<!-- ============================ Display Only On Desktop Mode ============================ -->
			<div class="d-none d-lg-block">
				<div class="row">
					<div class="col-md-12 mb-2">
						<a href='<?= base_url('telegram/send_alpha_xii/'); ?>'><button class="btn btn-info form-control">KIRIM KE TELEGRAM</button></a>
					</div>
				</div>
			</div>
			<!-- ============================ Display Only On Mobile Mode ============================ -->
			<div class="d-lg-none">
				<div class="row">
					<div class="col-md-12 mb-2">
						<a href='<?= base_url('telegram/send_alpha_xii/'); ?>'><button class="btn btn-info form-control">KIRIM KE TELEGRAM</button></a>
					</div>
				</div>
			</div>
			<br>
			<div class="responsive">
				<table class="table table-striped table-bordered text-nowrap" id="table-telegram-xii" style="width:100%;">
					<thead class="text-primary text-center">
						<tr>
							<th>NO.</th>
							<th>NAMA</th>
							<th>KELAS</th>
							<th>TANGGAL</th>
						</tr>
					</thead>

					<tbody class="text-center">
						<?php foreach ($alpha_xii as $key3 => $alpha_xii) : ?>
							<tr>
								<td><?php echo $key3 + 1; ?></td>
								<td><?php echo $alpha_xii['name']; ?> </a></td>
								<td><?php echo $alpha_xii['class_name']; ?></td>
								<td><?php echo $alpha_xii['date']; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<br>
			<br>
		</div>
	</div>
	<!-- KELAS XII -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- KELAS X -->
<script>
	$(document).ready(function() {
		$("#table-telegram-x").DataTable({
			rowReorder: {
				selector: "td:nth-child(2)",
			},
			pageLength: 5,
			lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
			responsive: true,
		});
	});
</script>

<!-- KELAS XI -->
<script>
	$(document).ready(function() {
		$("#table-telegram-xi").DataTable({
			rowReorder: {
				selector: "td:nth-child(2)",
			},
			pageLength: 5,
			lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
			responsive: true,
		});
	});
</script>

<!-- KELAS XII -->
<script>
	$(document).ready(function() {
		$("#table-telegram-xii").DataTable({
			rowReorder: {
				selector: "td:nth-child(2)",
			},
			pageLength: 5,
			lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
			responsive: true,
		});
	});
</script>
