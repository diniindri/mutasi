<?php

class View_pegawai_payroll_model extends CI_Model
{
    public function getPegawaiPayroll($payroll_id = null, $limit = 0, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('pegawai_payroll');
        $this->db->where(['payroll_id' => $payroll_id]);
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    public function getDetailPegawaiPayroll($pegawai_id = null)
    {
        return $this->db->get_where('pegawai_payroll', ['pegawai_id' => $pegawai_id])->row_array();
    }

    public function findPegawaiPayroll($payroll_id = null, $nmpeg = null, $limit = 0, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('pegawai_payroll');
        $this->db->like('nmpeg', $nmpeg);
        $this->db->where('payroll_id', $payroll_id);
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    public function countPegawaiPayroll($payroll_id = null)
    {
        return $this->db->get_where('pegawai_payroll', ['payroll_id' => $payroll_id])->num_rows();
    }

    public function sumPegawaiPayroll($payroll_id = null)
    {
        return $this->db->query("SELECT SUM(nominal) AS nominal FROM pegawai_payroll WHERE payroll_id='$payroll_id' GROUP BY payroll_id")->row_array();
    }
}
