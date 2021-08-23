<?php

class Data_upload_model extends CI_Model
{
    public function getUpload($sk_id = 0, $limit = 0, $offset = 0)
    {
        $this->db->where('sk_id', $sk_id);
        $this->db->order_by('nip', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('data_upload')->result_array();
    }

    public function getDetailUpload($id = null)
    {
        return $this->db->get_where('data_upload', ['id' => $id])->row_array();
    }

    public function findUpload($uraian = null, $limit = 0, $offset = 0)
    {
        $this->db->like('uraian', $uraian);
        $this->db->limit($limit, $offset);
        return $this->db->get('data_Upload')->result_array();
    }

    public function countUpload()
    {
        return $this->db->get('data_upload')->num_rows();
    }

    public function createUpload($data = null)
    {
        $this->db->insert('data_upload', $data);
        return $this->db->affected_rows();
    }

    public function updateUpload($data = null, $id = null)
    {
        $this->db->update('data_upload', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteUpload($id = null)
    {
        $this->db->delete('data_upload', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllUpload()
    {
        $this->db->order_by('nip', 'DESC');
        return $this->db->get('data_upload')->result_array();
    }
}
