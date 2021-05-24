<?php

class Ref_rute_model extends CI_Model
{
    public function getRute($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_rute')->result_array();
    }

    public function getDetailRute($id = null)
    {
        return $this->db->get_where('ref_rute', ['id' => $id])->row_array();
    }

    public function findRute($asal = null, $tujuan = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_rute', ['asal' => $asal, 'tujuan' => $tujuan])->result_array();
    }

    public function countRute()
    {
        return $this->db->get('ref_rute')->num_rows();
    }

    public function createRute($data = null)
    {
        $this->db->insert('ref_rute', $data);
        return $this->db->affected_rows();
    }

    public function updateRute($data = null, $id = null)
    {
        $this->db->update('ref_rute', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteRute($id = null)
    {
        $this->db->delete('ref_rute', ['id' => $id]);
        return $this->db->affected_rows();
    }
}
