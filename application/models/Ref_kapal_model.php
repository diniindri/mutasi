<?php

class Ref_kapal_model extends CI_Model
{
    public function getKapal($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_kapal')->result_array();
    }

    public function getDetailKapal($id = null)
    {
        return $this->db->get_where('ref_kapal', ['id' => $id])->row_array();
    }

    public function findKapal($asal = null, $tujuan = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_kapal', ['kota_asal' => $asal, 'kota_tujuan' => $tujuan])->result_array();
    }

    public function countKapal()
    {
        return $this->db->get('ref_kapal')->num_rows();
    }

    public function createKapal($data = null)
    {
        $this->db->insert('ref_kapal', $data);
        return $this->db->affected_rows();
    }

    public function updateKapal($data = null, $id = null)
    {
        $this->db->update('ref_kapal', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteKapal($id = null)
    {
        $this->db->delete('ref_kapal', ['id' => $id]);
        return $this->db->affected_rows();
    }
}
