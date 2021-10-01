<?php

class Data_sk_model extends CI_Model
{
    public function getSk($limit = null, $offset = 0)
    {
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('data_sk')->result_array();
    }

    public function getDetailSk($id = null)
    {
        return $this->db->get_where('data_sk', ['id' => $id])->row_array();
    }

    public function findSk($uraian = null, $limit = null, $offset = 0)
    {
        $this->db->like('uraian', $uraian);
        $this->db->limit($limit, $offset);
        return $this->db->get('data_sk')->result_array();
    }

    public function countSk()
    {
        return $this->db->get('data_sk')->num_rows();
    }

    public function createSk($data = null)
    {
        $this->db->insert('data_sk', $data);
        return $this->db->affected_rows();
    }

    public function updateSk($data = null, $id = null)
    {
        $this->db->update('data_sk', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteSk($id = null)
    {
        $this->db->delete('data_sk', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllSk()
    {
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('data_sk')->result_array();
    }
}
