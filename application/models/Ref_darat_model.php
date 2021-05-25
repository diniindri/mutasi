<?php

class Ref_darat_model extends CI_Model
{
    public function getDarat($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_darat')->result_array();
    }

    public function getDetailDarat($id = null)
    {
        return $this->db->get_where('ref_darat', ['id' => $id])->row_array();
    }

    public function findDarat($asal = null, $tujuan = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_darat', ['kota_asal' => $asal, 'kota_tujuan' => $tujuan])->result_array();
    }

    public function countDarat()
    {
        return $this->db->get('ref_darat')->num_rows();
    }

    public function createDarat($data = null)
    {
        $this->db->insert('ref_darat', $data);
        return $this->db->affected_rows();
    }

    public function updateDarat($data = null, $id = null)
    {
        $this->db->update('ref_darat', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteDarat($id = null)
    {
        $this->db->delete('ref_darat', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllDarat()
    {
        $this->db->order_by('kota_asal', 'ASC');
        return $this->db->get('ref_darat')->result_array();
    }
}
