<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('model');
    }

    public function login() {
        if($this->isLogin())
            redirect(base_url('admin/dashboard'));
        else
            $this->load->view('admin/login');
    }

    public function prosesLogin() {
        $username = preg_replace('/[^A-Za-z0-9]/', '', $this->input->post('username'));
        $password = $this->input->post('password');

        $where = array('username_admin' => $username);
        $informasi_admin = $this->model->getDataWhere('admin', $where);
    }

    private function isLogin() {
        if($this->session->username_admin != '')
            return true;
        else 
            return false;
    }
    
}