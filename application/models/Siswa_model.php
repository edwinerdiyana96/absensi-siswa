<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa_model extends CI_Model
{

	public function getAllClass()
	{
		return $this->db->get('student_class');
	}
	public function getAllClassById($id)
	{
		$this->db->where('class_id', $id);
		return $this->db->get('student_class');
	}

	public function getAllClassByName($name)
	{
		$this->db->where('class', $name);
		return $this->db->get('student_class');
	}


	public function getUserById($params = "")
	{
		$this->db->where('id', $params);
		return $this->db->get('user');
	}

	public function getSiswaByClass($params = "")
	{
		$this->db->where('class', $params);
		$this->db->where('department', 'class');
		return $this->db->get('user');
	}

	public function getClassLeader($user_id)
	{
		$this->db->where('class_leader', $user_id);
		return $this->db->get('student_class');
	}

	public function getViceLeader($user_id)
	{
		$this->db->where('vice_leader', $user_id);
		return $this->db->get('student_class');
	}

	public function getMapelBySiswa($user_id=""){
		$this->db->select("lessons_id");
		$this->db->where('student_id', $user_id);
		$this->db->distinct();
		return $this->db->get('student_room_absent');
	}
}
