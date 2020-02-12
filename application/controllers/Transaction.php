<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('model');
    }

    private function isLogin() {
        if($this->session->bullbear_username_member != '')
            return true;
        else 
            return false;
    }

    private function getInvoice($type, $id) {
        $username = $this->session->bullbear_username_member;
        $number = ($type === 'video' ? 'v' : 'e') . $id;
        return 'bullbear_' . $username . '_' . $number;
    }

    public function new() {
        if(!$this->isLogin()) {
            $return['type'] = 'error';
            $return['message'] = 'User not authorized.';
            echo json_encode($return);
            die();
        }

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

    public function payment($param = null) {
        if($param == null) {
            redirect(base_url('login'));
        }
        elseif($param == 'finish') {
            $this->session->set_flashdata('alert_status', 'primary');
            $this->session->set_flashdata('alert_info', 'Thank you for your payment. Please wait while we are processing your payment.');
        }
        elseif($param == 'unfinish') {
            $this->session->set_flashdata('alert_status', 'secondary');
            $this->session->set_flashdata('alert_info', 'Payment cancelled.');
        }
        elseif($param == 'finish') {
            $this->session->set_flashdata('alert_status', 'danger');
            $this->session->set_flashdata('alert_info', 'An error occured during payment process.');
        }
        $this->load->view('member/transaksi');
    }

    public function notification() {
        
    }
}