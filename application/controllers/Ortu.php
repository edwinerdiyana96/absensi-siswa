<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ortu extends CI_controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('Admin_model');
		$this->load->model('Absensi_model');
		$this->load->model('Siswa_model');
		$this->load->model('Operator_model');
		$this->load->model('M_Datatables');
        $this->load->helper('cookie');
    }
    
    public function index()
    {
        $data['title'] = "Pendaftaran Akun Orangtua";
        $this->load->view('auth/header', $data);
        $this->load->view('auth/daftar_ortu');
        $this->load->view('auth/footer');

    }

    public function add(){
        $cek = $this->db->query("SELECT * FROM student_parent where nis = '".$this->input->post('nis')."'")->num_rows();
        $cek_nis = $this->db->query("SELECT * FROM user where email = '".$this->input->post('nis')."'")->num_rows();
        if ($cek!=0) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="danger">Akun ortu dengan nis tersebut sudah terdaftar, harap hubungi admin untuk info selanjutnya!</div>');
            redirect('ortu');
        }elseif ($cek_nis==0) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="danger">NIS yang di inputkan tidak valid, harap cek kembali!</div>');
            redirect('ortu');
        }else{
            $data = [
                'nis' => $this->input->post('nis'),
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'password' => $this->input->post('password')
            ];
            $this->db->insert('student_parent', $data);

            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="danger">Data Akun Berhasil di Tambahkan!</div>');
            redirect('ortu');
        }
    }

    public function dashboard()
    {
        $data['title'] = 'Dashboard Orang Tua Siswa';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['class_leader'] = $this->Siswa_model->getClassLeader($data['user']['id'])->num_rows();

		$data['attendace_today'] = $this->Absensi_model->getAttendanceAll()->result_array();
		$data['hadir'] = $this->Absensi_model->total_hadir_siswa_perorang($data['user']['id']);
		$data['sakit'] = $this->Absensi_model->total_sakit_siswa_perorang($data['user']['id']);
		$data['izin'] = $this->Absensi_model->total_izin_siswa_perorang($data['user']['id']);
		$data['alpha'] = $this->Absensi_model->total_alpha_siswa_perorang($data['user']['id']);


		$this->load->view('templates_ortu/header', $data);
		$this->load->view('templates_ortu/sidebar', $data);
		$this->load->view('templates_ortu/topbar', $data);
		$this->load->view('ortu/index', $data);
		$this->load->view('templates_ortu/footer');

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
		}
		$data['class'] = $this->Operator_model->getAllClass()->result_array();

		$data['array_mapel'] = $this->Siswa_model->getMapelBySiswa($data['user']['id'])->result_array();

		$this->load->view('templates_ortu/header', $data);
		$this->load->view('templates_ortu/sidebar', $data);
		$this->load->view('templates_ortu/topbar', $data);
		$this->load->view('laporan/rekap_siswa', $data);
		$this->load->view('templates_ortu/footer');
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

		$query  = "SELECT * FROM `student_room_absent` 
		JOIN `student_room_history` ON student_room_absent.`room_history_id` = student_room_history.`id`";
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

   
}
