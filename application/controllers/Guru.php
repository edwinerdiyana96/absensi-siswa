<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Guru extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Auth_model');
        $this->load->model('Absensi_model');
        $this->load->model('Operator_model');
        $this->load->model('M_Datatables');
        // $cek = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->num_rows();
        // if ( $cek == 0) {
        //     redirect('auth');
        // }


    }


    public function index()
    {

        $data['title'] = 'Dashboard Guru';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kelas'] = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();
        $data['attendace_today'] = $this->Absensi_model->getAttendanceAll()->result_array();
        $data['hadir'] = $this->Absensi_model->total_hadir_siswa_perkelas();
        $data['hadir_telat'] = $this->Absensi_model->total_hadir_telat_siswa_perkelas();
        $data['sakit'] = $this->Absensi_model->total_sakit_siswa_perkelas();
        $data['izin'] = $this->Absensi_model->total_izin_siswa_perkelas();
        $data['alpha'] = $this->Absensi_model->total_alpha_siswa_perkelas();
        $data['status_guru'] = $this->Absensi_model->status_pembelajaran($data['user']['id'])->num_rows();
        // $data['status_guru'] = 0;

        $data_kelas = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->num_rows();
        if ($data_kelas == 0) {
            $data['nama_kelas'] = "-";
        } else {
            $data['wali_kelas'] = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();
            $data['nama_kelas'] = $data['wali_kelas']['class'];

            // Ambil semua kelas yang sesuai dengan homeroom_teacher yang sama
            $kelas = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->result_array();
            // Inisialisasi sebuah array untuk menyimpan nama kelas
            $nama_kelas = [];
            // Loop melalui hasil query dan tambahkan nama kelas ke dalam array
            foreach ($kelas as $row) {
            $nama_kelas[] = $row['class'];
            }
            $data['nama_kelas'] = implode(', ', $nama_kelas); // Menggabungkan semua nama kelas menjadi satu string
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('guru/index', $data);
        $this->load->view('templates/footer');
    }


    // public function rekap_absen_kelas() {

    //     $data['title'] = 'Dashboard Guru > Rekap Absen';
    //     $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/sidebar', $data);
    //         $this->load->view('templates/topbar', $data);
    //         $this->load->view('guru/rekap_absen_kelas', $data);
    //         $this->load->view('templates/footer');
    // }



    public function absen_siswa()
    {

        $data['title'] = 'Dashboard Guru';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('guru/absen_siswa', $data);
        $this->load->view('templates/footer');
    }

    public function guru_mapel($params = "")
    {

        $data['title'] = 'Detail Pembelajaran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pembelajaran'] = $this->db->get_where('student_room_history', ['id' => $params])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('scan/guru_mapel', $data);
        $this->load->view('templates/footer');
    }

    public function mapel($params = "", $params2 = "")
    {
        if ($params == 'add') {
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data = [
                'lessons_id' => $this->input->post('mapel'),
                'user_id' => $user['id']
            ];
            $this->db->insert('teacher_lessons', $data);
            $this->session->set_flashdata('message', '<script>
            swal({
                title: "Data Mapel!",
                text: "Data Mata Pelajaran Berhasil di Tambahkan!",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');

            redirect('guru/mapel');
        } elseif ($params == 'add_new') {
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $cek = $this->db->query("SELECT * FROM student_lessons WHERE lessons = '" . $this->input->post('lesson') . "' AND grade = '" . $this->input->post('grade') . "'")->num_rows();
            if ($cek == 0) {
                $cek = $this->db->query("SELECT * FROM student_lessons WHERE lessons = '" . strtoupper($this->input->post('lesson')) . "' AND grade = '" . $this->input->post('grade') . "'")->num_rows();
                if ($cek == 0) {
                    $cek = $this->db->query("SELECT * FROM student_lessons WHERE lessons = '" . strtolower($this->input->post('lesson')) . "' AND grade = '" . $this->input->post('grade') . "'")->num_rows();
                    if ($cek == 0) {
                        $data = [
                            'lessons' => $this->input->post('lesson'),
                            'grade' => $this->input->post('grade')
                        ];
                        $this->db->insert('student_lessons', $data);
                        $this->session->set_flashdata('message', '<script>
                        swal({
                            title: "Berhasil!",
                            text: "Mata Pelajaran Berhasil Di Tambahkan",
                            icon: "success",
                            button: "Ok"
                        // timer: 3000
                            });
                            </script>');
                        redirect('guru/mapel');
                    } else {
                        $this->session->set_flashdata('message', '<script>
                        swal({
                            title: "Gagal!",
                            text: "Mata Pelajaran Sudah Ada",
                            icon: "error",
                            button: "Ok"
                        // timer: 3000
                            });
                            </script>');
                        redirect('guru/mapel');
                    }
                } else {
                    $this->session->set_flashdata('message', '<script>
                    swal({
                        title: "Gagal!",
                        text: "Mata Pelajaran Sudah Ada",
                        icon: "error",
                        button: "Ok"
                    // timer: 3000
                        });
                        </script>');
                    redirect('guru/mapel');
                }
            } else {
                $this->session->set_flashdata('message', '<script>
				swal({
					title: "Gagal!",
					text: "Mata Pelajaran Sudah Ada",
					icon: "error",
					button: "Ok"
                // timer: 3000
					});
					</script>');
                redirect('guru/mapel');
            }
        } elseif ($params == 'delete') {
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

            $this->db->where('lessons_id', $params2);
            $this->db->where('user_id', $user['id']);
            $this->db->delete('teacher_lessons');

            $this->session->set_flashdata('message', '<script>
            swal({
                title: "Data Mapel!",
                text: "Data Mata Pelajaran Berhasil di Hapus!",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');

            redirect('guru/mapel');
        } else {
            $data['title'] = 'DATA MAPEL';
            $data['mapel'] = $this->db->get('student_lessons')->result_array();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('guru/mapel', $data);
            $this->load->view('templates/footer');
        }
    }

    function data_mapel($user_id = "")
    {
        date_default_timezone_set("Asia/Jakarta");
        $query  = "SELECT student_lessons.*, teacher_lessons.teacher_lessons_id FROM student_lessons 
        INNER JOIN teacher_lessons ON teacher_lessons.lessons_id = student_lessons.mapel_id
        ";
        $search = array('mapel_id', 'lessons', 'grade', 'teacher_lessons.teacher_lessons_id');
        // $where  = null;
        $where  = array(
            'mapel_id !' => 0,
            'user_id' => $user_id
        );

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_query_mapel($query, $search, $where, $isWhere);
    }

    function data_student_attendance()
    {
        date_default_timezone_set("Asia/Jakarta");
        $kelas = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();

        $query  = "SELECT * FROM student_attendance inner JOIN user ON student_attendance.class = user.class_name";
        $search = array('name', 'class_name', 'date', 'time', 'status', 'description', 'attendance_id');
        // $where  = null; 
        $where  = array(
            'date' => date("Y-m-d"),
            'status' == '2' and 'status' == '0',
            'student_attendance.class' => $kelas
        );

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }



    function data_student_attendance_walikelas()
    {
        $id_wali_kelas = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        date_default_timezone_set("Asia/Jakarta");
        $query  = "SELECT * FROM student_attendance INNER JOIN user ON student_attendance.user_id = user.id";
        $search = array('name', 'class_name', 'date', 'time', 'status', 'description', 'attendance_id');
        // $where  = null; 
        $where  = array(
            'date' => date("Y-m-d"),
            'teacher_id' => $id_wali_kelas
            // 'status' == '2' and 'status' == '0'
        );

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }


    public function hadir($id = "")
    {
        $this->Absensi_model->siswa_hadir($id);

        $this->session->set_flashdata('message', '<script>
           swal({
            title: "Absensi Status!",
            text: "Berhasil Mengubah Status Absensi!",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');

        redirect('guru');
    }

    public function telat($id = "")
    {
        $this->Absensi_model->siswa_telat($id);

        $this->session->set_flashdata('message', '<script>
           swal({
            title: "Absensi Status!",
            text: "Berhasil Mengubah Status Absensi!",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');

        redirect('guru');
    }

    public function sakit($id = "")
    {
        $this->Absensi_model->siswa_sakit($id);

        $this->session->set_flashdata('message', '<script>
           swal({
            title: "Absensi Status!",
            text: "Berhasil Mengubah Status Absensi!",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');

        redirect('guru');
    }

    public function izin($id = "")
    {
        $this->Absensi_model->siswa_izin($id);

        $this->session->set_flashdata('message', '<script>
           swal({
            title: "Absensi Status!",
            text: "Berhasil Mengubah Status Absensi!",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');

        redirect('guru');
    }

    public function alpha($id = "")
    {
        $this->Absensi_model->siswa_alpha($id);

        $this->session->set_flashdata('message', '<script>
           swal({
            title: "Absensi Status!",
            text: "Berhasil Mengubah Status Absensi!",
            icon: "success",
            button: "Ok"
                // timer: 3000
            });
            </script>');

        redirect('guru');
    }








    public function rekap($params = "")
    {
        $data['title'] = 'REKAP ABSENSI';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kelas'] = $this->db->get_where('user', ['class_name' => $this->session->userdata('class_name')])->row_array();
        $kelas_wali = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();



        if ($params == "filter_harian") {
            $data['tanggal_sekarang'] = $this->input->post('filter');
            $data['bulan_sekarang'] = date('Y-m');
            $data['sortir'] = 'Filter Harian';
            $data['kelas'] = $this->input->post('class');
        } elseif ($params == "filter_bulanan") {
            $data['tanggal_sekarang'] = date('Y-m-d');
            $data['bulan_sekarang'] = $this->input->post('filter');
            $data['sortir'] = 'Filter Bulanan';
            $data['kelas'] = $this->input->post('class');
        } else {
            $data['tanggal_sekarang'] = date('Y-m-d');
            $data['bulan_sekarang'] = date('Y-m');
            $data['sortir'] = 'Filter Harian';
            if ($data['user']['role_id'] == '3') {
                $data['kelas'] = $kelas_wali['class'];
            } else {
                $data['kelas'] = "X TKJ 2";
            }
        }

        $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $kelas = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();
        $data['class'] = $this->Absensi_model->getAllClassWali($user['id'])->result_array();
        // $data['class'] = $this->absensi_model->getAllStudent()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('guru/rekap_absen_kelas', $data);
        $this->load->view('templates/footer');
    }

    function data_rekap_harian($params = "", $kelas = "")
    {
        date_default_timezone_set("Asia/Jakarta");
        $kelas = str_replace("-", " ", $kelas);

        $query  = "SELECT * FROM `student_attendance` 
		JOIN `user` ON student_attendance.`user_id` = user.`id`";
        $search = array('attendance_id', 'user_id', 'name', 'class_name', 'date', 'time', 'status', 'description');
        // $where  = null;
        $where  = array(
            'date' => $params,
            'class_name' => $kelas
        );

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    function data_rekap_bulanan($bulan = "", $kelas = "")
    {
        date_default_timezone_set("Asia/Jakarta");
        $kelas = str_replace("-", " ", $kelas);

        $tgl1 = date('Y-m-d', strtotime($bulan));
        $tgl2 = date('Y-m-d', strtotime('+1 month', strtotime($bulan)));

        $query  = "SELECT * FROM `user`";
        $search = array('name', 'class_name', 'view_sakit', 'view_izin', 'view_alpha', 'view_hadir', 'view_tidak_hadir', 'view_persentase');
        // $where  = null;
        $where  = array(
            'class_name' => $kelas
        );

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_rekap_bulanan($query, $search, $where, $isWhere, $tgl1, $tgl2);
    }





    public function export_laporan()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $alignment_center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
        $alignment_right = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT;

        $sheet->setCellValue('A1', "LAPORAN DATA SISWA SMK KARYA NASIONAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $sheet->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
        $sheet->setCellValue('A2', "Jl. Cirendang - Cigugur, Cirendang, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45518"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A2:I2'); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('A1')->getAlignment()->setHorizontal($alignment_center);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal($alignment_center);

        // Buat header tabel nya pada baris ke 3

        $sheet->setCellValue('A4', "NIS");
        $sheet->setCellValue('B4', "Nama");
        $sheet->setCellValue('C4', "Kelas");
        $sheet->setCellValue('D4', "Sakit");
        $sheet->setCellValue('E4', "Izin");
        $sheet->setCellValue('F4', "Alpha");
        $sheet->setCellValue('G4', "Total Kehadiran");
        $sheet->setCellValue('H4', "Total Tidak Hadir");
        $sheet->setCellValue('I4', "Persentase");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A4')->applyFromArray($style_col);
        $sheet->getStyle('B4')->applyFromArray($style_col);
        $sheet->getStyle('C4')->applyFromArray($style_col);
        $sheet->getStyle('D4')->applyFromArray($style_col);
        $sheet->getStyle('E4')->applyFromArray($style_col);
        $sheet->getStyle('F4')->applyFromArray($style_col);
        $sheet->getStyle('G4')->applyFromArray($style_col);
        $sheet->getStyle('H4')->applyFromArray($style_col);
        $sheet->getStyle('I4')->applyFromArray($style_col);

        // Set height baris ke 1, 2 dan 3
        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);
        $sheet->getRowDimension('4')->setRowHeight(20);

        // Buat query untuk menampilkan semua data siswa
        $kelas = $this->input->post('class');
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $class = $this->db->query("SELECT * FROM student_class WHERE class = '" . $kelas . "'")->row_array();
        $data = $this->db->query("SELECT * FROM user WHERE role_id = '6' AND class_name = '" . $kelas . "'")->result_array();

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data as $key => $data) { // Ambil semua data dari hasil eksekusi $sql

            $tidak_hadir = 0;
            $persentase = 0;
            $sakit = $this->db->query("SELECT * FROM student_attendance where user_id = '" . $data['id'] . "' AND date >= '" . $awal . "' AND date <= '" . $akhir . "' AND status = '3'")->num_rows();
            $izin = $this->db->query("SELECT * FROM student_attendance where user_id = '" . $data['id'] . "' AND date >= '" . $awal . "' AND date <= '" . $akhir . "' AND status = '4'")->num_rows();
            $alpha = $this->db->query("SELECT * FROM student_attendance where user_id = '" . $data['id'] . "' AND date >= '" . $awal . "' AND date <= '" . $akhir . "' AND status = '0'")->num_rows();
            $hadir = $this->db->query("SELECT * FROM student_attendance where user_id = '" . $data['id'] . "' AND date >= '" . $awal . "' AND date <= '" . $akhir . "' AND status = '1'")->num_rows();
            $tidak_hadir = $sakit + $izin + $alpha;
            $semua = $hadir + $tidak_hadir;
            if ($hadir == 0) {
                $persentase = 0;
            } else {
                $persentase = number_format(($hadir / $semua) * 100, 2);
            }

            $sheet->setCellValue('A' . $numrow, $data['email']);
            $sheet->setCellValue('B' . $numrow, $data['name']);
            $sheet->setCellValue('C' . $numrow, $data['class_name']);
            $sheet->setCellValue('D' . $numrow, $sakit);
            $sheet->setCellValue('E' . $numrow, $izin);
            $sheet->setCellValue('F' . $numrow, $alpha);
            $sheet->setCellValue('G' . $numrow, $hadir);
            $sheet->setCellValue('H' . $numrow, $tidak_hadir);
            $sheet->setCellValue('I' . $numrow, $persentase . " %");

            // Khusus untuk no telepon. kita set type kolom nya jadi STRING
            // $sheet->setCellValue('E'.$numrow, $data['telp']);
            // $sheet->setCellValue('F'.$numrow, $data['alamat']);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);

            $sheet->getRowDimension($numrow)->setRowHeight(20);
            $numrow++;
        }

        $no++; // Tambah 1 setiap kali looping
        $numrow++;
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(15); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(15); // Set width kolom F
        $sheet->getColumnDimension('G')->setWidth(15); // Set width kolom C
        $sheet->getColumnDimension('H')->setWidth(15); // Set width kolom F
        $sheet->getColumnDimension('I')->setWidth(15); // Set width kolom C

        $sheet->setCellValue('G' . $numrow, "Kuningan, " . tgl_indo(date('d-m-Y'))); // Set mengetahui
        $sheet->mergeCells('G' . $numrow . ':H' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_right);
        $numrow++;

        $sheet->setCellValue('B' . $numrow, "Kasubag TU");
        $sheet->mergeCells('B' . $numrow . ':C' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('B' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1

        $sheet->setCellValue('G' . $numrow, "Staff Kepegawaian");
        $sheet->mergeCells('G' . $numrow . ':H' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_right);
        $numrow = $numrow + 5;

        $sheet->setCellValue('B' . $numrow, "Eman Arisman");
        $sheet->mergeCells('B' . $numrow . ':C' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('B' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1

        // kelas 10 : Nono Sumartono
        // Kelas 11 : Yadi Suryadi
        // Kelas 12 : Dodi
        if ($class['grade'] == 'X') {
            $sheet->setCellValue('G' . $numrow, "Nono Sumartono");
            $sheet->mergeCells('G' . $numrow . ':H' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
            $sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
            $sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_right);
            $numrow++;
        } elseif ($class['grade'] == 'XI') {
            $sheet->setCellValue('G' . $numrow, "Yadi Suryadi");
            $sheet->mergeCells('G' . $numrow . ':H' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
            $sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
            $sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_right);
            $numrow++;
        } else {
            $sheet->setCellValue('G' . $numrow, "Dodi");
            $sheet->mergeCells('G' . $numrow . ':H' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
            $sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
            $sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_right);
            $numrow++;
        }


        $sheet->setCellValue('C' . $numrow, "Mengetahui");
        $sheet->mergeCells('C' . $numrow . ':F' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('C' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('C' . $numrow)->getAlignment()->setHorizontal($alignment_center);
        $numrow++;

        $sheet->setCellValue('C' . $numrow, "Kepala Sekolah");
        $sheet->mergeCells('C' . $numrow . ':F' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('C' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('C' . $numrow)->getAlignment()->setHorizontal($alignment_center);
        $numrow = $numrow + 5;

        $sheet->setCellValue('C' . $numrow, "Dr.Yepi Esa Trijaka, M.M.Pd");
        $sheet->mergeCells('C' . $numrow . ':F' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('C' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('C' . $numrow)->getAlignment()->setHorizontal($alignment_center);

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        if ($awal == $akhir) {
            $tanggal_laporan = $awal;
        } else {
            $tanggal_laporan = $awal . "  s.d  " . $akhir;
        }
        // Set judul file excel nya
        $sheet->setTitle($tanggal_laporan);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Kehadiran Siswa.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }




    public function room_teacher($params = "")
    {
        date_default_timezone_set("Asia/Jakarta");
        if ($params == "filter") {
            $data['tanggal_sekarang'] = $this->input->post('filter');
        } else {
            $data['tanggal_sekarang'] = date('Y-m-d');
        }
        $data['title'] = 'Rekap Pembelajaran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('guru/room_teacher', $data);
        $this->load->view('templates/footer');
    }

    public function mapel_detail($params = "", $params2 = "")
    {
        if ($params == '1') {
            $status = 'Hadir Tepat Waktu';
            $kd = $params;
            $description = '-';
        } elseif ($params == '2') {
            $status = 'Hadir Terlambat';
            $kd = $params;
            $description = '-';
        } elseif ($params == '3') {
            $status = 'Sakit';
            $kd = $params;
            $description = '-';
        } elseif ($params == '4') {
            $status = 'Izin';
            $kd = $params;
            $description = '-';
        } elseif ($params == 'PKL') {
            $status = 'PKL/OJT';
            $kd = '0';
            $description = 'PKL';
        } else {
            $status = 'Alpha/Tidak Hadir';
            $kd = $params;
            $description = '-';
        }

        // $data['pembelajaran'] = $this->db->query("SELECT student_room_absent.*, user.name FROM student_room_absent 
        // INNER JOIN user ON student_room_absent.student_id = user.id
        // WHERE student_room_absent.room_history_id = '".$params2."' AND student_room_absent.status = '".$kd."' AND student_room_absent.description = '".$description."'")->result_array();
        $data['status'] = $status;
        $data['kd'] = $kd;
        $data['description'] = $description;
        $data['id'] = $params2;
        $data['title'] = 'Data Siswa ' . $status;
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('guru/room_detail', $data);
        $this->load->view('templates/footer');
    }

    function detail_pembelajaran($id = "", $status = "", $description = "")
    {

        $query  = "SELECT student_room_absent.*, user.name FROM student_room_absent 
        INNER JOIN user ON student_room_absent.student_id = user.id
        ";
        $search = array('student_room_id', 'name', 'time', 'tanggal', 'status', 'description');
        // $where  = null;
        if ($status == '0' and $description == '-') {
            $where  = array(
                'student_room_absent.room_history_id' => $id,
                'student_room_absent.status' => $status,
                'student_room_absent.description !' => 'PKL/OJT'
            );
        } elseif ($status == 0 and $description == 'PKL') {
            $where  = array(
                'student_room_absent.room_history_id' => $id,
                'student_room_absent.status' => $status,
                'student_room_absent.description' => "PKL/OJT"
            );
        } else {
            $where  = array(
                'student_room_absent.room_history_id' => $id,
                'student_room_absent.status' => $status,
                'student_room_absent.description' => $description
            );
        }

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // if ($status=='0') {
        //     $isWhere = "WHERE student_room_absent.room_history_id = '".$id."' AND student_room_absent.status = '".$status."' AND student_room_absent.description != 'PKL/OJT'";
        // }else{
        //     $isWhere = "WHERE student_room_absent.room_history_id = '".$id."' AND student_room_absent.status = '".$status."' AND student_room_absent.description = '".$description."'";
        // }

        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    function data_pembelajaran($tanggal = "")
    {
        date_default_timezone_set("Asia/Jakarta");
        $tgl1 = $tanggal . " 00:00:00";
        $tgl2 = $tanggal . " 24:00:00";
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $query  = "SELECT student_room.no, student_room.description, student_room_history.* , student_lessons.lessons FROM `student_room_history` 
        JOIN student_room ON student_room_history.room_id = student_room.room_id
        JOIN student_lessons ON student_room_history.lesson_id = student_lessons.mapel_id";
        $search = array('id', 'no', 'description', 'start_time', 'end_time', 'lessons');
        // $where  = null;
        $where  = array(
            'date' => $tanggal,
            'teacher_id' => $user['id']
        );

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    public function update_mapel_pembelajaran($params = "")
    {
        $data = [
            'lesson_id' => $this->input->post('lessons')
        ];
        $this->db->where('id', $params);
        $this->db->update('student_room_history', $data);

        $data = [
            'lessons_id' => $this->input->post('lessons')
        ];
        $this->db->where('room_history_id', $params);
        $this->db->update('student_room_absent', $data);

        $this->session->set_flashdata('message', '<script>
            swal({
                title: "Update Berhasl!",
                text: "Berhasil Mengubah Mapel Pembejalaran!",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');

        redirect($_SERVER['HTTP_REFERER']);
        // Menghapus flash data secara manual
        $this->session->unset_flashdata('message');
    }


    function data_student_absent($id = "")
    {
        date_default_timezone_set("Asia/Jakarta");

        $query  = "SELECT user.name, student_room_absent.* FROM student_room_absent inner JOIN user ON student_room_absent.student_id = user.id";
        $search = array('name', 'time', 'status');
        // $where  = null; 
        $where  = array(
            'room_history_id' => $id
        );

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
    }

    public function update_status_student_absent($status = "", $id = "")
    {
        $data = [
            'time' => date('H:i:s'),
            'status' => $status
        ];
        $this->db->where('student_room_id', $id);
        $this->db->update('student_room_absent', $data);

        $student_absent = $this->db->query("SELECT * FROM student_room_absent WHERE student_room_id = '" . $id . "'")->row_array();
        $cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $student_absent['student_id'] . "' AND date = '" . $student_absent['tanggal'] . "' AND time = '00:00:00'")->num_rows();

        if ($cek_absen > 0) {
            $data = [
                'status' => $status,
                'time' => date('H:i:s')
            ];
        } else {
            $data = [
                'status' => $status
            ];
        }
        $this->db->where('user_id', $student_absent['student_id']);
        $this->db->where('date', $student_absent['tanggal']);
        $this->db->update('student_attendance', $data);

        $this->session->set_flashdata('message', '<script>
            swal({
                title: "Update Berhasl!",
                text: "Berhasil Mengubah Status Absen Siswa!",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');

        redirect($_SERVER['HTTP_REFERER']);
        // Menghapus flash data secara manual
        $this->session->unset_flashdata('message');
    }


    public function end_pembelajaran($id = "")
    {
        $data = [
            'is_done' => '1',
            'end_time' => date('H:i:s')
        ];
        $this->db->where('id', $id);
        $this->db->update('student_room_history', $data);

        $this->session->set_flashdata('message', '<script>
            swal({
                title: "Update Berhasl!",
                text: "Pembelajaran berhasil di akhiri!",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');

        redirect('guru/room_teacher');
    }


    public function start_pembelajaran($id = "", $ruangan_id)
    {
        $data = [
            'is_done' => '1',
            'end_time' => date('H:i:s')
        ];
        $this->db->where('id', $id);
        $this->db->update('student_room_history', $data);

        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $user_id = $user['id'];

        $data = [
            'room_id' => $ruangan_id,
            'lesson_id' => 0,
            'teacher_id' => $user_id,
            'class' => '-',
            'date' => date('Y-m-d'),
            'start_time' => date('H:i:s'),
            'is_done' => '0'
        ];

        // $this->db->where('attendance_id', $attendance_id);
        $this->db->insert('student_room_history', $data);

        $room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $ruangan_id . "' AND is_done = '0'")->row_array();

        $this->session->set_flashdata('message', '<script>
		   swal({
			title: "Pembelajaran Baru!",
			text: "Pembelajaran Baru Berhasil di Buka!",
			icon: "success",
			button: "OK"
		// timer: 3000
			});
			</script>');
        redirect('guru/guru_mapel/' . $room_history['id']);
    }

    function absensi_pusat($params = "")
    {
        if ($params == 'cek') {
            $hasil_scan = $this->input->post('qr');
            $today = date('D');
            // $scan = $this->db->query("SELECT * FROM qr where qr_token = '" . $hasil_scan . "'")->num_rows();
            $scan = $this->db->query("SELECT * FROM user WHERE id = '" . $hasil_scan . "'")->num_rows();
            if ($scan == 1) {
                $data['title'] = 'Absensi Pusat';
                $data['user'] = $this->db->get_where('user', ['id' => $this->input->post('qr')])->row_array();
                $data['user_id'] = $hasil_scan;
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('scan/absen_pusat', $data);
                $this->load->view('templates/footer');
            } elseif ($scan == 0) {
                // $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
                $this->session->set_flashdata(
                    'message',
                    '<script>
					swal({
						title: "QR Code Status",
						text: "QR Token Tidak Valid",
						icon: "error",
						button: "Ok",
						timer: 2000
					});
				</script>'
                );
                // redirect('operator/absen_pusat');
                echo $hasil_scan;
            }
        } else {
            $data['title'] = 'Absensi Pusat';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('scan/scan_pusat', $data);
            $this->load->view('templates/footer');
        }
    }

    public function absen($user_id = "")
    {
        // $user_id = $this->input->post('qr');
        $hasil_scan = $user_id;
        $today = date('D');
        // $scan = $this->db->query("SELECT * FROM qr where qr_token = '" . $hasil_scan . "'")->num_rows();
        $scan = $this->db->query("SELECT * FROM user WHERE id = '" . $hasil_scan . "'")->num_rows();
        if ($scan == 1) {
            $this->Absensi_model->absen_pusat($user_id);
        } elseif ($scan == 0) {
            // $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
            $this->session->set_flashdata(
                'message',
                '<script>
				swal({
					title: "QR Code Status",
					text: "QR Token Tidak Valid",
					icon: "error",
					button: "Ok",
					timer: 2000
				});
            </script>'
            );
            redirect('guru/absensi_pusat');
        }
    }

    public function save_capture($user_id = "")
    {
        $image = $this->input->post('image');
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = base64_decode($image);
        $filename = 'image_' . time() . '.png';
        file_put_contents(FCPATH . '/uploads/' . $filename, $image);

        $data_attendance = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $user_id . "' AND date = '" . date('Y-m-d') . "'")->row_array();
        $cek_data_picture = $this->db->query("SELECT * FROM student_picture WHERE student_attendance = '" . $data_attendance['attendance_id'] . "'")->num_rows();
        $insert = array(
            'student_attendance' => $data_attendance['attendance_id'],
            'image' => $filename
        );
        if ($cek_data_picture == 0) {
            $this->db->insert('student_picture', $insert);
        } else {
            $this->db->where('student_attendance', $data_attendance['attendance_id']);
            $this->db->update('student_picture', $insert);
        }
    }

    public function update_pembelajaran()
    {
        $isi_post = $this->input->post();
        $total =  count($isi_post['aksi']);
        $status = $isi_post['pilihan'];

        for ($i = 0; $i < $total; $i++) {
            if ($status == 'delete') {
                $this->db->where('student_room_id', $isi_post['aksi'][$i]);
                $this->db->delete('student_room_absent');
            } else {
                $student_absent = $this->db->query("SELECT * FROM student_room_absent WHERE student_room_id = '" . $isi_post['aksi'][$i] . "'")->row_array();
                $siswa = $this->db->get_where('user', ['id' => $student_absent['student_id']])->row_array();
                if ($siswa['is_pkl'] == 0) {
                    echo $siswa['is_pkl'];
                    $data = [
                        'time' => date('H:i:s'),
                        'status' => $status
                    ];
                    $this->db->where('student_room_id', $isi_post['aksi'][$i]);
                    $this->db->update('student_room_absent', $data);
                }
                $cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id = '" . $student_absent['student_id'] . "' AND date = '" . $student_absent['tanggal'] . "' AND time = '00:00:00'")->num_rows();

                if ($siswa['is_pkl'] == 0) {
                    if ($cek_absen > 0) {
                        $data = [
                            'status' => $status,
                            'time' => date('H:i:s')
                        ];
                    } else {
                        $data = [
                            'status' => $status
                        ];
                    }
                    $this->db->where('user_id', $student_absent['student_id']);
                    $this->db->where('date', $student_absent['tanggal']);
                    $this->db->update('student_attendance', $data);
                }
            }
        }
        // $this->session->set_flashdata('message', '<script>
        //     swal({
        //         title: "Update Berhasl!",
        //         text: "Berhasil Mengubah Status Absen Siswa!",
        //         icon: "success",
        //         button: "Ok"
        //             // timer: 3000
        //         });
        //         </script>');

        // redirect($_SERVER['HTTP_REFERER']);
    }


    public function update_pembelajaran2()
    {
        $isi_post = $this->input->post();
        // echo $isi_post['pilih0'];
        $cek = 0;
        $array = $this->db->query("SELECT user.name, user.is_pkl, student_room_absent.* FROM student_room_absent 
        inner JOIN user ON student_room_absent.student_id = user.id where room_history_id = '" . $isi_post['room_history_id'] . "'")->result_array();
        foreach ($array as $key => $array) {
            if ($isi_post['aksi'] == 'desktop') {
                $menu = 'pilih' . $cek;
            } else {
                $menu = 'm' . $cek;
            }

            if ($isi_post[$menu] == 'hapus') {
                $this->db->where('student_room_id', $array['student_room_id']);
                $this->db->delete('student_room_absent');
            } else {

                if ($isi_post[$menu] == 'PKL/OJT') {
                    $status = '0';
                    $description = 'PKL/OJT';
                    // echo "OJT1";
                } elseif ($isi_post[$menu] == 'Lainnya') {
                    $status = '0';
                    $description = 'Lainnya';
                } elseif ($isi_post[$menu] == 'Bolos') {
                    $status = '0';
                    $description = 'Bolos';
                } elseif ($isi_post[$menu] == 'Alfa') {
                    $status = '0';
                    $description = 'Alfa';
                } elseif ($isi_post[$menu] == 'Dispensasi') {
                    $status = '0';
                    $description = 'Dispensasi';
                } elseif ($isi_post[$menu] == 'Tugas Luar/Tugas Sekolah') {
                    $status = '0';
                    $description = 'Tugas Luar/Tugas Sekolah';
                } else {
                    $status = $isi_post[$menu];
                    $description = '-';
                }

                if ($array['is_pkl'] == 0) {
                    // echo "OKE";
                    $data = [
                        'status' => $status,
                        'description' => $description,
                        'time' => date('H:i:s')
                    ];
                    $this->db->where('student_room_id', $array['student_room_id']);
                    $this->db->update('student_room_absent', $data);

                    $data = [
                        'status' => $isi_post[$menu],
                        'description' => $description
                    ];
                    $this->db->where('user_id', $array['student_id']);
                    $this->db->where('date', $array['tanggal']);
                    $this->db->update('student_attendance', $data);
                }
            }
            $cek++;
        }

        $this->session->set_flashdata('message', '<script>
            swal({
                title: "Update Berhasl!",
                text: "Berhasil Mengubah Status Absen Siswa!",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');

        redirect($_SERVER['HTTP_REFERER']);
        // Menghapus flash data secara manual
        $this->session->unset_flashdata('message');
    }



    public function kirim_pesan()
    {
        $isi_post = $this->input->post();
        $cek_kelas = $this->db->query("SELECT * FROM student_class WHERE class = '" . $isi_post['class'] . "'")->row_array();
        $settings = $this->db->get('settings')->row_array();
        if ($cek_kelas['kode_group'] == "" && $settings['metode_laporan'] == 'Whatsapp') {
            echo "Kode Group Blum ada";
        } elseif ($cek_kelas['chat_id'] == "" && $settings['metode_laporan'] == 'Telegram') {
            echo "Kode Group Blum ada";
        } else {
            $hasil_rekap = "";
            $rekap = $this->db->query("SELECT student_attendance.user_id, COUNT(student_attendance.attendance_id) as total, user.name 
            FROM student_attendance 
            INNER JOIN user ON user.id = student_attendance.user_id
            WHERE student_attendance.status = 2 AND student_attendance.class = '" . $isi_post['class'] . "' AND student_attendance.date BETWEEN '" . $isi_post['awal'] . "' AND '" . $isi_post['akhir'] . "' 
            GROUP BY student_attendance.user_id")->result_array();
            $hasil_rekap .= "*--- Rekap Siswa telat ---*
";
            foreach ($rekap as $key => $rekap) {
                $hasil_rekap .= $rekap['name'] . " : " . $rekap['total'] . " hari
";
            }

            $rekap = $this->db->query("SELECT student_attendance.user_id, COUNT(student_attendance.attendance_id) as total, user.name 
            FROM student_attendance 
            INNER JOIN user ON user.id = student_attendance.user_id
            WHERE student_attendance.status = 3 AND student_attendance.class = '" . $isi_post['class'] . "' AND student_attendance.date BETWEEN '" . $isi_post['awal'] . "' AND '" . $isi_post['akhir'] . "' 
            GROUP BY student_attendance.user_id")->result_array();
            $hasil_rekap .= "
            
*--- Rekap Siswa Sakit ---*
";
            foreach ($rekap as $key => $rekap) {
                $hasil_rekap .= $rekap['name'] . " : " . $rekap['total'] . " hari
";
            }


            $rekap = $this->db->query("SELECT student_attendance.user_id, COUNT(student_attendance.attendance_id) as total, user.name 
            FROM student_attendance 
            INNER JOIN user ON user.id = student_attendance.user_id
            WHERE student_attendance.status = 4 AND student_attendance.class = '" . $isi_post['class'] . "' AND student_attendance.date BETWEEN '" . $isi_post['awal'] . "' AND '" . $isi_post['akhir'] . "' 
            GROUP BY student_attendance.user_id")->result_array();
            $hasil_rekap .= "

*--- Rekap Siswa Izin ---*
";
            foreach ($rekap as $key => $rekap) {
                $hasil_rekap .= $rekap['name'] . " : " . $rekap['total'] . " hari
";
            }



            $rekap = $this->db->query("SELECT student_attendance.user_id, COUNT(student_attendance.attendance_id) as total, user.name 
            FROM student_attendance 
            INNER JOIN user ON user.id = student_attendance.user_id
            WHERE student_attendance.status = 0 AND student_attendance.class = '" . $isi_post['class'] . "' AND student_attendance.date BETWEEN '" . $isi_post['awal'] . "' AND '" . $isi_post['akhir'] . "' 
            GROUP BY student_attendance.user_id")->result_array();
            $hasil_rekap .= "
            
*--- Rekap Siswa Alpha ---*
";
            foreach ($rekap as $key => $rekap) {
                $hasil_rekap .= $rekap['name'] . " : " . $rekap['total'] . " hari
";
            }
            $data_pesan = "*======== DATA LAPORAN ABSENSI ========*
Tanggal : " . date('d-M-Y', strtotime($isi_post['awal'])) . " - " . date('d-M-Y', strtotime($isi_post['akhir'])) . "

" . $hasil_rekap . "
            ";
            $data_pesan = urlencode($hasil_rekap);
            echo $data_pesan;


            https: //api.telegram.org/bot5962774962:AAH7GGErG1xLb9mxhAx9KOJlLtQxMxQ0NEw/sendMessage?chat_id=-1001504113209&text=test123456789

            if ($settings['metode_laporan'] == 'Whatsapp') {
                $curl = curl_init();
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api-whatsapp.smkkarnas.id/sendtext?number=' . $settings['phone'] . '&to=' . $cek_kelas['kode_group'] . '&message=' . $data_pesan,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;
            } else {
                $api = 'https://api.telegram.org/' . $settings['bot_telegram'] . ':' . $settings['token_telegram'] . '/sendMessage?chat_id=-' . $cek_kelas['chat_id'] . '&text=' . $data_pesan . '';
                $ch = curl_init($api);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CAINFO, $cainfo);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($date));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, "CURL_HTTP_VERSION_2TLS");
                curl_setopt($ch, CURLOPT_SSLVERSION, "CURL_SSLVERSION_TLSv1_2");
                $result = curl_exec($ch);
                curl_close($ch);

                var_dump($api);
                echo $result;
            }


            // curl_setopt_array($curl, array(
            //   CURLOPT_URL => 'https://api-whatsapp.smkkarnas.id/sendmessage?number='.$settings['phone'],
            //   CURLOPT_RETURNTRANSFER => true,
            //   CURLOPT_ENCODING => '',
            //   CURLOPT_MAXREDIRS => 10,
            //   CURLOPT_TIMEOUT => 0,
            //   CURLOPT_FOLLOWLOCATION => true,
            //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //   CURLOPT_CUSTOMREQUEST => 'POST',
            //   CURLOPT_POSTFIELDS =>'{ "to": "'.$cek_kelas['kode_group'].'", "message": { "text": "'.$data_pesan.'"}}',
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);
            // echo $response;

            // $phone_no = '6283199766610';
            // $key='iay747isynk0bxhkq4uilwpscyha9yh'; //this is demo key please change with your own key
            // $url='https://api.easywa.id/v1/send-group';
            // $data = array(
            // //   "group_id" => "120363041823309375",
            // "group_id" => $cek_kelas['kode_group'],
            // "message" => $data_pesan
            // );
            // $data_string = json_encode($data);

            // $ch = curl_init($url);
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_VERBOSE, 0);
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            // curl_setopt($ch, CURLOPT_TIMEOUT, 360);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //     'email: it.smkkarnas.40@gmail.com',
            //     'secret-key: iay747isynk0bxhkq4uilwpscyha9yh',
            //     'Content-Type: application/json',
            //     'Content-Length: ' . strlen($data_string)
            // )
            // );
            // echo $res=curl_exec($ch);
            // curl_close($ch);


            redirect('guru/rekap');
        }
    }



    // =================================== Controler Absen Siswa ===================================
    public function absensi_kelas($params = "")
    {
        $data['title'] = 'DATA ABSENSI';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $kelas_wali = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();

        if ($params == "filter_harian") {
            $data['tanggal_sekarang'] = $this->input->post('filter');
            $data['bulan_sekarang'] = date('Y-m');
            $data['sortir'] = 'Filter Harian';
            $data['kelas'] = $this->input->post('class');
        } elseif ($params == "filter_bulanan") {
            $data['tanggal_sekarang'] = date('Y-m-d');
            $data['bulan_sekarang'] = $this->input->post('filter');
            $data['sortir'] = 'Filter Bulanan';
            $data['kelas'] = $this->input->post('class');
        } else {
            $data['tanggal_sekarang'] = date('Y-m-d');
            $data['bulan_sekarang'] = date('Y-m');
            $data['sortir'] = 'Filter Harian';
            if ($data['user']['role_id'] == '3') {
                $data['kelas'] = $kelas_wali['class'];
            } else {
                $data['kelas'] = "-";
            }
        }
        //$data['class'] = $this->db->query("SELECT * FROM student_class 
        //WHERE homeroom_teacher = '" . $data['user']['id'] . "'
        //")->result_array();
        $user = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $kelas = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();
        $data['class'] = $this->Absensi_model->getAllClassWali($user['id'])->result_array();
        // $data['class'] = $this->absensi_model->getAllStudent()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('guru/absensi', $data);
        $this->load->view('templates/footer');
    }


    public function update_absensi_perwalian()
	{
		$isi_post = $this->input->post();
		// echo $isi_post['pilih0'];
		$cek = 0;
		$array = $this->db->query("SELECT * FROM student_attendance where date = '" . $isi_post['tanggal'] . "' AND class like '" . $isi_post['class'] . "%'")->result_array();
		foreach ($array as $key => $array) {
			if ($isi_post['aksi'] == 'desktop') {
				$menu = 'pilih' . $cek;
			} else {
				$menu = 'm' . $cek;
			}
			$var_user = 'user' . $cek;

			if ($isi_post[$menu] == 'Lainnya') {
				$data = [
					'status' => 0,
					'description' => 'Lainnya'
				];
				$this->db->where('user_id', $isi_post[$var_user]);
				$this->db->where('date', $array['date']);
				$this->db->update('student_attendance', $data);
			} elseif ($isi_post[$menu] == 'PKL/OJT') {
				$data = [
					'status' => 0,
					'description' => 'PKL/OJT'
				];
				$this->db->where('user_id', $isi_post[$var_user]);
				$this->db->where('date', $array['date']);
				$this->db->update('student_attendance', $data);
			} elseif ($isi_post[$menu] == 'Bolos') {
				$data = [
					'status' => 0,
					'description' => 'Bolos'
				];
				$this->db->where('user_id', $isi_post[$var_user]);
				$this->db->where('date', $array['date']);
				$this->db->update('student_attendance', $data);
			} else {
				$data = [
					'status' => $isi_post[$menu]
				];
				$this->db->where('user_id', $isi_post[$var_user]);
				$this->db->where('date', $array['date']);
				$this->db->update('student_attendance', $data);
			}



			// echo $isi_post[$var_user]." = ";
			// echo $isi_post[$menu]."<br>";
			$cek++;
		}

		$this->session->set_flashdata('message', '<script>
            swal({
                title: "Update Berhasl!",
                text: "Berhasil Mengubah Status Absen Siswa!",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');

        redirect('guru/absensi_kelas');
        // Menghapus flash data secara manual
        $this->session->unset_flashdata('message');
	}


    public function update_absensi()
    {
        $isi_post = $this->input->post();
        // echo $isi_post['pilih0'];
        $cek = 0;
        $array = $this->db->query("SELECT * FROM student_attendance where date = '" . $isi_post['tanggal'] . "' AND class like '" . $isi_post['class'] . "%'")->result_array();
        foreach ($array as $key => $array) {
            if ($isi_post['aksi'] == 'desktop') {
                $menu = 'pilih' . $cek;
            } else {
                $menu = 'm' . $cek;
            }
            $var_user = 'user' . $cek;

            $data = [
                'status' => $isi_post[$menu]
            ];
            $this->db->where('user_id', $isi_post[$var_user]);
            $this->db->where('date', $array['date']);
            $this->db->update('student_attendance', $data);

            // echo $isi_post[$var_user]." = ";
            // echo $isi_post[$menu]."<br>";
            $cek++;
        }

        $this->session->set_flashdata('message', '<script>
            swal({
                title: "Update Berhasl!",
                text: "Berhasil Mengubah Status Absen Siswa!",
                icon: "success",
                button: "Ok"
                    // timer: 3000
                });
                </script>');

        redirect($_SERVER['HTTP_REFERER']);
        // Menghapus flash data secara manual
        $this->session->unset_flashdata('message');
    }



    public function export_rekap()
    {
        $spreadsheet    = new Spreadsheet();
        $sheet          = $spreadsheet->getActiveSheet();
        $isi_post       = $this->input->post();
        $user           = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];


        $row_sheet = 0;

        $history = $this->db->get_where('student_room_history', ['teacher_id' => $user['id'], 'date' => $isi_post['tanggal']])->result_array();
        foreach ($history as $key => $history) {
            // Buat header tabel nya pada baris ke 3
            $sheet->setCellValue('A1', "NO"); // Set kolom A3 dengan tulisan "NO"
            $sheet->setCellValue('B1', "Tanggal"); // Set kolom B3 dengan tulisan "NIS"
            $sheet->setCellValue('C1', "Nama"); // Set kolom C3 dengan tulisan "NAMA"
            $sheet->setCellValue('D1', "Kelas"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
            $sheet->setCellValue('E1', "Mata Pelajaran"); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('F1', "Status Absensi"); // Set kolom E3 dengan tulisan "ALAMAT"
            $sheet->setCellValue('G1', "Keterangan"); // Set kolom E3 dengan tulisan "ALAMAT"

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $sheet->getStyle('A1')->applyFromArray($style_col);
            $sheet->getStyle('B1')->applyFromArray($style_col);
            $sheet->getStyle('C1')->applyFromArray($style_col);
            $sheet->getStyle('D1')->applyFromArray($style_col);
            $sheet->getStyle('E1')->applyFromArray($style_col);
            $sheet->getStyle('F1')->applyFromArray($style_col);
            $sheet->getStyle('G1')->applyFromArray($style_col);

            // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
            // $detail = $this->db->get_where('student_room_absent', ['room_history_id' => $history['id']])->result_array();
            $detail = $this->db->query("SELECT student_room_absent.*, user.name, user.class_name, student_lessons.lessons  FROM student_room_absent 
            INNER JOIN user on student_room_absent.student_id = user.id
            INNER JOIN student_lessons ON student_room_absent.lessons_id = student_lessons.mapel_id
            where student_room_absent.room_history_id = '" . $history['id'] . "'
            ")->result_array();
            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach ($detail as $detail) { // Lakukan looping pada variabel siswa
                if ($detail['status'] == '1') {
                    $status = 'Hadir Tepat Waktu';
                } elseif ($detail['status'] == '2') {
                    $status = 'Hadir Terlambat';
                } elseif ($detail['status'] == '3') {
                    $status = 'Sakit';
                } elseif ($detail['status'] == '4') {
                    $status = 'Izin';
                } else {
                    if ($detail['description'] == 'Bolos') {
                        $status = 'Bolos';
                    } elseif ($detail['description'] == 'PKL/OJT') {
                        $status = 'Sedang PKL/OJT';
                    } elseif ($detail['description'] == 'Lainnya') {
                        $status = 'Lainnya';
                    } else {
                        $status = 'Alfa/Belum Absen';
                    }
                }

                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $detail['tanggal']);
                $sheet->setCellValue('C' . $numrow, $detail['name']);
                $sheet->setCellValue('D' . $numrow, $detail['class_name']);
                $sheet->setCellValue('E' . $numrow, $detail['lessons']);
                $sheet->setCellValue('F' . $numrow, $status);
                $sheet->setCellValue('G' . $numrow, $detail['description']);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
            }

            // Set width kolom
            $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
            $sheet->getColumnDimension('B')->setWidth(25); // Set width kolom B
            $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
            $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
            $sheet->getColumnDimension('E')->setWidth(20); // Set width kolom E
            $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E
            $sheet->getColumnDimension('G')->setWidth(20); // Set width kolom E


            // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
            $sheet->getDefaultRowDimension()->setRowHeight(-1);
            // Set orientasi kertas jadi LANDSCAPE
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            // Set judul file excel nya
            $sheet->setTitle($history['class']);
            $row_sheet++;
            // Create a new worksheet, after the default sheet
            $spreadsheet->createSheet();
            //sleep for 3 seconds
            sleep(3);
        }
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Rekap Pembelajaran.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }



    public function export_rekap_satuan($id = "")
    {
        $spreadsheet    = new Spreadsheet();
        $sheet          = $spreadsheet->getActiveSheet();
        $user           = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $history = $this->db->get_where('student_room_history', ['id' => $id])->row_array();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel  
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];


        $row_sheet = 0;

        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A1', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B1', "Tanggal"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C1', "Nama"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D1', "Kelas"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E1', "Mata Pelajaran"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('F1', "Status Absensi"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G1', "Keterangan"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A1')->applyFromArray($style_col);
        $sheet->getStyle('B1')->applyFromArray($style_col);
        $sheet->getStyle('C1')->applyFromArray($style_col);
        $sheet->getStyle('D1')->applyFromArray($style_col);
        $sheet->getStyle('E1')->applyFromArray($style_col);
        $sheet->getStyle('F1')->applyFromArray($style_col);
        $sheet->getStyle('G1')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        // $detail = $this->db->get_where('student_room_absent', ['room_history_id' => $history['id']])->result_array();
        $detail = $this->db->query("SELECT student_room_absent.*, user.name, user.class_name, student_lessons.lessons  FROM student_room_absent 
            INNER JOIN user on student_room_absent.student_id = user.id
            INNER JOIN student_lessons ON student_room_absent.lessons_id = student_lessons.mapel_id
            where student_room_absent.room_history_id = '" . $history['id'] . "'
            ")->result_array();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($detail as $detail) { // Lakukan looping pada variabel siswa
            if ($detail['status'] == '1') {
                $status = 'Hadir Tepat Waktu';
            } elseif ($detail['status'] == '2') {
                $status = 'Hadir Terlambat';
            } elseif ($detail['status'] == '3') {
                $status = 'Sakit';
            } elseif ($detail['status'] == '4') {
                $status = 'Izin';
            } else {
                if ($detail['description'] == 'Bolos') {
                    $status = 'Bolos';
                } elseif ($detail['description'] == 'PKL/OJT') {
                    $status = 'Sedang PKL/OJT';
                } elseif ($detail['description'] == 'Lainnya') {
                    $status = 'Lainnya';
                } else {
                    $status = 'Alfa/Belum Absen';
                }
            }

            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $detail['tanggal']);
            $sheet->setCellValue('C' . $numrow, $detail['name']);
            $sheet->setCellValue('D' . $numrow, $detail['class_name']);
            $sheet->setCellValue('E' . $numrow, $detail['lessons']);
            $sheet->setCellValue('F' . $numrow, $status);
            $sheet->setCellValue('G' . $numrow, $detail['description']);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(20); // Set width kolom E


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle($history['class']);
        $row_sheet++;
        // Create a new worksheet, after the default sheet
        $spreadsheet->createSheet();
        //sleep for 3 seconds

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Rekap Pembelajaran.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }





    public function kirim_laporan($params = "", $params2 = "", $params3 = "")
    {
        $kelas = $this->db->get_where('student_class', ['class_id' => $params2])->row_array();
        $history = $this->db->get_where('student_room_history', ['id' => $params3])->row_array();
        $user = $this->db->get_where('user', ['id' => $history['teacher_id']])->row_array();
        $mapel = $this->db->get_where('student_lessons', ['mapel_id' => $history['lesson_id']])->row_array();
        $wali_kelas = $this->db->get_where('user', ['id' => $kelas['homeroom_teacher']])->row_array();
        if ($params == '0') {
            $status = 'Alpha/Belum Absen';
        } elseif ($params == '1') {
            $status = 'Hadir Tepat Waktu';
        } elseif ($params == '2') {
            $status = 'Hadir Telat';
        } elseif ($params == '3') {
            $status = 'Sakit';
        } elseif ($params == '4') {
            $status = 'Izin';
        } elseif ($params == 'PKL') {
            $status = 'PKL/OJT';
        } elseif ($params == 'SIAT') {
            $status = 'SAKIT/IZIN/ALPA/TELAT';
        } else {
            $status = 'Alpha/Belum Absen';
        }
        //   echo $params2;
        
//*Data Siswa* : " . $status . "
        $isi_pesan = "[PESAN OTOMATIS] - ABSENSI ONLINE
*- Kelas* : " . $kelas['class'] . "
*- Wali Kelas* : " . $wali_kelas['name'] . "
*- Tanggal* : " . tgl_indo($history['date']) . "
*- Guru* : " . $user['name'] . "
*- Mata Pelajaran* : " . $mapel['lessons'] . "
            
";
        $no = 1;
        $kode_group = "";
        if ($status == 'PKL/OJT') {
            $room_absent = $this->db->get_where('student_room_absent', ['room_history_id' => $params3, 'description' => $status])->result_array();
        } elseif ($status == 'Alpha/Belum Absen') {
            $room_absent = $this->db->get_where('student_room_absent', ['room_history_id' => $params3, 'description' => '-', 'status' => $status])->result_array();
        } elseif ($status == 'SAKIT/IZIN/ALPA/TELAT') {
            $status_array = [0, 3, 4, 2];
            $this->db->where('room_history_id', $params3);
            $this->db->where('description', '-');
            $this->db->where_in('status', $status_array);
            $room_absent = $this->db->get('student_room_absent')->result_array();
        } else {
            $room_absent = $this->db->get_where('student_room_absent', ['room_history_id' => $params3, 'status' => $params])->result_array();
        }
        
        // $semuaStatusSatu = true;
        $jumlahStatusSatu = 0; // Menambahkan variabel ini untuk menghitung jumlah status 1
        // $isi_pesan = '';

        foreach ($room_absent as $key => $room_absent) {
            
            $siswa = $this->db->get_where('user', ['id' => $room_absent['student_id']])->row_array();
            
            if ($room_absent['status'] == '0') {
                $status_name = " *ALPA* ";
                // $semuaStatusSatu = false; // Status bukan 1
            } elseif ($room_absent['status'] == '1') {
                $status_name = " *HADIR* ";
                $jumlahStatusSatu++; // Meningkatkan jumlah status 1
            } elseif ($room_absent['status'] == '2') {
                $status_name = " *TELAT* ";
                // $semuaStatusSatu = false; // Status bukan 1
            } elseif ($room_absent['status'] == '3') {
                $status_name = " *SAKIT* ";
                // $semuaStatusSatu = false; // Status bukan 1
            } elseif ($room_absent['status'] == '4') {
                $status_name = " *IZIN* ";
                // $semuaStatusSatu = false; // Status bukan 1
            }
            
            $isi_pesan .= " ".$no.". ". $siswa['name'] . " (" .$status_name. ")" ."
";
            $no++;
            $kode_group = $kelas['group_laporan_angkatan'];
        }
        
        $jumlah_siswa = $this->db->get_where('student_room_absent', ['room_history_id' => $params3])->result_array();
        
            if ($jumlahStatusSatu == count($jumlah_siswa)) {
            $isi_pesan = "[PESAN OTOMATIS] - ABSENSI ONLINE
*- Kelas* : " . $kelas['class'] . "
*- Wali Kelas* : " . $wali_kelas['name'] . "
*- Tanggal* : " . tgl_indo($history['date']) . "
*- Guru* : " . $user['name'] . "
*- Mata Pelajaran* : " . $mapel['lessons'] . "

   *===== HADIR SEMUA =====*
            
";
            // $isi_pesan = "HADIR SEMUA"; // Ganti isi pesan dengan "HADIR SEMUA" hanya jika semua status adalah 1
            }
            
            // echo "Hadir: " . $jumlahStatusSatu . " Siswa: " .count($jumlah_siswa);
        
        $settings = $this->db->get('settings')->row_array();
        $phone = $settings['phone'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-whatsapp.smkkarnas.id/sendtext?number=' . $phone . '&to=' . $kode_group . '&message=' . urlencode($isi_pesan),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        redirect($_SERVER['HTTP_REFERER']);
        // Menghapus flash data secara manual
        $this->session->unset_flashdata('message');
    }




    public function histori_bulanan($params = "")
    {
        date_default_timezone_set("Asia/Jakarta");
        if ($params == "filter") {
            $data['bulan_sekarang'] = date('Y-m');
            $data['mapel']          = $this->input->post('mapel');
            $data['data_mapel']     = $this->db->get_where('student_lessons', ['mapel_id' => $data['mapel']])->row_array();
            $data['nama_mapel']     = $data['data_mapel']['lessons'];
            $data['awal']           = $this->input->post('awal');
            $data['akhir']          = $this->input->post('akhir');
            if (empty($this->input->post('kelas'))) {
                $data['data_kelas']      = $this->db->query("SELECT class FROM student_room_history WHERE lesson_id = '" . $data['mapel'] . "' and lesson_id = '" . $data['mapel'] . "' and teacher_id = '" . $this->session->userdata('id') . "' GROUP BY class")->result_array();
                $data['cek_kelas']       = 1;
                $data['kelas']           = 0;
            } else {
                $data['kelas']           = $this->input->post('kelas');
                $data['data_kelas']      = $this->db->query("SELECT class FROM student_room_history WHERE lesson_id = '" . $data['mapel'] . "' and lesson_id = '" . $data['mapel'] . "' and teacher_id = '" . $this->session->userdata('id') . "' GROUP BY class")->result_array();
                $data['cek_kelas']       = 1;
            }
        } else {
            $data['bulan_sekarang'] = date('Y-m');
            $data['awal']           = date('Y-m-d');
            $data['akhir']          = date('Y-m-d');
            $data['mapel']          = 0;
            $data['kelas']          = 0;
            $data['cek_kelas']      = 0;
            $data['nama_mapel']     = "-";
        }
        $data['title'] = 'Rekap Pembelajaran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['teacher_lessons'] = $this->db->query("SELECT * FROM teacher_lessons INNER JOIN student_lessons ON student_lessons.mapel_id = teacher_lessons.lessons_id WHERE teacher_lessons.user_id = '" . $this->session->userdata('id') . "'")->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('guru/history', $data);
        $this->load->view('templates/footer');
    }



    // -------------------------------- Controller Mapel -------------------------------- //

    function siswa_by_kelas($class = "", $awal = "", $akhir = "", $lessons_id = "")
    {
        $kelas = str_replace("-", " ", $class);
        $teacher_id = $this->session->userdata('id');
        $lessons_id = $lessons_id;
        $query  = "SELECT * FROM user";
        $search = array('id', 'name', 'class_name', 'view_sakit', 'view_izin', 'view_alpha', 'view_hadir', 'view_bolos', 'view_pkl', 'view_tidak_hadir', 'view_persentase', 'view_dispensasi', 'view_tugas');
        // $where  = null;
        $where  = array('class_name' => $kelas, 'department' => 'Siswa');
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_query_history_bulanan($query, $search, $where, $isWhere, $awal, $akhir, $teacher_id, $lessons_id);
    }


    // -------------------------------- Controller export history -------------------------------- //
    function export_history_bulanan()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $alignment_center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
        $alignment_right = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT;

        $sheet->setCellValue('A1', "LAPORAN DATA SISWA SMK KARYA NASIONAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $sheet->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
        $sheet->setCellValue('A2', "Jl. Cirendang - Cigugur, Cirendang, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45518"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A2:M2'); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('A1')->getAlignment()->setHorizontal($alignment_center);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal($alignment_center);

        // Buat header tabel nya pada baris ke 3

        $sheet->setCellValue('A4', "Nama");
        $sheet->setCellValue('B4', "Mata Pelajaran");
        $sheet->setCellValue('C4', "Kelas");
        $sheet->setCellValue('D4', "Sakit");
        $sheet->setCellValue('E4', "Izin");
        $sheet->setCellValue('F4', "Alpha");
        $sheet->setCellValue('G4', "Bolos");
        $sheet->setCellValue('H4', "PKL");
        // $sheet->setCellValue('I4', "Dispensasi");
        // $sheet->setCellValue('J4', "Tugas Sekolah");
        $sheet->setCellValue('I4', "Total Kehadiran");
        $sheet->setCellValue('J4', "Total Tidak Hadir");
        $sheet->setCellValue('K4', "Persentase");

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A4')->applyFromArray($style_col);
        $sheet->getStyle('B4')->applyFromArray($style_col);
        $sheet->getStyle('C4')->applyFromArray($style_col);
        $sheet->getStyle('D4')->applyFromArray($style_col);
        $sheet->getStyle('E4')->applyFromArray($style_col);
        $sheet->getStyle('F4')->applyFromArray($style_col);
        $sheet->getStyle('G4')->applyFromArray($style_col);
        $sheet->getStyle('H4')->applyFromArray($style_col);
        $sheet->getStyle('I4')->applyFromArray($style_col);
        $sheet->getStyle('J4')->applyFromArray($style_col);
        $sheet->getStyle('K4')->applyFromArray($style_col);
        // $sheet->getStyle('L4')->applyFromArray($style_col);
        // $sheet->getStyle('M4')->applyFromArray($style_col);

        // Set height baris ke 1, 2 dan 3
        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);
        $sheet->getRowDimension('4')->setRowHeight(20);

        // Buat query untuk menampilkan semua data siswa
        $kelas = $this->input->post('kelas');
        $lessons_id = $this->input->post('mapel');
        $teacher_id = $this->session->userdata('id');
        $data_mapel    = $this->db->get_where('student_lessons', ['mapel_id' => $lessons_id])->row_array();
        // $bulan = $this->input->post('bulan');
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $class = $this->db->query("SELECT * FROM student_class WHERE class = '" . $kelas . "'")->row_array();
        $data = $this->db->query("SELECT * FROM user WHERE role_id = '6' AND class_name = '" . $kelas . "'")->result_array();
        $data_guru = $this->db->get_where('user', ['id' => $teacher_id])->row_array();

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data as $key => $data) { // Ambil semua data dari hasil eksekusi $sql

            $tidak_hadir = 0;
            $semua = 0;
            $persentase = 0;
            $hadir = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '1' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "'")->num_rows();
            $sakit = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '3' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "'")->num_rows();
            $izin = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '4' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "'")->num_rows();
            // $alpha = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            // WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description ='Alfa'")->num_rows();
            $alpha = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "'")->num_rows();
            $pkl = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description = 'PKL/OJT'")->num_rows();
            $bolos = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
            WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description = 'Bolos'")->num_rows();


            $dispensasi = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description = 'Dispensasi'")->num_rows();

            $tugas = $this->db->query("SELECT student_room_id FROM student_room_absent INNER JOIN student_room_history ON student_room_history.id = student_room_absent.room_history_id 
WHERE student_room_absent.student_id = '" . $data['id'] . "' AND student_room_absent.lessons_id = '" . $lessons_id . "' AND student_room_history.teacher_id = '" . $teacher_id . "' AND student_room_absent.status = '0' AND student_room_absent.tanggal > '" . $awal . "' AND student_room_absent.tanggal < '" . $akhir . "' AND student_room_absent.description = 'Tugas Luar/Tugas Sekolah'")->num_rows();

            $tidak_hadir = $sakit + $izin + $alpha + $bolos;
            $total_hadir = $hadir + $pkl;
            $semua = $total_hadir + $tidak_hadir;
            if ($semua != 0) {
                $persentase = number_format(($hadir / $semua) * 100, 2);
            }

            $sheet->setCellValue('A' . $numrow, $data['name']);
            $sheet->setCellValue('B' . $numrow, $data_mapel['lessons']);
            $sheet->setCellValue('C' . $numrow, $data['class_name']);
            $sheet->setCellValue('D' . $numrow, $sakit);
            $sheet->setCellValue('E' . $numrow, $izin);
            $sheet->setCellValue('F' . $numrow, $alpha);
            // $sheet->setCellValue('G' . $numrow, $bolos);
            // $sheet->setCellValue('H' . $numrow, $pkl);
            $sheet->setCellValue('I' . $numrow, $hadir);
            // $sheet->setCellValue('J' . $numrow, $dispensasi);
            // $sheet->setCellValue('K' . $numrow, $tugas);
            $sheet->setCellValue('J' . $numrow, $tidak_hadir);
            $sheet->setCellValue('K' . $numrow, $persentase . " %");

            // Khusus untuk no telepon. kita set type kolom nya jadi STRING
            // $sheet->setCellValue('E'.$numrow, $data['telp']);
            // $sheet->setCellValue('F'.$numrow, $data['alamat']);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
            // $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);

            $sheet->getRowDimension($numrow)->setRowHeight(20);
            $numrow++;
        }

        $no++; // Tambah 1 setiap kali looping
        $numrow++;
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(20); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(15); // Set width kolom F
        // $sheet->getColumnDimension('G')->setWidth(15); // Set width kolom G
        // $sheet->getColumnDimension('H')->setWidth(15); // Set width kolom H
        $sheet->getColumnDimension('I')->setWidth(15); // Set width kolom I
        $sheet->getColumnDimension('J')->setWidth(15); // Set width kolom J
        $sheet->getColumnDimension('K')->setWidth(15); // Set width kolom K
        // $sheet->getColumnDimension('L')->setWidth(15); // Set width kolom K
        // $sheet->getColumnDimension('M')->setWidth(15); // Set width kolom K

        $sheet->setCellValue('H' . $numrow, "Kuningan, " . tgl_indo(date('d-m-Y'))); // Set mengetahui
        $sheet->mergeCells('H' . $numrow . ':J' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('H' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('H' . $numrow)->getAlignment()->setHorizontal($alignment_right);
        $numrow++;

        $sheet->setCellValue('B' . $numrow, "Wakasek Kurikulum");
        $sheet->mergeCells('B' . $numrow . ':D' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('B' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1

        $sheet->setCellValue('H' . $numrow, "Guru Mata Pelajaran");
        $sheet->mergeCells('H' . $numrow . ':J' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('H' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('H' . $numrow)->getAlignment()->setHorizontal($alignment_right);
        $numrow = $numrow + 5;

        $sheet->setCellValue('B' . $numrow, "Didi Rohendi, S.Pd.");
        $sheet->mergeCells('B' . $numrow . ':D' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('B' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1

        // kelas 10 : Nono Sumartono
        // Kelas 11 : Yadi Suryadi
        // Kelas 12 : Dodi
        $sheet->setCellValue('H' . $numrow, $data_guru['name']);
        $sheet->mergeCells('H' . $numrow . ':J' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('H' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('H' . $numrow)->getAlignment()->setHorizontal($alignment_right);
        $numrow++;



        $sheet->setCellValue('D' . $numrow, "Mengetahui");
        $sheet->mergeCells('D' . $numrow . ':H' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('D' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('D' . $numrow)->getAlignment()->setHorizontal($alignment_center);
        $numrow++;

        $sheet->setCellValue('D' . $numrow, "Kepala Sekolah");
        $sheet->mergeCells('D' . $numrow . ':H' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('D' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('D' . $numrow)->getAlignment()->setHorizontal($alignment_center);
        $numrow = $numrow + 5;

        $sheet->setCellValue('D' . $numrow, "Dr.Yepi Esa Trijaka, M.M.Pd");
        $sheet->mergeCells('D' . $numrow . ':H' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
        $sheet->getStyle('D' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $sheet->getStyle('D' . $numrow)->getAlignment()->setHorizontal($alignment_center);

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        if ($awal == $akhir) {
            $tanggal_laporan = $awal;
        } else {
            $tanggal_laporan = $awal . "  s.d  " . $akhir;
        }
        // Set judul file excel nya
        $sheet->setTitle($tanggal_laporan);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan History Pembelajaran.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    
    
    public function data_siswa($params = "", $params2 = "    ")
    {
        if ($params == 'add') {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('nis'),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => '6',
                'is_active' => '1',
                'date_created' => date('Y-m-d'),
                'department' => 'Siswa',
                'class_name' => $this->input->post('class'),
                'phone' => $this->input->post('phone'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'is_flexible' => '0'
            ];
            $this->db->insert('user', $data);

            $this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data Siswa Berhasil di Tambahkan",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
            redirect('guru/data_siswa');
        } elseif ($params == 'delete') {
            $this->db->where('id', $params2);
            $this->db->delete('user');
            $this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data Siswa Berhasil di Hapuskan",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
            redirect('guru/data_siswa');
        } elseif ($params == 'filter') {
            $data['title'] = 'DATA SISWA';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['class'] = $this->Absensi_model->getAllClassWali($this->session->userdata('id'))->result_array();
            $data['kelas_tampil'] = $this->input->post('class');
            $data['list_user'] = $this->Admin_model->getAllSiswa()->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('guru/data_siswa', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'DATA SISWA';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['class'] = $this->Absensi_model->getAllClassWali($this->session->userdata('id'))->result_array();
            $data_kelas = $this->Absensi_model->getAllClassWali($this->session->userdata('id'))->row_array();
            $data['kelas_tampil'] = $data_kelas['class'];
            $data['list_user'] = $this->Admin_model->getAllSiswa()->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('guru/data_siswa', $data);
            $this->load->view('templates/footer');
        }
    }


    // -------------------------------- Controller Datatables siswa -------------------------------- //
    function datatables_siswa($kelas)
    {
        $kelas = str_replace("-", " ", $kelas);
        $query  = "SELECT * FROM user";
        $search = array('class_name', 'name', 'email', 'phone', 'gender', 'id', 'is_pkl');
        // $where  = null; 
        $where  = array('role_id' => '6', 'class_name' => $kelas);

        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
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
        redirect('guru/data_siswa');
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
            redirect('guru/data_siswa');
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
            redirect('guru/data_siswa');
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
            redirect('guru/data_siswa');
        } else {
            $data['title'] = 'Edit  User';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['user_edit'] = $this->Admin_model->getUserById($id);
            $data['role'] = $this->db->get('user_role')->result_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('guru/edit-profile', $data);
            $this->load->view('templates/footer');
        }
    }
}
