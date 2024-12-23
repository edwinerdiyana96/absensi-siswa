<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function getUserByUsername ($params = ""){
		$this->db->where('username', $params);
		return $this->db->get('user');
	}

	public function getTeacherLessonsByMapel ($params = "", $params2=""){
		$this->db->where('user_id', $params);
		$this->db->where('lessons_id', $params2);
		return $this->db->get('teacher_lessons');
	}

}