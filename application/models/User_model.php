<?php

class User_model extends CI_Model
{
    public function signInUser($post)
    {
        $nip = $post['nip'];
        $password = $post['password'];
        $user = $this->db->get_where('users', ['nip' => $nip])->row_array();
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
