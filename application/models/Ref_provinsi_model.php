<?php

class Ref_provinsi_model extends CI_Model
{
    public function getProvinsi($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_provinsi')->result_array();
    }

    public function getDetailProvinsi($id = null)
    {
        return $this->db->get_where('ref_provinsi', ['id' => $id])->row_array();
    }

    public function findProvinsi($tujuan = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_provinsi', ['tujuan' => $tujuan])->result_array();
    }

    public function countProvinsi()
    {
        return $this->db->get('ref_provinsi')->num_rows();
    }

    public function createProvinsi($data = null)
    {
        $this->db->insert('ref_provinsi', $data);
        return $this->db->affected_rows();
    }

    public function updateProvinsi($data = null, $id = null)
    {
        $this->db->update('ref_provinsi', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteProvinsi($id = null)
    {
        $this->db->delete('ref_provinsi', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllProvinsi()
    {
        $this->db->order_by('tujuan', 'ASC');
        return $this->db->get('ref_provinsi')->result_array();
    }
}
