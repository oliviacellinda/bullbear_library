<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {
    
    private static $server_key = 'SB-Mid-server-q94LeQBlRu0MMd4cp6fYVzUC';

    public function __construct() {
        parent::__construct();

        $this->load->model('model');
        $this->load->helper('cookie');
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
        $date = date('YmdHis');
        return 'bullbear_' . $username . '_' . $number . '_' . $date;
    }
    
    private function getSignatureKey($order_id, $status_code, $gross_amount) {
        $input = $order_id . $status_code . $gross_amount . self::$server_key;
        return openssl_digest($input, 'sha512');
    }
    
    private function getStatusInvoice($order_id) {
        $header = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(self::$server_key.':'),
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.midtrans.com/v2/$order_id/status");
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $data = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        return $httpcode == 200 ? json_decode($data) : false;
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

        $invoice = $this->getInvoice($type, $id);

        $json = array(
            'transaction_details' => array(
                'order_id'      => $invoice,
                'gross_amount'  => $paket['harga_paket'],
            ),
            'item_details' => array(
                0 => array(
                    'id'        => $id,
                    'price'     => $paket['harga_paket'],
                    'quantity'  => 1,
                    'name'      => $paket['nama_paket'],
                ),
            ),
        );
        
        $transaksi = array(
            'invoice'           => $invoice,
            'username_member'   => $this->session->bullbear_username_member,
            'id_paket'          => $id,
            'jenis_paket'       => $type,
            'total_pembelian'   => $paket['harga_paket'],
        );
        // $this->session->set_userdata('transaksi', $transaksi);
        foreach($transaksi as $key => $value) {
            $data = array('name' => $key, 'value' => $value, 'expire' => 7200);
            set_cookie($data);
        }

        $header = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(self::$server_key.':'),
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
        elseif($this->session->alert_status) {
            $this->session->unset_userdata('alert_status');
            $this->session->unset_userdata('alert_info');
            redirect(base_url('member/history'));
        }
        elseif($param == 'finish') {
            $this->session->set_userdata('alert_status', 'info');
            $this->session->set_userdata('alert_info', 'Thank you for your payment. Please wait while we are processing your payment.');
            
            // $verify = $this->getStatusInvoice($_SESSION['transaksi']['invoice']);
            $verify = $this->getStatusInvoice($this->input->get('order_id'));
            if(!$verify) {
                $status = 'pending';
                $tgl_transaksi = date('Y-m-d H:i:s');
                $tgl_verifikasi = '';
            }
            else {
                if($verify->status_code == 200) {
                    $status = 'verified';
                    $tgl_transaksi = $verify->transaction_time;
                    $tgl_verifikasi = isset($verify->settlement_time) ? $verify->settlement_time : $verify->transaction_time;
                    
                    // $this->model->insertData('member_paket', $new);
                    // $this->model->insertNewLibrary($_SESSION['transaksi']['username_member'], $_SESSION['transaksi']['jenis_paket'], $_SESSION['transaksi']['id_paket']);
                    $this->model->insertNewLibrary(get_cookie('username_member'), get_cookie('jenis_member'), get_cookie('id_paket'));
                }
                elseif($verify->status_code == 201) {
                    $status = 'pending';
                    $tgl_transaksi = $verify->transaction_time;
                    $tgl_verifikasi = '';
                }
                elseif($verify->status_code == 202) {
                    $status = 'failed';
                    $tgl_transaksi = $verify->transaction_time;
                    $tgl_verifikasi = '';
                }
                else {
                    $status = 'error';
                    $tgl_transaksi = $verify->transaction_time;
                    $tgl_verifikasi = '';
                }   
            }
            
            // $data = array(
            //     'invoice'           => $_SESSION['transaksi']['invoice'],
            //     'username_member'   => $_SESSION['transaksi']['username_member'],
            //     'id_paket'          => $_SESSION['transaksi']['id_paket'],
            //     'jenis_paket'       => $_SESSION['transaksi']['jenis_paket'],
            //     'tanggal_transaksi' => $tgl_transaksi,
            //     'tanggal_verifikasi'=> $tgl_verifikasi,
            //     'status_verifikasi' => $status,
            //     'total_pembelian'   => $_SESSION['transaksi']['total_pembelian'],
            //     'sumber_pembayaran' => 'midtrans',
            // );
            $data = array(
                'invoice'           => get_cookie('invoice'),
                'username_member'   => get_cookie('username_member'),
                'id_paket'          => get_cookie('id_paket'),
                'jenis_paket'       => get_cookie('jenis_paket'),
                'tanggal_transaksi' => $tgl_transaksi,
                'tanggal_verifikasi'=> $tgl_verifikasi,
                'status_verifikasi' => $status,
                'total_pembelian'   => get_cookie('total_pembelian'),
                'sumber_pembayaran' => 'midtrans',
            );
            $this->model->insertData('transaksi', $data);
        }
        elseif($param == 'unfinish') {
            $this->session->set_userdata('alert_status', 'secondary');
            $this->session->set_userdata('alert_info', 'Payment cancelled.');
        }
        elseif($param == 'error') {
            $this->session->set_userdata('alert_status', 'danger');
            $this->session->set_userdata('alert_info', 'An error occured during payment process.');
        }
        
        $this->session->unset_userdata('transaksi');
        $this->load->view('member/transaksi');
    }

    public function notification() {
        $testing = array('datetime' => date('Y-m-d H:i:s'), 'data' => file_get_contents('php://input'));
        $this->model->insertData('notification', $testing);
        
        $data = file_get_contents('php://input');
        $data = json_decode($data);
        
        $signature = $this->getSignatureKey($data->order_id, $data->status_code, $data->gross_amount);
        
        if($data->signature_key === $signature) {
            $verify = $this->getStatusInvoice($data->order_id);
            
            if(!$verify) {
                http_response_code(403);
                return false;
            }
            
            // Untuk keperluan testing
            $testing = array('datetime' => date('Y-m-d H:i:s'), 'data1' => $data->signature_key, 'data2' => json_encode($verify));
            $this->model->insertData('testing', $testing);
            
            if($verify->status_code == 200) {
                $update = array(
                    'status_verifikasi' => 'verified',
                    'tanggal_verifikasi'=> $verify->settlement_time,
                );
                
                $where = array('invoice' => $verify->order_id);
                $transaksi = $this->model->getDataWhere('transaksi', $where);
                if($transaksi != '') {
                    // $new = array(
                    //     'username_member'   => $transaksi['username_member'],
                    //     'jenis_paket'       => $transaksi['jenis_paket'],
                    //     'id_paket'          => $transaksi['id_paket'],
                    // );
                    // $this->model->insertData('member_paket', $new);
                    $this->model->insertNewLibrary($transaksi['username_member'], $transaksi['jenis_paket'], $transaksi['id_paket']);
                }
            }
            elseif($verify->status_code == 201) {
                $update = array('status_verifikasi' => 'pending');
            }
            elseif($verify->status_code == 202) {
                $update = array('status_verifikasi' => 'failed');
            }
            else {
                $update = array('status_verifikasi' => 'error');
            }
            
            $where = array('invoice' => $verify->order_id);
            $this->model->updateData('transaksi', $where, $update);
            
            http_response_code(200);
            return true;
        }
        else {
            http_response_code(403);
            return false;
        }
    }
}