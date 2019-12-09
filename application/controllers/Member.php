<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Member extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('model');
    }


    /*--------------------------------------------------
    | [CRE] Credential
    | -------------------------------------------------- */

    public function login() {
        if($this->isLogin())
            redirect(base_url('member/home'));
        else
            $this->load->view('member/login');
    }

    public function prosesLogin() {
        $username = preg_replace('/[^A-Za-z0-9]/', '', $this->input->post('username'));
        $password = $this->input->post('password');

        $where = array('username_member' => $username);
        $informasi_member = $this->model->getDataWhere('member', $where);

        if($informasi_member == '') {
            echo json_encode('username tidak ada');
            die();
        }
        elseif(!password_verify($password, $informasi_member['password_member'])) {
            echo json_encode('password salah');
            die();
        }
        else {
            $this->session->set_userdata('bullbear_username_member', $informasi_member['username_member']);
            echo json_encode('berhasil');
        }
    }

    private function isLogin() {
        if($this->session->bullbear_username_member != '')
            return true;
        else 
            return false;
    }
    

    /*--------------------------------------------------
    | [HOM] Home
    | -------------------------------------------------- */

    public function home() {
        if(!$this->isLogin()) {
            redirect(base_url('member/login'));
        }
        else {
            $this->load->view('member/home');
        }
    }
}