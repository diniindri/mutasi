<?php

use Spipu\Html2Pdf\Html2Pdf;

class Dateline extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('View_pegawai_sk_model', 'view_pegawai_sk');
        $this->load->model('Data_jadwal_model', 'jadwal');
    }

    public function index($sk_id = null)
    {

        $nip = $this->session->userdata('nip');
        $data['sk'] = $this->view_pegawai_sk->getPegawaiSk($nip);

        if (!isset($sk_id) && $data['sk']) $sk_id = $data['sk'][0]['sk_id'];

        if (!isset($sk_id)) {
            $data['sk_id'] = null;
            $data['jadwal'] = [];
            $data['file'] = null;
        } else {
            $data['sk_id'] = $sk_id;
            $data['jadwal'] = $this->jadwal->getJadwal($sk_id);
            $data['file'] = $this->view_pegawai_sk->getSk($sk_id, $nip)['file'];
        }


        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('dateline/index', $data);
        $this->load->view('template/footer');
    }
}
