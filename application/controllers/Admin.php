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

    public function logout() {
        session_destroy();
        redirect(base_url('admin/login'));
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
        elseif($param === 'search') {
            $this->searchUser();
        }
    }

    private function userList() {
        $datatables = new Datatables(new CodeigniterAdapter);
        $query = 'SELECT `username_member`, `nama_member`, `email_member` FROM `member`';
        $datatables->query($query);
        echo $datatables->generate();
    }
    
    private function userResetPass() {
        $username = preg_replace('/[^A-Za-z0-9]/', '', $this->input->post('username'));
        $password = password_hash('12345678', PASSWORD_DEFAULT);
        $return = array();
        
        $where = array('username_member' => $username);
        $informasi_member = $this->model->getDataWhere('member', $where);

        if($informasi_member == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data member tidak ditemukan.';
            echo json_encode($return);
            die();
        }
        else {
            $data = array('password_member' => $password);
            $this->model->updateData('member', $where, $data);
            $return['type'] = 'success';
            $return['message'] = 'Berhasil mereset password member.';
            echo json_encode($return);
        }
    }

    private function searchUser() {
        $search = preg_replace('/[^a-zA-Z0-9]/', '', $this->input->post('search'));
        $data['results'] = $this->model->searchMember($search);
        if($data['results'] == '') $data['results'] = array();
        echo json_encode($data);   
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
        elseif($param1 === 'edit' && $param2 == null) {
            $this->editVideo();
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

    private function getDataVideo($param) {
        $nama = trim($this->input->post('nama'));
        $nama = htmlspecialchars(strip_tags($nama), ENT_QUOTES);
        $deskripsi = trim($this->input->post('deskripsi'));
        $deskripsi = htmlspecialchars(strip_tags($deskripsi), ENT_QUOTES);
        $singkat = trim($this->input->post('singkat'));
        $singkat = htmlspecialchars(strip_tags($singkat), ENT_QUOTES);
        $harga = preg_replace('/[^0-9]/', '', trim($this->input->post('harga')));
        $link = filter_var(trim($this->input->post('link')), FILTER_SANITIZE_URL);

        if($nama == '' || $deskripsi == '' || $singkat == '' || $harga == '' || $harga == 0) {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak lengkap.';
            return $return;
        }

        $this->lang->load('upload', 'indonesia');
        $this->config->set_item('language', 'indonesia');

		$config['upload_path']		= './course/video/thumbnail';
		$config['allowed_types']	= 'jpg|png|jpeg';
		$config['file_ext_tolower']	= true;
		$config['overwrite']		= false;
		$config['remove_spaces']	= true;
        $this->load->library('upload', $config);

        $thumbnail = '';
        if( $param === 'tambah' || ($param === 'edit' && isset($_FILES['thumbnail'])) ) {
            if( !$this->upload->do_upload('thumbnail') ) {
                $return['type'] = 'error';
                $return['message'] = $this->upload->display_errors();
                return $return;
            }
            else {
                $upload_data = $this->upload->data();
                $thumbnail = $upload_data['file_name'];
            }
        }

        $return['type'] = 'success';
        $return['data'] = array(
            'nama_paket'        => $nama,
            'deskripsi_paket'   => $deskripsi,
            'deskripsi_singkat' => $singkat,
            'harga_paket'       => $harga,
            'thumbnail_paket'   => $thumbnail,
            'tanggal_dibuat'    => date('Y-m-d H:i:s'),
            'link_video'        => $link,
        );
        return $return;
    }

    private function videoList() {
        // Jika request dari DataTable
        if($this->input->post('draw')) {
            $datatables = new Datatables(new CodeigniterAdapter);
            $query = 'SELECT `id_video_paket`, `nama_paket`, `harga_paket`, `tanggal_dibuat` FROM `video_paket`';
            $datatables->query($query);
            echo $datatables->generate();
        }
        else {
            $data = $this->model->getAllData('video_paket');
            echo json_encode($data);
        }
    }

    private function tambahVideo() {
        $data = $this->getDataVideo('tambah');

        if($data['type'] === 'error') {
            echo json_encode($data);
            die();
        }
        elseif($data['type'] === 'success') {
            $this->model->insertData('video_paket', $data['data']);

            $return['type'] = 'success';
            $return['message'] = $this->db->insert_id();
            echo json_encode($return);
        }
    }

    private function editVideo() {
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));
        $where = array('id_video_paket' => $id);
        $informasi_video = $this->model->getDataWhere('video_paket', $where);

        if($informasi_video == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data paket video tidak ditemukan.';
            echo json_encode($return);
            die();
        }

        $data = $this->getDataVideo('edit');

        if($data['type'] === 'error') {
            echo json_encode($data);
            die();
        }
        else {
            // Hapus thumbnail lama jika ada thumbnail baru
            if($data['data']['thumbnail_paket'] != '') {
                $path = './course/video/thumbnail/' . $informasi_video['thumbnail_paket'];
                if( file_exists($path) ) {
                    unlink($path);
                }
            }
            else {
                unset($data['data']['thumbnail_paket']);
            }

            $this->model->updateData('video_paket', $where, $data['data']);

            $return['type'] = 'success';
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('message', 'Berhasil mengedit data.');
            echo json_encode($return);
        }
    }

    private function lihatVideo($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        $where = array('id_video_paket' => $id);
        $data['video'] = $this->model->getDataWhere('video_paket', $where);

        if($data['video'] == '') {
            redirect(base_url('admin/login'));
        }
        else {
            $this->load->view('admin/video/detail', $data);
        }
    }

    private function isiVideo($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        $where = array('id_video_paket' => $id);
        $isi = $this->model->getAllDataWhere('video_isi', $where);
        echo json_encode($isi);
    }

    private function tambahIsiVideo() {
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));
        $judul = trim($this->input->post('judul'));
        $judul = htmlspecialchars(strip_tags($judul), ENT_QUOTES);
        $durasi = trim($this->input->post('durasi'));

        if($id == '' || $judul == '' || $durasi == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak lengkap.';
            echo json_encode($return);
            die();
        }
        elseif($this->model->getDataWhere('video_paket', array('id_video_paket' => $id)) == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data paket video tidak ditemukan.';
            echo json_encode($return);
            die();
        }

        if( !file_exists('./course/video/content/'.$id) ) {
            mkdir('./course/video/content/'.$id, 0777);
        }

        $this->lang->load('upload', 'indonesia');
        $this->config->set_item('language', 'indonesia');

		$config['upload_path']		= './course/video/content/'.$id;
		$config['allowed_types']	= 'mp4';
		$config['file_ext_tolower']	= true;
		$config['overwrite']		= false;
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
            'durasi_video'  => $durasi,
        );
        $this->model->insertData('video_isi', $data);

        $return['type'] = 'success';
        $return['message'] = 'Berhasil menyimpan data.';
        echo json_encode($return);
    }

    private function hapusIsiVideo() {
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));
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
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));
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

    public function ebook() {
        if($this->isLogin() == false) {
            redirect(base_url('admin/login'));
        }
        else {
            $this->load->view('admin/ebook/list');
        }
    }

    public function ebookMenu($param1 = null, $param2 = null) {
        if(!$this->isLogin()) {
            redirect(base_url('admin/login'));
        }
        if($param1 == null) {
            redirect(base_url('admin/ebook'));
        }
        elseif($param1 === 'list') {
            $this->ebookList();
        }
        elseif($param1 === 'tambah' && $param2 == null) {
            $this->load->view('admin/ebook/form');
        }
        elseif($param1 === 'tambah' && $param2 === 'proses') {
            $this->tambahEbook();
        }
        elseif($param1 === 'detail' && $param2 != null) {
            $this->lihatEbook($param2);
        }
        elseif($param1 === 'edit' && $param2 == null) {
            $this->editEbook();
        }
        elseif($param1 === 'isi' && $param2 === 'tambah') {
            $this->tambahIsiEbook();
        }
        elseif($param1 === 'isi' && $param2 === 'hapus') {
            $this->hapusIsiEbook();
        }
        elseif($param1 === 'isi' && $param2 != null) {
            $this->isiEbook($param2);
        }
        elseif($param1 === 'hapus') {
            $this->hapusEbook();
        }
        else {
            redirect(base_url('admin/login'));
        }
    }

    private function getDataEbook($param) {
        $nama = trim($this->input->post('nama'));
        $nama = htmlspecialchars(strip_tags($nama), ENT_QUOTES);
        $deskripsi = trim($this->input->post('deskripsi'));
        $deskripsi = htmlspecialchars(strip_tags($deskripsi), ENT_QUOTES);
        $singkat = trim($this->input->post('singkat'));
        $singkat = htmlspecialchars(strip_tags($singkat), ENT_QUOTES);
        $harga = preg_replace('/[^0-9]/', '', trim($this->input->post('harga')));
        $link = filter_var(trim($this->input->post('link')), FILTER_SANITIZE_URL);

        if($nama == '' || $deskripsi == '' || $singkat == '' || $harga == '' || $harga == 0) {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak lengkap.';
            return $return;
        }

        $this->lang->load('upload', 'indonesia');
        $this->config->set_item('language', 'indonesia');

		$config['upload_path']		= './course/ebook/thumbnail';
		$config['allowed_types']	= 'jpg|png|jpeg';
		$config['file_ext_tolower']	= true;
		$config['overwrite']		= false;
		$config['remove_spaces']	= true;
        $this->load->library('upload', $config);

        $thumbnail = '';
        if( $param === 'tambah' || ($param === 'edit' && isset($_FILES['thumbnail'])) ) {
            if( !$this->upload->do_upload('thumbnail') ) {
                $return['type'] = 'error';
                $return['message'] = $this->upload->display_errors();
                return $return;
            }
            else {
                $upload_data = $this->upload->data();
                $thumbnail = $upload_data['file_name'];
            }
        }

        $return['type'] = 'success';
        $return['data'] = array(
            'nama_paket'        => $nama,
            'deskripsi_paket'   => $deskripsi,
            'deskripsi_singkat' => $singkat,
            'harga_paket'       => $harga,
            'thumbnail_paket'   => $thumbnail,
            'tanggal_dibuat'    => date('Y-m-d H:i:s'),
            'link_ebook'        => $link,
        );
        return $return;
    }

    private function ebookList() {
        // Jika request dari DataTable
        if($this->input->post('draw')) {
            $datatables = new Datatables(new CodeigniterAdapter);
            $query = 'SELECT `id_ebook_paket`, `nama_paket`, `harga_paket`, `tanggal_dibuat` FROM `ebook_paket`';
            $datatables->query($query);
            echo $datatables->generate();
        }
        else {
            $data = $this->model->getAllData('ebook_paket');
            echo json_encode($data);
        }
    }

    private function tambahEbook() {
        $data = $this->getDataEbook('tambah');

        if($data['type'] === 'error') {
            echo json_encode($data);
            die();
        }
        elseif($data['type'] === 'success') {
            $this->model->insertData('ebook_paket', $data['data']);

            $return['type'] = 'success';
            $return['message'] = $this->db->insert_id();
            echo json_encode($return);
        }
    }

    private function editEbook() {
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));
        $where = array('id_ebook_paket' => $id);
        $informasi_ebook = $this->model->getDataWhere('ebook_paket', $where);

        if($informasi_ebook == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data paket ebook tidak ditemukan.';
            echo json_encode($return);
            die();
        }

        $data = $this->getDataEbook('edit');

        if($data['type'] === 'error') {
            echo json_encode($data);
            die();
        }
        else {
            // Hapus thumbnail lama jika ada thumbnail baru
            if($data['data']['thumbnail_paket'] != '') {
                $path = './course/ebook/thumbnail/' . $informasi_ebook['thumbnail_paket'];
                if( file_exists($path) ) {
                    unlink($path);
                }
            }
            else {
                unset($data['data']['thumbnail_paket']);
            }

            $this->model->updateData('ebook_paket', $where, $data['data']);

            $return['type'] = 'success';
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('message', 'Berhasil mengedit data.');
            echo json_encode($return);
        }
    }

    private function lihatEbook($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        $where = array('id_ebook_paket' => $id);
        $data['ebook'] = $this->model->getDataWhere('ebook_paket', $where);

        if($data['ebook'] == '') {
            redirect(base_url('admin/login'));
        }
        else {
            $this->load->view('admin/ebook/detail', $data);
        }
    }

    private function isiEbook($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        $where = array('id_ebook_paket' => $id);
        $isi = $this->model->getAllDataWhere('ebook_isi', $where);
        echo json_encode($isi);
    }

    private function tambahIsiEbook() {
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));
        $judul = trim($this->input->post('judul'));
        $judul = htmlspecialchars(strip_tags($judul), ENT_QUOTES);

        if($id == '' || $judul == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak lengkap.';
            echo json_encode($return);
            die();
        }
        elseif($this->model->getDataWhere('ebook_paket', array('id_ebook_paket' => $id)) == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data paket ebook tidak ditemukan.';
            echo json_encode($return);
            die();
        }

        if( !file_exists('./course/ebook/content/'.$id) ) {
            mkdir('./course/ebook/content/'.$id, 0777);
        }

        $this->lang->load('upload', 'indonesia');
        $this->config->set_item('language', 'indonesia');

		$config['upload_path']		= './course/ebook/content/'.$id;
		$config['allowed_types']	= 'pdf';
		$config['file_ext_tolower']	= true;
		$config['overwrite']		= false;
		$config['remove_spaces']	= true;
        $this->load->library('upload', $config);

        $video = '';
        if( !$this->upload->do_upload('ebook') ) {
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
            'id_ebook_paket'=> $id,
            'nama_ebook'    => $judul,
            'file_ebook'    => $video,
        );
        $this->model->insertData('ebook_isi', $data);

        $return['type'] = 'success';
        $return['message'] = 'Berhasil menyimpan data.';
        echo json_encode($return);
    }

    private function hapusIsiEbook() {
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));
        $where = array('id_ebook' => $id);
        $informasi_ebook = $this->model->getDataWhere('ebook_isi', $where);

        if($informasi_ebook == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak ditemukan.';
            echo json_encode($return);
            die();
        }

        $path = './course/ebook/content/' . $informasi_ebook['id_ebook_paket'] . '/' . $informasi_ebook['file_ebook'];
        if( file_exists($path) ) {
            unlink($path);

            $this->model->deleteData('ebook_isi', $where);

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

    public function hapusEbook() {
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));
        $where = array('id_ebook_paket' => $id);
        $informasi_ebook = $this->model->getDataWhere('ebook_paket', $where);
        $isi_ebook = $this->model->getAllDataWhere('ebook_isi', $where);

        if($informasi_ebook == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak ditemukan.';
            echo json_encode($return);
            die();
        }

        try {
            $path = './course/ebook/content/' . $informasi_ebook['id_ebook_paket'] . '/';
            $files = glob($path . '*', GLOB_MARK);
            foreach ($files as $file) {
                unlink($file);
            }
            rmdir($path);
            $this->model->deleteData('ebook_isi', $where);

            $path = './course/ebook/thumbnail/' . $informasi_ebook['thumbnail_paket'];
            if( file_exists($path) ) {
                unlink($path);
                $this->model->deleteData('ebook_paket', $where);
                
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
    | [TRA] Transaksi
    | -------------------------------------------------- */

    public function transaksi() {
        if(!$this->isLogin()) {
            redirect(base_url('admin/login'));
        }
        else {
            $this->load->view('admin/transaksi/list');
        }
    }

    public function transaksiMenu($param1 = null, $param2 = null) {
        if(!$this->isLogin()) {
            redirect(base_url('admin/login'));
        }
        elseif($param1 === 'list') {
            $this->transaksiList();
        }
        elseif($param1 === 'tambah' && $param2 === 'proses') {
            $this->tambahTransaksi();
        }
        elseif($param1 === 'tambah') {
            $this->load->view('admin/transaksi/form');
        }
    }

    private function transaksiList() {
        $datatables = new Datatables(new CodeigniterAdapter);
        $query = 'SELECT `invoice`, `username_member`, `tanggal_transaksi`, `status_verifikasi`, `total_pembelian` FROM `transaksi`';
        $datatables->query($query);
        echo $datatables->generate();
    }

    private function tambahTransaksi() {
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $this->input->post('username'));
        $jenis = preg_replace('/[^a-z]/', '', $this->input->post('jenis'));
        $paket = preg_replace('/[^0-9]/', '', $this->input->post('paket'));

        $where = array('username_member' => $username);
        $member = $this->model->getDataWhere('member', $where);

        $where['jenis_paket'] = $jenis;
        $where['id_paket'] = $paket;
        $member_paket = $this->model->getDataWhere('member_paket', $where);

        if($member == '') {
            $return['type'] = 'error';
            $return['message'] = 'Member tidak ditemukan.';
            echo json_encode($return);
            die();
        }
        elseif($jenis != 'video' && $jenis != 'ebook') {
            $return['type'] = 'error';
            $return['message'] = 'Jenis paket tidak sesuai.';
            echo json_encode($return);
            die();
        }
        elseif($member_paket != '') {
            $return['type'] = 'error';
            $return['message'] = 'Member telah memiliki paket ini.';
            echo json_encode($return);
            die();
        }
        else {
            switch($jenis) {
                case 'video' : $where = array('id_video_paket' => $paket); $tabel = 'video_paket'; break;
                case 'ebook' : $where = array('id_ebook_paket' => $paket); $tabel = 'ebook_paket'; break;
            }
            $informasi_paket = $this->model->getDataWhere($tabel, $where);

            if($informasi_paket == '') {
                $return['type'] = 'error';
                $return['message'] = 'Paket tidak ditemukan.';
                echo json_encode($return);
                die();
            }
            else {
                $data = array(
                    'invoice'           => "bullbear_$username" . "_$jenis[0]$paket",
                    'username_member'   => $username,
                    'id_paket'          => $paket,
                    'jenis_paket'       => $jenis,
                    'tanggal_transaksi' => date('Y-m-d H:i:s'),
                    'tanggal_verifikasi'=> date('Y-m-d H:i:s'),
                    'status_verifikasi' => 1,
                    'total_pembelian'   => $informasi_paket['harga_paket']
                );
                $this->model->insertData('transaksi', $data);

                $data = array(
                    'username_member'   => $username,
                    'jenis_paket'       => $jenis,
                    'id_paket'          => $paket,
                );
                $this->model->insertData('member_paket', $data);

                $return['type'] = 'success';
                $return['message'] = 'Transaksi berhasil disimpan.';
                echo json_encode($return);
                die();
            }
        }
    }
}