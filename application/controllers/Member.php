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


    /*--------------------------------------------------
    | [VID] Video
    | -------------------------------------------------- */

    public function videoMenu($param1 = null, $param2 = null) {
        if(!$this->isLogin()) {
            redirect(base_url('member/login'));
        }
        elseif($param1 === 'list' && $param2 == null) {
            $this->videoList();
        }
        elseif($param1 === 'library' && $param2 == null) {
            $this->videoLibrary();
        }
        elseif($param1 === 'content' && $param2 != null) {
            $this->videoContent($param2);
        }
    }

    private function videoList() {
        $sort = preg_replace('/[^a-z]/', '', $this->input->post('sort'));
        $limit = preg_replace('/[^a-z0-9]/', '', $this->input->post('limit'));
        $search = preg_replace('/[^a-zA-Z0-9 ]/', '', $this->input->post('search'));
        $is_owner = preg_replace('/[^a-z]/', '', $this->input->post('is_owner'));

        $data = $this->model->getContent('video', $search, $sort, $limit, $is_owner);
        
        if($data != '') {
            for($i=0; $i<count($data); $i++) {
                $data[$i]['thumbnail_paket'] = base_url('course/video/thumbnail/') . $data[$i]['thumbnail_paket'];
            }
        }

        echo json_encode($data);
    }

    private function videoLibrary() {
        $this->load->view('member/video/library');
    }

    private function videoContent($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        $where = array('id_video_paket' => $id);
        $data['video'] = $this->model->getDataWhere('video_paket', $where);
        $data['content'] = $this->model->getAllDataWhere('video_isi', $where);
        $where = array('jenis_library' => 'video', 'id_paket' => $id);
        $data['is_owner'] = ($this->model->getDataWhere('member_library') == '') ? false : true;

        if($data['video'] == '') {
            redirect(base_url('member/login'));
        }
        else {
            $this->load->view('member/video/content', $data);
        }
    }

    
    /*--------------------------------------------------
    | [EBO] Ebook
    | -------------------------------------------------- */

    public function ebookMenu($param1 = null, $param2 = null) {
        if(!$this->isLogin()) {
            redirect(base_url('member/login'));
        }
        elseif($param1 === 'list' && $param2 == null) {
            $this->ebookList();
        }
        elseif($param1 === 'library' && $param2 == null) {
            $this->ebookLibrary();
        }
    }

    private function ebookList() {
        $sort = preg_replace('/[^a-z]/', '', $this->input->post('sort'));
        $limit = preg_replace('/[^a-z0-9]/', '', $this->input->post('limit'));
        $search = preg_replace('/[^a-zA-Z0-9 ]/', '', $this->input->post('search'));
        $is_owner = preg_replace('/[^a-z]/', '', $this->input->post('is_owner'));

        $data = $this->model->getContent('ebook', $search, $sort, $limit, $is_owner);
        
        if($data != '') {
            for($i=0; $i<count($data); $i++) {
                $data[$i]['thumbnail_paket'] = base_url('course/ebook/thumbnail/') . $data[$i]['thumbnail_paket'];
            }
        }

        echo json_encode($data);
    }

    private function ebookLibrary() {
        $this->load->view('member/ebook/library');
    }

}