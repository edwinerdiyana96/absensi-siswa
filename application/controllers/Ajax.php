<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Admin_model');
		$this->load->helper('cookie');
	}


	public function AjaxKelas($params = "")
	{

		$guru1 = $this->Admin_model->getTotalGuru()->result_array();
		$siswa1 = $this->Admin_model->getAllSiswa()->result_array();
		$class = $this->db->query("SELECT * FROM student_class where class_id = '" . $params . "'")->row_array();

		$looping_siswa = "";
		$looping_wakil = "";
		$looping_guru = "";

		foreach ($guru1 as $gw1) :
			if ($class['homeroom_teacher'] == $gw1['id']) {
				$looping_guru .= '<option value="' . $gw1['id'] . '" selected>' . $gw1['name'] . '</option>';
			} else {
				$looping_guru .= '<option value="' . $gw1['id'] . '">' . $gw1['name'] . '</option>';
			}
		endforeach;

		$tingkatan = "";
		if ($class['grade'] == 'X') {
			$tingkatan .= '<option value="X" selected> X</option>';
		} else {
			$tingkatan .= '<option value="X"> X</option>';
		}

		if ($class['grade'] == 'XI') {
			$tingkatan .= '<option value="XI" selected> XI</option>';
		} else {
			$tingkatan .= '<option value="XI"> XI</option>';
		}

		if ($class['grade'] == 'XII') {
			$tingkatan .= '<option value="XII" selected> XII</option>';
		} else {
			$tingkatan .= '<option value="XII"> XII</option>';
		}

		$paragraf = '<div class="form-group">
                        <label for="grade" class="col-sm-12 control-label">Tingkat</label>
                        <select class="form-control grade" name="grade" id="grade" required>
                            <!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
                            <option value="" selected> --- Pilih Tingkat --- </option>'
			. $tingkatan . '
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class" class="col-sm-12 control-label">Masukan Nama Kelas (Contoh: TKJ 1) </label>
                        <input type="text" class="form-control class" name="class" id="class" placeholder="Nama Kelas" required value="' . $class['class'] . '">
                    </div>
                    <div class="form-group">
                        <label for="wk" class="col-sm-12 control-label">Wali Kelas</label>
                        <select class="form-control wk" name="wk" id="wk" required>
                            <option value="" selected> --- Pilih Wali Kelas --- </option>' . $looping_guru . '
                        </select>
                    </div>
					
                    <div class="form-group">
                        <label for="kode_group" class="col-sm-12 control-label">Kode Group </label>
                        <input type="text" class="form-control class" name="kode_group" id="kode_group" placeholder="Kode Group" required value="' . $class['kode_group'] . '">
                    </div>
					<div class="form-group">
						<label for="chat_id" class="col-sm-12 control-label">Chat Id </label>
						<input type="text" class="form-control" id="chat_id" name="chat_id" placeholder="Kode Group" value="' . $class['chat_id'] . '">
					</div>
                    <input type="hidden" name="class_id" value="' . $params . '">
                    ';
		echo $paragraf;
	}

	public function AjaxRuangan($params = "")
	{

		$guru1 = $this->Admin_model->getTotalGuru()->result_array();
		$ruangan = $this->db->query("SELECT * FROM student_room where room_id = '" . $params . "'")->row_array();

		$looping_pic = "";

		foreach ($guru1 as $gw1) :
			if ($ruangan['pic'] == $gw1['id']) {
				$looping_pic .= '<option value="' . $gw1['id'] . '" selected>' . $gw1['name'] . '</option>';
			} else {
				$looping_pic .= '<option value="' . $gw1['id'] . '">' . $gw1['name'] . '</option>';
			}
		endforeach;

		$status = "";
		if ($ruangan['status'] == 'Normal') {
			$status .= '<option value="Normal" selected> Normal</option>';
		} else {
			$status .= '<option value="Normal"> Normal</option>';
		}

		if ($ruangan['status'] == 'Flexible') {
			$status .= '<option value="Flexible" selected> Flexible</option>';
		} else {
			$status .= '<option value="Flexible"> Flexible</option>';
		}

		$paragraf = '<div class="form-group">
		<label for="grade" class="col-sm-12 control-label">STATUS KEHADIRAN</label>
		<select class="form-control grade" name="status" id="status" required>
			<option value="" selected disabled> --- TENTUKAN STATUS RUANGAN --- </option>'
			. $status . '
		</select>
	</div>';


		$paragraf = '<div class="form-group">
                            <input type="text" class="form-control" id="no" name="no" placeholder="Kode Ruangan" value="' . $ruangan['no'] . '">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="description" name="description" placeholder="Deskripsi Ruangan" value = "' . $ruangan['description'] . '">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="pic">
                                <!-- <Option value="">Silakan Pilih Jenis Kelamin</Option> -->
                                <Option value=""> Pilih PIC Ruangan</Option>
                                ' . $looping_pic . '
                            </select>
                        </div>
						' . $paragraf . '
                    <input type="hidden" name="room_id" value="' . $params . '">
                    ';
		echo $paragraf;
	}

	public function AjaxDataKehadiran($params = "")
	{

		$attendance = $this->db->query("SELECT * FROM student_attendance where attendance_id = '" . $params . "'")->row_array();
		$status = "";
		if ($attendance['status'] == '0') {
			$status .= '<option value="0" selected> Belum Absen</option>';
		} else {
			$status .= '<option value="0"> Belum Absen</option>';
		}

		if ($attendance['status'] == '1') {
			$status .= '<option value="1" selected> Hadir Tepat Waktu</option>';
		} else {
			$status .= '<option value="1"> Hadir Tepat Waktu</option>';
		}

		if ($attendance['status'] == '2') {
			$status .= '<option value="2" selected> Hadir Terlambat</option>';
		} else {
			$status .= '<option value="2"> Hadir Terlambat</option>';
		}
		if ($attendance['status'] == '3') {
			$status .= '<option value="3" selected> Sakit</option>';
		} else {
			$status .= '<option value="3"> Sakit</option>';
		}
		if ($attendance['status'] == '4') {
			$status .= '<option value="4" selected> Izin</option>';
		} else {
			$status .= '<option value="4"> Izin</option>';
		}
		$paragraf = '<div class="form-group">
		<label for="grade" class="col-sm-12 control-label">STATUS KEHADIRAN</label>
		<select class="form-control grade" name="status" id="status" required>
			<option value="" selected> --- TENTUKAN STATUS KEHADIRAN --- </option>'
			. $status . '
		</select>
	</div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="description" name="description" placeholder="Keterangan Kehadiran" value = "' . $attendance['description'] . '">
                        </div>
                    <input type="hidden" name="attendance_id" value="' . $params . '">
                    ';
		echo $paragraf;
	}

	public function AjaxDetailSiswa($params = "")
	{

		// $data_siswa = $this->db->query("SELECT student_class.* , user.name FROM student_class INNER JOIN user ON student_class.homeroom_teacher = '" . $params . "'")->row_array();
		$data_siswa = $this->db->query("SELECT * FROM user WHERE id = '" . $params . "'")->row_array();
		$data_kelas = $this->db->query("SELECT * FROM student_class WHERE class = '" . $data_siswa['class_name'] . "'")->row_array();
		$data_teacher = $this->db->query("SELECT * FROM user WHERE id = '" . $data_kelas['homeroom_teacher'] . "'")->row_array();

		$paragraf = '<div class="form-group">
		</div>
    	<input type="text" name="id" value="' . $params . '" hidden="true">
		<ul>
		<li>
		Kelas: <span id="class" name="class"> ' . $data_kelas['class'] . '</span>
		</li>
		<li>
		Wali Kelas: <span id="description" name="description"> ' . $data_teacher['name'] . '</span>
    	</li>
		</ul>
		<a href="https://wa.me/' . $data_teacher['phone'] . '?text=Maaf,%20siswa%20bapak%20/%20ibu%20yang%20bernama%20' . $data_siswa['name'] . '%20telat%20datang%20ke%20sekolah.%20Maka%20dari%20itu%20bapak%20/%20ibu%20harap%20untuk%20menjemputnya.%20Terima%20kasih." class="btn btn-success btn-block">HUBUNGI WALI KELAS</a>
    	';
		echo $paragraf;
	}

	public function AjaxJudulDetailSiswa($params = "")
	{

		// $data_siswa = $this->db->query("SELECT student_class.* , user.name FROM student_class INNER JOIN user ON student_class.homeroom_teacher = '" . $params . "'")->row_array();
		$data_siswa = $this->db->query("SELECT * FROM user WHERE id = '" . $params . "'")->row_array();
		$data_kelas = $this->db->query("SELECT * FROM student_class WHERE class = '" . $data_siswa['class_name'] . "'")->row_array();
		$data_teacher = $this->db->query("SELECT * FROM user WHERE id = '" . $data_kelas['homeroom_teacher'] . "'")->row_array();

		$tampil = "INFORMASI SISWA : " . $data_siswa['name'];
		echo $tampil;
	}



	public function AjaxMapel($params = "")
	{
		$mapel = $this->db->get_where('student_lessons', ['mapel_id' => $params])->row_array();
		$loop = "<div class='form-group'>
			<select class='form-control' name='grade' required>";
		if ($mapel['grade'] == 'X') {
			$loop .= "<Option value='X' selected> Kelas X</Option>
				<Option value='XI'> Kelas XI</Option>
				<Option value='XII'> Kelas XII</Option>";
		} elseif ($mapel['grade'] == 'XI') {
			$loop .= "<Option value='X' > Kelas X</Option>
				<Option value='XI' selected> Kelas XI</Option>
				<Option value='XII'> Kelas XII</Option>";
		} else {
			$loop .= "<Option value='X' > Kelas X</Option>
				<Option value='XI' selected> Kelas XI</Option>
				<Option value='XII'> Kelas XII</Option>";
		}
		$loop .= "</div>";
		$paragraf = "
		<input type='hidden' class='form-control' id='lesson' value='" . $params . "' name='id' >
			<div class='form-group'>
				<input type='text' class='form-control' id='lesson' name='lesson' value='" . $mapel['lessons'] . "' placeholder='Nama Mata Pelajaran'>
			</div>
			" . $loop;
		echo $paragraf;
	}
}
