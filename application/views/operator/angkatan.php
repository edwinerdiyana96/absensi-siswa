<!-- Begin Page Content -->
<?php
$guru = $this->Admin_model->getTotalGuru();
$siswa = $this->Admin_model->getAllSiswa();
$guru1 = $this->Admin_model->getTotalGuru()->result_array();
$siswa1 = $this->Admin_model->getAllSiswa()->result_array();
$siswa2 = $this->Admin_model->getAllSiswa()->result_array();

// foreach ($data_kelas as $dk) :
// 	$class_id = $dk['class_id'];
// 	$class    = $dk['class'];
// 	$wk       = $dk['homeroom_teacher'];
// 	$km       = $dk['class_leader'];
// 	$grade    = $dk['grade'];
// endforeach;
?>
<div class="container-fluid dashboard-atas">

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary "><?= $title ?></h6>
		</div>
		<div class="card-body">
			<?= $this->session->flashdata('message'); ?>
			<div class="row">
				<div class="col-lg-6">
				</div>
			</div>

			<!-- ============================ Display Only On Desktop Mode ============================ -->
			<div class="d-none d-lg-block">
				<div class="row">
					<div class="col-md-4 mb-2">
						<!--<button class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#addNewUser">-->
						<!--	<span class="icon text-white-50">-->
						<!--		<i class="fa fa-whatsapp"></i>-->
						<!--	</span>-->
						<!--	<span class="text">Kirim Rekap Absen ke Semua Group</span>-->
						<!--</button>-->
					</div>
				</div>
			</div>

			<!-- ============================ Display Only On Mobile Mode ============================ -->
			<div class="d-lg-none">
				<div class="row">
					<div class="col-md-4 mb-2">
						<!--<button class="btn btn-success form-control" data-toggle="modal" data-target="#addNewUser">-->
						<!--	<span class="icon text-white-50">-->
						<!--		<i class="fa fa-whatsapp"></i>-->
						<!--	</span>-->
						<!--	<span class="text">Kirim Rekap Absen ke Semua Group</span>-->
						<!--</button>-->
					</div>
				</div>
			</div>

			<br>

			<div class="responsive">
				<table class="table table-striped table-bordered" id="table-kelas" style="width:100%;">
					<thead class="text-primary">
						<tr>
							<th scope="col">No</th>
							<!-- <th scope="col">Nama</th> -->
							<th scope="col">Angkatan</th>
							<th scope="col">Kode Group</th>
							<th scope="col">Aksi</th>
						</tr>
					</thead>
					<!-- <tfoot class="text-primary">
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Ketua Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot> -->
					<tbody>
					    <tr>
					        <td>1</td>
					        <td>X</td>
					        <td><?php
					        $data_kelas = $this->db->get_where('student_class', ['grade' => 'X'])->row_array();
					        echo $data_kelas['kode_group_grade'];
					        ?></td>
					        <td>
					            <button class="btn btn-primary" data-toggle="modal" data-target="#kodeGroup1">Update Kode Group</button>
					            <a href="<?= base_url('operator/angkatan/kirim/X')?>">
					                <button class="btn btn-success">Kirim Rekap Absen ke Group</button>
					            </a>
					        </td>
					    </tr>
					    <tr>
					        <td>2</td>
					        <td>XI</td>
					        <td><?php
					        $data_kelas = $this->db->get_where('student_class', ['grade' => 'XI'])->row_array();
					        echo $data_kelas['kode_group_grade'];
					        ?></td>
					        <td>
					            <button class="btn btn-primary" data-toggle="modal" data-target="#kodeGroup2">Update Kode Group</button>
					            <a href="<?= base_url('operator/angkatan/kirim/XI')?>">
					                <button class="btn btn-success">Kirim Rekap Absen ke Group</button>
					            </a>
					        </td>
					    </tr>
					    <tr>
					        <td>3</td>
					        <td>XII</td>
					        <td><?php
					        $data_kelas = $this->db->get_where('student_class', ['grade' => 'XII'])->row_array();
					        echo $data_kelas['kode_group_grade'];
					        ?></td>
					        <td>
					            <button class="btn btn-primary" data-toggle="modal" data-target="#kodeGroup3">Update Kode Group</button>
					            <a href="<?= base_url('operator/angkatan/kirim/XII')?>">
					                <button class="btn btn-success">Kirim Rekap Absen ke Group</button>
					            </a>
					        </td>
					    </tr>
					    
					</tbody>
				</table>
			</div>
			<!-- </div> -->
		</div>

	</div>
</div>




<!-- Modal Update Kode Group Angkatan X -->
<div class="modal fade" id="kodeGroup1" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoleModelLabel">Update Group Angkatan X</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('operator/angkatan/group') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<label for="grade" class="col-sm-12 control-label">Pilih Tingkat</label>
						<input type="text" class="form-control" id="grade" name="grade" value="X" readonly placeholder="Kode Group">
					</div>
					<div class="form-group">
						<label for="group_id" class="col-sm-12 control-label">Kode Group </label>
						<input type="text" class="form-control" id="group_id" name="kode_group" placeholder="Kode Group">
					</div>
					<div class="form-group">
						<label for="chat_id" class="col-sm-12 control-label">Chat Id </label>
						<input type="text" class="form-control" id="chat_id" name="chat_id" placeholder="Kode Group">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary form-control">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>





<!-- Modal Update Kode Group Angkatan XI -->
<div class="modal fade" id="kodeGroup2" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoleModelLabel">Update Group Angkatan XI</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('operator/angkatan/group') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<label for="grade" class="col-sm-12 control-label">Pilih Tingkat</label>
						<input type="text" class="form-control" id="grade" name="grade" value="XI" readonly placeholder="Kode Group">
					</div>
					<div class="form-group">
						<label for="group_id" class="col-sm-12 control-label">Kode Group </label>
						<input type="text" class="form-control" id="group_id" name="kode_group" placeholder="Kode Group">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary form-control">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>





<!-- Modal Update Kode Group Angkatan XII -->
<div class="modal fade" id="kodeGroup3" tabindex="-1" aria-labelledby="addRoleModelLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addRoleModelLabel">Update Group Angkatan XII</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?= base_url('operator/angkatan/group') ?>" method="POST">
				<div class="modal-body">
					<div class="form-group">
						<label for="grade" class="col-sm-12 control-label">Pilih Tingkat</label>
						<input type="text" class="form-control" id="grade" name="grade" value="XII" readonly placeholder="Kode Group">
					</div>
					<div class="form-group">
						<label for="group_id" class="col-sm-12 control-label">Kode Group </label>
						<input type="text" class="form-control" id="group_id" name="kode_group" placeholder="Kode Group">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary form-control">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

