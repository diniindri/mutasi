<?php

class Data_dokumen_model extends CI_Model
{
    public function getDokumen($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('data_dokumen')->result_array();
    }

    public function getDetailDokumen($id = null)
    {
        return $this->db->get_where('data_dokumen', ['id' => $id])->row_array();
    }

    public function findDokumen($nama = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('data_dokumen', ['nama' => $nama])->result_array();
    }

    public function countDokumen()
    {
        return $this->db->get('data_dokumen')->num_rows();
    }

    public function createDokumen($data = null)
    {
        $this->db->insert('data_dokumen', $data);
        return $this->db->affected_rows();
    }

    public function updateDokumen($data = null, $id = null)
    {
        $this->db->update('data_dokumen', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteDokumen($id = null)
    {
        $this->db->delete('data_dokumen', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllDokumen()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('data_dokumen')->result_array();
    }
}
