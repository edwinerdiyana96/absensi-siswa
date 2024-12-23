<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Telegram extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		// is_logged_in();
		$this->load->model('Admin_model');
		$this->load->model('Absensi_model');
		$this->load->model('M_Datatables');
	}

	public function index()
	{
		$data['title'] = 'KIRIM KE TELEGRAM';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['alpha_x'] = $this->Absensi_model->siswa_alpha_x()->result_array();
		$data['total_alpha_x'] = $this->Absensi_model->total_siswa_alpha_x()->num_rows();
		$data['alpha_xi'] = $this->Absensi_model->siswa_alpha_xi()->result_array();
		$data['total_alpha_xi'] = $this->Absensi_model->total_siswa_alpha_xi()->num_rows();
		$data['alpha_xii'] = $this->Absensi_model->siswa_alpha_xii()->result_array();
		$data['total_alpha_xii'] = $this->Absensi_model->total_siswa_alpha_xii()->num_rows();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('telegram/index', $data);
		$this->load->view('templates/footer');
	}

	public function send_alpha_x()
	{
		function tanggal_indo($tanggal, $cetak_hari = false)
		{
			$hari = array(
				1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);

			$bulan = array(
				1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
			$split       = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

			if ($cetak_hari) {
				$num = date('N', strtotime($tanggal));
				return $hari[$num] . ', ' . $tgl_indo;
			}
			return $tgl_indo;
		}

		$enter = "%0A";
		$garis = "------------------------------------------------------";
		$info =  "[PESAN OTOMATIS] - ";
		$date = tanggal_indo(date('Y-m-d'), true) . $enter;

		$total_alpha_x = "JUMLAH TOTAL ALPA: " . $data['total_alpha_x'] = $this->Absensi_model->total_siswa_alpha_x()->num_rows() . " SISWA" . $enter;

		$title1 = "Data Siswa Kelas X Yang Alpha:" . $enter;
		
		$data['alpha_x'] = $this->Absensi_model->siswa_alpha_x()->result_array();
		
		$arr_alpha = []; //create empty array alpha
		
		date_default_timezone_set("Asia/Jakarta");
		$time = date('H.i.s');

		foreach ($data['alpha_x'] as $key => $alpha_x) {
			$no = $key + 1;
			$arr_alpha[] = array(
				'' => $no,
				'.' => '',
				'.' => $alpha_x['name'] ,
				' (' => $alpha_x['class_name'] . ')' . '%0A'
			); 
		}
		
		$json_alpha = json_encode($arr_alpha);
		
		function RemoveSpecialChar($str)
		{
			$res = preg_replace('/[\;\" "\:\}\{]+/', ' ', $str);
			return $res;
		}

		function ReplaceKoma($strKoma)
		{
			$res = preg_replace('/[,]+/', '', $strKoma);
			return $res;
		}

		$str_alpha = $json_alpha;
		
		$str1_alpha = RemoveSpecialChar($str_alpha);
		$str2_alpha = ReplaceKoma($str1_alpha);
		
		$str2_alpha = str_replace('[', ' ', $str2_alpha);
		$str2_alpha = str_replace(']', ' ', $str2_alpha);
		
		$api = 'https://api.telegram.org/bot5698168334:AAHPF7-THWBEIk_u55BXTMWyO7hYSlOTZFQ/sendMessage?chat_id=-1001640728598&text=' . $info . $date . $garis . $enter . $title1 . $str2_alpha . $garis . $enter . $total_alpha_x .'';

		$ch = curl_init($api);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($date));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);

		var_dump($api);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function send_alpha_xi()
	{
		function tanggal_indo($tanggal, $cetak_hari = false)
		{
			$hari = array(
				1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);

			$bulan = array(
				1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
			$split       = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

			if ($cetak_hari) {
				$num = date('N', strtotime($tanggal));
				return $hari[$num] . ', ' . $tgl_indo;
			}
			return $tgl_indo;
		}

		$enter = "%0A";
		$garis = "------------------------------------------------------";
		$info =  "[PESAN OTOMATIS] - ";
		$date = tanggal_indo(date('Y-m-d'), true) . $enter;

		$total_alpha_xi = "JUMLAH TOTAL ALPA: " . $data['total_alpha_xi'] = $this->Absensi_model->total_siswa_alpha_xi()->num_rows() . " SISWA" . $enter;

		$title1 = "Data Siswa Kelas XI Yang Alpha:" . $enter;
		
		$data['alpha_xi'] = $this->Absensi_model->siswa_alpha_xi()->result_array();
		
		$arr_alpha = []; //create empty array alpha
		
		date_default_timezone_set("Asia/Jakarta");
		$time = date('H.i.s');

		foreach ($data['alpha_xi'] as $key => $alpha_xi) {
			$no = $key + 1;
			$arr_alpha[] = array(
				'' => $no,
				'.' => '',
				'.' => $alpha_xi['name'] ,
				' (' => $alpha_xi['class_name'] . ')' . '%0A'
			); 
		}
		
		$json_alpha = json_encode($arr_alpha);
		
		function RemoveSpecialChar($str)
		{
			$res = preg_replace('/[\;\" "\:\}\{]+/', ' ', $str);
			return $res;
		}

		function ReplaceKoma($strKoma)
		{
			$res = preg_replace('/[,]+/', '', $strKoma);
			return $res;
		}

		$str_alpha = $json_alpha;
		
		$str1_alpha = RemoveSpecialChar($str_alpha);
		$str2_alpha = ReplaceKoma($str1_alpha);
		
		$str2_alpha = str_replace('[', ' ', $str2_alpha);
		$str2_alpha = str_replace(']', ' ', $str2_alpha);
		
		$api = 'https://api.telegram.org/bot5698168334:AAHPF7-THWBEIk_u55BXTMWyO7hYSlOTZFQ/sendMessage?chat_id=-1001640728598&text=' . $info . $date . $garis . $enter . $title1 . $str2_alpha . $garis . $enter . $total_alpha_xi .'';

		$ch = curl_init($api);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($date));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);

		var_dump($api);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function send_alpha_xii()
	{
		function tanggal_indo($tanggal, $cetak_hari = false)
		{
			$hari = array(
				1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);

			$bulan = array(
				1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
			$split       = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

			if ($cetak_hari) {
				$num = date('N', strtotime($tanggal));
				return $hari[$num] . ', ' . $tgl_indo;
			}
			return $tgl_indo;
		}

		$enter = "%0A";
		$garis = "------------------------------------------------------";
		$info =  "[PESAN OTOMATIS] - ";
		$date = tanggal_indo(date('Y-m-d'), true) . $enter;

		$total_alpha_xii = "JUMLAH TOTAL ALPA: " . $data['total_alpha_xii'] = $this->Absensi_model->total_siswa_alpha_xii()->num_rows() . " SISWA" . $enter;

		$title1 = "Data Siswa Kelas XII Yang Alpha:" . $enter;
		
		$data['alpha_xii'] = $this->Absensi_model->siswa_alpha_xii()->result_array();
		
		$arr_alpha = []; //create empty array alpha
		
		date_default_timezone_set("Asia/Jakarta");
		$time = date('H.i.s');

		foreach ($data['alpha_xii'] as $key => $alpha_xii) {
			$no = $key + 1;
			$arr_alpha[] = array(
				'' => $no,
				'.' => '',
				'.' => $alpha_xii['name'] ,
				' (' => $alpha_xii['class_name'] . ')' . '%0A'
			); 
		}
		
		$json_alpha = json_encode($arr_alpha);
		
		function RemoveSpecialChar($str)
		{
			$res = preg_replace('/[\;\" "\:\}\{]+/', ' ', $str);
			return $res;
		}

		function ReplaceKoma($strKoma)
		{
			$res = preg_replace('/[,]+/', '', $strKoma);
			return $res;
		}

		$str_alpha = $json_alpha;
		
		$str1_alpha = RemoveSpecialChar($str_alpha);
		$str2_alpha = ReplaceKoma($str1_alpha);
		
		$str2_alpha = str_replace('[', ' ', $str2_alpha);
		$str2_alpha = str_replace(']', ' ', $str2_alpha);
		
		$api = 'https://api.telegram.org/bot5698168334:AAHPF7-THWBEIk_u55BXTMWyO7hYSlOTZFQ/sendMessage?chat_id=-1001640728598&text=' . $info . $date . $garis . $enter . $title1 . $str2_alpha . $garis . $enter . $total_alpha_xii .'';

		$ch = curl_init($api);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($date));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);

		var_dump($api);

		redirect($_SERVER['HTTP_REFERER']);
	}

}
