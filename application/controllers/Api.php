<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        echo "COBA";
    }
    public function status()
    {
        $phone_no = '083199766610';
        $key='iay747isynk0bxhkq4uilwpscyha9yh'; //this is demo key please change with your own key
        $url='https://api.easywa.id/v1/status';
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'email: it.smkkarnas.40@gmail.com',
            'secret-key: iay747isynk0bxhkq4uilwpscyha9yh',
            'Content-Type: application/json'
          )
        );
        echo $res=curl_exec($ch);
        curl_close($ch);
    }

    public function cek_nomor()
    {
        $phone_no = '6283199766610';
        $key='iay747isynk0bxhkq4uilwpscyha9yh'; //this is demo key please change with your own key
        $url='https://api.easywa.id/v1/check-number';
        $data = array(
          "number" => $phone_no
        );
        $data_string = json_encode($data);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'email: it.smkkarnas.40@gmail.com',
            'secret-key: iay747isynk0bxhkq4uilwpscyha9yh',
            'Content-Type: application/json'
          )
        );
        echo $res=curl_exec($ch);
        curl_close($ch);
    }







    
    public function cek_group()
    {
        $phone_no = '6283199766610';
        $key='iay747isynk0bxhkq4uilwpscyha9yh'; //this is demo key please change with your own key
        $url='https://api.easywa.id/v1/groups';
        $data = array(
          "number" => $phone_no
        );
        $data_string = json_encode($data);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'email: it.smkkarnas.40@gmail.com',
            'secret-key: iay747isynk0bxhkq4uilwpscyha9yh',
            'Content-Type: application/json'
          )
        );
        echo $res=curl_exec($ch);
        curl_close($ch);
    }







    public function kirim_pesan()
    {

        
        $phone_no = '6283199766610';
        $key='iay747isynk0bxhkq4uilwpscyha9yh'; //this is demo key please change with your own key
        $url='https://api.easywa.id/v1/send-message';
        $data = array(
        //   "group_id" => "120363041823309375",
          "number" => "083199766610",
          "message" => "TESTING"
        );
        $data_string = json_encode($data);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'email: it.smkkarnas.40@gmail.com',
            'secret-key: iay747isynk0bxhkq4uilwpscyha9yh',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
          )
        );
        echo $res=curl_exec($ch);
        curl_close($ch);
    }
}
