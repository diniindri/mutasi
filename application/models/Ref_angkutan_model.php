<?php

class Ref_angkutan_model extends CI_Model
{
    public function getAngkutan()
    {
        return $this->db->get('ref_angkutan')->result_array();
    }
}
