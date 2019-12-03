<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('model');
    }

    /*--------------------------------------------------
    | [CRE] Credential
    | -------------------------------------------------- */

    public function login() {
        if($this->isLogin())
            redirect(base_url('admin/user'));
        else
            $this->load->view('admin/login');
    }

    public function prosesLogin() {
        $username = preg_replace('/[^A-Za-z0-9]/', '', $this->input->post('username'));
        $password = $this->input->post('password');

        $where = array('username_admin' => $username);
        $informasi_admin = $this->model->getDataWhere('admin', $where);

        if($informasi_admin == '') {
            echo json_encode('username tidak ada');
            die();
        }
        elseif(!password_verify($password, $informasi_admin['password_admin'])) {
            echo json_encode('password salah');
            die();
        }
        else {
            $this->session->set_userdata('bullbear_username_admin', $informasi_admin['username_admin']);
            echo json_encode('berhasil');
        }
    }

    private function isLogin() {
        if($this->session->bullbear_username_admin != '')
            return true;
        else 
            return false;
    }


    /*--------------------------------------------------
    | [USER] User
    | -------------------------------------------------- */

    public function user() {
        if(!$this->isLogin()) {
            redirect(base_url('admin/login'));
        }
        else {
            $this->load->view('admin/user/list');
        }
    }

    public function userMenu($param = null) {
        if(!$this->isLogin()) {
            redirect(base_url('admin/login'));
        }
        if($param == null) {
            redirect(base_url('admin/user'));
        }
        elseif($param === 'list') {
            $this->userList();
        }
        elseif($param === 'reset') {
            $this->userResetPass();
        }
    }

    private function userList() {
        $datatables = new Datatables(new CodeigniterAdapter);
        $query = 'SELECT `username_anggota`, `nama_anggota`, `email_anggota` FROM `anggota`';
        $datatables->query($query);
        echo $datatables->generate();
    }
    
    private function userResetPass() {
        $username = preg_replace('/[^A-Za-z0-9]/', '', $this->input->post('username'));
        $password = password_hash('12345678', PASSWORD_DEFAULT);
        $return = array();
        
        $where = array('username_anggota' => $username);
        $informasi_anggota = $this->model->getDataWhere('anggota', $where);

        if($informasi_anggota == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data anggota tidak ditemukan.';
            echo json_encode($return);
            die();
        }
        else {
            $data = array('password_anggota' => $password);
            $this->model->updateData('anggota', $where, $data);
            $return['type'] = 'success';
            $return['message'] = 'Berhasil mereset password anggota.';
            echo json_encode($return);
        }
    }


    /*--------------------------------------------------
    | [VID] Video
    | -------------------------------------------------- */

    public function video() {
        if($this->isLogin() == false) {
            redirect(base_url('admin/login'));
        }
        else {
            $this->load->view('admin/video/list');
        }
    }

    public function videoMenu($param1 = null, $param2 = null) {
        if(!$this->isLogin()) {
            redirect(base_url('admin/login'));
        }
        if($param1 == null) {
            redirect(base_url('admin/video'));
        }
        elseif($param1 === 'list') {
            $this->videoList();
        }
        elseif($param1 === 'tambah' && $param2 == null) {
            $this->load->view('admin/video/form');
        }
        elseif($param1 === 'tambah' && $param2 === 'proses') {
            $this->tambahVideo();
        }
        elseif($param1 === 'detail' && $param2 != null) {
            $this->lihatVideo($param2);
        }
        elseif($param1 === 'isi' && $param2 === 'tambah') {
            $this->tambahIsiVideo();
        }
        elseif($param1 === 'isi' && $param2 === 'hapus') {
            $this->hapusIsiVideo();
        }
        elseif($param1 === 'isi' && $param2 != null) {
            $this->isiVideo($param2);
        }
        elseif($param1 === 'hapus') {
            $this->hapusVideo();
        }
        else {
            redirect(base_url('admin/login'));
        }
    }

    private function videoList() {
        $datatables = new Datatables(new CodeigniterAdapter);
        $query = 'SELECT `id_video_paket`, `nama_paket`, `harga_paket`, `tanggal_dibuat` FROM `video_paket`';
        $datatables->query($query);
        echo $datatables->generate();
    }

    private function tambahVideo() {
        $nama = trim($this->input->post('nama'));
        $nama = htmlspecialchars(strip_tags($nama), ENT_QUOTES);
        $deskripsi = trim($this->input->post('deskripsi'));
        $deskripsi = htmlspecialchars(strip_tags($deskripsi), ENT_QUOTES);
        $harga = (int) preg_replace('/[^0-9]/', '', trim($this->input->post('harga')));

        if($nama == '' || $deskripsi == '' || $harga == '' || $harga == 0) {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak lengkap.';
            json_encode($return);
            die();
        }

        $this->lang->load('upload', 'indonesia');
        $this->config->set_item('language', 'indonesia');

		$config['upload_path']		= './course/video/thumbnail';
		$config['allowed_types']	= 'jpg|png|jpeg';
		$config['file_ext_tolower']	= true;
		$config['overwrite']		= true;
		$config['remove_spaces']	= true;
        $this->load->library('upload', $config);

        $thumbnail = '';
        if( !$this->upload->do_upload('thumbnail') ) {
            $return['type'] = 'error';
            $return['message'] = $this->upload->display_errors();
            echo json_encode($return);
            die();
        }
        else {
            $upload_data = $this->upload->data();
            $thumbnail = $upload_data['file_name'];
        }

        $data = array(
            'nama_paket'        => $nama,
            'deskripsi_paket'   => $deskripsi,
            'harga_paket'       => $harga,
            'thumbnail_paket'   => $thumbnail,
            'tanggal_dibuat'    => date('Y-m-d H:i:s'),
        );
        $this->model->insertData('video_paket', $data);

        $return['type'] = 'success';
        $return['message'] = $this->db->insert_id();
        echo json_encode($return);
    }

    private function lihatVideo($id) {
        $where = array('id_video_paket' => (int) $id);
        $data['video'] = $this->model->getDataWhere('video_paket', $where);

        if($data['video'] == '') {
            redirect('admin/login');
        }
        else {
            $this->load->view('admin/video/detail', $data);
        }
    }

    private function isiVideo($id) {
        $where = array('id_video_paket' => (int) $id);
        $isi = $this->model->getAllDataWhere('video_isi', $where);
        echo json_encode($isi);
    }

    private function tambahIsiVideo() {
        $id = (int) $this->input->post('id');
        $judul = trim($this->input->post('judul'));
        $judul = htmlspecialchars(strip_tags($judul), ENT_QUOTES);

        if($id == '' || $id == 0 || $judul == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak lengkap.';
            json_encode($return);
            die();
        }
        elseif($this->model->getDataWhere('video_paket', array('id_video_paket' => $id)) == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data paket video tidak ditemukan.';
            json_encode($return);
            die();
        }

        if( !file_exists('./course/video/content/'.$id) ) {
            mkdir('./course/video/content/'.$id, 0777);
        }

        $this->lang->load('upload', 'indonesia');
        $this->config->set_item('language', 'indonesia');

		$config['upload_path']		= './course/video/content/'.$id;
		$config['allowed_types']	= 'mp4|mkv|flv';
		$config['file_ext_tolower']	= true;
		$config['overwrite']		= true;
		$config['remove_spaces']	= true;
        $this->load->library('upload', $config);

        $video = '';
        if( !$this->upload->do_upload('video') ) {
            $return['type'] = 'error';
            $return['message'] = $this->upload->display_errors();
            echo json_encode($return);
            die();
        }
        else {
            $upload_data = $this->upload->data();
            $video = $upload_data['file_name'];
        }

        $data = array(
            'id_video_paket'=> $id,
            'nama_video'    => $judul,
            'file_video'    => $video,
        );
        $this->model->insertData('video_isi', $data);

        $return['type'] = 'success';
        $return['message'] = 'Berhasil menyimpan data.';
        echo json_encode($return);
    }

    private function hapusIsiVideo() {
        $id = (int) $this->input->post('id');
        $where = array('id_video' => $id);
        $informasi_video = $this->model->getDataWhere('video_isi', $where);

        if($informasi_video == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak ditemukan.';
            echo json_encode($return);
            die();
        }

        $path = './course/video/content/' . $informasi_video['id_video_paket'] . '/' . $informasi_video['file_video'];
        if( file_exists($path) ) {
            unlink($path);

            $this->model->deleteData('video_isi', $where);

            $return['type'] = 'success';
            $return['message'] = 'Berhasil menghapus data.';
            echo json_encode($return);
        }
        else {
            $return['type'] = 'error';
            $return['message'] = 'Gagal menghapus data.';
            echo json_encode($return);
        }
        
    }

    public function hapusVideo() {
        $id = (int) $this->input->post('id');
        $where = array('id_video_paket' => $id);
        $informasi_video = $this->model->getDataWhere('video_paket', $where);
        $isi_video = $this->model->getAllDataWhere('video_isi', $where);

        if($informasi_video == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak ditemukan.';
            echo json_encode($return);
            die();
        }

        try {
            $path = './course/video/content/' . $informasi_video['id_video_paket'] . '/';
            $files = glob($path . '*', GLOB_MARK);
            foreach ($files as $file) {
                unlink($file);
            }
            rmdir($path);
            $this->model->deleteData('video_isi', $where);

            $path = './course/video/thumbnail/' . $informasi_video['thumbnail_paket'];
            if( file_exists($path) ) {
                unlink($path);
                $this->model->deleteData('video_paket', $where);
                
                $return['type'] = 'success';
                $return['message'] = 'Berhasil menghapus data.';
                echo json_encode($return);
            }
            else {
                throw new Exception('error');
            }

        } catch (Exception $e) {
            $return['type'] = 'error';
            $return['message'] = 'Gagal menghapus data.';
            echo json_encode($return);
        }
    }


    /*--------------------------------------------------
    | [EBO] Ebook
    | -------------------------------------------------- */


}