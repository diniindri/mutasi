<?php

class Ref_packing_model extends CI_Model
{
    public function getPacking($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_packing')->result_array();
    }

    public function getDetailPacking($id = null)
    {
        return $this->db->get_where('ref_packing', ['id' => $id])->row_array();
    }

    public function findPacking($tujuan = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_packing', ['kota_tujuan' => $tujuan])->result_array();
    }

    public function countPacking()
    {
        return $this->db->get('ref_packing')->num_rows();
    }

    public function createPacking($data = null)
    {
        $this->db->insert('ref_packing', $data);
        return $this->db->affected_rows();
    }

    public function updatePacking($data = null, $id = null)
    {
        $this->db->update('ref_packing', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deletePacking($id = null)
    {
        $this->db->delete('ref_packing', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllPacking()
    {
        return $this->db->get('ref_packing')->result_array();
    }
}
