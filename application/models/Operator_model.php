<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operator_model extends CI_Model
{

    public function getAllClass()
    {
        return $this->db
            ->select('*')
            ->from('student_class')
            ->order_by('class', 'ASC') // Mengurutkan berdasarkan kolom 'nama_kelas' secara ascending
            ->get();
    }
	public function getAllClassById($id)
	{
		$this->db->where('class_id', $id);
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

	public function updateKelas()
	{
		date_default_timezone_set("Asia/Jakarta");

		$class_id = $this->input->post('class_id');

		$data = [
			'class' => $this->input->post('class'),
			'homeroom_teacher' => $this->input->post('wk'),
			'class_leader' => $this->input->post('km'),
			'vice_leader' => $this->input->post('wakil'),
			'grade' => $this->input->post('grade'),
			'kode_group' => $this->input->post('kode_group'),
			'chat_id' => $this->input->post('chat_id')
		];
		$this->db->where('class_id', $class_id);
		$this->db->update('student_class', $data);
	}

	public function deleteKelas($id)
	{
		$this->db->where('class_id', $id);
		$this->db->delete('student_class');
	}

	// =================================== Model Time Attendance =======================================
	public function addTime($data)
	{
		$this->db->insert('time_attendance', $data);
	}

	public function getTimeId($id)
	{
		return $this->db->get_where('time_attendance', ['id' => $id])->row_array();
	}

	public function updateTime()
	{
		$id = $this->input->post('id');
		$data = [
			'time_schedule' => $this->input->post('time_schedule'),
			'time_start' => $this->input->post('time_start'),
			'time_end' => $this->input->post('time_end')
		];
		$this->db->where('id', $id);
		$this->db->update('time_attendance', $data);
	}

	public function deleteTime($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('time_attendance');
	}
}
