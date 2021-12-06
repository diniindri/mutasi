<?php

class Data_jadwal_model extends CI_Model
{
    public function getJadwal($sk_id = null, $limit = null, $offset = 0)
    {
        $this->db->where('sk_id', $sk_id);
        $this->db->limit($limit, $offset);
        return $this->db->get('data_jadwal')->result_array();
    }

    public function getDetailJadwal($id = null)
    {
        return $this->db->get_where('data_jadwal', ['id' => $id])->row_array();
    }

    public function findJadwal($sk_id = null, $uraian = null, $limit = null, $offset = 0)
    {
        $this->db->like('uraian', $uraian);
        $this->db->where('sk_id', $sk_id);
        $this->db->limit($limit, $offset);
        return $this->db->get('data_jadwal')->result_array();
    }

    public function countJadwal($sk_id = null)
    {
        $this->db->where('sk_id', $sk_id);
        return $this->db->get('data_jadwal')->num_rows();
    }

    public function createJadwal($data = null)
    {
        $this->db->insert('data_jadwal', $data);
        return $this->db->affected_rows();
    }

    public function updateJadwal($data = null, $id = null)
    {
        $this->db->update('data_jadwal', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteJadwal($id = null)
    {
        $this->db->delete('data_jadwal', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllJadwal()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('data_jadwal')->result_array();
    }
}
