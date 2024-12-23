<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends CI_Model
{

	public function getAttendanceToday()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->where('date', $curr_date);
		$this->db->where('status !=', '3') && $this->db->where('status !=', '4') && $this->db->where('status !=', '0');
		return $this->db->get('student_attendance');
	}

	public function getAttendanceByDate($awal, $akhir)
	{

		$this->db->where('date >=', $awal);
		$this->db->where('date <=', $akhir);
		return $this->db->get('student_attendance');
	}

	public function getAttendanceAll()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('student_attendance', 'user.id = student_attendance.user_id');
		$this->db->where('date', $curr_date);
		return $this->db->get();
	}


	public function siswa_alpha($id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$data = [
			'status' => 0
		];

		$this->db->where('attendance_id', $id);
		$this->db->where('date', $curr_date);
		$this->db->update('student_attendance', $data);
	}

	public function siswa_alpha_x()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('student_attendance', 'user.id = student_attendance.user_id');
		$this->db->where('date', $curr_date);
		$this->db->like('class_name', 'X ');
		$this->db->where('status', '0');
		return $this->db->get();
	}
	public function total_siswa_alpha_x()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('student_attendance', 'user.id = student_attendance.user_id');
		$this->db->where('date', $curr_date);
		$this->db->like('class_name', 'X ');
		$this->db->where('status', '0');
		return $this->db->get();
	}
	public function siswa_alpha_xi()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('student_attendance', 'user.id = student_attendance.user_id');
		$this->db->where('date', $curr_date);
		$this->db->like('class_name', 'XI ');
		$this->db->where('status', '0');
		return $this->db->get();
	}
	public function total_siswa_alpha_xi()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('student_attendance', 'user.id = student_attendance.user_id');
		$this->db->where('date', $curr_date);
		$this->db->like('class_name', 'XI ');
		$this->db->where('status', '0');
		return $this->db->get();
	}
	public function siswa_alpha_xii()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('student_attendance', 'user.id = student_attendance.user_id');
		$this->db->where('date', $curr_date);
		$this->db->like('class_name', 'XII ');
		$this->db->where('status', '0');
		return $this->db->get();
	}
	public function total_siswa_alpha_xii()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('student_attendance', 'user.id = student_attendance.user_id');
		$this->db->where('date', $curr_date);
		$this->db->like('class_name', 'XII ');
		$this->db->where('status', '0');
		return $this->db->get();
	}

	public function siswa_hadir($id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$data = [
			'status' => 1
		];

		$this->db->where('attendance_id', $id);
		$this->db->where('date', $curr_date);
		$this->db->update('student_attendance', $data);
	}

	public function siswa_telat()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$attendance_id = $this->db->input->post('attendance_id');
		$description = $this->db->input->post('description');

		$data = [
			'status' => 2,
			'description' => $description
		];

		$this->db->where('attendance_id', $attendance_id);
		$this->db->where('date', $curr_date);
		$this->db->update('student_attendance', $data);
	}

	public function siswa_sakit($id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$data = [
			'status' => 3
		];

		$this->db->where('attendance_id', $id);
		$this->db->where('date', $curr_date);
		$this->db->update('student_attendance', $data);
	}

	public function siswa_izin($id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');

		$data = [
			'status' => 4
		];

		$this->db->where('attendance_id', $id);
		$this->db->where('date', $curr_date);
		$this->db->update('student_attendance', $data);
	}

	public function total_hadir_siswa_perkelas()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		// $where = "student_attendance.status=1'Joe' AND status='boss' OR status='active'";

		$this->db->select('*');
		$this->db->from('student_room_absent');
		$this->db->join('student_attendance', 'student_attendance.user_id = student_room_absent.student_id');
		$this->db->where('student_attendance.status', 1);
		$this->db->where('student_attendance.date', $curr_date);
		return $this->db->count_all_results();
	}

	public function total_hadir_telat_siswa_perkelas()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		// $where = "student_attendance.status=1'Joe' AND status='boss' OR status='active'";

		$this->db->select('*');
		$this->db->from('student_room_absent');
		$this->db->join('student_attendance', 'student_attendance.user_id = student_room_absent.student_id');
		$this->db->where('student_attendance.status', 2);
		$this->db->where('student_attendance.date', $curr_date);
		return $this->db->count_all_results();
	}

	public function total_sakit_siswa_perkelas()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('student_room_absent');
		$this->db->join('student_attendance', 'student_attendance.user_id = student_room_absent.student_id');
		$this->db->where('student_attendance.status', 3);
		$this->db->where('student_attendance.date', $curr_date);
		return $this->db->count_all_results();
	}

	public function total_izin_siswa_perkelas()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('student_room_absent');
		$this->db->join('student_attendance', 'student_attendance.user_id = student_room_absent.student_id');
		$this->db->where('student_attendance.status', 4);
		$this->db->where('student_attendance.date', $curr_date);
		return $this->db->count_all_results();
	}

	public function total_alpha_siswa_perkelas()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('student_room_absent');
		$this->db->join('student_attendance', 'student_attendance.user_id = student_room_absent.student_id');
		$this->db->where('student_attendance.status', 0);
		$this->db->where('student_attendance.date', $curr_date);
		return $this->db->count_all_results();
	}

	// ====== Functions Siswa Per Orang =================================================================

	public function total_hadir_siswa_perorang($user_id = "")
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		// $where = "student_attendance.status=1'Joe' AND status='boss' OR status='active'";

		$this->db->select('*');
		$this->db->from('student_attendance');
		$this->db->join('user', 'student_attendance.user_id = user.id');
		$this->db->where('id', $user_id);
		$this->db->where('status', 1);
		$this->db->where('date', $curr_date);
		return $this->db->count_all_results();
	}

	public function total_hadir_telat_siswa_perorang($user_id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		// $where = "student_attendance.status=1'Joe' AND status='boss' OR status='active'";

		$this->db->select('*');
		$this->db->from('student_attendance');
		$this->db->join('user', 'student_attendance.user_id = user.id');
		$this->db->where('id', $user_id);
		$this->db->where('status', 2);
		$this->db->where('date', $curr_date);
		return $this->db->count_all_results();
	}

	public function total_sakit_siswa_perorang($user_id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('student_attendance');
		$this->db->join('user', 'student_attendance.user_id = user.id');
		$this->db->where('id', $user_id);
		$this->db->where('status', 3);
		$this->db->where('date', $curr_date);
		return $this->db->count_all_results();
	}

	public function total_izin_siswa_perorang($user_id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('student_attendance');
		$this->db->join('user', 'student_attendance.user_id = user.id');
		$this->db->where('id', $user_id);
		$this->db->where('status', 4);
		$this->db->where('date', $curr_date);
		return $this->db->count_all_results();
	}

	public function total_alpha_siswa_perorang($user_id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date_now = new DateTime("now");
		$curr_date = $date_now->format('Y-m-d');

		$this->db->select('*');
		$this->db->from('student_attendance');
		$this->db->join('user', 'student_attendance.user_id = user.id');
		$this->db->where('id', $user_id);
		$this->db->where('status', 0);
		$this->db->where('date', $curr_date);
		return $this->db->count_all_results();
	}

	public function getDataSiswa()
	{
		$this->db->where('role_id', "6");
		$this->db->where_not_in('class_name', 'Alumni');
		return $this->db->get('user');
	}

	public function getDataGuru()
	{
		$this->db->where('role_id', "3");
		return $this->db->get('user');
	}

	public function insertDataAttendance()
	{
		$user_data = $this->db->query("SELECT * FROM user INNER JOIN student_class ON student_class.class = user.class_name where role_id = '6' and class_name != 'Alumni'")->result_array();
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$time = "00:00:00";
		// $time_break = "00:00:00";
		// $time_out = "00:00:00";
		// $latlong = "-6.9530251697747545, 108.46944914599598";
		// $location = "belum ada lokasi";
		$status = "0";
		$data = array();
		foreach ($user_data as $ud) {
			$user_id = $ud['id'];
			$class_name = $ud['class_name'];
			if ($ud['is_pkl'] == 1) {
				$description = "PKL/OJT";
			} else {
				$description = "Siswa ini belum absen pagi!";
			}

			$cek_data = $this->db->get_where('student_attendance', ['user_id' => $user_id, 'date' => $curr_date])->num_rows();
			if ($cek_data == 0) {
				$row_arr = array(
					'user_id' => $user_id,
					'date' => $curr_date,
					'month' => date('Y-m'),
					'time' => $time,
					// 'time_break' => $time_break,
					// 'time_out' => $time_out,
					// 'latlong' => $latlong,
					// 'location' => $location,
					'status' => $status,
					'description' => $description,
					'class' => $class_name
				);
				array_push($data, $row_arr);
			}
		}
		$cek_holiday = $this->get_holiday_by_date(date('Y-m-d'))->num_rows();
		if ($cek_holiday == 0) {
			$this->db->insert_batch('student_attendance', $data);
		}
	}

	public function getKodeScan($params = "")
	{
		$this->db->where('qr_token', $params);
		return $this->db->get('qr');
	}

	public function getRoomByQr($params = "")
	{
		$this->db->where('qr_token', $params);
		return $this->db->get('student_room');
	}

	function cek_absen()
	{

		$user_id = $this->input->post('user_id');
		$time_cek = date('H:i:s ', strtotime('00:00:00'));
		$time_in = $this->db->query("SELECT * FROM student_attendance where user_id = $user_id ")->row_array();

		if ($time_cek > $time_in['time']) {
			return true;
		} else {
			return false;
		}
	}

	public function absen()
	{
		date_default_timezone_set("Asia/Jakarta");
		$time = new DateTime("now");

		$link = base_url();
		// $jam_masuk_end = date('H:i:s', strtotime('22:00:00'));

		$curr_time = $time->format('H:i:s');
		$curr_date = $time->format('Y-m-d');

		// $attendance_id = $this->input->post('attendance_id');
		$user_id = $this->input->post('user_id');

		$jam_masuk = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Masuk'")->row_array();
		$jam_masuk_start = $jam_masuk['time_start'];
		$jam_masuk_end = $jam_masuk['time_end'];


		$jam_telat = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Telat'")->row_array();
		$jam_telat_start = $jam_telat['time_start'];
		$jam_telat_end = $jam_telat['time_end'];

		// $jam_istirahat          =  $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Istirahat'")->row_array();
		// $jam_istirahat_start    = $jam_istirahat['time_start'];
		// $jam_istirahat_end      = $jam_istirahat['time_end'];

		$jam_pulang = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Pulang'")->row_array();
		$jam_pulang_start = $jam_pulang['time_start'];
		$jam_pulang_end = $jam_pulang['time_end'];

		$time_cek = '00:00:00';

		if ($curr_time >= $jam_masuk_start && $curr_time <= $jam_masuk_end) { //jam masuk tepat waktu

			$time_cek = '00:00:00';
			$time_in = $this->db->query("SELECT * FROM student_attendance where user_id = $user_id and date = '" . $curr_date . "'")->row_array();
			if ($time_in['time'] == $time_cek) { // cek jika belum 
				$data = [
					'status' => 1,
					'time' => $curr_time,
					'description' => 'Siswa Sudah Datang Tepat Waktu!'
				];

				// $this->db->where('attendance_id', $attendance_id);
				$this->db->where('user_id', $user_id);
				$this->db->where('date', $curr_date);
				$this->db->update('student_attendance', $data);
				// $this->session->set_flashdata('message_absen', '<div class="alert alert-success" role="danger"> Berhasil Absen Tepat Waktu </div>');
				
				//DELAY
				// '<script>
                //	var delayInMilliseconds = 500; //0.5 second
                //		setTimeout(function() {' .
				//		// redirect("siswa");
				//		'}, delayInMilliseconds);
                // </script>';

				$this->session->set_flashdata('message_absen', '<script>
                    swal({
                        title: "Status Absen!",
                        text: "Berhasil Absen Tepat Waktu!",
                        icon: "success",
                        button: "OK"
                        // timer: 3000
                        });
                        </script>');

				//DELAY
				'<script>
                	var delayInMilliseconds = 500; //0.5 second
                		setTimeout(function() {' .
						// redirect("siswa");
						'}, delayInMilliseconds);
                </script>';

				redirect('siswa');
			} 
			else { //jika sudah
				$this->session->set_flashdata('message_absen', '<script>
                   swal({
                    title: "---INFORMASI---",
                    text: "**ABSENSI PAGI: \nAnda sudah absen masuk, cek status kehadiran pada dashboard."+ 
					"\n Jika merasa belum scan, kemungkinan kamera delay atau terlalu cepat!"+
					"\n\n**ABSENSI RUANGAN: \nStatus ruangan belum dibuka / belum diakhiri!",
                    icon: "info",
                    button: "OK"
                // timer: 3000
                    });
                    </script>');
				// $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger"> Anda Sudah  Absen Tepat Waktu </div>');
				
				//DELAY
				'<script>
                	var delayInMilliseconds = 500; //0.5 second
                		setTimeout(function() {' .
						// redirect("siswa");
						'}, delayInMilliseconds);
                </script>';

				redirect('siswa');
			}
		} 
		else if ($curr_time > $jam_masuk_end && $curr_time < $jam_telat_end) { //jam telat
			$time_in = $this->db->query("SELECT * FROM student_attendance where user_id = $user_id and date = '" . $curr_date . "'")->row_array();
			if ($time_cek == $time_in['time']) {
				$data = [
					'status' => 2,
					'time' => $curr_time,
					'description' => 'Siswa Sudah Datang Namun Terlambat!'
				];

				// $this->db->where('attendance_id', $attendance_id);
				$this->db->where('user_id', $user_id);
				$this->db->where('date', $curr_date);
				$this->db->update('student_attendance', $data);
				
				//DELAY
				'<script>
                	var delayInMilliseconds = 500; //0.5 second
                		setTimeout(function() {' .
						// redirect("siswa");
						'}, delayInMilliseconds);
                </script>';
				
				$this->session->set_flashdata('message_absen', '<script>
                   swal({
                    title: "Status Absen!",
                    text: "Berhasil Absen Tapi Terlambat!",
                    icon: "success",
                    button: "OK"
                    // timer: 3000
                    });
                    </script>');

				//fungsi telegram kirim data terlambat per absen
				// $api = $link . 'telegram/sendTerlambatTelegram/';
				// $ch = curl_init($api);
				// curl_setopt($ch, CURLOPT_HEADER, false);
				// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				// curl_setopt($ch, CURLOPT_POST, 1);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, ($time));
				// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				// $result = curl_exec($ch);
				// curl_close($ch);

				// var_dump($api);

				'<script>
                var delayInMilliseconds = 500; //0.5 second
                setTimeout(function() {' .
					redirect("siswa");
				'}, delayInMilliseconds);
                </script>';
			} else {
				$this->session->set_flashdata('message_absen', '<script>
                   swal({
                    title: "---INFORMASI---",
                    text: "**ABSENSI PAGI: \nAnda sudah absen masuk, cek status kehadiran pada dashboard."+ 
					"\n Jika merasa belum scan, kemungkinan kamera delay atau terlalu cepat!"+
					"\n\n**ABSENSI RUANGAN: \nStatus ruangan belum dibuka / belum diakhiri!",
                    icon: "info",
                    button: "OK"
                // timer: 3000
                    });
                    </script>');
				
				//DELAY
				'<script>
                	var delayInMilliseconds = 500; //0.5 second
                		setTimeout(function() {' .
						// redirect("siswa");
						'}, delayInMilliseconds);
                </script>';

				redirect('siswa');
			}
		}

		// else if ($curr_time > $jam_istirahat_start && $curr_time < $jam_istirahat_end) { //jam Istirahat

		//     $time_in = $this->db->query("SELECT * FROM studet_attendance where user_id = $user_id and date = '" . $curr_date . "'")->row_array();
		//     if ($time_cek == $time_in['time_break'] && $time_in['time_in'] != $time_cek) {

		//         $data = [
		//             'time_break' => $curr_time
		//         ];

		//         // $this->db->where('attendance_id', $attendance_id);
		//         $this->db->where('user_id', $user_id);
		//         $this->db->where('date', $curr_date);
		//         $this->db->update('studet_attendance', $data);
		//         $this->session->set_flashdata('message_absen', '<script>
		//              swal({
		//         title: "Status Absen!",
		//         text: "Absen Istirahat Berhasil!",
		//         icon: "success",
		//         button: "OK"
		//         // timer: 3000
		//     });
		//         </script>');
		//         redirect('user');
		//     } 
		//     else if ($time_in['time_in'] == $time_cek && $time_in['time_break'] == $time_cek) {
		//         $data = [
		//             'status' => 2,
		//             'time_in' => $curr_time,
		//             'time_break' => $curr_time
		//         ];
		//         $this->db->where('user_id', $user_id);
		//         $this->db->where('date', $curr_date);
		//         $this->db->update('studet_attendance', $data);
		//         $this->session->set_flashdata('message_absen', '<script>
		//              swal({
		//         title: "Status Absen!",
		//         text: "Anda Berhasil Absen! Tapi Anda Terlambat!",
		//         icon: "warning",
		//         button: "OK"
		//         // timer: 3000
		//     });
		//         </script>');
		//         //fungsi telegram kirim data terlambat per absen
		//         $api = $link . 'telegram/sendTerlambatTelegram/';

		//         $ch = curl_init($api);
		//         curl_setopt($ch, CURLOPT_HEADER, false);
		//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//         curl_setopt($ch, CURLOPT_POST, 1);
		//         curl_setopt($ch, CURLOPT_POSTFIELDS, ($time));
		//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//         $result = curl_exec($ch);
		//         curl_close($ch);

		//         var_dump($api);

		//         '<script>
		//         var delayInMilliseconds = 500; //0.5 second
		//         setTimeout(function() {'.
		//             redirect("user");
		//         '}, delayInMilliseconds);
		//         </script>';
		//     }

		//     else if ($time_in['time_in'] > $jam_masuk_end && $time_in['time_break'] == $time_cek) {
		//         $data = [
		//             'time_break' => $curr_time
		//         ];
		//         $this->db->where('user_id', $user_id);
		//         $this->db->where('date', $curr_date);
		//         $this->db->update('studet_attendance', $data);
		//         $this->session->set_flashdata('message_absen', '<script>
		//              swal({
		//         title: "Status Absen!",
		//         text: "Anda Berhasil Absen Istirahat!",
		//         icon: "success",
		//         button: "OK"
		//         // timer: 3000
		//     });
		//         </script>');
		//     redirect("user");
		//     }

		//     else {
		//         $this->session->set_flashdata('message_absen', '<script>
		//              swal({
		//         title: "Status Absen!",
		//         text: "Anda Sudah Absen Istirahat !!",
		//         icon: "warning",
		//         button: "OK"
		//         // timer: 3000
		//     });
		//         </script>');
		//         redirect('user');
		//     }
		// } 
		else if ($curr_time >= $jam_pulang_start && $curr_time < $jam_pulang_end) { //jam pulang
			$kelas = $this->input->post('kelas');
			$hasil_scan = $this->input->post('qr');
			$data_ruangan = $this->Absensi_model->getRoomByQr($hasil_scan)->row_array();
			$data_room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->row_array();
			$data_history = $this->db->query("SELECT * FROM student_room WHERE room_id = '" . $data_room_history['room_id'] . "'")->row_array();

			$time_siswa = $this->db->query("SELECT * FROM student_attendance where user_id = $user_id and date = '" . $curr_date . "'")->row_array();
		//	if ($time_cek == $time_in['time_out'] && $time_in['time_break'] != $time_cek && $time_in['time_in'] != $time_cek) {
			if ($time_cek == $time_siswa['waktu_siswa_pulang'] && $time_siswa['time'] != $time_cek) {
				$data = [
					'waktu_siswa_pulang' => $curr_time,
					'status_siswa_pulang' => "1",
					'description' => "Siswa Sudah Pulang!"
				];

				if ($data_history['status'] != 'Flexible') {

					$update = [
						'is_done' => 1
					];
				$this->db->where('class', $kelas);
				$this->db->update('student_room_history', $update);
				}

				// $this->db->where('attendance_id', $attendance_id);
				$this->db->where('user_id', $user_id);
				$this->db->where('date', $curr_date);
				$this->db->update('student_attendance', $data);
				$this->session->set_flashdata('message_absen', '<script>
		            swal({
		             title: "Status Absen!",
		             text: "Anda Berhasil Absen Pulang!",
		             icon: "success",
		             button: "OK"
		             // timer: 3000
		             });
		             </script>');

				
				//DELAY
				'<script>
                	var delayInMilliseconds = 500; //0.5 second
                		setTimeout(function() {' .
						// redirect("siswa");
						'}, delayInMilliseconds);
                </script>';
				redirect('siswa');
			} 
		//	else if ($time_in['time_in'] == $time_cek && $time_in['time_break'] == $time_cek && $time_in['time_out'] == $time_cek) {
			else if ($time_siswa['time'] == $time_cek && $time_siswa['waktu_siswa_pulang'] == $time_cek) {
				$data = [
					// 'time' => $curr_time,
					'time' => '00:00:00',
					// 'time_break' => '00:00:00',
					'waktu_siswa_pulang' => $curr_time,
					// 'status' => 1,
					'status_siswa_pulang' => 1,
					'description' => "Siswa Tidak Scan Pagi!"
				];

				$this->db->where('user_id', $user_id);
				$this->db->where('date', $curr_date);
				$this->db->update('student_attendance', $data);
				$this->session->set_flashdata('message_absen', '<script>
		            swal({
		             title: "Status Absen!",
		             text: "Berhasil Absen Pulang! Tapi Kamu Belum Absen Pagi, Lain Kali Pagi Absen Ya!",
		             icon: "success",
		             button: "OK"
		             // timer: 3000
		             });
		             </script>');
				//fungsi telegram kirim data terlambat per absen
				// $api = $link . 'telegram/sendTerlambatTelegram/';

				// $ch = curl_init($api);
				// curl_setopt($ch, CURLOPT_HEADER, false);
				// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				// curl_setopt($ch, CURLOPT_POST, 1);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, ($time));
				// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				// $result = curl_exec($ch);
				// curl_close($ch);

				// var_dump($api);

				//DELAY
				'<script>
                	var delayInMilliseconds = 500; //0.5 second
                		setTimeout(function() {' .
						// redirect("siswa");
						'}, delayInMilliseconds);
                </script>';
				redirect('siswa');
			} 
			// else if ($time_in['time_break'] == $time_cek && $time_in['time_out'] == $time_cek) {
			//	$data = [
					// 'time_break' => $curr_time,
			//		'time_out' => $curr_time
			//	];

			//	$this->db->where('user_id', $user_id);
			//	$this->db->where('date', $curr_date);
			//	$this->db->update('studet_attendance', $data);
			//	$this->session->set_flashdata('message_absen', '<script>
		    //        swal({
		    //         title: "Status Absen!",
		    //         text: "Berhasil Absen Pulang!",
		    //         icon: "success",
		    //         button: "OK"
		    //     // timer: 3000
		    //         });
		    //         </script>');

			//	//fungsi telegram kirim data terlambat per absen

			//	'<script>
		    //     var delayInMilliseconds = 500; //0.5 second
		    //     setTimeout(function() {' .
			//	redirect("user");
			//	'}, delayInMilliseconds);
		    //     </script>';
			// } 
			else {
				$this->session->set_flashdata('message_absen', '<script>
		            swal({
		             title: "Status Absen!",
		             text: "Anda Sudah Absen Pulang!",
		             icon: "info",
		             button: "OK"
		             // timer: 3000
		             });
		             </script>');

				//DELAY
				'<script>
                	var delayInMilliseconds = 500; //0.5 second
                		setTimeout(function() {' .
						// redirect("siswa");
						'}, delayInMilliseconds);
                </script>';
				redirect('siswa');
			}
		}
		// else if ($curr_time > $jam_pulang_end) { //jam pulang kelebihan

		// 	$this->session->set_flashdata('message_absen', '<script>
		//         swal({
		//             title: "Status Absen!",
		//             text: "Anda Belum Pulang Sampai Selarut Ini! Mungkin Anda Sedang Menginap.",
		//             icon: "info",
		//             button: "OK"
		//         // timer: 3000
		//             });
		//             </script>');
		// 	redirect('user');
		// }

		//Jam Jika Absen Belum Dimulai
		else if ($curr_time < $jam_masuk_start) {

			$this->session->set_flashdata('message_absen', '<script>
               swal({
                title: "Status Absen!",
                text: "Jam Absensi Masuk Belum Dibuka!",
                icon: "info",
                button: "OK"
                // timer: 3000
                });
                </script>');

			redirect("siswa");
		} else {
			$this->session->set_flashdata('message_absen', '<script>
               swal({
                title: "Status Absen!",
                text: "Terjadi Hal Yang Tidak Diketahui! Hubungi Administrator!",
                icon: "info",
                button: "OK"
                // timer: 3000
                });
                </script>');

			redirect("siswa");
		}
	}

	public function getSiswaById($id)
	{
		return $this->db->get_where('user', ['id' => $id])->row_array();
	}

	public function getHoliday()
	{
		$this->db->order_by('date');
		return $this->db->get('data_holiday');
	}


	public function get_holiday_by_date($params = "")
	{
		$this->db->where('date', $params);
		$this->db->order_by('date');
		return $this->db->get('data_holiday');
	}


	public function getAllClass()
	{
		// $this->db->where($kelas);
		// return $this->db->get('student_class');
		return $this->db
            ->select('*')
            ->from('student_class')
            ->order_by('class', 'ASC') // Mengurutkan berdasarkan kolom 'nama_kelas' secara ascending
            ->get();
	}

	public function getAllClassWali($user)
	{
		$this->db->where('homeroom_teacher', $user);
		// return $this->db->get('student_class');
		
		return $this->db
            ->select('*')
            ->from('student_class')
            ->order_by('class', 'ASC') // Mengurutkan berdasarkan kolom 'nama_kelas' secara ascending
            ->get();
	}







	public function mapel()
	{

		$hasil_scan = $this->input->post('qr');
		$user_id = $this->input->post('user_id');
		$scan = $this->db->query("SELECT * FROM student_room WHERE qr_token = '" . $hasil_scan . "'")->row_array();
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$cek_room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $scan['room_id'] . "' AND is_done = '0' AND teacher_id = '" . $user['id'] . "'")->num_rows();
		if ($cek_room_history == 0) {
			$data = [
				'room_id' => $scan['room_id'],
				'lesson_id' => 0,
				'teacher_id' => $user_id,
				'class' => '-',
				'date' => date('Y-m-d'),
				'start_time' => date('H:i:s'),
				'is_done' => '0'
			];
			// $this->db->where('attendance_id', $attendance_id);
			$this->db->insert('student_room_history', $data);
		}
		$room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $scan['room_id'] . "' AND is_done = '0' AND teacher_id = '" . $user['id'] . "'")->row_array();

		$this->session->set_flashdata('message_absen', '<script>
		   swal({
			title: "Scan Ruangan!",
			text: "Scan Ruangan Berhasil!",
			icon: "success",
			button: "OK"
		// timer: 3000
			});
			</script>');
		redirect('guru/guru_mapel/' . $room_history['id']);
	}



	public function status_pembelajaran($teacher_id)
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->db->where('date', date('Y-m-d'));
		$this->db->where('teacher_id', $teacher_id);
		$this->db->where('is_done', '0');
		return $this->db->get('student_room_history');
	}

	public function status_pembelajaran_siswa($class)
	{
		date_default_timezone_set("Asia/Jakarta");
		$this->db->where('date', date('Y-m-d'));
		$this->db->where('class', $class);
		$this->db->where('is_done', '0');
		return $this->db->get('student_room_history');
	}


	public function absen_kelas()
	{

		$hasil_scan = $this->input->post('qr');
		$kelas = $this->input->post('kelas');
		$tanggal_sekarang = date('Y-m-d');

		$data_ruangan = $this->Absensi_model->getRoomByQr($hasil_scan)->row_array();

		$scan = $this->db->query("SELECT * FROM student_room WHERE qr_token = '" . $hasil_scan . "'")->row_array();

		$user_data = $this->db->query("SELECT * FROM user where class_name = '" . $kelas . "' AND role_id = '6'")->result_array();
		$data_room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND is_done = '0' AND date = '" . $tanggal_sekarang . "'")->row_array();


		if ($data_ruangan['status'] == 'Flexible' and $data_room_history['class'] != '-') {
			$kelas = $data_room_history['class'] . ", " . $kelas;
		}

		$data = [
			'class' => $kelas
		];

		$this->db->where('id', $data_room_history['id']);
		$this->db->update('student_room_history', $data);

		$data = array();
		foreach ($user_data as $ud) {
			$absen_siswa = $this->db->query("SELECT * FROM student_attendance where user_id = '" . $ud['id'] . "' AND date = '" . $tanggal_sekarang . "'")->row_array();
			$row_arr = array(
				'room_history_id' => $data_room_history['id'],
				'student_id' => $ud['id'],
				'lessons_id' => $data_room_history['lesson_id'],
				'tanggal' => date('Y-m-d'),
				'time' => date('H:i:s'),
				'status' => $absen_siswa['status'],
				'description' => $absen_siswa['description'],
			);
			array_push($data, $row_arr);
		}

		$this->db->insert_batch('student_room_absent', $data);



		$this->session->set_flashdata('message_absen', '<script>
	   swal({
		title: "Berhasil!",
		text: "Absen Ruangan Berhasil!",
		icon: "success",
		button: "OK"
	// timer: 3000
		});
		</script>');
		redirect('siswa');
	}


	//jarak
	public function addnewJarak($data)
	{
		$this->db->insert('data_jarak', $data);
	}

	public function getJarakId($id)
	{
		return $this->db->get_where('data_jarak', ['id' => $id])->row_array();
	}

	public function updateJarak()
	{
		$id = $this->input->post('id');
		$data = [
			'jarak' => $this->input->post('jarak'),
			'status' => $this->input->post('status')
		];
		$this->db->where('id', $id);
		$this->db->update('data_jarak', $data);

		$data = [
			'status' => '0'
		];
		$this->db->where_not_in('id', $id);
		$this->db->update('data_jarak', $data);
	}

	public function deleteJarak($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('data_jarak');
	}
	//jarak












	public function absen_pusat($user_id)
	{

		date_default_timezone_set("Asia/Jakarta");
		$time = new DateTime("now");

		$link = base_url();
		// $jam_masuk_end = date('H:i:s', strtotime('22:00:00'));

		$curr_time = $time->format('H:i:s');
		$curr_date = $time->format('Y-m-d');

		// $attendance_id = $this->input->post('attendance_id');
		$user = $this->db->query("SELECT * FROM user where id = '" . $user_id . "'")->row_array();

		$jam_masuk = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Masuk'")->row_array();

		if (date('H:i:s') > $jam_masuk['time_start'] && date('H:i:s') <= $jam_masuk['time_end']) {
			$time_status = 1;
			$description = 'Siswa ini hadir tepat waktu!';
		} else {
			$time_status = 2;
			$description = 'Siswa ini hadir terlambat!';
		}

		$time_cek = '00:00:00';
		$time_user_cek = $this->db->query("SELECT * FROM student_attendance where user_id = '" . $user_id . "' and date = '" . $curr_date . "' AND time != '" . $time_cek . "'")->num_rows();

		if ($time_user_cek == 0) {
			$data = [
				'user_id' => $user_id,
				'date' => $curr_date,
				'month' => date('Y-m'),
				'time' => $curr_time,
				'status' => $time_status,
				'description' => $description,
				'class' => $user['class_name']
			];
			$this->db->where('user_id', $user_id);
			$this->db->where('date', date('Y-m-d'));
			$this->db->update('student_attendance', $data);
			$this->session->set_flashdata('message', '<script>
               swal({
                title: "Berhasil Absen!",
                text: "Anda Berhasil Absen Masuk!",
                icon: "success",
                button: "OK",
                timer: 2000
                });
                </script>');
			redirect('guru/absensi_pusat');
		} else {
			$this->session->set_flashdata('message', '<script>
               swal({
                title: "Status Absen!",
                text: "Anda Sudah Absen Hari ini!",
                icon: "warning",
                button: "OK",
                timer: 2000
                });
                </script>');
			redirect('guru/absensi_pusat');
		}
	}
}