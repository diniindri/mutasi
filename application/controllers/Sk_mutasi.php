<?php

use Spipu\Html2Pdf\Html2Pdf;

class Sk_mutasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['profil'] = [
            'nip' => $this->session->userdata('nip'),
            'nama' => $this->session->userdata('nama'),
            'level' => $this->session->userdata('level')
        ];

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('sk_mutasi/index', $data);
        $this->load->view('template/footer');
    }
}
