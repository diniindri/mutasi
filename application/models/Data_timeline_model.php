<?php

class Data_timeline_model extends CI_Model
{
    public function getTimeline($pegawai_id = null)
    {
        return $this->db->query("SELECT a.nama, b.keterangan,b.tanggal FROM ref_proses a LEFT JOIN data_timeline b ON a.id=b.proses_id WHERE b.pegawai_id='$pegawai_id'")->result_array();
    }

    public function getDetailTimeline($id = null)
    {
        return $this->db->get_where('data_timeline', ['id' => $id])->row_array();
    }

    public function createTimeline($data = null)
    {
        $this->db->insert('data_timeline', $data);
        return $this->db->affected_rows();
    }

    public function updateTimeline($data = null, $id = null)
    {
        $this->db->update('data_timeline', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteTimeline($id = null)
    {
        $this->db->delete('data_timeline', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllTimeline()
    {
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('data_timeline')->result_array();
    }
}
