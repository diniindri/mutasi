<?php

class Ref_users_model extends CI_Model
{
    public function getUsers($limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get('ref_users')->result_array();
    }

    public function getDetailUsers($id = null)
    {
        return $this->db->get_where('ref_users', ['id' => $id])->row_array();
    }

    public function findUsers($nama = null, $limit = 0, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get_where('ref_users', ['nama' => $nama])->result_array();
    }

    public function countUsers()
    {
        return $this->db->get('ref_users')->num_rows();
    }

    public function createUsers($data = null)
    {
        $this->db->insert('ref_users', $data);
        return $this->db->affected_rows();
    }

    public function updateUsers($data = null, $id = null)
    {
        $this->db->update('ref_users', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteUsers($id = null)
    {
        $this->db->delete('ref_users', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllusers()
    {
        $this->db->order_by('kota_asal', 'ASC');
        return $this->db->get('ref_users')->result_array();
    }

    public function signInUser($post)
    {
        $nip = $post['nip'];
        $password = $post['password'];
        $user = $this->db->get_where('ref_users', ['nip' => $nip])->row_array();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'nip' => $user['nip'],
                    'nama' => $user['nama'],
                    'level' => $user['is_active']
                ];
                $this->session->set_userdata($data);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('pesan', 'Password Anda salah!');
                redirect('sign-in');
            }
        } else {
            $this->session->set_flashdata('pesan', 'NIP Anda belum terdaftar!');
            redirect('sign-in');
        }
    }
}
