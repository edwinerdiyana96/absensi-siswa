<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Operator extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		// is_logged_in();
		// $this->load->library('datatables');
		$this->load->model('Admin_model');
		$this->load->model('Absensi_model');
		$this->load->model('Operator_model');
		$this->load->model('M_Datatables');
		$this->load->model('Laporan_model');
		// $cek = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->num_rows();
		// if ( $cek == 0) {
		//     redirect('auth');
		// }


	}

	// =================================== Controler Dashboard ===================================

	public function index()
	{
		$data['title'] = 'DASHBOARD OPERATOR';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['kelas'] = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();
		$data['attendace_today'] = $this->Absensi_model->getAttendanceAll()->result_array();
		$data['hadir'] = $this->Laporan_model->total_siswa_hadir_tepat_waktu();
		$data['hadir_telat'] = $this->Laporan_model->total_siswa_hadir_telat();
		$data['sakit'] = $this->Laporan_model->total_siswa_sakit();
		$data['izin'] = $this->Laporan_model->total_siswa_izin();
		$data['alpha'] = $this->Laporan_model->total_siswa_alpha();
		$data['status_guru'] = $this->Absensi_model->status_pembelajaran($data['user']['id'])->row_array();
		// $data['status_guru'] = 0;



		$data['wali_kelas'] = $this->db->get_where('student_class', ['homeroom_teacher' => $this->session->userdata('id')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/index', $data);
		$this->load->view('templates/footer');
	}


	// =================================== Controler Guru =================================== //

	public function guru()
	{
		$data['title'] = 'DATA GURU';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['role'] = $this->db->get('user_role')->result_array();
		// $data['list_user'] = $this->Admin_model->getAll();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/guru', $data);
		$this->load->view('templates/footer');
	}

	function data_guru()
	{
		$query  = "SELECT * FROM user";
		$search = array('name', 'department', 'email', 'phone', 'gender', 'id');
		// $where  = null; 
		$where  = array('role_id' => '3');

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}

	public function editGuruProfile($id = "", $params = "")
	{
		if ($params == 'profile') {
			$role_id = $this->input->post('role');
			$role = $this->Admin_model->getRoleById($role_id);
			$user_role_id = $this->Admin_model->getUserById($id);
			$data =  [
				'name'      => htmlspecialchars($this->input->post('name')),
				'email'     => htmlspecialchars($this->input->post('email')),
				'phone'         => htmlspecialchars($this->input->post('phone')),
				'department'    => $role['role'],
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
			// redirect('Admin/editUserProfile/'.$id);

			// if ($user_role_id == 17 or $user_role_id == 7) {
			redirect('operator/guru');
			// }
			// else {
			// redirect('admin/manage');
			// }

		} elseif ($params == 'password') {
			$user = $this->Admin_model->getUserById($id);
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
			redirect('operator/guru');
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
			redirect('operator/guru');
		} else {
			$data['title'] = 'EDIT DATA GURU';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$data['user_edit'] = $this->Admin_model->getUserById($id);
			$data['role'] = $this->db->get('user_role')->result_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('operator/edit-guru', $data);
			$this->load->view('templates/footer');
		}
	}

	public function deleteGuru($id)
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
		redirect('operator/guru');
	}

	// =================================== Controler Siswa ===================================

	public function siswa($params = "", $params2 = "    ")
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
			redirect('operator/siswa');
		} elseif ($params == 'excel') {
			include APPPATH . 'third_party/excel_reader/php-excel-reader/excel_reader2.php';
			include APPPATH . 'third_party/excel_reader/SpreadsheetReader.php';

			$name = $_FILES['file']['name'];
			$target_dir = 'assets/uploads/';
			$target_file = $target_dir . $_FILES["file"]["name"];

			$data_input = array();

			// Select file type
			$FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			// Valid file extensions
			$extensions_arr = array("xlsx", "xls", "csv", "jpg");

			// Check extension
			if (in_array($FileType, $extensions_arr)) {

				// Upload
				if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
					// Insert record
					$Reader = new SpreadsheetReader($target_file);
					$cek = 0;
					foreach ($Reader as $key => $row) {

						$NIS = str_replace("-", "", $row[0]);
						$NIS = str_replace("+", "", $NIS);
						$NIS = str_replace(" ", "", $NIS);
						$NIS = str_replace(".", "", $NIS);
						$NIS = str_replace(",", "", $NIS);
						$NIS = str_replace("'", "", $NIS);
						$NIS = str_replace("(", "", $NIS);

						$nama_siswa = str_replace("-", "", $row[1]);
						$nama_siswa = str_replace("+", "", $nama_siswa);
						$nama_siswa = str_replace(".", "", $nama_siswa);
						$nama_siswa = str_replace(",", "", $nama_siswa);
						$nama_siswa = str_replace("'", "", $nama_siswa);
						$nama_siswa = str_replace("(", "", $nama_siswa);
						$nama_siswa = str_replace(")", "", $nama_siswa);
						$nama_siswa = str_replace("?", " ", $nama_siswa);

						if ($cek > 2) {
							$data_input[] = array(
								'name' => $nama_siswa,
								'email' => $NIS,
								'image' => "default.jpg",
								'password' => password_hash($NIS, PASSWORD_DEFAULT),
								'role_id' => "6",
								'is_active' => "1",
								'date_created' => date('Y-m-d'),
								'department' => "Siswa",
								'class_name' => strtoupper($row[2]),
								'phone' => $row[3],
								'gender' => $row[4],
								'address' => $row[5],
								'is_flexible' => 0
							);
							// $data = [
							// 	'name' => $nama_siswa,
							// 	'email' => $NIS,
							// 	'image' => "default.jpg",
							// 	'password' => password_hash($NIS, PASSWORD_DEFAULT),
							// 	'role_id' => "6",
							// 	'is_active' => "1",
							// 	'date_created' => date('Y-m-d'),
							// 	'department' => "Siswa",
							// 	'class_name' => strtoupper($row[2]),
							// 	'phone' => $row[3],
							// 	'gender' => $row[4],
							// 	'address' => $row[5],
							// 	'is_flexible' => 0
							// ];
							// $this->db->insert('user', $data);

						}
						$cek++;
					}

					$this->db->insert_batch('user', $data_input);
					$this->session->set_flashdata('message', '<script>
						swal({
							title: "Berhasil!",
							text: "Data Siswa Berhasil di Tambahkan",
							icon: "success",
							button: "Ok"
		                // timer: 3000
							});
							</script>');
					redirect('operator/siswa');
				}
			} else {
				$this->session->set_flashdata('message', '<script>
					swal({
						title: "Berhasil!",
						text: "File yang di upload harus berformal xlsx, xls dan csv dengan ukuran maximal 10mb",
						icon: "success",
						button: "Ok"
		                // timer: 3000
						});
						</script>');
				redirect('operator/siswa');
			}
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
			redirect('operator/siswa');
		} elseif ($params == 'export') {

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

			$sheet->setCellValue('A1', "LAPORAN DATA SISWA SMK KARYA NASIONAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
			$sheet->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$sheet->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
			$sheet->setCellValue('A2', "Jl. Cirendang - Cigugur, Cirendang, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45518"); // Set kolom A1 dengan tulisan "DATA SISWA"
			$sheet->mergeCells('A2:G2'); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$sheet->getStyle('A1')->getAlignment()->setHorizontal($alignment_center);
			$sheet->getStyle('A2')->getAlignment()->setHorizontal($alignment_center);

			// Buat header tabel nya pada baris ke 3

			$sheet->setCellValue('A4', "NIS"); // Set kolom A3 dengan tulisan "NO"
			$sheet->setCellValue('B4', "Nama"); // Set kolom B3 dengan tulisan "NIS"
			$sheet->setCellValue('C4', "Kelas"); // Set kolom C3 dengan tulisan "NAMA"
			$sheet->setCellValue('D4', "Angkatan"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
			$sheet->setCellValue('E4', "No Telepon"); // Set kolom E3 dengan tulisan "TELEPON"
			$sheet->setCellValue('F4', "Jenis Kelamin"); // Set kolom F3 dengan tulisan "ALAMAT"
			$sheet->setCellValue('G4', "Alamat"); // Set kolom F3 dengan tulisan "ALAMAT"


			// Apply style header yang telah kita buat tadi ke masing-masing kolom header
			$sheet->getStyle('A4')->applyFromArray($style_col);
			$sheet->getStyle('B4')->applyFromArray($style_col);
			$sheet->getStyle('C4')->applyFromArray($style_col);
			$sheet->getStyle('D4')->applyFromArray($style_col);
			$sheet->getStyle('E4')->applyFromArray($style_col);
			$sheet->getStyle('F4')->applyFromArray($style_col);
			$sheet->getStyle('G4')->applyFromArray($style_col);

			// Set height baris ke 1, 2 dan 3
			$sheet->getRowDimension('1')->setRowHeight(20);
			$sheet->getRowDimension('2')->setRowHeight(20);
			$sheet->getRowDimension('3')->setRowHeight(20);
			$sheet->getRowDimension('4')->setRowHeight(20);

			// Buat query untuk menampilkan semua data siswa


			$angkatan = $this->input->post('grade');
			if ($angkatan == 'ALL') {
				$data = $this->db->query("SELECT * FROM user WHERE role_id = '6'")->result_array();
			} else {
				$data = $this->db->query("SELECT * FROM user WHERE role_id = '6' AND class_name LIKE '" . $angkatan . " %'")->result_array();
			}

			$no = 1; // Untuk penomoran tabel, di awal set dengan 1
			$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
			foreach ($data as $key => $data) { // Ambil semua data dari hasil eksekusi $sql

				// $hadir = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM data_attendance where date <= '$tanggal_akhir' and date >= '$tanggal_awal' and status = '1' and user_id = '".$data['id']."'"));
				// $izin = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM data_attendance where date <= '$tanggal_akhir' and date >= '$tanggal_awal' and status = '4' and user_id = '".$data['id']."'"));
				// $sakit = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM data_attendance where date <= '$tanggal_akhir' and date >= '$tanggal_awal' and status = '3' and user_id = '".$data['id']."'"));
				// $telat = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM data_attendance where date <= '$tanggal_akhir' and date >= '$tanggal_awal' and status = '2' and user_id = '".$data['id']."'"));
				// $alpha = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM data_attendance where date <= '$tanggal_akhir' and date >= '$tanggal_awal' and status = '0' and user_id = '".$data['id']."'"));

				$sheet->setCellValue('A' . $numrow, $data['email']);
				$sheet->setCellValue('B' . $numrow, $data['name']);
				$sheet->setCellValue('C' . $numrow, $data['class_name']);
				$sheet->setCellValue('D' . $numrow, $angkatan);
				$sheet->setCellValue('E' . $numrow, $data['phone']);
				$sheet->setCellValue('F' . $numrow, $data['gender']);
				$sheet->setCellValue('G' . $numrow, $data['address']);


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

				$sheet->getRowDimension($numrow)->setRowHeight(20);

				$numrow++;
			}

			$no++; // Tambah 1 setiap kali looping

			$numrow++;
			// Set width kolom
			$sheet->getColumnDimension('A')->setWidth(15); // Set width kolom A
			$sheet->getColumnDimension('B')->setWidth(25); // Set width kolom B
			$sheet->getColumnDimension('C')->setWidth(20); // Set width kolom C
			$sheet->getColumnDimension('D')->setWidth(15); // Set width kolom D
			$sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
			$sheet->getColumnDimension('F')->setWidth(10); // Set width kolom F
			$sheet->getColumnDimension('G')->setWidth(35); // Set width kolom C





			$sheet->setCellValue('G' . $numrow, "Kuningan, " . tgl_indo(date('d-m-Y'))); // Set mengetahui
			$sheet->mergeCells('G' . $numrow . ':G' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1

			$numrow++;


			$sheet->setCellValue('B' . $numrow, "Kasubag TU");
			$sheet->mergeCells('B' . $numrow . ':C' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('B' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1



			$sheet->setCellValue('G' . $numrow, "Staff Kepegawaian");
			$sheet->mergeCells('G' . $numrow . ':G' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_center);
			$numrow = $numrow + 5;

			$sheet->setCellValue('B' . $numrow, "Eman Arisman");
			$sheet->mergeCells('B' . $numrow . ':C' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('B' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1


			if ($angkatan == 'X') {
				$sheet->setCellValue('G' . $numrow, "Nono Sumartono");
				$sheet->mergeCells('G' . $numrow . ':G' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
				$sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
				$sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_center);
				$numrow++;
			} elseif ($angkatan == 'XI') {
				$sheet->setCellValue('G' . $numrow, "Yadi Suryadi");
				$sheet->mergeCells('G' . $numrow . ':G' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
				$sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
				$sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_center);
				$numrow++;
			} elseif ($angkatan == 'XII') {
				$sheet->setCellValue('G' . $numrow, "Dodi");
				$sheet->mergeCells('G' . $numrow . ':G' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
				$sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
				$sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_center);
				$numrow++;
			} else {
				$sheet->setCellValue('G' . $numrow, "Sarif Priant, A.Md.");
				$sheet->mergeCells('G' . $numrow . ':G' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
				$sheet->getStyle('G' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
				$sheet->getStyle('G' . $numrow)->getAlignment()->setHorizontal($alignment_center);
				$numrow++;
			}


			$sheet->setCellValue('C' . $numrow, "Mengetahui");
			$sheet->mergeCells('C' . $numrow . ':E' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('C' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$sheet->getStyle('C' . $numrow)->getAlignment()->setHorizontal($alignment_center);
			$numrow++;

			$sheet->setCellValue('C' . $numrow, "Kepala Sekolah");
			$sheet->mergeCells('C' . $numrow . ':E' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('C' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$sheet->getStyle('C' . $numrow)->getAlignment()->setHorizontal($alignment_center);
			$numrow = $numrow + 5;

			$sheet->setCellValue('C' . $numrow, "Dr.Yepi Esa Trijaka, M.M.Pd");
			$sheet->mergeCells('C' . $numrow . ':E' . $numrow); // Set Merge Cell pada kolom A1 sampai F1
			$sheet->getStyle('C' . $numrow)->getFont()->setSize(12); // Set font size 15 untuk kolom A1
			$sheet->getStyle('C' . $numrow)->getAlignment()->setHorizontal($alignment_center);

			// Set orientasi kertas jadi LANDSCAPE
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

			// Set judul file excel nya
			$sheet->setTitle("DATA SISWA");

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="DATA SISWA SMK KARYA NASIONAL.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
		} else {
			$data['title'] = 'DATA SISWA';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$data['class'] = $this->Operator_model->getAllClass()->result_array();
			$data['list_user'] = $this->Admin_model->getAllSiswa()->result_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('operator/siswa', $data);
			$this->load->view('templates/footer');
		}
	}

	function data_siswa()
	{
		$query  = "SELECT * FROM user";
		$search = array('class_name', 'name', 'email', 'phone', 'gender', 'id');
		// $where  = null; 
		$where  = array('role_id' => '6', 'class_name !' => 'Alumni');

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}



	// =================================== Controler Kelas ===================================

	public function kelas($params = "", $params2 = "")
	{
		$data['title'] = 'DATA KELAS';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['data_kelas'] = $this->Operator_model->getAllClass()->result_array();

		if ($params == "add") {
			$data = [
				'class' => $this->input->post('nama'),
				'homeroom_teacher' => $this->input->post('wali'),
				'class_leader' => $this->input->post('km'),
				'vice_leader' => $this->input->post('wakil'),
				'grade' => $this->input->post('grade'),
				'kode_group' => $this->input->post('kode_group'),
				'chat_id' => $this->input->post('chat_id')
			];
			$this->db->insert('student_class', $data);

			$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data Kelas Berhasil di Tambahkan",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
			redirect('operator/kelas');
		} elseif ($params == "pkl") {
			$data = [
				'status' => 'PKL'
			];
			$this->db->where('class_id', $params2);
			$this->db->update('student_class', $data);
			$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data Kelas Berhasil di Perbaharui",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
			redirect('operator/kelas');
		} else {

			$data['kelas'] = $this->Operator_model->getAllClass()->result_array();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('operator/kelas', $data);
			$this->load->view('templates/footer');
		}
	}

	function data_kelas()
	{
		date_default_timezone_set("Asia/Jakarta");
		$query  = "SELECT student_class.* , user.name FROM student_class 
		JOIN user ON student_class.homeroom_teacher = user.id";
		$search = array('class', 'name', 'class_leader', 'grade', 'class_id', 'kode_group');
		$where  = null;
		// $where  = array(
		// 'date' => date("Y-m-d"),
		// 'role_id' == '6' and 'role_id' == '3'
		// );

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}

	public function updateKelas()
	{

		$this->Operator_model->updateKelas();
		$this->session->set_flashdata('message', '<script>
			swal({
				title: "Data Kelas",
				text: "Data Kelas Berhasil Di Perbarui",
				icon: "success",
				button: "Ok"
                // timer: 3000
				});
				</script>');
		redirect('operator/kelas');
	}

	public function deleteKelas($id)
	{
		$this->Operator_model->deleteKelas($id);
		$this->session->set_flashdata('message', '<script>
			swal({
				title: "Kelas Status!",
				text: "Kelas Berhasil Dihapus!",
				icon: "success",
				button: "Ok"
                // timer: 3000
				});
				</script>');
		redirect('operator/kelas');
	}

	// =================================== Controler Ruangan ===================================

	public function ruangan($params = "", $params2 = "")
	{
		$data['title'] = 'DATA RUANGAN';
		$data['ruangan'] = $this->db->get('student_room')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		if ($params == "add") {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randstring = '';
			for ($i = 0; $i < 20; $i++) {
				$randstring = $randstring . $characters[rand(0, strlen($characters))];
			}

			$data = [
				'no' => $this->input->post('no'),
				'description' => $this->input->post('description'),
				'pic' => $this->input->post('pic'),
				'qr_token' => $randstring,
				'status' => 'Normal'
			];
			$this->db->insert('student_room', $data);


			include APPPATH . 'third_party/php-qrcode-library/qrlib.php';

			/*create folder*/
			$tempdir = "assets/qr/ruangan/";
			if (!file_exists($tempdir))
				mkdir($tempdir, 0755);
			$kode = $randstring;
			$file_name = $kode . ".png";
			$file_path = $tempdir . $file_name;

			QRcode::png($kode, $file_path, "H", 12, 2);

			$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data Ruangan Berhasil di Tambahkan",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
			redirect('operator/ruangan');
		} elseif ($params == "edit") {
			$data = [
				'no' => $this->input->post('no'),
				'description' => $this->input->post('description'),
				'pic' => $this->input->post('pic'),
				'status' => $this->input->post('status')
			];
			$this->db->where('room_id', $this->input->post('room_id'));
			$this->db->update('student_room', $data);

			$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data Ruangan Berhasil di Perbaharui",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
			redirect('operator/ruangan');
		} elseif ($params == "delete") {
			$this->db->where('room_id', $params2);
			$this->db->delete('student_room');
			$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data ruangan berhasil di hapus",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
			redirect('operator/ruangan');
		} elseif ($params == "cetak") {
			$data['data_ruangan'] = $this->db->get_where('student_room',['room_id' => $params2])->row_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('operator/cetak_qr', $data);
			$this->load->view('templates/footer');
		}else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('operator/ruangan', $data);
			$this->load->view('templates/footer');
		}
	}

	function data_ruangan()
	{
		$query  = "SELECT student_room.* , user.name FROM student_room 
		INNER JOIN user ON student_room.pic = user.id";
		$search = array('no', 'description', 'name', 'room_id', 'qr_token', 'status');
		$where  = null;
		// $where  = array('role_id' => '6');
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}

	function update()
	{ //function update data
		$room_id = $this->input->post('room_id');
		$data = array(
			'no'     => $this->input->post('no'),
			'description'    => $this->input->post('description'),
			'pic' => $this->input->post('pic')
		);
		$this->db->where('room_id', $room_id);
		$this->db->update('student_room', $data);
		redirect('operator/ruangan');
	}

	function delete()
	{ //function hapus data
		$room_id = $this->input->post('room_id');
		$this->db->where('room_id', $room_id);
		$this->db->delete('student_room');
		redirect('operator/ruangan');
	}


	// =================================== Controler Mapel ===================================

	public function mapel($params = "", $params2 = "")
	{


		if ($params == "add") {
			$data = [
				'lessons' => $this->input->post('lesson'),
				'grade' => $this->input->post('grade')
			];
			$this->db->insert('student_lessons', $data);

			$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Mata Pelajaran Berhasil di Tambahkan",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
			redirect('operator/mapel');
		} elseif ($params == "delete") {
			$this->db->where('mapel_id', $params2);
			$this->db->delete('student_lessons');
			$this->db->where('lessons_id', $params2);
			$this->db->delete('teacher_lessons');
			$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Mata Pelajaran Berhasil Di Hapus",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
			redirect('operator/mapel');
		} elseif ($params == 'updateguru') {
			$data['title'] = 'DATA GURU MAPEL';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$data['lessons_id'] = $params2;
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('operator/guru_mapel', $data);
			$this->load->view('templates/footer');
		} else {
			$data['title'] = 'DATA MAPEL';
			$data['mapel'] = $this->db->get('student_lessons')->result_array();
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('operator/mapel', $data);
			$this->load->view('templates/footer');
		}
	}

	public function add_mapel_guru()
	{
		$data = [
			'lessons_id' => $this->input->post('lesson_id'),
			'user_id' => $this->input->post('guru')
		];
		$this->db->insert('teacher_lessons', $data);

		$this->session->set_flashdata('message', '<script>
			swal({
				title: "Berhasil!",
				text: "Data Guru Mapel Berhasil di Tambahkan",
				icon: "success",
				button: "Ok"
                // timer: 3000
				});
				</script>');
		redirect($_SERVER['HTTP_REFERER']);
		// Menghapus flash data secara manual
		$this->session->unset_flashdata('message');
	}

	public function delete_guru_mapel($params = "")
	{
		$this->db->where('teacher_lessons_id', $params);
		$this->db->delete('teacher_lessons');

		$this->session->set_flashdata('message', '<script>
			swal({
				title: "Berhasil!",
				text: "Data Guru Mapel Berhasil di Hapuskan",
				icon: "success",
				button: "Ok"
                // timer: 3000
				});
				</script>');
		redirect($_SERVER['HTTP_REFERER']);
		// Menghapus flash data secara manual
		$this->session->unset_flashdata('message');
	}

	function data_mapel()
	{
		date_default_timezone_set("Asia/Jakarta");
		$query  = "SELECT * FROM student_lessons";
		$search = array('mapel_id', 'lessons', 'grade');
		// $where  = null;
		$where  = array(
			'mapel_id !' => 0
		);

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_query_mapel($query, $search, $where, $isWhere);
	}

	function data_mapel_guru($params = "")
	{
		date_default_timezone_set("Asia/Jakarta");
		$query  = "SELECT * FROM `teacher_lessons` 
		JOIN `user` ON teacher_lessons.`user_id` = user.`id`
		JOIN student_lessons ON student_lessons.`mapel_id` = teacher_lessons.`lessons_id`";
		$search = array('teacher_lessons_id', 'user_id', 'name', 'lessons', 'grade');
		// $where  = null;
		$where  = array(
			'lessons_id' => $params
		);

		// jika memakai IS NULL pada where sql
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}


	// =================================== Controler rekap_absen ===================================

	public function rekap($params = "")
	{
		$data['title'] = 'REKAP ABSENSI';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

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
			$data['kelas'] = 'X TKJ 2';
		}
		$data['class'] = $this->Operator_model->getAllClass()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('laporan/rekap_absen', $data);
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

	public function jam_absensi()
	{
		$data['title'] = 'JAM ABSENSI';
		$data['jam_absensi'] = $this->db->get('time_attendance')->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/time_attendance', $data);
		$this->load->view('templates/footer');
	}

	public function addTime()
	{
		$time_schedule = $this->input->post('time_schedule');
		$time_start = $this->input->post('time_start');
		$time_end = $this->input->post('time_end');

		$data = [
			'time_schedule' => $time_schedule,
			'time_start' => $time_start,
			'time_end' => $time_end
		];
		$this->Operator_model->addTime($data);
		$this->session->set_flashdata('message', '<script>
                     swal({
                title: "Jam Absen!",
                text: "Jam Berhasil Ditambahkan",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
		redirect('operator/jam_absensi');
	}

	public function editTime($id)
	{
		$data['title'] = 'Update Absensi';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['jam_absen_id'] = $this->Operator_model->getTimeId($id);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/edit-time', $data);
		$this->load->view('templates/footer');
	}


	public function updateTime()
	{
		$this->Operator_model->updateTime();
		$this->session->set_flashdata('message', '<script>
                     swal({
                title: "Jam Absen!",
                text: "Jam Berhasil Diperbaharui",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
		redirect('operator/jam_absensi');
	}

	public function deleteTime($id)
	{
		$this->Operator_model->deleteTime($id);

		$this->session->set_flashdata('message', '<script>
                     swal({
                title: "Jam Absen!",
                text: "Jam Berhasil Dihapus",
                icon: "success",
                button: "Ok"
                // timer: 3000
            });
                </script>');
		redirect('operator/jam_absensi');
	}



	public function export_guru()
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


		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A1', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B1', "Email"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C1', "Nama"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D1', "Phone"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E1', "Jabatan"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('F1', "Jenis Kelamin"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('G1', "Status Absensi"); // Set kolom E3 dengan tulisan "ALAMAT"

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A1')->applyFromArray($style_col);
		$sheet->getStyle('B1')->applyFromArray($style_col);
		$sheet->getStyle('C1')->applyFromArray($style_col);
		$sheet->getStyle('D1')->applyFromArray($style_col);
		$sheet->getStyle('E1')->applyFromArray($style_col);
		$sheet->getStyle('F1')->applyFromArray($style_col);
		$sheet->getStyle('G1')->applyFromArray($style_col);

		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$data = $this->Absensi_model->getDataGuru()->result_array();

		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($data as $data) { // Lakukan looping pada variabel siswa

			if ($data['gender'] == 'L') {
				$gender = 'Laki-Laki';
			} else {
				$gender = 'Perempuan';
			}
			if ($data['is_flexible'] == '1') {
				$status = 'Flexible';
			} else {
				$status = 'Full Time';
			}
			$sheet->setCellValue('A' . $numrow, $no);
			$sheet->setCellValue('B' . $numrow, $data['email']);
			$sheet->setCellValue('C' . $numrow, $data['name']);
			$sheet->setCellValue('D' . $numrow, $data['phone']);
			$sheet->setCellValue('E' . $numrow, $data['department']);
			$sheet->setCellValue('F' . $numrow, $gender);
			$sheet->setCellValue('G' . $numrow, $status);

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
		$sheet->setTitle("Data User");

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data User.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

	// =================================== Kenaikan Controler ===================================

	public function kenaikan()
	{
		$tingkatan = $this->input->post('grade');

		if ($tingkatan == 'XII') {
			$array = $this->db->query("SELECT DISTINCT class_name FROM `user` WHERE `class_name` LIKE 'XII %'")->result_array();
			foreach ($array as $key => $array) {
				$data = [
					'class_name' => "Alumni"
				];
				$this->db->where('class_name', $array['class_name']);
				$this->db->update('user', $data);
			}
		} elseif ($tingkatan == 'XI') {
			$array = $this->db->query("SELECT DISTINCT class_name FROM `user` WHERE `class_name` LIKE 'XI %'")->result_array();
			foreach ($array as $key => $array) {
				$data = [
					'class_name' => "XII" . substr($array['class_name'], 2)
				];
				$this->db->where('class_name', $array['class_name']);
				$this->db->update('user', $data);
			}
		} else {
			$array = $this->db->query("SELECT DISTINCT class_name FROM `user` WHERE `class_name` LIKE 'X %'")->result_array();
			foreach ($array as $key => $array) {
				$data = [
					'class_name' => "XI" . substr($array['class_name'], 1)
				];
				$this->db->where('class_name', $array['class_name']);
				$this->db->update('user', $data);
			}
		}
		$this->session->set_flashdata('message', '<script>
				swal({
					title: "Berhasil!",
					text: "Data Siswa Berhasil Di Perbaharui",
					icon: "success",
					button: "Ok"
                // timer: 3000
					});
					</script>');
		redirect('operator/siswa');
	}
	function jarak()
	{
		$data['title'] = 'Pengaturan Jarak Absensi';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['jarak_absen'] = $this->db->get('data_jarak')->result_array();
		$data['jarak_aktif'] = $this->db->get_where('data_jarak', ['status' => 1])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/jarak', $data);
		$this->load->view('templates/footer');
	}
	// =================================== Controler Laporan Absen Pusat ===================================
	public function laporan_absen_pusat($params = "", $params2 = "")
	{
		$data['title'] = 'Laporan Absensi Pusat';
		$data['laporan'] = $this->db->query("
	SELECT student_attendance.user_id, student_attendance.status, student_attendance.time, student_picture.image
	FROM student_attendance 
	INNER JOIN student_picture ON student_picture.student_attendance = student_attendance.attendance_id 
	WHERE student_attendance.date = '" . date('Y-m-d') . "'")->result_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/laporan_absensi_pusat', $data);
		$this->load->view('templates/footer');
	}

	// =================================== Cetak QR Code ===================================
	public function cetak($qr = "")
	{


		// (A) OPEN IMAGE
		$img = imagecreatefrompng(base_url('assets/qr/ruangan/' . $qr . '.png'));
		$ruangan = $this->db->query("SELECT * FROM student_room WHERE qr_token = '" . $qr . "'")->row_array();
		// (B) TEXT & FONT SETTINGS
		$txt = $ruangan['description'];

		// $fontFile = "C:\Windows\Fonts\arial.ttf"; 
		$fontFile = 'https://pegiumroh.com/arial.ttf';
		$fontSize = 24;
		$fontColor = imagecolorallocate($img, 0, 0, 0);
		$fontColor2 = imagecolorallocate($img, 255, 255, 255);
		$angle = 0;

		// (C) CALCULATE TEXT BOX POSITION
		// (C1) GET IMAGE DIMENSIONS
		$iWidth = imagesx($img);
		$iHeight = imagesy($img);

		// (C2) GET TEXT BOX DIMENSIONS
		$tSize = imagettfbbox($fontSize, $angle, $fontFile, $txt);
		$tWidth = max([$tSize[2], $tSize[4]]) - min([$tSize[0], $tSize[6]]);
		$tHeight = max([$tSize[5], $tSize[7]]) - min([$tSize[1], $tSize[3]]);

		// (C3) CENTER THE TEXT BLOCK
		$centerX = CEIL(($iWidth - $tWidth) / 2);
		$centerX = $centerX < 0 ? 0 : $centerX;
		$centerY = CEIL(($iHeight - $tHeight) / 2);
		$centerY = $centerY < 0 ? 0 : $centerY;

		// (D) DRAW TEXT ON IMAGE
		imagettftext($img, $fontSize, $angle, $centerX, $centerY + 1, $fontColor, $fontFile, $txt);
		imagettftext($img, $fontSize, $angle, $centerX, $centerY - 1, $fontColor, $fontFile, $txt);
		imagettftext($img, $fontSize, $angle, $centerX, $centerY + 2, $fontColor, $fontFile, $txt);
		imagettftext($img, $fontSize, $angle, $centerX, $centerY - 2, $fontColor, $fontFile, $txt);
		imagettftext($img, $fontSize, $angle, $centerX + 1, $centerY, $fontColor, $fontFile, $txt);
		imagettftext($img, $fontSize, $angle, $centerX - 1, $centerY, $fontColor, $fontFile, $txt);
		imagettftext($img, $fontSize, $angle, $centerX + 2, $centerY, $fontColor, $fontFile, $txt);
		imagettftext($img, $fontSize, $angle, $centerX - 2, $centerY, $fontColor, $fontFile, $txt);

		imagettftext($img, $fontSize, $angle, $centerX, $centerY, $fontColor2, $fontFile, $txt);

		// (E) OUTPUT IMAGE
		header("Content-type: image/jpeg");
		imagejpeg($img);
		imagedestroy($img);
	}


// =================================== Import Laporan ===================================
	public function import_laporan()
	{
		include APPPATH . 'third_party/excel_reader/php-excel-reader/excel_reader2.php';
		include APPPATH . 'third_party/excel_reader/SpreadsheetReader.php';

		$name = $_FILES['file']['name'];
		
		$target_dir = 'assets/uploads/';
		$target_file = $target_dir . $_FILES["file"]["name"];

		$data_input = array();

		// Select file type
		$FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		// Valid file extensions
		$extensions_arr = array("xlsx", "xls", "csv", "jpg");

		// Check extension
		if (in_array($FileType, $extensions_arr)) {

			// Upload
			if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
				// Insert record
				$Reader = new SpreadsheetReader($target_file);
				$cek = 0;
				foreach ($Reader as $key => $row) {

					$NIS = str_replace("-", "", $row[4]);
					$NIS = str_replace("+", "", $NIS);
					$NIS = str_replace(" ", "", $NIS);
					$NIS = str_replace(".", "", $NIS);
					$NIS = str_replace(",", "", $NIS);
					$NIS = str_replace("'", "", $NIS);
					$NIS = str_replace("(", "", $NIS);

					$user = $this->db->get_where('user', ['email' => $NIS])->row_array();

					$nama_siswa = str_replace("-", "", $row[3]);
					$nama_siswa = str_replace("+", "", $nama_siswa);
					$nama_siswa = str_replace(".", "", $nama_siswa);
					$nama_siswa = str_replace(",", "", $nama_siswa);
					$nama_siswa = str_replace("'", "", $nama_siswa);
					$nama_siswa = str_replace("(", "", $nama_siswa);
					$nama_siswa = str_replace(")", "", $nama_siswa);
					$nama_siswa = str_replace("?", " ", $nama_siswa);

					$kelas = strtoupper($row[5]);

					
					$tanggal =  $row[0]."-".$row[1]."-".$row[2];

					if ($cek > 2) {
						$data_input[] = array(
							'user_id' => $user['id'],
							'date' => $tanggal,
							'month' => date('Y-m', strtotime($tanggal)),
							'time' => $row[6],
							'status' => $row[7],
							'description' => $row[8],
							'class' => $kelas
						);

						$this->db->where('user_id', $user['id']);
						$this->db->where('date', $tanggal);
						$this->db->delete('student_attendance');
						// $data = [
						// 	'name' => $nama_siswa,
						// 	'email' => $NIS,
						// 	'image' => "default.jpg",
						// 	'password' => password_hash($NIS, PASSWORD_DEFAULT),
						// 	'role_id' => "6",
						// 	'is_active' => "1",
						// 	'date_created' => date('Y-m-d'),
						// 	'department' => "Siswa",
						// 	'class_name' => strtoupper($row[2]),
						// 	'phone' => $row[3],
						// 	'gender' => $row[4],
						// 	'address' => $row[5],
						// 	'is_flexible' => 0
						// ];
						// $this->db->insert('user', $data);

					}
					$cek++;
				}

				$this->db->insert_batch('student_attendance', $data_input);
				$this->session->set_flashdata('message', '<script>
						swal({
							title: "Berhasil!",
							text: "Data Laporan Berhasil di Tambahkan",
							icon: "success",
							button: "Ok"
		                // timer: 3000
							});
							</script>');
				redirect('operator/rekap');
			}
		} else {
			$this->session->set_flashdata('message', '<script>
					swal({
						title: "Gagal!",
						text: "File yang di upload harus berformal xlsx, xls dan csv dengan ukuran maximal 10mb",
						icon: "success",
						button: "Ok"
		                // timer: 3000
						});
						</script>');
			redirect('operator/rekap');
		}
	}



	public function group()
	{
		$data['title'] = 'DATA GROUP WHATSAPP';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['role'] = $this->db->get('user_role')->result_array();
		// $data['list_user'] = $this->Admin_model->getAll();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/group', $data);
		$this->load->view('templates/footer');
	}


    
	// =================================== Controler rekap_absen ===================================

	public function angkatan($params = "", $params2="")
	{
	  if($params=="group"){
        $data = [
            'kode_group_grade' => $this->input->post('kode_group'),
			'	chat_id_angkatan' => $this->input->post('chat_id') 
        ];
        $this->db->where('grade', $this->input->post('grade'));
        $this->db->update('student_class', $data);
	    $this->session->set_flashdata('message', '<script>
			swal({
				title: "Berhasil!",
				text: "Data Laporan Berhasil di Tambahkan",
				icon: "success",
				button: "Ok"
		       // timer: 3000
				});
		</script>');
		redirect('operator/angkatan');
	  }elseif($params=="kirim"){
	   //   echo $params2;
	   $isi_pesan = "======== Pesan Otomatis ========
*Data Siswa Alpha*
*Kelas* : ".$params2."
*Tanggal* : ".tgl_indo(date('Y-m-d'))."

";
$no = 1;
$kode_group ="";
	      $angkatan = $this->db->get_where('student_class', ['grade' => $params2])->result_array();
	      foreach($angkatan as $key => $angkatan){
	          $cek = $this->db->get_where('student_attendance', ['date' => date('Y-m-d'), 'class' => $angkatan['class'], 'status' => '0'])->num_rows();
	          if($cek != 0){
	              $isi_pesan .= "*".$no.". ".$angkatan['class']."*
";
	              $data_attendance = $this->db->get_where('student_attendance', ['date' => date('Y-m-d'), 'class' => $angkatan['class'], 'status' => '0'])->result_array();
	              foreach($data_attendance as $key => $data_attendance){
	                  $siswa = $this->db->get_where('user', ['id' => $data_attendance['user_id']])->row_array();
	                  $isi_pesan .= "  - ".$siswa['name']."
";
	              }
	              $isi_pesan .= "
";
	          }
	         $no++;
	         $kode_group = $angkatan['kode_group_grade'];
	      }
	      echo $kode_group;
	      
	      
		  $settings = $this->db->get('settings')->row_array();
		  $phone = $settings['phone'];
		  $curl = curl_init();
		  curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-whatsapp.smkkarnas.id/sendtext?number='.$phone.'&to='.$kode_group.'&message='.urlencode($isi_pesan),
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
		//   echo $response;
			redirect('operator/angkatan');
            
	  }else{
		$data['title'] = 'GROUP ANGKATAN';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['kelas'] = $this->Operator_model->getAllClass()->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/angkatan', $data);
		$this->load->view('templates/footer');
	  }
	}


	// =================================== Controler Absen Siswa ===================================
	public function absen_siswa($params = "")
	{
		$data['title'] = 'DATA ABSENSI';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		if ($params == "filter_harian") {
			$data['tanggal_sekarang'] = $this->input->post('filter');
			$data['bulan_sekarang'] = date('Y-m');
			$data['sortir'] = 'Filter Harian';
			$data['kelas'] = $this->input->post('class');
		}  else {
			$data['tanggal_sekarang'] = date('Y-m-d');
			$data['bulan_sekarang'] = date('Y-m');
			$data['sortir'] = 'Filter Harian';
			$data['kelas'] = 'X TKJ 2';
		}
		$data['class'] = $this->Operator_model->getAllClass()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('operator/absen', $data);
		$this->load->view('templates/footer');
	}

	
    
    public function update_absensi(){
        $isi_post = $this->input->post();
        // echo $isi_post['pilih0'];
        $cek=0;
        $array = $this->db->query("SELECT * FROM student_attendance where date = '".$isi_post['tanggal']."'")->result_array();
        foreach ($array as $key => $array) {
            if ($isi_post['aksi'] == 'desktop') {
                $menu = 'pilih'.$cek;   
            }else{
                $menu = 'm'.$cek;
            }
            
                $data = [
                    'status' => $isi_post[$menu]
                ];
                $this->db->where('user_id', $array['student_id']);
                $this->db->where('date', $array['tanggal']);
                $this->db->update('student_attendance', $data);
            
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
	// =================================== END Controler ===================================
}
