<?php

use Spipu\Html2Pdf\Html2Pdf;

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['sk'] = [
            [
                'nomor' => 'KEP-09/KN/2021',
                'uraian' => 'Mutasi Pelaksana Golongan II',
                'tanggal' => '02 April 2021'
            ],
            [
                'nomor' => 'KEP-10/KN/2021',
                'uraian' => 'Mutasi Pelaksana Golongan III',
                'tanggal' => '03 April 2021'
            ]
        ];

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
    }

    public function detail($sk_id = null)
    {
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/detail');
        $this->load->view('template/footer');
    }
}
