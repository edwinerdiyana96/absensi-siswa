<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Absensi_model');
        $this->load->model('Laporan_model');
        $this->load->model('M_Datatables');
        // $cek = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->num_rows();
        // if ( $cek == 0) {
        //     redirect('auth');
        // }


    }


    public function index($params = "")
    {
        if ($params == "") {
            $data['tanggal'] = date('Y-m-d');
        } else {
            $data['tanggal'] = $this->input->post('tanggal');
        }

        $data['title'] = 'Dashboard Laporan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['total_siswa'] = $this->Laporan_model->total_siswa();
        $data['total_guru'] = $this->Laporan_model->total_guru();
        $data['total_ruangan'] = $this->Laporan_model->total_ruangan();
        $data['total_siswa_hadir'] = $this->db->query("SELECT * FROM student_attendance WHERE date = '" . date('Y-m-d') . "' AND (status = '0' OR status = '1')")->num_rows();
        $data['total_siswa_tidak_hadir'] = $this->db->query("SELECT * FROM student_attendance WHERE date = '" . date('Y-m-d') . "' AND (status != '0' AND status != '1')")->num_rows();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    function monitoring_ruangan()
    {
        date_default_timezone_set("Asia/Jakarta");
        //user.name
        //user.class_name, 
        //studet_room.description
        //student_room_history.is_done
        // $query  = "SELECT user.name, user.class_name,student_room.description,student_room_history.is_done FROM user JOIN student_room ON user.id = student_room.pic JOIN student_room_history ON student_room_history.teacher_id = student_room.pic";
        $query  = "SELECT * FROM student_room
        JOIN user ON student_room.pic = user.id";
        $search = array('description', 'pic', 'name', 'room_id');
        $where  = null;
        // $where  = array(
        //     'is_done' => '0',
        //     'is_done' => '1'
        // );

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_monitoring_ruangan($query, $search, $where, $isWhere);
    }



    public function guru_mapel($params = "")
    {

        $data['title'] = 'Detail Pembelajaran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pembelajaran'] = $this->db->get_where('student_room_history', ['id' => $params])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/guru_mapel', $data);
        $this->load->view('templates/footer');
    }
}
