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
        elseif($param1 === 'buy' && $param2 != null) {
            $this->buyVideo($param2);
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

        if($data['video'] == '') {
            redirect(base_url('member/login'));
        }
        else {
            $this->load->view('member/video/content', $data);
        }
    }

    private function buyVideo($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        $where = array('id_video_paket' => $id);
        $video = $this->model->getDataWhere('video_paket', $where);

        if($video == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak ditemukan.';
            echo json_encode($return);
        }
        else {
            
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
        elseif($param1 === 'buy' && $param2 != null) {
            $this->buyEbook($param2);
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
        $where = array('username_member' => $this->session->bullbear_username_member, 'jenis_paket' => 'ebook', 'id_paket' => $id);
        $data['is_owner'] = ($this->model->getDataWhere('member_paket', $where) == '') ? false : true;

        if($data['ebook'] == '') {
            redirect(base_url('member/login'));
        }
        else {
            $this->load->view('member/ebook/content', $data);
        }
    }

    private function buyEbook($id) {
        $id = preg_replace('/[^0-9]/', '', $id);
        $where = array('id_ebook_paket' => $id);
        $video = $this->model->getDataWhere('ebook_paket', $where);

        if($video == '') {
            $return['type'] = 'error';
            $return['message'] = 'Data tidak ditemukan.';
            echo json_encode($return);
        }
        else {
            
        }
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


    /*--------------------------------------------------
    | [TRA] Transactions
    | -------------------------------------------------- */

    public function transaction($param) {
        if($param === 'new') {
            if(!$this->isLogin()) {
                $return['type'] = 'error';
                $return['message'] = 'User not authorized.';
                echo json_encode($return);
            }
            else {
                $this->newTransaction();
            }
        }
    }

    private function getInvoice($type, $id) {
        $username = $this->session->bullbear_username_member;
        $number = ($type === 'video' ? 'v' : 'e') . $id;
        return 'bullbear_' . $username . '_' . $number;
    }

    private function newTransaction() {
        $type = preg_replace('/[^a-z]/', '', $this->input->post('type'));
        $id = preg_replace('/[^0-9]/', '', $this->input->post('id'));

        if($type === 'video') {
            $where = array('id_video_paket' => $id);
            $paket = $this->model->getDataWhere('video_paket', $where);
        }
        elseif($type === 'ebook') {
            $where = array('id_ebook_paket' => $id);
            $paket = $this->model->getDataWhere('ebook_paket', $where);
        }
        else {
            $return['type'] = 'error';
            $return['message'] = 'Library not found';
            echo json_encode($return);
            die();
        }

        $json = array(
            'transaction_details' => array(
                'order_id' => $this->getInvoice($type, $id),
                'gross_amount' => $paket['harga_paket'],
            ),
            'item_details' => array(
                0 => array(
                    'id' => $id,
                    'price' => $paket['harga_paket'],
                    'quantity' => 1,
                    'name' => $paket['nama_paket'],
                ),
            ),
        );

        $header = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode('SB-Mid-server-q94LeQBlRu0MMd4cp6fYVzUC:'),
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, 'https://app.sandbox.midtrans.com/snap/v1/transactions');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $data = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if($httpcode == 201) {
            $data = json_decode($data);
            $return['type'] = 'success';
            $return['token'] = $data->token;
            $return['redirect_url'] = $data->redirect_url;
        }
        else {
            $return['type'] = 'error';
            $return['message'] = 'Error! Can not send transactions.';
        }

        echo json_encode($return);
    }
}