<?php

class View_biaya_pegawai_model extends CI_Model
{
    public function getBiayaPegawai($sk_id = null)
    {
        return $this->db->get_where('biaya_pegawai', ['sk_id' => $sk_id])->result_array();
    }

    public function getDetailBiayaPegawai($pegawai_id = null)
    {
        return $this->db->get_where('biaya_pegawai', ['pegawai_id' => $pegawai_id])->result_array();
    }

    public function getBiayaPegawaiPayroll($payroll_id = null)
    {
        return $this->db->query("SELECT b.* FROM pegawai_payroll a LEFT JOIN biaya_pegawai b ON a.pegawai_id=b.pegawai_id WHERE a.payroll_id='$payroll_id'")->result_array();
    }
}
