<?php

class Data_biaya_model extends CI_Model
{
    public function getBiaya($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('data_biaya')->result_array();
    }

    public function getDetailBiaya($id = null)
    {
        return $this->db->get_where('data_biaya', ['id' => $id])->row_array();
    }

    public function findBiaya($nama = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('data_biaya', ['nama' => $nama])->result_array();
    }

    public function countBiaya()
    {
        return $this->db->get('data_biaya')->num_rows();
    }

    public function createBiaya($data = null)
    {
        $this->db->insert('data_biaya', $data);
        return $this->db->affected_rows();
    }

    public function updateBiaya($data = null, $id = null)
    {
        $this->db->update('data_biaya', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteBiaya($id = null)
    {
        $this->db->delete('data_biaya', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllBiaya()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('data_biaya')->result_array();
    }

    public function getSumBiaya($pegawai_id = null)
    {
        return $this->db->query("SELECT pegawai_id, SUM(jumlah) AS jumlah FROM data_biaya WHERE pegawai_id='$pegawai_id' GROUP BY pegawai_id")->row_array();
    }

    public function deleteBiayaPegawai($pegawai_id = null)
    {
        $this->db->delete('data_biaya', ['pegawai_id' => $pegawai_id]);
        return $this->db->affected_rows();
    }

    public function getRincianBiaya($pegawai_id = null)
    {
        return $this->db->query("SELECT a.id, b.nama AS nama_jenis, c.nama AS nama_angkutan, a.satuan, a.jarak, a.tarif, a.jumlah, a.uraian FROM data_biaya a LEFT JOIN ref_jenis b ON a.jenis_id=b.id LEFT JOIN ref_angkutan c ON a.angkutan_id=c.id WHERE a.pegawai_id='$pegawai_id'")->result_array();
    }

    public function getRincianBiayaPerJenis($pegawai_id = null, $jenis_id = null)
    {
        return $this->db->query("SELECT a.id, b.nama AS nama_jenis, c.nama AS nama_angkutan, a.satuan, a.jarak, a.tarif, a.jumlah, a.uraian FROM data_biaya a LEFT JOIN ref_jenis b ON a.jenis_id=b.id LEFT JOIN ref_angkutan c ON a.angkutan_id=c.id WHERE a.pegawai_id='$pegawai_id' AND a.jenis_id='$jenis_id'")->result_array();
    }
}
