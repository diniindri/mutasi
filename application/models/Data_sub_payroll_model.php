<?php

class Data_sub_payroll_model extends CI_Model
{
    public function getSubPayroll($sk_id = 0, $limit = 0, $offset = 0)
    {
        $this->db->where('sk_id', $sk_id);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('data_sub_payroll')->result_array();
    }

    public function getDetailSubPayroll($id = null)
    {
        return $this->db->get_where('data_sub_payroll', ['id' => $id])->row_array();
    }

    public function findSubPayroll($uraian = null, $limit = 0, $offset = 0)
    {
        $this->db->like('uraian', $uraian);
        $this->db->limit($limit, $offset);
        return $this->db->get('data_sub_payroll')->result_array();
    }

    public function countSubPayroll()
    {
        return $this->db->get('data_sub_payroll')->num_rows();
    }

    public function createSubPayroll($data = null)
    {
        $this->db->insert('data_sub_payroll', $data);
        return $this->db->affected_rows();
    }

    public function updateSubPayroll($data = null, $id = null)
    {
        $this->db->update('data_sub_payroll', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteSubPayroll($id = null)
    {
        $this->db->delete('data_sub_payroll', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllSubPayroll()
    {
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('data_sub_payroll')->result_array();
    }
}
