<?php

class Ref_pangkat_model extends CI_Model
{
    public function getPangkat($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_pangkat')->result_array();
    }

    public function getDetailPangkat($id = null)
    {
        return $this->db->get_where('ref_pangkat', ['id' => $id])->row_array();
    }

    public function findPangkat($kdgol = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_pangkat', ['kdgol' => $kdgol])->result_array();
    }

    public function countPangkat()
    {
        return $this->db->get('ref_pangkat')->num_rows();
    }

    public function createPangkat($data = null)
    {
        $this->db->insert('ref_pangkat', $data);
        return $this->db->affected_rows();
    }

    public function updatePangkat($data = null, $id = null)
    {
        $this->db->update('ref_pangkat', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deletePangkat($id = null)
    {
        $this->db->delete('ref_pangkat', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllPangkat()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('ref_pangkat')->result_array();
    }

    public function getKodePangkat($kode = null)
    {
        return $this->db->get_where('ref_pangkat', ['kode' => $kode])->row_array();
    }

    public function getKdgapok($nmgol = null)
    {
        return $this->db->get_where('ref_pangkat', ['nmgol' => $nmgol])->row_array();
    }
}
