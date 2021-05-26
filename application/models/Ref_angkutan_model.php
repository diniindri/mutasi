<?php

class Ref_angkutan_model extends CI_Model
{
    public function getAngkutan($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_angkutan')->result_array();
    }

    public function getDetailAngkutan($id = null)
    {
        return $this->db->get_where('ref_angkutan', ['id' => $id])->row_array();
    }

    public function findAngkutan($nama = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_angkutan', ['nama' => $nama])->result_array();
    }

    public function countAngkutan()
    {
        return $this->db->get('ref_angkutan')->num_rows();
    }

    public function createAngkutan($data = null)
    {
        $this->db->insert('ref_angkutan', $data);
        return $this->db->affected_rows();
    }

    public function updateAngkutan($data = null, $id = null)
    {
        $this->db->update('ref_angkutan', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteAngkutan($id = null)
    {
        $this->db->delete('ref_angkutan', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllAngkutan()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('ref_angkutan')->result_array();
    }
}
