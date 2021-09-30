<?php

class Ref_laporan_model extends CI_Model
{
    public function getLaporan($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_laporan')->result_array();
    }

    public function getDetailLaporan($id = null)
    {
        return $this->db->get_where('ref_laporan', ['id' => $id])->row_array();
    }

    public function findLaporan($nama = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_laporan', ['nama' => $nama])->result_array();
    }

    public function countLaporan()
    {
        return $this->db->get('ref_laporan')->num_rows();
    }

    public function createLaporan($data = null)
    {
        $this->db->insert('ref_laporan', $data);
        return $this->db->affected_rows();
    }

    public function updateLaporan($data = null, $id = null)
    {
        $this->db->update('ref_laporan', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteLaporan($id = null)
    {
        $this->db->delete('ref_laporan', ['id' => $id]);
        return $this->db->affected_rows();
    }
}
