<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Absensi_model');
        $this->load->model('M_Datatables');
        // $cek = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->num_rows();
        // if ( $cek == 0) {
        //     redirect('auth');
        // }


    }

    public function index()
    {
        $data['title'] = 'Admin';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function settings($params = "", $params2 = "")
    {
        if ($params == 'logo') {
            $settings = $this->db->get('settings')->row_array();
            $config['upload_path']          = './assets/images/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 504100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            $config['file_name'] = "profile." . pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
            // echo pathinfo($_FILES['upload']['name'],PATHINFO_EXTENSION);
            $path_to_file = './' . $settings['logo'];
            unlink($path_to_file);

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload')) {
                $error = array('error' => $this->upload->display_errors());
                // $this->load->view('v_upload', $error);
                // echo $error['error'];
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Gagal!",
                   text: "' . $error['error'] . '",
                   icon: "error",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
                redirect('admin/settings');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                $file_name = $upload_data['file_name'];
                $input = [
                    'logo'  => "assets/images/profile." . pathinfo($file_name, PATHINFO_EXTENSION)
                ];
                $this->db->update('settings', $input);
                // echo 
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Berhasil!",
                   text: "Logo Berhasil di Perbaharui",
                   icon: "success",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
                redirect('admin/settings');
            }
        } elseif ($params == 'sampul') {
            $settings = $this->db->get('settings')->row_array();
            $config['upload_path']          = './assets/images/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 504100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            $config['file_name'] = "sampul." . pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
            $path_to_file = './' . $settings['sampul'];
            unlink($path_to_file);

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload')) {
                $error = array('error' => $this->upload->display_errors());
                // $this->load->view('v_upload', $error);
                // echo $error['error'];
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Gagal!",
                   text: "' . $error['error'] . '",
                   icon: "error",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
                redirect('admin/settings');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                $file_name = $upload_data['file_name'];
                $input = [
                    'sampul'  => "assets/images/sampul." . pathinfo($file_name, PATHINFO_EXTENSION)
                ];
                $this->db->update('settings', $input);
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Berhasil!",
                   text: "Foto Sampul Berhasil di Perbaharui",
                   icon: "success",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
                redirect('admin/settings');
                // echo  $file_name;
            }
        } elseif ($params == 'background') {
            $settings = $this->db->get('settings')->row_array();
            $config['upload_path']          = './assets/images/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 504100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            $config['file_name'] = "background." . pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
            $path_to_file = './' . $settings['bg_qrcode'];
            unlink($path_to_file);

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload')) {
                $error = array('error' => $this->upload->display_errors());
                // $this->load->view('v_upload', $error);
                // echo $error['error'];
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Gagal!",
                   text: "' . $error['error'] . '",
                   icon: "error",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
                redirect('admin/settings');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                $file_name = $upload_data['file_name'];
                $input = [
                    'bg_qrcode'  => "assets/images/background." . pathinfo($file_name, PATHINFO_EXTENSION)
                ];
                $this->db->update('settings', $input);
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Berhasil!",
                   text: "Background QR Code Berhasil di Perbaharui",
                   icon: "success",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
                redirect('admin/settings');
                // echo  $file_name;
            }
        } elseif ($params == 'edit') {
            $input = [
                'name'  => $this->input->post('nama'),
                'address'  => $this->input->post('address'),
                'latitude'  => $this->input->post('latitude'),
                'longitude'  => $this->input->post('longitude'),
                'phone'  => $this->input->post('phone')
            ];
            $this->db->update('settings', $input);
            $this->session->set_flashdata('message', '<script>
            swal({
               title: "Berhasil!",
               text: "Data Pengaturan Berhasil di Perbaharui",
               icon: "success",
               button: "Ok"
                   // timer: 3000
               });
               </script>');
            redirect('admin/settings');
        } else {
            $data['title'] = 'Data Pengaturan';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['geolocation'] = $this->Admin_model->getGeolocation()->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/settings', $data);
            $this->load->view('templates/footer');
        }
    }





    public function settings_api($params = "", $params2 = "")
    {
        if ($params == 'edit') {
            $phone         = $this->input->post('phone');
            $no_awal    = substr($phone, 0, 1);
            $no_awal1   = substr($phone, 0, 2);
            $no_awal2   = substr($phone, 0, 3);

            if ($no_awal1 == '08') {
                $nomor = "62" . substr($phone, 1);
                $cek_no = 1;
            } elseif ($no_awal == '8') {
                $nomor = "62" . $phone;
                $cek_no = 1;
            } elseif ($no_awal2 == '008') {
                $nomor = "62" . substr($phone, 2);
                $cek_no = 1;
            } elseif ($no_awal2 == '628') {
                $nomor = $phone;
                $cek_no = 1;
            } else {
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Gagal!",
                   text: "No Telepon Yang anda masukkan tidak valid!",
                   icon: "error",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
                redirect('admin/settings_api');
            }
            $input = [
                'phone'  => $nomor,
                'bot_telegram'  => $this->input->post('bot_telegram'),
                'metode_laporan'  => $this->input->post('metode_laporan')
            ];
            $this->db->update('settings', $input);
            $this->session->set_flashdata('message', '<script>
            swal({
               title: "Berhasil!",
               text: "Pengaturan API Berhasil di Perbaharui",
               icon: "success",
               button: "Ok"
                   // timer: 3000
               });
               </script>');
            redirect('admin/settings_api');
        } else {
            $data['title'] = 'Data Pengaturan';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['geolocation'] = $this->Admin_model->getGeolocation()->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/settings_api', $data);
            $this->load->view('templates/footer');
        }
    }


    public function change_maps_enabled($params = "")
    {
        $data = [
            'maps_enabled' => $params
        ];
        $this->db->update('settings', $data);
        $this->session->set_flashdata(
            'message',
            '<script>
				swal({
					title: "Berhasil",
					text: "Status Map Berhasil di Perbaharui!",
					icon: "success",
					button: "Ok",
					timer: 2000
				});
            </script>'
        );
        redirect('admin/settings');
    }


    public function change_uuid_enabled($params = "")
    {
        $data = [
            'uuid_enabled' => $params
        ];
        $this->db->update('settings', $data);
        $this->session->set_flashdata(
            'message',
            '<script>
				swal({
					title: "Berhasil",
					text: "Status Uuid Berhasil di Perbaharui!",
					icon: "success",
					button: "Ok",
					timer: 2000
				});
            </script>'
        );
        redirect('admin/settings');
    }


    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function addNewRole()
    {
        $role_name = $this->input->post('role_name');
        $data =  [
            'role' => $role_name
        ];
        $this->Admin_model->addNewRole($data);
        $this->session->set_flashdata('message', '<script>
         swal({
            title: "Role Status!",
            text: "Role Baru Berhasil Ditambahkan",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');
        redirect('Admin/role');
    }

    public function deleteRole($id)
    {

        $this->Admin_model->deleteDatarole($id);
        $this->session->set_flashdata('message', '<script>
         swal({
            title: "Role Status!",
            text: "Role Baru Berhasil Dihapus",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');
        redirect('Admin/role');
    }

    public function editRole($id)
    {
        $data['title'] = 'Update Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->Admin_model->getRoleById($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/edit-role', $data);
        $this->load->view('templates/footer');
    }

    public function updateRole()
    {
        $this->Admin_model->updateDataRole();
        $this->session->set_flashdata('message', '<script>
         swal({
            title: "Role Status!",
            text: "Role Baru Berhasil Di Perbaharui",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');
        redirect('admin/role');
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        $this->db->where('id !=1');
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', '<script>
         swal({
            title: "Role Status!",
            text: "Role Baru Berhasil Dirubah",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');
    }

    public function manage()
    {
        $data['title'] = 'KELOLA DATA GURU';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $data['list_user'] = $this->Admin_model->getAll();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/user', $data);
        $this->load->view('templates/footer');
    }

    function data_user()
    {
        $query  = "SELECT * FROM user";
        $search = array('name', 'department', 'email', 'phone', 'gender', 'id');
        $where  = null;
        // $where  = array('role_id' => '3');

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    public function editUserAccess($id)
    {
        $data['title'] = 'Update Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['user_role'] = $this->Admin_model->getUserById($id);
        $data['list_role'] = $this->db->get('user_role')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/edit-access', $data);
        $this->load->view('templates/footer');
    }

    public function updateUserAccess()
    {

        $this->Admin_model->updateAccessUser();
        $this->session->set_flashdata('message', '<script>
         swal({
            title: "Access Status!",
            text: "Akses Berhasil Di Perbarui",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');
        redirect('admin/manage');
    }

    //update user 
    public function deleteUser($id)
    {
        $this->Admin_model->deleteDataUser($id);
        $this->session->set_flashdata('message', '<script>
         swal({
            title: "User Status!",
            text: "User Berhasil Dihapus",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');
        redirect('Admin/manage');
    }

    public function addNewUser()
    {
        $name = $this->input->post('name');
        $gender = $this->input->post('gender');
        $department = $this->input->post('department');
        $nama_department = $this->Admin_model->getRoleById($department);
        $address = $this->input->post('address');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');
        $data =  [
            'name'      => htmlspecialchars($name),
            'email'     => htmlspecialchars($email),
            'image'     => 'default.jpg',
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'phone'         => htmlspecialchars($phone),
            'department'    => $nama_department['role'],
            'address'    => htmlspecialchars($address),
            'gender'        => htmlspecialchars($gender),
            'role_id'       => htmlspecialchars($this->input->post('department')),
            'is_active'     => 1,
            'date_created'  => time()

        ];
        $this->Admin_model->addNewUser($data);
        $this->session->set_flashdata('message', '<script>
         swal({
            title: "user Status!",
            text: "User Baru Berhasil Ditambahkan",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');
        redirect('Admin/manage');
    }


    public function editUserProfile($id = "", $params = "")
    {
        if ($params == 'profile') {
            $role_id = $this->input->post('role');
            $role = $this->Admin_model->getRoleById($role_id);
            $data =  [
                'name'      => htmlspecialchars($this->input->post('name')),
                'email'     => htmlspecialchars($this->input->post('email')),
                'phone'         => htmlspecialchars($this->input->post('phone')),
                'department'    => $role['role'],
                'class_name'    => htmlspecialchars($this->input->post('class_name')),
                'address'    => htmlspecialchars($this->input->post('address')),
                'gender'        => htmlspecialchars($this->input->post('gender')),
                'role_id'       => htmlspecialchars($this->input->post('role'))

            ];
            $this->db->where('id', $id);
            $this->db->update('user', $data);


            $this->session->set_flashdata('message', '<script>
             swal({
                title: "Profile",
                text: "Profile Berhasil DiPerbarui",
                icon: "success",
                button: "Ok"
                // timer: 3000
                });
                </script>');
            //redirect('Admin/editUserProfile/'.$id);
            redirect('operator/siswa');
        } elseif ($params == 'password') {
            $user = $this->Admin_model->getUserById($id);
            // $password = $this->input->post('current_password');
            // if (password_verify($password, $user['password'])) {
            $data = [
                'password' => password_hash($this->input->post('pass1'), PASSWORD_DEFAULT)
            ];
            $this->db->where('id', $id);
            $this->db->update('user', $data);
            $this->session->set_flashdata('message_password', '<script>
                 swal({
                    title: "Password Status!",
                    text: "Password Baru Berhasil Di Perbarui",
                    icon: "success",
                    button: "Ok"
                // timer: 3000
                    });
                    </script>');
            //redirect('Admin/editUserProfile/'.$id);
            redirect('admin/manage');
            // }
            // else{
            // $this->session->set_flashdata('message_password', '<div class="alert alert-danger" role="alert"> Wrong early password! </div>');
            //redirect('Admin/editUserProfile/'.$id);
            // redirect('admin/manage');
            // }
        } elseif ($params == 'status') {
            $user = $this->Admin_model->getUserById($id);

            if ($user['is_flexible'] == '0') {
                $data = [
                    'is_flexible' => '1'
                ];
            } else {
                $data = [
                    'is_flexible' => '0'
                ];
            }

            $this->db->where('id', $id);
            $this->db->update('user', $data);

            $this->session->set_flashdata('message', '<script>
             swal({
                title: "Berhasil",
                text: "Status User Berhasil DiPerbarui",
                icon: "success",
                button: "Ok"
                // timer: 3000
                });
                </script>');
            //redirect('Admin/editUserProfile/'.$id);
            redirect('admin/manage');
        } else {
            $data['title'] = 'Edit  User';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['user_edit'] = $this->Admin_model->getUserById($id);
            $data['role'] = $this->db->get('user_role')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-user', $data);
            $this->load->view('templates/footer');
        }
    }

    public function updateUser()
    {
        $this->Admin_model->updateDatauser();
        $this->session->set_flashdata('message', '<script>
         swal({
            title: "User Status!",
            text: "User Baru Berhasil Di Perbarui",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');
        redirect('admin/manage');
    }

    public function geolocation($params = "", $params2 = "")
    {
        if ($params == 'add') {
            $data = [
                'name' => $this->input->post('nama'),
                'place_id' => $this->input->post('place_id'),
                'date_create' => date('Y-m-d')
            ];
            $this->db->insert('data_geolocation', $data);
            $this->session->set_flashdata('message', '<script>
             swal({
                title: "Berhasil!",
                text: "Data Geolocation Berhasil di Tambahkan",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');
            redirect('admin/geolocation');
        } elseif ($params == 'edit') {
            $data = [
                'name' => $this->input->post('nama'),
                'place_id' => $this->input->post('place_id')
            ];
            $this->db->where('id', $params2);
            $this->db->update('data_geolocation', $data);
            $this->session->set_flashdata('message', '<script>
             swal({
                title: "Berhasil!",
                text: "Data Geolocation Berhasil di Perbaharui",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');
            redirect('admin/geolocation');
        } elseif ($params == 'hapus') {
            $this->db->where('id', $params2);
            $this->db->delete('data_geolocation');
            $this->session->set_flashdata('message', '<script>
             swal({
                title: "Berhasil!",
                text: "Data Geolocation Berhasil di Hapus",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');
            redirect('admin/geolocation');
        } else {
            $data['title'] = 'Data Geolocation';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['geolocation'] = $this->Admin_model->getGeolocation()->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/geolocation', $data);
            $this->load->view('templates/footer');
        }
    }

	public function qr($params = "", $params2 = "")
	{
		$data['title'] = 'QR Code';
		$data['qr'] = $this->db->get('qr')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		if ($params == "add") {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randstring = '';
			for ($i = 0; $i < 20; $i++) {
				$randstring = $randstring . $characters[rand(0, strlen($characters))];
			}
			$data = [
				'qr_token' => $randstring
			];
			$this->db->insert('qr', $data);
			$this->session->set_flashdata('message', '<script>
                swal({
                    title: "QR Token!",
                    text: "QR Token Berhasil Di Tambahkan",
                    icon: "success",
                    button: "Ok"
                    // timer: 3000
                    });
                    </script>');
                    
			include APPPATH . 'third_party/php-qrcode-library/qrlib.php';


			/*create folder*/
			$tempdir = "assets/qr/";
			if (!file_exists($tempdir))
				mkdir($tempdir, 0755);
			$kode = $randstring;
			$file_name = $kode . ".png";
			$file_path = $tempdir . $file_name;

			QRcode::png($kode, $file_path, "H", 12, 2);
			/* param (1)qrcontent,(2)filename,(3)errorcorrectionlevel,(4)pixelwidth,(5)margin */

			redirect('admin/qr');

		} elseif ($params == "delete") {
			$this->db->where('id', $params2);
			$this->db->delete('qr');
			$this->session->set_flashdata('message', '<script>
               swal({
                title: "QR Token!",
                text: "QR Token Berhasil Di Hapus",
                icon: "success",
                button: "Ok"
                // timer: 3000
                });
                </script>');
                
			redirect('admin/qr');
		} 
		elseif ($params == "cetak") 
		{
			//$this->db->where('id', $params2);
			$data['cetak_qr'] = $this->db->get_where('qr',['id' => $params2])->row_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/bg_qr_code', $data);
			$this->load->view('templates/footer');
		} 
		elseif ($params == "ganti") 
		{
			$config['upload_path']          = './assets/images/qr-template/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['max_size']             = 54100;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
			// $config['file_name']			= "QR-TEMPLATE.png";

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('upload')){
                $error = array('error' => $this->upload->display_errors());
                // $this->load->view('v_upload', $error);
                // echo $error['error'];
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Gagal!",
                   text: "'.$error['error'].'",
                   icon: "error",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
               redirect('admin/qr');
            }
			else{
                $data = array('upload_data' => $this->upload->data());
                $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                $file_name = $upload_data['file_name'];
                $input = [
                    'bg-qrcode'  => "assets/images/qr-template/".$file_name
					// 'bg-qrcode'  => "assets/images/qr-template/QR-TEMPLATE.png"
                ];
                $this->db->update('settings', $input);
                $this->session->set_flashdata('message', '<script>
                swal({
                   title: "Berhasil!",
                   text: "Background Berhasil diganti!",
                   icon: "success",
                   button: "Ok"
                       // timer: 3000
                   });
                   </script>');
				redirect($_SERVER['HTTP_REFERER']);
            }
		} 
		else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/qrcode', $data);
			$this->load->view('templates/footer');
		}
	}


    public function addJarak()
    {
        $jarak =  $this->input->post('jarak');
        $status = $this->input->post('status');

        $data = [
            'jarak' => $jarak,
            'status' => $status
        ];
        $this->Absensi_model->addnewJarak($data);
        $this->session->set_flashdata('message', '<script>
                     swal({
                title: "Jarak Absen!",
                text: "Jarak Berhasil Ditambahkan",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
        redirect('operator/jarak');
    }

    public function deleteJarak($id)
    {
        $this->Absensi_model->deleteJarak($id);

        $this->session->set_flashdata('message', '<script>
                     swal({
                title: "Jarak Absen!",
                text: "Jarak Absen Berhasil Dihapus",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
        redirect('operator/jarak');
    }



    public function editJarak($id)
    {
        $data['title'] = 'Update Jarak';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['jarak_id'] = $this->Absensi_model->getJarakId($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('operator/edit-jarak', $data);
        $this->load->view('templates/footer');
    }


    public function updateJarak()
    {
        $this->Absensi_model->updateJarak();
        $this->session->set_flashdata('message', '<script>
                     swal({
                title: "Jarak Absen!",
                text: "Jarak Berhasil Diperbaharui",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
        redirect('operator/jarak');
    }


    public function update_pkl($params = "")
    {
        $user = $this->db->get_where('user', ['id' => $params])->row_array();
        if ($user['is_pkl'] == '1') {
            $data = [
                'is_pkl' => 0
            ];
        } else {
            $data = [
                'is_pkl' => 1
            ];
        }
        $this->db->where('id', $params);
        $this->db->update('user', $data);

        $this->session->set_flashdata('message', '<script>
                     swal({
                title: "Berhasil!",
                text: "Status Siswa Berhasil di Perbaharui",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
        redirect('operator/siswa');
    }
}
