<?php

class Ref_proses_model extends CI_Model
{
    public function getProses($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_proses')->result_array();
    }

    public function getDetailProses($id = null)
    {
        return $this->db->get_where('ref_proses', ['id' => $id])->row_array();
    }

    public function findProses($nama = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_proses', ['nama' => $nama])->result_array();
    }

    public function countProses()
    {
        return $this->db->get('ref_proses')->num_rows();
    }

    public function createProses($data = null)
    {
        $this->db->insert('ref_proses', $data);
        return $this->db->affected_rows();
    }

    public function updateProses($data = null, $id = null)
    {
        $this->db->update('ref_proses', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteProses($id = null)
    {
        $this->db->delete('ref_proses', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllProses()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('ref_proses')->result_array();
    }
}
