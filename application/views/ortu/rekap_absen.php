<div class="container-fluid dashboard-atas">

	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">Perhari</a>
		</li>
		<li class="nav-item" role="presentation">
			<a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="month" aria-selected="false">Perbulan</a>
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
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">Rekap Absen Harian</h6>
						</div>



						<!-- Card Body -->
						<div class="card-body">
							<div class="form-group md-2 mb-3">
								<div>


									<form action="base_url('absensi/rekap/filter') " method="POST">
										<div class="input-group mb-6">
											<input type="date" name="filter" class="form-control col-md-3" value="$filter ">
											<div class="col-md-6 ">
												<button class="btn btn-primary btn-icon-split">
													<span class="icon text-white-50">
														<i class="fa fa-filter"></i>
													</span>
													<span class="text">Filter Tanggal</span>
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered display responsive" id="tableTanggal" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>No</th>
											<th>NIS</th>
											<th>Nama</th>
											<th>Tanggal</th>
											<th>Jam Masuk</th>
											<th>Keterangan</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No</th>
											<th>NIS</th>
											<th>Nama</th>
											<th>Tanggal</th>
											<th>Jam Masuk</th>
											<th>Keterangan</th>
										</tr>
									</tfoot>
									<tbody>


										<tr>
											<td>2</td>
											<td>Dede</td>
											<td>21551068</td>
											<td>20-02-2022</td>
											<td>06:30</td>
											<td>
												<h4><span class="badge badge-success">Hadir</span></h4>
											</td>
										</tr>
										<tr>
											<td>1 </td>
											<td>Dede</td>
											<td>21551068</td>
											<td>20-02-2022</td>
											<td>06:30</td>
											<td>
												<h4><span class="badge badge-danger">Izin</span></h4>
											</td>
										</tr>

									</tbody>
								</table>
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


									<form action="base_url('operator/export') " method="POST">

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
											<th>NIS</th>
											<th>Hadir</th>
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
											<th>NIS</th>
											<th>Hadir</th>
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
											<td>1</td>
											<td>Dede</td>
											<td>2018081037</td>
											</td>
											<td>25</td>
											</td>
											<td>1</td>
											</td>
											<td>1</td>
											</td>
											<td>1</td>
											</td>
											<td>25</td>
											</td>
											<td>3</td>
											</td>
											<td>20 %</td>
											</td>
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



