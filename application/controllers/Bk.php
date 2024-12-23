<?php

defined('BASEPATH') or exit('No  direct script access allowed');

class Bk extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Admin_model');
		$this->load->model('Absensi_model');
		$this->load->model('M_Datatables');
	}

	public function index($params = "")
	{

		$data['title'] = 'DATA KEHADIRAN SISWA (' . date("Y-m-d") . ')';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		date_default_timezone_set("Asia/Jakarta");
		$time = new DateTime("now");
		$curr_time = $time->format('H:i:s');

		if ($params == "edit") {
			$data = [
				'status' => $this->input->post('status'),
				'description' => $this->input->post('description'),
				'time' => $curr_time
			];
			$this->db->where('attendance_id', $this->input->post('attendance_id'));
			$this->db->update('student_attendance', $data);

			$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data Kehadiran Siswa Berhasil di Perbaharui!",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
			redirect('bk/siswa_telat');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('bk/index', $data);
			$this->load->view('templates/footer');
		}
	}

	public function siswa_telat()
	{

		$data['title'] = 'DAFTAR SISWA TERLAMBAT (' . date("Y-m-d") . ')';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['user_id'] = $this->input->post('id');
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('bk/siswa_telat', $data);
		$this->load->view('templates/footer');
	}


	function data_siswa_telat()
	{
		date_default_timezone_set("Asia/Jakarta");
		$query  = "SELECT * FROM student_attendance INNER JOIN user ON student_attendance.user_id = user.id";
		$search = array('name', 'date', 'time', 'status', 'description', 'attendance_id');
		// $where  = null; 
		$where  = array(
			'date' => date("Y-m-d"),
			'status' == '2' and 'status' == '0'
		);

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}

	function data_student_attendance()
	{
		date_default_timezone_set("Asia/Jakarta");
		$query  = "SELECT * FROM student_attendance INNER JOIN user ON student_attendance.user_id = user.id";
		$search = array('name', 'date', 'time', 'status', 'description', 'attendance_id');
		// $where  = null; 
		$where  = array(
			'date' => date("Y-m-d"),
			'status' == '2' and 'status' == '0'
		);

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}

	public function update()
	{
		$this->Absensi_model->siswa_telat();

		$this->session->set_flashdata('message', '<script>
           swal({
            title: "Absensi Status!",
            text: "Berhasil Mengubah Status Absensi!",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');

		redirect('bk');
	}
}
