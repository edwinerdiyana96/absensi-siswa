<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Absensi_model');
        
    }

    public function index()
    {
        // is_logged_in();
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['bulan'] = array(
            '0' => 'Januari',
            '1' => 'Februari',
            '2' => 'Maret',
            '3' => 'April',
            '4' => 'Mei',
            '5' => 'Juni',
            '6' => 'Juli',
            '7' => 'Agustus',
            '8' => 'September',
            '9' => 'Oktober',
            '10' => 'November',
            '11' => 'Desember',
        );

        $tanggal_awal = date('Y-m-')."1";
        $tanggal_akhir = date('Y-m-')."31";

        // $data['riwayat'] = $this->Absensi_model->getAbsensiUserByDate($data['user']['id'],$tanggal_awal,$tanggal_akhir)->result_array();
        // $id = $this->session->userdata('id');
        // $data['data_pegawai'] = $this->Admin_model->getPegawaibyId($id)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }



    
    public function edit()
    {
        
            $data['title'] = 'Edit Profile';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/updateProfile', $data);
            $this->load->view('templates/footer');
        
            $phone= $this->input->post('phone');
            $email= $this->input->post('email');
            $address = $this->input->post('address');
            //cek jika ada gambar
            $upload_image = $_FILES['image']['name'];

            $upload_image = str_replace(" ", "", $upload_image);

            if ($upload_image) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $data = [
            'phone' => $phone,
            'address' => $address
            ];

            $this->db->where('email', $email);
            $this->db->update('user',$data);
            $this->session->set_flashdata('message_profile', '<script>
                     swal({
                title: "Profile",
                text: "Profile Telah di Perbarui",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
            redirect('user/updateProfile');
        
    }



    public function updateProfile()
    {
        // $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[6]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/updateProfile', $data);
            $this->load->view('templates/footer');
        } else {
            // $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            // if ($current_password == $new_password) {
            if ($new_password) {
                $this->session->set_flashdata('message','<script>
                     swal({
                title: "Password",
                text: "Password Telah di Perbarui",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
                redirect('user/updateProfile');
            } else {
                //password oke 
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->set('password', $password_hash);
                $this->db->where('email', $this->session->userdata('email'));
                $this->db->update('user');
                $this->session->set_flashdata('message','<script>
                     swal({
                title: "Password",
                text: "Password Telah di Perbarui",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
                redirect('user/updateProfile');
            }
           
        }
    }




    
}
