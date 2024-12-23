<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Absensi_model');
		$this->load->model('Siswa_model');
		$this->load->model('Operator_model');
		$this->load->model('M_Datatables');
	}

	public function index()
	{
		$data['title'] = 'Dashboard Siswa';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['class_leader'] = $this->Siswa_model->getClassLeader($data['user']['id'])->num_rows();

		$data['attendace_today'] = $this->Absensi_model->getAttendanceAll()->result_array();
		$data['hadir'] = $this->db->query("SELECT attendance_id FROM student_attendance WHERE user_id = '".$data['user']['id']."' AND month = '".date('Y-m')."' AND ( status = '1' OR status = '2')")->num_rows();
		$data['sakit'] = $this->db->query("SELECT attendance_id FROM student_attendance WHERE user_id = '".$data['user']['id']."' AND month = '".date('Y-m')."' AND status = '3'")->num_rows();
		$data['izin'] = $this->db->query("SELECT attendance_id FROM student_attendance WHERE user_id = '".$data['user']['id']."' AND month = '".date('Y-m')."' AND status = '4'")->num_rows();
		$data['alpha'] = $this->db->query("SELECT attendance_id FROM student_attendance WHERE user_id = '".$data['user']['id']."' AND month = '".date('Y-m')."' AND status = '0'")->num_rows();

		$data['status_siswa'] = $this->Absensi_model->status_pembelajaran_siswa($data['user']['class_name']);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('siswa/index', $data);
		$this->load->view('templates/footer');
	}

	public function rekap_absen($params="")
	{
		$data['title'] = 'REKAP ABSENSI';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		
		if ($params=="filter") {
			$data['bulan_sekarang'] = $this->input->post('filter');
			$data['sortir'] = 'Filter Harian';
			$data['kelas'] = "-";
			$data['mapel'] = '-';
		}elseif($params=="filter_mapel"){
			$data['bulan_sekarang'] = $this->input->post('filter');
			$data['sortir'] = 'Filter Bulanan';
			$data['mapel'] = $this->input->post('mapel');
		} else{
			$data['tanggal_sekarang'] = date('Y-m-d');
			$data['bulan_sekarang'] = date('Y-m');
			$data['sortir'] = 'Filter Harian';
			$data['kelas'] = 'X TKJ 1';
			$data['mapel'] = '-';
		}
		$data['class'] = $this->Operator_model->getAllClass()->result_array();

		$data['array_mapel'] = $this->Siswa_model->getMapelBySiswa($data['user']['id'])->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('laporan/rekap_siswa', $data);
		$this->load->view('templates/footer');
	}

	function data_rekap_siswa($params="", $user="")
	{
		date_default_timezone_set("Asia/Jakarta");

		$query  = "SELECT * FROM `student_attendance` 
		JOIN `user` ON student_attendance.`user_id` = user.`id`";
		$search = array('attendance_id', 'user_id', 'name', 'class_name', 'date', 'time', 'status', 'description');
		// $where  = null;
		$where  = array(
			'month' => $params,
			'user_id' => $user
		);

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}


	function data_rekap_siswa_mapel($params="", $user="")
	{
		date_default_timezone_set("Asia/Jakarta");
		$siswa = $this->db->query("SELECT * FROM user WHERE id = '".$user."'")->row_array();
		$kelas = $this->db->query("SELECT * FROM student_class WHERE class = '".$siswa['class_name']."'")->row_array();
		$grade = $kelas['grade'];
		$query  = "SELECT * FROM `student_room_absent` 
		JOIN `student_room_history` ON student_room_absent.`room_history_id` = student_room_history.`id`
		JOIN `student_lessons` ON student_room_absent.lessons_id = student_lessons.mapel_id";
		$search = array('student_room_id','status','room_id','teacher_id','lessons_id','time','date');
		// $where  = null;
		$where  = array(
			'lessons_id' => $params,
			'student_id' => $user
		);

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_rekap_siswa($query, $search, $where, $isWhere);
	}


	function qrcode(){
		$data['title'] = 'Qr Code';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		if ($data['user']['qr_code'] != 'OK') {
			include APPPATH . 'third_party/php-qrcode-library/qrlib.php';
			/*create folder*/
			$tempdir = "assets/qr/";
			if (!file_exists($tempdir))
				mkdir($tempdir, 0755);
			$kode = $data['user']['id'];
			$file_name = $kode . ".png";
			$file_path = $tempdir . $file_name;

			QRcode::png($kode, $file_path, "H", 12, 2);
			/* param (1)qrcontent,(2)filename,(3)errorcorrectionlevel,(4)pixelwidth,(5)margin */
			$input = [
				'qr_code' => 'OK'
			];
			$this->db->where('id', $data['user']['id']);
			$this->db->update('user', $input);
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('siswa/qr_code', $data);
		$this->load->view('templates/footer');
	}
}
