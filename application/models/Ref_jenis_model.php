<?php

class Ref_jenis_model extends CI_Model
{
    public function getJenis($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_jenis')->result_array();
    }

    public function getDetailJenis($id = null)
    {
        return $this->db->get_where('ref_jenis', ['id' => $id])->row_array();
    }

    public function findJenis($nama = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_jenis', ['nama' => $nama])->result_array();
    }

    public function countJenis()
    {
        return $this->db->get('ref_jenis')->num_rows();
    }

    public function createJenis($data = null)
    {
        $this->db->insert('ref_jenis', $data);
        return $this->db->affected_rows();
    }

    public function updateJenis($data = null, $id = null)
    {
        $this->db->update('ref_jenis', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteJenis($id = null)
    {
        $this->db->delete('ref_jenis', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllJenis()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('ref_jenis')->result_array();
    }
}
