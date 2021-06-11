<?php

class Ref_tarif_darat_model extends CI_Model
{
    public function getTarifDarat($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_tarif_darat')->result_array();
    }

    public function getDetailTarifDarat($id = null)
    {
        return $this->db->get_where('ref_tarif_darat', ['id' => $id])->row_array();
    }

    public function findTarifDarat($orang = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_tarif_darat', ['orang' => $orang])->result_array();
    }

    public function countTarifDarat()
    {
        return $this->db->get('ref_tarif_darat')->num_rows();
    }

    public function createTarifDarat($data = null)
    {
        $this->db->insert('ref_tarif_darat', $data);
        return $this->db->affected_rows();
    }

    public function updateTarifDarat($data = null, $id = null)
    {
        $this->db->update('ref_tarif_darat', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteTarifDarat($id = null)
    {
        $this->db->delete('ref_tarif_darat', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllTarifDarat()
    {
        $this->db->order_by('orang', 'ASC');
        return $this->db->get('ref_tarif_darat')->result_array();
    }
}
