<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatables extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	// -------------------------------- Controller Karyawan -------------------------------- //

	function karyawan()
	{
		$query  = "SELECT * FROM student_room JOIN user ON student_room.pic = user.id";
		$search = array('no', 'description', 'pic', 'room_id');
		$where  = null;
		// $where  = array('role_id' => '6');
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}



	// -------------------------------- Controller Mapel -------------------------------- //

	function siswa_by_kelas()
	{
		$query  = "SELECT * FROM user";
		$search = array('id', 'name', 'class_name');
		$where  = null;
		// $where  = array('class_name' => 'X TKJ 2');
		$isWhere = null;
		// $isWhere = 'artikel.deleted_at IS NULL';
		header('Content-Type: application/json');
		echo $this->M_Datatables->get_tables_query($query, $search, $where, $isWhere);
	}

	// -------------------------------- END CONTROLLER -------------------------------- //

}
