<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getAllData($table) {
        $query = $this->db->get($table);
        if($query->num_rows() > 0)
            return $query->result_array();
    }

    public function getAllDataWhere($table, $where) {
        $this->db->where($where);
        $query = $this->db->get($table);
        if($query->num_rows() > 0)
            return $query->result_array();
    }

    public function getDataWhere($table, $where) {
        $this->db->where($where);
        $query = $this->db->get($table);
        if($query->num_rows() > 0)
            return $query->row_array();
    }

    public function insertData($table, $data) {
        $this->db->insert($table, $data);
    }

    public function updateData($table, $where, $data) {
        foreach ($data as $key => $value) {
            $this->db->set($key, $value);
        }
        $this->db->where($where);
        $this->db->update($table);
    }

    public function deleteData($table, $where) {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function getContent($content, $search, $sort, $limit, $is_owner) {
        if($is_owner == true) {
            $this->db->where('jenis_library', $content);
            $this->db->where('username_member', $this->session->bullbear_username_member);
            $query = $this->db->get('member_library');
            if($query->num_rows() > 0) {
                $query = $query->result_array();
                $list = array();
                foreach ($query as $element) {
                    $list[] = $element['id_paket'];
                }
            }
        }

        if($is_owner == true && isset($list))
            $this->db->where_in('id_paket', $list);

        if($search != '')
            $this->db->where('MATCH (nama_paket, deskripsi_paket) AGAINST ("'.$search.'" IN BOOLEAN MODE)');

        $this->db->order_by('harga_paket', $sort);

        if($limit !== 'all' && is_numeric($limit))
            $this->db->limit($limit);

        $query = $this->db->get( ($content === 'video') ? 'video_paket' : 'ebook_paket' );
        if($query->num_rows() > 0)
            return $query->result_array();
    }
}