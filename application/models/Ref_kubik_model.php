<?php

class Ref_kubik_model extends CI_Model
{
    public function getKubik($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_kubik')->result_array();
    }

    public function getDetailKubik($id = null)
    {
        return $this->db->get_where('ref_kubik', ['id' => $id])->row_array();
    }

    public function findKubik($gol = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_kubik', ['gol' => $gol])->result_array();
    }

    public function countKubik()
    {
        return $this->db->get('ref_kubik')->num_rows();
    }

    public function createKubik($data = null)
    {
        $this->db->insert('ref_kubik', $data);
        return $this->db->affected_rows();
    }

    public function updateKubik($data = null, $id = null)
    {
        $this->db->update('ref_kubik', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteKubik($id = null)
    {
        $this->db->delete('ref_kubik', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllKubik()
    {
        $this->db->order_by('gol', 'ASC');
        return $this->db->get('ref_kubik')->result_array();
    }
}
