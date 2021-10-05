<?php

class Data_payroll_model extends CI_Model
{
    public function getPayroll($sk_id = 0, $limit = 0, $offset = 0)
    {
        $this->db->where('sk_id', $sk_id);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('data_payroll')->result_array();
    }

    public function getDetailPayroll($id = null)
    {
        return $this->db->get_where('data_payroll', ['id' => $id])->row_array();
    }

    public function findPayroll($sk_id = null, $uraian = null, $limit = 0, $offset = 0)
    {
        $this->db->like('uraian', $uraian);
        $this->db->where('sk_id', $sk_id);
        $this->db->limit($limit, $offset);
        return $this->db->get('data_payroll')->result_array();
    }

    public function countPayroll($sk_id = null)
    {
        return $this->db->get_where('data_payroll', ['sk_id' => $sk_id])->num_rows();
    }

    public function createPayroll($data = null)
    {
        $this->db->insert('data_payroll', $data);
        return $this->db->affected_rows();
    }

    public function updatePayroll($data = null, $id = null)
    {
        $this->db->update('data_payroll', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deletePayroll($id = null)
    {
        $this->db->delete('data_payroll', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllPayroll()
    {
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('data_payroll')->result_array();
    }
}
