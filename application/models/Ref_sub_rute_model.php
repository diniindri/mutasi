<?php

class Ref_sub_rute_model extends CI_Model
{
    public function getSubRute($rute_id = null)
    {
        $this->db->select('ref_sub_rute.*, ref_jenis.nama AS jenis_rute, ref_angkutan.nama AS jenis_angkutan');
        $this->db->from('ref_sub_rute');
        $this->db->join('ref_jenis', 'ref_jenis.id = ref_sub_rute.jenis_id');
        $this->db->join('ref_angkutan', 'ref_angkutan.id = ref_sub_rute.angkutan_id');
        $this->db->where(['rute_id' => $rute_id]);
        return $this->db->get()->result_array();
    }

    public function getDetailSubRute($id = null)
    {
        return $this->db->get_where('ref_sub_rute', ['id' => $id])->row_array();
    }

    public function createSubRute($data = null)
    {
        $this->db->insert('ref_sub_rute', $data);
        return $this->db->affected_rows();
    }

    public function updateSubRute($data = null, $id = null)
    {
        $this->db->update('ref_sub_rute', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteSubRute($id = null)
    {
        $this->db->delete('ref_sub_rute', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getRefSubRute($angkutan_id = null, $ref_id = null)
    {
        if ($angkutan_id == 1) {
            return $this->db->get_where('ref_pesawat', ['id' => $ref_id])->row_array();
        } else if ($angkutan_id == 4) {
            return $this->db->get_where('ref_kapal', ['id' => $ref_id])->row_array();
        } else if ($angkutan_id == 5) {
            return $this->db->get_where('ref_packing', ['id' => $ref_id])->row_array();
        } else {
            return $this->db->get_where('ref_darat', ['id' => $ref_id])->row_array();
        }
    }
}
