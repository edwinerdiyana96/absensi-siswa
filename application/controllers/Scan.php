<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Absensi_model');
		$this->load->helper('jarak_helper');
		// $this->load->model('Siswa_model');
	}

	public function index()
	{
		$data['title'] = 'SCAN QR CODE';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('scan/index', $data);
		$this->load->view('templates/footer');

		$lat = $this->input->post('lat');
		$lng = $this->input->post('long');

		$lat_karnas = '-6.95444774752054';
		$long_karnas = '108.46938142360476';

		$point1 = array("lat" => $lat, "long" => $lng);
		$point2 = array("lat" => $lat_karnas, "long" => $long_karnas);
		$jarak_default = $this->db->get_where('data_jarak', ['status' => 1])->row_array();
		$distance = hitung_jarak($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);

		$jarak = $distance['meters'];
		if ($jarak > $jarak_default['jarak']) {
			$this->session->set_flashdata('message_absen', '<script>
                     swal({
                title: "STATUS LOKASI",
                text: "Absensi Tidak Bisa Dilakukan Ketika Lokasi Anda Berada Lebih Dari 100 Meter Dengan Pusat Absensi / Lingkungan SMK Karya Nasional Kuningan! \n\n Lokasi Anda Sekarang: ' . $jarak . ' Meter Dari Pusat Absensi.",
                icon: "warning",
                button: "OK"
                // timer: 3000
            });
                </script>');
			redirect('siswa');
		}
	}

	public function km()
	{
		$data['title'] = 'SCAN QR CODE UNTUK SISWA';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('scan/km', $data);
		$this->load->view('templates/footer');

		$lat = $this->input->post('lat');
		$lng = $this->input->post('long');
		$lat_karnas = '-6.95444774752054';
		$long_karnas = '108.46938142360476';

		$point1 = array("lat" => $lat, "long" => $lng);
		$point2 = array("lat" => $lat_karnas, "long" => $long_karnas);
		$distance = hitung_jarak($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);

		// if ($distance['meters'] < 100) {
		// 	$this->session->set_flashdata('message_absen', '<script>
		// 	swal({
		// 	title: "STATUS LOKASI",
		// 	text: "Lokasi Anda Tidak Boleh Kurang Dari 100 Meter Dengan Lokasi Absensi, Lokasi Anda Sekarang: ' . $distance['meters'] . ' Meter Dari Pusat Absen",
		// 	icon: "warning",
		// 	button: "OK"
		// 	// timer: 3000
		// });
		// 	</script>');
		// 	redirect('siswa');
		// } 
	}

	public function guru()
	{
		$data['title'] = 'SCAN QR CODE UNTUK GURU';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('scan/guru', $data);
		$this->load->view('templates/footer');

		$lat = $this->input->post('lat');
		$lng = $this->input->post('long');

		$lat_karnas = '-6.95444774752054';
		$long_karnas = '108.46938142360476';

		$point1 = array("lat" => $lat, "long" => $lng);
		$point2 = array("lat" => $lat_karnas, "long" => $long_karnas);
		$distance = hitung_jarak($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);

		// if ($distance['meters'] < 100) {
		// 	$this->session->set_flashdata('message_absen', '<script>
		//     swal({
		//     title: "STATUS LOKASI",
		//     text: "Lokasi Anda Tidak Boleh Kurang Dari 100 Meter Dengan Lokasi Absensi, Lokasi Anda Sekarang: ' . $distance['meters'] . ' Meter Dari Pusat Absen",
		//     icon: "warning",
		//     button: "OK"
		//     // timer: 3000
		// });
		//     </script>');
		// 	redirect('guru');
		// } 
	}

	public function update_absensi_setelah_pulang()
	{
		date_default_timezone_set("Asia/Jakarta");
		$time = new DateTime("now");

		$curr_time = $time->format('H:i:s');
		// $curr_date = $time->format('Y-m-d');

		// $jam_pulang = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Pulang'")->row_array();
		// $jam_pulang_start = $jam_pulang['time_start'];
		// $jam_pulang_end = $jam_pulang['time_end'];

		$time_cek = '15:00:00';

		$cek_data_attendance = $this->db->query("SELECT * FROM student_attendance WHERE date = '" . date('Y-m-d') . "' AND status_siswa_pulang = '1' AND status = '1'")->num_rows();
		// $data_attendance = $this->db->query("SELECT * FROM student_attendance")->row_array();
		$data_attendance = $this->db->query("SELECT * FROM student_attendance WHERE date = '" . date('Y-m-d') . "'")->row_array();
		if ($curr_time > $time_cek) {
			if ($cek_data_attendance != 0) {
				$status = '1';
				$description = "Siswa sudah melakukan absensi pulang!";
				$data = [
					'status' => $status,
					// 'time' => date('H:i:s'),
					'description' => $description
				];
				// $this->db->where('user_id', $user_id);
				$this->db->where('date', date('Y-m-d'));
				// $this->db->where('status !=', '3');
				// $this->db->or_where('status !=', '4');
				$this->db->update('student_attendance', $data);
			} else {
				if($data_attendance['status'] == '3')
				{
					$status = '3';
					$description = "Siswa tidak masuk karena sakit!";
					$data = [
					'status' => $status,
					// 'time' => date('H:i:s'),
					'description' => $description
					];
					// $this->db->where('user_id', $user_id);
					$this->db->where('date', date('Y-m-d'));
					// $this->db->where('status !=', '3');
					// $this->db->or_where('status !=', '4');
					$this->db->update('student_attendance', $data);
				}
				else if($data_attendance['status'] == '4')
				{
					$status = '4';
					$description = "Siswa tidak masuk karena izin!";
					$data = [
					'status' => $status,
					// 'time' => date('H:i:s'),
					'description' => $description
					];
					// $this->db->where('user_id', $user_id);
					$this->db->where('date', date('Y-m-d'));
					// $this->db->where('status !=', '3');
					// $this->db->or_where('status !=', '4');
					$this->db->update('student_attendance', $data);
				}
				else
				{
					$status = '0';
					$description = "Siswa tidak hadir / belum melakukan absensi pulang!";
					$data = [
					'status' => $status,
					// 'time' => date('H:i:s'),
					'description' => $description
					];
					// $this->db->where('user_id', $user_id);
					$this->db->where('date', date('Y-m-d'));
					// $this->db->where('status !=', '3');
					// $this->db->or_where('status !=', '4');
					$this->db->update('student_attendance', $data);
				}
			}
		}
	}

	public function absen()
	{
		$hasil_scan = $this->input->post('qr');
		$today = date('D');
		// $scan = $this->db->query("SELECT * FROM qr where qr_token = '" . $hasil_scan . "'")->num_rows();
		$scan = $this->Absensi_model->getKodeScan($hasil_scan)->num_rows();
		
		//LOGIKA SCAN QR UMUM
		if ($scan == 1) {
			$user_id = $this->input->post('user_id');
			$this->Absensi_model->getSiswaById($user_id);

			// Logika Pemilihan Absensi Pada Model Absensi Model
			$this->Absensi_model->absen();

			// echo "ABSEN BIASA";
			// $this->session->set_flashdata('message', '<div class="alert alert-success" role="danger">Absen Berhasil</div>');
			// redirect('user');

		}

		//LOGIKA SCAN SELAIN DARI QR UMUM
		elseif ($scan == 0) {
			// $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
			$cek_scan = $this->db->get_where('student_room', ['qr_token' => $hasil_scan])->num_rows();
			if ($cek_scan == 0) {
				$this->session->set_flashdata('message', '<script>
									swal({
								title: "ABSENSI RUANGAN",
								text: "QR Code Tidak Sesuai, Harap Cek QR Code nya!",
								icon: "error",
								button: "OK"
								// timer: 3000
							});
								</script>');
				redirect('siswa');
			}

			$kelas = $this->input->post('kelas');
			$today = date('D');
			// $scan = $this->db->query("SELECT * FROM qr where qr_token = '" . $hasil_scan . "'")->num_rows();
			$scan = $this->Absensi_model->getRoomByQr($hasil_scan)->num_rows();
			$data_ruangan = $this->Absensi_model->getRoomByQr($hasil_scan)->row_array();

			$cek_ruangan = $this->db->query("SELECT * FROM student_room_history where room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();

			$data_room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->row_array();
			$cek_data_room_history = $this->db->query("SELECT * FROM student_room_history WHERE  (class != '-' AND class != '" . $kelas . "') AND room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();
			$cek_kelas = $this->db->query("SELECT * FROM student_room_absent WHERE room_history_id = '" . $data_room_history['id'] . "'")->num_rows();

			$cek_jam_ruangan = date('H:i:s', strtotime('+30 minutes', strtotime($data_room_history['start_time'])));

			$data_history = $this->db->query("SELECT * FROM student_room WHERE room_id = '" . $data_room_history['room_id'] . "'")->row_array();

			if ($data_ruangan['status'] == 'Flexible') {
				redirect('scan/pilihan_scan/' . $data_ruangan['room_id']);
				// $user_id = $this->input->post('user_id');
				// $cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id ='" . $user_id . "' AND (status = '0' OR status = '3' OR status = '4') AND date = '" . date('Y-m-d') . "'")->num_rows();
				// if ($cek_absen != 0) {
				// 	$jam_masuk = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Masuk'")->row_array();
				// 	if (date('H:i:s') > $jam_masuk['time_end']) {
				// 		$status = '2';
				// 	} else {
				// 		$status = '1';
				// 	}
				// 	$data = [
				// 		'status' => $status,
				// 		'time' => date('H:i:s')
				// 	];
				// 	$this->db->where('user_id', $user_id);
				// 	$this->db->where('date', date('Y-m-d'));
				// 	$this->db->update('student_attendance', $data);

				// 	$cek_room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();
				// 	if ($cek_room_history == 0) {
				// 		$this->session->set_flashdata('message_absen', '<script>
				// 			swal({
				// 				title: "Berhasil!",
				// 				text: "Anda Berhasil Absen Pagi!",
				// 				icon: "success",
				// 				button: "OK"
				// 			// timer: 3000
				// 				});
				// 				</script>');
				// 		redirect('siswa');
				// 	}
				// }
				// $cek_ruangan = $this->db->query("SELECT * FROM student_room_history where class = '-' AND room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();
				// if ($cek_ruangan != 0) {
				// 	$this->Absensi_model->absen_kelas();
				// } else {

				// 	$cek_ruangan = $this->db->query("SELECT * FROM student_room_history where class = '" . $kelas . "' AND room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();
				// 	if ($cek_ruangan != 0 and date('H:i:s') < $cek_jam_ruangan) {
				// 		$this->session->set_flashdata('message', '<script>
				// 					swal({
				// 				title: "Absensi Ruangan",
				// 				text: "Kelas anda masih dalam proses pembelajaran, harap konfirmasi selesai terlebih dahulu sebelum menlanjutkan pembelajaran baru!",
				// 				icon: "error",
				// 				button: "Ok"
				// 				// timer: 3000
				// 			});
				// 				</script>');
				// 		redirect('siswa');
				// 	} elseif (date('H:i:s') > $cek_jam_ruangan) {
				// 		$update = [
				// 			'is_done' => 1
				// 		];
				// 		$this->db->where('class', $kelas);
				// 		$this->db->update('student_room_history', $update);
				// 	}
				// 	$data_room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->row_array();
				// 	$cek_room_history = $this->db->query("SELECT * FROM student_room_history WHERE room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();
				// 	if ($cek_room_history == 0) {
				// 		$this->session->set_flashdata('message_absen', '<script>
				// 			swal({
				// 				title: "Absensi ruangan!",
				// 				text: "Data Ruangan Belum di Buka Oleh Guru, Harap Tunggu Guru Mapel terlebih Dahulu!
				// 				!",
				// 				icon: "error",
				// 				button: "OK"
				// 			// timer: 3000
				// 				});
				// 				</script>');
				// 		redirect('siswa');
				// 	}
				// 	$input_class_history = [
				// 		'room_id' => $data_room_history['room_id'],
				// 		'lesson_id' => $data_room_history['lesson_id'],
				// 		'teacher_id' => $data_room_history['teacher_id'],
				// 		'class' => $kelas,
				// 		'date' => date('Y-m-d'),
				// 		'start_time' => $data_room_history['start_time'],
				// 		'end_time' => $data_room_history['end_time'],
				// 		'is_done' => '0',
				// 	];
				// 	$this->db->insert('student_room_history', $input_class_history);

				// 	$user_data = $this->db->query("SELECT * FROM user where class_name = '" . $kelas . "' AND role_id = '6'")->result_array();
				// 	$data = array();
				// 	foreach ($user_data as $ud) {
				// 		$absen_siswa = $this->db->query("SELECT * FROM student_attendance where user_id = '" . $ud['id'] . "' AND date = '" . date('Y-m-d') . "'")->row_array();
				// 		$row_arr = array(
				// 			'room_history_id' => $data_room_history['id'],
				// 			'student_id' => $ud['id'],
				// 			'lessons_id' => $data_room_history['lesson_id'],
				// 			'tanggal' => date('Y-m-d'),
				// 			'time' => date('H:i:s'),
				// 			'status' => $absen_siswa['status'],
				// 			'description' => '-'
				// 		);
				// 		array_push($data, $row_arr);
				// 	}

				// 	$this->db->insert_batch('student_room_absent', $data);



				// 	$this->session->set_flashdata('message_absen', '<script>
				// 	swal({
				// 		title: "Berhasil!",
				// 		text: "Absen Ruangan Berhasil!",
				// 		icon: "success",
				// 		button: "OK"
				// 	// timer: 3000
				// 		});
				// 		</script>');
				// 	redirect('siswa');
				// }
			}

			if ($cek_kelas != 0 and $data_history['status'] != 'Flexible' and date('H:i:s') < $cek_jam_ruangan) {
				$user_id = $this->input->post('user_id');
				// $cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id ='" . $user_id . "' AND (status = '0' OR status = '3' OR status = '4') AND date = '" . date('Y-m-d') . "'")->num_rows();
				$cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id ='" . $user_id . "' AND status = '0' OR status_siswa_pulang = '0' AND date = '" . date('Y-m-d') . "'")->num_rows();
				if ($cek_absen != 0) {
					
					//JALANKAN ABSENSI MODEL
					// Logika Pemilihan Absensi Pada Model Absensi Model
			        $this->Absensi_model->absen();

				//	$jam_masuk = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Masuk'")->row_array();
				//	if (date('H:i:s') > $jam_masuk['time_end']) {
				//		$status = '2';
				//	} else {
				//		$status = '1';
				//	}
				//	$data = [
				//		'status' => $status,
				//		'time' => date('H:i:s')
				//	];
				//	$this->db->where('user_id', $user_id);
				//	$this->db->where('date', date('Y-m-d'));
				//	$this->db->update('student_attendance', $data);

				//	$this->session->set_flashdata('message', '<script>
				//			swal({
				//		title: "Absen Berhasil",
				//		text: "Anda Berhasil Absen!",
				//		icon: "success",
				//		button: "Ok"
				//		// timer: 3000
				//	});
				//		</script>');
				//	redirect('siswa');
				} 
				else {
					$this->session->set_flashdata('message', '<script>
							swal({
						title: "INFORMASI!",
						text: "Harap Periksa Status Kehadiran Anda Terlebih Dahulu Pada Halaman Dashboard!",
						icon: "info",
						button: "OK"
						// timer: 3000
					});
						</script>');
					redirect('siswa');
				}
			}
			 
			elseif ($cek_ruangan == 0) {
				$user_id = $this->input->post('user_id');
				// $cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id ='" . $user_id . "' AND (status = '0' OR status = '3' OR status = '4') AND date = '" . date('Y-m-d') . "'")->num_rows();
				$cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id ='" . $user_id . "' AND status = '0' OR status_siswa_pulang = '0' AND date = '" . date('Y-m-d') . "'")->num_rows();
				if ($cek_absen != 0) {
					//JALANKAN ABSENSI MODEL
					// Logika Pemilihan Absensi Pada Model Absensi Model
			        $this->Absensi_model->absen();
					
				// $jam_masuk = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Masuk'")->row_array();
					
				//	if (date('H:i:s') > $jam_masuk['time_end']) {
				//		$status = '2';
				//	} else {
				//		$status = '1';
				//	}
				//	$data = [
				//		'status' => $status,
				//		'time' => date('H:i:s')
				//	];
				//	$this->db->where('user_id', $user_id);
				//	$this->db->where('date', date('Y-m-d'));
				//	$this->db->update('student_attendance', $data);

				//	$this->session->set_flashdata('message', '<script>
				//			swal({
				//		title: "Absen Berhasil",
				//		text: "Anda Berhasil Absen!",
				//		icon: "success",
				//		button: "Ok"
				//		// timer: 3000
				//	});
				//		</script>');
				//	redirect('siswa');
				}
				/* 
				else {
					$this->session->set_flashdata('message', '<script>
							swal({
						title: "Absensi Ruangan",
						text: "Ruangan Belum di Buka Oleh Guru, Harap Tunggu Guru Mapel Terlebih Dahulu!",
						icon: "error",
						button: "Ok"
						// timer: 3000
					});
						</script>');
					redirect('siswa');
				}
				*/ 
				else {
					$this->session->set_flashdata('message', '<script>
							swal({
						title: "INFORMASI!",
						text: "Coba Cek Status Kehadiran Pada Halaman Dashboard",
						icon: "info",
						button: "OK"
						// timer: 3000
					});
						</script>');
					redirect('siswa');
				}
			} 
			elseif ($cek_data_room_history != 0 and $data_history['status'] != 'Flexible') {
				$this->session->set_flashdata('message', '<script>
							swal({
						title: "INFORMASI!",
						text: "Ruangan tersebut sedang dipakai oleh kelas lain!",
						icon: "error",
						button: "OK"
						// timer: 3000
					});
						</script>');
				redirect('siswa');
				// echo "Coba";
				// echo $data_history['status'];
			} 
			else {
				if ($scan == 1) {
					$user_id = $this->input->post('user_id');
					// $cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id ='" . $user_id . "' AND (status = '0' OR status = '3' OR status = '4') AND date = '" . date('Y-m-d') . "'")->num_rows();
					$cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id ='" . $user_id . "' AND status = '0' OR status_siswa_pulang = '0' AND date = '" . date('Y-m-d') . "'")->num_rows();
					if ($cek_absen != 0) {
					
					//JALANKAN ABSENSI MODEL
					// Logika Pemilihan Absensi Pada Model Absensi Model
			        // $this->Absensi_model->absen();

						$jam_masuk = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Masuk'")->row_array();
						$jam_pulang = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Pulang'")->row_array();
						
						// LOGIKA JAM MASUK
						// if (date('H:i:s') > $jam_masuk['time_end']) {
						//	$status = '2';
						// } else {
						//	$status = '1';
						// }

						//LOGIKA JAM PULANG
						if (date('H:i:s') > $jam_pulang['time_start']) {
							$this->Absensi_model->absen();
						}
				
				        // if ((date('l') == "Friday" || date('l') == "Jumat") && date('H:i:s') > "11:20:00") {
						//	$this->Absensi_model->absen();
						// } 
						//else 
						// if (!(date('l') == "Friday" || date('l') == "Jumat") && date('H:i:s') > "14:00:00") {
						//	$this->Absensi_model->absen();
						// }

						$data = [
							'status' => 1,
							// 'time' => date('H:i:s'),
							'description' => "Siswa masuk setelah ruangan dibuka oleh guru mata pelajaran!"
						];
						$this->db->where('user_id', $user_id);
						$this->db->where('date', date('Y-m-d'));
						$this->db->update('student_attendance', $data);
					}

					if ($data_history['status'] != 'Flexible') {

						$update = [
							'is_done' => 1
						];
						$this->db->where('class', $kelas);
						$this->db->update('student_room_history', $update);
					}


					$cek_ruangan = $this->db->query("SELECT * FROM student_room_history where room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();
					if ($cek_ruangan == 0) {
						$this->session->set_flashdata('message', '<script>
									swal({
								title: "INFORMASI!",
								text: "Ruangan belum dibuka oleh guru mata pelajaran, harap tunggu guru mata pelajaran terlebih dahulu di scan!",
								icon: "error",
								button: "OK"
								// timer: 3000
							});
								</script>');
						redirect('siswa');
					}

					// echo $kelas;
					// echo "Absen";
					$this->Absensi_model->absen_kelas();
					// echo $user_id;
					// echo "OKE12";

					// $this->session->set_flashdata('message', '<div class="alert alert-success" role="danger">Absen Berhasil</div>');
					// redirect('user');

				} elseif ($scan == 0) {
					// $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
					$this->session->set_flashdata('message', '<script>
							swal({
						title: "QR Code Status",
						text: "QR Code Tidak Valid, Silahkan Scan Pada QR Code Yang Sesuai di Sekolah!",
						icon: "error",
						button: "OK"
						// timer: 3000
					});
						</script>');
					redirect('siswa');
				}
			}
		}
	}


	public function mapel()
	{
		$hasil_scan = $this->input->post('qr');
		$today = date('D');
		// $scan = $this->db->query("SELECT * FROM qr where qr_token = '" . $hasil_scan . "'")->num_rows();
		$scan = $this->Absensi_model->getRoomByQr($hasil_scan)->num_rows();
		$data_ruangan = $this->Absensi_model->getRoomByQr($hasil_scan)->row_array();
		$cek_ruangan = $this->db->query("SELECT * FROM student_room_history where room_id = '" . $data_ruangan['room_id'] . "' AND is_done = '0'")->num_rows();
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$cek_data_room_history = $this->db->query("SELECT * FROM student_room_history WHERE  teacher_id = '" . $user['id'] . "' AND date LIKE '" . date('Y-m-d') . "' AND is_done = '0'")->num_rows();


		// CEK RUANGAN FLEXIBLE
		if ($data_ruangan['status'] == 'Flexible') {
			if ($scan == 1) {
				$user_id = $this->input->post('user_id');
				// UPDATE STATUS IS DONE DI RUANGAN DAN SEMUA DATA RUANGAN GURU BERSANGKUTAN KETIKA BERHASIL ENROLL RUANGAN
				$this->Absensi_model->getSiswaById($user_id);
				$this->Absensi_model->mapel();

				// $this->session->set_flashdata('message', '<div class="alert alert-success" role="danger">Absen Berhasil</div>');
				// redirect('user');

			} elseif ($scan == 0) {
				// $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
				$this->session->set_flashdata('message', '<script>
						swal({
					title: "QR Code Status",
					text: "QR Token Tidak Valid",
					icon: "error",
					button: "Ok"
					// timer: 3000
				});
					</script>');
				redirect('guru');
			}
		}
		// CEK JIKA RUANGAN PENUH
		elseif ($cek_ruangan > 0 && $data_ruangan['status'] == 'Normal') {
			$data_room_history = $this->db->query("SELECT * FROM student_room_history where room_id = '" . $data_ruangan['room_id'] . "' AND is_done = '0'")->row_array();
			// CEK JIKA RUANGAN BARU DIKAPAI / BELUM LEBIH DARI 5 MENIT MAKA MENAMPILKAN NOTIF RUANGAN PENUH, KALAU LEBIH DARI 5 MENIT MAKA LANGSUNG ENROLL RUANGAN
			if (date('H:i:s') < date('H:i:s', strtotime('+5 minutes', strtotime($data_room_history['start_time'])))) {
				$this->session->set_flashdata('message', '<script>
						swal({
					title: "Ruangan Penuh",
					text: "Ruangan sedang di pakai, harap pakai ruangan yang lain!",
					icon: "error",
					button: "Ok"
					// timer: 3000
				});
					</script>');
				redirect('guru');
			} else {
				if ($scan == 1) {
					$user_id = $this->input->post('user_id');
					// UPDATE STATUS IS DONE DI RUANGAN DAN SEMUA DATA RUANGAN GURU BERSANGKUTAN KETIKA BERHASIL ENROLL RUANGAN
					$this->db->query("UPDATE student_room_history SET is_done = '1', end_time = '" . date('H:i:s') . "' WHERE id = '" . $data_room_history['id'] . "' AND is_done = '0'");
					$this->db->query("UPDATE student_room_history SET is_done = '1', end_time = '" . date('H:i:s') . "' WHERE teacher_id = '" . $user['id'] . "' AND date = '" . date('Y-m-d') . "' AND is_done = '0'");
					$this->Absensi_model->getSiswaById($user_id);
					$this->Absensi_model->mapel();

					// $this->session->set_flashdata('message', '<div class="alert alert-success" role="danger">Absen Berhasil</div>');
					// redirect('user');

				} elseif ($scan == 0) {
					// $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
					$this->session->set_flashdata('message', '<script>
							swal({
						title: "QR Code Status",
						text: "QR Token Tidak Valid",
						icon: "error",
						button: "Ok"
						// timer: 3000
					});
						</script>');
					redirect('guru');
				}
			}
		}
		// CEK STATUS GURU SEDANG MENGAJAR
		elseif ($cek_data_room_history > 0 && $data_ruangan['status'] == 'Normal') {
			$data_room_history = $this->db->query("SELECT * FROM student_room_history where teacher_id = '" . $user['id'] . "' AND is_done = '0'")->row_array();
			// CEK JIKA RUANGAN BARU DIKAPAI / BELUM LEBIH DARI 5 MENIT MAKA MENAMPILKAN NOTIF RUANGAN PENUH, KALAU LEBIH DARI 5 MENIT MAKA LANGSUNG ENROLL RUANGAN
			if (date('H:i:s') < date('H:i:s', strtotime('+5 minutes', strtotime($data_room_history['start_time'])))) {
				$this->session->set_flashdata('message', '<script>
						swal({
					title: "Status Pembelajaran",
					text: "Sesi Pembelajaran Anda Masih Ada, Silahkan Akhiri Sesi Pembelajaran Sebelumnya Jika Ingin Membuka Sesi Pembelajaran Baru!",
					icon: "error",
					button: "Ok"
					// timer: 3000
				});
					</script>');
				redirect('guru');
			} else {
				if ($scan == 1) {
					$user_id = $this->input->post('user_id');
					// UPDATE STATUS IS DONE DI RUANGAN DAN SEMUA DATA RUANGAN GURU BERSANGKUTAN KETIKA BERHASIL ENROLL RUANGAN
					$this->db->query("UPDATE student_room_history SET is_done = '1', end_time = '" . date('H:i:s') . "' WHERE id = '" . $data_room_history['id'] . "' AND is_done = '0'");
					$this->db->query("UPDATE student_room_history SET is_done = '1', end_time = '" . date('H:i:s') . "' WHERE teacher_id = '" . $user['id'] . "' AND is_done = '0'");
					// $this->Absensi_model->getSiswaById($user_id);
					$this->Absensi_model->mapel();

					// $this->session->set_flashdata('message', '<div class="alert alert-success" role="danger">Absen Berhasil</div>');
					// redirect('user');

				} elseif ($scan == 0) {
					// $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
					$this->session->set_flashdata('message', '<script>
							swal({
						title: "QR Code Status",
						text: "QR Token Tidak Valid",
						icon: "error",
						button: "Ok"
						// timer: 3000
					});
						</script>');
					redirect('guru');
				}
			}
		} else {
			if ($scan == 1) {
				$user_id = $this->input->post('user_id');

				$this->Absensi_model->getSiswaById($user_id);
				$this->Absensi_model->mapel();

				// $this->session->set_flashdata('message', '<div class="alert alert-success" role="danger">Absen Berhasil</div>');
				// redirect('user');

			} elseif ($scan == 0) {
				// $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
				$this->session->set_flashdata('message', '<script>
						swal({
					title: "QR Code Status",
					text: "QR Token Tidak Valid",
					icon: "error",
					button: "Ok"
					// timer: 3000
				});
					</script>');
				redirect('guru');
			}
		}
	}

	public function kelas()
	{
		$hasil_scan = $this->input->post('qr');
		$kelas = $this->input->post('kelas');
		$today = date('D');
		// $scan = $this->db->query("SELECT * FROM qr where qr_token = '" . $hasil_scan . "'")->num_rows();
		$scan = $this->Absensi_model->getRoomByQr($hasil_scan)->num_rows();
		$data_ruangan = $this->Absensi_model->getRoomByQr($hasil_scan)->row_array();
		$cek_ruangan = $this->db->query("SELECT * FROM student_room_history where room_id = '" . $data_ruangan['room_id'] . "' AND is_done = '0'")->num_rows();

		$cek_ruangan = $this->db->query("SELECT * FROM student_room_history where room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();

		$data_room_history = $this->db->query("SELECT * FROM student_room_history WHERE class = '" . $kelas . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->row_array();
		$cek_data_room_history = $this->db->query("SELECT * FROM student_room_history WHERE  class != '-' AND room_id = '" . $data_ruangan['room_id'] . "' AND date LIKE '" . date('Y-m-d') . "%' AND is_done = '0'")->num_rows();
		$cek_kelas = $this->db->query("SELECT * FROM student_room_absent WHERE room_history_id = '" . $data_room_history['id'] . "'")->num_rows();

		$data_history = $this->db->query("SELECT student_room.status FROM student_room_history 
		INNER JOIN student_room ON student_room.room_id = student_room_history.room_id
		WHERE student_room_history.id = '" . $data_room_history['id'] . "'")->row_array();

		if ($cek_kelas != 0 and $data_history['status'] != 'Flexible') {
			$this->session->set_flashdata('message', '<script>
						swal({
					title: "Absensi Ruangan",
					text: "Kelas anda masih dalam proses pembelajaran, harap konfirmasi selesai terlebih dahulu sebelum menlanjutkan pembelajaran baru!",
					icon: "error",
					button: "Ok"
					// timer: 3000
				});
					</script>');
			redirect('siswa');
		} elseif ($cek_ruangan == 0) {

			$this->session->set_flashdata('message', '<script>
						swal({
					title: "Absensi Ruangan",
					text: "Ruangan Belum di Buka Oleh Guru, Harap Tunggu Guru Mapel Terlebih Dahulu!",
					icon: "error",
					button: "Ok"
					// timer: 3000
				});
					</script>');
			redirect('siswa');
		} elseif ($cek_data_room_history != 0 and $data_history['status'] != 'Flexible') {
			$this->session->set_flashdata('message', '<script>
						swal({
					title: "Absensi Ruangan",
					text: "Ruangan tersebut sedang di pakai oleh Kelas Lain!",
					icon: "error",
					button: "Ok"
					// timer: 3000
				});
					</script>');
			redirect('siswa');
		} else {
			if ($scan == 1) {

				$this->Absensi_model->absen_kelas();

				// $this->session->set_flashdata('message', '<div class="alert alert-success" role="danger">Absen Berhasil</div>');
				// redirect('user');

			} elseif ($scan == 0) {
				// $this->session->set_flashdata('message_absen', '<div class="alert alert-danger" role="danger">Qr tidak valid</div>');
				$this->session->set_flashdata('message', '<script>
						swal({
					title: "QR Code Status",
					text: "QR Token Tidak Valid",
					icon: "error",
					button: "Ok"
					// timer: 3000
				});
					</script>');
				redirect('siswa');
			}
		}
	}




	public function pilihan_scan($room_id = "")
	{
		$data['ruangan'] = $this->db->get_where('student_room', ['room_id' => $room_id])->row_array();
		$data['guru']    = $this->db->query("SELECT student_room_history.id, user.name FROM student_room_history 
		INNER JOIN user on user.id = student_room_history.teacher_id
		WHERE room_id = '" . $room_id . "' and is_done = 0 ")->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('scan/konfirmasi_flexible', $data);
		$this->load->view('templates/footer');
	}

	public function absensi_flexible()
	{
		$user_id = $this->input->post('user_id');
		$cek_absen = $this->db->query("SELECT * FROM student_attendance WHERE user_id ='" . $user_id . "' AND (status = '0' OR status = '3' OR status = '4') AND date = '" . date('Y-m-d') . "'")->num_rows();
		if ($cek_absen != 0) {
			$jam_masuk = $this->db->query("SELECT * FROM time_attendance where time_schedule = 'Jam Masuk'")->row_array();
			if (date('H:i:s') > $jam_masuk['time_end']) {
				$status = '2';
			} else {
				$status = '1';
			}
			$data = [
				'status' => $status,
				'time' => date('H:i:s')
			];
			$this->db->where('user_id', $user_id);
			$this->db->where('date', date('Y-m-d'));
			$this->db->update('student_attendance', $data);
		}
		$isi_post = $this->input->post();
		$cek_data = $this->db->get_where('student_room_absent', ['room_history_id' => $isi_post['room_history'], 'student_id' => $user_id])->num_rows();
		if ($cek_data > 0) {
			$this->session->set_flashdata('message_absen', '<script>
				swal({
					title: "Gagal!",
					text: "Anda sedang dalam pembelajaran!",
					icon: "error",
					button: "OK"
				// timer: 3000
					});
					</script>');
			redirect('siswa');
		}
		$data_history = $this->db->get_where('student_room_history', ['id' => $isi_post['room_history']])->row_array();
		if ($data_history['class'] == '-') {
			$update_history = [
				'class' => $isi_post['kelas']
			];
			$this->db->where('id', $data_history['id']);
			$this->db->update('student_room_history', $update_history);
		}

		$user_data = $this->db->query("SELECT * FROM user where class_name = '" . $isi_post['kelas'] . "' AND role_id = '6'")->result_array();
		$data = array();
		foreach ($user_data as $ud) {
			$absen_siswa = $this->db->query("SELECT * FROM student_attendance where user_id = '" . $ud['id'] . "' AND date = '" . date('Y-m-d') . "'")->row_array();
			$row_arr = array(
				'room_history_id' => $data_history['id'],
				'student_id' => $ud['id'],
				'lessons_id' => $data_history['lesson_id'],
				'tanggal' => date('Y-m-d'),
				'time' => date('H:i:s'),
				'status' => $absen_siswa['status'],
				'description' => $absen_siswa['description']
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
}
