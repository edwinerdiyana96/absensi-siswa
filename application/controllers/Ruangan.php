<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Ruangan extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Absensi_model');
        // $cek = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->num_rows();
        // if ( $cek == 0) {
        //     redirect('auth');
        // }


    }



    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('ruangan/index', $data);
        $this->load->view('templates/footer');
    }



}
