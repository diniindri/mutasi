<?php

use Spipu\Html2Pdf\Html2Pdf;

class Referensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_level();
    }

    public function index()
    {

        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('referensi/index');
        $this->load->view('template/footer');
    }
}
