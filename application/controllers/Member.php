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

    public function register() {
        if($this->isLogin())
            redirect(base_url('member/home'));
        else
            $this->load->view('member/register');
    }

    public function prosesLogin() {
        $username = preg_replace('/[^A-Za-z0-9]/', '', $this->input->post('username'));
        $password = $this->input->post('password');

        $where = array('username_member' => $username);
        $informasi_member = $this->model->getDataWhere('member', $where);

        if($informasi_member == '') {
            echo json_encode('username not found');
            die();
        }
        elseif(!password_verify($password, $informasi_member['password_member'])) {
            echo json_encode('password is wrong');
            die();
        }
        else {
            $this->session->set_userdata('bullbear_username_member', $informasi_member['username_member']);
            echo json_encode('success');
        }
    }

    public function prosesRegister() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $nama = $this->input->post('nama');

        if($username == '' || $password == '' || $email == '' || $nama == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data is not complete.';
            echo json_encode($return);
            die();
        }

        if(!ctype_alnum($username)) {
            $return['type'] = 'error';
            $return['message'] = 'Username can only contain letters and numbers.';
            echo json_encode($return);
            die();
        }

        if(strlen($password) < 8) {
            $return['type'] = 'error';
            $return['message'] = 'The minimum length of password is 8 characters.';
            echo json_encode($return);
            die();
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $return['type'] = 'error';
            $return['message'] = 'Invalid email format.';
            echo json_encode($return);
            die();
        }

        if (!preg_match("/^[a-zA-Z ]/", $nama)) {
            $return['type'] = 'error';
            $return['message'] = 'Name can only contain letters and white space.';
            echo json_encode($return);
            die();
        }

        $username = trim($username);
        $password = trim($password);
        $email = trim($email);
        $nama = trim($nama);

        $where = array('username_member' => $username);
        $informasi_member = $this->model->getDataWhere('member', $where);
        if($informasi_member != '') {
            $return['type'] = 'error';
            $return['message'] = 'Username is already used.';
            echo json_encode($return);
            die();
        }

        $where = array('email_member' => $email);
        $informasi_member = $this->model->getDataWhere('member', $where);
        if($informasi_member != '') {
            $return['type'] = 'error';
            $return['message'] = 'Email is already used.';
            echo json_encode($return);
            die();
        }

        $data = array(
            'username_member'   => $username,
            'password_member'   => password_hash($password, PASSWORD_DEFAULT),
            'nama_member'       => $nama,
            'email_member'      => $email,
        );
        $this->model->insertData('member', $data);

        $this->session->set_userdata('bullbear_username_member', $username);
        $return['type'] = 'success';
        echo json_encode($return);
    }

    public function logout() {
        session_destroy();
        redirect(base_url('member/login'));
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
    
    public function changePassword() {
        $lama = $this->input->post('password_lama');
        $baru = $this->input->post('password_baru');
        $konfirmasi = $this->input->post('konfirmasi_password');
        
        if($lama == '' || $baru == '' || $konfirmasi == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data required is not complete.';
            echo json_encode($return);
            die();
        }
        elseif(strlen($baru) < 8) {
            $return['type'] = 'error';
            $return['message'] = 'The minimum length of password is 8 characters.';
            echo json_encode($return);
            die();
        }
        elseif($konfirmasi != $baru) {
            $return['type'] = 'error';
            $return['message'] = 'Confirmation password does not match.';
            echo json_encode($return);
            die();
        }
        
        $where = array('username_member' => $this->session->bullbear_username_member);
        $informasi_member = $this->model->getDataWhere('member', $where);
        
        if(!password_verify($lama, $informasi_member['password_member'])) {
            $return['type'] = 'error';
            $return['message'] = 'Wrong password.';
            echo json_encode($return);
            die();
        }
        
        $data = array('password_member' => password_hash($baru, PASSWORD_DEFAULT));
        $this->model->updateData('member', $where, $data);
        
        $return['type'] = 'success';
        $return['message'] = 'Successfully changed password.';
        echo json_encode($return);
    }


    /*--------------------------------------------------
    | [VID] Video
    | -------------------------------------------------- */

    public function myVideo() {
        if(!$this->isLogin()) {
            redirect(base_url('member/login'));
        }
        else {
            $this->load->view('member/video/my_video');
        }
    }

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

        $where = array('username_member' => $this->session->bullbear_username_member, 'jenis_paket' => 'video', 'id_paket' => $id);
        $data['is_owner'] = ($this->model->getDataWhere('member_paket', $where) == '') ? false : true;

        $transaksi = $this->model->getDataWhere('transaksi', $where);
        $data['is_pending'] = ($transaksi['status_verifikasi'] == 'pending') ? true : false;

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

    public function myEbook() {
        if(!$this->isLogin()) {
            redirect(base_url('member/login'));
        }
        else {
            $this->load->view('member/ebook/my_ebook');
        }
    }

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
        elseif($param1 === 'content' && $param2 != null) {
            $this->ebookContent($param2);
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

    private function ebookContent($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        $where = array('id_ebook_paket' => $id);
        $data['ebook'] = $this->model->getDataWhere('ebook_paket', $where);
        $data['content'] = $this->model->getAllDataWhere('ebook_isi', $where);
        
        for($i=0; $i<count($data['content']); $i++) {
            $data['content'][$i]['url'] = base_url('member/content/ebook/') . $data['content'][$i]['id_ebook_paket'] . '/' . $data['content'][$i]['id_ebook'];
        }
        
        $where = array('username_member' => $this->session->bullbear_username_member, 'jenis_paket' => 'ebook', 'id_paket' => $id);
        $data['is_owner'] = ($this->model->getDataWhere('member_paket', $where) == '') ? false : true;
        
        $transaksi = $this->model->getDataWhere('transaksi', $where);
        $data['is_pending'] = ($transaksi['status_verifikasi'] == 'pending') ? true : false;

        if($data['ebook'] == '') {
            redirect(base_url('member/login'));
        }
        else {
            $this->load->view('member/ebook/content', $data);
        }
    }

    
    /*--------------------------------------------------
    | [CON] Content
    | -------------------------------------------------- */
    
    public function content($jenis, $paket, $id) {
        if(!$this->isLogin() || $jenis != 'ebook' || empty($paket) || empty($id)) {
            redirect(base_url('login'));
        }
        
        $paket = preg_replace('/[^0-9]/', '', $paket);
        $id = preg_replace('/[^0-9]/', '', $id);
        
        $data['url'] = base_url('member/pdf/') . $paket . '/' . $id;
        
        $this->load->view('member/ebook/viewer', $data);
    }
    
    public function pdf($paket, $id) {
        $where = array('id_ebook_paket' => $paket, 'id_ebook' => $id);
        $ebook = $this->model->getDataWhere('ebook_isi', $where);
        
        $path = base_url('course/ebook/content/') . $ebook['id_ebook_paket'] . '/' .  $ebook['file_ebook'];
        
        $file = chunk_split(base64_encode(file_get_contents($path)));
        echo $file;
    }
    

    /*--------------------------------------------------
    | [HIS] History
    | -------------------------------------------------- */

    public function history($param = null) {
        if(!$this->isLogin()) {
            redirect(base_url('member/login'));
        }
        elseif($param === 'list') {
            $query = "SELECT tanggal_transaksi, jenis_paket, status_verifikasi, total_pembelian, 
                             nama_paket, deskripsi_singkat, thumbnail_paket
                      FROM transaksi
                      LEFT JOIN video_paket ON transaksi.id_paket = video_paket.id_video_paket 
                      WHERE username_member = '" . $this->session->bullbear_username_member . "' AND transaksi.jenis_paket = 'video' 
                      UNION 
                      SELECT tanggal_transaksi, jenis_paket, status_verifikasi, total_pembelian, 
                             nama_paket, deskripsi_singkat, thumbnail_paket
                      FROM transaksi
                      LEFT JOIN ebook_paket ON transaksi.id_paket = ebook_paket.id_ebook_paket  
                      WHERE username_member = '" . $this->session->bullbear_username_member . "' AND transaksi.jenis_paket = 'ebook'";
            
            $datatables = new Datatables(new CodeigniterAdapter);
            $datatables->query($query);
            echo $datatables->generate();
        }
        else {
            $this->load->view('member/transaksi');
        }
    }


}