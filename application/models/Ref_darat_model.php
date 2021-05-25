<?php

class Ref_darat_model extends CI_Model
{
    public function getPesawat($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_pesawat')->result_array();
    }

    public function getDetailPesawat($id = null)
    {
        return $this->db->get_where('ref_pesawat', ['id' => $id])->row_array();
    }

    public function findPesawat($asal = null, $tujuan = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_pesawat', ['kota_asal' => $asal, 'kota_tujuan' => $tujuan])->result_array();
    }

    public function countPesawat()
    {
        return $this->db->get('ref_pesawat')->num_rows();
    }

    public function createPesawat($data = null)
    {
        $this->db->insert('ref_pesawat', $data);
        return $this->db->affected_rows();
    }

    public function updatePesawat($data = null, $id = null)
    {
        $this->db->update('ref_pesawat', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deletePesawat($id = null)
    {
        $this->db->delete('ref_pesawat', ['id' => $id]);
        return $this->db->affected_rows();
    }
}
