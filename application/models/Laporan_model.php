<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    public function total_siswa()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('role_id', 6);
        return $this->db->count_all_results();
    }

    public function total_guru()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('role_id', 3);
        return $this->db->count_all_results();
    }

    public function total_ruangan()
    {
        $this->db->select('*');
        $this->db->from('student_room');
        return $this->db->count_all_results();
    }

    public function total_siswa_hadir()
    {

        date_default_timezone_set("Asia/Jakarta");
        $date_now = new DateTime("now");
        $curr_date = $date_now->format('Y-m-d');

        $where = "status=1 OR status=2";
        $this->db->select('*');
        $this->db->from('student_attendance');
        
        $this->db->where($where);
        $this->db->where('date',$curr_date);
        return $this->db->count_all_results();
    }

    public function total_siswa_tidak_hadir()
    {

        date_default_timezone_set("Asia/Jakarta");
        $date_now = new DateTime("now");
        $curr_date = $date_now->format('Y-m-d');

        $where = "status=3 OR status=4 Or status=0";
        $this->db->select('*');
        $this->db->from('student_attendance');
        
        $this->db->where($where);
        $this->db->where('date',$curr_date);
        return $this->db->count_all_results();
    }


    

    public function total_siswa_hadir_tepat_waktu()
    {

        date_default_timezone_set("Asia/Jakarta");
        $date_now = new DateTime("now");
        $curr_date = $date_now->format('Y-m-d');

        $where = "status=1";
        $this->db->select('*');
        $this->db->from('student_attendance');
        
        $this->db->where($where);
        $this->db->where('date',$curr_date);
        return $this->db->count_all_results();
    }

    public function total_siswa_hadir_telat()
    {

        date_default_timezone_set("Asia/Jakarta");
        $date_now = new DateTime("now");
        $curr_date = $date_now->format('Y-m-d');

        $where = "status=2";
        $this->db->select('*');
        $this->db->from('student_attendance');
        
        $this->db->where($where);
        $this->db->where('date',$curr_date);
        return $this->db->count_all_results();
    }

    public function total_siswa_sakit()
    {

        date_default_timezone_set("Asia/Jakarta");
        $date_now = new DateTime("now");
        $curr_date = $date_now->format('Y-m-d');

        $where = "status=3";
        $this->db->select('*');
        $this->db->from('student_attendance');
        
        $this->db->where($where);
        $this->db->where('date',$curr_date);
        return $this->db->count_all_results();
    }
    
    public function total_siswa_izin()
    {

        date_default_timezone_set("Asia/Jakarta");
        $date_now = new DateTime("now");
        $curr_date = $date_now->format('Y-m-d');

        $where = "status=4";
        $this->db->select('*');
        $this->db->from('student_attendance');
        
        $this->db->where($where);
        $this->db->where('date',$curr_date);
        return $this->db->count_all_results();
    }

    public function total_siswa_alpha()
    {

        date_default_timezone_set("Asia/Jakarta");
        $date_now = new DateTime("now");
        $curr_date = $date_now->format('Y-m-d');

        $where = "status=0";
        $this->db->select('*');
        $this->db->from('student_attendance');
        
        $this->db->where($where);
        $this->db->where('date',$curr_date);
        return $this->db->count_all_results();
    }
}
