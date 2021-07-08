<?php

class Ref_status_keluarga_model extends CI_Model
{
    public function getStatusKeluarga($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_status_keluarga')->result_array();
    }

    public function getDetailStatusKeluarga($id = null)
    {
        return $this->db->get_where('ref_status_keluarga', ['id' => $id])->row_array();
    }

    public function findStatusKeluarga($nama = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_status_keluarga', ['nama' => $nama])->result_array();
    }

    public function countStatusKeluarga()
    {
        return $this->db->get('ref_status_keluarga')->num_rows();
    }

    public function createStatusKeluarga($data = null)
    {
        $this->db->insert('ref_status_keluarga', $data);
        return $this->db->affected_rows();
    }

    public function updateStatusKeluarga($data = null, $id = null)
    {
        $this->db->update('ref_status_keluarga', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteStatusKeluarga($id = null)
    {
        $this->db->delete('ref_status_keluarga', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllStatusKeluarga()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('ref_status_keluarga')->result_array();
    }
}
