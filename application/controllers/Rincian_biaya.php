<?php

use Spipu\Html2Pdf\Html2Pdf;

class Rincian_biaya extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
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
        $this->load->view('rincian_biaya/index', $data);
        $this->load->view('template/footer');
    }
}
