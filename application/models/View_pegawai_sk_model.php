<?php

class View_pegawai_sk_model extends CI_Model
{
    public function getPegawaiSk($nip = null)
    {
        return $this->db->get_where('pegawai_sk', ['nip' => $nip])->result_array();
    }

    public function getDetailPegawaiSk($pegawai_id = null)
    {
        return $this->db->get_where('pegawai_sk', ['pegawai_id' => $pegawai_id])->row_array();
    }
    public function getSk($sk_id = null, $nip = null)
    {
        return $this->db->get_where('pegawai_sk', ['sk_id' => $sk_id, 'nip' => $nip])->row_array();
    }
}
