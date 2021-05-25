<?php

class Ref_jenis_model extends CI_Model
{
    public function getJenis()
    {
        return $this->db->get('ref_jenis')->result_array();
    }
}
