<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronjob extends CI_controller
{
    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Absensi_model');
        $this->load->model('M_Datatables');
    }
    
    public function testing(){
        $phone_no = '083199766610';
        $key='iay747isynk0bxhkq4uilwpscyha9yh'; //this is demo key please change with your own key
        $url='https://https://beta.seribumart.com/api/categories';
        // $data = array(
        //   "number" => $phone_no,
        //   "message" => "TESTING",
        //   "file" => "https://example.com/image.jpg",
        //   "type" => "sync",
        //   "delay" => 0
        // );
        // $data_string = json_encode($data);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
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
        //     'Content-Type: application/json'
        //   )
        // );
        echo $res=curl_exec($ch);
        curl_close($ch);
        echo $ch;
        
    }

    public function Update_Ruangan_Flexible()
    {
        $ruangan = $this->db->query("SELECT student_room_history.id, student_room_history.start_time, student_room_history.date FROM student_room_history 
        INNER JOIN student_room ON student_room_history.room_id = student_room.room_id
        WHERE student_room_history.date = '" . date('Y-m-d') . "' AND student_room_history.is_done = '0' AND student_room.status = 'Flexible'")->result_array();
        foreach ($ruangan as $key => $ruangan) {
            echo $ruangan['start_time'] . " | ";
            if (date('H:i:s', strtotime('+8 Hours', strtotime($ruangan['start_time']))) < date('H:i:s')) {
                $data_update = [
                    'is_done' => 1,
                    'end_time' => date('H:i:s')
                ];
                $this->db->where('id', $ruangan['id']);
                $this->db->update('student_room_history', $data_update);
            }
        }
    }

    public function Update_Ruangan_Harian()
    {
        // $ruangan = $this->db->query("SELECT student_room_history.id, student_room_history.start_time, student_room_history.date FROM student_room_history 
        // INNER JOIN student_room ON student_room_history.room_id = student_room.room_id
        // WHERE student_room_history.date < '".date('Y-m-d')."' AND student_room_history.is_done = '0'")->result_array();
        // foreach ($ruangan as $key => $ruangan) {
        //     echo $ruangan['start_time']." | ";
        //     $data_update = [
        //         'is_done' => 0,
        //         'end_time' => date('H:i:s')
        //     ];
        //     $this->db->where('id', $ruangan['id']);
        //     $this->db->update('student_room_history', $data_update);
        // }


        $data_update = [
            'is_done' => 1,
            'end_time' => date('H:i:s')
        ];
        $this->db->where('date', date('Y-m-d'));
        $this->db->update('student_room_history', $data_update);
    }


    public function kirim_laporan_harian()
    {

        function format_hari_tanggal($waktu)
        {
            $hari_array = array(
                'Minggu',
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu'
            );
            $hr = date('w', strtotime($waktu));
            $hari = $hari_array[$hr];
            $tanggal = date('j', strtotime($waktu));
            $bulan_array = array(
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            );
            $bl = date('n', strtotime($waktu));
            $bulan = $bulan_array[$bl];
            $tahun = date('Y', strtotime($waktu));
            $jam = date('H:i:s', strtotime($waktu));

            //untuk menampilkan hari, tanggal bulan tahun jam
            //return "$hari, $tanggal $bulan $tahun $jam";

            //untuk menampilkan hari, tanggal bulan tahun
            return "$hari, $tanggal $bulan $tahun";
        }
        $tanggal_sekarang = date('Y-m-d');
        // $tanggal_sekarang = '2023-08-01';
        $tanggal =  format_hari_tanggal($tanggal_sekarang); // Hasilnya menampilkan format tanggal 11 Oktober 2017
        $total_belum_absen = $this->db->get_where('student_attendance', ['date' => $tanggal_sekarang, 'status' => 0, 'description' => 'Siswa ini belum absen pagi!'])->num_rows();
        $total_sudah_absen = $this->db->get_where('student_attendance', ['date' => $tanggal_sekarang,  'description !=' => 'Siswa ini belum absen pagi!'])->num_rows();

        $text = "[PESAN OTOMATIS] " . $tanggal . "
===== REPORT ABSENSI SISWA PAGI =====

- TOTAL SISWA YANG SUDAH ABSEN: " . $total_sudah_absen . "
- TOTAL SISWA YANG BELUM ABSEN: " . $total_belum_absen . "

==============================
";
        $no = 1;
        $loop = $this->db->query("SELECT distinct class FROM student_attendance WHERE date = '" . $tanggal_sekarang . "'")->result_array();
        foreach ($loop as $key => $value) {
            $total_belum_absen_perkelas = $this->db->get_where('student_attendance', ['date' => $tanggal_sekarang, 'status' => 0, 'description' => 'Siswa ini belum absen pagi!', 'class' => $value['class']])->num_rows();
            $total_siswa = $this->db->get_where('user', ['class_name' => $value['class'], 'role_id' => '6'])->num_rows();
            $class = $this->db->get_where('student_class', ['class' => $value['class']])->row_array();
            $teacher = $this->db->get_where('user', ['id' => $class['homeroom_teacher']])->row_array();
            $text .= "
" . $no++ . ". " . $value['class'] . " (" . $total_siswa . ")
- Wali Kelas: " . $teacher['name'] . "
- Yang Belum Absen: " . $total_belum_absen_perkelas . "
    
";
        }
        echo "<pre>";
        echo $text;
        echo "</pre>";


        $settings = $this->db->get('settings')->row_array();
        $group = "120363144119219314@g.us";

        $phone = $settings['phone'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-whatsapp.smkkarnas.id/sendtext?number=' . $phone . '&to=' . $group . '&message=' . urlencode($text),
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
    }


    public function update_siswa($nis = "", $class = "")
    {
        $data_user = $this->db->get_where('user', ['email' => $nis])->row_array();
        $update_user = [
            'class_name' => 'XII TKJ ' . $class
        ];
        $this->db->where('id', $data_user['id']);
        $this->db->update('user', $update_user);


        $update_attendance = [
            'class' => 'XII TKJ ' . $class
        ];
        $this->db->where('user_id', $data_user['id']);
        $this->db->update('student_attendance', $update_attendance);

        echo "OKE";
    }
}
