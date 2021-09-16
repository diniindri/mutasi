<?php

class Ref_dokumen_model extends CI_Model
{
    public function getDokumen($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_dokumen')->result_array();
    }

    public function getDetailDokumen($id = null)
    {
        return $this->db->get_where('ref_dokumen', ['id' => $id])->row_array();
    }

    public function findDokumen($jenis = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_dokumen', ['jenis' => $jenis])->result_array();
    }

    public function countDokumen()
    {
        return $this->db->get('ref_dokumen')->num_rows();
    }

    public function createDokumen($data = null)
    {
        $this->db->insert('ref_dokumen', $data);
        return $this->db->affected_rows();
    }

    public function updateDokumen($data = null, $id = null)
    {
        $this->db->update('ref_dokumen', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteDokumen($id = null)
    {
        $this->db->delete('ref_dokumen', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllDokumen()
    {
        return $this->db->get('ref_dokumen')->result_array();
    }
}
