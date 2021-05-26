<?php

class Ref_uang_harian_model extends CI_Model
{
    public function getUangHarian($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_uang_harian')->result_array();
    }

    public function getDetailUangHarian($id = null)
    {
        return $this->db->get_where('ref_uang_harian', ['id' => $id])->row_array();
    }

    public function findUangHarian($provinsi = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_uang_harian', ['provinsi' => $provinsi])->result_array();
    }

    public function countUangHarian()
    {
        return $this->db->get('ref_uang_harian')->num_rows();
    }

    public function createUangHarian($data = null)
    {
        $this->db->insert('ref_uang_harian', $data);
        return $this->db->affected_rows();
    }

    public function updateUangHarian($data = null, $id = null)
    {
        $this->db->update('ref_uang_harian', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteUangHarian($id = null)
    {
        $this->db->delete('ref_uang_harian', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllUangHarian()
    {
        $this->db->order_by('provinsi', 'ASC');
        return $this->db->get('ref_uang_harian')->result_array();
    }
}
