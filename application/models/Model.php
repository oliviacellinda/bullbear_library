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
}